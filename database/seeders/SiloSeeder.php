<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Silo;

class SiloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main silos
        $poolResurfacing = Silo::create([
            'name' => 'Pool Resurfacing',
            'slug' => 'pool-resurfacing',
            'description' => 'Professional pool resurfacing services to restore and enhance your pool\'s appearance and functionality.',
            'content' => '<p>Transform your pool with our professional resurfacing services. We offer a variety of materials and finishes to suit your style and budget.</p>',
            'meta_title' => 'Pool Resurfacing Services | Professional Pool Renovation',
            'meta_description' => 'Expert pool resurfacing services in DFW. Transform your pool with fiberglass, plaster, or pebble finishes. Get a free quote today!',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $poolConversions = Silo::create([
            'name' => 'Pool Conversions',
            'slug' => 'pool-conversions',
            'description' => 'Convert your pool to a more efficient system with our professional pool conversion services.',
            'content' => '<p>Upgrade your pool with our conversion services. From saltwater conversions to energy-efficient systems, we have you covered.</p>',
            'meta_title' => 'Pool Conversion Services | Saltwater & System Upgrades',
            'meta_description' => 'Professional pool conversion services including saltwater systems, energy-efficient upgrades, and more. Expert installation in DFW.',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $poolRemodeling = Silo::create([
            'name' => 'Pool Remodeling',
            'slug' => 'pool-remodeling',
            'description' => 'Complete pool remodeling services to transform your backyard oasis.',
            'content' => '<p>Reimagine your pool area with our comprehensive remodeling services. From tile updates to complete renovations.</p>',
            'meta_title' => 'Pool Remodeling Services | Complete Pool Renovation',
            'meta_description' => 'Transform your pool with professional remodeling services. Tile, coping, decking, and complete renovations. Free estimates available.',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $poolRepair = Silo::create([
            'name' => 'Pool Repair',
            'slug' => 'pool-repair-service',
            'description' => 'Fast and reliable pool repair services for all types of pool problems.',
            'content' => '<p>Keep your pool in perfect condition with our expert repair services. We handle everything from minor fixes to major repairs.</p>',
            'meta_title' => 'Pool Repair Services | Emergency & Routine Pool Repairs',
            'meta_description' => 'Professional pool repair services in DFW. Crack repair, leak detection, equipment repair, and more. Fast, reliable service.',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        // Create sub-silos for Pool Resurfacing
        Silo::create([
            'name' => 'Fiberglass Pool Resurfacing',
            'slug' => 'fiberglass-pool-resurfacing',
            'parent_id' => $poolResurfacing->id,
            'description' => 'Durable and long-lasting fiberglass pool resurfacing solutions.',
            'content' => '<p>Fiberglass resurfacing provides a smooth, durable finish that resists stains and requires minimal maintenance.</p>',
            'template' => 'fiberglass-pool-resurfacing',
            'meta_title' => 'Fiberglass Pool Resurfacing | Durable Pool Finishes',
            'meta_description' => 'Professional fiberglass pool resurfacing services. Long-lasting, low-maintenance finishes for your pool. Get a free quote.',
            'features' => [
                ['title' => 'Long-lasting Durability', 'description' => 'Fiberglass surfaces can last 15-30 years with proper care'],
                ['title' => 'Smooth Finish', 'description' => 'Non-porous surface that resists algae and stains'],
                ['title' => 'Low Maintenance', 'description' => 'Requires less chemicals and cleaning'],
                ['title' => 'Quick Installation', 'description' => 'Faster installation compared to other materials'],
            ],
            'benefits' => [
                ['title' => 'Cost-Effective', 'description' => 'Lower long-term maintenance costs'],
                ['title' => 'Energy Efficient', 'description' => 'Better heat retention saves on heating costs'],
                ['title' => 'Comfortable', 'description' => 'Smooth surface is gentle on feet'],
                ['title' => 'Versatile Design', 'description' => 'Available in various colors and patterns'],
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Silo::create([
            'name' => 'Plaster & Marcite Resurfacing',
            'slug' => 'plaster-marcite-resurfacing',
            'parent_id' => $poolResurfacing->id,
            'description' => 'Traditional plaster and marcite pool resurfacing for a classic look.',
            'content' => '<p>Classic plaster and marcite finishes provide a timeless appearance and reliable performance for your pool.</p>',
            'template' => 'plaster-marcite-resurfacing',
            'meta_title' => 'Plaster & Marcite Pool Resurfacing | Classic Pool Finishes',
            'meta_description' => 'Expert plaster and marcite pool resurfacing services. Traditional finishes with modern application techniques. Free estimates.',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // Create sub-silos for Pool Repair
        Silo::create([
            'name' => 'Pool Crack Repair',
            'slug' => 'pool-crack-repair',
            'parent_id' => $poolRepair->id,
            'description' => 'Professional pool crack repair services to prevent water loss and structural damage.',
            'content' => '<p>Expert crack repair services to restore your pool\'s integrity and prevent further damage.</p>',
            'template' => 'pool-crack-repair',
            'meta_title' => 'Pool Crack Repair Services | Fix Pool Cracks Fast',
            'meta_description' => 'Professional pool crack repair services in DFW. Fix structural cracks, surface cracks, and prevent water loss. Emergency service available.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Create sub-silos for Pool Remodeling
        Silo::create([
            'name' => 'Pool Tile Remodeling',
            'slug' => 'pool-tile-remodeling',
            'parent_id' => $poolRemodeling->id,
            'description' => 'Update your pool with beautiful new tile designs and patterns.',
            'content' => '<p>Transform your pool\'s appearance with our professional tile remodeling services.</p>',
            'template' => 'pool-tile-remodeling',
            'meta_title' => 'Pool Tile Remodeling | Custom Pool Tile Installation',
            'meta_description' => 'Professional pool tile remodeling services. Custom designs, waterline tiles, and complete tile renovations. Free design consultation.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Create sub-silos for Pool Conversions
        Silo::create([
            'name' => 'Saltwater Pool Conversion',
            'slug' => 'saltwater-pool-conversion',
            'parent_id' => $poolConversions->id,
            'description' => 'Convert your chlorine pool to a saltwater system for easier maintenance.',
            'content' => '<p>Enjoy the benefits of a saltwater pool with our professional conversion services.</p>',
            'meta_title' => 'Saltwater Pool Conversion | Chlorine to Salt System',
            'meta_description' => 'Professional saltwater pool conversion services. Convert from chlorine to salt for easier maintenance and better swimming experience.',
            'features' => [
                ['title' => 'Softer Water', 'description' => 'Gentler on skin, eyes, and hair'],
                ['title' => 'Lower Maintenance', 'description' => 'Self-regulating chlorine production'],
                ['title' => 'Cost Savings', 'description' => 'Reduced chemical costs over time'],
                ['title' => 'Eco-Friendly', 'description' => 'Fewer harsh chemicals needed'],
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->command->info('Silos seeded successfully!');
    }
}