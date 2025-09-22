@extends('services.templates.base')

@section('service-content')
    {{-- Service Title --}}
    <header class="service-header">
        <h1 class="service-title">{{ $service->name }}</h1>
    </header>

    {{-- Service Image (if exists) --}}
    @if($service->image)
    <figure class="service-image mb-4" role="img" aria-label="{{ $service->name }} service image">
        <img src="{{ $service->image_url }}" 
             alt="{{ $service->meta_image_alt ?? 'Image showing ' . $service->name . ' service' }}" 
             class="img-fluid"
             loading="lazy">
    </figure>
    @endif

    {{-- Main Service Description --}}
    <section class="service-description mt-20" aria-label="Service Description">
        @if($service->description)
            {!! $service->description !!}
        @else
            <p>{{ $service->short_description ?? 'Contact us to learn more about our ' . $service->name . ' services.' }}</p>
        @endif
    </section>

    {{-- Sub-Services Section --}}
    @if($service->activeChildren->count() > 0)
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
    @if($service->features || $service->benefits)
    <section class="service-details mt-40" aria-label="Service Benefits">
        <h2 class="section-title">Why Choose Our {{ $service->name }} Service</h2>
        
        @if($service->overview)
        <div class="service-overview mt-20">
            {!! $service->overview !!}
        </div>
        @endif

        @if($service->benefits)
        <ul class="benefits-list mt-20" role="list">
            @foreach(json_decode($service->benefits, true) ?? [] as $benefit)
            <li class="benefit-item">
                <span class="benefit-icon" aria-hidden="true">✓</span>
                <span class="benefit-text">{{ $benefit }}</span>
            </li>
            @endforeach
        </ul>
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
    
    /* Benefits List */
    .benefits-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .benefit-item {
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
    }
    
    .benefit-text {
        flex: 1;
        line-height: 1.6;
    }
    
    /* CTA Section */
    .service-cta {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 30px;
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
        margin-bottom: 20px;
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
        background: #ff6b35;
    }
</style>
@endpush