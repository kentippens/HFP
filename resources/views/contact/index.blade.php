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
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>Contact</span>
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
                        <h3>We're Live & Local <span>Have a project? Let's Talk.</span></h3>
                    </div>
                    <div class="contact-left-img">
                        <img src="{{ asset('images/contactpage-texas.jpg') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="contact-v2-right">
                    @if(session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    <form action="{{ route('contact.store') }}" method="POST" id="main-contact-form">
                        @csrf
                        <input type="hidden" name="type" value="appointment">
                        <input type="hidden" name="source" value="contact_page">
                        
                        {{-- Honeypot field for spam protection --}}
                        <div style="position: absolute; left: -9999px;">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>
                        
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
                                        /* Add border to all form fields */
                                        .contact-v2-right input,
                                        .contact-v2-right select,
                                        .contact-v2-right textarea {
                                            border: 2px solid #043f88 !important;
                                        }
                                        
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
                                        .contact-v2-right input.error,
                                        .contact-v2-right select.error,
                                        .contact-v2-right textarea.error {
                                            border-color: #dc3545 !important;
                                            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
                                        }
                                        
                                        /* Match service details page button styling */
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
                                        .contact-v2-right .submit-btn button i,
                                        .contact-v3 .contact-v2-right .submit-btn button i {
                                            margin-right: 10px;
                                            display: inline-flex;
                                            align-items: center;
                                        }
                                        .contact-v2-right .submit-btn button:hover,
                                        .contact-v3 .contact-v2-right .submit-btn button:hover {
                                            background-color: #28a745 !important;
                                        }
                                        
                                        /* Contact Info Font Size */
                                        .contact-v3-info-content .info-item .item-content p {
                                            font-size: 16px !important;
                                        }
                                        .contact-v3-info-content .info-item .item-content p a {
                                            font-size: 16px !important;
                                        }
                                    </style>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="phone-number">
                                    <input type="tel" name="phone" placeholder="Phone Number*" value="{{ old('phone') }}" required
                                           class="{{ $errors->has('phone') ? 'error' : '' }}" maxlength="12" autocomplete="tel">
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
                            <button type="submit">@icon("fas fa-check-circle")Get A Quote</button>
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
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-4">
                    <div class="info-item">
                        <div class="icon-wrapper">
                            <img src="{{ asset('images/icons/contact/location.svg') }}" alt="Location" class="contact-page-icon">
                        </div>
                        <div class="item-content">
                            <h4>Office Address:</h4>
                            <p>603 Munger Ave<br>
                                Suite 100-243A<br>
                                Dallas, Texas 75202<br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="info-item">
                        <div class="icon-wrapper">
                            <img src="{{ asset('images/icons/contact/mail.svg') }}" alt="Email" class="contact-page-icon">
                        </div>
                        <div class="item-content">
                            <h4>E-Mail:</h4>
                            <p><a href="mailto:pools@hexagonservicesolutions.com">pools@<br>hexagonservicesolutions.com</a></p>                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="info-item">
                        <div class="icon-wrapper">
                            <img src="{{ asset('images/icons/contact/calling.svg') }}" alt="Phone" class="contact-page-icon">
                        </div>
                        <div class="item-content">
                            <h4>Phone Support:</h4>
                            <p><a href="tel:9727027586">(972) 702-7586</a></p>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Info Content End -->
@endsection