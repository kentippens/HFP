@extends('layouts.app')

@section('title', $seoData->meta_title ?? 'About Us')
@section('meta_description', $seoData->meta_description ?? 'Learn more about our professional cleaning services company, our team, mission, and commitment to excellence.')
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

<style>
    /* Featured Services Hover Accent Color */
    .abv2-service-section .abv2-sr-item .abv2-hv-item {
        background-color: #02154e !important;
        background-image: none !important;
    }
    .abv2-service-section .abv2-sr-item .abv2-hv-item::before {
        background-color: #02154e !important;
        background-image: none !important;
    }
    .abv2-service-section .abv2-sr-item .abv2-hv-item::after {
        background-color: #02154e !important;
        background-image: none !important;
    }
    .abv2-service-section .abv2-sr-item:hover .abv2-hv-item {
        background-color: #02154e !important;
        background-image: none !important;
    }
    .abv2-service-section .abv2-hv-item[data-background] {
        background-color: #02154e !important;
        background-image: none !important;
    }
    .abv2-service-section .abv2-sr-item .abv2-hv-item a {
        color: #fff !important;
    }
    .abv2-service-section .abv2-sr-item .abv2-hv-item h5 {
        color: #fff !important;
    }
    .abv2-service-section .abv2-sr-item .abv2-hv-item p {
        color: rgba(255, 255, 255, 0.9) !important;
    }
    .abv2-service-section .abv2-sr-item .abv2-hv-item .hv-item-count {
        color: rgba(255, 255, 255, 0.3) !important;
    }
    /* Override any inline styles or data-background attributes */
    div.abv2-hv-item[style*="background"] {
        background-color: #02154e !important;
        background-image: none !important;
    }
    
    /* Fix email contact content overflow */
    .abv2-contact-item .contact-content {
        word-break: break-word;
        overflow-wrap: break-word;
    }
    .abv2-contact-item .contact-content span {
        display: block;
        margin-bottom: 5px;
    }
    .abv2-contact-item .contact-content a {
        font-size: 14px;
        display: inline-block;
    }
    /* Responsive adjustments for smaller screens */
    @media (max-width: 767px) {
        .abv2-contact-item .contact-content a {
            font-size: 12px;
        }
    }
</style>

<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ asset('images/home1/hero-image-v.jpg') }}">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>About Us</h1>
            <a href="{{ route('home') }}">Home <i class="fas fa-angle-double-right"></i></a>
            <span>About Us</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- History -->
<section class="ab-history-section pt-100 pb-100">
    <span class="ab-history-left-img"><img src="{{ asset('images/about/about-history.jpg') }}" alt=""></span>
    <div class="container">
        <div class="ab-history-top">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="bixol-title-area">
                        <span class="bixol-subtitle">History</span>
                        <h3>You can check our <span>company timeline.</span></h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bf-desc">
                        <p>We're more than just a cleaning company – we're your neighbors committed to helping families and businesses enjoy cleaner, healthier environments through reliable, professional service.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ab-history-tab">
            <div class="tab-control">
                <ul class="nav nav-pills">                    
                    <li><a href="#year2023" data-bs-toggle="pill">2023</a></li>
                    <li><a href="#year2024" data-bs-toggle="pill">2024</a></li>
                    <li><a href="#year2025" data-bs-toggle="pill" class="active">2025</a></li>
                </ul>
                <div class="tab-devider"><hr></div>
            </div>
            <div class="tab-content">                
                <div class="tab-pane fade" id="year2023">
                    <div class="history-content">
                        <h4>Created with a strong desire to make make DFW healthier.</h4>                        
                    </div>
                </div>
                <div class="tab-pane fade" id="year2024">
                    <div class="history-content">
                        <h4>Introducing eco-friendly <br>cleaning solutions!</h4>                        
                    </div>
                </div>
                <div class="tab-pane" id="year2025">
                    <div class="history-content">
                        <h4>Building lasting relationships through dependable service</h4>                                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- History Area End -->

