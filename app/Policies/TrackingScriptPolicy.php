<?php

namespace App\Policies;

use App\Models\TrackingScript;
use App\Models\User;

class TrackingScriptPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasAnyPermission($user, ['settings.view', 'analytics.view', 'admin.access']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TrackingScript $trackingScript): bool
    {
        return $this->hasAnyPermission($user, ['settings.view', 'analytics.view']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Tracking scripts affect entire site, need admin permissions
        return $this->hasPermission($user, 'settings.edit') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TrackingScript $trackingScript): bool
    {
        return $this->hasPermission($user, 'settings.edit') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TrackingScript $trackingScript): bool
    {
        return $this->hasPermission($user, 'settings.edit') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TrackingScript $trackingScript): bool
    {
        return $this->hasPermission($user, 'settings.edit') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TrackingScript $trackingScript): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can toggle script activation.
     */
    public function toggle(User $user, TrackingScript $trackingScript): bool
    {
        return $this->hasPermission($user, 'settings.edit') && $this->isAdmin($user);
    }
}