@extends('layouts.app')

@section('title', $silo->meta_title ?? $silo->name)
@section('meta_description', $silo->meta_description ?? $silo->description)
@section('meta_robots', $silo->meta_robots ?? 'index, follow')

@if($silo->canonical_url)
    @section('canonical_url', $silo->canonical_url)
@endif

@section('json_ld')
{!! $silo->all_schema !!}
@endsection

@section('content')
<!-- Page Banner Start -->
<section class="page-banner" data-background="{{ asset('images/page-banner-bg.jpg') }}">
    <div class="container">
        <div class="page-banner-content">
            <h1>{{ $silo->name }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    @foreach($silo->breadcrumbs as $crumb)
                        @if(!$loop->last)
                            <li class="breadcrumb-item"><a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a></li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ $crumb['name'] }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
</section>
<!-- Page Banner End -->

<!-- Silo Detail Start -->
<section class="silo-detail-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if($silo->featured_image_url)
                    <div class="silo-featured-image mb-4">
                        <img src="{{ $silo->featured_image_url }}" alt="{{ $silo->name }}" class="img-fluid">
                    </div>
                @endif

                @if($silo->overview)
                    <div class="silo-overview mb-4">
                        <h2>Overview</h2>
                        <p>{{ $silo->overview }}</p>
                    </div>
                @endif

                @if($silo->content)
                    <div class="silo-content">
                        {!! \App\Helpers\HtmlHelper::safe($silo->content, 'admin') !!}
                    </div>
                @endif

                @if($silo->features)
                    <div class="silo-features mt-5">
                        <h3>Key Features</h3>
                        <div class="row">
                            @foreach($silo->features as $feature)
                                <div class="col-md-6 mb-3">
                                    <div class="feature-item">
                                        <h4><i class="fas fa-check-circle text-primary"></i> {{ $feature['title'] ?? '' }}</h4>
                                        @if(isset($feature['description']))
                                            <p>{{ $feature['description'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($silo->benefits)
                    <div class="silo-benefits mt-5">
                        <h3>Benefits</h3>
                        <div class="row">
                            @foreach($silo->benefits as $benefit)
                                <div class="col-md-6 mb-3">
                                    <div class="benefit-item">
                                        <h4><i class="fas fa-star text-warning"></i> {{ $benefit['title'] ?? '' }}</h4>
                                        @if(isset($benefit['description']))
                                            <p>{{ $benefit['description'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Contact Form Sidebar -->
                <div class="sidebar-widget contact-widget">
                    <h3>Get a Free Quote</h3>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="silo_inquiry">
                        <input type="hidden" name="silo" value="{{ $silo->name }}">
                        
                        <div class="form-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email Address">
                        </div>
                        
                        <div class="form-group mb-3">
                            <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your project"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block w-100">Get Free Quote</button>
                    </form>
                </div>

                @if($silo->parent && $silo->parent->activeChildren->count() > 1)
                    <!-- Related Services -->
                    <div class="sidebar-widget related-services mt-4">
                        <h3>Related Services</h3>
                        <ul class="list-unstyled">
                            @foreach($silo->parent->activeChildren as $sibling)
                                @if($sibling->id !== $silo->id)
                                    <li>
                                        <a href="{{ $sibling->url }}">
                                            <i class="fas fa-angle-right"></i> {{ $sibling->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Silo Detail End -->

<!-- CTA Section -->
<section class="cta-section bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3>Ready to Transform Your Pool?</h3>
                <p>Contact our experts today for professional {{ strtolower($silo->name) }} services.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="tel:972-789-2983" class="btn btn-light btn-lg">
                    <i class="fas fa-phone"></i> Call 972-789-2983
                </a>
            </div>
        </div>
    </div>
</section>
@endsection