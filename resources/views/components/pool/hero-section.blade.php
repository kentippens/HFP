@props([
    'title',
    'subtitle' => null,
    'description' => null,
    'backgroundImage' => null,
    'ctaText' => 'Get Free Quote',
    'ctaUrl' => '#contact-form'
])

<section class="pool-hero-section" @if($backgroundImage) style="background-image: url('{{ $backgroundImage }}')" @endif>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero-content">
                    <h1 class="hero-title">{{ $title }}</h1>

                    @if($subtitle)
                        <h2 class="hero-subtitle">{{ $subtitle }}</h2>
                    @endif

                    @if($description)
                        <p class="hero-description">{{ $description }}</p>
                    @endif

                    <div class="hero-cta">
                        <a href="{{ $ctaUrl }}" class="btn btn-primary btn-lg">
                            {{ $ctaText }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>