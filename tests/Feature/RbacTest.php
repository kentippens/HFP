<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Run the seeder to create roles and permissions
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_user_can_be_assigned_role()
    {
        $user = User::factory()->create();
        $role = Role::where('slug', 'admin')->first();
        
        $user->assignRole($role);
        
        $this->assertTrue($user->hasRole('admin'));
        $this->assertFalse($user->hasRole('super-admin'));
    }

    public function test_user_can_have_multiple_roles()
    {
        $user = User::factory()->create();
        
        $user->assignRole('admin');
        $user->assignRole('manager');
        
        $this->assertTrue($user->hasRole('admin'));
        $this->assertTrue($user->hasRole('manager'));
        $this->assertTrue($user->hasAnyRole(['admin', 'manager']));
        $this->assertTrue($user->hasAllRoles(['admin', 'manager']));
    }

    public function test_user_can_be_given_direct_permission()
    {
        $user = User::factory()->create();
        $permission = Permission::where('slug', 'services.create')->first();
        
        $user->givePermission($permission);
        
        $this->assertTrue($user->hasPermission('services.create'));
    }

    public function test_user_inherits_permissions_from_role()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        
        // Admin role should have services.create permission
        $this->assertTrue($user->hasPermission('services.create'));
        $this->assertTrue($user->hasPermission('blog.edit'));
        
        // Admin shouldn't have logs.view permission (system group)
        $this->assertFalse($user->hasPermission('logs.view'));
    }

    public function test_super_admin_has_all_permissions()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');
        
        // Super admin should have any permission
        $this->assertTrue($user->hasPermission('any.random.permission'));
        $this->assertTrue($user->hasPermission('users.delete'));
        $this->assertTrue($user->hasPermission('logs.view'));
    }

    public function test_role_can_sync_permissions()
    {
        $role = Role::where('slug', 'employee')->first();
        $permissions = Permission::whereIn('slug', ['services.view', 'blog.view'])->get();
        
        $role->syncPermissions($permissions->toArray());
        
        $this->assertTrue($role->hasPermission('services.view'));
        $this->assertTrue($role->hasPermission('blog.view'));
    }

    public function test_middleware_protects_routes_by_role()
    {
        // Create test users
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $customer = User::factory()->create();
        $customer->assignRole('customer');
        
        // Define a test route with role middleware
        \Route::get('/test-admin-route', function () {
            return 'Admin access granted';
        })->middleware(['auth', 'role:admin']);
        
        // Test admin can access
        $response = $this->actingAs($admin)->get('/test-admin-route');
        $response->assertStatus(200);
        $response->assertSee('Admin access granted');
        
        // Test customer cannot access
        $response = $this->actingAs($customer)->get('/test-admin-route');
        $response->assertStatus(403);
    }

    public function test_middleware_protects_routes_by_permission()
    {
        // Create test users
        $manager = User::factory()->create();
        $manager->assignRole('manager');
        
        $employee = User::factory()->create();
        $employee->assignRole('employee');
        
        // Define a test route with permission middleware
        \Route::get('/test-create-service', function () {
            return 'Service creation allowed';
        })->middleware(['auth', 'permission:services.create']);
        
        // Test manager can access (has services.create permission)
        $response = $this->actingAs($manager)->get('/test-create-service');
        $response->assertStatus(200);
        $response->assertSee('Service creation allowed');
        
        // Test employee cannot access (doesn't have services.create permission)
        $response = $this->actingAs($employee)->get('/test-create-service');
        $response->assertStatus(403);
    }

    public function test_user_can_check_multiple_permissions()
    {
        $user = User::factory()->create();
        $user->assignRole('manager');
        
        // Manager should have these permissions
        $this->assertTrue($user->hasAnyPermission(['services.view', 'blog.create']));
        $this->assertTrue($user->hasAllPermissions(['services.view', 'blog.view']));
        
        // Manager shouldn't have these permissions
        $this->assertFalse($user->hasAllPermissions(['users.delete', 'settings.edit']));
    }

    public function test_roles_have_correct_hierarchy_levels()
    {
        $superAdmin = Role::where('slug', 'super-admin')->first();
        $admin = Role::where('slug', 'admin')->first();
        $manager = Role::where('slug', 'manager')->first();
        $employee = Role::where('slug', 'employee')->first();
        $customer = Role::where('slug', 'customer')->first();
        
        $this->assertEquals(100, $superAdmin->level);
        $this->assertEquals(50, $admin->level);
        $this->assertEquals(30, $manager->level);
        $this->assertEquals(20, $employee->level);
        $this->assertEquals(10, $customer->level);
        
        $this->assertTrue($superAdmin->isSuperAdmin());
        $this->assertTrue($superAdmin->isAdmin());
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($manager->isAdmin());
    }

    public function test_permissions_are_grouped_correctly()
    {
        $grouped = Permission::getGrouped();
        
        $this->assertArrayHasKey('users', $grouped);
        $this->assertArrayHasKey('services', $grouped);
        $this->assertArrayHasKey('blog', $grouped);
        $this->assertArrayHasKey('system', $grouped);
        
        $this->assertCount(5, $grouped['users']);
        $this->assertCount(5, $grouped['services']);
    }

    public function test_user_role_can_be_removed()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        
        $this->assertTrue($user->hasRole('admin'));
        
        $user->removeRole('admin');
        
        $this->assertFalse($user->hasRole('admin'));
    }

    public function test_user_permission_can_be_revoked()
    {
        $user = User::factory()->create();
        $user->givePermission('services.create');
        
        $this->assertTrue($user->hasPermission('services.create'));
        
        $user->revokePermission('services.create');
        
        $this->assertFalse($user->hasPermission('services.create'));
    }

    public function test_default_role_is_set_correctly()
    {
        $customerRole = Role::where('slug', 'customer')->first();
        $adminRole = Role::where('slug', 'admin')->first();
        
        $this->assertTrue($customerRole->is_default);
        $this->assertFalse($adminRole->is_default);
    }

    public function test_admin_panel_access_requires_proper_role()
    {
        $adminUser = User::factory()->create(['is_admin' => false]);
        $adminUser->assignRole('admin');
        
        $regularUser = User::factory()->create(['is_admin' => false]);
        $regularUser->assignRole('customer');
        
        $this->assertTrue($adminUser->canAccessPanel(new \Filament\Panel()));
        $this->assertFalse($regularUser->canAccessPanel(new \Filament\Panel()));
    }
}