@extends('layouts.app')

@section('title', $seoData->meta_title ?? 'Home')
@section('meta_description', $seoData->meta_description ?? 'Professional cleaning services for homes and offices. Quality service with experienced staff.')
@section('meta_robots', $seoData->meta_robots ?? 'index, follow')
@if($seoData && $seoData->canonical_url)
    @section('canonical_url', $seoData->canonical_url)
@endif
@if($seoData && $seoData->json_ld)
    @section('json_ld')
{!! $seoData->json_ld_string !!}
    @endsection
@endif
@section('body_class', 'home-page')


@section('content')

@include('components.hero-static')

<!-- Local Trust Signals -->
<section class="local-trust-signals py-4">
    <div class="container">
        <div class="trust-signals-wrapper">
            <div class="trust-signal-item">
                <img src="{{ asset('images/homepage-logos/north-texas-food-bank.png') }}" alt="North Texas Food Bank" class="trust-logo food-bank-logo">
            </div>
            <div class="trust-signal-item">
                <img src="{{ asset('images/homepage-logos/WWP_ProudSupporterLockup.svg') }}" alt="Wounded Warrior Project" class="trust-logo wwp-logo">
            </div>
            <div class="trust-signal-item">
                <img src="{{ asset('images/homepage-logos/flag-of-the-united-states.svg') }}" alt="USA Flag" class="flag-logo">
            </div>
            <div class="trust-signal-item">
                <img src="{{ asset('images/homepage-logos/flag-of-texas.svg') }}" alt="Texas Flag" class="flag-logo">
            </div>
            <div class="trust-signal-item">
                <img src="{{ asset('images/homepage-logos/North-Dallas-Chamber-icon.png') }}" alt="North Dallas Chamber" class="trust-logo chamber-logo">
            </div>
            <div class="trust-signal-item">
                <img src="{{ asset('images/homepage-logos/PHTA-Member-Logo.png') }}" alt="Pool & Hot Tub Alliance Member" class="trust-logo phta-logo">
            </div>
        </div>
    </div>
</section>
<!-- Local Trust Signals End -->

<!-- Our Services Section Start -->
<div class="our-services-featured">
    <div class="container">
        <div class="row section-row align-items-center">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title text-center">
                    <h3 class="services-subtitle">What We Do</h3>
                    <h2>Professional Pool Conversion &<br>Resurfacing Experts</h2>
                </div>
                <!-- Section Title End -->
            </div>
        </div>

        <div class="services-carousel-wrapper">
            <div class="row services-grid">
                @forelse($featuredServices->take(4) as $index => $service)
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <!-- Service Card Start -->
                    <div class="service-card-featured">
                        @php
                            // Use provided image or fallback to placeholder
                            $imageUrl = isset($service->image) ? asset($service->image) : asset('images/services/placeholder-service.jpg');
                        @endphp
                        <div class="service-card-image" data-bg-image="{{ $imageUrl }}">
                            <div class="service-overlay"></div>
                            <div class="service-card-content">
                                <h4 class="service-title">{{ $service->name }}</h4>
                                <a href="{{ route($service->route) }}" class="service-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Card End -->
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No services available at this time. Please check back later.</p>
                </div>
                @endforelse
            </div>

            <!-- Carousel Navigation -->
            <div class="services-nav">
                <div class="nav-dots">
                    @foreach($featuredServices->take(4) as $index => $service)
                    <span class="dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
                    @endforeach
                </div>
                <div class="nav-text">
                    <span>Let's make something great work together.</span>
                    <a href="{{ route('contact.index') }}" class="get-quote-link">Get Free Quote</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Our Services Section End -->

