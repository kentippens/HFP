<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SecurityHeaders
{
    /**
     * Security headers configuration
     */
    protected array $config;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->config = config('security.headers', $this->getDefaultConfig());
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Skip if disabled or in debug mode (optional)
        if ($this->config['enabled'] === false) {
            return $response;
        }

        // Content Security Policy (CSP)
        $this->setContentSecurityPolicy($request, $response);

        // XSS Protection (deprecated but still useful for older browsers)
        if ($this->config['x_xss_protection']) {
            $response->headers->set('X-XSS-Protection', '1; mode=block');
        }

        // Frame Options - Prevent clickjacking
        if ($this->config['x_frame_options']) {
            $response->headers->set('X-Frame-Options', $this->config['x_frame_options']);
        }

        // Content Type Options - Prevent MIME sniffing
        if ($this->config['x_content_type_options']) {
            $response->headers->set('X-Content-Type-Options', 'nosniff');
        }

        // Referrer Policy
        if ($this->config['referrer_policy']) {
            $response->headers->set('Referrer-Policy', $this->config['referrer_policy']);
        }

        // Permissions Policy (formerly Feature Policy)
        if ($this->config['permissions_policy']) {
            $response->headers->set('Permissions-Policy', $this->buildPermissionsPolicy());
        }

        // Strict Transport Security (HSTS) - only for HTTPS
        if ($request->secure() && $this->config['strict_transport_security']['enabled']) {
            $hsts = 'max-age=' . $this->config['strict_transport_security']['max_age'];

            if ($this->config['strict_transport_security']['include_subdomains']) {
                $hsts .= '; includeSubDomains';
            }

            if ($this->config['strict_transport_security']['preload']) {
                $hsts .= '; preload';
            }

            $response->headers->set('Strict-Transport-Security', $hsts);
        }

        // Additional security headers

        // Expect-CT (Certificate Transparency)
        if ($request->secure() && $this->config['expect_ct']['enabled']) {
            $expectCt = 'max-age=' . $this->config['expect_ct']['max_age'];
            if ($this->config['expect_ct']['enforce']) {
                $expectCt .= ', enforce';
            }
            if ($this->config['expect_ct']['report_uri']) {
                $expectCt .= ', report-uri="' . $this->config['expect_ct']['report_uri'] . '"';
            }
            $response->headers->set('Expect-CT', $expectCt);
        }

        // Cross-Origin Headers
        if ($this->config['cross_origin_embedder_policy']) {
            $response->headers->set('Cross-Origin-Embedder-Policy', $this->config['cross_origin_embedder_policy']);
        }

        if ($this->config['cross_origin_opener_policy']) {
            $response->headers->set('Cross-Origin-Opener-Policy', $this->config['cross_origin_opener_policy']);
        }

        if ($this->config['cross_origin_resource_policy']) {
            $response->headers->set('Cross-Origin-Resource-Policy', $this->config['cross_origin_resource_policy']);
        }

        // Remove potentially sensitive headers
        if ($this->config['remove_x_powered_by']) {
            $response->headers->remove('X-Powered-By');
            header_remove('X-Powered-By');
        }

        if ($this->config['remove_server']) {
            $response->headers->remove('Server');
        }

        return $response;
    }

    /**
     * Set Content Security Policy header
     */
    protected function setContentSecurityPolicy(Request $request, $response): void
    {
        if (!$this->config['content_security_policy']['enabled']) {
            return;
        }

        $csp = $this->buildContentSecurityPolicy($request);

        if ($this->config['content_security_policy']['report_only']) {
            $response->headers->set('Content-Security-Policy-Report-Only', $csp);
        } else {
            $response->headers->set('Content-Security-Policy', $csp);
        }
    }

    /**
     * Build Content Security Policy directives
     */
    protected function buildContentSecurityPolicy(Request $request): string
    {
        $directives = $this->config['content_security_policy']['directives'];
        $policies = [];

        // Add nonce for inline scripts/styles if configured
        if ($this->config['content_security_policy']['use_nonce']) {
            $nonce = $this->generateNonce();

            // Store nonce for use in views
            session(['csp_nonce' => $nonce]);
            view()->share('cspNonce', $nonce);

            // Update directives to include nonce
            if (isset($directives['script-src'])) {
                $directives['script-src'] = str_replace("'unsafe-inline'", "'nonce-{$nonce}'", $directives['script-src']);
            }
            if (isset($directives['style-src'])) {
                $directives['style-src'] = str_replace("'unsafe-inline'", "'nonce-{$nonce}'", $directives['style-src']);
            }
        }

        foreach ($directives as $directive => $value) {
            if ($value !== null && $value !== '') {
                $policies[] = "{$directive} {$value}";
            }
        }

        // Add report-uri if configured
        if ($this->config['content_security_policy']['report_uri']) {
            $policies[] = "report-uri " . $this->config['content_security_policy']['report_uri'];
        }

        // Add report-to if configured (newer standard)
        if ($this->config['content_security_policy']['report_to']) {
            $policies[] = "report-to " . $this->config['content_security_policy']['report_to'];
        }

        return implode('; ', $policies);
    }

    /**
     * Build Permissions Policy
     */
    protected function buildPermissionsPolicy(): string
    {
        $policies = [];
        foreach ($this->config['permissions_policy'] as $feature => $value) {
            if (is_array($value)) {
                $policies[] = "{$feature}=(" . implode(' ', $value) . ")";
            } else {
                $policies[] = "{$feature}={$value}";
            }
        }
        return implode(', ', $policies);
    }

    /**
     * Generate a cryptographically secure nonce
     */
    protected function generateNonce(): string
    {
        return base64_encode(Str::random(32));
    }

    /**
     * Get default configuration
     */
    protected function getDefaultConfig(): array
    {
        return [
            'enabled' => true,
            'x_xss_protection' => true,
            'x_frame_options' => 'SAMEORIGIN', // or 'DENY' for stricter
            'x_content_type_options' => true,
            'referrer_policy' => 'strict-origin-when-cross-origin',
            'remove_x_powered_by' => true,
            'remove_server' => true,
            'cross_origin_embedder_policy' => 'unsafe-none', // or 'require-corp' for stricter
            'cross_origin_opener_policy' => 'same-origin', // or 'same-origin-allow-popups'
            'cross_origin_resource_policy' => 'same-origin', // or 'cross-origin'

            'strict_transport_security' => [
                'enabled' => true,
                'max_age' => 31536000, // 1 year
                'include_subdomains' => true,
                'preload' => false, // Enable after testing
            ],

            'expect_ct' => [
                'enabled' => false, // Enable if using Certificate Transparency
                'max_age' => 86400,
                'enforce' => false,
                'report_uri' => null,
            ],

            'permissions_policy' => [
                'accelerometer' => '()',
                'camera' => '()',
                'geolocation' => '()',
                'gyroscope' => '()',
                'magnetometer' => '()',
                'microphone' => '()',
                'payment' => '()',
                'usb' => '()',
                'interest-cohort' => '()', // FLoC opt-out
                'fullscreen' => '(self)',
                'picture-in-picture' => '(self)',
            ],

            'content_security_policy' => [
                'enabled' => true,
                'report_only' => false, // Set to true for testing
                'use_nonce' => false, // Enable for better inline script security
                'report_uri' => null, // e.g., '/csp-report'
                'report_to' => null, // e.g., 'csp-endpoint'

                'directives' => [
                    'default-src' => "'self'",
                    'script-src' => "'self' 'unsafe-inline' 'unsafe-eval' " .
                        "https://cdn.jsdelivr.net " .
                        "https://cdnjs.cloudflare.com " .
                        "https://unpkg.com " .
                        "https://www.googletagmanager.com " .
                        "https://www.google-analytics.com " .
                        "https://maps.googleapis.com " .
                        "https://www.clarity.ms " .
                        "https://cdn.ckeditor.com " .
                        "https://www.gstatic.com",
                    'style-src' => "'self' 'unsafe-inline' " .
                        "https://cdn.jsdelivr.net " .
                        "https://cdnjs.cloudflare.com " .
                        "https://unpkg.com " .
                        "https://fonts.googleapis.com",
                    'img-src' => "'self' data: https: http: blob:",
                    'font-src' => "'self' data: " .
                        "https://fonts.gstatic.com " .
                        "https://cdnjs.cloudflare.com " .
                        "https://cdn.jsdelivr.net",
                    'connect-src' => "'self' " .
                        "https://www.google-analytics.com " .
                        "https://analytics.google.com " .
                        "https://www.clarity.ms " .
                        "https://api.github.com " .
                        "wss://livewire.test " .
                        "ws://localhost:*",
                    'media-src' => "'self' https: blob:",
                    'object-src' => "'none'",
                    'child-src' => "'self' " .
                        "https://www.youtube.com " .
                        "https://www.youtube-nocookie.com " .
                        "https://player.vimeo.com " .
                        "https://maps.google.com " .
                        "https://www.google.com",
                    'frame-src' => "'self' " .
                        "https://www.youtube.com " .
                        "https://www.youtube-nocookie.com " .
                        "https://player.vimeo.com " .
                        "https://maps.google.com " .
                        "https://www.google.com",
                    'frame-ancestors' => "'self'",
                    'form-action' => "'self'",
                    'base-uri' => "'self'",
                    'manifest-src' => "'self'",
                    'worker-src' => "'self' blob:",
                    'prefetch-src' => "'self'",
                    'navigate-to' => "'self'",
                ],
            ],
        ];
    }
}