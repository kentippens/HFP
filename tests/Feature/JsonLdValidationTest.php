<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CorePage;
use App\Rules\ValidJsonLd;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

class JsonLdValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_json_ld_strings()
    {
        $validJsonLd = [
            '{"@context": "https://schema.org", "@type": "Organization", "name": "Test Business"}',
            '{"@context": "https://schema.org", "@type": "LocalBusiness", "name": "Cleaning Service", "address": {"@type": "PostalAddress", "streetAddress": "123 Main St"}}',
            '[{"@context": "https://schema.org", "@type": "Organization", "name": "Test"}, {"@context": "https://schema.org", "@type": "WebSite", "url": "https://example.com"}]',
        ];

        foreach ($validJsonLd as $jsonLd) {
            $rule = new ValidJsonLd();
            $validator = Validator::make(['json_ld' => $jsonLd], ['json_ld' => $rule]);
            
            $this->assertFalse($validator->fails(), "JSON-LD should be valid: " . $jsonLd);
        }
    }

    public function test_valid_json_ld_arrays()
    {
        $validJsonLdArrays = [
            ["@context" => "https://schema.org", "@type" => "Organization", "name" => "Test Business"],
            [
                ["@context" => "https://schema.org", "@type" => "Organization", "name" => "Test"],
                ["@context" => "https://schema.org", "@type" => "WebSite", "url" => "https://example.com"]
            ],
        ];

        foreach ($validJsonLdArrays as $jsonLd) {
            $rule = new ValidJsonLd();
            $validator = Validator::make(['json_ld' => $jsonLd], ['json_ld' => $rule]);
            
            $this->assertFalse($validator->fails(), "JSON-LD array should be valid: " . json_encode($jsonLd));
        }
    }

    public function test_invalid_json_strings()
    {
        $invalidJson = [
            '{"@context": "https://schema.org", "@type": "Organization", "name": "Test Business"', // Missing closing brace
            '{"@context": "https://schema.org" "@type": "Organization"}', // Missing comma
            'not json at all',
            '{"invalid": "no context or type"}',
        ];

        foreach ($invalidJson as $jsonLd) {
            $rule = new ValidJsonLd();
            $validator = Validator::make(['json_ld' => $jsonLd], ['json_ld' => $rule]);
            
            $this->assertTrue($validator->fails(), "JSON-LD should be invalid: " . $jsonLd);
        }
    }

    public function test_json_ld_missing_required_properties()
    {
        $invalidJsonLd = [
            '{"name": "Test Business"}', // Missing @context and @type
            '{"@context": "https://schema.org"}', // Missing @type
            '{"@type": "Organization"}', // Missing @context
            '[{"@context": "https://schema.org"}]', // Array with missing @type
        ];

        foreach ($invalidJsonLd as $jsonLd) {
            $rule = new ValidJsonLd();
            $validator = Validator::make(['json_ld' => $jsonLd], ['json_ld' => $rule]);
            
            $this->assertTrue($validator->fails(), "JSON-LD should be invalid (missing required properties): " . $jsonLd);
        }
    }

    public function test_empty_json_ld_is_valid()
    {
        $rule = new ValidJsonLd();
        
        $validator = Validator::make(['json_ld' => ''], ['json_ld' => $rule]);
        $this->assertFalse($validator->fails(), "Empty JSON-LD should be valid");
        
        $validator = Validator::make(['json_ld' => null], ['json_ld' => $rule]);
        $this->assertFalse($validator->fails(), "Null JSON-LD should be valid");
    }

    public function test_json_ld_context_validation()
    {
        // Valid contexts
        $validContexts = [
            '{"@context": "https://schema.org", "@type": "Organization", "name": "Test"}',
            '{"@context": ["https://schema.org", "https://example.com/context"], "@type": "Organization", "name": "Test"}',
        ];

        foreach ($validContexts as $jsonLd) {
            $rule = new ValidJsonLd();
            $validator = Validator::make(['json_ld' => $jsonLd], ['json_ld' => $rule]);
            
            $this->assertFalse($validator->fails(), "JSON-LD with valid context should pass: " . $jsonLd);
        }

        // Invalid contexts
        $invalidContexts = [
            '{"@context": "not-a-url", "@type": "Organization", "name": "Test"}',
            '{"@context": 123, "@type": "Organization", "name": "Test"}',
        ];

        foreach ($invalidContexts as $jsonLd) {
            $rule = new ValidJsonLd();
            $validator = Validator::make(['json_ld' => $jsonLd], ['json_ld' => $rule]);
            
            $this->assertTrue($validator->fails(), "JSON-LD with invalid context should fail: " . $jsonLd);
        }
    }

    public function test_core_page_json_ld_with_string_input()
    {
        $validJsonLd = '{"@context": "https://schema.org", "@type": "Organization", "name": "Test Business"}';

        $page = CorePage::create([
            'name' => 'Test Page',
            'slug' => 'test-page-json',
            'meta_title' => 'Test Page',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'json_ld' => $validJsonLd,
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);

        $this->assertNotNull($page);
        $this->assertNotNull($page->json_ld);
        
        // The json_ld should be cast to an array
        $this->assertIsArray($page->json_ld);
        $this->assertEquals('https://schema.org', $page->json_ld['@context']);
        $this->assertEquals('Organization', $page->json_ld['@type']);
    }

    public function test_core_page_json_ld_with_array_input()
    {
        $validJsonLdArray = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => "Test Business"
        ];

        $page = CorePage::create([
            'name' => 'Test Page',
            'slug' => 'test-page-json-array',
            'meta_title' => 'Test Page',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'json_ld' => $validJsonLdArray,
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);

        $this->assertNotNull($page);
        $this->assertNotNull($page->json_ld);
        
        // The json_ld should remain as an array
        $this->assertIsArray($page->json_ld);
        $this->assertEquals('https://schema.org', $page->json_ld['@context']);
        $this->assertEquals('Organization', $page->json_ld['@type']);
    }

    public function test_core_page_invalid_json_ld_fails()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        CorePage::create([
            'name' => 'Test Page',
            'slug' => 'test-page-invalid-json',
            'meta_title' => 'Test Page',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'json_ld' => '{"invalid": "json without required properties"}',
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);
    }

    public function test_json_ld_string_accessor()
    {
        $jsonLdData = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => "Test Business"
        ];

        $page = CorePage::create([
            'name' => 'Test Page',
            'slug' => 'test-page-accessor',
            'meta_title' => 'Test Page',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'json_ld' => $jsonLdData,
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);

        $jsonLdString = $page->json_ld_string;
        
        $this->assertNotNull($jsonLdString);
        $this->assertIsString($jsonLdString);
        $this->assertStringContainsString('"@context": "https://schema.org"', $jsonLdString);
        $this->assertStringContainsString('"@type": "Organization"', $jsonLdString);
        $this->assertStringContainsString('"name": "Test Business"', $jsonLdString);
    }

    public function test_multiple_json_ld_schemas_with_graph()
    {
        $multipleSchemas = [
            [
                "@context" => "https://schema.org",
                "@type" => "Organization",
                "name" => "Test Business"
            ],
            [
                "@context" => "https://schema.org",
                "@type" => "WebSite",
                "url" => "https://example.com"
            ]
        ];

        $page = CorePage::create([
            'name' => 'Test Page',
            'slug' => 'test-page-multiple',
            'meta_title' => 'Test Page',
            'meta_description' => 'Test description',
            'meta_robots' => 'index, follow',
            'json_ld' => $multipleSchemas,
            'is_active' => true,
            'include_in_sitemap' => true,
        ]);

        $jsonLdString = $page->json_ld_string;
        
        $this->assertNotNull($jsonLdString);
        $this->assertStringContainsString('@graph', $jsonLdString);
        $this->assertStringContainsString('Organization', $jsonLdString);
        $this->assertStringContainsString('WebSite', $jsonLdString);
    }

    public function test_json_ld_validation_error_messages()
    {
        $rule = new ValidJsonLd();
        
        // Test invalid JSON syntax
        $validator = Validator::make(['json_ld' => '{"invalid": json}'], ['json_ld' => $rule]);
        $this->assertTrue($validator->fails());
        $this->assertStringContainsString('invalid JSON', $validator->errors()->first('json_ld'));
        
        // Test missing @context
        $validator = Validator::make(['json_ld' => '{"@type": "Organization"}'], ['json_ld' => $rule]);
        $this->assertTrue($validator->fails());
        $this->assertStringContainsString('@context', $validator->errors()->first('json_ld'));
        
        // Test missing @type
        $validator = Validator::make(['json_ld' => '{"@context": "https://schema.org"}'], ['json_ld' => $rule]);
        $this->assertTrue($validator->fails());
        $this->assertStringContainsString('@type', $validator->errors()->first('json_ld'));
    }

    public function test_json_ld_validation_handles_both_string_and_array_inputs()
    {
        $rule = new ValidJsonLd();
        
        // Test with string input
        $stringInput = '{"@context": "https://schema.org", "@type": "Organization", "name": "Test"}';
        $validator = Validator::make(['json_ld' => $stringInput], ['json_ld' => $rule]);
        $this->assertFalse($validator->fails(), "String input should be valid");
        
        // Test with array input (simulating Eloquent casting)
        $arrayInput = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => "Test"
        ];
        $validator = Validator::make(['json_ld' => $arrayInput], ['json_ld' => $rule]);
        $this->assertFalse($validator->fails(), "Array input should be valid");
    }
}