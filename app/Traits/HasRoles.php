<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;
use App\Exceptions\RoleNotFoundException;
use App\Exceptions\PermissionNotFoundException;
use App\Exceptions\RoleAssignmentException;
use App\Exceptions\UnauthorizedRoleAssignmentException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

trait HasRoles
{
    /**
     * Get user's roles
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withPivot(['assigned_at', 'expires_at'])
            ->withTimestamps();
    }

    /**
     * Get user's direct permissions
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_user')
            ->withPivot(['assigned_at', 'expires_at'])
            ->withTimestamps();
    }

    /**
     * Get all permissions (from roles and direct) with caching
     */
    public function getAllPermissions(): Collection
    {
        try {
            $cacheKey = "user_permissions_{$this->id}";
            
            return Cache::remember($cacheKey, 300, function () {
                $rolePermissions = $this->roles()
                    ->with('permissions')
                    ->get()
                    ->pluck('permissions')
                    ->flatten();

                $directPermissions = $this->permissions;

                return $rolePermissions->merge($directPermissions)->unique('id');
            });
        } catch (\Exception $e) {
            Log::error('Error getting all permissions', [
                'user_id' => $this->id,
                'error' => $e->getMessage(),
            ]);
            return collect();
        }
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles()->where('slug', $role)->exists();
        }

        if (is_array($role)) {
            return $this->roles()->whereIn('slug', $role)->exists();
        }

