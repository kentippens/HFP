<?php

namespace App\Providers;

use App\Models\Service;
use App\Observers\ServiceObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        
        // Custom Blade directive for optimized icons
        \Blade::directive('icon', function ($expression) {
            return "<?php echo view('components.icons', ['class' => $expression])->render(); ?>";
        });

        // Provide active top-level services to header and mobile menu components
        View::composer(['components.header', 'components.mobile-menu-new'], function ($view) {
            $view->with('services', Service::active()->topLevel()->ordered()->get());
        });
    }
}
