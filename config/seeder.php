<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Seeder Safety Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration file controls the safety mechanisms for database
    | seeders to prevent accidental data loss in production environments.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Safe Environments
    |--------------------------------------------------------------------------
    |
    | List of environments where destructive seeding operations (truncate,
    | delete) are allowed without additional confirmation.
    |
    */
    'safe_environments' => [
        'local',
        'testing',
    ],

    /*
    |--------------------------------------------------------------------------
    | Protected Environments
    |--------------------------------------------------------------------------
    |
    | Environments that require explicit confirmation for destructive operations.
    | In these environments, seeders will use safe methods by default.
    |
    */
    'protected_environments' => [
        'staging',
        'production',
    ],

    /*
    |--------------------------------------------------------------------------
    | Protected Tables
    |--------------------------------------------------------------------------
    |
    | Tables that should never be truncated in production, regardless of
    | force flags. Add critical production data tables here.
    |
    */
    'protected_tables' => [
        'users',              // User accounts
        'contact_submissions', // Customer contact form submissions
        'orders',             // Order data (if applicable)
        'payments',           // Payment records (if applicable)
        'sessions',           // Active user sessions
        'password_resets',    // Password reset tokens
        'failed_jobs',        // Failed job records
        'jobs',               // Queued jobs
    ],

    /*
    |--------------------------------------------------------------------------
    | Seeding Strategy
    |--------------------------------------------------------------------------
    |
    | Default seeding strategy for different environments:
    | - 'truncate': Delete all data then insert (DANGEROUS)
    | - 'upsert': Update existing or insert new (SAFE)
    | - 'skip_existing': Only insert if table is empty (SAFEST)
    |
    */
    'strategy' => [
        'local' => 'upsert',
        'testing' => 'truncate',
        'staging' => 'upsert',
        'production' => 'skip_existing',
    ],

    /*
    |--------------------------------------------------------------------------
    | Require Confirmation
    |--------------------------------------------------------------------------
    |
    | Whether to require interactive confirmation for destructive operations
    | in each environment. Set to false for CI/CD environments.
    |
    */
    'require_confirmation' => [
        'local' => true,
        'testing' => false,
        'staging' => true,
        'production' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Backup Before Seed
    |--------------------------------------------------------------------------
    |
    | Automatically create a backup before running seeders with destructive
    | operations. Only works if backup package is installed.
    |
    */
    'backup_before_seed' => env('BACKUP_BEFORE_SEED', false),

    /*
    |--------------------------------------------------------------------------
    | Audit Logging
    |--------------------------------------------------------------------------
    |
    | Log all seeding operations for audit trail. Includes timestamp,
    | environment, user, and operations performed.
    |
    */
    'audit_logging' => [
        'enabled' => env('SEEDER_AUDIT_LOG', true),
        'channel' => env('SEEDER_LOG_CHANNEL', 'single'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Force Flags
    |--------------------------------------------------------------------------
    |
    | Environment variables required to force destructive operations in
    | protected environments. Both must be set to true.
    |
    */
    'force_flags' => [
        'force_seed' => env('FORCE_SEED_DESTRUCTIVE', false),
        'acknowledge_risk' => env('I_UNDERSTAND_THIS_WILL_DELETE_DATA', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Dry Run Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, seeders will show what would be done without actually
    | making any database changes. Useful for testing.
    |
    */
    'dry_run' => env('SEEDER_DRY_RUN', false),

];