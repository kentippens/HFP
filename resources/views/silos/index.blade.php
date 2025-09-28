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

<!-- Silo Content Start -->
<section class="silo-section">
    <div class="container">
        @if($silo->description)
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <p class="lead">{{ $silo->description }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($children->count() > 0)
            <div class="row">
                @foreach($children as $child)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="service-card">
                            @if($child->featured_image_url)
                                <div class="service-card-image">
                                    <img src="{{ $child->featured_image_url }}" alt="{{ $child->name }}">
                                </div>
                            @endif
                            <div class="service-card-body">
                                <h3>{{ $child->name }}</h3>
                                @if($child->description)
                                    <p>{{ Str::limit($child->description, 150) }}</p>
                                @endif
                                <a href="{{ $child->url }}" class="btn btn-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($silo->content)
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="silo-content">
                        {!! \App\Helpers\HtmlHelper::safe($silo->content, 'admin') !!}
                    </div>
                </div>
            </div>
        @endif

        @if($silo->features || $silo->benefits)
            <div class="row mt-5">
                @if($silo->features)
                    <div class="col-lg-6">
                        <h3>Features</h3>
                        <ul class="feature-list">
                            @foreach($silo->features as $feature)
                                <li>
                                    <h4>{{ $feature['title'] ?? '' }}</h4>
                                    @if(isset($feature['description']))
                                        <p>{{ $feature['description'] }}</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($silo->benefits)
                    <div class="col-lg-6">
                        <h3>Benefits</h3>
                        <ul class="benefit-list">
                            @foreach($silo->benefits as $benefit)
                                <li>
                                    <h4>{{ $benefit['title'] ?? '' }}</h4>
                                    @if(isset($benefit['description']))
                                        <p>{{ $benefit['description'] }}</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>
<!-- Silo Content End -->

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3>Ready to Get Started?</h3>
                <p>Contact us today for a free consultation and quote.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">Get Free Quote</a>
            </div>
        </div>
    </div>
</section>
@endsection