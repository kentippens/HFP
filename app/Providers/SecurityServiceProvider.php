<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class SecurityServiceProvider extends ServiceProvider
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
        $this->configurePasswordDefaults();
        $this->configureRateLimiting();
        $this->enforceHttps();
    }

    /**
     * Configure password validation defaults
     */
    protected function configurePasswordDefaults(): void
    {
        Password::defaults(function () {
            $rule = Password::min(config('security.auth.password.min_length', 12));

            if (config('security.auth.password.require_uppercase', true)) {
                $rule->mixedCase();
            }

            if (config('security.auth.password.require_numbers', true)) {
                $rule->numbers();
            }

            if (config('security.auth.password.require_symbols', true)) {
                $rule->symbols();
            }

            if (config('security.auth.password.compromised_check', true) && app()->environment('production')) {
                $rule->uncompromised();
            }

            return $rule;
        });
    }

    /**
     * Configure rate limiting for authentication endpoints
     */
    protected function configureRateLimiting(): void
    {
        // Admin login rate limiting
        RateLimiter::for('admin-login', function (Request $request) {
            return Limit::perMinute(
                config('security.rate_limits.login.attempts', 5)
            )->by($request->email ?: $request->ip())
            ->response(function () {
                return response()->json([
                    'message' => 'Too many login attempts. Please try again later.',
                ], 429);
            });
        });

        // Password reset rate limiting
        RateLimiter::for('password-reset', function (Request $request) {
            return Limit::perHour(
                config('security.rate_limits.password_reset.attempts', 3)
            )->by($request->email ?: $request->ip());
        });

        // API rate limiting
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(
                config('security.rate_limits.api.attempts', 60)
            )->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Enforce HTTPS in production
     */
    protected function enforceHttps(): void
    {
        if (config('security.https.force_https', false)) {
            \URL::forceScheme('https');
        }
    }
}