<!-- Services Section -->
<section class="abv2-service-section pt-100" data-background="{{ asset('images/about/service-bg.jpg') }}">
    <div class="container">
        <div class="title-top">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="bixol-title-area">
                        <span class="bixol-subtitle">Featured Services</span>
                        <h3>Essential Services <span>at Affordable Prices</span></h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bf-desc">
                        <p>As your trusted cleaning partner, we help homeowners and businesses maintain beautiful, healthy spaces through our complete range of house, carpet, and pool cleaning services.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="abv2-sr-slider">
            @if($featuredServices->count() > 0)
                @foreach($featuredServices as $index => $service)
                <div class="abv2-sr-item">
                    <span class="item-count">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="icon-wrapper">
                        <span><i class="flaticon-clean"></i></span>
                    </div>
                    <h5>{{ $service->name }}</h5>
                    <p>{{ Str::limit($service->short_description, 100) }}</p>
                    <div class="abv2-hv-item" data-background="{{ asset('images/about/item-bg.jpg') }}">
                        <a href="{{ $service->url }}"><h5>{{ $service->name }}</h5></a>
                        <p>{{ Str::limit($service->short_description, 150) }}</p>
                        <a href="{{ $service->url }}">Read More <i class="fas fa-arrow-right"></i></a>
                        <span class="hv-item-count">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p>No featured services available at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Service Slider End -->

