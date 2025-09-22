<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Rules\ValidJsonLd;
use App\Rules\PreventCircularServiceReference;
use Illuminate\Support\Facades\Storage;
use App\Traits\SanitizesHtml;

class Service extends Model
{
    use HasFactory, HasSlug, SanitizesHtml;

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        // Prevent self-referencing on save
        static::saving(function ($service) {
            if ($service->parent_id && $service->parent_id == $service->id) {
                throw new \InvalidArgumentException('A service cannot be its own parent.');
            }
        });

        // Ensure slug uniqueness within same parent
        static::saving(function ($service) {
            $query = static::where('slug', $service->slug)
                ->where('id', '!=', $service->id ?? 0);

            // If parent_id is set, check uniqueness within that parent
            if ($service->parent_id !== null) {
                $query->where('parent_id', $service->parent_id);
            } else {
                $query->whereNull('parent_id');
            }

            if ($query->exists()) {
                throw new \InvalidArgumentException('A service with this slug already exists under the same parent.');
            }
        });

        // Check maximum nesting depth
        static::saving(function ($service) {
            if ($service->parent_id && ($service->isDirty('parent_id') || !$service->exists)) {
                if ($service->wouldExceedMaxDepth($service->parent_id)) {
                    throw new \InvalidArgumentException('Maximum nesting depth of 5 levels would be exceeded.');
                }
            }
        });

