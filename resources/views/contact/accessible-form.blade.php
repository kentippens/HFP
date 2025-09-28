@extends('layouts.app')

@section('title', $seoData->meta_title ?? 'Contact Us')
@section('meta_description', $seoData->meta_description ?? 'Get in touch with our professional cleaning team.')
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
<div class="bixol-breadcrumb" data-background="{{ asset('images/home1/hero-image-v.jpg') }}">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>Contact</h1>
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb" style="list-style: none; display: flex; gap: 10px;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Contact Area V3 -->
<section class="contact-v2 contact-v3 pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-v2-left">
                    <div class="bixol-title-area">
                        <h2>We're Live & Local <span>Have a project? Let's Talk.</span></h2>
                    </div>
                    <div class="contact-left-img">
                        <img src="{{ asset('images/contactpage-texas.jpg') }}" alt="Our team in Texas ready to help you">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="contact-v2-right">
                    @if(session('success'))
                    <div class="alert alert-success mb-4" role="alert">
                        <h3 class="sr-only">Success</h3>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" id="main-contact-form" aria-label="Contact Form">
                        @csrf
                        <input type="hidden" name="type" value="appointment">
                        <input type="hidden" name="source" value="contact_page">

                        {{-- Honeypot field for spam protection --}}
                        <div style="position: absolute; left: -9999px;" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger" role="alert" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                <h3 class="sr-only">Error</h3>
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger" role="alert" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                <h3 class="sr-only">Form Validation Errors</h3>
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-sm-12">
                                <x-form.input
                                    name="name"
                                    label="Your Name"
                                    placeholder="Enter your full name (Mr./Mrs./Ms.)"
                                    required="true"
                                    :value="old('name')"
                                    :error="$errors->first('name')"
                                    helpText="Please include your title if preferred (Mr., Mrs., Ms.)"
                                />
                            </div>
                            <div class="col-sm-6">
                                <x-form.input
                                    type="tel"
                                    name="phone"
                                    label="Phone Number"
                                    placeholder="(xxx) xxx-xxxx"
                                    required="true"
                                    :value="old('phone')"
                                    :error="$errors->first('phone')"
                                    maxlength="12"
                                    autocomplete="tel"
                                />
                            </div>
                            <div class="col-sm-6">
                                <x-form.input
                                    type="email"
                                    name="address"
                                    label="Email Address"
                                    placeholder="your.email@example.com"
                                    :value="old('address')"
                                    :error="$errors->first('address')"
                                    autocomplete="email"
                                    helpText="Optional - We'll use this to send you a confirmation"
                                />
                            </div>
                            <div class="col-sm-12">
                                <x-form.select
                                    name="service"
                                    label="Service Needed"
                                    :options="[
                                        'request-callback' => 'Request A Callback',
                                        'pool-resurfacing-conversion' => 'Pool Resurfacing & Conversion',
                                        'pool-repair' => 'Pool Repair',
                                        'pool-remodeling' => 'Pool Remodeling'
                                    ]"
                                    :value="old('service', 'request-callback')"
                                    required="true"
                                    :error="$errors->first('service')"
                                    helpText="Select the service you're interested in"
                                />
                            </div>
                            <div class="col-sm-12">
                                <x-form.textarea
                                    name="message"
                                    label="Additional Notes"
                                    placeholder="Please provide any additional details about your project..."
                                    rows="8"
                                    :value="old('message')"
                                    :error="$errors->first('message')"
                                    showCharCount="true"
                                    maxlength="500"
                                    helpText="Tell us more about your project or specific requirements (optional)"
                                />
                            </div>
                        </div>

                        <div class="submit-btn">
                            <button type="submit" class="btn btn-primary">
                                <span aria-hidden="true">@icon("fas fa-check-circle")</span>
                                Get A Quote
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact V3 End -->

<!-- Contact V3 Info Content  -->
<section class="contact-v3-info-content pt-60 pb-120">
    <div class="container">
        <div class="info-content">
            <h2 class="sr-only">Contact Information</h2>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-4">
                    <div class="info-item">
                        <div class="icon-wrapper" aria-hidden="true">
                            <img src="{{ asset('images/icons/contact/location.svg') }}" alt="">
                        </div>
                        <div class="item-content">
                            <h3>Office Address:</h3>
                            <address>
                                603 Munger Ave<br>
                                Suite 100-243A<br>
                                Dallas, Texas 75202<br>
                            </address>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="info-item">
                        <div class="icon-wrapper" aria-hidden="true">
                            <img src="{{ asset('images/icons/contact/mail.svg') }}" alt="">
                        </div>
                        <div class="item-content">
                            <h3>E-Mail:</h3>
                            <p><a href="mailto:pools@hexagonservicesolutions.com" aria-label="Send email to pools@hexagonservicesolutions.com">pools@<br>hexagonservicesolutions.com</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="info-item">
                        <div class="icon-wrapper" aria-hidden="true">
                            <img src="{{ asset('images/icons/contact/calling.svg') }}" alt="">
                        </div>
                        <div class="item-content">
                            <h3>Phone Support:</h3>
                            <p><a href="tel:9727027586" aria-label="Call us at (972) 702-7586">(972) 702-7586</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Info Content End -->

<style>
/* Override for contact form specific styles */
.contact-v2-right input,
.contact-v2-right select,
.contact-v2-right textarea {
    border: 2px solid #043f88 !important;
}

.contact-v2-right .submit-btn button,
.contact-v3 .contact-v2-right .submit-btn button {
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

.contact-v2-right .submit-btn button:hover,
.contact-v3 .contact-v2-right .submit-btn button:hover,
.contact-v2-right .submit-btn button:focus,
.contact-v3 .contact-v2-right .submit-btn button:focus {
    background-color: #28a745 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.contact-v2-right .submit-btn button svg,
.contact-v3 .contact-v2-right .submit-btn button svg {
    margin-right: 10px;
    display: inline-flex;
    align-items: center;
}

/* Contact Info Font Size */
.contact-v3-info-content .info-item .item-content p {
    font-size: 16px !important;
}

.contact-v3-info-content .info-item .item-content p a {
    font-size: 16px !important;
}

/* Ensure form groups have proper spacing */
.contact-v2-right .form-group {
    margin-bottom: 20px;
}

/* Style the breadcrumb for accessibility */
nav[aria-label="Breadcrumb"] .breadcrumb {
    padding: 0;
    margin: 0;
    background: transparent;
}

nav[aria-label="Breadcrumb"] .breadcrumb-item::after {
    content: "›";
    margin: 0 10px;
    color: rgba(255, 255, 255, 0.7);
}

nav[aria-label="Breadcrumb"] .breadcrumb-item:last-child::after {
    content: "";
}

nav[aria-label="Breadcrumb"] .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
}

nav[aria-label="Breadcrumb"] .breadcrumb-item a:hover,
nav[aria-label="Breadcrumb"] .breadcrumb-item a:focus {
    color: #fff;
    text-decoration: underline;
}

nav[aria-label="Breadcrumb"] .breadcrumb-item.active {
    color: #fff;
}
</style>
@endsection