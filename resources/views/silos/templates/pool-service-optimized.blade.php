@extends('layouts.app')

@section('title', $silo->meta_title ?? 'Pool Services')
@section('meta_description', $silo->meta_description ?? '')
@section('meta_robots', $silo->meta_robots ?? 'index, follow')

@if($silo && $silo->canonical_url)
    @section('canonical_url', $silo->canonical_url)
@endif

@section('json_ld')
{!! $silo->json_ld ?? '' !!}
@endsection

@section('content')
    {{-- Breadcrumb --}}
    @include('partials.breadcrumb', [
        'title' => $silo->h1_heading ?? $silo->name,
        'backgroundImage' => asset('images/home1/hero-image-v.jpg')
    ])

    {{-- Main Content Area --}}
    <section class="pool-service-content pt-100 pb-100">
        <div class="container">
            <div class="row">
                {{-- Main Content Column --}}
                <div class="col-lg-8">
                    @include('silos.partials.main-content', ['silo' => $silo])
                </div>

                {{-- Sidebar Column --}}
                <div class="col-lg-4">
                    <div class="service-sidebar sticky-sidebar">
                        {{-- Contact Form Widget --}}
                        <div class="sidebar-widget">
                            <x-pool.sidebar-contact-form
                                title="Get Your Free Quote"
                                subtitle="Transform Your Pool Today"
                                source="pool_service_sidebar"
                            />
                        </div>

                        {{-- Limited Offer Widget --}}
                        <div class="sidebar-widget">
                            <x-pool.limited-offer
                                discount="$2,500 OFF"
                                :validUntil="now()->addDays(30)->format('F d, Y')"
                            />
                        </div>

                        {{-- Trust Badges Widget --}}
                        <div class="sidebar-widget">
                            <x-pool.trust-badges />
                        </div>

                        {{-- Service Areas Widget --}}
                        @includeWhen(
                            isset($serviceAreas),
                            'silos.partials.service-areas',
                            ['areas' => $serviceAreas ?? []]
                        )
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action Section --}}
    @include('silos.partials.cta-section', [
        'title' => 'Ready to Transform Your Pool?',
        'description' => 'Get your free quote today and save thousands!',
        'phone' => config('company.phone')
    ])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pool-services-optimized.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/sticky-sidebar.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new StickySidebar('.sticky-sidebar', {
                topSpacing: 20,
                bottomSpacing: 20,
                containerSelector: '.pool-service-content',
                innerWrapperSelector: '.service-sidebar'
            });
        });
    </script>
@endpush