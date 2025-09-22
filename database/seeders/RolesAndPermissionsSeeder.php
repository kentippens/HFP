<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $superAdmin = Role::firstOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'Super Administrator',
                'description' => 'Full system access with all privileges',
                'level' => 100,
                'is_default' => false
            ]
        );

        $admin = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrator',
                'description' => 'Administrative access with most privileges',
                'level' => 50,
                'is_default' => false
            ]
        );

        $manager = Role::firstOrCreate(
            ['slug' => 'manager'],
            [
                'name' => 'Manager',
                'description' => 'Manage services and content',
                'level' => 30,
                'is_default' => false
            ]
        );

        $employee = Role::firstOrCreate(
            ['slug' => 'employee'],
            [
                'name' => 'Employee',
                'description' => 'Basic employee access',
                'level' => 20,
                'is_default' => false
            ]
        );

        $customer = Role::firstOrCreate(
            ['slug' => 'customer'],
            [
                'name' => 'Customer',
                'description' => 'Customer access to services',
                'level' => 10,
                'is_default' => true
            ]
        );

        // Create Permissions by Group

        // User Management Permissions
        $userPermissions = [
            ['name' => 'View Users', 'slug' => 'users.view', 'group' => 'users', 'description' => 'View user list and profiles'],
            ['name' => 'Create Users', 'slug' => 'users.create', 'group' => 'users', 'description' => 'Create new users'],
            ['name' => 'Edit Users', 'slug' => 'users.edit', 'group' => 'users', 'description' => 'Edit user information'],
            ['name' => 'Delete Users', 'slug' => 'users.delete', 'group' => 'users', 'description' => 'Delete users'],
            ['name' => 'Manage User Roles', 'slug' => 'users.roles', 'group' => 'users', 'description' => 'Assign and manage user roles'],
        ];

        // Service Management Permissions
        $servicePermissions = [
            ['name' => 'View Services', 'slug' => 'services.view', 'group' => 'services', 'description' => 'View service listings'],
            ['name' => 'Create Services', 'slug' => 'services.create', 'group' => 'services', 'description' => 'Create new services'],
            ['name' => 'Edit Services', 'slug' => 'services.edit', 'group' => 'services', 'description' => 'Edit service information'],
            ['name' => 'Delete Services', 'slug' => 'services.delete', 'group' => 'services', 'description' => 'Delete services'],
            ['name' => 'Publish Services', 'slug' => 'services.publish', 'group' => 'services', 'description' => 'Publish and unpublish services'],
        ];

        // Blog Management Permissions
        $blogPermissions = [
            ['name' => 'View Blog Posts', 'slug' => 'blog.view', 'group' => 'blog', 'description' => 'View blog posts'],
            ['name' => 'Create Blog Posts', 'slug' => 'blog.create', 'group' => 'blog', 'description' => 'Create new blog posts'],
            ['name' => 'Edit Blog Posts', 'slug' => 'blog.edit', 'group' => 'blog', 'description' => 'Edit blog posts'],
            ['name' => 'Delete Blog Posts', 'slug' => 'blog.delete', 'group' => 'blog', 'description' => 'Delete blog posts'],
            ['name' => 'Publish Blog Posts', 'slug' => 'blog.publish', 'group' => 'blog', 'description' => 'Publish and unpublish blog posts'],
        ];

        // Lead Management Permissions
        $leadPermissions = [
            ['name' => 'View Leads', 'slug' => 'leads.view', 'group' => 'leads', 'description' => 'View customer leads'],
            ['name' => 'Create Leads', 'slug' => 'leads.create', 'group' => 'leads', 'description' => 'Create new leads'],
            ['name' => 'Edit Leads', 'slug' => 'leads.edit', 'group' => 'leads', 'description' => 'Edit lead information'],
            ['name' => 'Delete Leads', 'slug' => 'leads.delete', 'group' => 'leads', 'description' => 'Delete leads'],
            ['name' => 'Export Leads', 'slug' => 'leads.export', 'group' => 'leads', 'description' => 'Export lead data'],
        ];

        // Quote Management Permissions
        $quotePermissions = [
            ['name' => 'View Quotes', 'slug' => 'quotes.view', 'group' => 'quotes', 'description' => 'View service quotes'],
            ['name' => 'Create Quotes', 'slug' => 'quotes.create', 'group' => 'quotes', 'description' => 'Create new quotes'],
            ['name' => 'Edit Quotes', 'slug' => 'quotes.edit', 'group' => 'quotes', 'description' => 'Edit quote information'],
            ['name' => 'Delete Quotes', 'slug' => 'quotes.delete', 'group' => 'quotes', 'description' => 'Delete quotes'],
            ['name' => 'Approve Quotes', 'slug' => 'quotes.approve', 'group' => 'quotes', 'description' => 'Approve and reject quotes'],
        ];

        // System Settings Permissions
        $systemPermissions = [
            ['name' => 'View Settings', 'slug' => 'settings.view', 'group' => 'system', 'description' => 'View system settings'],
            ['name' => 'Edit Settings', 'slug' => 'settings.edit', 'group' => 'system', 'description' => 'Edit system settings'],
            ['name' => 'View Logs', 'slug' => 'logs.view', 'group' => 'system', 'description' => 'View system logs'],
            ['name' => 'View Reports', 'slug' => 'reports.view', 'group' => 'system', 'description' => 'View system reports'],
            ['name' => 'Manage Backups', 'slug' => 'backups.manage', 'group' => 'system', 'description' => 'Manage system backups'],
            ['name' => 'Access Admin Panel', 'slug' => 'admin.access', 'group' => 'system', 'description' => 'Access admin panel'],
            ['name' => 'Manage Cache', 'slug' => 'cache.manage', 'group' => 'system', 'description' => 'Clear and manage cache'],
        ];

        // SEO Management Permissions
        $seoPermissions = [
            ['name' => 'View SEO Settings', 'slug' => 'seo.view', 'group' => 'seo', 'description' => 'View SEO settings'],
            ['name' => 'Edit SEO Settings', 'slug' => 'seo.edit', 'group' => 'seo', 'description' => 'Edit SEO settings'],
            ['name' => 'Manage Sitemap', 'slug' => 'sitemap.manage', 'group' => 'seo', 'description' => 'Generate and manage sitemap'],
            ['name' => 'View Analytics', 'slug' => 'analytics.view', 'group' => 'seo', 'description' => 'View analytics data'],
        ];

        // Create all permissions
        $allPermissions = array_merge(
            $userPermissions,
            $servicePermissions,
            $blogPermissions,
            $leadPermissions,
            $quotePermissions,
            $systemPermissions,
            $seoPermissions
        );

        foreach ($allPermissions as $permissionData) {
            Permission::firstOrCreate(
                ['slug' => $permissionData['slug']],
                $permissionData
            );
        }

        // Assign permissions to roles

        // Super Admin gets all permissions (handled by isSuperAdmin check in trait)
        // No need to assign permissions explicitly

        // Admin Role Permissions
        $adminPermissions = Permission::whereIn('slug', [
            // All user permissions except delete
            'users.view', 'users.create', 'users.edit', 'users.roles',
            // All service permissions
            'services.view', 'services.create', 'services.edit', 'services.delete', 'services.publish',
            // All blog permissions
            'blog.view', 'blog.create', 'blog.edit', 'blog.delete', 'blog.publish',
            // All lead permissions
            'leads.view', 'leads.create', 'leads.edit', 'leads.delete', 'leads.export',
            // All quote permissions
            'quotes.view', 'quotes.create', 'quotes.edit', 'quotes.delete', 'quotes.approve',
            // Most system permissions
            'settings.view', 'settings.edit', 'reports.view', 'admin.access', 'cache.manage',
            // All SEO permissions
            'seo.view', 'seo.edit', 'sitemap.manage', 'analytics.view',
        ])->get();

        $admin->syncPermissions($adminPermissions->toArray());

        // Manager Role Permissions
        $managerPermissions = Permission::whereIn('slug', [
            // Limited user permissions
            'users.view',
            // Most service permissions
            'services.view', 'services.create', 'services.edit', 'services.publish',
            // Most blog permissions
            'blog.view', 'blog.create', 'blog.edit', 'blog.publish',
            // Lead permissions
            'leads.view', 'leads.create', 'leads.edit', 'leads.export',
            // Quote permissions
            'quotes.view', 'quotes.create', 'quotes.edit',
            // Basic system permissions
            'reports.view', 'admin.access',
            // SEO viewing
            'seo.view', 'analytics.view',
        ])->get();

        $manager->syncPermissions($managerPermissions->toArray());

        // Employee Role Permissions
        $employeePermissions = Permission::whereIn('slug', [
            // View only for most things
            'services.view',
            'blog.view',
            'leads.view', 'leads.create', 'leads.edit',
            'quotes.view', 'quotes.create',
            'admin.access',
        ])->get();

        $employee->syncPermissions($employeePermissions->toArray());

        // Customer Role - No specific permissions
        // Customers only have access to public areas

        // Assign super-admin role to users with is_admin flag
        $adminUsers = User::where('is_admin', true)->get();
        foreach ($adminUsers as $user) {
            if (!$user->hasRole('super-admin')) {
                $user->assignRole('super-admin');
            }
        }

        $this->command->info('Roles and permissions have been seeded successfully.');
        $this->command->info('Roles created: Super Admin, Admin, Manager, Employee, Customer');
        $this->command->info('Permissions created: ' . count($allPermissions) . ' permissions across 7 groups');
        
        if ($adminUsers->count() > 0) {
            $this->command->info('Super Admin role assigned to ' . $adminUsers->count() . ' existing admin user(s)');
        }
    }
}