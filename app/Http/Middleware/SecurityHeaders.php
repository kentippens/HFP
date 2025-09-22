<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Content Security Policy
        $csp = $this->getContentSecurityPolicy();
        $response->headers->set('Content-Security-Policy', $csp);

        // XSS Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Frame Options - Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Content Type Options - Prevent MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy (formerly Feature Policy)
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Strict Transport Security (only for HTTPS)
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }

    /**
     * Get Content Security Policy directives
     */
    protected function getContentSecurityPolicy(): string
    {
        $policies = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://www.googletagmanager.com https://www.google-analytics.com https://maps.googleapis.com https://www.clarity.ms https://cdn.ckeditor.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com",
            "img-src 'self' data: https: http: blob:",
            "font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com",
            "connect-src 'self' https://www.google-analytics.com https://analytics.google.com https://www.clarity.ms",
            "media-src 'self' https: blob:",
            "object-src 'none'",
            "child-src 'self' https://www.youtube.com https://player.vimeo.com https://maps.google.com https://www.google.com",
            "frame-src 'self' https://www.youtube.com https://player.vimeo.com https://maps.google.com https://www.google.com",
            "frame-ancestors 'self'",
            "form-action 'self'",
            "base-uri 'self'",
            "manifest-src 'self'",
            "worker-src 'self' blob:",
        ];

        // Add nonce for inline scripts if needed (optional, more secure)
        // $nonce = base64_encode(random_bytes(16));
        // session(['csp_nonce' => $nonce]);
        // Update script-src to include 'nonce-'.$nonce instead of 'unsafe-inline'

        return implode('; ', $policies);
    }
}