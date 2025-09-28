@extends('layouts.app')

@section('title', $service->meta_title ?: $service->name . ' - Service Details')
@section('meta_description', $service->meta_description ?: $service->short_description)
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
                <div class="sr-sidebar">
                    <div class="sidebar-widget sr-list-widget">
                        <div class="widget-title">
                            <h5>All Services</h5>
                        </div>
                        <div class="list-nav">
                            <ul>
                                @php
                                    $allServices = \App\Models\Service::active()
                                        ->topLevel()
                                        ->with('activeChildren')
                                        ->ordered()
                                        ->get();
                                @endphp
                                @foreach($allServices as $sidebarService)
                                    @php
                                        // Check if this service or any of its children is active
                                        $isParentActive = $service->id === $sidebarService->id;
                                        $hasActiveChild = false;
                                        foreach($sidebarService->activeChildren as $child) {
                                            if($service->id === $child->id) {
                                                $hasActiveChild = true;
                                                break;
                                            }
                                        }
                                        $shouldExpand = $isParentActive || $hasActiveChild;
                                    @endphp
                                    <li class="has-children {{ $sidebarService->activeChildren->count() > 0 ? 'has-sub-services' : '' }}">
                                        <a href="{{ route('services.show', $sidebarService->full_slug) }}" class="service-link {{ $isParentActive ? 'active' : '' }}" style="display: flex; justify-content: space-between; align-items: center;">
                                            <span>{{ $sidebarService->name }}</span>
                                            @if($sidebarService->activeChildren->count() > 0)
                                                <span class="service-nav-icon toggle-icon" style="width: 16px; height: 16px; flex-shrink: 0; cursor: pointer;" data-expanded="{{ $shouldExpand ? 'true' : 'false' }}" data-service-id="{{ $sidebarService->id }}">
                                                    @if($shouldExpand)
                                                        @icon('fa-angle-down')
                                                    @else
                                                        @icon('fa-angle-right')
                                                    @endif
                                                </span>
                                            @else
                                                <span class="service-nav-icon" style="width: 16px; height: 16px; flex-shrink: 0;">@icon('fa-angle-right')</span>
                                            @endif
                                        </a>
                                        @if($sidebarService->activeChildren->count() > 0)
                                            <ul class="sub-services-list" style="padding-left: 20px; margin-top: 5px; {{ $shouldExpand ? '' : 'display: none;' }}">
                                                @foreach($sidebarService->activeChildren as $childService)
                                                    <li>
                                                        <a href="{{ route('services.show', $childService->full_slug) }}" class="service-link {{ $service->id === $childService->id ? 'active' : '' }}" style="display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
                                                            <span>{{ $childService->name }}</span>
                                                            <span class="service-nav-icon" style="width: 14px; height: 14px; flex-shrink: 0;">@icon('fa-angle-right')</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-widget sr-btn-widget" data-background="{{ asset('images/services/sidebar.png') }}">
                        <span class="subtitle">Service Overview</span>
                        <h5>Service Data Sheets</h5>
                        <div class="download-btns">
                            <a href="#" class="btn-1">Carpet Cleaning Flyer<span>@icon("fa-file-pdf") </span></a>
                            <a href="#" class="btn-2">House Cleaning Flyer<span>@icon("fa-file-pdf") </span></a>
                            <a href="#" class="btn-2">Pool Cleaning Flyer<span>@icon("fa-file-pdf") </span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="sr-details-content">
                    <div class="title-txt">
                        <h3>{{ $service->name }}</h3>
                    </div>
                    @if($service->image)
                    <div class="service-image mb-4">
                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="img-fluid">
                    </div>
                    @endif
                    <div class="pera-text mt-20">
                        @if($service->slug === 'pool-cleaning')
                            {{-- Custom HTML for Pool Cleaning Service --}}
                            <div class="pool-cleaning-content">
                                <h4>Professional Pool Maintenance & Cleaning</h4>
                                <p>Keep your pool crystal clear and swim-ready all season long!</p>
                                
                                <div class="service-features">
                                    <h5>Our Pool Services Include:</h5>
                                    <ul>
                                        <li>Weekly chemical balancing and testing</li>
                                        <li>Skimming and debris removal</li>
                                        <li>Filter cleaning and maintenance</li>
                                        <li>Algae prevention and treatment</li>
                                        <li>Equipment inspection and repairs</li>
                                    </ul>
                                </div>
                                
                                <div class="pricing-info">
                                    <h5>Service Plans</h5>
                                    <p><strong>Basic Plan:</strong> Weekly cleaning starting at $80/month</p>
                                    <p><strong>Premium Plan:</strong> Includes chemical balancing from $120/month</p>
                                </div>
                                
                                {{-- You can still include the database content if desired --}}
                                {!! \App\Helpers\HtmlHelper::safe($service->description, 'services') !!}
                            </div>
                        @else
                            {{-- Default content for other services --}}
                            {!! \App\Helpers\HtmlHelper::safe($service->description ?: '<p>Professional service with experienced staff and quality results.</p>', 'services') !!}
                        @endif
                    </div>

                    @if($service->activeChildren->count() > 0)
                    <div class="sub-services mt-40">
                        <div class="title-txt">
                            <h4>Related Sub-Services</h4>
                        </div>
                        <div class="row mt-20">
                            @foreach($service->activeChildren as $subService)
                            <div class="col-md-6 mb-3">
                                <div class="sub-service-item" style="background: #f8f9fa; padding: 20px; border-radius: 8px; height: 100%;">
                                    <h5 style="margin-bottom: 10px;">
                                        <a href="{{ route('services.show', $subService->full_slug) }}" style="color: #333; text-decoration: none;">
                                            {{ $subService->name }}
                                        </a>
                                    </h5>
                                    <p style="margin-bottom: 10px; font-size: 14px; color: #666;">
                                        {{ Str::limit(strip_tags($subService->short_description ?: $subService->description), 100) }}
                                    </p>
                                    <a href="{{ route('services.show', $subService->full_slug) }}" class="read-more-link" style="color: #02154e; font-size: 14px; font-weight: 500;">
                                        Learn More @icon("fas fa-arrow-right")
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="sr-details-bottom mt-40">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="sr-details-left">
                                    <div class="title-txt">
                                        <h4>Company Overview</h4>
                                    </div>
                                    <div class="pera-txt mt-20">
                                        <p>A neatly maintained building is an important asset to every organization. It reflects who you are and influences how your customers perceive you to complete depending on the size.</p>
                                    </div>
                                    <div class="pera-txt mt-20">
                                        <p>Condition of your home. We work in teams of 2-4 or more. A team leader or the owner.</p>
                                    </div>
                                    <div class="srd-list mt-20">
                                         <ul>
                                            <li><span style="color: #043f88; margin-right: 10px;">✓</span><p>The housekeepers we hired are professionals who take pride in doing excellent work and in exceeding expectations.</p></li>
                                            <li><span style="color: #043f88; margin-right: 10px;">✓</span><p>We carefully screen all of our cleaners, so you can rest assured that your home would receive the absolute highest quality of service providing.</p></li>
                                            <li><span style="color: #043f88; margin-right: 10px;">✓</span><p>Your time is precious, and we understand that cleaning is really just one more item on your to-do list.</p></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Service Details End -->

 <!-- Get In Tauch -->
 <section class="bixol-gta-area" data-background="{{ asset('images/home1/contactform-background.jpg') }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 offset-lg-6">
                <div class="bixol-gt-right">
                    <h4 style="color: #22356f;">Get A Quote</h4>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('contact.store') }}" method="POST" id="service-contact-form">
                        @csrf
                        <input type="hidden" name="type" value="appointment">
                        <input type="hidden" name="source" value="service_{{ $service->slug }}">
                        
                        @if(session('error'))
                            <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="name-field-wrapper" style="position: relative;">
                                    <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required 
                                           class="{{ $errors->has('name') ? 'error' : '' }}" style="width: 100%; box-sizing: border-box;">
                                    <style>
                                        /* Contact page form styling for service details */
                                        .bixol-gt-right {
                                            padding: 20px;
                                            overflow: visible;
                                        }
                                        .bixol-gt-right form {
                                            width: 100%;
                                            margin-top: 20px;
                                            overflow: visible;
                                        }
                                        .bixol-gt-right .row {
                                            margin-left: 0;
                                            margin-right: 0;
                                        }
                                        .bixol-gt-right .row > * {
                                            padding-left: 5px;
                                            padding-right: 5px;
                                        }
                                        .bixol-gt-right form input,
                                        .bixol-gt-right form select,
                                        .bixol-gt-right form textarea {
                                            width: 100%;
                                            border: 0;
                                            padding: 12px 20px;
                                            background-color: #22356f !important;
                                            color: #ffffff !important;
                                            margin-bottom: 20px;
                                            border-radius: 3px;
                                            font-family: "Poppins", sans-serif;
                                            font-size: 14px;
                                            box-shadow: 0px 0px 10px 0px rgba(12, 12, 12, 0.1);
                                        }
                                        .bixol-gt-right form input::placeholder,
                                        .bixol-gt-right form select::placeholder,
                                        .bixol-gt-right form textarea::placeholder {
                                            color: #b8c5d1 !important;
                                        }
                                        .bixol-gt-right form .submit-btn {
                                            margin-top: 0;
                                        }
                                        .bixol-gt-right form .submit-btn button {
                                            width: 100%;
                                            height: 50px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            background-color: #22356f !important;
                                            border: 0;
                                            border-radius: 3px;
                                            color: #ffffff;
                                            font-family: "Poppins", sans-serif;
                                            font-weight: 700;
                                            font-size: 15px;
                                            transition: all 0.3s ease-in;
                                            text-align: center;
                                        }
                                        .bixol-gt-right form .submit-btn button i {
                                            margin-right: 10px;
                                            display: inline-flex;
                                            align-items: center;
                                        }
                                        .bixol-gt-right form .submit-btn button:hover {
                                            background-color: #28a745 !important;
                                        }
                                        
                                        /* Name field styling */
                                        .name-field-wrapper::after {
                                            content: "Mr. Mrs. Ms.";
                                            position: absolute;
                                            right: 15px;
                                            top: 50%;
                                            transform: translateY(-50%);
                                            font-style: italic;
                                            color: #999;
                                            pointer-events: none;
                                            font-size: 14px;
                                        }
                                        .name-field-wrapper input[name="name"] {
                                            padding-right: 120px;
                                        }
                                        
                                        /* Error styling */
                                        .bixol-gt-right input.error,
                                        .bixol-gt-right select.error,
                                        .bixol-gt-right textarea.error,
                                        .bixol-gta-area input.error,
                                        .bixol-gta-area select.error,
                                        .bixol-gta-area textarea.error {
                                            border-color: #dc3545 !important;
                                            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
                                        }
                                        
                                        /* Override existing service form styling */
                                        .bixol-gta-area form input,
                                        .bixol-gta-area form select,
                                        .bixol-gta-area form textarea {
                                            width: 100%;
                                            border: 0;
                                            padding: 12px 20px;
                                            background-color: #22356f !important;
                                            color: #ffffff !important;
                                            margin-bottom: 20px;
                                            border-radius: 3px;
                                            font-family: "Poppins", sans-serif;
                                            font-size: 14px;
                                            box-shadow: 0px 0px 10px 0px rgba(12, 12, 12, 0.1);
                                        }
                                        .bixol-gta-area .submit-btn button {
                                            width: 100%;
                                            height: 50px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            background-color: #22356f !important;
                                            border: 0;
                                            border-radius: 3px;
                                            color: #ffffff;
                                            font-family: "Poppins", sans-serif;
                                            font-weight: 700;
                                            font-size: 15px;
                                            transition: all 0.3s ease-in;
                                            text-align: center;
                                        }
                                        .bixol-gta-area .submit-btn button i {
                                            margin-right: 10px;
                                            display: inline-flex;
                                            align-items: center;
                                        }
                                        .bixol-gta-area .submit-btn button:hover {
                                            background-color: #28a745 !important;
                                        }
                                        
                                        /* Responsive fixes */
                                        @media (max-width: 767.98px) {
                                            .bixol-gt-right {
                                                padding: 15px;
                                            }
                                            .bixol-gt-right .row > * {
                                                padding-left: 0;
                                                padding-right: 0;
                                                margin-bottom: 10px;
                                            }
                                            .name-field-wrapper input[name="name"] {
                                                padding-right: 20px !important;
                                            }
                                            .name-field-wrapper::after {
                                                display: none;
                                            }
                                        }
                                        
                                        /* Ensure form container doesn't cut off content */
                                        .bixol-gta-area {
                                            overflow: visible;
                                        }
                                        .bixol-gta-area .container {
                                            overflow: visible;
                                        }
                                        
                                        /* Set form field background to #22356f */
                                        .bixol-gt-right input[type="text"],
                                        .bixol-gt-right input[type="tel"],
                                        .bixol-gt-right input[type="email"],
                                        .bixol-gt-right select,
                                        .bixol-gt-right textarea,
                                        .bixol-gta-area input[type="text"],
                                        .bixol-gta-area input[type="tel"],
                                        .bixol-gta-area input[type="email"],
                                        .bixol-gta-area select,
                                        .bixol-gta-area textarea {
                                            background: #22356f !important;
                                            background-color: #22356f !important;
                                            color: #ffffff !important;
                                        }
                                        
                                        /* Specific targeting for email and select fields */
                                        .mail-field input,
                                        .select-field select {
                                            background: #22356f !important;
                                            background-color: #22356f !important;
                                            color: #ffffff !important;
                                        }
                                        
                                        /* Update placeholder text color for better visibility */
                                        .bixol-gt-right form input::placeholder,
                                        .bixol-gt-right form select::placeholder,
                                        .bixol-gt-right form textarea::placeholder,
                                        .bixol-gta-area form input::placeholder,
                                        .bixol-gta-area form select::placeholder,
                                        .bixol-gta-area form textarea::placeholder {
                                            color: #b8c5d1 !important;
                                        }
                                    </style>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="phone-number">
                                    <input type="tel" name="phone" placeholder="Phone Number*" value="{{ old('phone') }}" required
                                           class="{{ $errors->has('phone') ? 'error' : '' }}" maxlength="12" autocomplete="tel" style="width: 100%; box-sizing: border-box;">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mail-field">
                                    <input type="email" name="address" placeholder="Email Address" value="{{ old('address') }}"
                                           class="{{ $errors->has('address') ? 'error' : '' }}" style="width: 100%; box-sizing: border-box;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="select-field">
                                    <select name="service" required class="{{ $errors->has('service') ? 'error' : '' }}" style="width: 100%; box-sizing: border-box;">
                                        <option value="request-callback" {{ old('service') == 'request-callback' || old('service') === null ? 'selected' : '' }}>Request A Callback</option>
                                        <option value="pool-resurfacing-conversion" {{ old('service') == 'pool-resurfacing-conversion' ? 'selected' : '' }}>Pool Resurfacing & Conversion</option>
                                        <option value="pool-repair" {{ old('service') == 'pool-repair' ? 'selected' : '' }}>Pool Repair</option>
                                        <option value="pool-remodeling" {{ old('service') == 'pool-remodeling' ? 'selected' : '' }}>Pool Remodeling</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="message-field">
                                    <textarea name="message" placeholder="Notes for our team..." rows="8"
                                              class="{{ $errors->has('message') ? 'error' : '' }}" style="width: 100%; box-sizing: border-box;">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="submit-btn">
                            <button type="submit" class="bixol-primary-btn submit-btn">@icon("fas fa-check-circle")Get A Quote</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Get In Tauch End -->


@endsection

@push('styles')
<style>
    /* Override the default ::after chevron icon */
    .service-details .sr-sidebar .sr-list-widget .list-nav ul li a.service-link::after {
        display: none !important;
    }
    
    /* Ensure SVG icons display properly */
    .service-nav-icon {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        color: #666; /* Ensure icons have color */
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
        font-style: normal; /* Remove italic styling from i tag */
    }
    
    /* Debug styles - remove after fixing */
    .toggle-icon {
        background-color: rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 0, 0, 0.1);
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