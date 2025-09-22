<?php

namespace Database\Seeders;

use App\Models\CorePage;

class AdditionalCorePagesSeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'name' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'meta_title' => 'Privacy Policy | Hexagon Service Solutions',
                'meta_description' => 'Learn how Hexagon Service Solutions protects your privacy and handles your personal information. Our commitment to data security and customer privacy.',
                'meta_robots' => 'index, follow',
                'include_in_sitemap' => true,
                'is_active' => true,
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => 'Privacy Policy',
                    'description' => 'Privacy Policy for Hexagon Service Solutions',
                    'url' => url('/privacy-policy'),
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'Hexagon Service Solutions',
                        'url' => url('/')
                    ]
                ])
            ],
            [
                'name' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'meta_title' => 'Terms of Service | Hexagon Service Solutions',
                'meta_description' => 'Read the terms and conditions for using Hexagon Service Solutions services. Our service agreement and customer responsibilities.',
                'meta_robots' => 'index, follow',
                'include_in_sitemap' => true,
                'is_active' => true,
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => 'Terms of Service',
                    'description' => 'Terms of Service for Hexagon Service Solutions',
                    'url' => url('/terms-of-service'),
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'Hexagon Service Solutions',
                        'url' => url('/')
                    ]
                ])
            ],
            [
                'name' => 'Investor Relations',
                'slug' => 'investor-relations',
                'meta_title' => 'Investor Relations | Hexagon Service Solutions',
                'meta_description' => 'Explore investment opportunities with Hexagon Service Solutions. Financial information, growth strategy, and investor resources.',
                'meta_robots' => 'index, follow',
                'include_in_sitemap' => true,
                'is_active' => true,
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => 'Investor Relations',
                    'description' => 'Investor Relations information for Hexagon Service Solutions',
                    'url' => url('/investor-relations'),
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'Hexagon Service Solutions',
                        'url' => url('/')
                    ]
                ])
            ]
        ];

        foreach ($pages as $pageData) {
            // Check if page already exists
            $existingPage = CorePage::where('slug', $pageData['slug'])->first();
            
            if (!$existingPage) {
                CorePage::create($pageData);
                $this->command->info("Created core page: {$pageData['name']}");
            } else {
                // Update existing page with new data
                $existingPage->update($pageData);
                $this->command->info("Updated existing core page: {$pageData['name']}");
            }
        }
    }
}