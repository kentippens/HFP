<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\ContactSubmission;
use App\Models\CorePage;
use App\Models\LandingPage;
use App\Models\Service;
use App\Models\Silo;
use App\Models\TrackingScript;
use App\Models\User;
use App\Policies\BlogPostPolicy;
use App\Policies\BlogCategoryPolicy;
use App\Policies\ContactSubmissionPolicy;
use App\Policies\CorePagePolicy;
use App\Policies\LandingPagePolicy;
use App\Policies\ServicePolicy;
use App\Policies\SiloPolicy;
use App\Policies\TrackingScriptPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        BlogPost::class => BlogPostPolicy::class,
        BlogCategory::class => BlogCategoryPolicy::class,
        ContactSubmission::class => ContactSubmissionPolicy::class,
        CorePage::class => CorePagePolicy::class,
        LandingPage::class => LandingPagePolicy::class,
        Service::class => ServicePolicy::class,
        Silo::class => SiloPolicy::class,
        TrackingScript::class => TrackingScriptPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define additional gates if needed

        // Gate for accessing Filament admin panel
        Gate::define('access-filament', function (User $user) {
            return $user->hasPermission('admin.access');
        });

        // Gate for viewing logs
        Gate::define('view-logs', function (User $user) {
            return $user->hasPermission('logs.view');
        });

        // Gate for managing settings
        Gate::define('manage-settings', function (User $user) {
            return $user->hasPermission('settings.edit');
        });

        // Gate for viewing reports
        Gate::define('view-reports', function (User $user) {
            return $user->hasPermission('reports.view');
        });

        // Gate for managing backups
        Gate::define('manage-backups', function (User $user) {
            return $user->hasPermission('backups.manage');
        });

        // Gate for managing cache
        Gate::define('manage-cache', function (User $user) {
            return $user->hasPermission('cache.manage');
        });

        // Super admin gate
        Gate::define('super-admin', function (User $user) {
            return $user->isSuperAdmin();
        });

        // Admin gate (super admin or admin)
        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });

        // Manager gate
        Gate::define('manager', function (User $user) {
            return $user->hasRole('manager');
        });

        // Employee gate
        Gate::define('employee', function (User $user) {
            return $user->hasRole('employee');
        });
    }
}