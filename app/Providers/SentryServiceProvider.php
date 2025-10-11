<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Sentry\State\Scope;

class SentryServiceProvider extends ServiceProvider
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
        // Configure Sentry before_send callback to remove sensitive data
        if (app()->bound('sentry') && config('app.env') !== 'local') {
            \Sentry\configureScope(function (Scope $scope): void {
                $scope->addEventProcessor(function (\Sentry\Event $event): ?\Sentry\Event {
                    // Remove sensitive data from request
                    if ($event->getRequest()) {
                        $request = $event->getRequest();

                        // Remove sensitive headers
                        $headers = $request->getHeaders();
                        unset(
                            $headers['authorization'],
                            $headers['cookie'],
                            $headers['x-xsrf-token'],
                            $headers['x-csrf-token']
                        );
                        $request->setHeaders($headers);
                    }

                    return $event;
                });
            });
        }
    }
}
