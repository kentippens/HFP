<?php

namespace App\Providers;

use App\Models\Service;
use App\Observers\ServiceObserver;
use App\Listeners\AuthenticationListener;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Service Observer
        Service::observe(ServiceObserver::class);

        // Register authentication event subscriber
        Event::subscribe(AuthenticationListener::class);

        // Custom Blade directive for optimized icons
        \Blade::directive('icon', function ($expression) {
            return "<?php echo view('components.icons', ['class' => $expression])->render(); ?>";
        });

        // Provide active top-level services to header and mobile menu components
        View::composer(['components.header', 'components.mobile-menu-new'], function ($view) {
            $view->with('services', Service::active()->topLevel()->ordered()->get());
        });

        // Configure Sentry user context
        if (app()->bound('sentry')) {
            \Sentry\configureScope(function (\Sentry\State\Scope $scope): void {
                if ($user = auth()->user()) {
                    $scope->setUser([
                        'id' => $user->id,
                        'username' => $user->name,
                        'email' => $user->email,
                        'ip_address' => request()->ip(),
                    ]);

                    // Add user role tag for filtering
                    $scope->setTag('user_role', $user->is_admin ? 'admin' : 'user');
                }
            });
        }
    }
}
