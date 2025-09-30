<?php

namespace App\Policies;

use App\Models\BlogCategory;
use App\Models\User;

class BlogCategoryPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasAnyPermission($user, ['blog.view', 'admin.access']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BlogCategory $blogCategory): bool
    {
        return $this->hasPermission($user, 'blog.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Blog categories affect all posts, so need higher permission
        return $this->hasPermission($user, 'blog.create') &&
               ($this->isAdmin($user) || $user->hasRole('manager'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BlogCategory $blogCategory): bool
    {
        return $this->hasPermission($user, 'blog.edit') &&
               ($this->isAdmin($user) || $user->hasRole('manager'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BlogCategory $blogCategory): bool
    {
        // Check if category has posts
        if ($blogCategory->blogPosts()->exists()) {
            // Only super admin can delete categories with posts
            return $user->isSuperAdmin();
        }

        return $this->hasPermission($user, 'blog.delete') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BlogCategory $blogCategory): bool
    {
        return $this->hasPermission($user, 'blog.delete') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BlogCategory $blogCategory): bool
    {
        return $user->isSuperAdmin();
    }
}