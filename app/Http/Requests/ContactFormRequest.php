<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $formType = $this->getFormType();

        return match ($formType) {
            'newsletter' => $this->getNewsletterRules(),
            'investor' => $this->getInvestorRules(),
            'homepage' => $this->getHomepageRules(),
            'contact' => $this->getContactPageRules(),
            default => $this->getDefaultRules(),
        };
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Name must be at least 2 characters.',
            'name.regex' => 'Name can only contain letters, spaces, hyphens, and apostrophes.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'phone.min' => 'Phone number must be at least 10 digits.',
            'service.required' => 'Please select a service.',
            'service.in' => 'Please select a valid service option.',
            'message.required' => 'Please enter a message.',
            'message.min' => 'Message must be at least 10 characters.',
        ];
    }

    /**
     * Determine the form type based on request data.
     */
    private function getFormType(): string
    {
        if ($this->has('type')) {
            if ($this->input('type') === 'newsletter') {
                return 'newsletter';
            }
            if ($this->input('type') === 'investor_inquiry') {
                return 'investor';
            }
            if ($this->input('type') === 'appointment') {
                return 'homepage';
            }
        }

        if ($this->has('investment_interest')) {
            return 'investor';
        }

        if ($this->has('fname') || $this->has('pnumber')) {
            return 'service';
        }

        return 'contact';
    }

    /**
     * Get validation rules for newsletter form.
     */
    private function getNewsletterRules(): array
    {
        return [
            'email' => 'required|email:rfc,dns|max:255',
        ];
    }

    /**
     * Get validation rules for investor form.
     */
    private function getInvestorRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => ['required', 'string', 'max:20', 'min:10', $this->phoneValidation()],
            'company' => 'nullable|string|max:255',
            'investment_interest' => 'required|string|in:franchise,partnership,capital_investment,general_inquiry',
            'investment_amount' => 'nullable|string|in:under_50k,50k_100k,100k_250k,250k_500k,over_500k',
            'message' => 'nullable|string|max:2000',
        ];
    }

    /**
     * Get validation rules for homepage form.
     */
    private function getHomepageRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'phone' => ['required', 'string', 'max:20', 'min:10', $this->phoneValidation(true)],
            'address' => ['nullable', 'email:rfc,dns', 'max:255'],
            'service' => $this->getServiceRule(),
            'message' => ['nullable', 'string', 'max:1000', $this->optionalMinLength(10)],
        ];
    }

    /**
     * Get validation rules for contact page form.
     */
    private function getContactPageRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'phone' => ['required', 'string', 'max:20', 'min:10', $this->phoneValidation()],
            'address' => ['nullable', 'email:rfc,dns', 'max:255'],
            'service' => $this->getServiceRule(),
            'message' => ['nullable', 'string', 'max:1000', $this->optionalMinLength(10)],
        ];
    }

    /**
     * Get default validation rules.
     */
    private function getDefaultRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'email' => 'required|email:rfc,dns|max:255',
            'message' => 'required|string|max:1000|min:10',
        ];
    }

    /**
     * Get service validation rule.
     */
    private function getServiceRule(): string
    {
        $validServices = [
            'request-callback',
            'carpet-cleaning',
            'commercial-cleaning',
            'house-cleaning',
            'pool-cleaning',
            'vinyl-fence-installation',
            'gutter-leafguard-installation',
            'christmas-light-installation',
        ];

        return 'required|string|in:' . implode(',', $validServices);
    }

    /**
     * Phone validation closure.
     */
    private function phoneValidation(bool $blockTestNumbers = false): \Closure
    {
        return function ($attribute, $value, $fail) use ($blockTestNumbers) {
            // Remove all non-numeric characters
            $numbersOnly = preg_replace('/[^0-9]/', '', $value);

            // Check minimum digits
            if (strlen($numbersOnly) < 10) {
                $fail('Phone number must be at least 10 digits.');
                return;
            }

            // Check for blocked area codes
            $blockedAreaCodes = ['000', '111'];
            
            if ($blockTestNumbers) {
                $blockedAreaCodes = array_merge($blockedAreaCodes, ['123', '555']);
            }
            
            $areaCode = substr($numbersOnly, 0, 3);
            
            if (in_array($areaCode, $blockedAreaCodes)) {
                $fail("Area code {$areaCode} is not valid. Please enter a valid phone number.");
                return;
            }

            // Check for US format starting with +1
            if (strlen($numbersOnly) >= 4 && substr($numbersOnly, 0, 1) === '1') {
                $usAreaCode = substr($numbersOnly, 1, 3);
                if (in_array($usAreaCode, $blockedAreaCodes)) {
                    $fail("Area code {$usAreaCode} is not valid. Please enter a valid phone number.");
                }
            }
        };
    }

    /**
     * Optional minimum length validation.
     */
    private function optionalMinLength(int $length): \Closure
    {
        return function ($attribute, $value, $fail) use ($length) {
            if (!empty($value) && strlen(trim($value)) < $length) {
                $fail("The {$attribute} must be at least {$length} characters if provided.");
            }
        };
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Log validation failures for monitoring
        \Log::warning('Contact form validation failed', [
            'errors' => $validator->errors()->toArray(),
            'input' => $this->except(['_token', 'password']),
            'ip' => $this->ip(),
            'user_agent' => $this->userAgent(),
        ]);

        parent::failedValidation($validator);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Additional validation logic if needed
            if ($this->hasSpamIndicators()) {
                $validator->errors()->add('spam', 'Your submission has been flagged. Please try again.');
            }
        });
    }

    /**
     * Check for spam indicators.
     */
    private function hasSpamIndicators(): bool
    {
        // Check for honeypot field (if implemented)
        if ($this->has('website') && !empty($this->input('website'))) {
            return true;
        }

        // Check for suspicious patterns in message
        if ($this->has('message')) {
            $message = strtolower($this->input('message'));
            $spamPatterns = [
                'viagra',
                'cialis',
                'casino',
                'lottery',
                'congratulations you won',
                'click here now',
                'act now',
                'limited time offer',
                'make money fast',
            ];

            foreach ($spamPatterns as $pattern) {
                if (str_contains($message, $pattern)) {
                    return true;
                }
            }
        }

        return false;
    }
}