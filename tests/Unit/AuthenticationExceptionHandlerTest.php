<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Exceptions\AuthenticationExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthenticationExceptionHandlerTest extends TestCase
{
    protected Request $request;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);
        $this->request->setLaravelSession(session());
    }

    public function test_handles_authentication_exception()
    {
        $exception = new AuthenticationException();
        
        $result = AuthenticationExceptionHandler::handle($exception, $this->request);
        
        $this->assertEquals('Please log in to continue.', $result['message']);
        $this->assertEquals(401, $result['code']);
        $this->assertEquals(route('login'), $result['redirect']);
    }

    public function test_handles_validation_exception()
    {
        $validator = Validator::make([], ['email' => 'required']);
        $exception = new ValidationException($validator);
        
        $result = AuthenticationExceptionHandler::handle($exception, $this->request);
        
        $this->assertEquals('Invalid input provided.', $result['message']);
        $this->assertEquals(422, $result['code']);
        $this->assertArrayHasKey('email', $result['errors']);
    }

    public function test_sanitizes_sensitive_error_messages()
    {
        $validator = Validator::make(
            ['email' => 'user@example.com'],
            ['email' => 'exists:users,email']
        );
        $validator->fails();
        
        $exception = new ValidationException($validator);
        $result = AuthenticationExceptionHandler::handle($exception, $this->request);
        
        // Should not expose that user doesn't exist
        foreach ($result['errors']['email'] as $error) {
            $this->assertStringNotContainsString('does not exist', $error);
        }
    }

    public function test_handles_generic_exceptions()
    {
        $exception = new \Exception('Some internal error');
        
        $result = AuthenticationExceptionHandler::handle($exception, $this->request);
        
        $this->assertEquals('An error occurred during authentication.', $result['message']);
        $this->assertEquals(500, $result['code']);
    }

    public function test_preserves_safe_input_values()
    {
        $request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'secret',
            'credit_card' => '1234567890'
        ]);
        
        $validator = Validator::make([], ['email' => 'required']);
        $exception = new ValidationException($validator);
        
        $result = AuthenticationExceptionHandler::handle($exception, $request);
        
        // Email should be preserved
        $this->assertArrayHasKey('email', $result['inputs']);
        $this->assertEquals('test@example.com', $result['inputs']['email']);
        
        // Sensitive data should not be preserved
        $this->assertArrayNotHasKey('password', $result['inputs']);
        $this->assertArrayNotHasKey('credit_card', $result['inputs']);
    }

    public function test_logs_suspicious_activity()
    {
        $this->expectsLogChannel('security');
        
        AuthenticationExceptionHandler::logSuspiciousActivity($this->request, 'Test reason');
        
        $this->assertTrue(true); // If no exception, test passes
    }
}