<?php

namespace Database\Seeders;

use App\Models\Service;

class GutterLeafguardServiceSeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Gutter & Leaf Guard Installation',
            'slug' => 'gutter-leafguard-installation',
            'short_description' => 'Professional gutter and leaf guard installation. Never clean your gutters again! Protect your home from water damage with our premium seamless gutter systems.',
            'description' => '<p>Stop risking falls from ladder accidents. Our professional gutter and leaf guard installation service provides a permanent solution that protects your home while eliminating maintenance headaches forever. Seamless aluminum gutters paired with premium leaf guard technology ensure your home stays protected year-round.</p>',
            'image' => null,
            'breadcrumb_image' => 'images/banner.png',
            'meta_title' => 'Gutter & Leaf Guard Installation DFW | Never Clean Gutters Again | Hexagon',
            'meta_description' => 'Professional gutter & leaf guard installation in DFW. Lifetime warranty, one-day installation. Stop ladder accidents & protect your foundation. Free estimates!',
            'is_active' => true,
            'order_index' => 8,
        ]);
    }
}