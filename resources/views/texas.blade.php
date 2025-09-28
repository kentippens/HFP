@extends('layouts.app')

@section('title', $seoData->meta_title ?? 'Pool Services in Texas')
@section('meta_description', $seoData->meta_description ?? 'Professional pool resurfacing and remodeling services across Texas.')
@section('meta_robots', $seoData->meta_robots ?? 'index, follow')
@section('canonical_url', $seoData->canonical_url ?? url('/texas'))

@section('content')

<!-- Hero Section with Texas Map Background -->
<section class="texas-hero" style="background: linear-gradient(135deg, #043f88 0%, #0066cc 100%); position: relative; overflow: hidden;">
    <div class="container">
        <div class="row align-items-center min-vh-50 py-5">
            <div class="col-lg-7">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-3">Pool Services in Texas</h1>
                    <p class="lead mb-4">From the Panhandle to the Gulf Coast, Hexagon Fiberglass Pools delivers premium pool resurfacing, remodeling, and repair services across the Lone Star State.</p>
                    <div class="hero-stats d-flex flex-wrap gap-4 mb-4">
                        <div class="stat-item">
                            <h3 class="mb-0" style="color: #ffcc00;">1.2M+</h3>
                            <p class="mb-0 small">Texas Pools</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="mb-0" style="color: #ffcc00;">254</h3>
                            <p class="mb-0 small">Counties Served</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="mb-0" style="color: #ffcc00;">25 Year</h3>
                            <p class="mb-0 small">Warranty</p>
                        </div>
                    </div>
                    <div class="hero-cta d-flex flex-wrap gap-3">
                        <a href="tel:972-789-2983" class="btn btn-warning btn-lg">
                            <i class="fas fa-phone-alt me-2"></i>Call (972) 789-2983
                        </a>
                        <a href="/pool-repair-quote" class="btn btn-outline-light btn-lg">
                            Get Free Quote
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="texas-map-wrapper text-center">
                    <img src="{{ asset('images/flag-of-texas.svg') }}" alt="Texas" style="max-width: 300px; opacity: 0.3;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="services-overview py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Pool Services We Offer in Texas</h2>
            <p class="lead">Comprehensive solutions for every pool need across the state</p>
        </div>

        <div class="row g-4">
            @if(isset($coreServices))
                @foreach($coreServices as $service)
                <div class="col-lg-6">
                    <div class="service-card h-100 border rounded-3 p-4 shadow-sm hover-lift">
                        <div class="d-flex align-items-start">
                            <div class="service-icon me-3">
                                <i class="fas fa-swimming-pool text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <div class="service-content">
                                <h3 class="h4 mb-2">{{ $service->name }}</h3>
                                <p class="text-muted mb-3">{{ $service->short_description }}</p>
                                <a href="/{{ $service->slug }}" class="btn btn-sm btn-outline-primary">Learn More →</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Service Areas -->
<section class="service-areas py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Major Texas Cities We Serve</h2>
            <p class="lead">Professional pool services delivered throughout the Lone Star State</p>
        </div>

        <div class="row g-4">
            @if(isset($majorCities))
                @foreach($majorCities as $city)
                <div class="col-lg-3 col-md-6">
                    <div class="city-card text-center p-4 h-100 border rounded-3 hover-shadow">
                        <h3 class="h4 mb-3">{{ $city['name'] }}</h3>
                        <div class="city-stats mb-3">
                            <p class="mb-1 small text-muted">Population: <strong>{{ $city['population'] }}</strong></p>
                            <p class="mb-1 small text-muted">Est. Pools: <strong>{{ $city['pools'] }}</strong></p>
                        </div>
                        <p class="small">{{ $city['description'] }}</p>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="texas-cta py-5 bg-dark text-white">
    <div class="container">
        <div class="text-center">
            <h2 class="display-5 fw-bold mb-3">Ready to Transform Your Texas Pool?</h2>
            <p class="lead mb-4">Join thousands of Texas homeowners who've chosen permanent pool solutions</p>

            <div class="cta-buttons d-flex justify-content-center flex-wrap gap-3">
                <a href="tel:972-789-2983" class="btn btn-warning btn-lg px-5">
                    <i class="fas fa-phone-alt me-2"></i>
                    <span>Call (972) 789-2983</span>
                </a>
                <a href="/pool-repair-quote" class="btn btn-light btn-lg px-5">
                    Get Your Free Texas Quote
                </a>
            </div>

            <p class="mt-4 mb-0 text-white-50">
                <small>Serving all 254 Texas counties • Same-day callbacks • Se habla español</small>
            </p>
        </div>
    </div>
</section>

@endsection