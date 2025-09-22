<?php

namespace Database\Seeders;

use App\Models\Service;

class PoolServicesSeeder extends SafeSeeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'Fiberglass Pool Resurfacing',
                'slug' => 'fiberglass-pool-resurfacing',
                'short_description' => 'Premium fiberglass coating that transforms your pool with superior durability and a smooth, luxurious finish.',
                'description' => '<p>Our fiberglass pool resurfacing service provides the ultimate solution for pool renovation. Using state-of-the-art materials and techniques, we apply multiple layers of high-grade fiberglass to create a seamless, non-porous surface that resists algae, stains, and chemicals.</p><p>This advanced resurfacing method not only extends your pool\'s lifespan by 15-20 years but also reduces maintenance costs and chemical usage. The smooth finish is gentle on feet and swimwear while providing a beautiful, modern appearance.</p>',
                'overview' => '<p>Fiberglass pool resurfacing is the most advanced and durable option available for pool renovation. Our multi-layer application process creates a seamless, non-porous surface that outperforms traditional materials in every way.</p><p>With a lifespan of 15-20 years and minimal maintenance requirements, fiberglass resurfacing is the smart investment for pool owners who want lasting quality and beauty.</p>',
                'benefits' => [
                    'Superior durability - 17 times stronger than traditional plaster',
                    'Non-porous surface resists algae growth and staining',
                    'Reduces chemical usage by up to 40%',
                    'Smooth finish is gentle on feet and swimwear',
                    'Available in multiple colors and finishes',
                    '15-20 year warranty on materials and workmanship',
                    'Quick installation - pool ready in 3-5 days',
                    'Energy efficient - better heat retention'
                ],
                'features' => [
                    'Multi-layer fiberglass application',
                    'Premium gel coat finish',
                    'UV-resistant coating',
                    'Chemical-resistant surface',
                    'Slip-resistant texture options',
                    'Custom color matching available',
                    'Complete surface preparation included',
                    'Professional warranty coverage'
                ],
                'icon' => 'services/fiberglass-icon.png',
                'image' => 'services/fiberglass-pool.jpg',
                'homepage_image' => 'services/homepage/fiberglass-resurfacing.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Fiberglass Pool Resurfacing | Premium Pool Renovation Services',
                'meta_description' => 'Transform your pool with our premium fiberglass resurfacing. 15-20 year warranty, chemical resistant, and beautiful finishes available.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/fiberglass-pool-resurfacing',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 1
            ],
            [
                'name' => 'Plaster & Marcite Resurfacing',
                'slug' => 'plaster-marcite-resurfacing',
                'short_description' => 'Traditional plaster resurfacing with modern materials for a classic, elegant pool finish.',
                'description' => '<p>Our pool plaster resurfacing service combines traditional craftsmanship with modern materials to deliver a beautiful, durable finish. We use premium white marble aggregate plaster that provides a classic, timeless appearance while ensuring long-lasting performance.</p><p>Perfect for pools of all sizes, our plaster resurfacing process includes thorough surface preparation, expert application, and careful curing to ensure optimal results that will last for years.</p>',
                'overview' => '<p>Pool plaster resurfacing remains a popular choice for its classic appearance and cost-effectiveness. Our expert application ensures a smooth, comfortable surface that enhances your pool\'s beauty.</p><p>Using premium materials and proven techniques, we deliver plaster finishes that stand the test of time while providing excellent value for your investment.</p>',
                'benefits' => [
                    'Classic, timeless appearance',
                    'Cost-effective resurfacing solution',
                    'Smooth, comfortable swimming surface',
                    'Available in white or colored finishes',
                    'Quick installation process',
                    'Compatible with all pool types',
                    '7-10 year expected lifespan',
                    'Easy to maintain and repair'
                ],
                'features' => [
                    'Premium marble aggregate plaster',
                    'Multiple color options available',
                    'Professional surface preparation',
                    'Expert trowel application',
                    'Proper curing process',
                    'Smooth finish techniques',
                    'Quality control inspections',
                    'Warranty protection included'
                ],
                'icon' => 'services/plaster-icon.png',
                'image' => 'services/plaster-pool.jpg',
                'homepage_image' => 'services/homepage/plaster-resurfacing.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Plaster & Marcite Resurfacing | Classic Pool Renovation',
                'meta_description' => 'Expert plaster & marcite resurfacing services. Traditional craftsmanship with modern materials for a beautiful, lasting finish.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/plaster-marcite-resurfacing',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 2
            ],
            [
                'name' => 'Pool Tile Remodeling',
                'slug' => 'pool-tile-remodeling',
                'short_description' => 'Complete waterline tile remodeling and repair services for a fresh, updated look.',
                'description' => '<p>Revitalize your pool\'s appearance with our professional tile remodeling services. We specialize in waterline tile installation, offering a wide selection of glass, ceramic, and natural stone tiles to complement any pool design.</p><p>Our expert technicians ensure proper installation with waterproof adhesives and grouts, creating a beautiful, long-lasting finish that enhances both the aesthetics and value of your pool.</p>',
                'overview' => '<p>Pool tile remodeling is an excellent way to update your pool\'s appearance without complete resurfacing. Our expert installation ensures waterproof, long-lasting results that enhance your pool\'s beauty.</p><p>We offer a wide selection of tile materials and designs, from classic ceramics to modern glass mosaics, allowing you to customize your pool\'s look.</p>',
                'benefits' => [
                    'Instantly updates pool appearance',
                    'Wide selection of tile materials',
                    'Waterproof installation methods',
                    'Enhances pool value',
                    'Easy to clean and maintain',
                    'Resistant to chemicals and UV',
                    'Custom design possibilities',
                    'Can be combined with resurfacing'
                ],
                'features' => [
                    'Glass, ceramic, and stone options',
                    'Waterline and spillway tiling',
                    'Professional tile removal',
                    'Surface preparation included',
                    'Waterproof adhesives and grouts',
                    'Color-matched grout options',
                    'Decorative pattern installation',
                    'Repair services available'
                ],
                'icon' => 'services/tile-icon.png',
                'image' => 'services/pool-tile.jpg',
                'homepage_image' => 'services/homepage/tile-replacement.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pool Tile Remodeling | Waterline Tile Installation',
                'meta_description' => 'Professional pool tile remodeling and repair services. Wide selection of tiles for waterline and decorative applications.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-tile-remodeling',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 3
            ],
            [
                'name' => 'Pool Crack Repair',
                'slug' => 'pool-crack-repair',
                'short_description' => 'Expert structural crack repair to restore your pool\'s integrity and prevent water loss.',
                'description' => '<p>Don\'t let cracks compromise your pool\'s structure or cause water loss. Our specialized crack repair service addresses both surface and structural cracks using advanced techniques and materials that ensure lasting repairs.</p><p>We use hydraulic cement, epoxy injections, and fiberglass reinforcement to permanently seal cracks, preventing further damage and water loss while preparing your pool for resurfacing.</p>',
                'overview' => '<p>Pool cracks can lead to significant water loss and structural damage if left untreated. Our specialized crack repair services address the root cause of the problem, ensuring a permanent solution that protects your investment.</p><p>Using advanced injection techniques and premium sealants, we repair cracks of all sizes in concrete, gunite, and fiberglass pools.</p>',
                'benefits' => [
                    'Stops water loss immediately',
                    'Prevents structural damage',
                    'Professional-grade repair materials',
                    'Comprehensive crack assessment',
                    'Warranty-backed repairs',
                    'Color-matched finishes available',
                    'Prepares surface for resurfacing',
                    'Cost-effective solution'
                ],
                'features' => [
                    'Structural crack assessment',
                    'Hydraulic cement application',
                    'Epoxy injection repairs',
                    'Fiberglass reinforcement',
                    'Leak detection included',
                    'Surface preparation',
                    'Flexible sealant options',
                    'Warranty protection'
                ],
                'icon' => 'services/repair-icon.png',
                'image' => 'services/crack-repair.jpg',
                'homepage_image' => 'services/homepage/fiberglass-resurfacing.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pool Crack Repair | Structural Pool Repairs',
                'meta_description' => 'Professional pool crack repair services. Fix structural cracks, stop leaks, and restore your pool\'s integrity.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-crack-repair',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 4
            ]
        ];

        // Process each service individually to handle JSON casting properly
        foreach ($services as $service) {
            // Convert arrays to JSON for database storage
            if (isset($service['benefits']) && is_array($service['benefits'])) {
                $service['benefits'] = json_encode($service['benefits']);
            }
            if (isset($service['features']) && is_array($service['features'])) {
                $service['features'] = json_encode($service['features']);
            }
            if (isset($service['json_ld']) && is_array($service['json_ld'])) {
                $service['json_ld'] = json_encode($service['json_ld']);
            }
            
            // Use updateOrCreate for proper handling
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
        
        $this->command->info('✅ Pool services seeded successfully');
    }
}