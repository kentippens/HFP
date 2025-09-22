@extends('layouts.app')

@section('title', $seoData->meta_title ?? 'Premier Pool Resurfacing | Fiberglass, Plaster & Pebble Finishes')
@section('meta_description', $seoData->meta_description ?? 'Transform your pool with our professional resurfacing services. Fiberglass, plaster, and pebble finishes available. 15-20 year warranties.')
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

<!-- Pool Season CTA -->
<section class="pool-cta-section py-5">
    <div class="container">
        <div class="cta-section text-center">
            <h5 class="mb-3">🏊 Get Your Pool Ready for Swimming Season! 🏊</h5>
            <p class="mb-4">FREE Inspection + 15% Off All Resurfacing Services - Limited Time Offer</p>
            <a href="{{ route('contact.index') }}" class="bixol-primary-btn pool-btn">
                Get Your Free Quote
                <span>@icon("fas fa-arrow-right")</span>
            </a>
        </div>
    </div>
</section>
<!-- Pool CTA End -->

<!-- About Section -->
<section class="home2-about-section pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-left">
                    <div class="img-wrapper">
                        <img src="{{ asset('images/home2/pool-resurfacing-about.jpg') }}" alt="Pool Resurfacing Services">                                                
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-right">
                    <div class="bixol-title-area">
                        <span class="bixol-subtitle">About Premier Pool Resurfacing</span>
                        <h3>Why Choose <span>Our Pool Services?</span></h3>
                        <p>With over 15 years of experience in pool resurfacing, we've transformed thousands of pools across the region.</p>
                    </div>
                    <div class="seperator"><hr></div>
                    <div class="about-content">
                        <ul>
                            <li>@icon('fa-check')<p>15-20 Year Warranties on Fiberglass Resurfacing</p></li>    
                            <li>@icon('fa-check')<p>Licensed, Bonded & Fully Insured</p></li>                            
                            <li>@icon('fa-check')<p>Free Inspections & Detailed Quotes</p></li>
                            <li>@icon('fa-check')<p>Eco-Friendly Materials & Processes</p></li>
                            <li>@icon('fa-check')<p>Expert Craftsmen with 10+ Years Experience</p></li>
                            <li>@icon('fa-check')<p>Competitive Pricing with Flexible Financing</p></li>
                            <li>@icon('fa-check')<p>100% Satisfaction Guarantee</p></li>                            
                        </ul>
                    </div>
                    <div class="about-btn">
                        <a href="{{ route('services.index') }}" class="bixol-primary-btn">View Our Services<span>@icon('fa-plus')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Services Section -->
<section class="home2-service-section pt-100 pb-70" data-background="{{ asset('images/home2/pool-service-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="bixol-title-area text-center">
                    <span class="bixol-subtitle">Our Pool Services</span>
                    <h3>Complete Pool <span>Resurfacing Solutions</span></h3>
                    <p>From fiberglass coating to pebble finishes, we offer comprehensive pool resurfacing services that transform your pool into a stunning centerpiece. Our expert technicians use the latest techniques and premium materials to ensure lasting beauty and durability.</p>
                </div>
            </div>
        </div>
        <div class="home2-service-slider">
            @foreach($featuredServices as $service)
            <div class="service-single-item">
                <div class="srv2-icon-wrapper">
                    @php
                        $serviceIcons = [
                            'fiberglass' => 'fiberglass-icon.svg',
                            'plaster' => 'plaster-icon.svg', 
                            'pebble' => 'pebble-icon.svg',
                            'tile' => 'tile-icon.svg',
                            'crack' => 'repair-icon.svg',
                            'acid' => 'acid-wash-icon.svg',
                            'inspection' => 'inspection-icon.svg',
                            'commercial' => 'commercial-icon.svg',
                            'pool' => 'swimming-pool.svg',
                        ];
                        
                        $iconName = 'swimming-pool.svg'; // Default icon
                        foreach($serviceIcons as $keyword => $icon) {
                            if(str_contains(strtolower($service->name), $keyword)) {
                                $iconName = $icon;
                                break;
                            }
                        }
                    @endphp
                    <img src="{{ asset('images/icons/' . $iconName) }}" alt="{{ $service->name }} Icon">
                </div>
                <div class="service-content">
                    <h5><a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a></h5>
                    <p>{{ $service->short_description }}</p>
                    <div class="btn-wrapper">
                        <a href="{{ route('services.show', $service->slug) }}">Learn More <span>@icon("fa-arrow-right")</span></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Why Choose Section -->
