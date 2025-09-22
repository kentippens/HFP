<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidJson implements ValidationRule
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

        json_decode($value);
        
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
        }
    }
}