@props([
    'title' => 'Ready to Get Started?',
    'description' => 'Contact us today for a free consultation',
    'phone' => config('company.phone', '469-956-0505'),
    'ctaText' => 'Get Free Quote',
    'ctaUrl' => '#contact-form',
    'backgroundClass' => 'bg-primary'
])

<section class="cta-section {{ $backgroundClass }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="cta-content">
                    <h2 class="cta-title">{{ $title }}</h2>
                    <p class="cta-description">{{ $description }}</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="cta-buttons">
                    <a href="{{ $ctaUrl }}" class="btn btn-light btn-lg">
                        {{ $ctaText }}
                    </a>
                    <div class="or-divider">OR</div>
                    <a href="tel:{{ $phone }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone"></i> {{ $phone }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>