@extends('layouts.app')

@section('title', 'Sitemap - ' . config('app.name'))
@section('meta_description', 'Browse our complete sitemap to find all pages, services, and resources available on ' . config('app.name'))
@section('meta_robots', 'index, follow')

@section('content')

<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <div class="page-banner-content">
            <h1>Sitemap</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sitemap</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Sitemap Content -->
<section class="sitemap-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sitemap-content">
                    <p class="lead mb-4">Browse our complete website structure below. Click any link to navigate to that page.</p>
                    
                    <div class="row">
                        <!-- Main Pages Column -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="sitemap-group">
                                <h3 class="sitemap-heading">
                                    @icon('fas fa-home') Main Pages
                                </h3>
                                <ul class="sitemap-list">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    {{-- <li><a href="{{ route('about') }}">About Us</a></li> --}}
                                    <li><a href="{{ route('contact.index') }}">Get Pool Repair Quote</a></li>
                                    <li><a href="{{ route('investor.relations') }}">Investor Relations</a></li>
                                    <li><a href="{{ route('crystal-clear-guarantee') }}">Crystal Clear Guarantee</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Pool Services Silos -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="sitemap-group">
                                <h3 class="sitemap-heading">
                                    @icon('fas fa-swimming-pool') Pool Services
                                </h3>
                                <ul class="sitemap-list">
                                    <li><a href="{{ route('silo.pool_resurfacing') }}">Pool Resurfacing</a></li>
                                    <li><a href="{{ route('silo.pool_conversions') }}">Pool Conversions</a></li>
                                    <li><a href="{{ route('silo.pool_remodeling') }}">Pool Remodeling</a></li>
                                    <li><a href="{{ route('silo.pool_repair_service') }}">Pool Repair Service</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Services Column -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="sitemap-group">
                                <h3 class="sitemap-heading">
                                    @icon('fas fa-tools') All Services
                                </h3>
                                <ul class="sitemap-list">
                                    <li><a href="{{ route('services.index') }}">View All Services</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Resources Column -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="sitemap-group">
                                <h3 class="sitemap-heading">
                                    @icon('fas fa-book') Resources
                                </h3>
                                <ul class="sitemap-list">
                                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                                    @if(isset($recentPosts) && $recentPosts->count() > 0)
                                        <ul class="sitemap-sublist">
                                            @foreach($recentPosts->take(5) as $post)
                                                <li>
                                                    <a href="{{ route('blog.show', $post->slug) }}">
                                                        {{ Str::limit($post->name, 40) }}
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li><a href="{{ route('blog.index') }}">View All Posts →</a></li>
                                        </ul>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- Legal Column -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="sitemap-group">
                                <h3 class="sitemap-heading">
                                    @icon('fas fa-shield-alt') Legal & Policies
                                </h3>
                                <ul class="sitemap-list">
                                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                                    <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                                    <li><a href="{{ route('sitemap') }}">XML Sitemap</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Core Pages Column (if any exist) -->
                        @if(isset($corePages) && $corePages->count() > 0)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="sitemap-group">
                                <h3 class="sitemap-heading">
                                    @icon('fas fa-file-alt') Additional Pages
                                </h3>
                                <ul class="sitemap-list">
                                    @foreach($corePages as $page)
                                        <li>
                                            <a href="{{ url($page->slug) }}">
                                                {{ $page->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <!-- Contact Information -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="sitemap-group">
                                <h3 class="sitemap-heading">
                                    @icon('fas fa-phone') Get In Touch
                                </h3>
                                <ul class="sitemap-list contact-info">
                                    <li>
                                        <strong>Phone:</strong> 
                                        <a href="tel:972-789-2983">972-789-2983</a>
                                    </li>
                                    <li>
                                        <strong>Email:</strong> 
                                        <a href="mailto:pools@hexagonservicesolutions.com">pools@hexagonservicesolutions.com</a>
                                    </li>
                                    <li>
                                        <strong>Hours:</strong>
                                        Mon-Fri: 9:00 AM - 4:00 PM<br>
                                        Sat: Closed<br>
                                        Sun: Closed
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.sitemap-section {
    min-height: 500px;
    background: #f8f9fa;
}

.sitemap-group {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    height: 100%;
    transition: all 0.3s ease;
}

.sitemap-group:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    transform: translateY(-2px);
}

.sitemap-heading {
    color: #2c3e50;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #007bff;
}

.sitemap-heading svg {
    color: #007bff;
    margin-right: 8px;
    width: 20px;
    height: 20px;
    vertical-align: middle;
}

.sitemap-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sitemap-list li {
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.sitemap-list li:last-child {
    border-bottom: none;
}

.sitemap-list a {
    color: #495057;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    width: 100%;
}

.sitemap-list a:hover {
    color: #007bff;
    padding-left: 5px;
}

.sitemap-sublist {
    list-style: none;
    padding-left: 20px;
    margin-top: 10px;
}

.sitemap-sublist li {
    padding: 5px 0;
    border-bottom: 1px dashed #e9ecef;
    font-size: 0.95rem;
}

.sitemap-sublist li:before {
    content: "→";
    color: #007bff;
    margin-right: 8px;
}

.contact-info li {
    border-bottom: none;
    padding: 10px 0;
}

/* Page Banner */
.page-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 60px 0;
    color: white;
    margin-bottom: 0;
}

.page-banner h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item {
    color: rgba(255, 255, 255, 0.8);
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.7);
    content: "/";
}

/* Responsive */
@media (max-width: 768px) {
    .sitemap-group {
        margin-bottom: 20px;
        padding: 20px;
    }
    
    .page-banner h1 {
        font-size: 2rem;
    }
}
</style>
@endpush