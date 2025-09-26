<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class CorePoolServicesSeeder extends Seeder
{
    public function run()
    {
        $coreServices = [
            [
                'name' => 'Pool Resurfacing',
                'slug' => 'pool-resurfacing',
                'short_description' => 'Transform your pool with our premium resurfacing solutions. Long-lasting, beautiful finishes backed by a 25-year warranty.',
                'description' => '<p>Professional pool resurfacing services that restore and enhance your pool\'s beauty and functionality. We specialize in fiberglass, plaster, and pebble finishes.</p>',
                'meta_title' => 'Pool Resurfacing Experts | 25-Year Warranty | Save $22,500',
                'meta_description' => 'Expert pool resurfacing services in Dallas-Fort Worth. Transform your pool with premium fiberglass coating. 25-year warranty included.',
                'is_active' => true,
                'order_index' => 1,
            ],
            [
                'name' => 'Pool Conversions',
                'slug' => 'pool-conversions',
                'short_description' => 'Convert your traditional pool to modern fiberglass. Upgrade to a low-maintenance, energy-efficient swimming experience.',
                'description' => '<p>Complete pool conversion services to transform your outdated pool into a modern, efficient fiberglass pool that saves money and maintenance time.</p>',
                'meta_title' => 'Pool Conversions | Upgrade to Fiberglass | Dallas-Fort Worth',
                'meta_description' => 'Convert your gunite or vinyl pool to fiberglass. Reduce maintenance costs by 70% with our professional pool conversion services.',
                'is_active' => true,
                'order_index' => 2,
            ],
            [
                'name' => 'Pool Remodeling',
                'slug' => 'pool-remodeling',
                'short_description' => 'Complete pool remodeling services including tile, coping, and equipment upgrades for a total pool transformation.',
                'description' => '<p>Comprehensive pool remodeling to update every aspect of your pool area. From waterline tiles to deck resurfacing, we handle it all.</p>',
                'meta_title' => 'Pool Remodeling | Complete Pool Renovation | DFW',
                'meta_description' => 'Full-service pool remodeling in Dallas-Fort Worth. Update tiles, coping, equipment, and more with our expert renovation team.',
                'is_active' => true,
                'order_index' => 3,
            ],
            [
                'name' => 'Pool Repair',
                'slug' => 'pool-repair',
                'short_description' => 'Expert pool repair services for cracks, leaks, and structural issues. Permanent solutions with warranty protection.',
                'description' => '<p>Professional pool repair services addressing all types of damage including cracks, leaks, and equipment failures. Fast, reliable solutions that last.</p>',
                'meta_title' => 'Pool Repair | Fix Cracks & Stop Leaks | Permanent Solutions',
                'meta_description' => 'Expert Pool Repair in Texas. Fix Structural Cracks, Gunite Damage & Concrete Cancer. 25-Year Warranty. Free Estimates. Call (972) 789-2983.',
                'is_active' => true,
                'order_index' => 4,
            ],
        ];

        foreach ($coreServices as $serviceData) {
            Service::updateOrCreate(
                ['slug' => $serviceData['slug']],
                $serviceData
            );
        }
    }
}