<!-- How it Works Section -->
<section class="how-it-works-section">
    <div class="container">
        <div class="row section-row align-items-center">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title section-title-center">
                    <h3 class="how-subtitle how-subtitle-white">
                        <span class="star-icon">✦</span>
                        <span>How We Do It</span>
                    </h3>
                    <h2 class="how-main-title">How it works easy pool care<br>process</h2>
                </div>
                <!-- Section Title End -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <!-- How Work Item Start -->
                <div class="how-work-item">
                    <div class="how-work-item-image">
                        <figure class="image-anime">
                            <img src="{{ asset('images/how-work/how-work-image-1.jpg') }}" alt="Book a Service">
                        </figure>

                        <div class="how-work-item-no">
                            <h3>01</h3>
                        </div>
                    </div>
                    <div class="how-work-item-content">
                        <h3>Book a Service</h3>
                        <p>Book a Service Easily schedule a your pool cleaning at a time.</p>
                    </div>
                </div>
                <!-- How Work Item End -->
            </div>

            <div class="col-lg-3 col-md-6">
                <!-- How Work Item Start -->
                <div class="how-work-item">
                    <div class="how-work-item-image">
                        <figure class="image-anime">
                            <img src="{{ asset('images/how-work/how-work-image-2.jpg') }}" alt="Personalized Plan">
                        </figure>

                        <div class="how-work-item-no">
                            <h3>02</h3>
                        </div>
                    </div>
                    <div class="how-work-item-content">
                        <h3>Personalized Plan</h3>
                        <p>Book a Service Easily schedule a your pool cleaning at a time.</p>
                    </div>
                </div>
                <!-- How Work Item End -->
            </div>

            <div class="col-lg-3 col-md-6">
                <!-- How Work Item Start -->
                <div class="how-work-item">
                    <div class="how-work-item-image">
                        <figure class="image-anime">
                            <img src="{{ asset('images/how-work/how-work-image-3.jpg') }}" alt="Expert Cleaning">
                        </figure>

                        <div class="how-work-item-no">
                            <h3>03</h3>
                        </div>
                    </div>
                    <div class="how-work-item-content">
                        <h3>Expert Cleaning</h3>
                        <p>Book a Service Easily schedule a your pool cleaning at a time.</p>
                    </div>
                </div>
                <!-- How Work Item End -->
            </div>

            <div class="col-lg-3 col-md-6">
                <!-- How Work Item Start -->
                <div class="how-work-item">
                    <div class="how-work-item-image">
                        <figure class="image-anime">
                            <img src="{{ asset('images/how-work/how-work-image-4.jpg') }}" alt="Ongoing Support">
                        </figure>

                        <div class="how-work-item-no">
                            <h3>04</h3>
                        </div>
                    </div>
                    <div class="how-work-item-content">
                        <h3>Ongoing Support</h3>
                        <p>Book a Service Easily schedule a your pool cleaning at a time.</p>
                    </div>
                </div>
                <!-- How Work Item End -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- Section Footer Text Start -->
                <div class="how-it-works-footer">
                    <p>24/7 Customer Support Ready Whenever You Need Us. <a href="{{ route('contact.index') }}" class="get-quote-link">Get Free Quote</a></p>
                </div>
                <!-- Section Footer Text End -->
            </div>
        </div>
    </div>
</section>
<!-- How it Works Section End -->

