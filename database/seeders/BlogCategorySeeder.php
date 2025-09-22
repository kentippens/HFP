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
                'name' => 'House Cleaning',
                'slug' => 'house-cleaning',
                'description' => 'Tips, tricks, and insights about residential cleaning services',
                'meta_title' => 'House Cleaning Tips & Services | Hexagon Service Solutions',
                'meta_description' => 'Expert house cleaning tips, guides, and professional services information from Hexagon Service Solutions.',
                'is_active' => true,
                'order_index' => 1,
            ],
            [
                'name' => 'Commercial Cleaning',
                'slug' => 'commercial-cleaning',
                'description' => 'Information about commercial and office cleaning services',
                'meta_title' => 'Commercial Cleaning Services & Tips | Hexagon Service Solutions',
                'meta_description' => 'Professional commercial cleaning insights, industry standards, and service information.',
                'is_active' => true,
                'order_index' => 2,
            ],
            [
                'name' => 'Carpet Cleaning',
                'slug' => 'carpet-cleaning',
                'description' => 'Everything about carpet care, maintenance, and professional cleaning',
                'meta_title' => 'Carpet Cleaning Guide & Services | Hexagon Service Solutions',
                'meta_description' => 'Learn about professional carpet cleaning techniques, maintenance tips, and our services.',
                'is_active' => true,
                'order_index' => 3,
            ],
            [
                'name' => 'Pool Cleaning',
                'slug' => 'pool-cleaning',
                'description' => 'Pool maintenance, cleaning tips, and service information',
                'meta_title' => 'Pool Cleaning & Maintenance | Hexagon Service Solutions',
                'meta_description' => 'Expert pool cleaning advice, maintenance schedules, and professional service information.',
                'is_active' => true,
                'order_index' => 4,
            ],
            [
                'name' => 'Window Cleaning',
                'slug' => 'window-cleaning',
                'description' => 'Professional window cleaning techniques and service insights',
                'meta_title' => 'Window Cleaning Services & Tips | Hexagon Service Solutions',
                'meta_description' => 'Discover professional window cleaning methods, safety tips, and service options.',
                'is_active' => true,
                'order_index' => 5,
            ],
            [
                'name' => 'Deep Cleaning',
                'slug' => 'deep-cleaning',
                'description' => 'Comprehensive deep cleaning guides and service information',
                'meta_title' => 'Deep Cleaning Services & Guides | Hexagon Service Solutions',
                'meta_description' => 'Everything you need to know about deep cleaning services and techniques.',
                'is_active' => true,
                'order_index' => 6,
            ],
            [
                'name' => 'Green Cleaning',
                'slug' => 'green-cleaning',
                'description' => 'Eco-friendly cleaning methods and sustainable practices',
                'meta_title' => 'Green Cleaning Solutions | Hexagon Service Solutions',
                'meta_description' => 'Learn about eco-friendly cleaning products, methods, and sustainable cleaning practices.',
                'is_active' => true,
                'order_index' => 7,
            ],
            [
                'name' => 'Cleaning Tips',
                'slug' => 'cleaning-tips',
                'description' => 'General cleaning tips, hacks, and advice for all situations',
                'meta_title' => 'Cleaning Tips & Tricks | Hexagon Service Solutions',
                'meta_description' => 'Discover helpful cleaning tips, tricks, and expert advice for maintaining a clean space.',
                'is_active' => true,
                'order_index' => 8,
            ],
            [
                'name' => 'Industry News',
                'slug' => 'industry-news',
                'description' => 'Latest news and updates from the cleaning industry',
                'meta_title' => 'Cleaning Industry News | Hexagon Service Solutions',
                'meta_description' => 'Stay updated with the latest cleaning industry news, trends, and innovations.',
                'is_active' => true,
                'order_index' => 9,
            ],
            [
                'name' => 'General',
                'slug' => 'general',
                'description' => 'General updates and information about our services',
                'meta_title' => 'General Updates | Hexagon Service Solutions',
                'meta_description' => 'General news, updates, and information from Hexagon Service Solutions.',
                'is_active' => true,
                'order_index' => 10,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }
    }
}