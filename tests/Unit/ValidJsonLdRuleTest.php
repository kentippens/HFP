<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Rules\ValidJsonLd;
use Illuminate\Support\Facades\Validator;

class ValidJsonLdRuleTest extends TestCase
{
    public function test_validates_json_string_input()
    {
        $rule = new ValidJsonLd();
        $validator = Validator::make(
            ['json_ld' => '{"@context": "https://schema.org", "@type": "Organization", "name": "Test"}'],
            ['json_ld' => $rule]
        );
        
        $this->assertFalse($validator->fails(), 'Valid JSON-LD string should pass validation');
    }

    public function test_validates_array_input()
    {
        $rule = new ValidJsonLd();
        $validator = Validator::make(
            ['json_ld' => ["@context" => "https://schema.org", "@type" => "Organization", "name" => "Test"]],
            ['json_ld' => $rule]
        );
        
        $this->assertFalse($validator->fails(), 'Valid JSON-LD array should pass validation');
    }

    public function test_rejects_invalid_json_string()
    {
        $rule = new ValidJsonLd();
        $validator = Validator::make(
            ['json_ld' => '{"@context": "https://schema.org", "@type": "Organization", "name": "Test"'], // Missing closing brace
            ['json_ld' => $rule]
        );
        
        $this->assertTrue($validator->fails(), 'Invalid JSON string should fail validation');
        $this->assertStringContainsString('invalid JSON', $validator->errors()->first('json_ld'));
    }

    public function test_rejects_json_missing_context()
    {
        $rule = new ValidJsonLd();
        $validator = Validator::make(
            ['json_ld' => '{"@type": "Organization", "name": "Test"}'],
            ['json_ld' => $rule]
        );
        
        $this->assertTrue($validator->fails(), 'JSON-LD without @context should fail validation');
        $this->assertStringContainsString('@context', $validator->errors()->first('json_ld'));
    }

    public function test_rejects_json_missing_type()
    {
        $rule = new ValidJsonLd();
        $validator = Validator::make(
            ['json_ld' => '{"@context": "https://schema.org", "name": "Test"}'],
            ['json_ld' => $rule]
        );
        
        $this->assertTrue($validator->fails(), 'JSON-LD without @type should fail validation');
        $this->assertStringContainsString('@type', $validator->errors()->first('json_ld'));
    }

    public function test_allows_empty_values()
    {
        $rule = new ValidJsonLd();
        
        $validator = Validator::make(['json_ld' => ''], ['json_ld' => $rule]);
        $this->assertFalse($validator->fails(), 'Empty string should be valid');
        
        $validator = Validator::make(['json_ld' => null], ['json_ld' => $rule]);
        $this->assertFalse($validator->fails(), 'Null value should be valid');
    }

    public function test_validates_array_of_schemas()
    {
        $rule = new ValidJsonLd();
        $arrayOfSchemas = [
            ["@context" => "https://schema.org", "@type" => "Organization", "name" => "Test"],
            ["@context" => "https://schema.org", "@type" => "WebSite", "url" => "https://example.com"]
        ];
        
        $validator = Validator::make(['json_ld' => $arrayOfSchemas], ['json_ld' => $rule]);
        
        $this->assertFalse($validator->fails(), 'Array of valid JSON-LD schemas should pass validation');
    }

    public function test_rejects_invalid_context_url()
    {
        $rule = new ValidJsonLd();
        $validator = Validator::make(
            ['json_ld' => '{"@context": "not-a-url", "@type": "Organization", "name": "Test"}'],
            ['json_ld' => $rule]
        );
        
        $this->assertTrue($validator->fails(), 'Invalid @context URL should fail validation');
        $this->assertStringContainsString('valid URL', $validator->errors()->first('json_ld'));
    }

    public function test_handles_both_string_and_array_contexts()
    {
        $rule = new ValidJsonLd();
        
        // String context
        $validator = Validator::make(
            ['json_ld' => '{"@context": "https://schema.org", "@type": "Organization", "name": "Test"}'],
            ['json_ld' => $rule]
        );
        $this->assertFalse($validator->fails(), 'String context should be valid');
        
        // Array context
        $validator = Validator::make(
            ['json_ld' => '{"@context": ["https://schema.org", "https://example.com"], "@type": "Organization", "name": "Test"}'],
            ['json_ld' => $rule]
        );
        $this->assertFalse($validator->fails(), 'Array context should be valid');
    }

    public function test_original_error_json_decode_with_array_is_fixed()
    {
        // This test specifically verifies the original error is fixed
        // where json_decode() was called on an array instead of a string
        
        $rule = new ValidJsonLd();
        $arrayData = [
            "@context" => "https://schema.org",
            "@type" => "Organization", 
            "name" => "Test Business"
        ];
        
        // This should NOT throw the error: json_decode(): Argument #1 ($json) must be of type string, array given
        $validator = Validator::make(['json_ld' => $arrayData], ['json_ld' => $rule]);
        
        $this->assertFalse($validator->fails(), 'Array input should not cause json_decode error');
    }
}