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
        'strict_transport_security' => env('HSTS_ENABLED', true),
        'hsts_max_age' => env('HSTS_MAX_AGE', 31536000), // 1 year
        'hsts_include_subdomains' => env('HSTS_INCLUDE_SUBDOMAINS', true),
        'x_frame_options' => 'SAMEORIGIN',
        'x_content_type_options' => 'nosniff',
        'x_xss_protection' => '1; mode=block',
        'referrer_policy' => 'strict-origin-when-cross-origin',
        'permissions_policy' => 'camera=(), microphone=(), geolocation=()',
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