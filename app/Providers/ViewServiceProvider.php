<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\TrackingScriptComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register the tracking script composer for both layouts
        View::composer(['layouts.app', 'layouts.app-optimized'], TrackingScriptComposer::class);
        
        // In production, alias the optimized layout to the main layout
        if (app()->environment('production')) {
            View::alias('layouts.app-optimized', 'layouts.app');
        }
    }
}