        return $this->roles->contains($role);
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole($roles): bool
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }

        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has all of the given roles
     */
    public function hasAllRoles($roles): bool
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }

        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if user has a specific permission with caching
     */
    public function hasPermission($permission): bool
    {
        try {
            // Super admin bypass
            if ($this->isSuperAdmin()) {
                return true;
            }
            
            // Cache permission check for performance
            $cacheKey = "user_{$this->id}_has_permission_{$permission}";
            
            return Cache::remember($cacheKey, 300, function () use ($permission) {
                // Check direct permissions
                if ($this->permissions()->where('slug', $permission)->exists()) {
                    return true;
                }

                // Check role permissions
                return $this->roles()
                    ->whereHas('permissions', function ($query) use ($permission) {
                        $query->where('slug', $permission);
                    })->exists();
            });
        } catch (\Exception $e) {
            Log::error('Error checking permission', [
                'user_id' => $this->id,
                'permission' => $permission,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission($permissions): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (is_string($permissions)) {
            return $this->hasPermission($permissions);
        }

        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has all of the given permissions
     */
    public function hasAllPermissions($permissions): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (is_string($permissions)) {
            return $this->hasPermission($permissions);
        }

        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Assign role to user with validation and error handling
     */
    public function assignRole($role)
    {
        try {
            DB::beginTransaction();
            
            if (is_string($role)) {
                $role = Role::where('slug', $role)->first();
                if (!$role) {
                    throw new RoleNotFoundException($role);
                }
            }
            
            if (!$role instanceof Role) {
                throw new RoleAssignmentException('Invalid role provided');
            }
            
            // Check if current user can assign this role
            if (auth()->check() && !auth()->user()->isSuperAdmin()) {
                $currentUserLevel = auth()->user()->roles()->max('level') ?? 0;
                if ($role->level > $currentUserLevel) {
                    throw new UnauthorizedRoleAssignmentException($role->slug);
                }
            }

            if (!$this->roles->contains($role->id)) {
                $this->roles()->attach($role->id, [
                    'assigned_at' => now()
                ]);
                
                // Clear cache
                Cache::forget("user_roles_{$this->id}");
                Cache::forget("user_permissions_{$this->id}");
                
                // Log the assignment
                Log::info('Role assigned to user', [
                    'user_id' => $this->id,
                    'role_id' => $role->id,
                    'role_slug' => $role->slug,
                    'assigned_by' => auth()->id(),
                ]);
            }
            
            DB::commit();
            return $this;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to assign role', [
                'user_id' => $this->id,
                'role' => $role,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Remove role from user with validation and error handling
     */
    public function removeRole($role)
    {
        try {
            DB::beginTransaction();
            
            if (is_string($role)) {
                $role = Role::where('slug', $role)->first();
                if (!$role) {
                    throw new RoleNotFoundException($role);
                }
            }
            
            if (!$role instanceof Role) {
                throw new RoleAssignmentException('Invalid role provided');
            }
            
            // Prevent removal of last admin role if it would leave no admins
            if ($role->slug === 'super-admin' || $role->slug === 'admin') {
                $adminCount = \App\Models\User::whereHas('roles', function ($q) {
                    $q->whereIn('slug', ['super-admin', 'admin']);
                })->count();
                
                if ($adminCount <= 1 && $this->hasRole($role->slug)) {
                    throw new RoleAssignmentException('Cannot remove the last admin role');
                }
            }

            if ($this->roles->contains($role->id)) {
                $this->roles()->detach($role->id);
                
                // Clear cache
                Cache::forget("user_roles_{$this->id}");
                Cache::forget("user_permissions_{$this->id}");
                
                // Log the removal
                Log::info('Role removed from user', [
                    'user_id' => $this->id,
                    'role_id' => $role->id,
                    'role_slug' => $role->slug,
                    'removed_by' => auth()->id(),
                ]);
            }
            
            DB::commit();
            return $this;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to remove role', [
                'user_id' => $this->id,
                'role' => $role,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Sync user roles
     */
    public function syncRoles($roles)
    {
        $roleIds = collect($roles)->map(function ($role) {
            if (is_numeric($role)) {
                return $role;
            }
            if (is_string($role)) {
                return Role::where('slug', $role)->first()?->id;
            }
            return $role->id ?? null;
        })->filter()->toArray();

        $this->roles()->sync($roleIds);

        return $this;
    }

    /**
     * Give permission directly to user with validation and error handling
     */
    public function givePermission($permission)
    {
        try {
            DB::beginTransaction();
            
            if (is_string($permission)) {
                $permission = Permission::where('slug', $permission)->first();
                if (!$permission) {
                    throw new PermissionNotFoundException($permission);
                }
            }
            
            if (!$permission instanceof Permission) {
                throw new RoleAssignmentException('Invalid permission provided');
            }

            if (!$this->permissions->contains($permission->id)) {
                $this->permissions()->attach($permission->id, [
                    'assigned_at' => now()
                ]);
                
                // Clear cache
                Cache::forget("user_permissions_{$this->id}");
                
                // Log the assignment
                Log::info('Permission assigned to user', [
                    'user_id' => $this->id,
                    'permission_id' => $permission->id,
                    'permission_slug' => $permission->slug,
                    'assigned_by' => auth()->id(),
                ]);
            }
            
            DB::commit();
            return $this;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to assign permission', [
                'user_id' => $this->id,
                'permission' => $permission,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Revoke permission from user
     */
    public function revokePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->first();
        }

        if ($permission) {
            $this->permissions()->detach($permission->id);
        }

        return $this;
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Check if user is admin (super admin or admin)
     */
    public function isAdmin(): bool
    {
        return $this->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Check if user can perform an action
     */
    public function can($abilities, $arguments = [])
    {
        // First check Laravel's built-in authorization
        if (parent::can($abilities, $arguments)) {
            return true;
        }

        // Then check our permission system
        if (is_string($abilities)) {
            return $this->hasPermission($abilities);
        }

        return false;
    }

    /**
     * Get active roles (not expired)
     */
    public function getActiveRoles()
    {
        return $this->roles()
            ->where(function ($query) {
                $query->whereNull('role_user.expires_at')
                    ->orWhere('role_user.expires_at', '>', now());
            })
            ->get();
    }

    /**
     * Get active permissions (not expired)
     */
    public function getActivePermissions()
    {
        return $this->permissions()
            ->where(function ($query) {
                $query->whereNull('permission_user.expires_at')
                    ->orWhere('permission_user.expires_at', '>', now());
            })
            ->get();
    }
}