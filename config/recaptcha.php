<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google reCAPTCHA Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Google reCAPTCHA v2 Invisible
    |
    */

    'enabled' => env('RECAPTCHA_ENABLED', true),

    'site_key' => env('RECAPTCHA_SITE_KEY', ''),

    'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),

    'verify_url' => 'https://www.google.com/recaptcha/api/siteverify',

    // Skip validation for these IPs (useful for local development)
    'skip_ips' => env('APP_ENV') === 'local' ? ['127.0.0.1', '::1'] : [],

    // Minimum score for v3 (not used for v2 invisible, but keeping for future)
    'min_score' => 0.5,

    // Timeout for API call in seconds
    'timeout' => 5,
];