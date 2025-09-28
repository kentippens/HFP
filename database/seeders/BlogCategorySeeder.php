<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogCategorySeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pool Resurfacing',
                'slug' => 'pool-resurfacing',
                'description' => 'Expert guides on fiberglass, plaster, and pebble pool resurfacing techniques',
                'meta_title' => 'Pool Resurfacing Tips & Guides | Hexagon Fiberglass Pools',
                'meta_description' => 'Learn about pool resurfacing options, costs, and professional techniques from industry experts.',
                'is_active' => true,
                'order_index' => 1,
            ],
            [
                'name' => 'Pool Conversions',
                'slug' => 'pool-conversions',
                'description' => 'Converting vinyl liner and concrete pools to modern fiberglass',
                'meta_title' => 'Pool Conversion Guides | Fiberglass Pool Conversions',
                'meta_description' => 'Everything about converting traditional pools to durable fiberglass pool systems.',
                'is_active' => true,
                'order_index' => 2,
            ],
            [
                'name' => 'Pool Remodeling',
                'slug' => 'pool-remodeling',
                'description' => 'Pool renovation ideas, design trends, and remodeling projects',
                'meta_title' => 'Pool Remodeling Ideas & Inspiration | Pool Renovation',
                'meta_description' => 'Discover pool remodeling ideas, latest design trends, and renovation tips.',
                'is_active' => true,
                'order_index' => 3,
            ],
            [
                'name' => 'Pool Repair',
                'slug' => 'pool-repair',
                'description' => 'Pool repair solutions for cracks, leaks, and structural issues',
                'meta_title' => 'Pool Repair Solutions & Tips | Expert Pool Repair',
                'meta_description' => 'Professional pool repair advice for cracks, leaks, equipment, and structural problems.',
                'is_active' => true,
                'order_index' => 4,
            ],
            [
                'name' => 'Pool Maintenance',
                'slug' => 'pool-maintenance',
                'description' => 'Pool care tips, maintenance schedules, and water chemistry',
                'meta_title' => 'Pool Maintenance Guide | Pool Care Tips',
                'meta_description' => 'Essential pool maintenance tips, cleaning schedules, and water chemistry guides.',
                'is_active' => true,
                'order_index' => 5,
            ],
            [
                'name' => 'Fiberglass Pools',
                'slug' => 'fiberglass-pools',
                'description' => 'Benefits, installation, and care of fiberglass pool systems',
                'meta_title' => 'Fiberglass Pool Guide | Benefits & Installation',
                'meta_description' => 'Learn about fiberglass pool advantages, installation process, and long-term benefits.',
                'is_active' => true,
                'order_index' => 6,
            ],
            [
                'name' => 'Pool Design',
                'slug' => 'pool-design',
                'description' => 'Pool design trends, features, and landscaping ideas',
                'meta_title' => 'Pool Design Ideas & Trends | Modern Pool Features',
                'meta_description' => 'Explore modern pool design trends, water features, and landscaping ideas.',
                'is_active' => true,
                'order_index' => 7,
            ],
            [
                'name' => 'Pool Safety',
                'slug' => 'pool-safety',
                'description' => 'Pool safety equipment, regulations, and best practices',
                'meta_title' => 'Pool Safety Guide | Safety Equipment & Tips',
                'meta_description' => 'Important pool safety information, equipment recommendations, and compliance guidelines.',
                'is_active' => true,
                'order_index' => 8,
            ],
            [
                'name' => 'Industry News',
                'slug' => 'industry-news',
                'description' => 'Latest news and updates from the pool industry',
                'meta_title' => 'Pool Industry News & Updates | Pool Trends',
                'meta_description' => 'Stay updated with the latest pool industry news, innovations, and market trends.',
                'is_active' => true,
                'order_index' => 9,
            ],
            [
                'name' => 'General',
                'slug' => 'general',
                'description' => 'General updates and company announcements',
                'meta_title' => 'Company Updates | Hexagon Fiberglass Pools News',
                'meta_description' => 'General news, updates, and announcements from Hexagon Fiberglass Pools.',
                'is_active' => true,
                'order_index' => 10,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::updateOrCreate(
                ['slug' => $category['slug']], // Match by slug
                $category // Update with new data
            );
        }
    }
}