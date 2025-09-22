@extends('layouts.app')

@section('title', $service->meta_title ?: $service->name . ' - Service Details')
@section('meta_description', $service->meta_description ?: $service->short_description)
@section('meta_robots', $service->meta_robots ?? 'index, follow')
@if($service->canonical_url)
    @section('canonical_url', $service->canonical_url)
@endif
@if($service->json_ld)
    @section('json_ld')
{!! $service->json_ld_string !!}
    @endsection
@endif
@section('body_class', 'service-details-page')

@section('content')

<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ $service->breadcrumb_image_url }}" style="background-image: url('{{ $service->breadcrumb_image_url }}');">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>{{ $service->name }}</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <a href="{{ route('services.index') }}">Services @icon("fas fa-angle-double-right")</a>
            @foreach($service->breadcrumbs as $breadcrumb)
                @if($loop->last)
                    <span>{{ $breadcrumb->name }}</span>
                @else
                    <a href="{{ route('services.show', $breadcrumb->full_slug) }}">{{ $breadcrumb->name }} @icon("fas fa-angle-double-right")</a>
                @endif
            @endforeach
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- service details -->
<section class="service-details pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('services.partials.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="sr-details-content">
                    @yield('service-content')
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Service Details End -->

@include('services.partials.contact-form')

@endsection

@push('styles')
<style>
    /* Remove blue background from service image container */
    .service-details .service-image,
    .sr-details-content .service-image,
    .service-image.mb-4 {
        background: transparent !important;
        background-color: transparent !important;
        height: auto !important;
        min-height: 0 !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    /* Hide service image container if it's empty */
    .service-details .service-image:empty,
    .sr-details-content .service-image:empty {
        display: none !important;
    }
    
    /* Ensure images in service-image display properly */
    .service-details .service-image img {
        display: block;
        width: 100%;
        height: auto;
    }
    
    /* Service page typography */
    .service-details h2 {
        font-size: 32px !important;
    }
    .service-details h3 {
        font-size: 32px !important;
    }
    
    /* Hide redundant h3 title in service content */
    .sr-details-content > div:first-child > h3:first-child {
        display: none;
    }
    
    /* Override the default ::after chevron icon */
    .service-details .sr-sidebar .sr-list-widget .list-nav ul li a.service-link::after {
        display: none !important;
    }
    
    /* Complete override to remove ALL icon decorations and blue squares */
    .service-details .sr-details-content .sr-details-bottom .srd-list ul li i,
    .service-details .sr-details-content .sr-details-bottom .srd-list ul li .icon,
    .sr-details-bottom .srd-list ul li i,
    .sr-details-bottom .srd-list ul li .icon,
    .srd-list ul li i,
    .srd-list ul li .icon {
        /* Remove all backgrounds and decorations */
        background: transparent !important;
        background-color: transparent !important;
        background-image: none !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
        
        /* Reset positioning and sizing */
        position: static !important;
        display: inline !important;
        width: auto !important;
        height: auto !important;
        padding: 0 !important;
        margin: 0 5px 0 0 !important;
        
        /* Ensure proper icon color */
        color: #043f88 !important;
        font-size: 14px !important;
        line-height: 1 !important;
        vertical-align: middle !important;
    }
    
    /* Remove ALL pseudo-elements that might create squares */
    .service-details .sr-details-content .sr-details-bottom .srd-list ul li i::before,
    .service-details .sr-details-content .sr-details-bottom .srd-list ul li i::after,
    .service-details .sr-details-content .sr-details-bottom .srd-list ul li .icon::before,
    .service-details .sr-details-content .sr-details-bottom .srd-list ul li .icon::after,
    .srd-list ul li i::before,
    .srd-list ul li i::after,
    .srd-list ul li .icon::before,
    .srd-list ul li .icon::after,
    .sr-details-bottom i::before,
    .sr-details-bottom i::after,
    .sr-details-bottom .icon::before,
    .sr-details-bottom .icon::after {
        display: none !important;
        content: none !important;
        background: none !important;
        border: none !important;
        width: 0 !important;
        height: 0 !important;
    }
    
    /* Ensure SVG within icon displays correctly */
    .srd-list ul li i svg,
    .srd-list ul li .icon svg {
        fill: #043f88 !important;
        width: 14px !important;
        height: 14px !important;
        display: inline-block !important;
        vertical-align: middle !important;
    }
    
    /* Remove any blue square pseudo-elements from icon wrappers */
    .bixol-icon-wrapper span::before,
    .bixol-service-item .bixol-icon-wrapper span::before {
        display: none !important;
    }
    
    /* Ensure SVG icons display properly */
    .service-nav-icon {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        color: #666;
    }
    
    .service-nav-icon .icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    
    .service-nav-icon svg {
        width: 100% !important;
        height: 100% !important;
        fill: currentColor !important;
    }
    
    /* Fix for icon component wrapper */
    .service-nav-icon i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-style: normal;
    }
    
    /* Toggle icon styling */
    .toggle-icon {
        transition: all 0.2s ease;
        padding: 4px;
        margin-right: -4px;
        border-radius: 3px;
        cursor: pointer !important;
        position: relative;
        z-index: 10;
    }
    
    .toggle-icon:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    /* Ensure toggle icon is clickable */
    .service-link {
        position: relative;
    }
    
    .service-link .toggle-icon {
        pointer-events: auto !important;
    }
    
    /* Sub-services list styling */
    .sub-services-list {
        border-left: 2px solid #f0f0f0;
        margin-left: 10px;
    }
    
    /* Active service highlighting */
    .sr-sidebar .list-nav ul li a.service-link.active {
        font-weight: 600;
        color: #02154e;
    }
    
    /* Smooth transitions */
    .has-sub-services {
        position: relative;
    }
    
    /* Visual separation for toggle icon */
    .service-link .toggle-icon {
        border-left: 1px solid #e0e0e0;
        margin-left: 8px;
        padding-left: 8px;
    }
