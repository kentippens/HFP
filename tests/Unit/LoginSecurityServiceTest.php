<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\LoginSecurityService;
use App\Models\FailedLoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginSecurityServiceTest extends TestCase
{
    use RefreshDatabase;

    protected LoginSecurityService $service;
    protected Request $request;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);
        $this->request->server->set('REMOTE_ADDR', '192.168.1.1');
        
        $this->service = new LoginSecurityService($this->request);
    }

    public function test_detects_sql_injection_patterns()
    {
        $request = Request::create('/login', 'POST', [
            'email' => "admin' OR '1'='1",
            'password' => 'password'
        ]);
        
        $service = new LoginSecurityService($request);
        $issues = $service->checkSuspiciousActivity();
        
        $this->assertContains('sql_injection', $issues);
    }

    public function test_detects_script_injection_patterns()
    {
        $request = Request::create('/login', 'POST', [
            'email' => '<script>alert("xss")</script>',
            'password' => 'password'
        ]);
        
        $service = new LoginSecurityService($request);
        $issues = $service->checkSuspiciousActivity();
        
        $this->assertContains('script_injection', $issues);
    }

    public function test_detects_path_traversal_patterns()
    {
        $request = Request::create('/login', 'POST', [
            'email' => '../../../etc/passwd',
            'password' => 'password'
        ]);
        
        $service = new LoginSecurityService($request);
        $issues = $service->checkSuspiciousActivity();
        
        $this->assertContains('path_traversal', $issues);
    }

    public function test_blocks_and_checks_ip()
    {
        $this->assertFalse($this->service->isIPBlocked());
        
        $this->service->blockIP(60);
        
        $this->assertTrue($this->service->isIPBlocked());
    }

    public function test_counts_failed_attempts_for_ip()
    {
        FailedLoginAttempt::create([
            'email' => 'user1@example.com',
            'ip_address' => '192.168.1.1',
            'attempts' => 3,
            'created_at' => now()->subMinutes(30)
        ]);
        
        FailedLoginAttempt::create([
            'email' => 'user2@example.com',
            'ip_address' => '192.168.1.1',
            'attempts' => 2,
            'created_at' => now()->subMinutes(45)
        ]);
        
        $count = $this->service->getFailedAttemptsForIP();
        
        $this->assertEquals(5, $count);
    }

    public function test_counts_failed_attempts_for_email()
    {
        FailedLoginAttempt::create([
            'email' => 'test@example.com',
            'ip_address' => '192.168.1.1',
            'attempts' => 2,
            'created_at' => now()->subMinutes(30)
        ]);
        
        FailedLoginAttempt::create([
            'email' => 'test@example.com',
            'ip_address' => '192.168.1.2',
            'attempts' => 3,
            'created_at' => now()->subMinutes(45)
        ]);
        
        $count = $this->service->getFailedAttemptsForEmail('test@example.com');
        
        $this->assertEquals(5, $count);
    }

    public function test_determines_captcha_requirement()
    {
        // No attempts - no captcha
        $this->assertFalse($this->service->shouldRequireCaptcha('test@example.com'));
        
        // 3 attempts for email - require captcha
        FailedLoginAttempt::create([
            'email' => 'test@example.com',
            'ip_address' => '192.168.1.1',
            'attempts' => 3,
            'created_at' => now()->subMinutes(30)
        ]);
        
        $this->assertTrue($this->service->shouldRequireCaptcha('test@example.com'));
    }

    public function test_dynamic_rate_limiting_based_on_attempts()
    {
        // Default rate limit
        $this->assertEquals(10, $this->service->getRateLimitAttempts());
        
        // Create failed attempts
        FailedLoginAttempt::create([
            'email' => 'any@example.com',
            'ip_address' => '192.168.1.1',
            'attempts' => 15,
            'created_at' => now()->subMinutes(30)
        ]);
        
        // Should have stricter rate limit
        $this->assertEquals(1, $this->service->getRateLimitAttempts());
    }

    public function test_detects_bot_patterns()
    {
        $botRequests = [
            'curl/7.64.1',
            'python-requests/2.25.1',
            'Mozilla/5.0 (compatible; Googlebot/2.1)',
            'wget/1.20.3'
        ];
        
        foreach ($botRequests as $userAgent) {
            $request = Request::create('/login', 'POST');
            $request->headers->set('User-Agent', $userAgent);
            
            $service = new LoginSecurityService($request);
            $issues = $service->checkSuspiciousActivity();
            
            $this->assertContains('bot_detected', $issues, "Failed to detect bot: $userAgent");
        }
    }

    public function test_records_successful_login()
    {
        // Create failed attempts
        FailedLoginAttempt::create([
            'email' => 'test@example.com',
            'ip_address' => '192.168.1.1',
            'attempts' => 3,
            'created_at' => now()
        ]);
        
        $this->service->recordSuccessfulLogin('test@example.com');
        
        // Failed attempts should be cleared
        $this->assertDatabaseMissing('failed_login_attempts', [
            'email' => 'test@example.com',
            'ip_address' => '192.168.1.1'
        ]);
    }

    protected function tearDown(): void
    {
        Cache::flush();
        parent::tearDown();
    }
}