<!-- Contact Section -->
<section class="abv2-contact pt-250 pt-sm-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="abv2-contact-left">
                    <div class="bixol-title-area">
                        <span class="bixol-subtitle">Contact Us</span>
                        <h3>Interested In Our Services?<span>Let's Talk</span></h3>                        
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="abv2-contact-item">
                                <div class="icon-wrapper">
                                    <span><i class="flaticon flaticon-phone"></i></span>
                                </div>
                                <div class="contact-content">
                                    <h5>Phone Number: </h5>
                                    <span><strong> Office</strong>: <a href="tel:9727892983">972-789-2983</a></span>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="abv2-contact-item">
                                <div class="icon-wrapper">
                                    <span><i class="flaticon flaticon-mail"></i></span>
                                </div>
                                <div class="contact-content">
                                    <h5>Email Address: </h5>                                    
                                    <span class="text-grey"><a href="mailto:pools@hexagonfiberglasspools.com">pools@<br>hexagonfiberglasspools.com</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="abv2-contact-item">
                                <div class="icon-wrapper">
                                    <span><i class="flaticon flaticon-pin"></i></span>
                                </div>
                                <div class="contact-content">
                                    <h5>Office Address: </h5>
                                    <span>
                                        603 Munger Ave<br>
                                        Suite 100-243A<br>
                                        Dallas, Texas 75202
                                    </span>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="abv2-contact-item">
                                <div class="icon-wrapper">
                                    <span><i class="flaticon flaticon-alarm-clock"></i></span>
                                </div>
                                <div class="contact-content">
                                    <h5>Business Hours: </h5>
                                    <span><strong>Mon.-Fri.</strong> 9:00 AM - 4:00 PM</span>
                                    <span><strong>Sat.</strong> Closed</span>
                                    <span><strong>Sun.</strong> Closed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="abv2-contact-right">
                    <form action="{{ route('contact.store') }}" method="POST" id="about-contact-form">
                        @csrf
                        <input type="hidden" name="type" value="appointment">
                        <input type="hidden" name="source" value="about_page">
                        
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
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="name-field-wrapper" style="position: relative;">
                                    <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required 
                                           class="{{ $errors->has('name') ? 'error' : '' }}">
                                    <style>
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
                                        /* Match contact page form styling */
                                        .abv2-contact-right form {
                                            width: 100%;
                                            margin-top: 20px;
                                        }
                                        .abv2-contact-right form input,
                                        .abv2-contact-right form select,
                                        .abv2-contact-right form textarea {
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
                                        .abv2-contact-right form input::placeholder,
                                        .abv2-contact-right form select::placeholder,
                                        .abv2-contact-right form textarea::placeholder {
                                            color: #b8c5d1 !important;
                                        }
                                        .abv2-contact-right input.error,
                                        .abv2-contact-right select.error,
                                        .abv2-contact-right textarea.error {
                                            border-color: #dc3545 !important;
                                            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
                                        }
                                        
                                        /* Bootstrap grid fixes for about page */
                                        .abv2-contact-right .row {
                                            margin-left: 0;
                                            margin-right: 0;
                                        }
                                        .abv2-contact-right .row > * {
                                            padding-left: 5px;
                                            padding-right: 5px;
                                        }
                                        
                                        /* Match contact page button styling */
                                        .abv2-contact-right .submit-btn {
                                            margin-top: 0;
                                        }
                                        .abv2-contact-right .submit-btn button {
                                            width: 100%;
                                            height: 50px;
                                            display: flex !important;
                                            align-items: center !important;
                                            justify-content: center !important;
                                            background-color: #22356f !important;
                                            border: 0;
                                            border-radius: 3px;
                                            color: #ffffff !important;
                                            font-family: "Poppins", sans-serif !important;
                                            font-weight: 700 !important;
                                            font-size: 15px !important;
                                            transition: all 0.3s ease-in !important;
                                            text-align: center;
                                        }
                                        .abv2-contact-right .submit-btn button i {
                                            margin-right: 10px;
                                            display: inline-flex;
                                            align-items: center;
                                        }
                                        .abv2-contact-right .submit-btn button:hover {
                                            background-color: #28a745 !important;
                                        }
                                        
                                        /* Responsive fixes */
                                        @media (max-width: 767.98px) {
                                            .abv2-contact-right .row > * {
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
                                    </style>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="phone-number">
                                    <input type="tel" name="phone" placeholder="Phone Number*" value="{{ old('phone') }}" required
                                           class="{{ $errors->has('phone') ? 'error' : '' }}" maxlength="20" autocomplete="tel">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mail-field">
                                    <input type="email" name="address" placeholder="Email Address" value="{{ old('address') }}"
                                           class="{{ $errors->has('address') ? 'error' : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="select-field">
                                    <select name="service" required class="{{ $errors->has('service') ? 'error' : '' }}">
                                        <option value="request-callback" {{ old('service') == 'request-callback' || old('service') === null ? 'selected' : '' }}>Request A Callback</option>
                                        <option value="pool-resurfacing-conversion" {{ old('service') == 'pool-resurfacing-conversion' ? 'selected' : '' }}>Pool Resurfacing & Conversion</option>
                                        <option value="pool-repair" {{ old('service') == 'pool-repair' ? 'selected' : '' }}>Pool Repair</option>
                                        <option value="pool-remodeling" {{ old('service') == 'pool-remodeling' ? 'selected' : '' }}>Pool Remodeling</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="message-field">
                                    <textarea name="message" placeholder="Notes for our team..." rows="8"
                                              class="{{ $errors->has('message') ? 'error' : '' }}">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="submit-btn">
                            <button type="submit"><i class="fas fa-check-circle"></i>Get A Quote</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<!-- Testimonial Section -->
<section class="abv2-feedback-section pt-100 pb-100" data-background="{{ asset('images/about/feedback-bg.jpg') }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-9 order-2 order-lg-1">
                <div class="abv2-feedback-wrapper">
                    @php
                        $testimonials = [
                            [
                                'title' => 'Great communication and great service',
                                'content' => 'Outstanding service! They transformed my carpets and made my whole house feel fresh and clean. Professional team and great attention to detail.',
                                'client_name' => 'Sarah Martinez',
                                'client_position' => 'Homeowner',
                                'client_image' => 'testimonial-profile.png'
                            ],
                            [
                                'title' => 'Professional and Timely',
                                'content' => 'Best cleaning service I\'ve used. They\'re thorough, trustworthy, and use products that don\'t bother my allergies. Highly recommend!',
                                'client_name' => 'Jennifer Lee',
                                'client_position' => 'Homeowner',
                                'client_image' => 'testimonial-profile.png'
                            ]
                        ];
                    @endphp
                    
                    @foreach($testimonials as $testimonial)
                    <div class="single-item">
                        <span class="quote-icon">,,</span>
                        <div class="title">
                            <span style="color: #02154e;">{{ $testimonial['title'] }}</span>
                        </div>
                        <div class="feedback-txt">
                            <p>{{ $testimonial['content'] }}</p>
                        </div>
                        <div class="clients-info">
                            <div class="img-wrapper">
                                <span class="client-thumb"><img src="{{ asset('images/about/' . $testimonial['client_image']) }}" alt="{{ $testimonial['client_name'] }}"></span>
                            </div>
                            <div class="client-content">
                                <h6>{{ $testimonial['client_name'] }}</h6>
                                <span>{{ $testimonial['client_position'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3 order-1 order-lg-2">
                <div class="abv2-feedback-right">
                    <div class="bixol-title-area">
                        <span class="bixol-subtitle">Customer Testimonials</span>
                        <h3>Proven Results <span>Quality Service.</span></h3>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial Section End -->

<!-- Bottom Spacing for Footer Logo -->
<div style="padding-bottom: 80px;"></div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize service slider
    $('.abv2-sr-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        dots: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    // Initialize testimonial slider
    $('.abv2-feedback-wrapper').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        dots: true,
        arrows: false,
        fade: false
    });


    // Initialize Bootstrap tabs
    $('.nav-pills a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
</script>

<!-- Include contact form validation -->
<script src="{{ asset('js/contact-form-validation.js') }}"></script>
@endpush