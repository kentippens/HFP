<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Support\Facades\DB;

/**
 * @deprecated Use SafePoolResurfacingServiceSeeder instead
 * This seeder is kept for backward compatibility only
 */
class PoolResurfacingServiceSeeder extends SafeSeeder
{
    public function run()
    {
        $this->command->warn('⚠️  PoolResurfacingServiceSeeder is deprecated. Use SafePoolResurfacingServiceSeeder instead.');
        
        // Use safe truncate instead of direct truncate
        if ($this->confirmDestructive('truncate services')) {
            $this->safeTruncate(Service::class);
        } else {
            $this->command->info('Using safe upsert method instead...');
            // Continue with upsert instead
        }
        
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
                'slug' => 'pool-plaster-resurfacing',
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
                'meta_description' => 'Expert pool plaster resurfacing services. Traditional craftsmanship with modern materials for a beautiful, lasting finish.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-plaster-resurfacing',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 2
            ],
            [
                'name' => 'Pebble Pool Finishes',
                'slug' => 'pebble-pool-finishes',
                'short_description' => 'Luxurious pebble finishes that combine natural beauty with exceptional durability.',
                'description' => '<p>Experience the ultimate in pool luxury with our pebble finish resurfacing. This premium option combines natural river pebbles with advanced binding agents to create a stunning, textured surface that\'s both beautiful and incredibly durable.</p><p>Available in a variety of colors and textures, pebble finishes offer superior longevity, natural slip resistance, and a unique aesthetic that transforms your pool into a backyard oasis.</p>',
                'overview' => '<p>Pebble finishes represent the pinnacle of pool surfacing technology, combining natural beauty with unmatched durability. The textured surface provides natural slip resistance while hiding minor imperfections.</p><p>With a lifespan of 15-25 years, pebble finishes are an excellent long-term investment that adds significant value to your property.</p>',
                'benefits' => [
                    'Longest lifespan - 15-25 years',
                    'Natural, luxurious appearance',
                    'Superior durability and strength',
                    'Natural slip-resistant texture',
                    'Hides minor surface imperfections',
                    'Multiple color and size options',
                    'Low maintenance requirements',
                    'Increases property value'
                ],
                'features' => [
                    'Natural river pebble aggregate',
                    'Advanced polymer-modified cement',
                    'Multiple pebble sizes available',
                    'Custom color blending options',
                    'Hand-troweled application',
                    'Exposed aggregate finish',
                    'Sealed for durability',
                    'Premium quality materials'
                ],
                'icon' => 'services/pebble-icon.png',
                'image' => 'services/pebble-pool.jpg',
                'homepage_image' => 'services/homepage/pebble-finishes.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pebble Pool Finishes | Luxury Pool Resurfacing',
                'meta_description' => 'Transform your pool with luxurious pebble finishes. Natural beauty, exceptional durability, and 15-25 year lifespan.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pebble-pool-finishes',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 3
            ],
            [
                'name' => 'Pool Tile Remodeling',
                'slug' => 'pool-tile-replacement',
                'short_description' => 'Complete waterline tile replacement and repair services for a fresh, updated look.',
                'description' => '<p>Revitalize your pool\'s appearance with our professional tile replacement services. We specialize in waterline tile installation, offering a wide selection of glass, ceramic, and natural stone tiles to complement any pool design.</p><p>Our expert technicians ensure proper installation with waterproof adhesives and grouts, creating a beautiful, long-lasting finish that enhances both the aesthetics and value of your pool.</p>',
                'overview' => '<p>Pool tile replacement is an excellent way to update your pool\'s appearance without complete resurfacing. Our expert installation ensures waterproof, long-lasting results that enhance your pool\'s beauty.</p><p>We offer a wide selection of tile materials and designs, from classic ceramics to modern glass mosaics, allowing you to customize your pool\'s look.</p>',
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
                'meta_description' => 'Professional pool tile replacement and repair services. Wide selection of tiles for waterline and decorative applications.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-tile-replacement',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 4
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
                'order_index' => 5
            ],
            [
                'name' => 'Pool Acid Washing',
                'slug' => 'pool-acid-washing',
                'short_description' => 'Deep cleaning service that removes stains and prepares pools for resurfacing.',
                'description' => '<p>Our pool acid washing service provides deep cleaning that removes stubborn stains, algae, and mineral deposits from your pool surface. This essential preparation step ensures optimal adhesion for new surface materials.</p><p>Using carefully controlled acid solutions and professional techniques, we strip away the thin layer of plaster to reveal fresh, clean surface underneath, eliminating years of buildup and discoloration.</p>',
                'overview' => '<p>Acid washing is a powerful cleaning process that removes stains, algae, and mineral deposits from your pool surface. This service is essential before resurfacing or as a standalone treatment to restore your pool\'s appearance.</p><p>Our controlled application ensures safe, effective results while protecting your pool\'s structural integrity.</p>',
                'benefits' => [
                    'Removes stubborn stains completely',
                    'Eliminates algae and bacteria',
                    'Brightens existing plaster',
                    'Prepares surface for resurfacing',
                    'Restores original appearance',
                    'Cost-effective cleaning solution',
                    'Environmentally safe process',
                    'Immediate visible results'
                ],
                'features' => [
                    'Professional-grade acid solutions',
                    'Controlled application process',
                    'Complete surface coverage',
                    'Proper chemical neutralization',
                    'Safe disposal methods',
                    'Surface inspection included',
                    'Pre and post-treatment',
                    'Environmental compliance'
                ],
                'icon' => 'services/acid-wash-icon.png',
                'image' => 'services/acid-washing.jpg',
                'homepage_image' => 'services/homepage/plaster-resurfacing.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pool Acid Washing | Deep Pool Cleaning Services',
                'meta_description' => 'Professional pool acid washing to remove stains, algae, and prepare for resurfacing. Safe, effective deep cleaning.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-acid-washing',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 6
            ],
            [
                'name' => 'Pool Inspection & Consultation',
                'slug' => 'pool-inspection-consultation',
                'short_description' => 'Comprehensive pool assessment and expert recommendations for maintenance or renovation.',
                'description' => '<p>Start your pool renovation journey with our thorough inspection and consultation service. Our experienced technicians evaluate your pool\'s condition, identify issues, and provide detailed recommendations for the best resurfacing options.</p><p>We assess structural integrity, surface condition, equipment functionality, and overall pool health to create a customized renovation plan that fits your needs and budget.</p>',
                'overview' => '<p>Our comprehensive pool inspection service provides you with a complete understanding of your pool\'s condition and renovation needs. We identify all issues and provide detailed recommendations for the most effective solutions.</p><p>This service is ideal for new pool owners, pre-purchase inspections, or planning major renovations.</p>',
                'benefits' => [
                    'Complete pool health assessment',
                    'Identify hidden problems early',
                    'Professional recommendations',
                    'Detailed written reports',
                    'Cost estimates provided',
                    'Priority scheduling available',
                    'Free initial consultation',
                    'Peace of mind guaranteed'
                ],
                'features' => [
                    'Structural integrity assessment',
                    'Surface condition evaluation',
                    'Leak detection testing',
                    'Equipment functionality check',
                    'Chemical balance analysis',
                    'Safety compliance review',
                    'Photo documentation',
                    'Renovation planning assistance'
                ],
                'icon' => 'services/inspection-icon.png',
                'image' => 'services/pool-inspection.jpg',
                'homepage_image' => 'services/homepage/pebble-finishes.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pool Inspection & Consultation | Expert Pool Assessment',
                'meta_description' => 'Professional pool inspection and consultation services. Get expert assessment and recommendations for your pool renovation.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-inspection-consultation',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 7
            ],
            [
                'name' => 'Commercial Pool Services',
                'slug' => 'commercial-pool-services',
                'short_description' => 'Specialized resurfacing and maintenance for hotels, resorts, and public pools.',
                'description' => '<p>We provide comprehensive commercial pool resurfacing services designed to meet the demanding requirements of hotels, resorts, apartments, and public facilities. Our commercial-grade materials and techniques ensure minimal downtime and maximum durability.</p><p>With experience in high-traffic pool environments, we understand the importance of safety compliance, durability, and maintaining operational schedules while delivering exceptional results.</p>',
                'overview' => '<p>Our commercial pool services are designed to meet the unique needs of hotels, resorts, apartments, and public facilities. We understand the importance of minimizing downtime while delivering durable, compliant solutions.</p><p>With extensive experience in commercial projects, we provide reliable, efficient service that keeps your facility operational.</p>',
                'benefits' => [
                    'Minimal operational disruption',
                    'ADA compliance expertise',
                    'High-traffic durability',
                    'Safety-focused solutions',
                    'Flexible scheduling options',
                    'Competitive commercial rates',
                    'Maintenance contracts available',
                    'Rapid project completion'
                ],
                'features' => [
                    'Large-scale project management',
                    'Multiple pool coordination',
                    'Safety compliance updates',
                    'Commercial-grade materials',
                    'Extended warranty options',
                    'Emergency repair services',
                    '24/7 support available',
                    'Preventive maintenance plans'
                ],
                'icon' => 'services/commercial-icon.png',
                'image' => 'services/commercial-pool.jpg',
                'homepage_image' => 'services/homepage/tile-replacement.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Commercial Pool Services | Hotel & Resort Pool Resurfacing',
                'meta_description' => 'Commercial pool resurfacing for hotels, resorts, and public facilities. Minimal downtime, maximum durability.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/commercial-pool-services',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 8
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}