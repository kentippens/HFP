<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\FailedLoginAttempt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class LoginSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);
    }

    public function test_successful_login()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_failed_login_with_wrong_password()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
        
        // Check that failed attempt was recorded
        $this->assertDatabaseHas('failed_login_attempts', [
            'email' => 'test@example.com',
            'attempts' => 1
        ]);
    }

    public function test_captcha_required_after_three_failed_attempts()
    {
        // Simulate 3 failed attempts
        for ($i = 0; $i < 3; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ]);
        }

        // Next attempt should show captcha
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertSessionHas('show_captcha', true);
    }

    public function test_account_lockout_after_five_attempts()
    {
        // Create failed login attempt record
        $attempt = FailedLoginAttempt::create([
            'email' => 'test@example.com',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Test Browser',
            'attempts' => 4,
            'last_attempt_at' => now()
        ]);

        // Fifth attempt should trigger lockout
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors('email');
        
        // Verify lockout is set
        $attempt->refresh();
        $this->assertNotNull($attempt->locked_until);
        $this->assertTrue($attempt->isLocked());
    }

    public function test_rate_limiting_prevents_excessive_attempts()
    {
        // Make multiple rapid requests
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ]);
        }

        // Should be rate limited
        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Too many', session('errors')->get('email')[0]);
    }

    public function test_sql_injection_attempt_blocked()
    {
        $response = $this->post('/login', [
            'email' => "admin' OR '1'='1",
            'password' => "' OR '1'='1"
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Invalid request', session('errors')->get('email')[0]);
        
        // Verify IP was blocked
        $this->assertTrue(Cache::has('blocked_ip:127.0.0.1'));
    }

    public function test_xss_attempt_blocked()
    {
        $response = $this->post('/login', [
            'email' => '<script>alert("xss")</script>',
            'password' => 'password'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Invalid request', session('errors')->get('email')[0]);
    }

    public function test_blocked_ip_cannot_login()
    {
        // Block the IP
        Cache::put('blocked_ip:127.0.0.1', true, now()->addMinutes(60));

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Access temporarily restricted', session('errors')->get('email')[0]);
        $this->assertGuest();
    }

    public function test_session_regenerated_on_successful_login()
    {
        $oldSessionId = session()->getId();

        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $this->assertNotEquals($oldSessionId, session()->getId());
    }

    public function test_login_clears_failed_attempts_on_success()
    {
        // Create failed attempt record
        FailedLoginAttempt::create([
            'email' => 'test@example.com',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Test Browser',
            'attempts' => 3,
            'last_attempt_at' => now()
        ]);

        // Successful login
        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        // Failed attempts should be cleared
        $this->assertDatabaseMissing('failed_login_attempts', [
            'email' => 'test@example.com',
            'ip_address' => '127.0.0.1'
        ]);
    }

    public function test_bot_patterns_detected_and_blocked()
    {
        $response = $this->withHeaders([
            'User-Agent' => 'curl/7.64.1'
        ])->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Invalid request', session('errors')->get('email')[0]);
    }

    public function test_login_validates_input_length()
    {
        $response = $this->post('/login', [
            'email' => str_repeat('a', 300) . '@example.com',
            'password' => str_repeat('a', 300)
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_remember_me_functionality()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'remember' => true
        ]);

        $response->assertRedirect('/');
        $response->assertCookie(auth()->guard()->getRecallerName());
    }

    public function test_logout_invalidates_session()
    {
        $this->actingAs($this->user);
        $oldSessionId = session()->getId();

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
        $this->assertNotEquals($oldSessionId, session()->getId());
    }

    protected function tearDown(): void
    {
        // Clear any rate limiting
        RateLimiter::clear('test@example.com|127.0.0.1');
        
        // Clear any cached blocks
        Cache::forget('blocked_ip:127.0.0.1');
        
        parent::tearDown();
    }
}