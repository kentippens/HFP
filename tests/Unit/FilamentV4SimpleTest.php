<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class FilamentV4SimpleTest extends TestCase
{
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
        $filamentPath = __DIR__ . '/../../app/Filament';
        $filamentFiles = glob($filamentPath . '/**/*.php');

        foreach ($filamentFiles as $file) {
            $content = file_get_contents($file);
            $this->assertStringNotContainsString('Forms\\Components\\', $content,
                "File {$file} still contains Forms\\Components namespace usage");
        }
    }

    public function test_no_missing_action_imports()
    {
        $filamentPath = __DIR__ . '/../../app/Filament';
        $filamentFiles = glob($filamentPath . '/**/*.php');

        $filesChecked = 0;
        foreach ($filamentFiles as $file) {
            $content = file_get_contents($file);
            $filesChecked++;

            // Check for any Tables\Actions\*:: usage without proper imports
            $actionPatterns = [
                'Tables\\Actions\\Action::',
                'Tables\\Actions\\EditAction::',
                'Tables\\Actions\\ViewAction::',
                'Tables\\Actions\\DeleteAction::',
                'Tables\\Actions\\BulkAction::',
                'Tables\\Actions\\BulkActionGroup::',
                'Tables\\Actions\\DeleteBulkAction::'
            ];

            foreach ($actionPatterns as $pattern) {
                $this->assertStringNotContainsString($pattern, $content,
                    "File {$file} still contains {$pattern} usage - should use imported class");
            }
        }

        // Ensure we actually checked some files
        $this->assertGreaterThan(0, $filesChecked, 'No Filament files found to check');
    }
}