<?php

namespace Database\Seeders;

use App\Models\Service;

class VinylFenceServiceSeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Vinyl Fence Installation',
            'slug' => 'vinyl-fence-installation',
            'short_description' => 'Professional vinyl fence installation services. Beautiful, durable fencing that enhances your property value with zero maintenance required.',
            'description' => '<p>Looking for a beautiful, durable fence that will enhance your property value while providing years of maintenance-free enjoyment? Our professional vinyl fence installation services deliver superior quality, expert craftsmanship, and unmatched durability that wood simply can\'t match.</p>',
            'image' => 'icon-7.png',
            'breadcrumb_image' => 'images/banner.png',
            'meta_title' => 'Vinyl Fence Installation - Professional Fencing Services | Hexagon Service Solutions',
            'meta_description' => 'Professional vinyl fence installation in DFW. Lifetime warranty, maintenance-free, and beautiful designs. Privacy, semi-privacy, and picket styles available. Free estimates!',
            'is_active' => true,
            'order_index' => 7,
        ]);
    }
}