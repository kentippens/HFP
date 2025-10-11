<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BlogPostRepository;
use App\Repositories\SiloRepository;
use App\Repositories\CorePageRepository;
use App\Repositories\ServiceRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register repositories as singletons for better performance
        $this->app->singleton(BlogPostRepository::class, function ($app) {
            return new BlogPostRepository($app->make(\App\Models\BlogPost::class));
        });

        $this->app->singleton(SiloRepository::class, function ($app) {
            return new SiloRepository($app->make(\App\Models\Silo::class));
        });

        $this->app->singleton(CorePageRepository::class, function ($app) {
            return new CorePageRepository($app->make(\App\Models\CorePage::class));
        });

        $this->app->singleton(ServiceRepository::class, function ($app) {
            return new ServiceRepository($app->make(\App\Models\Service::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
