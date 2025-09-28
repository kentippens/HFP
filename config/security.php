<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Security Settings
    |--------------------------------------------------------------------------
    |
    | These settings control various security aspects of the authentication
    | system including password requirements, session management, and
    | login attempt monitoring.
    |
    */

    'auth' => [
        // Password requirements
        'password' => [
            'min_length' => env('PASSWORD_MIN_LENGTH', 12),
            'require_uppercase' => env('PASSWORD_REQUIRE_UPPERCASE', true),
            'require_lowercase' => env('PASSWORD_REQUIRE_LOWERCASE', true),
            'require_numbers' => env('PASSWORD_REQUIRE_NUMBERS', true),
            'require_symbols' => env('PASSWORD_REQUIRE_SYMBOLS', true),
            'compromised_check' => env('PASSWORD_COMPROMISED_CHECK', true),
            'history_count' => env('PASSWORD_HISTORY_COUNT', 5),
            'max_age_days' => env('PASSWORD_MAX_AGE_DAYS', 90),
        ],

        // Session security
        'session' => [
            'lifetime_minutes' => env('ADMIN_SESSION_LIFETIME', 120),
            'timeout_on_inactivity' => env('SESSION_TIMEOUT_ON_INACTIVITY', true),
            'inactivity_timeout_minutes' => env('SESSION_INACTIVITY_TIMEOUT', 30),
            'single_session_per_user' => env('SINGLE_SESSION_PER_USER', true),
            'regenerate_on_login' => true,
        ],

        // Login security
        'login' => [
            'max_attempts' => env('LOGIN_MAX_ATTEMPTS', 5),
            'lockout_duration_minutes' => env('LOGIN_LOCKOUT_DURATION', 15),
            'show_generic_error' => env('LOGIN_SHOW_GENERIC_ERROR', true),
            'log_failed_attempts' => true,
            'notify_on_suspicious_activity' => env('NOTIFY_SUSPICIOUS_ACTIVITY', true),
        ],

        // Two-factor authentication
        '2fa' => [
            'enabled' => env('2FA_ENABLED', false),
            'required_for_admin' => env('2FA_REQUIRED_FOR_ADMIN', true),
            'recovery_codes_count' => 8,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Headers
    |--------------------------------------------------------------------------
    |
    | These headers help protect against various attacks including XSS,
    | clickjacking, and other code injection attacks.
    |
    */

    'headers' => [
        'enabled' => env('SECURITY_HEADERS_ENABLED', true),

        // Basic Security Headers
        'x_xss_protection' => true,
        'x_frame_options' => env('SECURITY_FRAME_OPTIONS', 'SAMEORIGIN'),
        'x_content_type_options' => true,
        'referrer_policy' => env('SECURITY_REFERRER_POLICY', 'strict-origin-when-cross-origin'),
        'remove_x_powered_by' => true,
        'remove_server' => true,

        // Cross-Origin Policies
        'cross_origin_embedder_policy' => env('SECURITY_COEP', 'unsafe-none'),
        'cross_origin_opener_policy' => env('SECURITY_COOP', 'same-origin'),
        'cross_origin_resource_policy' => env('SECURITY_CORP', 'same-origin'),

        // Strict Transport Security (HSTS)
        'strict_transport_security' => [
            'enabled' => env('SECURITY_HSTS_ENABLED', true),
            'max_age' => env('SECURITY_HSTS_MAX_AGE', 31536000),
            'include_subdomains' => env('SECURITY_HSTS_SUBDOMAINS', true),
            'preload' => env('SECURITY_HSTS_PRELOAD', false),
        ],

        // Certificate Transparency
        'expect_ct' => [
            'enabled' => env('SECURITY_EXPECT_CT_ENABLED', false),
            'max_age' => env('SECURITY_EXPECT_CT_MAX_AGE', 86400),
            'enforce' => env('SECURITY_EXPECT_CT_ENFORCE', false),
            'report_uri' => env('SECURITY_EXPECT_CT_REPORT_URI'),
        ],

        // Permissions Policy
        'permissions_policy' => [
            'accelerometer' => '()',
            'camera' => '()',
            'geolocation' => '()',
            'gyroscope' => '()',
            'magnetometer' => '()',
            'microphone' => '()',
            'payment' => '()',
            'usb' => '()',
            'interest-cohort' => '()',
            'fullscreen' => '(self)',
            'picture-in-picture' => '(self)',
        ],

        // Content Security Policy (CSP)
        'content_security_policy' => [
            'enabled' => env('SECURITY_CSP_ENABLED', true),
            'report_only' => env('SECURITY_CSP_REPORT_ONLY', false),
            'use_nonce' => env('SECURITY_CSP_USE_NONCE', false),
            'report_uri' => env('SECURITY_CSP_REPORT_URI'),
            'report_to' => env('SECURITY_CSP_REPORT_TO'),

            'directives' => [
                'default-src' => "'self'",
                'script-src' => "'self' 'unsafe-inline' 'unsafe-eval' " .
                    "https://cdn.jsdelivr.net " .
                    "https://cdnjs.cloudflare.com " .
                    "https://www.googletagmanager.com " .
                    "https://www.google-analytics.com " .
                    "https://maps.googleapis.com " .
                    "https://www.clarity.ms " .
                    "https://cdn.ckeditor.com " .
                    "https://www.gstatic.com",
                'style-src' => "'self' 'unsafe-inline' " .
                    "https://cdn.jsdelivr.net " .
                    "https://cdnjs.cloudflare.com " .
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
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IP Security
    |--------------------------------------------------------------------------
    |
    | Control access based on IP addresses for additional security layers.
    |
    */

    'ip' => [
        'whitelist_enabled' => env('IP_WHITELIST_ENABLED', false),
        'whitelist' => env('IP_WHITELIST', ''), // Comma-separated IPs
        'blacklist_enabled' => env('IP_BLACKLIST_ENABLED', true),
        'auto_block_after_attempts' => env('IP_AUTO_BLOCK_ATTEMPTS', 20),
        'block_duration_hours' => env('IP_BLOCK_DURATION_HOURS', 24),
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging and Monitoring
    |--------------------------------------------------------------------------
    |
    | Configure security event logging and monitoring.
    |
    */

    'logging' => [
        'log_successful_logins' => env('LOG_SUCCESSFUL_LOGINS', true),
        'log_failed_logins' => env('LOG_FAILED_LOGINS', true),
        'log_suspicious_activity' => env('LOG_SUSPICIOUS_ACTIVITY', true),
        'log_admin_actions' => env('LOG_ADMIN_ACTIONS', true),
        'alert_on_multiple_failures' => env('ALERT_ON_MULTIPLE_FAILURES', true),
        'failure_threshold_for_alert' => env('FAILURE_ALERT_THRESHOLD', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTPS Enforcement
    |--------------------------------------------------------------------------
    |
    | Force all traffic through HTTPS in production.
    |
    */

    'https' => [
        'force_https' => env('FORCE_HTTPS', env('APP_ENV') === 'production'),
        'redirect_to_https' => env('REDIRECT_TO_HTTPS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for various endpoints.
    |
    */

    'rate_limits' => [
        'login' => [
            'attempts' => env('LOGIN_RATE_LIMIT_ATTEMPTS', 5),
            'decay_minutes' => env('LOGIN_RATE_LIMIT_DECAY', 1),
        ],
        'password_reset' => [
            'attempts' => env('PASSWORD_RESET_RATE_LIMIT', 3),
            'decay_minutes' => env('PASSWORD_RESET_DECAY', 60),
        ],
        'api' => [
            'attempts' => env('API_RATE_LIMIT', 60),
            'decay_minutes' => env('API_RATE_DECAY', 1),
        ],
    ],
];