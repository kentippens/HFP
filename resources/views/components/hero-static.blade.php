<!-- Static Hero Section -->
<section class="hero-static-section" style="background-image: url('{{ asset('images/slider/home2/hero-image-hp.jpg') }}');">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Texas #1 Pool Resurfacing & Conversion Company</h1>
            <p class="hero-description">Transform your pool with Texas' premier fiberglass resurfacing experts. From complete pool conversions to expert repairs and stunning remodels, we deliver lasting quality with our advanced fiberglass technology. Serving all of Texas with <strong style="color: #ffc107; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">25+ year warranties</strong> and unmatched craftsmanship.</p>
            <a href="/pool-repair-quote" class="btn btn-plus btn-plus-primary btn-plus-round">
                Let's Transform Your Pool
            </a>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="hero-star hero-star-left">
        <img src="{{ asset('images/slider/home2/slider-star1.png') }}" alt="decoration">
    </div>
    <div class="hero-star hero-star-right">
        <img src="{{ asset('images/slider/home2/slider-star1.png') }}" alt="decoration">
    </div>
    
</section>
<!-- Static Hero Section End -->

<!-- Appointment Form Section -->
<div class="hero-appointment-wrapper">
    <div class="container">
        <div class="appoinment-form" data-background="{{ asset('images/home2/form-bg.jpg') }}">
            <div class="appoinment-title">
                <h4>👉 Free Online Quote 👈</h4>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('contact.store') }}" method="POST" id="hero-contact-form">
                @csrf
                <input type="hidden" name="type" value="appointment">
                <div class="name-field-wrapper" style="position: relative;">
                    <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required 
                           class="{{ $errors->has('name') ? 'error' : '' }}">
                    <style>
                        .name-field-wrapper::after {
                            content: "Mr. Mrs. Ms.";
                            position: absolute;
                            right: 15px;
                            top: 50%;
                            transform: translateY(-50%);
                            font-style: italic;
                            color: #999;
                            pointer-events: none;
                            font-size: 14px;
                        }
                        .name-field-wrapper input[name="name"] {
                            padding-right: 120px;
                        }
                        .appoinment-form input.error,
                        .appoinment-form select.error,
                        .appoinment-form textarea.error {
                            border-color: #dc3545 !important;
                            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
                        }
                    </style>
                </div>
                <input type="tel" name="phone" placeholder="Phone Number*" value="{{ old('phone') }}" required
                       class="{{ $errors->has('phone') ? 'error' : '' }}" maxlength="20" autocomplete="tel">
                <input type="email" name="address" placeholder="Email Address" value="{{ old('address') }}"
                       class="{{ $errors->has('address') ? 'error' : '' }}">
                <div class="select-field">
                    <select name="service" required class="{{ $errors->has('service') ? 'error' : '' }}">
                        <option value="request-callback" {{ old('service') == 'request-callback' || old('service') === null ? 'selected' : '' }}>Request A Callback</option>
                        <option value="pool-resurfacing-conversion" {{ old('service') == 'pool-resurfacing-conversion' ? 'selected' : '' }}>Pool Resurfacing & Conversion</option>
                        <option value="pool-repair" {{ old('service') == 'pool-repair' ? 'selected' : '' }}>Pool Repair</option>
                        <option value="pool-remodeling" {{ old('service') == 'pool-remodeling' ? 'selected' : '' }}>Pool Remodeling</option>
                    </select>
                </div>
                <textarea name="message" placeholder="Notes for our team..." rows="8"
                          class="{{ $errors->has('message') ? 'error' : '' }}">{{ old('message') }}</textarea>

                @include('components.recaptcha-button', [
                    'formId' => 'hero-contact-form',
                    'buttonText' => 'Get A Quote',
                    'buttonClass' => 'bixol-primary-btn',
                    'buttonIcon' => 'fa-paper-plane'
                ])
            </form>
        </div>
    </div>
</div>
<!-- Appointment Form Section End -->