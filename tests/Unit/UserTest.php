<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_valid_data()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('SecurePassword123!'),
        ];

        $user = User::create($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertTrue(Hash::check('SecurePassword123!', $user->password));
    }

    public function test_user_password_is_automatically_hashed()
    {
        $user = User::factory()->create(['password' => 'plaintext']);

        $this->assertNotEquals('plaintext', $user->password);
        $this->assertTrue(Hash::check('plaintext', $user->password));
    }

    public function test_user_email_must_be_unique()
    {
        User::factory()->create(['email' => 'test@example.com']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        User::factory()->create(['email' => 'test@example.com']);
    }

    public function test_user_name_is_fillable()
    {
        $user = new User();
        $this->assertContains('name', $user->getFillable());
    }

    public function test_user_email_is_fillable()
    {
        $user = new User();
        $this->assertContains('email', $user->getFillable());
    }

    public function test_user_password_is_fillable()
    {
        $user = new User();
        $this->assertContains('password', $user->getFillable());
    }

    public function test_user_password_is_hidden()
    {
        $user = User::factory()->create();
        $array = $user->toArray();
        
        $this->assertArrayNotHasKey('password', $array);
    }

    public function test_user_remember_token_is_hidden()
    {
        $user = User::factory()->create();
        $array = $user->toArray();
        
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    public function test_email_verified_at_is_cast_to_datetime()
    {
        $user = User::factory()->create(['email_verified_at' => '2024-01-01 12:00:00']);
        
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
    }

    public function test_user_has_correct_attributes()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertNotNull($user->email_verified_at);
        $this->assertNotNull($user->created_at);
        $this->assertNotNull($user->updated_at);
    }

    public function test_user_factory_creates_valid_user()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotEmpty($user->name);
        $this->assertNotEmpty($user->email);
        $this->assertNotEmpty($user->password);
        $this->assertTrue(filter_var($user->email, FILTER_VALIDATE_EMAIL) !== false);
    }

    public function test_user_factory_can_create_verified_user()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->assertNotNull($user->email_verified_at);
    }

    public function test_user_factory_can_create_unverified_user()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $this->assertNull($user->email_verified_at);
    }

    public function test_user_can_update_name()
    {
        $user = User::factory()->create(['name' => 'Original Name']);
        
        $user->update(['name' => 'Updated Name']);
        
        $this->assertEquals('Updated Name', $user->fresh()->name);
    }

    public function test_user_can_update_email()
    {
        $user = User::factory()->create(['email' => 'original@example.com']);
        
        $user->update(['email' => 'updated@example.com']);
        
        $this->assertEquals('updated@example.com', $user->fresh()->email);
    }

    public function test_user_can_update_password()
    {
        $user = User::factory()->create();
        $originalPassword = $user->password;
        
        $user->update(['password' => Hash::make('NewPassword123!')]);
        
        $this->assertNotEquals($originalPassword, $user->fresh()->password);
        $this->assertTrue(Hash::check('NewPassword123!', $user->fresh()->password));
    }

    public function test_user_timestamps_are_updated()
    {
        $user = User::factory()->create();
        $originalUpdatedAt = $user->updated_at;
        
        sleep(1);
        $user->update(['name' => 'Updated Name']);
        
        $this->assertNotEquals($originalUpdatedAt, $user->fresh()->updated_at);
    }
}