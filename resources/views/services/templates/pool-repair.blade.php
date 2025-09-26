@extends('services.templates.base')

@section('service-content')
    <div class="title-txt">
        <h3>{{ $service->title }}</h3>
    </div>
    @if($service->image)
    <div class="service-image mb-4">
        <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="img-fluid">
    </div>
    @endif
    <div class="pera-text mt-20">
        {{-- Custom content for  --}}
        <h4>Professional  Services</h4>
        <p>Experience our exceptional  services designed to meet your specific needs.</p>
        
        {{-- Add custom service-specific content here --}}
        
        {{-- Include database content --}}
        {!! $service->description ?: '<p>Professional service with experienced staff and quality results.</p>' !!}
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
                            {{ $subService->title }}
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
            <div class="col-lg-6">
                <div class="sr-details-left">
                    <div class="title-txt">
                        <h4>Service Overview</h4>
                    </div>
                    <div class="pera-txt mt-20">
                        <p>A neatly maintained building is an important asset to every organization. It reflects who you are and influences how your customers perceive you to complete depending on the size.</p>
                    </div>
                    <div class="pera-txt mt-20">
                        <p>Condition of your home. We work in teams of 2-4 or more. A team leader or the owner.</p>
                    </div>
                    <div class="srd-list mt-20">
                         <ul>
                            <li>@icon("fas fa-check")<p>The housekeepers we hired are professionals who take pride in doing excellent work and in exceeding expectations.</p></li>
                            <li>@icon("fas fa-check")<p>We carefully screen all of our cleaners, so you can rest assured that your home would receive the absolute highest quality of service providing.</p></li>
                            <li>@icon("fas fa-check")<p>Your time is precious, and we understand that cleaning is really just one more item on your to-do list.</p></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="srd-right-img">
                    <img src="{{ asset('images/services/services-rightsidebar.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection