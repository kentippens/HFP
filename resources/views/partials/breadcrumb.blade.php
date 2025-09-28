@props([
    'title',
    'subtitle' => null,
    'backgroundImage' => asset('images/home1/hero-image-v.jpg'),
    'breadcrumbs' => []
])

<div class="bixol-breadcrumb" data-background="{{ $backgroundImage }}">
    <span class="breadcrumb-object">
        <img src="{{ asset('images/home1/slider-object.png') }}" alt="">
    </span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>{{ $title }}</h1>
            @if($subtitle)
                <p>{{ $subtitle }}</p>
            @endif
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    @foreach($breadcrumbs as $crumb)
                        @if(isset($crumb['url']))
                            <li class="breadcrumb-item">
                                <a href="{{ $crumb['url'] }}">{{ $crumb['title'] }}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $crumb['title'] ?? $title }}
                            </li>
                        @endif
                    @endforeach
                    @if(empty($breadcrumbs))
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $title }}
                        </li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>
</div>