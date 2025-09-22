<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Service;
use App\Models\CorePage;
use App\Models\LandingPage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recentPosts = BlogPost::published()->recent()->take(3)->get();
        $featuredServices = Service::active()->ordered()->take(4)->get();
        $seoData = $this->getSeoData('homepage', [
            'meta_title' => 'Home - Professional Cleaning Services',
            'meta_description' => 'Professional cleaning services for homes and offices. Quality service with experienced staff.',
        ]);
        
        return view('home', compact('recentPosts', 'featuredServices', 'seoData'));
    }

    public function about()
    {
        $seoData = $this->getSeoData('about', [
            'meta_title' => 'About Premier Pool Resurfacing | Expert Pool Renovation Services',
            'meta_description' => 'Learn about our pool resurfacing company with over 15 years of experience. Licensed, insured, and committed to excellence.',
        ]);
        
        // Get active services for the featured services section
        $featuredServices = Service::active()
            ->ordered()
            ->take(4)
            ->get();
        
        return view('about', compact('seoData', 'featuredServices'));
    }

    public function sitemap()
    {
        $corePages = CorePage::active()->inSitemap()->get();
        $services = Service::active()->get();
        $blogPosts = BlogPost::published()->get();
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
    
    public function crystalClearGuarantee()
    {
        $seoData = $this->getSeoData('crystal-clear-guarantee', [
            'meta_title' => 'Crystal Clear Guarantee',
            'meta_description' => 'Our 100% satisfaction guarantee ensures quality service every time.',
        ]);
        
        return view('crystal-clear-guarantee', compact('seoData'));
    }

    public function htmlSitemap()
    {
        $services = Service::active()
            ->whereNull('parent_id')
            ->with('children')
            ->ordered()
            ->get();
        
        $recentPosts = BlogPost::published()
            ->recent()
            ->take(5)
            ->get();
        
        $corePages = CorePage::active()
            ->inSitemap()
            ->get();
        
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
        $corePage = CorePage::where('slug', $slug)
            ->where('is_active', true)
            ->first();
        
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
