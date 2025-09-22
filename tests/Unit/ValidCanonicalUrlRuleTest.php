<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Rules\ValidCanonicalUrl;
use Illuminate\Support\Facades\Validator;

class ValidCanonicalUrlRuleTest extends TestCase
{
    public function test_validates_root_path()
    {
        $rule = new ValidCanonicalUrl();
        $validator = Validator::make(['canonical_url' => '/'], ['canonical_url' => $rule]);
        
        $this->assertFalse($validator->fails(), 'Root path "/" should be valid');
    }

    public function test_validates_relative_paths()
    {
        $rule = new ValidCanonicalUrl();
        $validPaths = ['/about', '/services', '/services/cleaning', '/blog/post-title'];
        
        foreach ($validPaths as $path) {
            $validator = Validator::make(['canonical_url' => $path], ['canonical_url' => $rule]);
            $this->assertFalse($validator->fails(), "Path '$path' should be valid");
        }
    }

    public function test_validates_absolute_urls()
    {
        $rule = new ValidCanonicalUrl();
        $validUrls = [
            'https://example.com',
            'https://example.com/about',
            'http://localhost:3000/test'
        ];
        
        foreach ($validUrls as $url) {
            $validator = Validator::make(['canonical_url' => $url], ['canonical_url' => $rule]);
            $this->assertFalse($validator->fails(), "URL '$url' should be valid");
        }
    }

    public function test_rejects_paths_without_leading_slash()
    {
        $rule = new ValidCanonicalUrl();
        $validator = Validator::make(['canonical_url' => 'about'], ['canonical_url' => $rule]);
        
        $this->assertTrue($validator->fails(), 'Path without leading slash should be invalid');
        $this->assertStringContainsString('must start with /', $validator->errors()->first('canonical_url'));
    }

    public function test_rejects_trailing_slashes()
    {
        $rule = new ValidCanonicalUrl();
        $validator = Validator::make(['canonical_url' => '/about/'], ['canonical_url' => $rule]);
        
        $this->assertTrue($validator->fails(), 'Path with trailing slash should be invalid');
        $this->assertStringContainsString('should not end with a trailing slash', $validator->errors()->first('canonical_url'));
    }

    public function test_rejects_double_slashes()
    {
        $rule = new ValidCanonicalUrl();
        $validator = Validator::make(['canonical_url' => '/path//double'], ['canonical_url' => $rule]);
        
        $this->assertTrue($validator->fails(), 'Path with double slashes should be invalid');
        $this->assertStringContainsString('cannot contain double slashes', $validator->errors()->first('canonical_url'));
    }

    public function test_rejects_non_http_protocols()
    {
        $rule = new ValidCanonicalUrl();
        $validator = Validator::make(['canonical_url' => 'ftp://example.com'], ['canonical_url' => $rule]);
        
        $this->assertTrue($validator->fails(), 'Non-HTTP protocol should be invalid');
        $this->assertStringContainsString('HTTP or HTTPS URL', $validator->errors()->first('canonical_url'));
    }

    public function test_allows_empty_values()
    {
        $rule = new ValidCanonicalUrl();
        
        $validator = Validator::make(['canonical_url' => ''], ['canonical_url' => $rule]);
        $this->assertFalse($validator->fails(), 'Empty string should be valid');
        
        $validator = Validator::make(['canonical_url' => null], ['canonical_url' => $rule]);
        $this->assertFalse($validator->fails(), 'Null value should be valid');
    }

    public function test_trims_whitespace()
    {
        $rule = new ValidCanonicalUrl();
        $validator = Validator::make(['canonical_url' => ' /about '], ['canonical_url' => $rule]);
        
        $this->assertFalse($validator->fails(), 'Path with whitespace should be valid after trimming');
    }

    public function test_homepage_canonical_url_fix()
    {
        // This test specifically verifies that "/" (homepage canonical) works
        $rule = new ValidCanonicalUrl();
        $validator = Validator::make(['canonical_url' => '/'], ['canonical_url' => $rule]);
        
        $this->assertFalse($validator->fails(), 'Homepage canonical URL "/" should be valid');
    }
}