<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    
    <!-- Page Title -->
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Professional cleaning services for homes and offices')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    
    <!-- Canonical Link -->
    @hasSection('canonical_url')
        @php
            $canonicalUrl = trim(view()->yieldContent('canonical_url'));
            if (!empty($canonicalUrl) && !filter_var($canonicalUrl, FILTER_VALIDATE_URL)) {
                $canonicalUrl = url($canonicalUrl);
            }
        @endphp
        @if($canonicalUrl)
            <link rel="canonical" href="{{ $canonicalUrl }}">
        @endif
    @endif
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', config('app.name', 'Laravel'))">
    <meta property="og:description" content="@yield('og_description', 'Professional cleaning services')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Critical CSS (inline for performance) -->
    <style>
        /* Critical above-the-fold CSS here */
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; }
        .loading { opacity: 0; transition: opacity 0.3s; }
        .loaded { opacity: 1; }
    </style>

    <!-- Preload critical assets -->
    @if(config('app.env') === 'production')
        <link rel="preload" href="{{ mix('css/app.min.css') }}" as="style">
        <link rel="preload" href="{{ mix('js/app.min.js') }}" as="script">
    @endif

    <!-- CSS Files (consolidated in production) -->
    @if(config('app.env') === 'production')
        <link rel="stylesheet" href="{{ mix('css/app.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/optimized-icons.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('css/odometer-theme-car.css') }}">
        @stack('styles')
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/portfolio-fix.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pool-theme.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pool-services.css') }}">
        <link rel="stylesheet" href="{{ asset('css/phone-cta.css') }}">
        <link rel="stylesheet" href="{{ asset('css/mobile-menu-new.css') }}">
        <link rel="stylesheet" href="{{ asset('css/how-it-works.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pagination-fix.css') }}">
        <link rel="stylesheet" href="{{ asset('css/blog-details-fix.css') }}">
    @endif
    
    <!-- JSON-LD Structured Data -->
    @hasSection('json_ld')
        <script type="application/ld+json">
@yield('json_ld')
        </script>
    @endif
    
    <!-- Additional Head Content -->
    @yield('head')
    
    <!-- Tracking Scripts - Head -->
    @if(isset($trackingScripts['head']))
        @foreach($trackingScripts['head'] as $script)
            <!-- {{ $script->name }} -->
            {{ \App\Helpers\HtmlHelper::adminContent($script->script_content) }}
        @endforeach
    @endif
</head>

<body class="@yield('body_class', '') loading">
    <!-- Skip to content for accessibility -->
    <a href="#main-content" class="sr-only sr-only-focusable">Skip to main content</a>
    
    <!-- Tracking Scripts - Body Start -->
    @if(isset($trackingScripts['body_start']))
        @foreach($trackingScripts['body_start'] as $script)
            <!-- {{ $script->name }} -->
            {{ \App\Helpers\HtmlHelper::adminContent($script->script_content) }}
        @endforeach
    @endif
    
    <!-- ScrollTop Button with aria-label -->
    <a href="#" class="scrolltop-btn" aria-label="Scroll to top">
        <span>@icon("flaticon-arrow")</span>
    </a>

    <!-- Header -->
    @include('components.header')

    <!-- Main Content with landmark -->
    <main id="main-content" role="main">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- JavaScript Files (consolidated and deferred in production) -->
    @if(config('app.env') === 'production')
        <script src="{{ mix('js/app.min.js') }}" defer></script>
    @else
        <script src="{{ asset('js/vendor/jquery-3.6.0.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/slick.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/easing.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/wow.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/before-after.js') }}" defer></script>
        <script src="{{ asset('js/vendor/jquery.magnific-popup.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/odometer.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/isotope.pkgd.js') }}" defer></script>
        <script src="{{ asset('js/vendor/piechart.js') }}" defer></script>
        <script src="{{ asset('js/vendor/appear.js') }}" defer></script>
        @stack('scripts')
        <script src="{{ asset('js/main.js') }}" defer></script>
        <script src="{{ asset('js/mobile-menu-new.js') }}" defer></script>
        <script src="{{ asset('js/form-validation.js') }}" defer></script>
    @endif
    
    <!-- Initialize loading state -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.remove('loading');
            document.body.classList.add('loaded');
        });
    </script>
    
    <!-- Additional Scripts -->
    @yield('scripts')
    
    <!-- Tracking Scripts - Body End -->
    @if(isset($trackingScripts['body_end']))
        @foreach($trackingScripts['body_end'] as $script)
            <!-- {{ $script->name }} -->
            {{ \App\Helpers\HtmlHelper::adminContent($script->script_content) }}
        @endforeach
    @endif
</body>
</html>