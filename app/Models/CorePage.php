<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Rules\ValidJsonLd;
use App\Rules\ValidCanonicalUrl;
use App\Traits\SanitizesHtml;

class CorePage extends Model
{
    use HasFactory, HasUuids, SanitizesHtml;

    /**
     * Fields that should be sanitized as HTML
     */
    protected $htmlFields = ['content', 'custom_html'];

    /**
     * Fields that should be stripped of HTML
     */
    protected $stripFields = ['title', 'meta_title', 'meta_description'];

    /**
     * Purifier config to use for this model
     */
    protected $purifierConfig = 'admin'; // Admin config for core pages

    protected static function boot()
    {
        parent::boot();

        // Note: Validation is handled at the form/API level
        // Uncomment below to enable automatic validation on save
        /*
        static::saving(function ($model) {
            $model->validateModel();
        });
        */
    }

    // Meta robots options
    public const META_ROBOTS_OPTIONS = [
        'index, follow' => 'Index, Follow (Default)',
        'noindex, follow' => 'No Index, Follow',
        'index, nofollow' => 'Index, No Follow',
        'noindex, nofollow' => 'No Index, No Follow',
        'noarchive' => 'Index, Follow, No Archive',
        'nosnippet' => 'Index, Follow, No Snippet',
        'noimageindex' => 'Index, Follow, No Image Index',
        'none' => 'None (No Index, No Follow)',
    ];

    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'meta_robots',
        'json_ld',
        'canonical_url',
        'include_in_sitemap',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'include_in_sitemap' => 'boolean',
        'json_ld' => 'array'
    ];

    // Use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInSitemap($query)
    {
        return $query->where('include_in_sitemap', true);
    }

    // Get core page by slug
    public static function getBySlug($slug)
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }

    // Validation rules for the model
    public static function rules($id = null)
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:core_pages,slug' . ($id ? ',' . $id : ''),
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_robots' => 'required|string|in:' . implode(',', array_keys(self::META_ROBOTS_OPTIONS)),
            'json_ld' => ['nullable', new ValidJsonLd()],
            'canonical_url' => ['nullable', 'string', 'max:255', new ValidCanonicalUrl()],
            'include_in_sitemap' => 'boolean',
            'is_active' => 'boolean'
        ];
    }

    // Custom validation messages
    public static function messages()
    {
        return [
            'json_ld.json' => 'The JSON-LD field must contain valid JSON data.',
            'canonical_url.regex' => 'The canonical URL must be a valid URL (https://example.com/path) or a relative path starting with / (e.g., /, /about, /services/cleaning).',
        ];
    }

    // Accessor to get JSON-LD as a formatted string
    public function getJsonLdStringAttribute()
    {
        if (empty($this->json_ld)) {
            return null;
        }
        
        // Check if it's an array of multiple schemas
        if (isset($this->json_ld[0]) && is_array($this->json_ld[0])) {
            // Multiple schemas - wrap in @graph
            $graphData = [
                '@context' => 'https://schema.org',
                '@graph' => $this->json_ld
            ];
            return json_encode($graphData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        }
        
        return json_encode($this->json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    }

    // Mutator to set JSON-LD from string input
    public function setJsonLdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['json_ld'] = null;
            return;
        }

        // If it's already an array, encode it
        if (is_array($value)) {
            $this->attributes['json_ld'] = json_encode($value);
            return;
        }

        // Try to decode if it's a string
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->attributes['json_ld'] = json_encode($decoded);
            } else {
                // Store as-is if invalid JSON (will be caught by validation)
                $this->attributes['json_ld'] = $value;
            }
        }
    }

    // Helper method to check if JSON-LD is valid
    public function hasValidJsonLd()
    {
        if (empty($this->attributes['json_ld'])) {
            return false;
        }
        
        // Check if the raw JSON string is valid
        json_decode($this->attributes['json_ld']);
        return json_last_error() === JSON_ERROR_NONE;
    }

    // Get JSON-LD validation errors
    public function getJsonLdError()
    {
        if (empty($this->attributes['json_ld'])) {
            return null;
        }

        json_decode($this->attributes['json_ld']);
        
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return null;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded';
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch';
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON';
            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded';
            default:
                return 'Unknown JSON error';
        }
    }

    // Validate the model using the defined rules
    protected function validateModel()
    {
        $validator = \Illuminate\Support\Facades\Validator::make(
            $this->attributes,
            $this->rules($this->id),
            $this->messages()
        );

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }
}
