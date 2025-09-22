<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class CKEditorSecurity
{
    /**
     * Handle an incoming request for CKEditor uploads with additional security
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Rate limiting: 10 uploads per minute per user
        $key = 'ckeditor-upload:' . $request->user()?->id . ':' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 10)) {
            Log::warning('CKEditor upload rate limit exceeded', [
                'user_id' => $request->user()?->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'Too many upload attempts. Please wait before trying again.'
                ]
            ], 429);
        }

        // Verify the request is coming from a legitimate source
        if (!$this->isValidCKEditorRequest($request)) {
            Log::warning('Invalid CKEditor upload request', [
                'user_id' => $request->user()?->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer')
            ]);
            
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'Invalid request source.'
                ]
            ], 403);
        }

        // Track the attempt
        RateLimiter::hit($key, 60); // 1 minute decay

        $response = $next($request);

        // Log successful uploads
        if ($response->getStatusCode() === 200) {
            Log::info('CKEditor upload completed successfully', [
                'user_id' => $request->user()?->id,
                'ip' => $request->ip()
            ]);
        }

        return $response;
    }

    /**
     * Verify this is a legitimate CKEditor upload request
     */
    private function isValidCKEditorRequest(Request $request): bool
    {
        // Skip validation in testing environment
        if (app()->environment('testing')) {
            return true;
        }

        // Check if the request has the expected CKEditor headers/content
        $contentType = $request->header('content-type');
        
        // CKEditor uploads should be multipart/form-data
        if ($contentType && !str_contains($contentType, 'multipart/form-data')) {
            return false;
        }

        // Check if the file input name is 'upload' (CKEditor standard)
        if (!$request->hasFile('upload')) {
            return false;
        }

        // Verify referer is from our admin panel (optional, can be spoofed but adds a layer)
        $referer = $request->header('referer');
        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_HOST);
            $currentHost = $request->getHost();
            
            if ($refererHost && $refererHost !== $currentHost) {
                return false;
            }
        }

        return true;
    }
}