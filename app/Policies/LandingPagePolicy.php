<?php

namespace App\Policies;

use App\Models\LandingPage;
use App\Models\User;

class LandingPagePolicy extends BasePolicy
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
    public function view(User $user, LandingPage $landingPage): bool
    {
        return $this->hasPermission($user, 'services.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'services.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LandingPage $landingPage): bool
    {
        return $this->hasPermission($user, 'services.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LandingPage $landingPage): bool
    {
        return $this->hasPermission($user, 'services.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LandingPage $landingPage): bool
    {
        return $this->hasPermission($user, 'services.delete') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LandingPage $landingPage): bool
    {
        return $this->hasPermission($user, 'services.delete') && $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can publish/unpublish the landing page.
     */
    public function publish(User $user, LandingPage $landingPage): bool
    {
        return $this->hasPermission($user, 'services.publish');
    }
}