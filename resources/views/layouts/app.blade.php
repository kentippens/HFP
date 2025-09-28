<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Page Title -->
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Professional cleaning services for homes and offices')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    
    <!-- Canonical Link -->
    @hasSection('canonical_url')
        @php
            $canonicalUrl = trim(view()->yieldContent('canonical_url'));
            // Convert relative URLs to absolute URLs
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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Rubik:wght@400;500;600;700&family=Playfair+Display:wght@700&family=Nunito+Sans:wght@400;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    @if(file_exists(public_path('mix-manifest.json')))
        <!-- Compiled CSS with version hashing -->
        <link rel="stylesheet" href="{{ mix('css/app.min.css') }}">
    @elseif(file_exists(public_path('css/app.min.css')))
        <!-- Compiled CSS - All vendor and custom styles minified -->
        <link rel="stylesheet" href="{{ asset('css/app.min.css') }}?v={{ filemtime(public_path('css/app.min.css')) }}">
    @else
        <!-- Fallback to individual files if compiled version not available -->
        <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/optimized-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('css/odometer-theme-car.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/portfolio-fix.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pool-theme.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pool-services.css') }}">
        <link rel="stylesheet" href="{{ asset('css/phone-cta.css') }}">
        <link rel="stylesheet" href="{{ asset('css/how-it-works.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pagination-fix.css') }}">
        <link rel="stylesheet" href="{{ asset('css/blog-details-fix.css') }}">
        <link rel="stylesheet" href="{{ asset('css/lazy-loading.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layout-fixes.css') }}">
        <link rel="stylesheet" href="{{ asset('css/accessibility.css') }}">
    @endif

    <!-- External Font Awesome - kept separate for CDN benefits -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Page-specific styles (extracted from inline) -->
    @if(file_exists(public_path('mix-manifest.json')))
        <link rel="stylesheet" href="{{ mix('css/pages.min.css') }}">
    @elseif(file_exists(public_path('css/pages.min.css')))
        <link rel="stylesheet" href="{{ asset('css/pages.min.css') }}?v={{ filemtime(public_path('css/pages.min.css')) }}">
    @endif

    @stack('styles')
    
    <!-- JSON-LD Structured Data -->
    @hasSection('json_ld')
@yield('json_ld')
    @endif
    
    <!-- Additional Head Content -->
    @yield('head')

    @if(config('recaptcha.enabled'))
    <!-- Google reCAPTCHA v2 Invisible -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    <!-- Tracking Scripts - Head -->
    @if(isset($trackingScripts['head']))
        @foreach($trackingScripts['head'] as $script)
            <!-- {{ $script->name }} -->
            {{ \App\Helpers\HtmlHelper::adminContent($script->script_content) }}
        @endforeach
    @endif
</head>

<body class="@yield('body_class', '')">
    <!-- Skip to main content link for screen readers -->
    <a href="#main-content" class="skip-link sr-only-focusable">Skip to main content</a>

    <!-- Tracking Scripts - Body Start -->
    @if(isset($trackingScripts['body_start']))
        @foreach($trackingScripts['body_start'] as $script)
            <!-- {{ $script->name }} -->
            {{ \App\Helpers\HtmlHelper::adminContent($script->script_content) }}
        @endforeach
    @endif
    
    <!-- ScrollTop Button -->
    <a href="#" class="scrolltop-btn"><span>@icon("flaticon-arrow")</span></a>

    <!-- Header -->
    @include('components.header')

    <!-- Main Content -->
    <main id="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Javascript Files -->
    @if(file_exists(public_path('mix-manifest.json')))
        <!-- Compiled JavaScript with version hashing -->
        <script src="{{ mix('js/app.min.js') }}"></script>
    @elseif(file_exists(public_path('js/app.min.js')))
        <!-- Compiled JavaScript - All vendor and custom scripts minified -->
        <script src="{{ asset('js/app.min.js') }}?v={{ filemtime(public_path('js/app.min.js')) }}"></script>
    @else
        <!-- Fallback to individual files if compiled version not available -->
        <script src="{{ asset('js/vendor/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/vendor/slick.min.js') }}"></script>
        <script src="{{ asset('js/vendor/easing.min.js') }}"></script>
        <script src="{{ asset('js/vendor/wow.min.js') }}"></script>
        <script src="{{ asset('js/vendor/before-after.js') }}"></script>
        <script src="{{ asset('js/vendor/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('js/vendor/odometer.min.js') }}"></script>
        <script src="{{ asset('js/vendor/isotope.pkgd.js') }}"></script>
        <script src="{{ asset('js/vendor/piechart.js') }}"></script>
        <script src="{{ asset('js/vendor/appear.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/form-validation.js') }}"></script>
        <script src="{{ asset('js/lazy-loading.js') }}"></script>
        <script src="{{ asset('js/inline-replacements.js') }}"></script>
        <script src="{{ asset('js/accessibility.js') }}"></script>
    @endif

    @stack('scripts')
    
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