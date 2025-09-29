<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\BlogCategory;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentV4AuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test user
        $this->user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('TestPassword123!'),
        ]);
    }

    /** @test */
    public function admin_login_page_loads_correctly()
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Sign in');
        $response->assertSee('HexServices Admin');
    }

    /** @test */
    public function admin_routes_require_authentication()
    {
        $routes = [
            '/admin',
            '/admin/blog-categories',
            '/admin/blog-posts',
            '/admin/core-pages',
            '/admin/users',
            '/admin/services',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/admin/login');
        }
    }

    /** @test */
    public function authenticated_user_can_access_admin_panel()
    {
        $response = $this->actingAs($this->user)->get('/admin');

        $response->assertStatus(200);
    }

    /** @test */
    public function filament_assets_are_accessible()
    {
        $assets = [
            '/css/filament/filament/app.css?v=4.0.20.0',
            '/fonts/filament/filament/inter/index.css?v=4.0.20.0',
            '/js/filament/actions/actions.js?v=4.0.20.0',
        ];

        foreach ($assets as $asset) {
            $response = $this->get($asset);
            $response->assertStatus(200);
        }
    }

    /** @test */
    public function blog_category_resource_works()
    {
        $category = BlogCategory::factory()->create();

        $response = $this->actingAs($this->user)->get('/admin/blog-categories');

        $response->assertStatus(200);
        $response->assertSee($category->name);
    }

    /** @test */
    public function service_resource_works()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->user)->get('/admin/services');

        $response->assertStatus(200);
        $response->assertSee($service->name);
    }

    /** @test */
    public function user_resource_works()
    {
        $response = $this->actingAs($this->user)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee($this->user->name);
    }

    /** @test */
    public function filament_navigation_methods_exist()
    {
        $resources = [
            \App\Filament\Resources\BlogCategoryResource::class,
            \App\Filament\Resources\BlogPostResource::class,
            \App\Filament\Resources\CorePageResource::class,
            \App\Filament\Resources\ServiceResource::class,
            \App\Filament\Resources\UserResource::class,
        ];

        foreach ($resources as $resource) {
            $this->assertTrue(method_exists($resource, 'getNavigationIcon'));
            $this->assertTrue(method_exists($resource, 'getNavigationLabel'));
            $this->assertTrue(method_exists($resource, 'getNavigationGroup'));
        }
    }

    /** @test */
    public function schemas_namespace_migration_complete()
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

            $this->assertEquals('Filament\Schemas\Schema', $returnType->getName());
        }
    }

    /** @test */
    public function password_validation_rules_work()
    {
        $rule = new \App\Rules\SecurePassword();

        // Test weak password
        $this->assertFalse($rule->passes('password', '123'));

        // Test strong password
        $this->assertTrue($rule->passes('password', 'TestPassword123!'));
    }

    /** @test */
    public function json_ld_validation_works()
    {
        $rule = new \App\Rules\ValidJsonLd();

        // Test invalid JSON
        $this->assertFalse($rule->passes('json_ld', '{invalid json}'));

        // Test valid JSON-LD
        $validJsonLd = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Test'
        ]);

        $this->assertTrue($rule->passes('json_ld', $validJsonLd));
    }
}