        // Clean up orphaned relationships before delete
        static::deleting(function ($service) {
            // Log deletion for audit trail
            \Log::info('Service being deleted', [
                'service_id' => $service->id,
                'name' => $service->name,
                'has_children' => $service->children()->count() > 0
            ]);
        });
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
        'description',
        'short_description',
        'overview',
        'features',
        'benefits',
        'image',
        'homepage_image',
        'breadcrumb_image',
        'meta_title',
        'meta_description',
        'meta_robots',
        'json_ld',
        'canonical_url',
        'include_in_sitemap',
        'is_active',
        'order_index',
        'parent_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'include_in_sitemap' => 'boolean',
        'order_index' => 'integer',
        'features' => 'array',
        'benefits' => 'array',
        'json_ld' => 'array'
    ];

    /**
     * Fields that should be sanitized as HTML
     */
    protected $htmlFields = ['description', 'overview'];

    /**
     * Fields that should be stripped of HTML
     */
    protected $stripFields = ['name', 'meta_title', 'meta_description', 'short_description'];

    /**
     * Purifier configuration to use
     */
    protected $purifierConfig = 'services';

    // Auto-generate slugs from title
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate()
            ->skipGenerateWhen(function () {
                // Skip generation if slug is already set
                return !empty($this->slug);
            });
    }

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

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index')->orderBy('name');
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Service::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Service::class, 'parent_id')->ordered();
    }

    public function activeChildren()
    {
        return $this->hasMany(Service::class, 'parent_id')->active()->ordered();
    }

    // Get full URL path including parent slugs
    public function getFullSlugAttribute()
    {
        $slugs = [$this->slug];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($slugs, $parent->slug);
            $parent = $parent->parent;
        }
        
        return implode('/', $slugs);
    }

    // Get breadcrumb trail
    public function getBreadcrumbsAttribute()
    {
        $breadcrumbs = [];
        $service = $this;
        
        while ($service) {
            array_unshift($breadcrumbs, $service);
            $service = $service->parent;
        }
        
        return $breadcrumbs;
    }

    // Get nesting depth
    public function getDepthAttribute()
    {
        $depth = 0;
        $parent = $this->parent;
        
        while ($parent) {
            $depth++;
            $parent = $parent->parent;
            
            // Prevent infinite loops
            if ($depth > 100) {
                break;
            }
        }
        
        return $depth;
    }

    // Check if adding this as a child would exceed max depth
    public function wouldExceedMaxDepth($parentId, $maxDepth = 5)
    {
        if (!$parentId) {
            return false;
        }
        
        $parent = static::find($parentId);
        if (!$parent) {
            return false;
        }
        
        $parentDepth = $parent->depth;
        $thisMaxChildDepth = $this->exists ? $this->getMaxChildDepth() : 0;
        
        // The total depth would be: parent's depth + 1 (for this service) + max depth of children
        $totalDepth = $parentDepth + 1 + $thisMaxChildDepth;
        
        return $totalDepth >= $maxDepth;
    }

    // Get maximum depth of children
    protected function getMaxChildDepth()
    {
        $maxDepth = 0;
        
        foreach ($this->children as $child) {
            $childDepth = 1 + $child->getMaxChildDepth();
            $maxDepth = max($maxDepth, $childDepth);
        }
        
        return $maxDepth;
    }

    // Accessor for image URL - consistent between environments
    public function getImageUrlAttribute()
    {
        try {
            if ($this->image) {
                // Check if it's a full URL
                if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                    return $this->image;
                }
                
                // Build the image path
                $imagePath = 'images/' . $this->image;
                
                // Check if file exists before returning URL
                if (file_exists(public_path($imagePath))) {
                    return asset($imagePath);
                }
                
                // Log missing image for debugging
                \Log::warning('Service image not found', [
                    'service_id' => $this->id,
                    'service_name' => $this->name,
                    'image_path' => $imagePath
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error getting service image URL', [
                'service_id' => $this->id,
                'error' => $e->getMessage()
            ]);
        }
        
        // Return null instead of placeholder
        return null;
    }

    // Accessor for homepage image URL
    public function getHomepageImageUrlAttribute()
    {
        try {
            if ($this->homepage_image) {
                // Check if it's a full URL
                if (filter_var($this->homepage_image, FILTER_VALIDATE_URL)) {
                    return $this->homepage_image;
                }
                
                // All images are stored relative to public/images/
                $imagePath = 'images/' . $this->homepage_image;
                if (file_exists(public_path($imagePath))) {
                    return asset($imagePath);
                }
                
                \Log::warning('Homepage image not found', [
                    'service_id' => $this->id,
                    'service_name' => $this->name,
                    'homepage_image_path' => $imagePath
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error getting homepage image URL', [
                'service_id' => $this->id,
                'error' => $e->getMessage()
            ]);
        }
        
        // Return null if no homepage image is set
        return null;
    }

    // Accessor for breadcrumb image URL - consistent between environments
    public function getBreadcrumbImageUrlAttribute()
    {
        if ($this->breadcrumb_image) {
            // Check if it's a full URL
            if (filter_var($this->breadcrumb_image, FILTER_VALIDATE_URL)) {
                return $this->breadcrumb_image;
            }
            // Check if it starts with 'services/breadcrumbs/' (Filament upload path)
            if (str_starts_with($this->breadcrumb_image, 'services/breadcrumbs/')) {
                // Check for WebP support (you can implement browser detection if needed)
                $webpPath = str_replace(['.jpg', '.png'], '.webp', $this->breadcrumb_image);
                $webpFullPath = storage_path('app/public/' . $webpPath);
                
                // For now, always use JPG (WebP can be implemented with picture element in views)
                return asset('storage/' . $this->breadcrumb_image);
            }
            // Legacy path - images stored relative to public/images/
            return asset('images/' . $this->breadcrumb_image);
        }
        
        // Use default from config
        return asset('images/' . config('services-config.images.default_breadcrumb', 'breadcrumb/services-bg.jpg'));
    }
    
    // Accessor for icon URL - consistent between environments
    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            // Check if it's a full URL
            if (filter_var($this->icon, FILTER_VALIDATE_URL)) {
                return $this->icon;
            }
            // All icons are stored relative to public/images/
            return asset('images/' . $this->icon);
        }
        
        // Use placeholder from config
        return asset('images/' . config('services-config.images.placeholders.icon', 'services/placeholder-icon.png'));
    }

    // Scope for sitemap inclusion
    public function scopeInSitemap($query)
    {
        return $query->where('include_in_sitemap', true);
    }

    // Validation rules
    public static function rules($id = null, $parentId = null)
    {
        $slugRule = ['required', 'string', 'max:255'];
        
        // Build unique rule that considers parent_id
        if ($id) {
            $slugRule[] = \Illuminate\Validation\Rule::unique('services')
                ->where(function ($query) use ($parentId) {
                    return $query->where('parent_id', $parentId);
                })
                ->ignore($id);
        } else {
            $slugRule[] = \Illuminate\Validation\Rule::unique('services')
                ->where(function ($query) use ($parentId) {
                    return $query->where('parent_id', $parentId);
                });
        }
        
        return [
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'image' => 'nullable|string|max:255',
            'homepage_image' => 'nullable|string|max:255',
            'breadcrumb_image' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_robots' => 'required|string|in:' . implode(',', array_keys(self::META_ROBOTS_OPTIONS)),
            'json_ld' => ['nullable', new ValidJsonLd()],
            'canonical_url' => 'nullable|string|max:255|regex:/^(https?:\/\/|\/)/i',
            'include_in_sitemap' => 'boolean',
            'is_active' => 'boolean',
            'order_index' => 'nullable|integer',
            'parent_id' => ['nullable', 'exists:services,id', new PreventCircularServiceReference($id)]
        ];
    }

    // Custom validation messages
    public static function messages()
    {
        return [
            'json_ld.json' => 'The JSON-LD field must contain valid JSON data.',
            'canonical_url.regex' => 'The canonical URL must be a valid URL (https://example.com/path) or a relative path (/path).',
        ];
    }

    // Accessor to get JSON-LD as a formatted string for display
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
    
    // Accessor to get JSON-LD for form editing (returns prettified JSON string)
    public function getJsonLdFormAttribute()
    {
        if (empty($this->json_ld)) {
            return '';
        }
        
        return json_encode($this->json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
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
}