</style>
@stack('service-styles')
@endpush

@push('scripts')
<script>
    // Wait for DOM to be ready
    $(document).ready(function() {
        console.log('Page loaded, jQuery version:', $.fn.jquery);
        
        // Define SVG icons - matching the exact format from the icons component
        const angleRightIcon = '<i class="icon"><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M6 2L5 3L10 8L5 13L6 14L12 8z"/></svg></i>';
        const angleDownIcon = '<i class="icon"><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M2 6L3 5L8 10L13 5L14 6L8 12z"/></svg></i>';
        
        // Function to toggle sub-services
        function toggleSubServices(toggleIcon) {
            const parentLi = toggleIcon.closest('li');
            const subServicesList = parentLi.querySelector('.sub-services-list');
            const isExpanded = toggleIcon.getAttribute('data-expanded') === 'true';
            
            console.log('Toggle clicked, isExpanded:', isExpanded, 'serviceId:', toggleIcon.getAttribute('data-service-id')); // Debug log
            
            if (isExpanded) {
                // Collapse
                if (subServicesList) {
                    $(subServicesList).slideUp(200);
                }
                toggleIcon.setAttribute('data-expanded', 'false');
                // Clear and set new icon
                while (toggleIcon.firstChild) {
                    toggleIcon.removeChild(toggleIcon.firstChild);
                }
                toggleIcon.insertAdjacentHTML('beforeend', angleRightIcon);
            } else {
                // Expand
                if (subServicesList) {
                    $(subServicesList).slideDown(200);
                }
                toggleIcon.setAttribute('data-expanded', 'true');
                // Clear and set new icon
                while (toggleIcon.firstChild) {
                    toggleIcon.removeChild(toggleIcon.firstChild);
                }
                toggleIcon.insertAdjacentHTML('beforeend', angleDownIcon);
            }
        }
        
        // Handle sub-service toggle in sidebar
        document.addEventListener('click', function(e) {
            // Check if clicked element is toggle icon or its child
            const toggleIcon = e.target.closest('.toggle-icon');
            if (toggleIcon && toggleIcon.closest('.sr-sidebar')) {
                e.preventDefault();
                e.stopPropagation();
                toggleSubServices(toggleIcon);
            }
        });
        
        // Prevent navigation when clicking on toggle icon
        document.querySelectorAll('.sr-sidebar .has-sub-services > .service-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (e.target.closest('.toggle-icon')) {
                    e.preventDefault();
                }
            });
        });
        
        // Initialize service details slider - matching the template exactly
        if($(".sr-details-slider").length > 0) {
            $(".sr-details-slider").slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: false,
                dots: false,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        }
    });
</script>
@endpush