<section class="home2-why-section pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="hw-right-content">
                    <div class="bixol-title-area">
                        <span class="bixol-subtitle">Why Premier Pool</span>
                        <h3>Trusted Pool <span>Resurfacing Experts</span></h3>
                    </div>
                    <p>We've built our reputation on quality workmanship, honest pricing, and exceptional customer service. Every pool we resurface is a testament to our commitment to excellence.</p>
                    <div class="hw-list">
                        <ul>
                            <li>@icon("fa-check")<span>Over 5,000 Pools Resurfaced</span></li>
                            <li>@icon("fa-check")<span>Factory-Trained Technicians</span></li>
                            <li>@icon("fa-check")<span>Premium Materials Only</span></li>
                            <li>@icon("fa-check")<span>Lifetime Support</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="why-img-wrapper">
                    <img src="{{ asset('images/home2/pool-why-choose.jpg') }}" alt="Why Choose Us">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Why Choose Section End -->

<!-- Process Section -->
<section class="pool-process-section pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="bixol-title-area text-center">
                    <span class="bixol-subtitle">Our Process</span>
                    <h3>Simple Steps to <span>Pool Perfection</span></h3>
                    <p>Our streamlined process ensures your pool resurfacing project is completed efficiently with minimal disruption.</p>
                </div>
            </div>
        </div>
        <div class="row pt-50">
            <div class="col-lg-3 col-md-6">
                <div class="process-item text-center">
                    <div class="process-icon">
                        <span class="step-number">1</span>
                    </div>
                    <h5>Free Inspection</h5>
                    <p>Comprehensive assessment of your pool's condition</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="process-item text-center">
                    <div class="process-icon">
                        <span class="step-number">2</span>
                    </div>
                    <h5>Custom Quote</h5>
                    <p>Detailed estimate with multiple finish options</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="process-item text-center">
                    <div class="process-icon">
                        <span class="step-number">3</span>
                    </div>
                    <h5>Professional Work</h5>
                    <p>Expert resurfacing by certified technicians</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="process-item text-center">
                    <div class="process-icon">
                        <span class="step-number">4</span>
                    </div>
                    <h5>Final Inspection</h5>
                    <p>Quality check and warranty activation</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Process Section End -->

<!-- Testimonial Section -->
<section class="home-testimonial home2-testimonial">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="bixol-title-area text-center">
                    <span class="bixol-subtitle">Customer Reviews</span>
                    <h3>What Our <span>Clients Say</span></h3>
                </div>
            </div>
        </div>
        <div class="home2-testimonial-wrapper pt-60">
            <div class="testimonial-slider">
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <p>"Our pool looks brand new! The fiberglass resurfacing has completely transformed it. The team was professional, on time, and the results exceeded our expectations."</p>
                        <div class="author-info">
                            <h6>Sarah Johnson</h6>
                            <span>Homeowner</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <p>"Best investment we've made in our home. The pebble finish is absolutely beautiful and the warranty gives us peace of mind. Highly recommend!"</p>
                        <div class="author-info">
                            <h6>Mike Thompson</h6>
                            <span>Property Owner</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <p>"They resurfaced our community pool with minimal disruption to our residents. Professional, efficient, and the results speak for themselves."</p>
                        <div class="author-info">
                            <h6>Jennifer Martinez</h6>
                            <span>HOA President</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial Section End -->

<!-- CTA Section -->
<section class="home2-cta-section">
    <div class="container">
        <div class="cta-bg" data-background="{{ asset('images/home2/pool-cta-bg.jpg') }}">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="cta-content">
                        <h3>Ready to Transform Your Pool?</h3>
                        <p>Get a free inspection and quote today. No obligations, just expert advice.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cta-btn text-lg-end">
                        <a href="{{ route('contact.index') }}" class="bixol-primary-btn white-btn">Get Free Quote<span>@icon('fa-arrow-right')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- CTA Section End -->

@endsection