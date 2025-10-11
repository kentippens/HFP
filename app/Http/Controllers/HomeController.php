<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Repositories\BlogPostRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\CorePageRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        protected BlogPostRepository $blogPostRepository,
        protected ServiceRepository $serviceRepository,
        protected CorePageRepository $corePageRepository
    ) {}
    public function index()
    {
        $recentPosts = $this->blogPostRepository->getPublishedRecent(3);

        // Get the 4 core services as silos
        $coreServiceData = [
            [
                'name' => 'Pool Resurfacing',
                'slug' => 'pool-resurfacing',
                'route' => 'silo.pool_resurfacing',
                'description' => 'Transform your pool with our premium resurfacing solutions. Long-lasting, beautiful finishes backed by a 25-year warranty.',
                'image' => 'images/services/pool-resurfacing.jpg'
            ],
            [
                'name' => 'Pool Conversions',
                'slug' => 'pool-conversions',
                'route' => 'silo.pool_conversions',
                'description' => 'Convert your traditional pool to modern fiberglass. Upgrade to a low-maintenance, energy-efficient swimming experience.',
                'image' => 'images/services/pool-conversions.jpg'
            ],
            [
                'name' => 'Pool Remodeling',
                'slug' => 'pool-remodeling',
                'route' => 'silo.pool_remodeling',
                'description' => 'Complete pool remodeling services including tile, coping, and equipment upgrades for a total pool transformation.',
                'image' => 'images/services/pool-remodeling.jpg'
            ],
            [
                'name' => 'Pool Repair',
                'slug' => 'pool-repair-service',
                'route' => 'silo.pool_repair_service',
                'description' => 'Expert pool repair services for cracks, leaks, and structural issues. Permanent solutions with warranty protection.',
                'image' => 'images/services/pool-repair.jpg'
            ]
        ];

        // Convert to collection of objects for consistency with template
        $featuredServices = collect($coreServiceData)->map(function ($service) {
            return (object) $service;
        });

        $seoData = $this->getSeoData('homepage', [
            'meta_title' => 'Home - Professional Cleaning Services',
            'meta_description' => 'Professional cleaning services for homes and offices. Quality service with experienced staff.',
        ]);

        return view('home', compact('recentPosts', 'featuredServices', 'seoData'));
    }

    public function about()
    {
        $seoData = $this->getSeoData('about', [
            'meta_title' => 'About Hexagon Fiberglass Pools | Expert Pool Renovation Services',
            'meta_description' => 'Learn about our pool resurfacing company with over 15 years of experience. Licensed, insured, and committed to excellence.',
        ]);

        // Get the 4 core services as objects for the featured services section
        $coreServiceData = [
            [
                'name' => 'Pool Resurfacing',
                'slug' => 'pool-resurfacing',
                'url' => route('silo.pool_resurfacing'),
                'short_description' => 'Transform your pool with our premium resurfacing solutions. Long-lasting, beautiful finishes backed by a 25-year warranty.',
            ],
            [
                'name' => 'Pool Conversions',
                'slug' => 'pool-conversions',
                'url' => route('silo.pool_conversions'),
                'short_description' => 'Convert your traditional pool to modern fiberglass. Upgrade to a low-maintenance, energy-efficient swimming experience.',
            ],
            [
                'name' => 'Pool Remodeling',
                'slug' => 'pool-remodeling',
                'url' => route('silo.pool_remodeling'),
                'short_description' => 'Complete pool remodeling services including tile, coping, and equipment upgrades for a total pool transformation.',
            ],
            [
                'name' => 'Pool Repair',
                'slug' => 'pool-repair-service',
                'url' => route('silo.pool_repair_service'),
                'short_description' => 'Expert pool repair services for cracks, leaks, and structural issues. Permanent solutions with warranty protection.',
            ]
        ];

        $featuredServices = collect($coreServiceData)->map(function ($service) {
            return (object) $service;
        });

        return view('about', compact('seoData', 'featuredServices'));
    }

    public function sitemap()
    {
        $corePages = $this->corePageRepository->getActiveInSitemap();
        $services = $this->serviceRepository->getAllActive();
        $blogPosts = $this->blogPostRepository->getPublishedRecent();
        $landingPages = LandingPage::active()->get();

        $content = view('sitemap', compact('corePages', 'services', 'blogPosts', 'landingPages'))->render();
        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $content = view('robots')->render();
        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function terms()
    {
        return view('terms');
    }
    

    /**
     * Display the Texas state page
     */
    public function texas()
    {
        $seoData = $this->getSeoData('texas', [
            'meta_title' => 'Pool Resurfacing & Remodeling Services in Texas | Hexagon Fiberglass Pools',
            'meta_description' => 'Professional pool resurfacing, remodeling, and repair services across Texas. Serving Dallas-Fort Worth, Austin, Houston, and San Antonio. 25-year warranty. Free quotes.',
            'canonical_url' => url('/texas'),
        ]);

        // Get major Texas cities we serve
        $majorCities = [
            'Dallas-Fort Worth' => [
                'name' => 'Dallas-Fort Worth',
                'population' => '7.6 million',
                'pools' => '450,000+',
                'description' => 'The Metroplex is our primary service area with same-day consultations.'
            ],
            'Austin' => [
                'name' => 'Austin',
                'population' => '2.3 million',
                'pools' => '125,000+',
                'description' => 'Central Texas hub with year-round pool season.'
            ],
            'San Antonio' => [
                'name' => 'San Antonio',
                'population' => '2.5 million',
                'pools' => '150,000+',
                'description' => 'Extended service area with scheduled installations.'
            ],
            'Houston' => [
                'name' => 'Houston',
                'population' => '7.1 million',
                'pools' => '400,000+',
                'description' => 'Partner network for comprehensive coverage.'
            ]
        ];

        // Get core services for the page
        $coreServices = $this->serviceRepository->getActiveBySlugs([
            'pool-resurfacing',
            'pool-conversions',
            'pool-remodeling',
            'pool-repair'
        ]);

        return view('texas', compact('seoData', 'majorCities', 'coreServices'));
    }

    public function htmlSitemap()
    {
        $services = $this->serviceRepository->getActiveParentsWithChildren();

        $recentPosts = $this->blogPostRepository->getPublishedRecent(5);

        $corePages = $this->corePageRepository->getActiveInSitemap();

        return view('html-sitemap', compact('services', 'recentPosts', 'corePages'));
    }

    /**
     * Handle dynamic Core Pages
     * This method checks if a Core Page exists with the given slug
     * and displays it, or returns a 404 if not found
     */
    public function corePage($slug)
    {
        // List of reserved routes that should not be handled as Core Pages
        $reservedRoutes = [
            'admin', 'api', 'login', 'logout', 'register',
            'services', 'blog', 'contact', 'about', 'lp',
            'sitemap.xml', 'robots.txt', 'health'
        ];
        
        // Check if this is a reserved route
        $firstSegment = explode('/', $slug)[0];
        if (in_array($firstSegment, $reservedRoutes)) {
            abort(404);
        }
        
        // Check if a Core Page exists with this slug
        $corePage = $this->corePageRepository->findActiveBySlug($slug);
        
        if (!$corePage) {
            abort(404);
        }
        
        // Prepare SEO data from the Core Page
        $seoData = [
            'meta_title' => $corePage->meta_title ?: $corePage->name,
            'meta_description' => $corePage->meta_description,
            'meta_robots' => $corePage->meta_robots,
            'canonical_url' => $corePage->canonical_url,
            'json_ld' => $corePage->json_ld_string,
        ];
        
        // Check if a specific view exists for this page
        $viewName = 'core-pages.' . str_replace('/', '.', $slug);
        if (view()->exists($viewName)) {
            return view($viewName, compact('corePage', 'seoData'));
        }
        
        // Use a generic core page template
        if (view()->exists('core-pages.default')) {
            return view('core-pages.default', compact('corePage', 'seoData'));
        }
        
        // Fallback to a simple page display
        return view('page', compact('corePage', 'seoData'));
    }
}
