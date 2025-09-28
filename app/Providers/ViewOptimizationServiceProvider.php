<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class ViewOptimizationServiceProvider extends ServiceProvider
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
        // Register component namespaces
        Blade::componentNamespace('App\\View\\Components\\Pool', 'pool');

        // Register custom blade directives
        $this->registerBladeDirectives();

        // Pre-compile frequently used views
        $this->precompileViews();

        // Share common data with all views
        $this->shareCommonData();

        // Register view composers for complex data
        $this->registerViewComposers();
    }

    /**
     * Register custom blade directives
     */
    protected function registerBladeDirectives(): void
    {
        // Cached include directive
        Blade::directive('cachedInclude', function ($expression) {
            list($view, $data) = $this->parseExpression($expression);
            return "<?php echo \\Cache::remember('view.' . md5({$view}), 3600, function() use (\$__env) {
                return \$__env->make({$view}, {$data} ?? [])->render();
            }); ?>";
        });

        // Lazy include directive (loads via AJAX)
        Blade::directive('lazyInclude', function ($expression) {
            list($view, $data) = $this->parseExpression($expression);
            return "<?php echo '<div class=\"lazy-load\" data-view=\"' . {$view} . '\"></div>'; ?>";
        });

        // Fragment caching directive
        Blade::directive('cache', function ($expression) {
            return "<?php if(! \\Cache::has({$expression})): ?>";
        });

        Blade::directive('endcache', function ($expression) {
            return "<?php \\Cache::put({$expression}, ob_get_contents()); endif; echo \\Cache::get({$expression}); ?>";
        });
    }

    /**
     * Parse blade directive expression
     */
    protected function parseExpression($expression): array
    {
        $segments = explode(',', $expression, 2);
        $view = trim($segments[0], " '\"");
        $data = isset($segments[1]) ? trim($segments[1]) : '[]';
        return [$view, $data];
    }

    /**
     * Pre-compile frequently used views
     */
    protected function precompileViews(): void
    {
        if ($this->app->environment('production')) {
            $viewsToCompile = [
                'partials.breadcrumb',
                'silos.partials.main-content',
                'silos.partials.cta-section',
                'components.pool.sidebar-contact-form',
                'components.pool.trust-badges',
                'components.pool.limited-offer',
            ];

            foreach ($viewsToCompile as $view) {
                if (View::exists($view)) {
                    View::getFinder()->find($view);
                }
            }
        }
    }

    /**
     * Share common data with all views
     */
    protected function shareCommonData(): void
    {
        View::share('companyPhone', config('company.phone', '469-956-0505'));
        View::share('companyEmail', config('company.email', 'info@hexagonservices.com'));
        View::share('companyName', config('company.name', 'Hexagon Services'));
    }

    /**
     * Register view composers for complex data
     */
    protected function registerViewComposers(): void
    {
        // Compose sidebar data for pool service pages
        View::composer('silos.templates.pool-*', function ($view) {
            $view->with('serviceAreas', $this->getServiceAreas());
        });

        // Compose trust badges data
        View::composer('components.pool.trust-badges', function ($view) {
            if (!$view->offsetExists('badges')) {
                $view->with('badges', $this->getTrustBadges());
            }
        });
    }

    /**
     * Get service areas
     */
    protected function getServiceAreas(): array
    {
        return cache()->remember('service-areas', 3600, function () {
            return [
                'Dallas',
                'Fort Worth',
                'Plano',
                'Arlington',
                'Frisco',
                'McKinney',
                'Allen',
                'Richardson',
                'Carrollton',
                'Grand Prairie',
            ];
        });
    }

    /**
     * Get trust badges
     */
    protected function getTrustBadges(): array
    {
        return [
            ['icon' => 'fa-shield-alt', 'text' => '25-Year Warranty'],
            ['icon' => 'fa-clock', 'text' => '5-7 Day Installation'],
            ['icon' => 'fa-award', 'text' => 'Licensed & Insured'],
            ['icon' => 'fa-users', 'text' => '500+ Happy Customers'],
            ['icon' => 'fa-check-circle', 'text' => 'No Hidden Fees'],
            ['icon' => 'fa-star', 'text' => '5-Star Reviews'],
        ];
    }
}