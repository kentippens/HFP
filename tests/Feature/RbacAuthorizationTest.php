<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Service;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create permissions
        $permissions = [
            'blog.view',
            'blog.create',
            'blog.edit',
            'blog.delete',
            'blog.publish',
            'services.view',
            'services.create',
            'services.edit',
            'services.delete',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'admin.access',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'slug' => $permission]);
        }

        // Create roles
        $this->superAdmin = Role::create([
            'name' => 'Super Admin',
            'slug' => 'super-admin',
            'level' => 100,
        ]);

        $this->admin = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'level' => 50,
        ]);

        $this->manager = Role::create([
            'name' => 'Manager',
            'slug' => 'manager',
            'level' => 30,
        ]);

        $this->employee = Role::create([
            'name' => 'Employee',
            'slug' => 'employee',
            'level' => 20,
        ]);

        // Assign permissions to roles
        $adminPermissions = Permission::whereIn('slug', [
            'blog.view', 'blog.create', 'blog.edit', 'blog.delete', 'blog.publish',
            'services.view', 'services.create', 'services.edit', 'services.delete',
            'users.view', 'users.create', 'users.edit',
            'admin.access',
        ])->get();

        $this->admin->syncPermissions($adminPermissions);

        $managerPermissions = Permission::whereIn('slug', [
            'blog.view', 'blog.create', 'blog.edit', 'blog.publish',
            'services.view', 'services.create', 'services.edit',
            'admin.access',
        ])->get();

        $this->manager->syncPermissions($managerPermissions);

        $employeePermissions = Permission::whereIn('slug', [
            'blog.view',
            'services.view',
            'admin.access',
        ])->get();

        $this->employee->syncPermissions($employeePermissions);
    }

    /**
     * Test super admin can do everything
     */
    public function test_super_admin_can_do_everything()
    {
        $user = User::factory()->create();
        $user->assignRole($this->superAdmin);

        $blogPost = BlogPost::factory()->create();
        $service = Service::factory()->create();

        $this->assertTrue($user->can('viewAny', BlogPost::class));
        $this->assertTrue($user->can('create', BlogPost::class));
        $this->assertTrue($user->can('update', $blogPost));
        $this->assertTrue($user->can('delete', $blogPost));

        $this->assertTrue($user->can('viewAny', Service::class));
        $this->assertTrue($user->can('create', Service::class));
        $this->assertTrue($user->can('update', $service));
        $this->assertTrue($user->can('delete', $service));
    }

    /**
     * Test admin permissions
     */
    public function test_admin_permissions()
    {
        $user = User::factory()->create();
        $user->assignRole($this->admin);

        $blogPost = BlogPost::factory()->create();
        $service = Service::factory()->create();

        // Admin can manage blog posts
        $this->assertTrue($user->can('viewAny', BlogPost::class));
        $this->assertTrue($user->can('create', BlogPost::class));
        $this->assertTrue($user->can('update', $blogPost));
        $this->assertTrue($user->can('delete', $blogPost));

        // Admin can manage services
        $this->assertTrue($user->can('viewAny', Service::class));
        $this->assertTrue($user->can('create', Service::class));
        $this->assertTrue($user->can('update', $service));
        $this->assertTrue($user->can('delete', $service));
    }

    /**
     * Test manager permissions
     */
    public function test_manager_permissions()
    {
        $user = User::factory()->create();
        $user->assignRole($this->manager);

        $blogPost = BlogPost::factory()->create();
        $service = Service::factory()->create();

        // Manager can manage blog posts except delete
        $this->assertTrue($user->can('viewAny', BlogPost::class));
        $this->assertTrue($user->can('create', BlogPost::class));
        $this->assertTrue($user->can('update', $blogPost));
        $this->assertFalse($user->can('delete', $blogPost));

        // Manager can manage services except delete
        $this->assertTrue($user->can('viewAny', Service::class));
        $this->assertTrue($user->can('create', Service::class));
        $this->assertTrue($user->can('update', $service));
        $this->assertFalse($user->can('delete', $service));
    }

    /**
     * Test employee permissions
     */
    public function test_employee_permissions()
    {
        $user = User::factory()->create();
        $user->assignRole($this->employee);

        $blogPost = BlogPost::factory()->create();
        $service = Service::factory()->create();

        // Employee can only view
        $this->assertTrue($user->can('viewAny', BlogPost::class));
        $this->assertFalse($user->can('create', BlogPost::class));
        $this->assertFalse($user->can('update', $blogPost));
        $this->assertFalse($user->can('delete', $blogPost));

        $this->assertTrue($user->can('viewAny', Service::class));
        $this->assertFalse($user->can('create', Service::class));
        $this->assertFalse($user->can('update', $service));
        $this->assertFalse($user->can('delete', $service));
    }

    /**
     * Test author can edit own blog posts
     */
    public function test_author_can_edit_own_posts()
    {
        $author = User::factory()->create();
        $author->assignRole($this->manager);

        $ownPost = BlogPost::factory()->create(['author_id' => $author->id]);
        $otherPost = BlogPost::factory()->create(['author_id' => 999]);

        // Author can edit own post
        $this->assertTrue($author->can('update', $ownPost));

        // Manager can edit any post
        $this->assertTrue($author->can('update', $otherPost));
    }

    /**
     * Test user without permissions cannot access resources
     */
    public function test_user_without_permissions_cannot_access_resources()
    {
        $user = User::factory()->create();
        // User has no role assigned

        $blogPost = BlogPost::factory()->create();
        $service = Service::factory()->create();

        $this->assertFalse($user->can('viewAny', BlogPost::class));
        $this->assertFalse($user->can('create', BlogPost::class));
        $this->assertFalse($user->can('update', $blogPost));
        $this->assertFalse($user->can('delete', $blogPost));

        $this->assertFalse($user->can('viewAny', Service::class));
        $this->assertFalse($user->can('create', Service::class));
        $this->assertFalse($user->can('update', $service));
        $this->assertFalse($user->can('delete', $service));
    }

    /**
     * Test blog workflow permissions
     */
    public function test_blog_workflow_permissions()
    {
        $manager = User::factory()->create();
        $manager->assignRole($this->manager);

        $blogPost = BlogPost::factory()->create([
            'status' => BlogPost::STATUS_REVIEW,
            'author_id' => 999, // Different author
        ]);

        // Manager with blog.publish can approve posts
        $this->assertTrue($manager->can('approve', $blogPost));
        $this->assertTrue($manager->can('reject', $blogPost));
    }

    /**
     * Test user hierarchy permissions
     */
    public function test_user_hierarchy_permissions()
    {
        $admin = User::factory()->create();
        $admin->assignRole($this->admin);

        $manager = User::factory()->create();
        $manager->assignRole($this->manager);

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole($this->superAdmin);

        // Admin cannot delete super admin
        $this->assertFalse($admin->can('delete', $superAdmin));

        // Admin can delete manager
        $this->assertTrue($admin->can('delete', $manager));

        // Manager cannot delete admin
        $this->assertFalse($manager->can('delete', $admin));
    }
}