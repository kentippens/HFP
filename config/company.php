<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Company Information
    |--------------------------------------------------------------------------
    |
    | This file contains the company information used throughout the application
    | for metadata, branding, and display purposes.
    |
    */
    
    'name' => env('COMPANY_NAME', 'Premier Pool Resurfacing'),
    
    'short_name' => env('COMPANY_SHORT_NAME', 'PPR'),
    
    'meta_suffix' => env('COMPANY_META_SUFFIX', 'PPR'),
    
    'address' => env('COMPANY_ADDRESS', ''),
    
    'phone' => env('COMPANY_PHONE', ''),
    
    'email' => env('COMPANY_EMAIL', 'pools@hexagonservicesolutions.com'),
    
    /*
    |--------------------------------------------------------------------------
    | SEO Configuration
    |--------------------------------------------------------------------------
    |
    | Default SEO settings for the company.
    |
    */
    
    'seo' => [
        'default_meta_title_suffix' => ' | Premier Pool Resurfacing',
        'blog_meta_title_suffix' => ' | Pool Care Blog',
        'use_short_name_in_meta' => false,
    ],
];