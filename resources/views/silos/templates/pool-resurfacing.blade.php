@extends('layouts.app')

@section('title', $silo->meta_title ?? 'Pool Resurfacing - Transform Your Pool')
@section('meta_description', $silo->meta_description ?? 'Professional pool resurfacing services in Dallas-Fort Worth. Expert plaster, pebble, and fiberglass resurfacing.')
@section('meta_robots', $silo->meta_robots ?? 'index, follow')

@if($silo->canonical_url)
    @section('canonical_url', $silo->canonical_url)
@endif

@section('json_ld')
{!! $silo->all_schema ?? '' !!}
@endsection

@section('content')
<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ asset('images/home1/hero-image-v.jpg') }}" style="background-image: url('{{ asset('images/home1/hero-image-v.jpg') }}');">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>Pool Resurfacing</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>Pool Resurfacing</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Pool Resurfacing Main Content Start -->
<section class="pool-resurfacing-section pt-5 pb-5" style="overflow: visible !important;">
    <div class="container">
        <!-- Intro Section -->
        <div class="intro-section mb-5">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="display-4 mb-4">Transform Your Pool with Professional Resurfacing</h1>
                    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                </div>
            </div>
        </div>

        <!-- Sub-Services Section -->
        <div class="sub-services-section mb-5">
            <div class="row">
                @php
                    // Mock sub-services data - this will be dynamic from database
                    $subServices = [
                        ['name' => 'Fiberglass Resurfacing', 'description' => 'Durable fiberglass coating for long-lasting pool protection'],
                        ['name' => 'Marcite & Plaster Resurfacing', 'description' => 'Classic white plaster and marcite finishes for traditional pools'],
                        ['name' => 'Gunite & Concrete Resurfacing', 'description' => 'Professional resurfacing for gunite and concrete pool structures'],
                        ['name' => 'Vinyl Liner Resurfacing', 'description' => 'Complete vinyl liner replacement and resurfacing solutions'],
                    ];
                @endphp

                @foreach($subServices as $index => $service)
                <div class="col-lg-3 col-md-6 mb-4">
                    <!-- How Work Item Start -->
                    <div class="how-work-item">
                        <div class="how-work-item-image">
                            <figure class="image-anime">
                                <img src="{{ asset('images/how-work/how-work-image-' . ($index + 1) . '.jpg') }}" alt="{{ $service['name'] }}">
                            </figure>
                            <div class="how-work-item-no">
                                <h3>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</h3>
                            </div>
                        </div>
                        <div class="how-work-item-content">
                            <h3>{{ $service['name'] }}</h3>
                            <p>{{ $service['description'] }}</p>
                        </div>
                    </div>
                    <!-- How Work Item End -->
                </div>
                @endforeach
            </div>
        </div>

        <!-- Main Content and Sidebar -->
        <div class="row">
            <!-- Main Body Content -->
            <div class="col-lg-8">
                <div class="main-content">
                    <h2>Professional Pool Resurfacing Services</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                    <h3>Why Choose Our Pool Resurfacing Services?</h3>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                    <ul>
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>
                        <li>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</li>
                        <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris</li>
                        <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum</li>
                    </ul>

                    <h3>Our Pool Resurfacing Process</h3>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.</p>

                    <h4>Step 1: Inspection and Assessment</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                    <h4>Step 2: Surface Preparation</h4>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                    <h4>Step 3: Application</h4>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>

                    <h4>Step 4: Finishing and Curing</h4>
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.</p>

                    <h3>Types of Pool Surfaces We Resurface</h3>
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>

                    <ul>
                        <li><strong>Concrete Pools:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>
                        <li><strong>Gunite Pools:</strong> Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</li>
                        <li><strong>Fiberglass Pools:</strong> Ut enim ad minim veniam, quis nostrud exercitation ullamco</li>
                        <li><strong>Vinyl Liner Pools:</strong> Duis aute irure dolor in reprehenderit in voluptate velit</li>
                    </ul>

                    <h3>Frequently Asked Questions</h3>

                    <h4>How often should a pool be resurfaced?</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Typically, pools need resurfacing every 10-15 years depending on the material and maintenance.</p>

                    <h4>How long does pool resurfacing take?</h4>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Most resurfacing projects take 3-7 days depending on the size and condition of your pool.</p>

                    <h4>What are the signs that my pool needs resurfacing?</h4>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Common signs include rough texture, staining, chalking, and visible cracks or chips in the surface.</p>

                    @if($silo->content)
                        <!-- Dynamic content from database -->
                        {!! $silo->content !!}
                    @endif
                </div>
            </div>

            <!-- Sticky Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar-sticky-wrapper" style="height: 100%;">
                    <div class="sticky-sidebar" style="position: sticky; position: -webkit-sticky; top: 100px; z-index: 100;">
                        <!-- Contact Form Widget -->
                    <div class="appoinment-form sidebar-form" data-background="{{ asset('images/home2/form-bg.jpg') }}">
                        <div class="appoinment-title">
                            <h4>👉 Free Online Quote 👈</h4>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                                {{ session('success') }}
                            </div>
                        @endif

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

                        <form action="{{ route('contact.store') }}" method="POST" id="sidebar-contact-form">
                            @csrf
                            <input type="hidden" name="type" value="pool_resurfacing_quote">
                            <div class="name-field-wrapper" style="position: relative;">
                                <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required
                                       class="{{ $errors->has('name') ? 'error' : '' }}">
                            </div>
                            <input type="tel" name="phone" placeholder="Phone Number*" value="{{ old('phone') }}" required
                                   class="{{ $errors->has('phone') ? 'error' : '' }}" maxlength="20" autocomplete="tel">
                            <input type="email" name="address" placeholder="Email Address" value="{{ old('address') }}"
                                   class="{{ $errors->has('address') ? 'error' : '' }}">
                            <div class="select-field">
                                <select name="service" required class="{{ $errors->has('service') ? 'error' : '' }}">
                                    <option value="request-callback" {{ old('service') == 'request-callback' || old('service') === null ? 'selected' : '' }}>Request A Callback</option>
                                    <option value="pool-resurfacing-conversion" {{ old('service') == 'pool-resurfacing-conversion' ? 'selected' : '' }}>Pool Resurfacing & Conversion</option>
                                    <option value="pool-repair" {{ old('service') == 'pool-repair' ? 'selected' : '' }}>Pool Repair</option>
                                    <option value="pool-remodeling" {{ old('service') == 'pool-remodeling' ? 'selected' : '' }}>Pool Remodeling</option>
                                </select>
                            </div>
                            <textarea name="message" placeholder="Notes for our team..." rows="8"
                                      class="{{ $errors->has('message') ? 'error' : '' }}">{{ old('message') }}</textarea>

                            @include('components.recaptcha-button', [
                                'formId' => 'sidebar-contact-form',
                                'buttonText' => 'Get A Quote',
                                'buttonClass' => 'bixol-primary-btn',
                                'buttonIcon' => 'fa-paper-plane'
                            ])
                        </form>
                    </div>

                    <!-- Trust Badges Widget -->
                    <div class="trust-badges-widget mt-4">
                        <h3 class="widget-title mb-3 text-center">Why Choose Us</h3>
                        <div class="trust-badges">
                            @php
                                $logos = [
                                    'flag-of-the-united-states.svg',
                                    'flag-of-texas.svg',
                                    'PHTA-Member-Logo.png',
                                    'North-Dallas-Chamber-icon.png',
                                    'north-texas-food-bank.png',
                                    'WWP_ProudSupporterLockup.svg'
                                ];
                            @endphp

                            <div class="row g-3 align-items-center">
                                @foreach($logos as $logo)
                                    @if(file_exists(public_path('images/homepage-logos/' . $logo)))
                                        <div class="col-6 text-center">
                                            <div class="trust-badge-wrapper">
                                                <img src="{{ asset('images/homepage-logos/' . $logo) }}"
                                                     alt="{{ pathinfo($logo, PATHINFO_FILENAME) }}"
                                                     class="trust-badge-img">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Pool Resurfacing Main Content End -->

