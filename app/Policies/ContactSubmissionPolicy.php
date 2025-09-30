<?php

namespace App\Policies;

use App\Models\ContactSubmission;
use App\Models\User;

class ContactSubmissionPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasAnyPermission($user, ['leads.view', 'admin.access']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->hasPermission($user, 'leads.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'leads.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->hasPermission($user, 'leads.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->hasPermission($user, 'leads.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->hasPermission($user, 'leads.delete') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->hasPermission($user, 'leads.delete') && $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can export contact submissions.
     */
    public function export(User $user): bool
    {
        return $this->hasPermission($user, 'leads.export');
    }

    /**
     * Determine whether the user can mark as read/unread.
     */
    public function markAsRead(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->hasPermission($user, 'leads.edit');
    }

    /**
     * Determine whether the user can mark as spam.
     */
    public function markAsSpam(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->hasPermission($user, 'leads.edit');
    }

    /**
     * Determine whether the user can assign the lead to someone.
     */
    public function assign(User $user, ContactSubmission $contactSubmission): bool
    {
        return $this->hasPermission($user, 'leads.edit') &&
               ($this->isAdmin($user) || $user->hasRole('manager'));
    }
}