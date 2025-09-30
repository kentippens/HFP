@extends('services.templates.base')

@section('service-content')
@php
    // Error handling: Ensure all variables are properly initialized
    $service = $service ?? null;
    if (!$service) {
        Log::error('Service object not available in template');
        return;
    }
@endphp
    {{-- Service Title --}}
    <header class="service-header">
        <h1 class="service-title">{{ $service->name }}</h1>
    </header>

    {{-- Service Image (if exists) --}}
    @if($service->image && $service->image_url)
    <figure class="service-image mb-4" role="img" aria-label="{{ $service->name }} service image">
        <img src="{{ $service->image_url }}"
             alt="{{ $service->meta_image_alt ?? 'Image showing ' . $service->name . ' service' }}"
             class="img-fluid"
             loading="lazy"
             data-hide-on-error="true"
             data-hide-parent-on-error="true">
    </figure>
    @endif

    {{-- Main Service Description --}}
    <section class="service-description mt-20" aria-label="Service Description">
        @if($service->description)
            {!! \App\Helpers\HtmlHelper::safe($service->description, 'services') !!}
        @else
            <p>{{ $service->short_description ?? 'Contact us to learn more about our ' . $service->name . ' services.' }}</p>
        @endif
    </section>

    {{-- Sub-Services Section --}}
    @if(isset($service->activeChildren) && $service->activeChildren->count() > 0)
    <section class="sub-services mt-40" aria-label="Related Services">
        <h2 class="section-title">Related {{ $service->name }} Services</h2>
        <div class="row mt-20">
            @foreach($service->activeChildren as $subService)
            <div class="col-md-6 mb-3">
                <article class="sub-service-card">
                    <h3 class="sub-service-title">
                        <a href="{{ route('services.show', $subService->full_slug) }}">
                            {{ $subService->name }}
                        </a>
                    </h3>
                    <p class="sub-service-description">
                        {{ Str::limit(strip_tags($subService->short_description ?: $subService->description), 100) }}
                    </p>
                    <a href="{{ route('services.show', $subService->full_slug) }}" 
                       class="read-more-link"
                       aria-label="Learn more about {{ $subService->name }}">
                        Learn More <span aria-hidden="true">→</span>
                    </a>
                </article>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Service Benefits/Features --}}
    @if($service->overview || $service->features || $service->benefits)
    <section class="service-details mt-40" aria-label="Service Benefits">
        <h2 class="section-title">Why Choose Our {{ $service->name }} Service</h2>
        
        @if($service->overview)
        <div class="service-overview mt-20">
            {!! \App\Helpers\HtmlHelper::safe($service->overview, 'services') !!}
        </div>
        @endif

        @if($service->benefits && ((is_array($service->benefits) && count($service->benefits) > 0) || (is_object($service->benefits) && count((array)$service->benefits) > 0)))
        <ul class="benefits-list mt-20" role="list">
            @foreach((array)$service->benefits as $benefit)
            <li class="benefit-item">
                <span class="benefit-icon" aria-hidden="true">✓</span>
                <span class="benefit-text">{{ $benefit }}</span>
            </li>
            @endforeach
        </ul>
        @endif

        @if($service->features && ((is_array($service->features) && count($service->features) > 0) || (is_object($service->features) && count((array)$service->features) > 0)))
        <div class="features-section mt-30">
            <h3 class="features-title">Key Features</h3>
            <ul class="features-list mt-20" role="list">
                @foreach((array)$service->features as $feature)
                <li class="feature-item">
                    <span class="feature-icon" aria-hidden="true">•</span>
                    <span class="feature-text">{{ $feature }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </section>
    @endif

    {{-- Call to Action --}}
    <section class="service-cta mt-40">
        <h2 class="cta-title">Get Started with {{ $service->name }}</h2>
        <p class="cta-description">
            Ready to transform your pool? Contact our expert team for a free consultation and quote.
        </p>
        <a href="{{ route('contact.index', ['service' => $service->slug]) }}" 
           class="btn btn-primary btn-lg"
           aria-label="Get a free quote for {{ $service->name }}">
            Get Your Free Quote
        </a>
    </section>
@endsection

@push('service-styles')
<style>
    /* Service Header */
    .service-header {
        margin-bottom: 20px;
    }
    
    .service-title {
        font-size: 2rem;
        color: #043f88;
        margin-bottom: 0;
    }
    
    /* Service Image */
    .service-image {
        margin: 0;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .service-image img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    /* Service Card Styles */
    .sub-service-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .sub-service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .sub-service-title {
        font-size: 1.25rem;
        margin-bottom: 10px;
    }
    
    .sub-service-title a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .sub-service-title a:hover {
        color: #043f88;
    }
    
    .sub-service-description {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
        line-height: 1.6;
    }
    
    .read-more-link {
        color: #043f88;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .read-more-link:hover {
        color: #ff6b35;
    }
    
    /* Benefits & Features Lists */
    .benefits-list,
    .features-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .benefit-item,
    .feature-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        padding-left: 0;
    }
    
    .benefit-icon {
        color: #043f88;
        margin-right: 10px;
        font-weight: bold;
        flex-shrink: 0;
        font-size: 18px;
    }
    
    .feature-icon {
        color: #043f88;
        margin-right: 10px;
        flex-shrink: 0;
        font-size: 16px;
    }
    
    .benefit-text,
    .feature-text {
        flex: 1;
        line-height: 1.6;
        color: #333;
    }
    
    .features-title {
        font-size: 1.25rem;
        color: #043f88;
        margin-bottom: 15px;
    }
    
    /* CTA Section */
    .service-cta {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 40px 30px;
        border-radius: 10px;
        text-align: center;
    }
    
    .cta-title {
        font-size: 1.75rem;
        color: #043f88;
        margin-bottom: 15px;
    }
    
    .cta-description {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 25px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .service-cta .btn-primary {
        background-color: #043f88;
        border-color: #043f88;
        padding: 12px 30px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    
    .service-cta .btn-primary:hover {
        background-color: #032d5f;
        border-color: #032d5f;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(4, 63, 136, 0.3);
    }
    
    /* Section Titles */
    .section-title {
        font-size: 1.5rem;
        color: #043f88;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: #043f88;
    }
    
    /* Service Overview */
    .service-overview {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #555;
    }
    
    .service-overview p {
        margin-bottom: 15px;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .service-title {
            font-size: 1.5rem;
        }
        
        .section-title {
            font-size: 1.25rem;
        }
        
        .cta-title {
            font-size: 1.5rem;
        }
        
        .service-cta {
            padding: 30px 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/image-error-handler.js') }}" defer></script>
@endpush