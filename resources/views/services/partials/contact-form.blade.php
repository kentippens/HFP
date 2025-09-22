<!-- Get In Touch -->
<section class="bixol-gta-area" data-background="{{ asset('images/home1/contactform-background.jpg') }}" style="background-image: url('{{ asset('images/home1/contactform-background.jpg') }}');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 offset-lg-6">
                <div class="bixol-gt-right">
                    <h4 style="color: #22356f;">Get A Quote</h4>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(isset($errors) && $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('contact.store') }}" method="POST" id="partial-contact-form">
                        @csrf
                        <input type="hidden" name="type" value="appointment">
                        <input type="hidden" name="source" value="service_{{ $service->slug }}">
                        
                        @if(session('error'))
                            <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if(isset($errors) && $errors->any())
                            <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="name-field-wrapper" style="position: relative;">
                                    <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required 
                                           class="{{ isset($errors) && $errors->has('name') ? 'error' : '' }}" style="width: 100%; box-sizing: border-box;">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="phone-number">
                                    <input type="tel" name="phone" placeholder="Phone Number*" value="{{ old('phone') }}" required
                                           class="{{ isset($errors) && $errors->has('phone') ? 'error' : '' }}" maxlength="12" autocomplete="tel" style="width: 100%; box-sizing: border-box;">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mail-field">
                                    <input type="email" name="address" placeholder="Email Address" value="{{ old('address') }}"
                                           class="{{ isset($errors) && $errors->has('address') ? 'error' : '' }}" style="width: 100%; box-sizing: border-box;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="select-field">
                                    <select name="service" required class="{{ isset($errors) && $errors->has('service') ? 'error' : '' }}" style="width: 100%; box-sizing: border-box;">
                                        <option value="request-callback" {{ old('service') == 'request-callback' || old('service') === null ? 'selected' : '' }}>Request A Callback</option>
                                        <option value="pool-resurfacing-conversion" {{ old('service') == 'pool-resurfacing-conversion' ? 'selected' : '' }}>Pool Resurfacing & Conversion</option>
                                        <option value="pool-repair" {{ old('service') == 'pool-repair' ? 'selected' : '' }}>Pool Repair</option>
                                        <option value="pool-remodeling" {{ old('service') == 'pool-remodeling' ? 'selected' : '' }}>Pool Remodeling</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="message-field">
                                    <textarea name="message" placeholder="Notes for our team..." rows="8"
                                              class="{{ isset($errors) && $errors->has('message') ? 'error' : '' }}" style="width: 100%; box-sizing: border-box;">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="submit-btn">
                            <button type="submit" class="bixol-primary-btn submit-btn">@icon("fas fa-check-circle")Get A Quote</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Get In Touch End -->