<!-- Call to Action Section -->
<section class="cta-section bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3>Ready to Transform Your Pool?</h3>
                <p class="mb-0">Contact our pool resurfacing experts today for a free consultation and quote.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="tel:972-702-7586" class="btn btn-light btn-lg me-2 mb-2">
                    <i class="fas fa-phone"></i> Call 972-702-7586
                </a>
                <a href="/pool-repair-quote" class="btn btn-outline-light btn-lg mb-2">
                    Get Quote Online
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Custom Styles for Pool Resurfacing Page -->
<style>
/* CRITICAL FIX: Override global section overflow hidden that breaks sticky */
section.pool-resurfacing-section {
    overflow: visible !important;
    overflow: clip !important; /* Fallback for older browsers */
}

/* Ensure main element doesn't have overflow issues */
main {
    overflow: visible !important;
}

/* Sidebar Form Styles */
.sidebar-form.appoinment-form {
    background-size: cover;
    background-position: center;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.sidebar-form .appoinment-title {
    text-align: center;
    margin-bottom: 20px;
}

.sidebar-form .appoinment-title h4 {
    font-size: 20px;
    color: #ffffff;
    font-weight: 600;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

.sidebar-form input,
.sidebar-form select,
.sidebar-form textarea {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.sidebar-form .select-field select {
    background-color: #fff;
}

.sidebar-form .bixol-primary-btn {
    width: 100%;
    padding: 12px 20px;
    background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
    color: #fff;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.sidebar-form .bixol-primary-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.name-field-wrapper::after {
    content: "Mr. Mrs. Ms.";
    position: absolute;
    right: 15px;
    top: 12px;
    font-style: italic;
    color: #999;
    pointer-events: none;
    font-size: 14px;
}

.name-field-wrapper input[name="name"] {
    padding-right: 100px;
}

.sidebar-form input.error,
.sidebar-form select.error,
.sidebar-form textarea.error {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

/* Intro Section Styles */
.intro-section {
    padding: 2rem 0;
    border-bottom: 2px solid #f0f0f0;
}

.intro-section h1 {
    color: #333;
    font-weight: 700;
}

.intro-section .lead {
    font-size: 1.15rem;
    color: #666;
}

/* Sub-Services Section */
.sub-services-section {
    padding: 3rem 0;
}

/* Main Content Styles */
.main-content {
    padding-right: 2rem;
}

.main-content h2 {
    color: #333;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.main-content h3 {
    color: #444;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.main-content h4 {
    color: #555;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-weight: 500;
}

.main-content ul {
    padding-left: 1.5rem;
    margin-bottom: 1.5rem;
}

.main-content ul li {
    margin-bottom: 0.5rem;
    color: #666;
}

/* Fix Bootstrap row that might have issues */
.pool-resurfacing-section .row {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start !important;
}

/* Ensure parent section allows sticky */
.pool-resurfacing-section {
    overflow: visible !important;
}

/* Sidebar column needs proper setup for sticky */
.pool-resurfacing-section .col-lg-4 {
    align-self: stretch !important; /* Changed from flex-start to stretch */
    position: relative;
}

/* Sidebar Styles - Complete sticky setup */
.sticky-sidebar {
    position: -webkit-sticky !important;
    position: sticky !important;
    top: 100px !important;
    z-index: 100 !important; /* Increased z-index */
    will-change: transform; /* Optimize for sticky */
}

.widget-title {
    color: #333;
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.trust-badges-widget {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

/* Trust Badge Image Styling */
.trust-badge-wrapper {
    padding: 10px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.trust-badge-wrapper:hover {
    background: #e9ecef;
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.trust-badge-img {
    max-width: 100%;
    max-height: 60px;
    width: auto;
    height: auto;
    object-fit: contain;
}

/* Specific adjustments for known logos */
.trust-badge-wrapper img[alt*="PHTA"] {
    max-height: 50px;
}

.trust-badge-wrapper img[alt*="North-Dallas-Chamber"] {
    max-height: 55px;
}

.trust-badge-wrapper img[alt*="food-bank"] {
    max-height: 45px;
}

.trust-badge-wrapper img[alt*="WWP"] {
    max-height: 40px;
}

.trust-badge-wrapper img[alt*="flag-of-the-united-states"],
.trust-badge-wrapper img[alt*="flag-of-texas"] {
    max-height: 45px;
    max-width: 70px;
}

/* Responsive Styles */
@media (max-width: 991px) {
    .sticky-sidebar {
        position: relative !important;
        top: auto !important;
        margin-top: 2rem;
    }

    .main-content {
        padding-right: 0;
        margin-bottom: 2rem;
    }

    /* Adjust trust badges on tablet */
    .trust-badge-wrapper {
        height: 70px;
    }

    .trust-badge-img {
        max-height: 50px;
    }
}

@media (max-width: 767px) {
    .intro-section h1 {
        font-size: 2rem;
    }

    .sub-services-section .col-md-6 {
        margin-bottom: 2rem;
    }

    /* Trust badges on mobile - show 2 per row but smaller */
    .trust-badge-wrapper {
        height: 60px;
        padding: 8px;
    }

    .trust-badge-img {
        max-height: 40px;
    }

    /* Specific mobile adjustments */
    .trust-badge-wrapper img[alt*="PHTA"] {
        max-height: 35px;
    }

    .trust-badge-wrapper img[alt*="North-Dallas-Chamber"] {
        max-height: 40px;
    }

    .trust-badge-wrapper img[alt*="food-bank"] {
        max-height: 35px;
    }

    .trust-badge-wrapper img[alt*="WWP"] {
        max-height: 30px;
    }

    .trust-badge-wrapper img[alt*="flag-of-the-united-states"],
    .trust-badge-wrapper img[alt*="flag-of-texas"] {
        max-height: 35px;
        max-width: 55px;
    }
}
</style>

<!-- JavaScript for Sticky Sidebar Fallback -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if CSS sticky is supported
    var testEl = document.createElement('div');
    testEl.style.position = 'sticky';
    var isSticky = testEl.style.position === 'sticky';

    if (!isSticky) {
        // Fallback for browsers that don't support sticky
        var sidebar = document.querySelector('.sticky-sidebar');
        var sidebarParent = sidebar.parentElement;
        var mainContent = document.querySelector('.main-content').parentElement;

        window.addEventListener('scroll', function() {
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            var sidebarTop = sidebarParent.offsetTop;
            var mainContentHeight = mainContent.offsetHeight;
            var sidebarHeight = sidebar.offsetHeight;

            if (scrollTop > sidebarTop - 100) {
                var maxScroll = sidebarTop + mainContentHeight - sidebarHeight - 100;
                if (scrollTop < maxScroll) {
                    sidebar.style.position = 'fixed';
                    sidebar.style.top = '100px';
                    sidebar.style.width = sidebarParent.offsetWidth + 'px';
                } else {
                    sidebar.style.position = 'absolute';
                    sidebar.style.top = (maxScroll - sidebarTop) + 'px';
                }
            } else {
                sidebar.style.position = 'static';
                sidebar.style.top = 'auto';
            }
        });
    }

    // Debug: Log if sticky is working
    console.log('Sticky positioning supported:', isSticky);

    // Ensure parent containers don't have overflow hidden
    var section = document.querySelector('.pool-resurfacing-section');
    if (section) {
        section.style.overflow = 'visible';
    }
});
</script>
@endsection