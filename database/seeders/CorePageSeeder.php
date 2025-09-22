<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CorePage;

class CorePageSeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->logSeeding('Starting CorePageSeeder');
        
        $corePages = [
            [
                'name' => 'Homepage',
                'slug' => 'homepage',
                'meta_title' => 'Professional Cleaning Services - Your Trusted Partner',
                'meta_description' => 'Professional cleaning and maintenance services for homes and businesses. Quality service, competitive prices, and customer satisfaction guaranteed.',
                'canonical_url' => url('/'),
                'is_active' => true,
            ],
            [
                'name' => 'Services',
                'slug' => 'services',
                'meta_title' => 'Our Services - Professional Cleaning Solutions',
                'meta_description' => 'Explore our comprehensive range of professional cleaning and maintenance services. From residential to commercial cleaning solutions.',
                'canonical_url' => url('/services'),
                'is_active' => true,
            ],
            [
                'name' => 'About',
                'slug' => 'about',
                'meta_title' => 'About Us - Professional Cleaning Experts',
                'meta_description' => 'Learn about our professional cleaning company, our experienced team, and our commitment to providing exceptional service.',
                'canonical_url' => url('/about'),
                'is_active' => true,
            ],
            [
                'name' => 'Contact',
                'slug' => 'contact',
                'meta_title' => 'Contact Us - Get Your Free Cleaning Quote',
                'meta_description' => 'Get in touch with our professional cleaning team. Request a free quote or schedule your cleaning service today.',
                'canonical_url' => url('/contact'),
                'is_active' => true,
            ],
        ];

        foreach ($corePages as $page) {
            CorePage::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
            $this->command->info("✅ Processed core page: {$page['name']}");
        }
        
        $this->logSeeding('Completed CorePageSeeder', 'Processed ' . count($corePages) . ' core pages');
    }
}
