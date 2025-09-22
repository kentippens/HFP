<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Rules\ValidJsonLd;
use App\Models\User;
use App\Traits\SanitizesHtml;

class BlogPost extends Model
{
    use HasFactory, HasSlug, SanitizesHtml;

    /**
     * Fields that should be sanitized as HTML
     */
    protected $htmlFields = ['content', 'excerpt'];

    /**
     * Fields that should be stripped of HTML
     */
    protected $stripFields = ['name', 'meta_title', 'meta_description', 'category'];

    /**
     * Purifier config to use for this model
     */
    protected $purifierConfig = 'admin'; // Admin config for blog posts (more permissive)

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
        'content',
        'excerpt',
        'category',
        'category_id',
        'author',        // Keep for backward compatibility during migration
        'author_id',     // New foreign key field
        'author_legacy', // For storing old author name after migration
        'featured_image',
        'thumbnail',
        'meta_title',
        'meta_description',
        'meta_robots',
        'json_ld',
        'canonical_url',
        'include_in_sitemap',
        'is_published',
        'published_at',
        'order_index'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'include_in_sitemap' => 'boolean',
        'published_at' => 'datetime',
        'json_ld' => 'array'
    ];

    // Auto-generate slugs from title
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    // Use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the category that owns the blog post.
     */
    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * Get the author (user) who wrote the blog post.
     * This is the proper relationship following database normalization.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the author name - handles both old and new structure.
     * This accessor provides backward compatibility.
     */
    public function getAuthorNameAttribute(): string
    {
        // If we have the new author relationship, use it
        if ($this->author_id && $this->relationLoaded('author')) {
            return $this->author->name;
        }
        
        // If author_id exists but relation not loaded, load it
        if ($this->author_id) {
            return $this->author()->first()?->name ?? 'Hexagon Team';
        }
        
        // Fall back to legacy author field if it exists
        if (!empty($this->author_legacy)) {
            return $this->author_legacy;
        }
        
        // Fall back to old author field if still present
        if (!empty($this->author)) {
            return $this->author;
        }
        
        // Default author name
        return 'Hexagon Team';
    }

    /**
     * Get author email for contact or display purposes
     */
    public function getAuthorEmailAttribute(): ?string
    {
        if ($this->author_id && $this->relationLoaded('author')) {
            return $this->author->email;
        }
        
        if ($this->author_id) {
            return $this->author()->first()?->email;
        }
        
        return null;
    }

    /**
     * Get author avatar URL
     */
    public function getAuthorAvatarAttribute(): string
    {
        if ($this->author_id && $this->relationLoaded('author')) {
            // Check if user has a profile image
            if (method_exists($this->author, 'getAvatarUrlAttribute')) {
                return $this->author->avatar_url;
            }
        }
        
        // Return default avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->author_name) . '&background=043f88&color=fff';
    }

    /**
     * Check if the given user is the author of this post
     */
    public function isAuthor(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        
        return $this->author_id === $user->id;
    }

    /**
     * Scope to get posts by a specific author
     */
    public function scopeByAuthor($query, $author)
    {
        if ($author instanceof User) {
            return $query->where('author_id', $author->id);
        }
        
        if (is_numeric($author)) {
            return $query->where('author_id', $author);
        }
        
        // Handle string author name (for backward compatibility)
        if (is_string($author)) {
            return $query->whereHas('author', function ($q) use ($author) {
                $q->where('name', 'like', '%' . $author . '%');
            });
        }
        
        return $query;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopeInSitemap($query)
    {
        return $query->where('include_in_sitemap', true);
    }

    // Accessor for featured image URL
    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            // Check if it's a full URL (from storage)
            if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
                return $this->featured_image;
            }
            // Check if it's a storage path
            if (str_starts_with($this->featured_image, 'blog/')) {
                return asset('storage/' . $this->featured_image);
            }
            // Otherwise assume it's in public/images/blog
            return asset('images/blog/' . $this->featured_image);
        }
        
        return asset('images/blog/single-1.jpg');
    }

    // Accessor for thumbnail URL
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            // Check if it's a full URL (from storage)
            if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
                return $this->thumbnail;
            }
            // Check if it's a storage path
            if (str_starts_with($this->thumbnail, 'blog/')) {
                return asset('storage/' . $this->thumbnail);
            }
            // Otherwise assume it's in public/images/blog
            return asset('images/blog/' . $this->thumbnail);
        }
        
        // Fallback to featured image if no thumbnail
        return $this->featured_image_url;
    }

    // Accessor to clean content from Filament's image metadata
    public function getCleanContentAttribute()
    {
        $content = $this->content;
        
        // Remove Filament's trix-attachment tags and any file info
        $content = preg_replace('/<figure[^>]*class="[^"]*trix-attachment[^"]*"[^>]*>.*?<\/figure>/is', '', $content);
        
        // Remove any remaining file size/name info that might be displayed
        $content = preg_replace('/<span[^>]*class="[^"]*attachment__[^"]*"[^>]*>.*?<\/span>/is', '', $content);
        
        // Clean up any data-trix attributes
        $content = preg_replace('/\s*data-trix-[^=]*="[^"]*"/i', '', $content);
        
        return $content;
    }

    // Automatically set published_at when is_published becomes true
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            if ($post->is_published && !$post->published_at) {
                $post->published_at = now();
            }
            
            // Clean content before saving
            if ($post->content) {
                $post->content = self::cleanTrixContent($post->content);
            }
        });
    }
    
    // Clean Trix/Filament content from attachment metadata
    public static function cleanTrixContent($content)
    {
        // Remove attachment captions and metadata while keeping the images
        $content = preg_replace_callback(
            '/<figure[^>]*>.*?<\/figure>/is',
            function ($matches) {
                $figure = $matches[0];
                
                // Extract just the img tag
                if (preg_match('/<img[^>]*>/i', $figure, $imgMatch)) {
                    // Return just the image wrapped in a clean figure
                    return '<figure>' . $imgMatch[0] . '</figure>';
                }
                
                // If no img found, remove the entire figure
                return '';
            },
            $content
        );
        
        // Remove any standalone attachment spans
        $content = preg_replace('/<span[^>]*class="[^"]*attachment__[^"]*"[^>]*>.*?<\/span>/is', '', $content);
        
        // Clean up data-trix attributes from remaining elements
        $content = preg_replace('/\s*data-trix-[^=]*="[^"]*"/i', '', $content);
        
        // Preserve empty paragraphs with &nbsp; or spaces as they might be intentional line breaks
        // CKEditor uses these for line spacing
        // Only remove completely empty paragraphs without any content at all
        $content = preg_replace('/<p[^>]*><\/p>/i', '', $content);
        
        // Convert multiple consecutive <br> tags to paragraphs for better formatting
        $content = preg_replace('/(<br\s*\/?>\s*){3,}/i', '</p><p>', $content);
        
        return $content;
    }

    // Validation rules
    public static function rules($id = null)
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug' . ($id ? ',' . $id : ''),
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:100',
            'featured_image' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_robots' => 'required|string|in:' . implode(',', array_keys(self::META_ROBOTS_OPTIONS)),
            'json_ld' => ['nullable', new ValidJsonLd()],
            'canonical_url' => 'nullable|string|max:255|regex:/^(https?:\/\/|\/)/i',
            'include_in_sitemap' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date'
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
}