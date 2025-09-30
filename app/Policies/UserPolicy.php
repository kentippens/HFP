<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'users.view') ||
               $this->hasPermission($user, 'admin.access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Users can view their own profile
        if ($user->id === $model->id) {
            return true;
        }

        return $this->hasPermission($user, 'users.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'users.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Users can update their own profile (limited fields)
        if ($user->id === $model->id) {
            return true;
        }

        // Need users.edit permission to edit other users
        if (!$this->hasPermission($user, 'users.edit')) {
            return false;
        }

        // Cannot edit users with higher role level
        $currentUserMaxLevel = $user->roles()->max('level') ?? 0;
        $targetUserMaxLevel = $model->roles()->max('level') ?? 0;

        if ($targetUserMaxLevel > $currentUserMaxLevel) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Cannot delete yourself
        if ($user->id === $model->id) {
            return false;
        }

        // Need users.delete permission
        if (!$this->hasPermission($user, 'users.delete')) {
            return false;
        }

        // Cannot delete users with higher role level
        $currentUserMaxLevel = $user->roles()->max('level') ?? 0;
        $targetUserMaxLevel = $model->roles()->max('level') ?? 0;

        if ($targetUserMaxLevel > $currentUserMaxLevel) {
            return false;
        }

        // Prevent deleting the last super admin
        if ($model->isSuperAdmin()) {
            $superAdminCount = User::whereHas('roles', function ($query) {
                $query->where('slug', 'super-admin');
            })->count();

            if ($superAdminCount <= 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $this->hasPermission($user, 'users.delete') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $this->hasPermission($user, 'users.delete') && $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can manage roles for the model.
     */
    public function manageRoles(User $user, User $model): bool
    {
        // Cannot manage your own roles
        if ($user->id === $model->id && !$user->isSuperAdmin()) {
            return false;
        }

        // Need users.roles permission
        if (!$this->hasPermission($user, 'users.roles')) {
            return false;
        }

        // Cannot assign roles to users with higher level
        $currentUserMaxLevel = $user->roles()->max('level') ?? 0;
        $targetUserMaxLevel = $model->roles()->max('level') ?? 0;

        if ($targetUserMaxLevel > $currentUserMaxLevel) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can assign a specific role.
     */
    public function assignRole(User $user, User $model, string $roleSlug): bool
    {
        if (!$this->manageRoles($user, $model)) {
            return false;
        }

        // Get the role being assigned
        $role = \App\Models\Role::where('slug', $roleSlug)->first();
        if (!$role) {
            return false;
        }

        // Cannot assign roles higher than your own highest role
        $currentUserMaxLevel = $user->roles()->max('level') ?? 0;
        if ($role->level > $currentUserMaxLevel) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can manage permissions directly.
     */
    public function managePermissions(User $user, User $model): bool
    {
        // Only super admins can directly assign permissions
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can impersonate another user.
     */
    public function impersonate(User $user, User $model): bool
    {
        // Cannot impersonate yourself
        if ($user->id === $model->id) {
            return false;
        }

        // Only super admins can impersonate
        if (!$user->isSuperAdmin()) {
            return false;
        }

        // Cannot impersonate other super admins
        if ($model->isSuperAdmin()) {
            return false;
        }

        return true;
    }
}