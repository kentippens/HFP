<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Export Schedule Configuration
    |--------------------------------------------------------------------------
    |
    | Configure automatic export schedules for different data types.
    | Each schedule defines when and how exports should be generated.
    |
    */

    'enabled' => env('SCHEDULED_EXPORTS_ENABLED', true),

    'default_storage' => env('EXPORT_STORAGE_DISK', 'local'),

    'email_recipients' => [
        'admin@hexagonservicesolutions.com',
        // Add more recipients as needed
    ],

    'schedules' => [
        'contact_submissions' => [
            'enabled' => true,
            'frequency' => 'weekly', // daily, weekly, monthly
            'day' => 'monday',       // For weekly: monday-sunday, For monthly: 1-31
            'time' => '09:00',       // 24-hour format
            'period' => 'week',      // day, week, month, year, all
            'email_results' => true,
            'retention_days' => 30,  // Auto-delete files older than X days
        ],

        'services' => [
            'enabled' => true,
            'frequency' => 'daily',
            'time' => '23:30',
            'period' => 'all',
            'email_results' => false,
            'retention_days' => 7,
            'conditions' => [
                'only_if_updated' => true, // Only export if data changed
            ],
        ],

        'blog_posts' => [
            'enabled' => true,
            'frequency' => 'weekly',
            'day' => 'sunday',
            'time' => '20:00',
            'period' => 'month',
            'email_results' => false,
            'retention_days' => 14,
        ],

        'users' => [
            'enabled' => true,
            'frequency' => 'weekly',
            'day' => 'friday',
            'time' => '17:00',
            'period' => 'week',
            'email_results' => true,
            'retention_days' => 30,
        ],

        'full_backup' => [
            'enabled' => true,
            'frequency' => 'monthly',
            'day' => 1, // 1st of each month
            'time' => '08:00',
            'period' => 'month',
            'email_results' => true,
            'retention_days' => 90,
            'include' => ['contacts', 'services', 'posts', 'users'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Export File Settings
    |--------------------------------------------------------------------------
    */

    'file_settings' => [
        'prefix' => 'hexservice',
        'include_timestamp' => true,
        'compression' => false, // Future feature: compress large exports
        'max_file_size' => '50MB',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */

    'notifications' => [
        'email_on_success' => true,
        'email_on_failure' => true,
        'slack_webhook' => env('EXPORT_SLACK_WEBHOOK'),
        'log_channel' => 'exports', // Custom log channel for exports
    ],

    /*
    |--------------------------------------------------------------------------
    | Cleanup Settings
    |--------------------------------------------------------------------------
    */

    'cleanup' => [
        'enabled' => true,
        'run_after_export' => true,
        'keep_latest' => 5, // Always keep the 5 most recent exports
    ],
];