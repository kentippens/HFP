<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Service Image Configuration
    |--------------------------------------------------------------------------
    |
    | These settings ensure consistency between local and production environments.
    | All paths are relative to the public/images directory.
    |
    */
    
    'images' => [
        // Default breadcrumb image for all services
        'default_breadcrumb' => 'breadcrumb/services-bg.jpg',
        
        // Icon naming pattern
        'icon_pattern' => 'services/icon-{index}.png',
        
        // Service image naming pattern
        'image_pattern' => 'services/service-img-{index}.jpg',
        
        // Placeholder images (used when actual images are missing)
        'placeholders' => [
            'icon' => 'services/placeholder-icon.png',
            'image' => 'services/placeholder-service.jpg',
            'breadcrumb' => 'breadcrumb/placeholder-bg.jpg',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Service Status Configuration
    |--------------------------------------------------------------------------
    |
    | Define which services should be active by default.
    |
    */
    
    'active_services' => [
        'pool-resurfacing',
        'pool-conversions',
        'pool-remodeling',
        'pool-repair-service',
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Order Configuration
    |--------------------------------------------------------------------------
    |
    | Define the default order for services.
    |
    */

    'service_order' => [
        'pool-resurfacing' => 1,
        'pool-conversions' => 2,
        'pool-remodeling' => 3,
        'pool-repair-service' => 4,
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Image Mapping
    |--------------------------------------------------------------------------
    |
    | Maps service slugs to their image indices.
    |
    */

    'image_mapping' => [
        'pool-resurfacing' => 1,
        'pool-conversions' => 2,
        'pool-remodeling' => 3,
        'pool-repair-service' => 4,
    ],
];