<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    /**
     * Verify reCAPTCHA response
     *
     * @param string|null $response
     * @param string|null $ip
     * @return bool
     */
    public function verify(?string $response, ?string $ip = null): bool
    {
        // If reCAPTCHA is disabled, always return true
        if (!config('recaptcha.enabled')) {
            return true;
        }

        // Skip validation for whitelisted IPs (local development)
        if ($ip && in_array($ip, config('recaptcha.skip_ips', []))) {
            return true;
        }

        // No response provided
        if (empty($response)) {
            Log::warning('reCAPTCHA verification failed: No response provided', [
                'ip' => $ip
            ]);
            return false;
        }

        try {
            // Make API request to Google
            $verifyResponse = Http::timeout(config('recaptcha.timeout', 5))
                ->asForm()
                ->post(config('recaptcha.verify_url'), [
                    'secret' => config('recaptcha.secret_key'),
                    'response' => $response,
                    'remoteip' => $ip
                ]);

            if (!$verifyResponse->successful()) {
                Log::error('reCAPTCHA API request failed', [
                    'status' => $verifyResponse->status(),
                    'ip' => $ip
                ]);
                return false;
            }

            $result = $verifyResponse->json();

            // Log the verification attempt
            Log::info('reCAPTCHA verification attempt', [
                'success' => $result['success'] ?? false,
                'hostname' => $result['hostname'] ?? null,
                'error_codes' => $result['error-codes'] ?? [],
                'ip' => $ip
            ]);

            // Check if verification was successful
            if (!isset($result['success']) || !$result['success']) {
                Log::warning('reCAPTCHA verification failed', [
                    'error_codes' => $result['error-codes'] ?? [],
                    'ip' => $ip
                ]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification exception', [
                'error' => $e->getMessage(),
                'ip' => $ip
            ]);

            // In case of exception, we might want to allow the submission
            // to avoid losing potential customers due to technical issues
            // You can change this to false if you prefer to block on errors
            return config('app.env') === 'production' ? false : true;
        }
    }

    /**
     * Get error message for failed verification
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return 'Please complete the reCAPTCHA verification.';
    }
}