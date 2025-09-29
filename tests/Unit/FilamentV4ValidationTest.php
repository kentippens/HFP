<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Rules\ValidJsonLd;
use App\Rules\SecurePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilamentV4ValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_filament_navigation_methods_exist()
    {
        $resources = [
            \App\Filament\Resources\BlogCategoryResource::class,
            \App\Filament\Resources\BlogPostResource::class,
            \App\Filament\Resources\CorePageResource::class,
            \App\Filament\Resources\ServiceResource::class,
            \App\Filament\Resources\UserResource::class,
        ];

        foreach ($resources as $resource) {
            $this->assertTrue(method_exists($resource, 'getNavigationIcon'),
                "Missing getNavigationIcon method in {$resource}");
            $this->assertTrue(method_exists($resource, 'getNavigationLabel'),
                "Missing getNavigationLabel method in {$resource}");
        }
    }

    public function test_schemas_namespace_migration_complete()
    {
        $resources = [
            \App\Filament\Resources\BlogCategoryResource::class,
            \App\Filament\Resources\BlogPostResource::class,
            \App\Filament\Resources\CorePageResource::class,
        ];

        foreach ($resources as $resource) {
            $reflection = new \ReflectionClass($resource);
            $formMethod = $reflection->getMethod('form');
            $returnType = $formMethod->getReturnType();

            $this->assertEquals('Filament\Schemas\Schema', $returnType->getName(),
                "Form method in {$resource} should return Filament\Schemas\Schema");
        }
    }

    public function test_password_validation_rules_work()
    {
        $rule = new SecurePassword();

        // Test weak password
        $this->assertFalse($rule->passes('password', '123'));
        $this->assertFalse($rule->passes('password', 'password'));
        $this->assertFalse($rule->passes('password', 'short'));

        // Test strong password
        $this->assertTrue($rule->passes('password', 'TestPassword123!'));
        $this->assertTrue($rule->passes('password', 'ComplexP@ssw0rd123'));
    }

    public function test_json_ld_validation_works()
    {
        $rule = new ValidJsonLd();

        // Test invalid JSON
        $failClosure = function($message) {
            throw new \Exception($message);
        };

        // Test invalid JSON should fail
        try {
            $rule->validate('json_ld', '{invalid json}', $failClosure);
            $this->fail('Should have failed for invalid JSON');
        } catch (\Exception $e) {
            $this->assertStringContainsString('invalid JSON', $e->getMessage());
        }

        // Test missing @context should fail
        try {
            $validJson = json_encode(['@type' => 'Organization', 'name' => 'Test']);
            $rule->validate('json_ld', $validJson, $failClosure);
            $this->fail('Should have failed for missing @context');
        } catch (\Exception $e) {
            $this->assertStringContainsString('@context', $e->getMessage());
        }

        // Test valid JSON-LD should pass
        $validJsonLd = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Test'
        ]);

        // This should not throw an exception
        $rule->validate('json_ld', $validJsonLd, $failClosure);
        $this->assertTrue(true); // If we get here, validation passed
    }

    public function test_filament_resource_classes_exist()
    {
        $resources = [
            \App\Filament\Resources\BlogCategoryResource::class,
            \App\Filament\Resources\BlogPostResource::class,
            \App\Filament\Resources\CorePageResource::class,
            \App\Filament\Resources\ServiceResource::class,
            \App\Filament\Resources\UserResource::class,
            \App\Filament\Resources\ContactSubmissionResource::class,
            \App\Filament\Resources\LandingPageResource::class,
            \App\Filament\Resources\TrackingScriptResource::class,
        ];

        foreach ($resources as $resource) {
            $this->assertTrue(class_exists($resource), "Resource class {$resource} does not exist");
        }
    }

    public function test_no_forms_namespace_usage()
    {
        $filamentPath = base_path('app/Filament');
        $filamentFiles = glob($filamentPath . '/**/*.php');

        foreach ($filamentFiles as $file) {
            $content = file_get_contents($file);
            $this->assertStringNotContainsString('Forms\\Components\\', $content,
                "File {$file} still contains Forms\\Components namespace usage");
        }
    }
}