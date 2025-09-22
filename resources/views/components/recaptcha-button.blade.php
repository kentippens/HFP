@if(config('recaptcha.enabled'))
    @php
        $formId = $formId ?? 'contact-form-' . uniqid();
        $buttonText = $buttonText ?? 'Get A Quote';
        $buttonClass = $buttonClass ?? 'bixol-primary-btn';
        $buttonIcon = $buttonIcon ?? 'fa-paper-plane';
    @endphp

    <button type="button"
            class="{{ $buttonClass }} g-recaptcha"
            data-sitekey="{{ config('recaptcha.site_key') }}"
            data-callback="onSubmit{{ str_replace('-', '', $formId) }}"
            data-action="submit"
            id="submit-{{ $formId }}">
        {{ $buttonText }}
        @if($buttonIcon)
            <span>@icon($buttonIcon)</span>
        @endif
    </button>

    <script>
        function onSubmit{{ str_replace('-', '', $formId) }}(token) {
            // Add the token to the form
            var form = document.getElementById('{{ $formId }}');
            if (form) {
                // Check if hidden input already exists
                var existingInput = form.querySelector('input[name="g-recaptcha-response"]');
                if (existingInput) {
                    existingInput.value = token;
                } else {
                    // Create hidden input for token
                    var hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'g-recaptcha-response';
                    hiddenInput.value = token;
                    form.appendChild(hiddenInput);
                }

                // Submit the form
                form.submit();
            }
        }
    </script>
@else
    <!-- reCAPTCHA disabled - regular submit button -->
    <button type="submit" class="{{ $buttonClass ?? 'bixol-primary-btn' }}">
        {{ $buttonText ?? 'Get A Quote' }}
        @if($buttonIcon ?? 'fa-paper-plane')
            <span>@icon($buttonIcon ?? 'fa-paper-plane')</span>
        @endif
    </button>
@endif