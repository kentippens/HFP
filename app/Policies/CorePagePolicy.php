<?php

namespace App\Policies;

use App\Models\CorePage;
use App\Models\User;

class CorePagePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasAnyPermission($user, ['services.view', 'admin.access']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CorePage $corePage): bool
    {
        return $this->hasPermission($user, 'services.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Core pages are system-level, only admins can create
        return $this->hasPermission($user, 'services.create') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CorePage $corePage): bool
    {
        return $this->hasPermission($user, 'services.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CorePage $corePage): bool
    {
        // Core pages should rarely be deleted, only super admins
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CorePage $corePage): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CorePage $corePage): bool
    {
        return $user->isSuperAdmin();
    }
}