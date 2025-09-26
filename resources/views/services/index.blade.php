@extends('layouts.app')

@section('title', $seoData->meta_title ?? 'Our Services')
@section('meta_description', $seoData->meta_description ?? 'Explore our comprehensive cleaning services for homes and offices.')
@section('meta_robots', $seoData->meta_robots ?? 'index, follow')
@if($seoData && $seoData->canonical_url)
    @section('canonical_url', $seoData->canonical_url)
@endif
@if($seoData && $seoData->json_ld)
    @section('json_ld')
{!! $seoData->json_ld_string !!}
    @endsection
@endif

@section('content')

<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ asset('images/home1/hero-image-v.jpg') }}" style="background-image: url('{{ asset('images/home1/hero-image-v.jpg') }}');">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>Services</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>Services</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Services -->
<section class="bixol-services pt-150 pb-150">
    <div class="container">
        <div class="bixol-service-wrapper">
            <div class="row">
                @forelse($services as $service)
                <div class="col-lg-4 col-md-6">
                    <div class="bixol-single-item sr-item">
                        <div class="bixol-icon-wrapper">
                            @php
                                $serviceTitle = strtolower($service->name);
                                $icon = 'house-cleaning.svg'; // default
                                
                                if (str_contains($serviceTitle, 'house') || str_contains($serviceTitle, 'home') || str_contains($serviceTitle, 'residential')) {
                                    $icon = 'house-cleaning.svg';
                                } elseif (str_contains($serviceTitle, 'office') || str_contains($serviceTitle, 'commercial')) {
                                    $icon = 'vacuum-cleaner.svg';
                                } elseif (str_contains($serviceTitle, 'pool')) {
                                    $icon = 'swimming-pool.svg';
                                } elseif (str_contains($serviceTitle, 'christmas') || str_contains($serviceTitle, 'holiday')) {
                                    $icon = 'christmas-lights.svg';
                                } elseif (str_contains($serviceTitle, 'fence')) {
                                    $icon = 'fence.svg';
                                } elseif (str_contains($serviceTitle, 'gutter')) {
                                    $icon = 'gutters.svg';
                                } elseif (str_contains($serviceTitle, 'carpet')) {
                                    $icon = 'vacuum-cleaner.svg';
                                } elseif (str_contains($serviceTitle, 'window')) {
                                    $icon = 'window.svg';
                                } elseif (str_contains($serviceTitle, 'bathroom')) {
                                    $icon = 'toilet-brush.svg';
                                } elseif (str_contains($serviceTitle, 'plumb')) {
                                    $icon = 'plunger.svg';
                                }
                                
                                $iconPath = asset('images/icons/cleaning/' . $icon);
                            @endphp
                            <img src="{{ $iconPath }}" alt="{{ $service->name }}" class="service-icon">
                        </div>
                        <div class="bixol-sr-content">
                            <a href="{{ $service->url }}"><h6>{{ $service->name }}</h6></a>
                            <p>{{ Str::limit($service->short_description, 80) }}</p>
                            <a href="{{ $service->url }}" class="bixol-readmore-btn">Read More</a>
                        </div>
                        <div class="bixol-sr-hover">
                            <div class="img-wrapper">
                                <img src="{{ asset('images/services/01.jpg') }}" alt="{{ $service->name }}">
                                <span class="img-shadow"></span>
                            </div>
                            <div class="icon-wrapper">
                                <div class="bixol-img">
                                    <img src="{{ $iconPath }}" alt="{{ $service->name }}" class="service-icon">
                                </div>
                                <span class="bixol-icon-shadow"></span>
                            </div>
                            <div class="bixol-sr-content">
                                <a href="{{ $service->url }}"><h6>{{ $service->name }}</h6></a>
                                <p>{{ Str::limit($service->short_description, 120) }}</p>
                                <a href="{{ $service->url }}" class="bixol-readmore-btn">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p>No services available at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- Services End -->

@endsection

@push('styles')
<style>
/* Debug hover effect - minimal override */
.bixol-services .bixol-service-wrapper .bixol-single-item:hover .bixol-sr-hover {
    opacity: 1 !important;
    visibility: visible !important;
}

/* Ensure service cards have proper spacing for hover overlay */
.bixol-services .bixol-service-wrapper .bixol-single-item.sr-item {
    margin-bottom: 120px !important;
}

/* Make sure images display properly */
.bixol-services .bixol-service-wrapper .bixol-single-item .bixol-sr-hover .img-wrapper img {
    max-width: 100%;
    height: auto;
}

/* SVG Icon Styling */
.service-icon {
    width: 60px;
    height: 60px;
    object-fit: contain;
}

.bixol-icon-wrapper .service-icon {
    width: 80px;
    height: 80px;
}

.bixol-sr-hover .bixol-img .service-icon {
    width: 60px;
    height: 60px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Add service hover effects
    $('.sr-item').hover(
        function() {
            $(this).addClass('hovered');
        },
        function() {
            $(this).removeClass('hovered');
        }
    );
});
</script>
@endpush