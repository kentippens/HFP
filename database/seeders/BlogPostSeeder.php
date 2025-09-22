<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogPostSeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Essential House Cleaning Tips for Busy Families',
                'category' => 'House Cleaning',
                'author' => 'Sarah Johnson',
                'excerpt' => 'Quality service begins with quality people. Each professional cleaner receives extensive, ongoing training in product and equipment usage, cleaning & maintenance methodologies, safety procedures. You can count on prompt and courteous attention.',
                'content' => '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English.</p>
                <p>Professional cleaning requires specialized knowledge and equipment. Our certified operators use industry-leading techniques to maintain clean, healthy environments that boost productivity and satisfaction.</p>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.</p>
                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p>',
                'featured_image' => 'blog-1.jpg',
                'thumbnail' => 'blog-1-thumb.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'Our Proprietary Methods Enable Quality Commercial Cleaning',
                'category' => 'Commercial Cleaning',
                'author' => 'Mike Wilson',
                'excerpt' => 'Professional commercial cleaning requires specialized knowledge and equipment. Our certified operators use industry-leading techniques to maintain clean, healthy work environments that boost productivity and employee satisfaction.',
                'content' => '<p>Commercial cleaning goes beyond simple maintenance. It requires understanding of different materials, traffic patterns, and industry-specific requirements that ensure optimal cleanliness and hygiene standards.</p>
                <p>Our team uses state-of-the-art equipment and eco-friendly cleaning products to deliver exceptional results while maintaining environmental responsibility.</p>
                <p>We customize our cleaning schedules to minimize disruption to your business operations, offering flexible timing options including after-hours and weekend services.</p>',
                'featured_image' => 'blog-2.jpg',
                'thumbnail' => 'blog-2-thumb.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Locate Our Professional Carpet Cleaning Services Near You',
                'category' => 'Carpet Cleaning',
                'author' => 'Jennifer Martinez',
                'excerpt' => 'Deep cleaning goes beyond surface cleaning to eliminate hidden dirt, bacteria, and allergens. Our comprehensive deep cleaning services restore your space to its original cleanliness and create a healthier living environment.',
                'content' => '<p>Deep cleaning is essential for maintaining a healthy home or workplace. Our thorough approach addresses areas often overlooked in regular cleaning routines.</p>
                <p>We focus on high-touch surfaces, hidden corners, and hard-to-reach areas where dust and allergens accumulate over time.</p>
                <p>Our deep cleaning services include carpet shampooing, upholstery cleaning, window washing, and detailed sanitization of all surfaces.</p>',
                'featured_image' => 'blog-3.jpg',
                'thumbnail' => 'blog-3-thumb.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'Visit Our Office and See Our Eco-Friendly Cleaning Solutions',
                'category' => 'General',
                'author' => 'David Green',
                'excerpt' => 'Environmental responsibility is at the core of our cleaning philosophy. We use eco-friendly products and sustainable practices that protect your family, pets, and the planet while delivering exceptional cleaning results.',
                'content' => '<p>Our commitment to environmental sustainability drives us to continuously research and implement the latest eco-friendly cleaning solutions.</p>
                <p>We use biodegradable products, microfiber technology, and water-efficient cleaning methods to minimize our environmental impact.</p>
                <p>Green cleaning doesn\'t mean compromising on effectiveness. Our eco-friendly approach delivers the same high-quality results you expect.</p>',
                'featured_image' => 'blog-4.jpg',
                'thumbnail' => 'blog-4-thumb.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'How to Stay Organized with Regular Maintenance Cleaning',
                'category' => 'General',
                'author' => 'Emily Thompson',
                'excerpt' => 'Regular maintenance cleaning is the key to keeping your space consistently clean and organized. Learn our professional tips and schedules that help busy homeowners and business owners maintain pristine environments.',
                'content' => '<p>Creating and sticking to a regular cleaning schedule is essential for maintaining a clean and organized space.</p>
                <p>We recommend dividing tasks into daily, weekly, and monthly categories to make maintenance more manageable.</p>
                <p>Our professional maintenance programs are designed to keep your space consistently clean without the stress of managing it yourself.</p>',
                'featured_image' => 'blog-5.jpg',
                'thumbnail' => 'blog-5-thumb.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'The Benefits of Professional Office Cleaning Services',
                'category' => 'Commercial Cleaning',
                'author' => 'Robert Johnson',
                'excerpt' => 'A clean office environment boosts employee productivity, reduces sick days, and creates a positive impression on clients. Discover how professional cleaning services can transform your workplace.',
                'content' => '<p>Studies show that clean workplaces lead to increased employee satisfaction and productivity. Our professional office cleaning services ensure your workspace supports your business goals.</p>
                <p>We provide comprehensive cleaning solutions including daily maintenance, periodic deep cleaning, and specialized services for medical and industrial facilities.</p>
                <p>Our flexible scheduling and customized cleaning plans ensure minimal disruption to your business operations while maintaining the highest standards of cleanliness.</p>',
                'featured_image' => 'blog-1.jpg',
                'thumbnail' => 'blog-1-thumb.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create($post);
        }
    }
}
