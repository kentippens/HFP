<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Silo;
use App\Models\User;

class SiloTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test silos
        $this->rootSilo = Silo::create([
            'name' => 'Test Pool Service',
            'slug' => 'test-pool-service',
            'description' => 'Test description',
            'is_active' => true,
        ]);
        
        $this->childSilo = Silo::create([
            'name' => 'Test Sub Service',
            'slug' => 'test-sub-service',
            'parent_id' => $this->rootSilo->id,
            'description' => 'Test child description',
            'is_active' => true,
        ]);
    }

    /**
     * Test root silo page loads successfully
     */
    public function test_root_silo_page_loads()
    {
        // Create the specific route silo for pool-resurfacing
        Silo::create([
            'name' => 'Pool Resurfacing',
            'slug' => 'pool-resurfacing',
            'description' => 'Test pool resurfacing',
            'is_active' => true,
        ]);
        
        $response = $this->get('/pool-resurfacing');
        
        $response->assertStatus(200);
        $response->assertSee('Pool Resurfacing');
    }

    /**
     * Test child silo page loads successfully
     */
    public function test_child_silo_page_loads()
    {
        // Create the specific route silo structure
        $parent = Silo::create([
            'name' => 'Pool Repair',
            'slug' => 'pool-repair',
            'is_active' => true,
        ]);
        
        $child = Silo::create([
            'name' => 'Crack Repair',
            'slug' => 'crack-repair',
            'parent_id' => $parent->id,
            'is_active' => true,
        ]);
        
        $response = $this->get('/pool-repair/crack-repair');
        
        $response->assertStatus(200);
        $response->assertSee('Crack Repair');
    }

    /**
     * Test inactive silo returns 404
     */
    public function test_inactive_silo_returns_404()
    {
        Silo::create([
            'name' => 'Pool Conversions',
            'slug' => 'pool-conversions',
            'is_active' => false,
        ]);
        
        $response = $this->get('/pool-conversions');
        
        $response->assertStatus(404);
    }

    /**
     * Test non-existent silo returns 404
     */
    public function test_nonexistent_silo_returns_404()
    {
        $response = $this->get('/pool-resurfacing/non-existent');
        
        $response->assertStatus(404);
    }

    /**
     * Test silo model relationships
     */
    public function test_silo_relationships()
    {
        $this->assertInstanceOf(Silo::class, $this->childSilo->parent);
        $this->assertEquals($this->rootSilo->id, $this->childSilo->parent->id);
        
        $this->assertTrue($this->rootSilo->children->contains($this->childSilo));
        $this->assertEquals(1, $this->rootSilo->children->count());
    }

    /**
     * Test silo slug generation
     */
    public function test_silo_slug_generation()
    {
        $silo = Silo::create([
            'name' => 'Test Silo With Spaces',
            'is_active' => true,
        ]);
        
        $this->assertEquals('test-silo-with-spaces', $silo->slug);
    }

    /**
     * Test duplicate slug handling
     */
    public function test_duplicate_slug_handling()
    {
        $silo1 = Silo::create([
            'name' => 'Duplicate Test',
            'slug' => 'duplicate-test',
            'is_active' => true,
        ]);
        
        $silo2 = Silo::create([
            'name' => 'Duplicate Test',
            'is_active' => true,
        ]);
        
        $this->assertEquals('duplicate-test', $silo1->slug);
        $this->assertEquals('duplicate-test-1', $silo2->slug);
    }

    /**
     * Test circular reference prevention
     */
    public function test_circular_reference_prevention()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        // Try to set a silo as its own parent
        $this->rootSilo->parent_id = $this->rootSilo->id;
        $this->rootSilo->save();
    }

    /**
     * Test full URL generation
     */
    public function test_full_url_generation()
    {
        $grandchild = Silo::create([
            'name' => 'Grandchild Service',
            'slug' => 'grandchild-service',
            'parent_id' => $this->childSilo->id,
            'is_active' => true,
        ]);
        
        $this->assertEquals('test-pool-service', $this->rootSilo->full_slug);
        $this->assertEquals('test-pool-service/test-sub-service', $this->childSilo->full_slug);
        $this->assertEquals('test-pool-service/test-sub-service/grandchild-service', $grandchild->full_slug);
    }

    /**
     * Test breadcrumb generation
     */
    public function test_breadcrumb_generation()
    {
        $breadcrumbs = $this->childSilo->breadcrumbs;
        
        $this->assertCount(2, $breadcrumbs);
        $this->assertEquals('Test Pool Service', $breadcrumbs[0]['name']);
        $this->assertEquals('Test Sub Service', $breadcrumbs[1]['name']);
    }

    /**
     * Test JSON-LD string conversion
     */
    public function test_json_ld_string_conversion()
    {
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => 'Test Service',
        ];
        
        $silo = Silo::create([
            'name' => 'JSON Test',
            'slug' => 'json-test',
            'json_ld' => $jsonLd,
            'is_active' => true,
        ]);
        
        $this->assertJson($silo->json_ld_string);
        $this->assertStringContainsString('@context', $silo->json_ld_string);
    }

    /**
     * Test features and benefits casting
     */
    public function test_features_benefits_casting()
    {
        $features = [
            ['title' => 'Feature 1', 'description' => 'Description 1'],
            ['title' => 'Feature 2', 'description' => 'Description 2'],
        ];
        
        $silo = Silo::create([
            'name' => 'Features Test',
            'slug' => 'features-test',
            'features' => $features,
            'is_active' => true,
        ]);
        
        $this->assertIsArray($silo->features);
        $this->assertCount(2, $silo->features);
        $this->assertEquals('Feature 1', $silo->features[0]['title']);
    }

    /**
     * Test scope queries
     */
    public function test_scope_queries()
    {
        // Create additional test data
        Silo::create([
            'name' => 'Inactive Silo',
            'slug' => 'inactive-silo',
            'is_active' => false,
        ]);
        
        $activeSilos = Silo::active()->get();
        $rootSilos = Silo::root()->get();
        
        $this->assertEquals(2, $activeSilos->count()); // rootSilo and childSilo from setUp
        $this->assertEquals(2, $rootSilos->count()); // rootSilo from setUp and inactive silo
    }
}