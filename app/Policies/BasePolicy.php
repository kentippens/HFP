<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class BasePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     * Super admins can do everything.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Check if user has permission
     */
    protected function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermission($permission);
    }

    /**
     * Check if user has any of the permissions
     */
    protected function hasAnyPermission(User $user, array $permissions): bool
    {
        return $user->hasAnyPermission($permissions);
    }

    /**
     * Check if user has all permissions
     */
    protected function hasAllPermissions(User $user, array $permissions): bool
    {
        return $user->hasAllPermissions($permissions);
    }

    /**
     * Check if user is admin (super admin or admin role)
     */
    protected function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }
}