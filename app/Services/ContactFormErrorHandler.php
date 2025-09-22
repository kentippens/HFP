<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use App\Exceptions\DatabaseExceptionHandler;

class ContactFormErrorHandler
{
    /**
     * Handle contact form errors with appropriate logging and user messages
     */
    public static function handle(\Exception $e, array $context = []): array
    {
        $errorInfo = [
            'success' => false,
            'user_message' => 'An unexpected error occurred. Please try again.',
            'error_type' => 'general',
            'should_retry' => true,
            'log_level' => 'error'
        ];

        // Handle validation errors
        if ($e instanceof ValidationException) {
            $errorInfo['user_message'] = 'Please correct the errors in the form and try again.';
            $errorInfo['error_type'] = 'validation';
            $errorInfo['validation_errors'] = $e->errors();
            $errorInfo['log_level'] = 'info';
            $errorInfo['should_retry'] = false;
            
            Log::info('Contact form validation failed', array_merge([
                'errors' => $e->errors(),
                'input' => request()->except(['password', '_token'])
            ], $context));
            
            return $errorInfo;
        }

        // Handle database errors
        if ($e instanceof QueryException) {
            $dbError = DatabaseExceptionHandler::handle($e);
            
            // Check for specific database errors
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $errorInfo['user_message'] = 'It looks like you\'ve already submitted this form. Please wait for our response.';
                $errorInfo['error_type'] = 'duplicate';
                $errorInfo['should_retry'] = false;
                $errorInfo['log_level'] = 'warning';
            } elseif (str_contains($e->getMessage(), 'Data too long')) {
                $errorInfo['user_message'] = 'Some of your input is too long. Please shorten your message and try again.';
                $errorInfo['error_type'] = 'data_too_long';
                $errorInfo['should_retry'] = true;
                $errorInfo['log_level'] = 'warning';
            } elseif (str_contains($e->getMessage(), 'Connection refused')) {
                $errorInfo['user_message'] = 'We\'re experiencing technical difficulties. Please try again in a few moments.';
                $errorInfo['error_type'] = 'connection';
                $errorInfo['should_retry'] = true;
                $errorInfo['log_level'] = 'critical';
            } else {
                $errorInfo['user_message'] = $dbError['user_message'];
                $errorInfo['error_type'] = 'database';
            }
            
            Log::log($errorInfo['log_level'], 'Contact form database error', array_merge([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'sql_state' => $e->errorInfo[0] ?? null
            ], $context));
            
            return $errorInfo;
        }

        // Handle rate limiting
        if ($e instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException) {
            $errorInfo['user_message'] = 'Too many submission attempts. Please wait a few minutes and try again.';
            $errorInfo['error_type'] = 'rate_limit';
            $errorInfo['should_retry'] = true;
            $errorInfo['log_level'] = 'warning';
            
            Log::warning('Contact form rate limit exceeded', $context);
            
            return $errorInfo;
        }

        // Handle file upload errors
        if ($e instanceof \Illuminate\Http\Exceptions\PostTooLargeException) {
            $errorInfo['user_message'] = 'The form data is too large. Please reduce the size of any attachments.';
            $errorInfo['error_type'] = 'file_too_large';
            $errorInfo['should_retry'] = true;
            $errorInfo['log_level'] = 'warning';
            
            Log::warning('Contact form file too large', $context);
            
            return $errorInfo;
        }

        // Handle CSRF token errors
        if ($e instanceof \Illuminate\Session\TokenMismatchException) {
            $errorInfo['user_message'] = 'Your session has expired. Please refresh the page and try again.';
            $errorInfo['error_type'] = 'csrf_token';
            $errorInfo['should_retry'] = true;
            $errorInfo['log_level'] = 'info';
            
            Log::info('Contact form CSRF token mismatch', $context);
            
            return $errorInfo;
        }

        // Log all other errors
        Log::error('Unexpected contact form error', array_merge([
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ], $context));

        return $errorInfo;
    }

    /**
     * Create a context array for logging
     */
    public static function createContext(\Illuminate\Http\Request $request): array
    {
        return [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'form_type' => self::detectFormType($request),
            'timestamp' => now()->toIso8601String()
        ];
    }

    /**
     * Detect the type of form being submitted
     */
    public static function detectFormType(\Illuminate\Http\Request $request): string
    {
        if ($request->has('type')) {
            if ($request->type === 'appointment') return 'homepage';
            if ($request->type === 'newsletter') return 'newsletter';
        }
        
        if ($request->has('fname')) return 'service';
        if ($request->has('investment_interest')) return 'investor';
        if ($request->routeIs('contact.store')) return 'contact';
        
        return 'unknown';
    }

    /**
     * Sanitize form data for logging (remove sensitive info)
     */
    public static function sanitizeForLogging(array $data): array
    {
        $sensitive = ['password', '_token', 'credit_card', 'ssn', 'cvv'];
        
        foreach ($sensitive as $field) {
            if (isset($data[$field])) {
                $data[$field] = '[REDACTED]';
            }
        }
        
        // Partially mask email and phone for privacy
        if (isset($data['email'])) {
            $parts = explode('@', $data['email']);
            if (count($parts) === 2) {
                $data['email'] = substr($parts[0], 0, 2) . '***@' . $parts[1];
            }
        }
        
        if (isset($data['phone'])) {
            $data['phone'] = substr($data['phone'], 0, 3) . '-***-' . substr($data['phone'], -4);
        }
        
        return $data;
    }
}