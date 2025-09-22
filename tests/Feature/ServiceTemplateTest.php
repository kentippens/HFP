<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTemplateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that service pages render without errors
     */
    public function test_service_page_renders_successfully()
    {
        // Create a test service
        $service = Service::create([
            'name' => 'Test Service',
            'slug' => 'test-service',
            'description' => '<p>Test description</p>',
            'short_description' => 'Short test description',
            'is_active' => true,
        ]);

        $response = $this->get('/services/' . $service->slug);
        $response->assertStatus(200);
        $response->assertSee($service->name);
    }

    /**
     * Test service with benefits and features
     */
    public function test_service_with_benefits_and_features_renders()
    {
        $service = Service::create([
            'name' => 'Pool Service',
            'slug' => 'pool-service',
            'description' => '<p>Pool service description</p>',
            'overview' => '<p>Service overview</p>',
            'benefits' => ['Benefit 1', 'Benefit 2', 'Benefit 3'],
            'features' => ['Feature 1', 'Feature 2'],
            'is_active' => true,
        ]);

        $response = $this->get('/services/' . $service->slug);
        $response->assertStatus(200);
        $response->assertSee('Benefit 1');
        $response->assertSee('Feature 1');
        $response->assertSee('Service overview');
    }

    /**
     * Test service with missing optional fields
     */
    public function test_service_with_missing_fields_renders()
    {
        $service = Service::create([
            'name' => 'Minimal Service',
            'slug' => 'minimal-service',
            'is_active' => true,
        ]);

        $response = $this->get('/services/' . $service->slug);
        $response->assertStatus(200);
        $response->assertSee($service->name);
        $response->assertSee('Contact us to learn more');
    }

    /**
     * Test nested service paths
     */
    public function test_nested_service_path_renders()
    {
        $parent = Service::create([
            'name' => 'Parent Service',
            'slug' => 'parent',
            'is_active' => true,
        ]);

        $child = Service::create([
            'name' => 'Child Service',
            'slug' => 'child',
            'parent_id' => $parent->id,
            'is_active' => true,
        ]);

        $response = $this->get('/services/parent/child');
        $response->assertStatus(200);
        $response->assertSee($child->name);
    }

    /**
     * Test invalid service returns 404
     */
    public function test_invalid_service_returns_404()
    {
        $response = $this->get('/services/non-existent-service');
        $response->assertStatus(404);
    }

    /**
     * Test service with children displays them
     */
    public function test_service_with_children_displays_them()
    {
        $parent = Service::create([
            'name' => 'Parent Service',
            'slug' => 'parent',
            'is_active' => true,
        ]);

        $child = Service::create([
            'name' => 'Child Service',
            'slug' => 'child',
            'parent_id' => $parent->id,
            'is_active' => true,
        ]);

        $response = $this->get('/services/' . $parent->slug);
        $response->assertStatus(200);
        $response->assertSee('Related ' . $parent->name . ' Services');
        $response->assertSee($child->name);
    }
}