<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class SanitizeInput
{
    /**
     * Fields that should be sanitized as HTML
     */
    protected array $htmlFields = [
        'description',
        'content',
        'body',
        'message',
        'overview',
        'short_description',
        'meta_description',
        'excerpt',
        'summary',
        'details',
        'bio',
        'about',
    ];

    /**
     * Fields that should be stripped of all HTML
     */
    protected array $stripFields = [
        'name',
        'title',
        'email',
        'phone',
        'subject',
        'meta_title',
        'first_name',
        'last_name',
        'username',
        'company',
        'address',
        'city',
        'state',
        'zip',
        'postal_code',
        'country',
    ];

    /**
     * Fields that should never be sanitized (tokens, IDs, etc.)
     */
    protected array $skipFields = [
        'password',
        'password_confirmation',
        '_token',
        '_method',
        'remember_token',
        'api_token',
        'csrf_token',
        'id',
        'uuid',
        'slug',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ?string $config = 'default')
    {
        // Skip sanitization for Filament admin routes
        if ($request->is('admin/*') || $request->is('livewire/*')) {
            return $next($request);
        }

        // Sanitize input data
        $input = $request->all();

        if (!empty($input)) {
            $sanitized = $this->sanitizeArray($input, $config ?? 'default');
            $request->merge($sanitized);
        }

        return $next($request);
    }

    /**
     * Recursively sanitize array values
     */
    protected function sanitizeArray(?array $data, string $config): array
    {
        if ($data === null) {
            return [];
        }

        foreach ($data as $key => $value) {
            if ($value === null) {
                $data[$key] = null;
            } elseif (is_array($value)) {
                $data[$key] = $this->sanitizeArray($value, $config);
            } elseif (is_string($value)) {
                $data[$key] = $this->sanitizeField($key, $value, $config);
            }
        }

        return $data;
    }

    /**
     * Sanitize individual field based on field name
     */
    protected function sanitizeField(string $fieldName, string $value, string $config): string
    {
        // Skip empty values
        if (empty(trim($value))) {
            return $value;
        }

        // Skip fields that should never be sanitized
        if ($this->shouldSkipField($fieldName)) {
            return $value;
        }

        // Strip all HTML from specific fields
        if ($this->shouldStripHtml($fieldName)) {
            // First decode any HTML entities to catch encoded tags
            $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            // Remove all HTML and PHP tags completely
            $stripped = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $decoded);
            $stripped = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $stripped);
            $stripped = strip_tags($stripped);
            // Clean up any extra whitespace
            return trim(preg_replace('/\s+/', ' ', $stripped));
        }

        // Purify HTML content fields
        if ($this->shouldPurifyHtml($fieldName)) {
            return Purifier::clean($value, $config);
        }

        // For other fields, escape HTML entities
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }

    /**
     * Check if field should have all HTML stripped
     */
    protected function shouldStripHtml(string $fieldName): bool
    {
        foreach ($this->stripFields as $field) {
            if (str_contains(strtolower($fieldName), strtolower($field))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if field should be purified as HTML
     */
    protected function shouldPurifyHtml(string $fieldName): bool
    {
        foreach ($this->htmlFields as $field) {
            if (str_contains(strtolower($fieldName), strtolower($field))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if field should be skipped from sanitization
     */
    protected function shouldSkipField(string $fieldName): bool
    {
        foreach ($this->skipFields as $field) {
            if (strtolower($fieldName) === strtolower($field)) {
                return true;
            }
        }
        return false;
    }
}