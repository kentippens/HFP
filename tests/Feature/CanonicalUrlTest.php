<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CorePage;
use App\Rules\ValidCanonicalUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

class CanonicalUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_relative_canonical_urls()
    {
        $validUrls = [
            '/',
            '/about',
            '/services',
            '/services/cleaning',
            '/blog/post-title',
            '/contact-us',
            '/privacy-policy',
        ];

        foreach ($validUrls as $url) {
            $rule = new ValidCanonicalUrl();
            $validator = Validator::make(['canonical_url' => $url], ['canonical_url' => $rule]);
            
            $this->assertFalse($validator->fails(), "URL '$url' should be valid but failed validation");
        }
    }

    public function test_valid_absolute_canonical_urls()
    {
        $validUrls = [
            'https://example.com',
            'https://example.com/',
            'https://example.com/about',
            'https://www.example.com/services',
            'http://localhost:3000/test',
            'https://subdomain.example.co.uk/path/to/page',
        ];

        foreach ($validUrls as $url) {
            $rule = new ValidCanonicalUrl();
            $validator = Validator::make(['canonical_url' => $url], ['canonical_url' => $rule]);
            
            $this->assertFalse($validator->fails(), "URL '$url' should be valid but failed validation");
        }
    }

    public function test_invalid_canonical_urls()
    {
        $invalidUrls = [
            'about',           // Missing leading slash for relative
            'relative/path',   // Missing leading slash
            '/about/',         // Trailing slash (except root)
            '/services/',      // Trailing slash
            '//double/slash',  // Double slash
            '/path//double',   // Double slash in middle
            'ftp://example.com', // Non-HTTP protocol
            'javascript:void(0)', // JavaScript protocol
            '/path with spaces', // Spaces
            '/path<script>',   // Invalid characters
            '/path&param=value', // Query parameters (should be avoided in canonical)
        ];

        foreach ($invalidUrls as $url) {
            $rule = new ValidCanonicalUrl();
            $validator = Validator::make(['canonical_url' => $url], ['canonical_url' => $rule]);
            
            $this->assertTrue($validator->fails(), "URL '$url' should be invalid but passed validation");
        }
    }

    public function test_empty_canonical_url_is_valid()
    {
        $rule = new ValidCanonicalUrl();
        $validator = Validator::make(['canonical_url' => ''], ['canonical_url' => $rule]);
        
        $this->assertFalse($validator->fails(), "Empty canonical URL should be valid");
        
        $validator = Validator::make(['canonical_url' => null], ['canonical_url' => $rule]);
        
        $this->assertFalse($validator->fails(), "Null canonical URL should be valid");
    }

    public function test_whitespace_is_trimmed()
    {
        $urlsWithWhitespace = [
            ' /about ',
            "\t/services\t",
            "\n/contact\n",
            ' https://example.com/path ',
        ];

        foreach ($urlsWithWhitespace as $url) {
            $rule = new ValidCanonicalUrl();
            $validator = Validator::make(['canonical_url' => $url], ['canonical_url' => $rule]);
            
            $this->assertFalse($validator->fails(), "URL '$url' should be valid after trimming whitespace");
        }
    }

    public function test_core_page_canonical_url_validation()
    {
        // Test valid canonical URL creation
        $validPage = CorePage::create([
            'name' => 'Test Page',
            'slug' => 'test-page',
            'meta_title' => 'Test Page Title',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'canonical_url' => '/',
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);

        $this->assertNotNull($validPage);
        $this->assertEquals('/', $validPage->canonical_url);
    }

    public function test_core_page_invalid_canonical_url_fails()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        CorePage::create([
            'name' => 'Test Page',
            'slug' => 'test-page-invalid',
            'meta_title' => 'Test Page Title',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'canonical_url' => 'invalid-url-without-slash',
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);
    }

    public function test_canonical_url_appears_in_html_output()
    {
        // Create a core page with canonical URL
        CorePage::create([
            'name' => 'Test Page',
            'slug' => 'homepage',
            'meta_title' => 'Test Home Page',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'canonical_url' => '/',
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();
        
        // Check if canonical link tag is present
        $this->assertStringContainsString('<link rel="canonical"', $content);
        $this->assertStringContainsString('href="/"', $content);
    }

    public function test_no_canonical_tag_when_url_not_set()
    {
        // Create a core page without canonical URL
        CorePage::create([
            'name' => 'Test Page',
            'slug' => 'homepage',
            'meta_title' => 'Test Home Page',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'canonical_url' => null,
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();
        
        // Check that canonical link tag is NOT present
        $this->assertStringNotContainsString('<link rel="canonical"', $content);
    }

    public function test_relative_canonical_url_is_absolute_in_output()
    {
        // Create a core page with relative canonical URL
        CorePage::create([
            'name' => 'Test Page',
            'slug' => 'homepage',
            'meta_title' => 'Test Home Page',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'canonical_url' => '/about',
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();
        
        // Check if canonical link tag contains full URL
        $this->assertStringContainsString('<link rel="canonical"', $content);
        $this->assertStringContainsString('href="http://localhost/about"', $content);
    }

    public function test_absolute_canonical_url_stays_absolute_in_output()
    {
        // Create a core page with absolute canonical URL
        CorePage::create([
            'name' => 'Test Page',
            'slug' => 'homepage',
            'meta_title' => 'Test Home Page',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'canonical_url' => 'https://example.com/custom-page',
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();
        
        // Check if canonical link tag contains the exact absolute URL
        $this->assertStringContainsString('<link rel="canonical"', $content);
        $this->assertStringContainsString('href="https://example.com/custom-page"', $content);
    }

    public function test_canonical_url_validation_error_messages()
    {
        $rule = new ValidCanonicalUrl();
        
        // Test invalid relative URL
        $validator = Validator::make(['canonical_url' => 'no-slash'], ['canonical_url' => $rule]);
        $this->assertTrue($validator->fails());
        $this->assertStringContainsString('must start with /', $validator->errors()->first('canonical_url'));
        
        // Test double slash
        $validator = Validator::make(['canonical_url' => '/path//double'], ['canonical_url' => $rule]);
        $this->assertTrue($validator->fails());
        $this->assertStringContainsString('cannot contain double slashes', $validator->errors()->first('canonical_url'));
        
        // Test trailing slash
        $validator = Validator::make(['canonical_url' => '/about/'], ['canonical_url' => $rule]);
        $this->assertTrue($validator->fails());
        $this->assertStringContainsString('should not end with a trailing slash', $validator->errors()->first('canonical_url'));
        
        // Test non-HTTP protocol
        $validator = Validator::make(['canonical_url' => 'ftp://example.com'], ['canonical_url' => $rule]);
        $this->assertTrue($validator->fails());
        $this->assertStringContainsString('HTTP or HTTPS URL', $validator->errors()->first('canonical_url'));
    }
}