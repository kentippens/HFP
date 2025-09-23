<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiloController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\TrackingScriptErrorController;
use App\Http\Controllers\HealthCheckController;

/*
|--------------------------------------------------------------------------
| Public Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// ============================================================================
// CORE PAGES
// ============================================================================

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Error check route (remove in production)
if (config('app.debug')) {
    Route::get('/error-check', function() {
        return view('test.error-check');
    })->name('error.check');
}

// About Us
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Pool Repair Quote - Display form and handle submission
Route::get('/pool-repair-quote', [ContactController::class, 'index'])->name('contact.index');
Route::post('/pool-repair-quote', [ContactController::class, 'store'])
    ->middleware(['throttle:contact-form', 'throttle:contact-form-daily'])
    ->name('contact.store');

// Investor Relations
Route::get('/investor-relations', [ContactController::class, 'investorRelations'])->name('investor.relations');
Route::post('/investor-relations', [ContactController::class, 'storeInvestorInquiry'])
    ->middleware(['throttle:contact-form', 'throttle:contact-form-daily'])
    ->name('investor.store');

// ============================================================================
// AUTHENTICATION ROUTES
// ============================================================================

// Redirect old login route to Filament admin login
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// Logout (keep this for compatibility)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================================================
// SILO PAGES (Pool Resurfacing, Pool Conversions, etc.)
// These routes handle the main silo structure
// ============================================================================

// Pool Resurfacing routes
Route::get('/pool-resurfacing/{path?}', [SiloController::class, 'show'])
    ->name('silo.pool_resurfacing')
    ->where('path', '.*');

// Pool Conversions routes
Route::get('/pool-conversions/{path?}', [SiloController::class, 'show'])
    ->name('silo.pool_conversions')
    ->where('path', '.*');

// Pool Remodeling routes
Route::get('/pool-remodeling/{path?}', [SiloController::class, 'show'])
    ->name('silo.pool_remodeling')
    ->where('path', '.*');

// Pool Repair Service routes
Route::get('/pool-repair-service/{path?}', [SiloController::class, 'show'])
    ->name('silo.pool_repair_service')
    ->where('path', '.*');

// ============================================================================
// SERVICES SECTION
// Prefix: /services
// ============================================================================

Route::prefix('services')->name('services.')->group(function () {
    // Services listing page
    // URL: /services
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    
    // Service detail pages with support for nested sub-services
    // This route captures all paths like:
    // - /services/house-cleaning
    // - /services/house-cleaning/pet-house-cleaning
    // - /services/house-cleaning/pet-house-cleaning/deep-clean
    Route::get('/{path}', [ServiceController::class, 'show'])
        ->name('show')
        ->where('path', '[a-z0-9\-]+(/[a-z0-9\-]+)*');
});

// ============================================================================
// BLOG SECTION
// Prefix: /blog
// ============================================================================

Route::prefix('blog')->name('blog.')->group(function () {
    // Blog listing page with pagination
    // URL: /blog
    Route::get('/', [BlogController::class, 'index'])->name('index');
    
    // Individual blog post pages
    // URL: /blog/{post-slug}
    // Example: /blog/how-to-improve-website-seo, /blog/digital-marketing-trends-2024
    Route::get('/{post:slug}', [BlogController::class, 'show'])->name('show');
    
    // Blog comment submission
    // URL: /blog/{post-slug}/comment
    Route::post('/{slug}/comment', [BlogController::class, 'comment'])->name('comment');
    
    // Optional: Blog category pages
    // URL: /blog/category/{category}
    // Example: /blog/category/web-development, /blog/category/marketing
    Route::get('/category/{category}', [BlogController::class, 'category'])->name('category');
    
    // Optional: Blog archive by date
    // URL: /blog/archive/{year}/{month?}
    // Example: /blog/archive/2024, /blog/archive/2024/07
    Route::get('/archive/{year}/{month?}', [BlogController::class, 'archive'])
        ->name('archive')
        ->where(['year' => '[0-9]{4}', 'month' => '[0-9]{1,2}']);
});

// ============================================================================
// LANDING PAGES (PPC)
// Prefix: /lp
// ============================================================================

Route::prefix('lp')->name('landing.')->group(function () {
    // Individual landing pages for PPC campaigns
    // URL: /lp/{page-slug}
    // Example: /lp/ppc-web-development, /lp/free-consultation, /lp/summer-special
    Route::get('/{page:slug}', [LandingPageController::class, 'show'])->name('show');
    
    // Optional: Landing page form submission (if different from contact)
    // URL: /lp/{page-slug}/submit
    Route::post('/{page:slug}/submit', [LandingPageController::class, 'submit'])
        ->middleware(['throttle:contact-form', 'throttle:contact-form-daily'])
        ->name('submit');
});

// ============================================================================
// ADMIN/API ROUTES
// ============================================================================

// CKEditor image upload (admin only with security)
Route::middleware(['auth', App\Http\Middleware\CKEditorSecurity::class])
    ->post('/admin/ckeditor/upload', [App\Http\Controllers\Admin\CKEditorController::class, 'upload'])
    ->name('admin.ckeditor.upload');

// Tracking script error reporting
Route::post('/api/tracking-script-errors', [TrackingScriptErrorController::class, 'report'])
    ->name('api.tracking-script-errors');

// Password strength checker
Route::post('/api/password-strength', [\App\Http\Controllers\Api\PasswordStrengthController::class, 'check'])
    ->name('api.password-strength');

// ============================================================================
// ADDITIONAL UTILITY ROUTES
// ============================================================================

// Sitemap for SEO
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');

// HTML Sitemap
Route::get('/sitemap', [HomeController::class, 'htmlSitemap'])->name('html-sitemap');

// Robots.txt
Route::get('/robots.txt', [HomeController::class, 'robots'])->name('robots');

// Privacy Policy
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy');

// Terms of Service
Route::get('/terms-of-service', [HomeController::class, 'terms'])->name('terms');

// Crystal Clear Guarantee
Route::get('/crystal-clear-guarantee', [HomeController::class, 'crystalClearGuarantee'])->name('crystal-clear-guarantee');

// Test route for mobile menu
Route::get('/test-mobile', function () {
    return view('test-mobile');
});

// Health Check Endpoints
Route::get('/health', [HealthCheckController::class, 'health'])->name('health');
Route::get('/health/detailed', [HealthCheckController::class, 'detailed'])->name('health.detailed');

// ============================================================================
// REDIRECTS FOR OLD URLS (if migrating from another site)
// ============================================================================

// Example redirects from old site structure
// Route::redirect('/old-services.html', '/services', 301);
// Route::redirect('/blog.php', '/blog', 301);
// Route::redirect('/contact.html', '/contact', 301);

// ============================================================================
// DYNAMIC CORE PAGES
// ============================================================================

// This route should be near the end to catch dynamic pages
// It will check if a Core Page exists with the given slug
// Supports both simple slugs and nested paths
Route::get('/{slug}', [HomeController::class, 'corePage'])
    ->name('core-page')
    ->where('slug', '[a-z0-9\-\/]+');

// ============================================================================
// 404 ERROR HANDLING
// ============================================================================

// Custom 404 page - this catches all unmatched routes
Route::fallback(function () {
    // Log the 404 for analytics
    \Log::warning('404 Page Not Found', [
        'url' => request()->fullUrl(),
        'user_agent' => request()->userAgent(),
        'referer' => request()->header('referer'),
        'ip' => request()->ip()
    ]);
    
    // Return custom 404 view
    return response()->view('errors.404', [
        'title' => 'Page Not Found - Your Business Name',
        'description' => 'The page you are looking for could not be found.',
    ], 404);
});
