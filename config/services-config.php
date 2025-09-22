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
        'house-cleaning',
        'commercial-cleaning',
        'carpet-cleaning',
        'deep-cleaning',
        'window-cleaning',
        'post-construction-cleaning',
        'pool-cleaning',
        'gutter-leafguard-installation',
        'christmas-light-installation',
        'vinyl-fence-installation',
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
        'house-cleaning' => 1,
        'commercial-cleaning' => 2,
        'carpet-cleaning' => 3,
        'deep-cleaning' => 4,
        'window-cleaning' => 5,
        'post-construction-cleaning' => 6,
        'pool-cleaning' => 7,
        'gutter-leafguard-installation' => 8,
        'christmas-light-installation' => 9,
        'vinyl-fence-installation' => 10,
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
        'house-cleaning' => 1,
        'commercial-cleaning' => 2,
        'carpet-cleaning' => 3,
        'deep-cleaning' => 4,
        'window-cleaning' => 5,
        'post-construction-cleaning' => 6,
        'pool-cleaning' => 7,
        'gutter-leafguard-installation' => 8,
        'christmas-light-installation' => 9,
        'vinyl-fence-installation' => 10,
    ],
];