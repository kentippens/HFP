<?php

namespace Database\Seeders;

use App\Models\Service;

class ServiceSeeder extends SafeSeeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'House Cleaning',
                'short_description' => 'Professional residential cleaning services that keep your home spotless and hygienic.',
                'description' => '<p>Our comprehensive house cleaning services are designed to maintain your home in pristine condition. We provide thorough cleaning of all living spaces including bedrooms, bathrooms, kitchens, and common areas.</p><p>Our trained professionals use eco-friendly products and follow systematic cleaning protocols to ensure every corner of your home receives proper attention. From deep cleaning to regular maintenance, we customize our services to meet your specific needs.</p><p>Services include: dusting, vacuuming, mopping, bathroom sanitization, kitchen cleaning, and organizing.</p>',
                'image' => 'icon-1.png',
                'meta_title' => 'Professional House Cleaning Services',
                'meta_description' => 'Expert residential cleaning services for homes. Deep cleaning, regular maintenance, and eco-friendly solutions.',
                'is_active' => true,
                'order_index' => 1
            ],
            [
                'name' => 'Commercial Cleaning',
                'short_description' => 'Specialized cleaning services for offices, retail stores, and commercial buildings.',
                'description' => '<p>Professional commercial cleaning services designed to maintain clean, healthy work environments that boost productivity and create positive impressions on clients and employees.</p><p>We understand the unique requirements of different commercial spaces and provide customized cleaning solutions for offices, retail stores, medical facilities, and industrial buildings.</p><p>Our services include: office cleaning, floor maintenance, window cleaning, restroom sanitization, break room cleaning, and waste management.</p>',
                'image' => 'icon-2.png',
                'meta_title' => 'Commercial Cleaning Services',
                'meta_description' => 'Professional commercial cleaning for offices, retail, and industrial spaces. Reliable and thorough.',
                'is_active' => true,
                'order_index' => 2
            ],
            [
                'name' => 'Carpet Cleaning',
                'short_description' => 'Deep carpet cleaning and maintenance services for residential and commercial properties.',
                'description' => '<p>Professional carpet cleaning services that remove deep-seated dirt, stains, and allergens from your carpets, extending their life and maintaining a healthy indoor environment.</p><p>We use advanced cleaning equipment and techniques including steam cleaning, dry cleaning, and stain removal treatments. Our process effectively eliminates bacteria, dust mites, and odors while being safe for your family and pets.</p><p>Services include: steam cleaning, stain removal, odor elimination, carpet protection, and upholstery cleaning.</p>',
                'image' => 'icon-3.png',
                'meta_title' => 'Professional Carpet Cleaning Services',
                'meta_description' => 'Expert carpet cleaning services. Steam cleaning, stain removal, and carpet maintenance for homes and offices.',
                'is_active' => true,
                'order_index' => 3
            ],
            [
                'name' => 'Deep Cleaning',
                'short_description' => 'Comprehensive deep cleaning services for thorough property maintenance.',
                'description' => '<p>Our deep cleaning services go beyond regular maintenance to address areas that require special attention. Perfect for move-ins, post-construction cleanup, or seasonal deep cleans.</p><p>We focus on hard-to-reach areas, detailed scrubbing, and comprehensive sanitization to restore your space to like-new condition. This service is ideal for properties that need intensive cleaning attention.</p><p>Services include: baseboards, light fixtures, inside appliances, detailed bathroom cleaning, cabinet interiors, and window tracks.</p>',
                'image' => 'icon-4.png',
                'meta_title' => 'Deep Cleaning Services',
                'meta_description' => 'Comprehensive deep cleaning for move-ins, post-construction, and seasonal maintenance.',
                'is_active' => true,
                'order_index' => 4
            ],
            [
                'name' => 'Window Cleaning',
                'short_description' => 'Professional window cleaning for crystal clear views and enhanced curb appeal.',
                'description' => '<p>Professional window cleaning services for both interior and exterior windows. We ensure streak-free, crystal clear results that enhance the appearance of your property and maximize natural light.</p><p>Our trained technicians use professional-grade equipment and techniques to safely clean windows at any height, including high-rise buildings. We also clean window frames, sills, and screens.</p><p>Services include: interior and exterior window cleaning, screen cleaning, frame cleaning, and mirror cleaning.</p>',
                'image' => 'icon-5.png',
                'meta_title' => 'Professional Window Cleaning Services',
                'meta_description' => 'Expert window cleaning for homes and businesses. Interior, exterior, and high-rise window cleaning.',
                'is_active' => true,
                'order_index' => 5
            ],
            [
                'name' => 'Post-Construction Cleaning',
                'short_description' => 'Specialized cleanup services for newly constructed or renovated properties.',
                'description' => '<p>Post-construction cleaning requires specialized knowledge and equipment to handle the unique challenges of construction debris, dust, and residue. Our team is experienced in safely cleaning construction sites and newly renovated spaces.</p><p>We remove construction dust, clean fixtures, sanitize surfaces, and prepare the space for occupancy. Our thorough approach ensures your new or renovated space is move-in ready.</p><p>Services include: debris removal, dust elimination, fixture cleaning, floor polishing, and final inspection cleanup.</p>',
                'image' => 'icon-6.png',
                'meta_title' => 'Post-Construction Cleaning Services',
                'meta_description' => 'Specialized post-construction cleanup for new builds and renovations. Professional debris removal.',
                'is_active' => true,
                'order_index' => 6
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}