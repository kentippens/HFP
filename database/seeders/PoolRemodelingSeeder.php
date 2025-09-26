<?php

namespace Database\Seeders;

use App\Models\Silo;
use Illuminate\Database\Seeder;

class PoolRemodelingSeeder extends Seeder
{
    public function run()
    {
        Silo::updateOrCreate(
            ['slug' => 'pool-remodeling'],
            [
                'name' => 'Pool Remodeling',
                'template' => 'pool-remodeling',
                'description' => 'Complete pool remodeling services including tile, coping, and equipment upgrades for a total pool transformation.',
                'content' => '<p>Transform your entire pool with our comprehensive remodeling services. We handle every aspect of your pool renovation from tiles and coping to equipment and surfaces.</p>',
                'meta_title' => 'Pool Remodeling | Complete Pool Renovation | Dallas-Fort Worth',
                'meta_description' => 'Complete pool remodeling services in Dallas-Fort Worth. Update tiles, coping, equipment, and surfaces. Transform your pool with expert renovation. Free quote.',
                'meta_robots' => 'index, follow',
                'is_active' => true,
                'sort_order' => 3,
            ]
        );
    }
}