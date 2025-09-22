<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ContactSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactSubmissionExportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        
        // Create admin user for Filament access
        $this->adminUser = User::factory()->create([
            'email' => 'admin@test.com',
            'name' => 'Admin User'
        ]);
    }

    public function test_contact_submission_resource_can_be_instantiated()
    {
        // Test that the resource class can be instantiated without errors
        $resource = new \App\Filament\Resources\ContactSubmissionResource();
        $this->assertInstanceOf(\App\Filament\Resources\ContactSubmissionResource::class, $resource);
    }

    public function test_export_helper_methods_exist()
    {
        // Test that our new helper methods exist and are callable
        $this->assertTrue(method_exists(\App\Filament\Resources\ContactSubmissionResource::class, 'getActiveFilterInfo'));
        $this->assertTrue(method_exists(\App\Filament\Resources\ContactSubmissionResource::class, 'getActiveFiltersText'));
    }

    public function test_contact_submissions_can_be_created_for_testing()
    {
        // Create some test contact submissions
        ContactSubmission::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123-456-7890',
            'message' => 'Test message',
            'source' => 'contact_page',
            'service_requested' => 'house-cleaning',
            'is_read' => false,
            'ip_address' => '127.0.0.1',
        ]);

        ContactSubmission::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '098-765-4321',
            'message' => 'Another test message',
            'source' => 'homepage_form',
            'service_requested' => 'carpet-cleaning',
            'is_read' => true,
            'ip_address' => '127.0.0.1',
        ]);

        $count = ContactSubmission::count();
        $this->assertGreaterThan(0, $count, 'No contact submissions found for testing');
        $this->assertEquals(2, $count);
    }

    public function test_source_options_method_works()
    {
        // Test the source options method
        $options = \App\Filament\Resources\ContactSubmissionResource::getSourceOptions();
        $this->assertIsArray($options);
        $this->assertNotEmpty($options);
    }

    public function test_source_label_method_works()
    {
        // Test the source label method with various inputs
        $this->assertEquals('Homepage Hero', \App\Filament\Resources\ContactSubmissionResource::getSourceLabel('homepage_form'));
        $this->assertEquals('Service: Test Service', \App\Filament\Resources\ContactSubmissionResource::getSourceLabel('service_test-service'));
        $this->assertEquals('Custom Source', \App\Filament\Resources\ContactSubmissionResource::getSourceLabel('custom_source'));
    }
}