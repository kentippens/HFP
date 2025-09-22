<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthenticationExceptionHandler
{
    /**
     * Handle authentication exceptions with proper logging and sanitization
     */
    public static function handle(\Exception $e, Request $request): array
    {
        $errorData = [
            'message' => 'Authentication failed',
            'code' => 401,
            'redirect' => null,
            'inputs' => [],
            'errors' => []
        ];

        // Handle different types of authentication errors
        if ($e instanceof AuthenticationException) {
            $errorData['message'] = 'Please log in to continue.';
            $errorData['redirect'] = '/admin/login';
            
            Log::info('Unauthenticated access attempt', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        } elseif ($e instanceof ValidationException) {
            $errorData['message'] = 'Invalid input provided.';
            $errorData['code'] = 422;
            $errorData['errors'] = $e->errors();
            
            // Sanitize error messages to prevent information disclosure
            $errorData['errors'] = self::sanitizeErrors($errorData['errors']);
            
            // Preserve safe input values
            $safeInputs = ['email', 'name'];
            foreach ($safeInputs as $input) {
                if ($request->has($input)) {
                    $errorData['inputs'][$input] = $request->input($input);
                }
            }
        } else {
            // Generic error for other exceptions
            $errorData['message'] = 'An error occurred during authentication.';
            $errorData['code'] = 500;
            
            // Log the actual error for debugging
            Log::error('Authentication error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);
        }

        return $errorData;
    }

    /**
     * Sanitize error messages to prevent information disclosure
     */
    protected static function sanitizeErrors(array $errors): array
    {
        $sanitized = [];
        
        foreach ($errors as $field => $messages) {
            $sanitized[$field] = [];
            
            foreach ($messages as $message) {
                // Replace specific error messages with generic ones
                if (str_contains($message, 'does not exist')) {
                    $sanitized[$field][] = 'Invalid credentials provided.';
                } elseif (str_contains($message, 'SQL') || str_contains($message, 'database')) {
                    $sanitized[$field][] = 'A system error occurred. Please try again.';
                } elseif (str_contains($message, 'token') || str_contains($message, 'csrf')) {
                    $sanitized[$field][] = 'Your session has expired. Please refresh and try again.';
                } else {
                    $sanitized[$field][] = $message;
                }
            }
        }
        
        return $sanitized;
    }

    /**
     * Log suspicious authentication patterns
     */
    public static function logSuspiciousActivity(Request $request, string $reason): void
    {
        Log::channel('security')->warning('Suspicious authentication activity', [
            'reason' => $reason,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'inputs' => array_keys($request->all()),
            'timestamp' => now()->toIso8601String()
        ]);
    }
}