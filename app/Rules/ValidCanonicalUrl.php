<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCanonicalUrl implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        // Trim whitespace
        $url = trim($value);

        // Check if it's a valid absolute URL
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            // Must be HTTP or HTTPS
            if (!preg_match('/^https?:\/\//i', $url)) {
                $fail("The {$attribute} must be an HTTP or HTTPS URL when using absolute URLs.");
                return;
            }
            return;
        }

        // Check if it's a valid relative URL (must start with /)
        if (!str_starts_with($url, '/')) {
            $fail("The {$attribute} must start with / when using relative URLs (e.g., /, /about, /services).");
            return;
        }

        // Check for valid characters in relative URL
        if (!preg_match('/^\/[\w\-\.\/]*$/i', $url)) {
            $fail("The {$attribute} contains invalid characters. Use only letters, numbers, hyphens, dots, and forward slashes.");
            return;
        }

        // Check for common issues
        if (str_contains($url, '//')) {
            $fail("The {$attribute} cannot contain double slashes (//).");
            return;
        }

        if (str_ends_with($url, '/') && $url !== '/') {
            $fail("The {$attribute} should not end with a trailing slash (except for the root path /).");
            return;
        }

        // Check length (reasonable URL length)
        if (strlen($url) > 255) {
            $fail("The {$attribute} is too long. Maximum length is 255 characters.");
        }
    }
}