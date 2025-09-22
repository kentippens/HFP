<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Rate limiter for contact forms - 3 per minute
        RateLimiter::for('contact-form', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        // Daily rate limiter for contact forms - 20 per day
        RateLimiter::for('contact-form-daily', function (Request $request) {
            return Limit::perDay(20)->by($request->ip());
        });

        // API rate limiter (default)
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}