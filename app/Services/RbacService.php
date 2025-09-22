<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Exceptions\RbacException;
use App\Exceptions\RoleNotFoundException;
use App\Exceptions\PermissionNotFoundException;
use App\Exceptions\InvalidRoleException;
use App\Exceptions\InvalidPermissionException;
use App\Exceptions\UnauthorizedRoleAssignmentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RbacService
{
    /**
     * Validate and create a new role
     */
    public function createRole(array $data): Role
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string|max:500',
            'level' => 'required|integer|min:0|max:100',
            'is_default' => 'boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            DB::beginTransaction();

            // Ensure only one default role
            if (!empty($data['is_default'])) {
                Role::where('is_default', true)->update(['is_default' => false]);
            }

            $role = Role::create($data);

            // Assign permissions if provided
            if (!empty($data['permissions'])) {
                $this->syncRolePermissions($role, $data['permissions']);
            }

            DB::commit();

            Log::info('Role created', [
                'role_id' => $role->id,
                'role_slug' => $role->slug,
                'created_by' => auth()->id(),
            ]);

            $this->clearRbacCache();

            return $role;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create role', [
                'data' => $data,
                'error' => $e->getMessage(),
            ]);
            throw new RbacException('Failed to create role: ' . $e->getMessage());
        }
    }

    /**
     * Validate and update a role
     */
    public function updateRole(Role $role, array $data): Role
    {
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:roles,slug,' . $role->id,
            'description' => 'nullable|string|max:500',
            'level' => 'sometimes|required|integer|min:0|max:100',
            'is_default' => 'boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            DB::beginTransaction();

            // Prevent modification of super-admin role
            if ($role->slug === 'super-admin' && !auth()->user()->isSuperAdmin()) {
                throw new UnauthorizedRoleAssignmentException('super-admin');
            }

            // Ensure only one default role
            if (!empty($data['is_default']) && !$role->is_default) {
                Role::where('is_default', true)->update(['is_default' => false]);
            }

            $role->update($data);

            // Update permissions if provided
            if (isset($data['permissions'])) {
                $this->syncRolePermissions($role, $data['permissions']);
            }

            DB::commit();

            Log::info('Role updated', [
                'role_id' => $role->id,
                'role_slug' => $role->slug,
                'updated_by' => auth()->id(),
            ]);

            $this->clearRbacCache();

            return $role;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update role', [
                'role_id' => $role->id,
                'data' => $data,
                'error' => $e->getMessage(),
            ]);
            throw new RbacException('Failed to update role: ' . $e->getMessage());
        }
    }

    /**
     * Delete a role with safety checks
     */
    public function deleteRole(Role $role): bool
    {
        try {
            DB::beginTransaction();

            // Prevent deletion of system roles
            if (in_array($role->slug, ['super-admin', 'admin', 'customer'])) {
                throw new InvalidRoleException('Cannot delete system roles');
            }

            // Check if role has users
            if ($role->users()->count() > 0) {
                throw new InvalidRoleException('Cannot delete role with assigned users');
            }

            $role->delete();

            DB::commit();

            Log::info('Role deleted', [
                'role_id' => $role->id,
                'role_slug' => $role->slug,
                'deleted_by' => auth()->id(),
            ]);

            $this->clearRbacCache();

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete role', [
                'role_id' => $role->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Sync permissions for a role
     */
    public function syncRolePermissions(Role $role, array $permissions): void
    {
        $permissionIds = [];

        foreach ($permissions as $permission) {
            if (is_numeric($permission)) {
                $permissionIds[] = $permission;
            } elseif (is_string($permission)) {
                $perm = Permission::where('slug', $permission)->first();
                if (!$perm) {
                    throw new PermissionNotFoundException($permission);
                }
                $permissionIds[] = $perm->id;
            }
        }

        $role->permissions()->sync($permissionIds);
    }

    /**
     * Validate and create a new permission
     */
    public function createPermission(array $data): Permission
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:permissions',
            'group' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $permission = Permission::create($data);

            Log::info('Permission created', [
                'permission_id' => $permission->id,
                'permission_slug' => $permission->slug,
                'created_by' => auth()->id(),
            ]);

            $this->clearRbacCache();

            return $permission;

        } catch (\Exception $e) {
            Log::error('Failed to create permission', [
                'data' => $data,
                'error' => $e->getMessage(),
            ]);
            throw new RbacException('Failed to create permission: ' . $e->getMessage());
        }
    }

    /**
     * Bulk assign roles to multiple users
     */
    public function bulkAssignRoles(array $userIds, array $roleIds): array
    {
        $results = [
            'success' => [],
            'failed' => [],
        ];

        foreach ($userIds as $userId) {
            try {
                $user = User::findOrFail($userId);
                $user->roles()->sync($roleIds);
                $results['success'][] = $userId;
            } catch (\Exception $e) {
                $results['failed'][$userId] = $e->getMessage();
                Log::error('Failed to assign roles to user', [
                    'user_id' => $userId,
                    'role_ids' => $roleIds,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->clearRbacCache();

        return $results;
    }

    /**
     * Check if a user can perform an action on a resource
     */
    public function authorize(User $user, string $permission, $resource = null): bool
    {
        try {
            // Super admin bypass
            if ($user->isSuperAdmin()) {
                return true;
            }

            // Basic permission check
            if (!$user->hasPermission($permission)) {
                return false;
            }

            // Resource-specific checks
            if ($resource) {
                return $this->checkResourcePermission($user, $permission, $resource);
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Authorization check failed', [
                'user_id' => $user->id,
                'permission' => $permission,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Check resource-specific permissions
     */
    protected function checkResourcePermission(User $user, string $permission, $resource): bool
    {
        // Implement resource-specific logic here
        // For example, check if user owns the resource
        
        if (method_exists($resource, 'user_id')) {
            return $resource->user_id === $user->id;
        }

        if (method_exists($resource, 'owner')) {
            return $resource->owner->id === $user->id;
        }

        return true;
    }

    /**
     * Get permission statistics
     */
    public function getPermissionStats(): array
    {
        return Cache::remember('rbac_stats', 3600, function () {
            $roles = Role::withCount('permissions')->get();
            $avgPermissions = $roles->count() > 0 ? $roles->avg('permissions_count') : 0;
            
            return [
                'total_roles' => Role::count(),
                'total_permissions' => Permission::count(),
                'users_with_roles' => User::has('roles')->count(),
                'users_with_direct_permissions' => User::has('permissions')->count(),
                'permission_groups' => Permission::distinct('group')->count('group'),
                'average_permissions_per_role' => round($avgPermissions, 2),
            ];
        });
    }

    /**
     * Clear all RBAC-related cache
     */
    public function clearRbacCache(): void
    {
        Cache::tags(['rbac'])->flush();
        Cache::forget('rbac_stats');
        
        // Clear user-specific caches
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                Cache::forget("user_roles_{$user->id}");
                Cache::forget("user_permissions_{$user->id}");
            }
        });
    }

    /**
     * Audit user permissions
     */
    public function auditUserPermissions(User $user): array
    {
        return [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'roles' => $user->roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'slug' => $role->slug,
                    'level' => $role->level,
                    'assigned_at' => $role->pivot->assigned_at,
                    'expires_at' => $role->pivot->expires_at,
                ];
            }),
            'direct_permissions' => $user->permissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'slug' => $permission->slug,
                    'group' => $permission->group,
                    'assigned_at' => $permission->pivot->assigned_at,
                    'expires_at' => $permission->pivot->expires_at,
                ];
            }),
            'all_permissions' => $user->getAllPermissions()->pluck('slug')->unique()->sort()->values(),
            'is_super_admin' => $user->isSuperAdmin(),
            'is_admin' => $user->isAdmin(),
        ];
    }
}