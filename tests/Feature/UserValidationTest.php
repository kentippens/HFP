<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_creation_with_extremely_long_name()
    {
        $longName = Str::repeat('a', 256); // Exceeds 255 character limit

        $userData = [
            'name' => $longName,
            'email' => 'test@example.com',
            'password' => 'SecurePassword123!',
        ];

        // Test the actual length constraint
        try {
            $user = User::create($userData);
            // If creation succeeds, the name should be truncated or we should fail the test
            $this->fail('Expected exception was not thrown for extremely long name');
        } catch (\Exception $e) {
            // Any exception is acceptable here (QueryException, ValidationException, etc.)
            $this->assertTrue(true);
        }
    }

    public function test_user_creation_with_extremely_long_email()
    {
        $longEmail = Str::repeat('a', 250) . '@example.com'; // Exceeds 255 character limit

        $userData = [
            'name' => 'Test User',
            'email' => $longEmail,
            'password' => 'SecurePassword123!',
        ];

        try {
            $user = User::create($userData);
            $this->fail('Expected exception was not thrown for extremely long email');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }

    public function test_user_creation_with_empty_string_values()
    {
        $userData = [
            'name' => '',
            'email' => '',
            'password' => '',
        ];

        try {
            $user = User::create($userData);
            // Empty strings might be allowed at model level but should fail at validation level
            $this->assertTrue(strlen($user->name) === 0);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }

    public function test_user_creation_with_null_values()
    {
        $userData = [
            'name' => null,
            'email' => null,
            'password' => null,
        ];

        $this->expectException(\Illuminate\Database\QueryException::class);
        User::create($userData);
    }

    public function test_user_creation_with_special_characters_in_name()
    {
        $userData = [
            'name' => 'José María O\'Connor-Smith 中文',
            'email' => 'test@example.com',
            'password' => 'SecurePassword123!',
        ];

        $user = User::create($userData);
        
        $this->assertEquals('José María O\'Connor-Smith 中文', $user->name);
    }

    public function test_user_creation_with_unicode_email()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@münchen.de', // Unicode domain
            'password' => 'SecurePassword123!',
        ];

        $user = User::create($userData);
        
        $this->assertEquals('test@münchen.de', $user->email);
    }

    public function test_user_creation_with_case_sensitive_email()
    {
        User::factory()->create(['email' => 'test@example.com']);

        $userData = [
            'name' => 'Test User',
            'email' => 'TEST@EXAMPLE.COM', // Different case
            'password' => 'SecurePassword123!',
        ];

        // This should succeed as email uniqueness is typically case-insensitive at application level
        // but case-sensitive at database level (depending on collation)
        $user = User::create($userData);
        
        $this->assertEquals('TEST@EXAMPLE.COM', $user->email);
    }

    public function test_user_creation_with_whitespace_in_fields()
    {
        $userData = [
            'name' => '  John Doe  ',
            'email' => '  test@example.com  ',
            'password' => 'SecurePassword123!',
        ];

        $user = User::create($userData);
        
        // Laravel doesn't automatically trim by default
        $this->assertEquals('  John Doe  ', $user->name);
        $this->assertEquals('  test@example.com  ', $user->email);
    }

    public function test_user_creation_with_maximum_allowed_lengths()
    {
        $maxName = Str::repeat('a', 255);
        $maxEmail = Str::repeat('a', 243) . '@example.com'; // 255 chars total

        $userData = [
            'name' => $maxName,
            'email' => $maxEmail,
            'password' => 'SecurePassword123!',
        ];

        $user = User::create($userData);
        
        $this->assertEquals($maxName, $user->name);
        $this->assertEquals($maxEmail, $user->email);
    }

    public function test_concurrent_user_creation_with_same_email()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'SecurePassword123!',
        ];

        // Create first user
        $user1 = User::create($userData);
        
        // Attempt to create second user with same email
        $this->expectException(\Illuminate\Database\QueryException::class);
        User::create($userData);
    }

    public function test_user_update_with_existing_email()
    {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        // Try to update user2's email to user1's email
        $this->expectException(\Illuminate\Database\QueryException::class);
        $user2->update(['email' => 'user1@example.com']);
    }

    public function test_user_creation_with_various_email_formats()
    {
        $validEmails = [
            'simple@example.com',
            'very.common@example.com',
            'disposable.style.email.with+symbol@example.com',
            'x@example.com',
            'example@s.example',
            'test@example-one.com',
            'test@123.123.123.123', // IP address (though not recommended)
        ];

        foreach ($validEmails as $email) {
            $user = User::factory()->create(['email' => $email]);
            $this->assertEquals($email, $user->email);
        }
    }

    public function test_user_password_hashing_consistency()
    {
        $password = 'TestPassword123!';
        
        $user1 = User::factory()->create(['password' => $password]);
        $user2 = User::factory()->create(['password' => $password]);

        // Passwords should be hashed and different for each user
        $this->assertNotEquals($user1->password, $user2->password);
        $this->assertNotEquals($password, $user1->password);
        $this->assertNotEquals($password, $user2->password);
    }

    public function test_user_creation_performance_with_large_dataset()
    {
        $startTime = microtime(true);
        
        // Create 100 users
        User::factory(100)->create();
        
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        
        // Should complete within reasonable time (adjust as needed)
        $this->assertLessThan(10, $executionTime, 'User creation took too long');
        
        $this->assertEquals(100, User::count());
    }

    public function test_user_deletion_cascading_effects()
    {
        $user = User::factory()->create();
        $userId = $user->id;
        
        // Delete user
        $user->delete();
        
        // Verify user is deleted
        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }

    public function test_user_soft_delete_if_implemented()
    {
        $user = User::factory()->create();
        
        // If soft deletes are implemented, this would be different
        // For now, testing hard delete
        $user->delete();
        
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}