<?php

namespace App\Policies;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BlogPostPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'blog.view') ||
               $this->hasPermission($user, 'admin.access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BlogPost $blogPost): bool
    {
        // Can view if has blog.view permission
        if ($this->hasPermission($user, 'blog.view')) {
            return true;
        }

        // Authors can view their own posts
        if ($blogPost->author_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'blog.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BlogPost $blogPost): bool
    {
        // Check if user has blog.edit permission
        if ($this->hasPermission($user, 'blog.edit')) {
            // Admins can edit any post
            if ($this->isAdmin($user)) {
                return true;
            }

            // Authors can edit their own posts
            if ($blogPost->author_id === $user->id) {
                return true;
            }

            // Managers can edit any post
            if ($user->hasRole('manager')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BlogPost $blogPost): bool
    {
        // Must have blog.delete permission
        if (!$this->hasPermission($user, 'blog.delete')) {
            return false;
        }

        // Admins can delete any post
        if ($this->isAdmin($user)) {
            return true;
        }

        // Authors can delete their own posts if they're drafts
        if ($blogPost->author_id === $user->id && $blogPost->status === BlogPost::STATUS_DRAFT) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BlogPost $blogPost): bool
    {
        return $this->hasPermission($user, 'blog.delete') && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BlogPost $blogPost): bool
    {
        return $this->hasPermission($user, 'blog.delete') && $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can publish the model.
     */
    public function publish(User $user, BlogPost $blogPost): bool
    {
        return $this->hasPermission($user, 'blog.publish');
    }

    /**
     * Determine whether the user can change the post status.
     */
    public function changeStatus(User $user, BlogPost $blogPost, string $newStatus): bool
    {
        // Must have publish permission for status changes
        if (!$this->hasPermission($user, 'blog.publish')) {
            return false;
        }

        // Check workflow rules
        if (!$blogPost->canTransitionTo($newStatus)) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can approve the post.
     */
    public function approve(User $user, BlogPost $blogPost): bool
    {
        // Must have publish permission
        if (!$this->hasPermission($user, 'blog.publish')) {
            return false;
        }

        // Post must be in review status
        if ($blogPost->status !== BlogPost::STATUS_REVIEW) {
            return false;
        }

        // Cannot approve own posts unless admin
        if ($blogPost->author_id === $user->id && !$this->isAdmin($user)) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can reject the post.
     */
    public function reject(User $user, BlogPost $blogPost): bool
    {
        return $this->approve($user, $blogPost);
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, BlogPost $blogPost): bool
    {
        return $this->hasPermission($user, 'blog.create');
    }
}