<!-- PMV Section -->
<section class="home2-pmv-section pt-100 pb-100">
    <div class="container">
        <div class="pmv-top">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="bixol-title-area">
                        <span class="bixol-subtitle">Why Choose us?</span>
                        <h3>We're Local <span>and we like that way.</span></h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bf-desc">
                        <p>Our dedication lies in delivering outstanding services distinguished by customer service and unique features that differentiate us from others in the industry.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="pmv-bottom">
            <div class="pmv-nav">
                <ul class="nav">
                    <li><a href="#philosophy" data-bs-toggle="tab" class="active">Our Philosophy</a></li>
                    <li><a href="#mission" data-bs-toggle="tab">Company Mission</a></li>
                    <li><a href="#vision" data-bs-toggle="tab">Our Vision</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="philosophy">
                    <div class="row align-items-center">
                        <div class="col-lg-6 order-2 order-lg-1">
                            <div class="pmv-content">
                                <h4>The Hexagon Promise</h4>
                                <p>Do It Right The First Time. We put your satisfaction first by delivering excellent service. If our work doesn't meet your expectations, we'll return to re-clean the area at no extra cost.</p>
                                {{-- <a href="{{ route('about') }}" class="bixol-primary-btn">View terms of services</a> --}}
                            </div>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2">
                            <div class="img-wrapper">
                                <img src="{{ asset('images/home2/hss-promise.png') }}" alt="Our Philosophy">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="mission">
                    <div class="row align-items-center">
                        <div class="col-lg-6 order-2 order-lg-1">
                            <div class="pmv-content">
                                <h4>Customer Service Excellence</h4>
                                <p>Our mission is to deliver comprehensive, environmentally responsible cleaning solutions that consistently surpass client expectations. We are dedicated to fostering healthier environments for our clients while upholding the utmost standards of professionalism and reliability in all our engagements.</p>
                                {{-- <a href="{{ route('about') }}" class="bixol-primary-btn">Learn more about us</a> --}}
                            </div>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2">
                            <div class="img-wrapper">
                                <img src="{{ asset('images/home2/hss-company-mission.png') }}" alt="Our Mission">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="vision">
                    <div class="row align-items-center">
                        <div class="col-lg-6 order-2 order-lg-1">
                            <div class="pmv-content">
                                <h4>Creating a Cleaner, Healthier, Stress Free future. Together.</h4>
                                <p>Our mission is to deliver outstanding service at competitive prices. We strive to redefine perceptions of professional cleaning services by applying advanced techniques, maintaining high standards of quality, leveraging innovative technology, and demonstrating authentic care for our partners.</p>
                                <a href="{{ route('services.index') }}" class="bixol-primary-btn">Explore our services</a>
                            </div>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2">
                            <div class="img-wrapper">
                                <img src="{{ asset('images/home2/hss-vision.png') }}" alt="Our Vision">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- PMV Section End -->

<!-- FAQ Section -->
<section class="home2-faq-area pt-100 pb-100" data-background="{{ asset('images/home2/faqs-background.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-6">
                <div class="faq-content">
                    <div class="bixol-title-area">
                        <span class="bixol-subtitle faq-subtitle">FAQ</span>
                        <h3><span class="faq-title"><strong>Common Questions Answered:</strong></span><span><strong>Our FAQs.</strong></span></h3>
                        <p class="faq-description">Find answers to the most common questions about our cleaning services and policies.</p>
                    </div>
                    <div class="faq-wrapper">
                        <div class="accordion" id="faq-accordion">
                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <a href="#collapseOne" data-bs-toggle="collapse">What is the Hexagon Guarantee?</a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-bs-parent="#faq-accordion">
                                    <div class="accordion-body">
                                        <p>The Hexagon Guarantee is our service commitment. Right the 1st Time. Every Time. Or we'll fix it at no charge.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <a href="#collapseTwo" data-bs-toggle="collapse">What Areas Do You Service?</a>
                                </div>
                                <div id="collapseTwo" class="collapse" data-bs-parent="#faq-accordion">
                                    <div class="accordion-body">
                                        <p>We serve the DFW metroplex. We do service clients beyond with an additional travel fee.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <a href="#collapseThree" data-bs-toggle="collapse">What are your pricing and payment options?</a>
                                </div>
                                <div id="collapseThree" class="collapse" data-bs-parent="#faq-accordion">
                                    <div class="accordion-body">
                                        <p>We offer competitive pricing based on the size and scope of your cleaning needs. We accept major payment methods.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <a href="#collapsefour" data-bs-toggle="collapse">How can I schedule services?</a>
                                </div>
                                <div id="collapsefour" class="collapse" data-bs-parent="#faq-accordion">
                                    <div class="accordion-body">
                                        <p>You can schedule by calling us directly, filling out our online form, or using our appointment booking system on the website.</p>
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
<!-- FAQ Area End -->

