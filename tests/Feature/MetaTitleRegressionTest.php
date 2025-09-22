<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MetaTitleRegressionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test that no pages have unwanted "- Cleaning Services" suffix
     * This test prevents regression of the meta title issue
     */
    public function test_no_pages_have_unwanted_cleaning_services_suffix()
    {
        $pages = [
            '/' => 'Homepage',
            '/services' => 'Services listing',
            '/contact' => 'Contact page',
            '/about' => 'About page'
        ];

        $failedPages = [];

        foreach ($pages as $url => $description) {
            $response = $this->get($url);
            
            if ($response->status() === 200) {
                $content = $response->getContent();
                preg_match('/<title>(.*?)<\/title>/', $content, $matches);
                $title = $matches[1] ?? '';
                
                // Check for the unwanted suffix
                if (str_contains($title, '- Cleaning Services')) {
                    $failedPages[] = [
                        'url' => $url,
                        'description' => $description,
                        'title' => $title
                    ];
                }
            }
        }

        $this->assertEmpty($failedPages, 
            'Found pages with unwanted "- Cleaning Services" suffix: ' . 
            json_encode($failedPages, JSON_PRETTY_PRINT)
        );
    }

    /**
     * Test that meta titles are properly set from database or fallbacks
     */
    public function test_meta_titles_are_properly_set()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        // Homepage should have a meaningful title, not just app name
        $this->assertNotEquals('Laravel', $title);
        $this->assertNotEmpty($title);
        $this->assertStringContainsString('Professional Cleaning Services', $title);
    }

    /**
     * Test that services page has correct title structure
     */
    public function test_services_page_meta_title()
    {
        $response = $this->get('/services');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        $this->assertStringContainsString('Services', $title);
        $this->assertStringNotContainsString('- Cleaning Services', $title);
    }

    /**
     * Test that contact page has correct title structure
     */
    public function test_contact_page_meta_title()
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        $this->assertStringContainsString('Contact', $title);
        $this->assertStringNotContainsString('- Cleaning Services', $title);
    }

    /**
     * Test that about page has correct title structure
     */
    public function test_about_page_meta_title()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $title = $matches[1] ?? '';
        
        $this->assertStringContainsString('About', $title);
        $this->assertStringNotContainsString('- Cleaning Services', $title);
    }

    /**
     * Test that meta titles don't have double suffixes or redundant text
     */
    public function test_meta_titles_dont_have_redundant_text()
    {
        $pages = ['/', '/services', '/contact', '/about'];
        
        foreach ($pages as $url) {
            $response = $this->get($url);
            
            if ($response->status() === 200) {
                $content = $response->getContent();
                preg_match('/<title>(.*?)<\/title>/', $content, $matches);
                $title = $matches[1] ?? '';
                
                // Check for common redundancy patterns
                $this->assertStringNotContainsString('- Cleaning Services - Cleaning Services', $title);
                $this->assertStringNotContainsString('Laravel - Cleaning Services', $title);
                $this->assertStringNotContainsString('- -', $title);
                
                // Title should not be excessively long
                $this->assertLessThan(100, strlen($title), 
                    "Title for $url is too long: '$title'"
                );
            }
        }
    }
}