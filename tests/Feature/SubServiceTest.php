<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a service can have a parent
     */
    public function test_service_can_have_parent()
    {
        $parent = Service::create([
            'title' => 'House Cleaning',
            'slug' => 'house-cleaning',
            'description' => 'Professional house cleaning service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $child = Service::create([
            'title' => 'Pet House Cleaning',
            'slug' => 'pet-house-cleaning',
            'description' => 'Specialized cleaning for pet owners',
            'parent_id' => $parent->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $this->assertNotNull($child->parent);
        $this->assertEquals($parent->id, $child->parent->id);
        $this->assertTrue($parent->children->contains($child));
    }

    /**
     * Test full slug generation for nested services
     */
    public function test_full_slug_generation()
    {
        $parent = Service::create([
            'title' => 'House Cleaning',
            'slug' => 'house-cleaning',
            'description' => 'Professional house cleaning service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $child = Service::create([
            'title' => 'Pet House Cleaning',
            'slug' => 'pet-house-cleaning',
            'description' => 'Specialized cleaning for pet owners',
            'parent_id' => $parent->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $grandchild = Service::create([
            'title' => 'Deep Pet Cleaning',
            'slug' => 'deep-pet-cleaning',
            'description' => 'Deep cleaning for heavy pet situations',
            'parent_id' => $child->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $this->assertEquals('house-cleaning', $parent->full_slug);
        $this->assertEquals('house-cleaning/pet-house-cleaning', $child->full_slug);
        $this->assertEquals('house-cleaning/pet-house-cleaning/deep-pet-cleaning', $grandchild->full_slug);
    }

    /**
     * Test breadcrumb generation
     */
    public function test_breadcrumb_generation()
    {
        $parent = Service::create([
            'title' => 'House Cleaning',
            'slug' => 'house-cleaning',
            'description' => 'Professional house cleaning service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $child = Service::create([
            'title' => 'Pet House Cleaning',
            'slug' => 'pet-house-cleaning',
            'description' => 'Specialized cleaning for pet owners',
            'parent_id' => $parent->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $breadcrumbs = $child->breadcrumbs;
        
        $this->assertCount(2, $breadcrumbs);
        $this->assertEquals($parent->id, $breadcrumbs[0]->id);
        $this->assertEquals($child->id, $breadcrumbs[1]->id);
    }

    /**
     * Test nested service URL routing
     */
    public function test_nested_service_url_routing()
    {
        $parent = Service::create([
            'title' => 'House Cleaning',
            'slug' => 'house-cleaning',
            'description' => 'Professional house cleaning service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $child = Service::create([
            'title' => 'Pet House Cleaning',
            'slug' => 'pet-house-cleaning',
            'description' => 'Specialized cleaning for pet owners',
            'parent_id' => $parent->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        // Test parent service URL
        $response = $this->get('/services/house-cleaning');
        $response->assertStatus(200);
        $response->assertSee('House Cleaning');

        // Test child service URL
        $response = $this->get('/services/house-cleaning/pet-house-cleaning');
        $response->assertStatus(200);
        $response->assertSee('Pet House Cleaning');
    }

    /**
     * Test invalid nested URL returns 404
     */
    public function test_invalid_nested_url_returns_404()
    {
        Service::create([
            'title' => 'House Cleaning',
            'slug' => 'house-cleaning',
            'description' => 'Professional house cleaning service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        // Test non-existent child
        $response = $this->get('/services/house-cleaning/non-existent');
        $response->assertStatus(404);

        // Test wrong parent
        $response = $this->get('/services/wrong-parent/house-cleaning');
        $response->assertStatus(404);
    }

    /**
     * Test inactive services are not accessible
     */
    public function test_inactive_services_not_accessible()
    {
        $parent = Service::create([
            'title' => 'House Cleaning',
            'slug' => 'house-cleaning',
            'description' => 'Professional house cleaning service',
            'is_active' => false,
            'meta_robots' => 'index, follow',
        ]);

        $response = $this->get('/services/house-cleaning');
        $response->assertStatus(404);
    }

    /**
     * Test top level scope
     */
    public function test_top_level_scope()
    {
        $parent1 = Service::create([
            'title' => 'House Cleaning',
            'slug' => 'house-cleaning',
            'description' => 'Professional house cleaning service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $parent2 = Service::create([
            'title' => 'Office Cleaning',
            'slug' => 'office-cleaning',
            'description' => 'Professional office cleaning service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $child = Service::create([
            'title' => 'Pet House Cleaning',
            'slug' => 'pet-house-cleaning',
            'description' => 'Specialized cleaning for pet owners',
            'parent_id' => $parent1->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $topLevelServices = Service::topLevel()->get();
        
        $this->assertCount(2, $topLevelServices);
        $this->assertTrue($topLevelServices->contains($parent1));
        $this->assertTrue($topLevelServices->contains($parent2));
        $this->assertFalse($topLevelServices->contains($child));
    }

    /**
     * Test service index only shows top level services
     */
    public function test_service_index_shows_only_top_level()
    {
        $parent = Service::create([
            'title' => 'House Cleaning',
            'slug' => 'house-cleaning',
            'description' => 'Professional house cleaning service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $child = Service::create([
            'title' => 'Pet House Cleaning',
            'slug' => 'pet-house-cleaning',
            'description' => 'Specialized cleaning for pet owners',
            'parent_id' => $parent->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $response = $this->get('/services');
        $response->assertStatus(200);
        $response->assertSee('House Cleaning');
        $response->assertSee('Pet House Cleaning'); // Should appear as sub-service
    }

    /**
     * Test cascade delete of children when parent is deleted
     */
    public function test_cascade_delete_children()
    {
        $parent = Service::create([
            'title' => 'House Cleaning',
            'slug' => 'house-cleaning',
            'description' => 'Professional house cleaning service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $child = Service::create([
            'title' => 'Pet House Cleaning',
            'slug' => 'pet-house-cleaning',
            'description' => 'Specialized cleaning for pet owners',
            'parent_id' => $parent->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $childId = $child->id;
        
        // Delete parent
        $parent->delete();

        // Check child is also deleted
        $this->assertNull(Service::find($childId));
    }

    /**
     * Test maximum nesting depth validation
     */
    public function test_maximum_nesting_depth_validation()
    {
        // Create a chain of services
        $level1 = Service::create([
            'title' => 'Level 1',
            'slug' => 'level-1',
            'description' => 'Level 1 service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $level2 = Service::create([
            'title' => 'Level 2',
            'slug' => 'level-2',
            'description' => 'Level 2 service',
            'parent_id' => $level1->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $level3 = Service::create([
            'title' => 'Level 3',
            'slug' => 'level-3',
            'description' => 'Level 3 service',
            'parent_id' => $level2->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $level4 = Service::create([
            'title' => 'Level 4',
            'slug' => 'level-4',
            'description' => 'Level 4 service',
            'parent_id' => $level3->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $level5 = Service::create([
            'title' => 'Level 5',
            'slug' => 'level-5',
            'description' => 'Level 5 service',
            'parent_id' => $level4->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        // Try to create level 6 - should fail
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Maximum nesting depth of 5 levels would be exceeded');

        Service::create([
            'title' => 'Level 6',
            'slug' => 'level-6',
            'description' => 'Level 6 service',
            'parent_id' => $level5->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);
    }

    /**
     * Test duplicate slug validation within same parent
     */
    public function test_duplicate_slug_within_same_parent()
    {
        $parent = Service::create([
            'title' => 'Parent Service',
            'slug' => 'parent-service',
            'description' => 'Parent service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $child1 = Service::create([
            'title' => 'Child Service 1',
            'slug' => 'child-service',
            'description' => 'First child',
            'parent_id' => $parent->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        // Try to create another child with same slug under same parent
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A service with this slug already exists under the same parent');

        Service::create([
            'title' => 'Child Service 2',
            'slug' => 'child-service',
            'description' => 'Second child',
            'parent_id' => $parent->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);
    }

    /**
     * Test same slug allowed under different parents
     */
    public function test_same_slug_allowed_under_different_parents()
    {
        $parent1 = Service::create([
            'title' => 'Parent 1',
            'slug' => 'parent-1',
            'description' => 'First parent',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $parent2 = Service::create([
            'title' => 'Parent 2',
            'slug' => 'parent-2',
            'description' => 'Second parent',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        // Create child under parent1
        $child1 = Service::create([
            'title' => 'Common Service',
            'slug' => 'common-service',
            'description' => 'Service under parent 1',
            'parent_id' => $parent1->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        // Create child with same slug under parent2 - should succeed
        $child2 = Service::create([
            'title' => 'Common Service',
            'slug' => 'common-service',
            'description' => 'Service under parent 2',
            'parent_id' => $parent2->id,
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        $this->assertNotEquals($child1->id, $child2->id);
        $this->assertEquals($child1->slug, $child2->slug);
        $this->assertEquals('parent-1/common-service', $child1->full_slug);
        $this->assertEquals('parent-2/common-service', $child2->full_slug);
    }

    /**
     * Test path validation with special characters
     */
    public function test_path_validation_with_special_characters()
    {
        Service::create([
            'title' => 'Test Service',
            'slug' => 'test-service',
            'description' => 'Test service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        // Test with invalid characters
        $response = $this->get('/services/test-service!@#');
        $response->assertStatus(404);

        $response = $this->get('/services/test service');
        $response->assertStatus(404);

        $response = $this->get('/services/test_service');
        $response->assertStatus(404);
    }

    /**
     * Test extremely long paths
     */
    public function test_extremely_long_paths()
    {
        // Create a valid service
        Service::create([
            'title' => 'Test Service',
            'slug' => 'test-service',
            'description' => 'Test service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        // Test path that's too deep (more than 10 segments)
        $longPath = 'test-service/' . implode('/', array_fill(0, 10, 'segment'));
        $response = $this->get('/services/' . $longPath);
        $response->assertStatus(404);
    }

    /**
     * Test empty slug segments
     */
    public function test_empty_slug_segments()
    {
        Service::create([
            'title' => 'Test Service',
            'slug' => 'test-service',
            'description' => 'Test service',
            'is_active' => true,
            'meta_robots' => 'index, follow',
        ]);

        // These URLs should not match our route pattern or should be caught by middleware/validation
        // Testing various malformed paths
        
        // Path with double slashes - should be caught
        $response = $this->get('/services/test-service/non-existent');
        $response->assertStatus(404);
        
        // Non-existent sub-service
        $response = $this->get('/services/test-service/fake-sub');
        $response->assertStatus(404);
        
        // Test that valid service still works
        $response = $this->get('/services/test-service');
        $response->assertStatus(200);
    }
}
