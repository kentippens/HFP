<?php

namespace App\Policies;

use App\Models\Silo;
use App\Models\User;

class SiloPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasAnyPermission($user, ['seo.view', 'services.view', 'admin.access']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Silo $silo): bool
    {
        return $this->hasAnyPermission($user, ['seo.view', 'services.view']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Silos are SEO-critical, need higher permissions
        return $this->hasPermission($user, 'seo.edit') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Silo $silo): bool
    {
        return $this->hasPermission($user, 'seo.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Silo $silo): bool
    {
        // Silos affect SEO structure, only super admins can delete
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Silo $silo): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Silo $silo): bool
    {
        return $user->isSuperAdmin();
    }
}