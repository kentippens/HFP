<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidJsonLd implements ValidationRule
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

        // Handle both string and array inputs
        if (is_array($value)) {
            // Value is already an array (probably from Eloquent casting)
            $data = $value;
        } else {
            // Value is a string, need to decode JSON
            $data = json_decode($value, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $error = match(json_last_error()) {
                    JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
                    JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
                    JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
                    JSON_ERROR_SYNTAX => 'Syntax error in JSON',
                    JSON_ERROR_UTF8 => 'Malformed UTF-8 characters in JSON',
                    default => 'Invalid JSON format'
                };
                
                $fail("The {$attribute} field contains invalid JSON: {$error}");
                return;
            }
        }

        // Check if it's an array of multiple schemas
        if (isset($data[0]) && is_array($data[0])) {
            // Validate each schema in the array
            foreach ($data as $index => $schema) {
                if (!is_array($schema)) {
                    $fail("Item {$index} in {$attribute} must be a valid JSON-LD object");
                    return;
                }
                if (!isset($schema['@context'])) {
                    $fail("Item {$index} in {$attribute} must include '@context' property");
                    return;
                }
                if (!isset($schema['@type'])) {
                    $fail("Item {$index} in {$attribute} must include '@type' property");
                    return;
                }
            }
        } else {
            // Single schema validation
            if (!isset($data['@context'])) {
                $fail("The {$attribute} must include '@context' property for valid JSON-LD");
                return;
            }

            if (!isset($data['@type'])) {
                $fail("The {$attribute} must include '@type' property for valid JSON-LD");
                return;
            }

            // Validate @context format
            $context = $data['@context'];
            if (!is_string($context) && !is_array($context)) {
                $fail("The '@context' property must be a string or array");
                return;
            }

            // If it's a string, check if it's a valid URL
            if (is_string($context) && !filter_var($context, FILTER_VALIDATE_URL)) {
                $fail("The '@context' must be a valid URL (e.g., 'https://schema.org')");
            }
        }
    }
}