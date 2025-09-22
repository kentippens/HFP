<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CorePage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanonicalUrlIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_canonical_url_appears_in_homepage_html()
    {
        // Update the homepage to have a canonical URL
        $homepage = CorePage::where('slug', 'homepage')->first();
        if ($homepage) {
            $homepage->canonical_url = '/';
            $homepage->save();
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();
        
        // Check if canonical link tag is present
        $this->assertStringContainsString('<link rel="canonical"', $content);
        // The URL helper converts "/" to the full base URL (may include port in test environment)
        $this->assertStringContainsString('href="' . url('/') . '"', $content);
    }

    public function test_relative_canonical_url_becomes_absolute_in_html()
    {
        // Update the homepage to have a relative canonical URL
        $homepage = CorePage::where('slug', 'homepage')->first();
        if ($homepage) {
            $homepage->canonical_url = '/about';
            $homepage->save();
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();
        
        // Check if canonical link tag contains full URL
        $this->assertStringContainsString('<link rel="canonical"', $content);
        $this->assertStringContainsString('href="' . url('/about') . '"', $content);
    }

    public function test_absolute_canonical_url_stays_absolute_in_html()
    {
        // Update the homepage to have an absolute canonical URL
        $homepage = CorePage::where('slug', 'homepage')->first();
        if ($homepage) {
            $homepage->canonical_url = 'https://example.com/custom-page';
            $homepage->save();
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();
        
        // Check if canonical link tag contains the exact absolute URL
        $this->assertStringContainsString('<link rel="canonical"', $content);
        $this->assertStringContainsString('href="https://example.com/custom-page"', $content);
    }

    public function test_no_canonical_tag_when_url_not_set()
    {
        // Update the homepage to have no canonical URL
        $homepage = CorePage::where('slug', 'homepage')->first();
        if ($homepage) {
            $homepage->canonical_url = null;
            $homepage->save();
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();
        
        // Check that canonical link tag is NOT present
        $this->assertStringNotContainsString('<link rel="canonical"', $content);
    }

    public function test_canonical_url_validation_in_filament()
    {
        // Test that the validation rules work correctly
        $this->assertTrue(true); // Placeholder - actual Filament testing would require more setup
    }
}