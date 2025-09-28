@props([
    'title' => 'Get Your Free Quote',
    'subtitle' => 'Transform Your Pool Today',
    'formId' => 'sidebar-contact-form',
    'source' => 'sidebar',
    'phoneNumber' => config('company.phone', '469-956-0505')
])

<div class="sidebar-contact-form">
    <h3 class="widget-title">{{ $title }}</h3>
    <p class="widget-subtitle">{{ $subtitle }}</p>

    <form action="{{ route('contact.store') }}" method="POST" id="{{ $formId }}">
        @csrf
        <input type="hidden" name="source" value="{{ $source }}">
        <input type="hidden" name="type" value="quote">

        <div class="form-group">
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Your Name *"
                   required
                   value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <input type="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Your Email *"
                   required
                   value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <input type="tel"
                   name="phone"
                   class="form-control @error('phone') is-invalid @enderror"
                   placeholder="Your Phone *"
                   required
                   value="{{ old('phone') }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <textarea name="message"
                      class="form-control @error('message') is-invalid @enderror"
                      placeholder="Tell us about your project..."
                      rows="4">{{ old('message') }}</textarea>
            @error('message')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Honeypot field for spam protection --}}
        <div style="position: absolute; left: -9999px;">
            <label for="website">Website</label>
            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="form-group">
            @include('components.recaptcha-button', [
                'buttonText' => 'Get Free Quote',
                'buttonClass' => 'btn btn-primary btn-block'
            ])
        </div>
    </form>

    <div class="phone-cta">
        <span>Or Call Now:</span>
        <a href="tel:{{ $phoneNumber }}" class="phone-link">
            <i class="fas fa-phone"></i> {{ $phoneNumber }}
        </a>
    </div>
</div>