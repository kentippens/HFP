<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Support\Facades\DB;

/**
 * @deprecated Use safe service seeders instead
 * This seeder is kept for backward compatibility only
 */
class StandardizedServiceSeeder extends SafeSeeder
{
    public function run()
    {
        $this->command->warn('⚠️  StandardizedServiceSeeder is deprecated. Use safe service seeders instead.');
        $this->logSeeding('Starting StandardizedServiceSeeder');
        
        // Use safe truncate instead of direct truncate
        if (!$this->isProduction() && $this->confirmDestructive('truncate services')) {
            $this->safeTruncate(Service::class);
        } else {
            $this->command->info('Using safe upsert method...');
            // Will use upsert below
        }
        
        // Get image mapping from config
        $imageMapping = config('services-config.image_mapping');
        $serviceOrder = config('services-config.service_order');
        $activeServices = config('services-config.active_services');
        
        $services = [
            [
                'name' => 'House Cleaning',
                'slug' => 'house-cleaning',
                'short_description' => 'Professional residential cleaning services that keep your home spotless and hygienic.',
                'description' => '<p>Our comprehensive house cleaning services are designed to maintain your home in pristine condition. We provide thorough cleaning of all living spaces including bedrooms, bathrooms, kitchens, and common areas.</p><p>Our trained professionals use eco-friendly products and follow systematic cleaning protocols to ensure every corner of your home receives proper attention. From deep cleaning to regular maintenance, we customize our services to meet your specific needs.</p>',
                'features' => json_encode([
                    'Thorough dusting and vacuuming',
                    'Kitchen and bathroom sanitization',
                    'Floor cleaning and mopping',
                    'Trash removal',
                    'Customizable cleaning schedules'
                ]),
                'icon' => 'services/icon-1.png',
                'image' => 'services/service-img-1.jpg',
                'breadcrumb_image' => 'breadcrumb/services-bg.jpg',
                'meta_title' => 'Professional House Cleaning Services | HSS',
                'meta_description' => 'Expert residential cleaning services for homes. Deep cleaning, regular maintenance, and eco-friendly solutions.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/house-cleaning',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 1
            ],
            [
                'name' => 'Commercial Cleaning',
                'slug' => 'commercial-cleaning',
                'short_description' => 'Specialized cleaning services for offices, retail stores, and commercial buildings.',
                'description' => '<p>Professional commercial cleaning services designed to maintain clean, healthy work environments that boost productivity and create positive impressions on clients and employees.</p><p>We understand the unique requirements of different commercial spaces and provide customized cleaning solutions for offices, retail stores, medical facilities, and industrial buildings.</p>',
                'features' => json_encode([
                    'Office cleaning and sanitization',
                    'Floor maintenance and polishing',
                    'Window and glass cleaning',
                    'Restroom deep cleaning',
                    'Flexible scheduling options'
                ]),
                'icon' => 'services/icon-2.png',
                'image' => 'services/service-img-2.jpg',
                'breadcrumb_image' => 'breadcrumb/services-bg.jpg',
                'meta_title' => 'Commercial Cleaning Services | HSS',
                'meta_description' => 'Professional commercial cleaning for offices, retail, and industrial spaces. Reliable and thorough.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/commercial-cleaning',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 2
            ],
            [
                'name' => 'Carpet Cleaning',
                'slug' => 'carpet-cleaning',
                'short_description' => 'Deep carpet cleaning and maintenance services for residential and commercial properties.',
                'description' => '<p>Professional carpet cleaning services that remove deep-seated dirt, stains, and allergens from your carpets, extending their life and maintaining a healthy indoor environment.</p><p>We use advanced cleaning equipment and techniques including steam cleaning, dry cleaning, and stain removal treatments.</p>',
                'features' => json_encode([
                    'Steam cleaning technology',
                    'Stain and odor removal',
                    'Pet-safe cleaning products',
                    'Quick drying methods',
                    'Carpet protection treatment'
                ]),
                'icon' => 'services/icon-3.png',
                'image' => 'services/service-img-3.jpg',
                'breadcrumb_image' => 'breadcrumb/services-bg.jpg',
                'meta_title' => 'Professional Carpet Cleaning Services | HSS',
                'meta_description' => 'Expert carpet cleaning services. Steam cleaning, stain removal, and carpet maintenance for homes and offices.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/carpet-cleaning',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 3
            ],
            [
                'name' => 'Deep Cleaning',
                'slug' => 'deep-cleaning',
                'short_description' => 'Comprehensive deep cleaning services for thorough property maintenance.',
                'description' => '<p>Our deep cleaning services go beyond regular maintenance to address areas that require special attention. Perfect for move-ins, post-construction cleanup, or seasonal deep cleans.</p><p>We focus on hard-to-reach areas, detailed scrubbing, and comprehensive sanitization.</p>',
                'features' => json_encode([
                    'Detailed appliance cleaning',
                    'Baseboard and trim cleaning',
                    'Light fixture cleaning',
                    'Cabinet interior cleaning',
                    'Comprehensive sanitization'
                ]),
                'icon' => 'services/icon-4.png',
                'image' => 'services/service-img-4.jpg',
                'breadcrumb_image' => 'breadcrumb/services-bg.jpg',
                'meta_title' => 'Deep Cleaning Services | HSS',
                'meta_description' => 'Comprehensive deep cleaning for move-ins, post-construction, and seasonal maintenance.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/deep-cleaning',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 4
            ],
            [
                'name' => 'Window Cleaning',
                'slug' => 'window-cleaning',
                'short_description' => 'Professional window cleaning for crystal clear views and enhanced curb appeal.',
                'description' => '<p>Professional window cleaning services for both interior and exterior windows. We ensure streak-free, crystal clear results that enhance the appearance of your property.</p><p>Our trained technicians use professional-grade equipment and techniques to safely clean windows at any height.</p>',
                'features' => json_encode([
                    'Interior and exterior cleaning',
                    'Screen cleaning and repair',
                    'Frame and sill cleaning',
                    'High-rise window cleaning',
                    'Streak-free guarantee'
                ]),
                'icon' => 'services/icon-5.png',
                'image' => 'services/service-img-5.jpg',
                'breadcrumb_image' => 'breadcrumb/services-bg.jpg',
                'meta_title' => 'Professional Window Cleaning Services | HSS',
                'meta_description' => 'Expert window cleaning for homes and businesses. Interior, exterior, and high-rise window cleaning.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/window-cleaning',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 5
            ],
            [
                'name' => 'Post-Construction Cleaning',
                'slug' => 'post-construction-cleaning',
                'short_description' => 'Specialized cleanup services for newly constructed or renovated properties.',
                'description' => '<p>Post-construction cleaning requires specialized knowledge and equipment to handle the unique challenges of construction debris, dust, and residue.</p><p>We remove construction dust, clean fixtures, sanitize surfaces, and prepare the space for occupancy.</p>',
                'features' => json_encode([
                    'Construction debris removal',
                    'Dust elimination',
                    'Fixture and surface cleaning',
                    'Floor polishing',
                    'Final inspection cleanup'
                ]),
                'icon' => 'services/icon-6.png',
                'image' => 'services/service-img-6.jpg',
                'breadcrumb_image' => 'breadcrumb/services-bg.jpg',
                'meta_title' => 'Post-Construction Cleaning Services | HSS',
                'meta_description' => 'Specialized post-construction cleanup for new builds and renovations. Professional debris removal.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/post-construction-cleaning',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 6
            ],
            [
                'name' => 'Pool Cleaning',
                'slug' => 'pool-cleaning',
                'short_description' => 'Professional pool maintenance and cleaning services to keep your pool sparkling clean.',
                'description' => '<p>Our comprehensive pool cleaning services ensure your pool remains clean, safe, and inviting throughout the year. We provide regular maintenance, chemical balancing, and equipment inspections.</p><p>From weekly cleanings to seasonal openings and closings, we handle all aspects of pool care.</p>',
                'features' => json_encode([
                    'Weekly pool maintenance',
                    'Chemical testing and balancing',
                    'Filter cleaning and maintenance',
                    'Algae prevention and removal',
                    'Equipment inspection and repair'
                ]),
                'icon' => 'services/icon-7.png',
                'image' => 'services/service-img-7.jpg',
                'breadcrumb_image' => 'breadcrumb/services-bg.jpg',
                'meta_title' => 'Professional Pool Cleaning Services | HSS',
                'meta_description' => 'Expert pool cleaning and maintenance services. Chemical balancing, equipment care, and regular cleaning.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-cleaning',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 7
            ],
            [
                'name' => 'Gutter & Leaf Guard Installation',
                'slug' => 'gutter-leafguard-installation',
                'short_description' => 'Professional gutter cleaning and leaf guard installation to protect your home.',
                'description' => '<p>Protect your home from water damage with our professional gutter services. We provide thorough gutter cleaning and install high-quality leaf guards to prevent clogs and ensure proper water drainage.</p><p>Our leaf guard systems reduce maintenance needs and extend the life of your gutters.</p>',
                'features' => json_encode([
                    'Complete gutter cleaning',
                    'Leaf guard installation',
                    'Downspout clearing',
                    'Gutter repair services',
                    'Annual maintenance plans'
                ]),
                'icon' => 'services/icon-8.png',
                'image' => 'services/service-img-8.jpg',
                'breadcrumb_image' => 'breadcrumb/services-bg.jpg',
                'meta_title' => 'Gutter & Leaf Guard Installation | HSS',
                'meta_description' => 'Professional gutter cleaning and leaf guard installation. Protect your home from water damage.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/gutter-leafguard-installation',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 8
            ],
            [
                'name' => 'Christmas Light Installation',
                'slug' => 'christmas-light-installation',
                'short_description' => 'Professional holiday lighting design and installation services.',
                'description' => '<p>Transform your property into a winter wonderland with our professional Christmas light installation services. We handle everything from design to installation and removal.</p><p>Our team creates custom lighting displays that bring holiday cheer while ensuring safety and energy efficiency.</p>',
                'features' => json_encode([
                    'Custom light design',
                    'Professional installation',
                    'LED energy-efficient lights',
                    'Timer and control setup',
                    'Post-season removal and storage'
                ]),
                'icon' => 'services/icon-9.png',
                'image' => 'services/service-img-9.jpg',
                'breadcrumb_image' => 'breadcrumb/services-bg.jpg',
                'meta_title' => 'Christmas Light Installation | HSS',
                'meta_description' => 'Professional holiday lighting installation. Custom designs, LED lights, and complete service.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/christmas-light-installation',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 9
            ],
            [
                'name' => 'Vinyl Fence Installation',
                'slug' => 'vinyl-fence-installation',
                'short_description' => 'Professional vinyl fence installation for privacy, security, and curb appeal.',
                'description' => '<p>Enhance your property with our professional vinyl fence installation services. Vinyl fencing offers durability, low maintenance, and attractive appearance that lasts for years.</p><p>We provide custom designs and professional installation for residential and commercial properties.</p>',
                'features' => json_encode([
                    'Custom fence design',
                    'Professional installation',
                    'Multiple style options',
                    'Lifetime warranty',
                    'Low maintenance solution'
                ]),
                'icon' => 'services/icon-10.png',
                'image' => 'services/service-img-10.jpg',
                'breadcrumb_image' => 'breadcrumb/services-bg.jpg',
                'meta_title' => 'Vinyl Fence Installation | HSS',
                'meta_description' => 'Professional vinyl fence installation. Durable, low-maintenance fencing solutions for your property.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/vinyl-fence-installation',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 10
            ]
        ];
        
        foreach ($services as $service) {
            Service::create($service);
        }
        
        $this->command->info('Standardized services seeded successfully!');
    }
}