<!-- Feedback Area -->
<section class="srv2-feedback-area pt-100 pb-100">
    <div class="container">
        <div class="srv2-feedback-top">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="bixol-title-area">
                        <span class="bixol-subtitle">Clients Testimonial</span>
                        <h3>Service. <span>It's In Our Name.</span></h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bf-desc">
                        <p>Testimonials from our valued clients regarding the quality of our professional cleaning services and our commitment to outstanding customer care.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="srv2-feedback-wrapper srv2-feedback-slider">
            @php                
                $testimonials = [
                    ['name' => 'Sarah Martinez', 'position' => 'Homeowner', 'image' => 'client-1.png', 'review' => 'Outstanding service! They transformed my carpets and made my whole house feel fresh and clean. Professional team and great attention to detail.'],
                    ['name' => 'David Wilson', 'position' => 'Office Manager', 'image' => 'client-2.png', 'review' => 'Reliable pool cleaning service that keeps our pool perfect year-round. They\'re always on time and do thorough work.'],
                    ['name' => 'Jennifer Lee', 'position' => 'Homeowner', 'image' => 'client-3.png', 'review' => 'Best cleaning service I\'ve used. They\'re thorough, trustworthy, and use products that don\'t bother my allergies. Highly recommend!'],                    
                ];
            @endphp
            @foreach($testimonials as $testimonial)
            <div class="feedback-single">
                <p>{{ $testimonial['review'] }}</p>
                <div class="srv2-clients-info">
                    <div class="clients-thumb">
                        <span><img src="{{ asset('images/services/' . $testimonial['image']) }}" alt="{{ $testimonial['name'] }}"></span>
                    </div>
                    <div class="clients-info">
                        <h5>{{ $testimonial['name'] }}</h5>
                        <span>{{ $testimonial['position'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Feedback Area End -->

<!-- Divider -->
<div class="section-divider">
    <div class="container">
        <hr class="divider-line">
    </div>
</div>
<!-- Divider End -->

<!-- Blog Area -->
<br>
<section class="home2-blog-area pb-100">
    <div class="container">
        <div class="blog-top-title">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="bixol-title-area">
                        <span class="bixol-subtitle">Field Notes Blog</span>
                        <h3>Learn about our latest <span>news from blog.</span></h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bf-desc">
                        <p>Stay updated with our latest tips, industry news, and helpful guides for maintaining a clean and healthy environment.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="home2-blog-slider">
            @forelse($recentPosts as $post)
            <div class="blog-single-item">
                <div class="thumb-wrapper">
                    <a href="{{ route('blog.show', $post->slug) }}"><img src="{{ $post->featured_image_url }}" alt="{{ $post->name }}"></a>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">
                        <span><i class="fas fa-calendar-alt"></i>{{ $post->published_at->format('F d, Y') }}</span>
                        <span><i class="fas fa-user"></i>{{ $post->author }}</span>
                    </div>
                    <div class="blog-title">
                        <a href="{{ route('blog.show', $post->slug) }}"><h5>{{ $post->name }}</h5></a>
                    </div>
                    <div class="readmore-btn">
                        <a href="{{ route('blog.show', $post->slug) }}">Read more <i class="fas fa-angle-double-right"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No blog posts available at the moment.</p>
                <a href="{{ route('blog.index') }}" class="btn btn-primary">View All Blog Posts</a>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- Blog Area End -->

<!-- Contact Area -->
<section class="home2-contact-area">
    <div class="container">
        <div class="home2-git" data-background="{{ asset('images/home2/contact-bg.jpg') }}">
            <div class="row">
                <div class="col-lg-7 order-2 order-lg-1">
                    <div class="git-left">
                        <div class="title">
                            <h3>Need a Service? | Let's Talk</h3>
                        </div>
                        <div class="git-bottom">
                            <div class="phon-area">
                                <span class="git-title">Phone Support:</span>
                                <a href="tel:9727892983"><span><i class="fas fa-phone-alt"></i></span>972-789-2983</a>
                            </div>
                            <div class="git-txt">
                                or
                                <span></span>
                            </div>
                            <div class="mail-area">
                                <span class="git-title">E-Mail Support:</span>
                                <a href="mailto:pools@hexagonfiberglasspools.com"><span><i class="fas fa-envelope"></i></span>pools@<br>hexagonfiberglasspools.com</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2">
                    <div class="git-right">
                        <img src="{{ asset('images/home2/git-right.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Area End -->

@endsection

{{-- Inline styles moved to resources/css/pages/home.css and compiled to public/css/pages.min.css --}}


