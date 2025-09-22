<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Support\Facades\DB;

class SafePoolResurfacingServiceSeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->logSeeding('Starting SafePoolResurfacingServiceSeeder');

        // Define our pool resurfacing services
        $services = $this->getPoolServices();

        // Option 1: Safe upsert (recommended for production)
        // This will update existing services or create new ones without deleting
        if ($this->isProduction()) {
            $this->command->info("🛡️  Running in SAFE MODE - using upsert to preserve existing data");
            $this->safeUpsertServices($services);
        } else {
            // Option 2: In development/testing, optionally allow truncate
            if ($this->command->confirm('Do you want to truncate existing services? This will DELETE all current services.', false)) {
                $this->safeTruncate(Service::class);
                $this->insertServices($services);
            } else {
                $this->command->info("Using safe upsert method...");
                $this->safeUpsertServices($services);
            }
        }

        $this->logSeeding('Completed SafePoolResurfacingServiceSeeder', 'Added/Updated ' . count($services) . ' services');
    }

    /**
     * Safely upsert services without deleting existing data
     */
    private function safeUpsertServices(array $services): void
    {
        foreach ($services as $index => $serviceData) {
            // Add timestamps
            $serviceData['created_at'] = now();
            $serviceData['updated_at'] = now();

            // Use updateOrCreate for each service
            Service::updateOrCreate(
                ['slug' => $serviceData['slug']], // Match by slug
                $serviceData // Update with all data
            );

            $this->command->info("✅ Processed service: {$serviceData['name']}");
        }
    }

    /**
     * Insert services (only after truncate in safe environments)
     */
    private function insertServices(array $services): void
    {
        foreach ($services as $index => $serviceData) {
            $serviceData['created_at'] = now();
            $serviceData['updated_at'] = now();
            Service::create($serviceData);
            $this->command->info("✅ Created service: {$serviceData['name']}");
        }
    }

    /**
     * Get pool resurfacing services data
     */
    private function getPoolServices(): array
    {
        return [
            [
                'name' => 'Fiberglass Pool Resurfacing',
                'slug' => 'fiberglass-pool-resurfacing',
                'short_description' => 'Premium fiberglass coating that transforms your pool with superior durability and a smooth, luxurious finish.',
                'description' => '<p>Our fiberglass pool resurfacing service provides the ultimate solution for pool renovation. Using state-of-the-art materials and techniques, we apply multiple layers of high-grade fiberglass to create a seamless, non-porous surface that resists algae, stains, and chemicals.</p><p>This advanced resurfacing method not only extends your pool\'s lifespan by 15-20 years but also reduces maintenance costs and chemical usage. The smooth finish is gentle on feet and swimwear while providing a beautiful, modern appearance.</p>',
                'overview' => '<p>Fiberglass pool resurfacing is the most advanced and durable option available for pool renovation. Our multi-layer application process creates a seamless, non-porous surface that outperforms traditional materials in every way.</p><p>With a lifespan of 15-20 years and minimal maintenance requirements, fiberglass resurfacing is the smart investment for pool owners who want lasting quality and beauty.</p>',
                'benefits' => json_encode([
                    'Superior durability - 17 times stronger than traditional plaster',
                    'Non-porous surface resists algae growth and staining',
                    'Reduces chemical usage by up to 40%',
                    'Smooth finish is gentle on feet and swimwear',
                    'Available in multiple colors and finishes',
                    '15-20 year warranty on materials and workmanship',
                    'Quick installation - pool ready in 3-5 days',
                    'Energy efficient - better heat retention'
                ]),
                'features' => json_encode([
                    'Multi-layer fiberglass application',
                    'Premium gel coat finish',
                    'UV-resistant coating',
                    'Chemical-resistant surface',
                    'Slip-resistant texture options',
                    'Custom color matching available',
                    'Complete surface preparation included',
                    'Professional warranty coverage'
                ]),
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
                'short_description' => 'Traditional white or colored plaster resurfacing for a classic, clean pool appearance at an affordable price.',
                'description' => '<p>Pool plaster resurfacing is the time-tested method for renovating swimming pools. Our expert technicians apply premium-grade marcite plaster to create a smooth, watertight surface that restores your pool\'s beauty and functionality.</p><p>Available in classic white or a variety of colors, plaster resurfacing offers an economical solution that typically lasts 7-10 years with proper maintenance. We use only the highest quality materials and proven application techniques to ensure a flawless finish.</p>',
                'overview' => '<p>Plaster resurfacing remains one of the most popular choices for pool renovation due to its affordability and proven performance. Our professional application process ensures a smooth, durable finish that will serve your family for years to come.</p>',
                'benefits' => json_encode([
                    'Cost-effective resurfacing solution',
                    'Classic, clean appearance',
                    'Available in multiple color options',
                    '7-10 year lifespan with proper care',
                    'Smooth, comfortable surface',
                    'Time-tested reliability',
                    'Quick application process',
                    'Compatible with all pool types'
                ]),
                'features' => json_encode([
                    'Premium marcite plaster material',
                    'Professional surface preparation',
                    'Hand-troweled application',
                    'Multiple color choices',
                    'Smooth finish process',
                    'Waterline tile coordination',
                    'Full curing support',
                    'Maintenance guidance included'
                ]),
                'icon' => 'services/plaster-icon.png',
                'image' => 'services/plaster-pool.jpg',
                'homepage_image' => 'services/homepage/plaster-resurfacing.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Plaster & Marcite Resurfacing | Affordable Pool Renovation',
                'meta_description' => 'Professional pool plaster resurfacing services. Classic white or colored options available. 7-10 year lifespan with expert installation.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-plaster-resurfacing',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 2
            ],
            [
                'name' => 'Pebble Pool Finishes',
                'slug' => 'pebble-pool-finishes',
                'short_description' => 'Luxurious pebble finishes combining natural beauty with exceptional durability for the ultimate pool surface.',
                'description' => '<p>Pebble pool finishes represent the pinnacle of pool surfacing technology, combining natural stone aggregate with advanced polymers to create a stunning, long-lasting surface. Our pebble finishes offer unmatched durability, lasting 15-20 years while maintaining their beautiful appearance.</p><p>Choose from a variety of pebble sizes and color blends to create a custom look that complements your outdoor space. The textured surface provides natural slip resistance and hides minor imperfections while creating a beautiful, natural appearance.</p>',
                'overview' => '<p>Pebble finishes offer the perfect combination of beauty, durability, and value. The natural stone aggregate creates a unique, luxurious appearance while providing superior longevity compared to traditional surfaces.</p>',
                'benefits' => json_encode([
                    'Superior durability - 15-20 year lifespan',
                    'Natural, luxurious appearance',
                    'Excellent slip resistance',
                    'Hides minor imperfections',
                    'Wide variety of color options',
                    'Resistant to chemicals and staining',
                    'Low maintenance requirements',
                    'Increases property value'
                ]),
                'features' => json_encode([
                    'Natural pebble aggregate',
                    'Advanced polymer technology',
                    'Custom color blending',
                    'Multiple texture options',
                    'UV-stable materials',
                    'Professional installation',
                    'Comprehensive warranty',
                    'Environmentally friendly'
                ]),
                'icon' => 'services/pebble-icon.png',
                'image' => 'services/pebble-pool.jpg',
                'homepage_image' => 'services/homepage/pebble-finishes.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pebble Pool Finishes | Luxury Pool Resurfacing Options',
                'meta_description' => 'Premium pebble pool finishes for lasting beauty and durability. Natural stone aggregate surfaces with 15-20 year lifespan.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pebble-pool-finishes',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 3
            ],
            [
                'name' => 'Pool Tile Remodeling',
                'slug' => 'pool-tile-replacement',
                'short_description' => 'Expert tile replacement and repair services to restore your pool\'s waterline and decorative features.',
                'description' => '<p>Pool tile replacement is essential for maintaining your pool\'s appearance and preventing water damage. Our skilled technicians specialize in replacing waterline tiles, spillway tiles, and decorative tile features with precision and attention to detail.</p><p>We offer a wide selection of glass, ceramic, and natural stone tiles to match your style and budget. Whether you need to replace a few broken tiles or completely retile your pool, we ensure a perfect installation that will last for years.</p>',
                'overview' => '<p>Professional tile replacement can transform your pool\'s appearance while protecting the underlying structure. We handle everything from minor repairs to complete retiling projects with expert craftsmanship.</p>',
                'benefits' => json_encode([
                    'Prevents water damage to pool structure',
                    'Enhances pool aesthetics',
                    'Wide variety of tile options',
                    'Increases property value',
                    'Prevents calcium buildup',
                    'Easy to clean and maintain',
                    'Long-lasting results',
                    'Professional color matching'
                ]),
                'features' => json_encode([
                    'Expert tile removal and installation',
                    'Waterline and decorative tiling',
                    'Glass, ceramic, and stone options',
                    'Custom pattern design',
                    'Proper surface preparation',
                    'Professional grouting and sealing',
                    'Color matching service',
                    'Warranty on installation'
                ]),
                'icon' => 'services/tile-icon.png',
                'image' => 'services/tile-replacement.jpg',
                'homepage_image' => 'services/homepage/tile-replacement.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pool Tile Remodeling | Waterline Tile Repair Services',
                'meta_description' => 'Professional pool tile replacement and repair. Waterline tiles, decorative features, glass and ceramic options. Expert installation guaranteed.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-tile-replacement',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 4
            ],
            [
                'name' => 'Pool Crack Repair',
                'slug' => 'pool-crack-repair',
                'short_description' => 'Professional crack repair services to stop leaks and prevent structural damage to your pool.',
                'description' => '<p>Pool cracks can lead to water loss, structural damage, and costly repairs if not addressed promptly. Our expert technicians use advanced techniques and materials to permanently repair cracks in concrete, gunite, and fiberglass pools.</p><p>We begin with a thorough inspection to identify all cracks and determine their cause. Then, we use specialized injection methods and high-strength materials to seal cracks from the inside out, ensuring a lasting repair that prevents future problems.</p>',
                'overview' => '<p>Don\'t let pool cracks turn into major problems. Our professional repair services address the root cause of cracks while providing permanent solutions that restore your pool\'s integrity.</p>',
                'benefits' => json_encode([
                    'Stops water loss immediately',
                    'Prevents structural damage',
                    'Saves money on water bills',
                    'Extends pool lifespan',
                    'Prevents further cracking',
                    'Professional warranty included',
                    'Quick repair process',
                    'Long-lasting results'
                ]),
                'features' => json_encode([
                    'Comprehensive crack inspection',
                    'Structural crack analysis',
                    'High-pressure injection repair',
                    'Flexible sealant application',
                    'Surface preparation and bonding',
                    'Waterproof coating application',
                    'Pressure testing',
                    'Follow-up inspection included'
                ]),
                'icon' => 'services/crack-repair-icon.png',
                'image' => 'services/crack-repair.jpg',
                'homepage_image' => 'services/homepage/crack-repair.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pool Crack Repair | Stop Pool Leaks & Structural Damage',
                'meta_description' => 'Expert pool crack repair services. Stop leaks, prevent damage, save water. Professional repairs for concrete, gunite, and fiberglass pools.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-crack-repair',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 5
            ],
            [
                'name' => 'Pool Acid Washing',
                'slug' => 'pool-acid-washing',
                'short_description' => 'Professional acid washing to remove stains, algae, and mineral deposits, restoring your pool\'s original beauty.',
                'description' => '<p>Pool acid washing is a powerful cleaning process that removes stubborn stains, algae buildup, and mineral deposits from your pool\'s surface. Our trained professionals use a carefully controlled acid solution to strip away the top layer of plaster, revealing fresh, clean material underneath.</p><p>This process is ideal for pools with severe staining or discoloration that cannot be removed through regular cleaning. Acid washing can dramatically improve your pool\'s appearance without the cost of complete resurfacing.</p>',
                'overview' => '<p>Acid washing is an effective way to restore your pool\'s appearance by removing years of buildup and staining. Our professional service ensures safe, thorough cleaning with impressive results.</p>',
                'benefits' => json_encode([
                    'Removes stubborn stains and discoloration',
                    'Eliminates algae and bacteria',
                    'Restores original plaster color',
                    'More affordable than resurfacing',
                    'Quick process (1-2 days)',
                    'Improves water chemistry',
                    'Enhances pool appearance',
                    'Prepares surface for new finish'
                ]),
                'features' => json_encode([
                    'Complete pool draining',
                    'Professional-grade acid solution',
                    'Controlled application process',
                    'Thorough neutralization',
                    'Surface inspection',
                    'Proper waste disposal',
                    'Safety protocols',
                    'Post-wash conditioning'
                ]),
                'icon' => 'services/acid-wash-icon.png',
                'image' => 'services/acid-washing.jpg',
                'homepage_image' => 'services/homepage/acid-washing.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pool Acid Washing | Remove Stains & Restore Pool Surfaces',
                'meta_description' => 'Professional pool acid washing services. Remove stains, algae, and mineral deposits. Restore your pool\'s beauty without resurfacing.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-acid-washing',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 6
            ],
            [
                'name' => 'Pool Inspection & Consultation',
                'slug' => 'pool-inspection-consultation',
                'short_description' => 'Comprehensive pool inspections and expert consultation to identify issues and plan renovations.',
                'description' => '<p>Our detailed pool inspection and consultation service provides you with a complete assessment of your pool\'s condition and renovation needs. Our experienced inspectors examine every aspect of your pool, from surface condition to equipment functionality.</p><p>We provide a detailed report with photos, recommendations, and cost estimates for any necessary repairs or improvements. This service is perfect for new pool owners, pre-purchase inspections, or planning major renovations.</p>',
                'overview' => '<p>Make informed decisions about your pool with our comprehensive inspection and consultation service. We provide the expertise and information you need to maintain and improve your pool investment.</p>',
                'benefits' => json_encode([
                    'Complete pool condition assessment',
                    'Identify hidden problems early',
                    'Professional recommendations',
                    'Detailed written report',
                    'Cost estimates for repairs',
                    'Priority ranking of issues',
                    'Maintenance planning guidance',
                    'Peace of mind'
                ]),
                'features' => json_encode([
                    'Surface condition evaluation',
                    'Structural integrity check',
                    'Equipment inspection',
                    'Plumbing system assessment',
                    'Water chemistry analysis',
                    'Safety compliance review',
                    'Photo documentation',
                    'Detailed written report'
                ]),
                'icon' => 'services/inspection-icon.png',
                'image' => 'services/pool-inspection.jpg',
                'homepage_image' => 'services/homepage/inspection.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pool Inspection & Consultation | Professional Pool Assessment',
                'meta_description' => 'Comprehensive pool inspection and consultation services. Detailed assessment, expert recommendations, and renovation planning.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-inspection-consultation',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 7
            ],
            [
                'name' => 'Commercial Pool Services',
                'slug' => 'commercial-pool-services',
                'short_description' => 'Specialized resurfacing and maintenance services for hotels, apartments, and community pools.',
                'description' => '<p>Our commercial pool services cater to the unique needs of hotels, apartments, HOAs, and public facilities. We understand the importance of minimizing downtime and maintaining compliance with health and safety regulations.</p><p>From large-scale resurfacing projects to ongoing maintenance contracts, we have the expertise and resources to handle commercial pools of any size. Our team works efficiently to complete projects on schedule and within budget.</p>',
                'overview' => '<p>Keep your commercial pool in top condition with our professional services. We specialize in minimizing downtime while delivering superior results that meet all regulatory requirements.</p>',
                'benefits' => json_encode([
                    'Minimal facility downtime',
                    'Regulatory compliance expertise',
                    'Large-scale project capability',
                    'Flexible scheduling options',
                    'Commercial-grade materials',
                    'Liability reduction',
                    'Maintenance contracts available',
                    'Emergency repair services'
                ]),
                'features' => json_encode([
                    'Complete resurfacing services',
                    'ADA compliance updates',
                    'Safety equipment installation',
                    'High-traffic surface options',
                    'Project management',
                    'Certified technicians',
                    'Insurance documentation',
                    '24/7 emergency support'
                ]),
                'icon' => 'services/commercial-icon.png',
                'image' => 'services/commercial-pool.jpg',
                'homepage_image' => 'services/homepage/commercial-pools.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Commercial Pool Services | Hotel & Community Pool Experts',
                'meta_description' => 'Professional commercial pool resurfacing and maintenance. Hotels, apartments, HOAs. Minimal downtime, regulatory compliance, expert service.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/commercial-pool-services',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 8
            ],
            [
                'name' => 'Pool Cleaning',
                'slug' => 'pool-cleaning',
                'short_description' => 'Regular pool cleaning and maintenance services to keep your pool crystal clear and healthy year-round.',
                'description' => '<p>Our professional pool cleaning service takes the hassle out of pool maintenance. We provide comprehensive cleaning that includes skimming, vacuuming, brushing, and chemical balancing to ensure your pool stays pristine and safe for swimming.</p><p>With flexible scheduling options from weekly to monthly service, we customize our cleaning program to meet your specific needs and budget. Our certified technicians use professional-grade equipment and maintain detailed service records for your peace of mind.</p>',
                'overview' => '<p>Enjoy a sparkling clean pool without the work. Our professional cleaning service handles all aspects of pool maintenance, giving you more time to relax and enjoy your pool.</p>',
                'benefits' => json_encode([
                    'Crystal clear water year-round',
                    'Proper chemical balance maintained',
                    'Extends equipment life',
                    'Prevents algae growth',
                    'Saves time and effort',
                    'Early problem detection',
                    'Consistent professional care',
                    'Detailed service records'
                ]),
                'features' => json_encode([
                    'Surface skimming and debris removal',
                    'Vacuum pool floor and walls',
                    'Brush tiles and walls',
                    'Empty skimmer and pump baskets',
                    'Test and balance water chemistry',
                    'Inspect equipment operation',
                    'Backwash filter as needed',
                    'Detailed service report'
                ]),
                'icon' => 'services/cleaning-icon.png',
                'image' => 'services/pool-cleaning.jpg',
                'homepage_image' => 'services/homepage/pool-cleaning.jpg',
                'breadcrumb_image' => 'breadcrumb/pool-services-bg.jpg',
                'meta_title' => 'Pool Cleaning Services | Professional Pool Maintenance',
                'meta_description' => 'Professional pool cleaning and maintenance services. Weekly, bi-weekly, and monthly options. Keep your pool crystal clear year-round.',
                'meta_robots' => 'index, follow',
                'canonical_url' => '/services/pool-cleaning',
                'include_in_sitemap' => true,
                'is_active' => true,
                'order_index' => 9
            ]
        ];
    }
}