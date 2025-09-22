<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Service;
use App\Models\BlogPost;
use App\Models\LandingPage;
use App\Models\CorePage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MetaTitleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_homepage_meta_title()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check if title contains hardcoded "- Cleaning Services"
        $content = $response->getContent();
        $this->assertStringContainsString('<title>', $content);
        
        // Extract title tag content
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        $this->assertNotEmpty($title, 'Title should not be empty');
        
        // Check if it has the unwanted suffix
        if (str_contains($title, '- Cleaning Services')) {
            echo "\n❌ Homepage title has unwanted suffix: '$title'";
        } else {
            echo "\n✅ Homepage title is correct: '$title'";
        }
    }

    public function test_services_listing_meta_title()
    {
        $response = $this->get('/services');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        if (str_contains($title, '- Cleaning Services')) {
            echo "\n❌ Services listing title has unwanted suffix: '$title'";
        } else {
            echo "\n✅ Services listing title is correct: '$title'";
        }
    }

    public function test_individual_service_meta_title()
    {
        $service = Service::factory()->create([
            'title' => 'Test Cleaning Service',
            'slug' => 'test-cleaning-service',
            'meta_title' => 'Professional Test Cleaning Service',
            'is_active' => true
        ]);

        $response = $this->get('/services/' . $service->slug);
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        if (str_contains($title, '- Cleaning Services')) {
            echo "\n❌ Individual service title has unwanted suffix: '$title'";
        } else {
            echo "\n✅ Individual service title is correct: '$title'";
        }
    }

    public function test_blog_listing_meta_title()
    {
        $response = $this->get('/blog');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        if (str_contains($title, '- Cleaning Services')) {
            echo "\n❌ Blog listing title has unwanted suffix: '$title'";
        } else {
            echo "\n✅ Blog listing title is correct: '$title'";
        }
    }

    public function test_individual_blog_post_meta_title()
    {
        $post = BlogPost::factory()->create([
            'title' => 'Test Blog Post',
            'slug' => 'test-blog-post',
            'meta_title' => 'Test Blog Post Meta Title',
            'is_published' => true,
            'published_at' => now()
        ]);

        $response = $this->get('/blog/' . $post->slug);
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        if (str_contains($title, '- Cleaning Services')) {
            echo "\n❌ Individual blog post title has unwanted suffix: '$title'";
        } else {
            echo "\n✅ Individual blog post title is correct: '$title'";
        }
    }

    public function test_contact_page_meta_title()
    {
        $response = $this->get('/contact');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        if (str_contains($title, '- Cleaning Services')) {
            echo "\n❌ Contact page title has unwanted suffix: '$title'";
        } else {
            echo "\n✅ Contact page title is correct: '$title'";
        }
    }

    public function test_about_page_meta_title()
    {
        $response = $this->get('/about');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        if (str_contains($title, '- Cleaning Services')) {
            echo "\n❌ About page title has unwanted suffix: '$title'";
        } else {
            echo "\n✅ About page title is correct: '$title'";
        }
    }

    public function test_landing_page_meta_title()
    {
        $landingPage = LandingPage::factory()->create([
            'title' => 'Test Landing Page',
            'slug' => 'test-landing-page',
            'meta_title' => 'Test Landing Page Meta Title',
            'is_active' => true
        ]);

        $response = $this->get('/lp/' . $landingPage->slug);
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        if (str_contains($title, '- Cleaning Services')) {
            echo "\n❌ Landing page title has unwanted suffix: '$title'";
        } else {
            echo "\n✅ Landing page title is correct: '$title'";
        }
    }

    public function test_core_page_meta_title_handling()
    {
        // Test with a core page that has meta_title set
        $corePage = CorePage::create([
            'slug' => 'test-core-page',
            'meta_title' => 'Custom Core Page Title',
            'meta_description' => 'Test description',
            'is_active' => true,
            'include_in_sitemap' => true
        ]);

        // Simulate getting SEO data like the controllers do
        $seoData = \App\Models\CorePage::getBySlug('test-core-page');
        
        $this->assertNotNull($seoData);
        $this->assertEquals('Custom Core Page Title', $seoData->meta_title);
    }

    public function test_fallback_meta_title_handling()
    {
        // Test when no core page exists, should use fallback
        $seoData = \App\Models\CorePage::getBySlug('non-existent-page');
        
        $this->assertNull($seoData);
        
        // Test controller getSeoData method
        $controller = new \App\Http\Controllers\HomeController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('getSeoData');
        $method->setAccessible(true);
        
        $result = $method->invokeArgs($controller, ['test-page', ['meta_title' => 'Test Title']]);
        
        $this->assertEquals('Test Title', $result->meta_title);
    }

    public function test_meta_title_structure_consistency()
    {
        // Test multiple pages to see the pattern
        $pages = [
            '/' => 'Homepage',
            '/services' => 'Services listing',
            '/blog' => 'Blog listing',
            '/contact' => 'Contact page',
            '/about' => 'About page'
        ];

        echo "\n\n📋 Meta Title Analysis:";
        echo "\n" . str_repeat("=", 60);

        foreach ($pages as $url => $description) {
            $response = $this->get($url);
            
            if ($response->status() === 200) {
                $content = $response->getContent();
                preg_match('/<title>(.*?)<\/title>/', $content, $matches);
                $title = $matches[1] ?? 'NO TITLE FOUND';
                
                $hasSuffix = str_contains($title, '- Cleaning Services');
                $status = $hasSuffix ? '❌' : '✅';
                
                echo "\n$status $description: '$title'";
            } else {
                echo "\n❓ $description: HTTP {$response->status()}";
            }
        }
        
        echo "\n" . str_repeat("=", 60);
    }
}