<style>
    /* Fix oversized background image and height */
    .bixol-gta-area {
        background-size: cover !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
        padding: 60px 0 !important;
        min-height: auto !important;
        height: auto !important;
        position: relative !important;
        overflow: hidden !important;
    }
    
    /* Ensure proper section boundaries */
    section.bixol-gta-area {
        max-height: auto !important;
        margin-bottom: 0 !important;
    }
    
    /* Contain the form within section boundaries */
    .bixol-gta-area .container {
        position: relative !important;
        z-index: 1 !important;
    }
    
    /* Ensure form doesn't overflow */
    .bixol-gta-area .bixol-gt-right {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
        position: relative !important;
    }
    
    /* Remove any absolute positioning that might cause overflow */
    .bixol-gta-area .bixol-gt-left {
        display: none !important;
    }
    
    /* Fix row alignment to prevent overflow */
    .bixol-gta-area .row {
        margin: 0 !important;
    }
    
    /* Ensure column doesn't push content out */
    .bixol-gta-area .col-lg-6.offset-lg-6 {
        margin-left: auto !important;
        margin-right: 0 !important;
        max-width: 50% !important;
    }
    
    @media (max-width: 991.98px) {
        .bixol-gta-area .col-lg-6.offset-lg-6 {
            margin-left: 0 !important;
            max-width: 100% !important;
        }
    }
    
    /* Override responsive breakpoints that cause oversizing */
    @media (max-width: 1930px) {
        .bixol-gta-area {
            background-size: cover !important;
        }
    }
    @media (max-width: 1800px) {
        .bixol-gta-area {
            background-size: cover !important;
        }
    }
    @media (max-width: 1600px) {
        .bixol-gta-area {
            background-size: cover !important;
        }
    }
    @media (max-width: 1400px) {
        .bixol-gta-area {
            background-size: cover !important;
            background-position: center center !important;
        }
    }
    
    /* Contact page form styling for service details */
    .bixol-gt-right {
        padding: 20px;
        overflow: visible;
    }
    .bixol-gt-right form {
        width: 100%;
        margin-top: 20px;
        overflow: visible;
    }
    .bixol-gt-right .row {
        margin-left: 0;
        margin-right: 0;
    }
    .bixol-gt-right .row > * {
        padding-left: 5px;
        padding-right: 5px;
    }
    .bixol-gt-right form input,
    .bixol-gt-right form select,
    .bixol-gt-right form textarea {
        width: 100%;
        border: 0;
        padding: 12px 20px;
        background-color: #22356f !important;
        color: #ffffff !important;
        margin-bottom: 20px;
        border-radius: 3px;
        font-family: "Poppins", sans-serif;
        font-size: 14px;
        box-shadow: 0px 0px 10px 0px rgba(12, 12, 12, 0.1);
    }
    .bixol-gt-right form input::placeholder,
    .bixol-gt-right form select::placeholder,
    .bixol-gt-right form textarea::placeholder {
        color: #b8c5d1 !important;
    }
    .bixol-gt-right form .submit-btn {
        margin-top: 0;
    }
    .bixol-gt-right form .submit-btn button {
        width: 100%;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #22356f !important;
        border: 0;
        border-radius: 3px;
        color: #ffffff;
        font-family: "Poppins", sans-serif;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s ease-in;
        text-align: center;
    }
    .bixol-gt-right form .submit-btn button i {
        margin-right: 10px;
        display: inline-flex;
        align-items: center;
    }
    .bixol-gt-right form .submit-btn button:hover {
        background-color: #28a745 !important;
    }
    
    /* Name field styling */
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
    
    /* Error styling */
    .bixol-gt-right input.error,
    .bixol-gt-right select.error,
    .bixol-gt-right textarea.error,
    .bixol-gta-area input.error,
    .bixol-gta-area select.error,
    .bixol-gta-area textarea.error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
    
    /* Override existing service form styling */
    .bixol-gta-area form input,
    .bixol-gta-area form select,
    .bixol-gta-area form textarea {
        width: 100%;
        border: 0;
        padding: 12px 20px;
        background-color: #22356f !important;
        color: #ffffff !important;
        margin-bottom: 20px;
        border-radius: 3px;
        font-family: "Poppins", sans-serif;
        font-size: 14px;
        box-shadow: 0px 0px 10px 0px rgba(12, 12, 12, 0.1);
    }
    .bixol-gta-area .submit-btn button {
        width: 100%;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #22356f !important;
        border: 0;
        border-radius: 3px;
        color: #ffffff;
        font-family: "Poppins", sans-serif;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s ease-in;
        text-align: center;
    }
    .bixol-gta-area .submit-btn button i {
        margin-right: 10px;
        display: inline-flex;
        align-items: center;
    }
    .bixol-gta-area .submit-btn button:hover {
        background-color: #28a745 !important;
    }
    
    /* Responsive fixes */
    @media (max-width: 767.98px) {
        .bixol-gt-right {
            padding: 15px;
        }
        .bixol-gt-right .row > * {
            padding-left: 0;
            padding-right: 0;
            margin-bottom: 10px;
        }
        .name-field-wrapper input[name="name"] {
            padding-right: 20px !important;
        }
        .name-field-wrapper::after {
            display: none;
        }
    }
    
    /* Ensure form container doesn't cut off content */
    .bixol-gta-area {
        overflow: visible;
    }
    .bixol-gta-area .container {
        overflow: visible;
    }
    
    /* Set form field background to #22356f */
    .bixol-gt-right input[type="text"],
    .bixol-gt-right input[type="tel"],
    .bixol-gt-right input[type="email"],
    .bixol-gt-right select,
    .bixol-gt-right textarea,
    .bixol-gta-area input[type="text"],
    .bixol-gta-area input[type="tel"],
    .bixol-gta-area input[type="email"],
    .bixol-gta-area select,
    .bixol-gta-area textarea {
        background: #22356f !important;
        background-color: #22356f !important;
        color: #ffffff !important;
    }
    
    /* Specific targeting for email and select fields */
    .mail-field input,
    .select-field select {
        background: #22356f !important;
        background-color: #22356f !important;
        color: #ffffff !important;
    }
    
    /* Update placeholder text color for better visibility */
    .bixol-gt-right form input::placeholder,
    .bixol-gt-right form select::placeholder,
    .bixol-gt-right form textarea::placeholder,
    .bixol-gta-area form input::placeholder,
    .bixol-gta-area form select::placeholder,
    .bixol-gta-area form textarea::placeholder {
        color: #b8c5d1 !important;
    }
</style>