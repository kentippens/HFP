<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Silo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'content',
        'template',
        'meta_title',
        'meta_description',
        'canonical_url',
        'meta_robots',
        'json_ld',
        'featured_image',
        'homepage_image',
        'features',
        'benefits',
        'overview',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'json_ld' => 'array',
        'features' => 'array',
        'benefits' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($silo) {
            // Validate required fields
            if (empty($silo->name)) {
                throw new \InvalidArgumentException('Silo name is required.');
            }
            
            if (empty($silo->slug)) {
                $silo->slug = Str::slug($silo->name);
            }
            
            // Ensure slug is URL-safe
            $silo->slug = Str::slug($silo->slug);
            
            // Ensure unique slug
            $originalSlug = $silo->slug;
            $count = 1;
            while (static::where('slug', $silo->slug)->exists()) {
                $silo->slug = $originalSlug . '-' . $count;
                $count++;
            }
            
            // Validate parent exists if specified
            if ($silo->parent_id && !static::find($silo->parent_id)) {
                throw new \InvalidArgumentException('Invalid parent silo specified.');
            }
            
            // Note: Cannot check for self-reference on creation as ID doesn't exist yet
        });

        static::updating(function ($silo) {
            // Validate required fields
            if (empty($silo->name)) {
                throw new \InvalidArgumentException('Silo name is required.');
            }
            
            if ($silo->isDirty('name') && !$silo->isDirty('slug')) {
                $silo->slug = Str::slug($silo->name);
                
                // Ensure unique slug
                $originalSlug = $silo->slug;
                $count = 1;
                while (static::where('slug', $silo->slug)->where('id', '!=', $silo->id)->exists()) {
                    $silo->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
            
            // Ensure slug is URL-safe
            $silo->slug = Str::slug($silo->slug);
            
            // Prevent circular references
            if ($silo->parent_id) {
                if ($silo->parent_id == $silo->id) {
                    throw new \InvalidArgumentException('A silo cannot be its own parent.');
                }
                
                // Check for circular reference in hierarchy
                $parent = static::find($silo->parent_id);
                while ($parent) {
                    if ($parent->id == $silo->id) {
                        throw new \InvalidArgumentException('Circular reference detected in silo hierarchy.');
                    }
                    $parent = $parent->parent;
                }
            }
        });
        
        // Clean up orphaned children when deleting
        static::deleting(function ($silo) {
            // Update children to have no parent instead of cascading delete
            $silo->children()->update(['parent_id' => null]);
        });
    }

    /**
     * Parent silo relationship
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Silo::class, 'parent_id');
    }

    /**
     * Children silos relationship
     */
    public function children(): HasMany
    {
        return $this->hasMany(Silo::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Active children silos
     */
    public function activeChildren(): HasMany
    {
        return $this->children()->where('is_active', true);
    }

    /**
     * Get the full URL path for the silo
     */
    public function getFullSlugAttribute(): string
    {
        if ($this->parent) {
            return $this->parent->full_slug . '/' . $this->slug;
        }
        return $this->slug;
    }

    /**
     * Get the URL for the silo
     */
    public function getUrlAttribute(): string
    {
        return url('/' . $this->full_slug);
    }

    /**
     * Get breadcrumbs for the silo
     */
    public function getBreadcrumbsAttribute(): array
    {
        $breadcrumbs = [];
        $current = $this;

        while ($current) {
            array_unshift($breadcrumbs, [
                'name' => $current->name,
                'url' => $current->url
            ]);
            $current = $current->parent;
        }

        return $breadcrumbs;
    }

    /**
     * Check if silo has children
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Check if silo has active children
     */
    public function hasActiveChildren(): bool
    {
        return $this->activeChildren()->exists();
    }

    /**
     * Get featured image URL
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image) {
            if (Str::startsWith($this->featured_image, ['http://', 'https://'])) {
                return $this->featured_image;
            }
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/services/placeholder-service.jpg');
    }

    /**
     * Get homepage image URL
     */
    public function getHomepageImageUrlAttribute(): ?string
    {
        if ($this->homepage_image) {
            if (Str::startsWith($this->homepage_image, ['http://', 'https://'])) {
                return $this->homepage_image;
            }
            return asset('storage/' . $this->homepage_image);
        }
        return $this->featured_image_url;
    }

    /**
     * Get JSON-LD as string
     */
    public function getJsonLdStringAttribute(): ?string
    {
        if ($this->json_ld) {
            return is_string($this->json_ld) ? $this->json_ld : json_encode($this->json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        return null;
    }
    
    /**
     * Generate breadcrumb schema markup
     */
    public function getBreadcrumbSchemaAttribute(): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];
        
        // Add Home
        $schema['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => url('/')
        ];
        
        // Add each breadcrumb level
        $position = 2;
        foreach($this->breadcrumbs as $crumb) {
            $schema['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $crumb['name'],
                'item' => $crumb['url']
            ];
            $position++;
        }
        
        return $schema;
    }
    
    /**
     * Generate service schema markup
     */
    public function getServiceSchemaAttribute(): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $this->name,
            'description' => $this->meta_description ?? $this->description ?? '',
            'provider' => [
                '@type' => 'LocalBusiness',
                'name' => config('company.name', 'Hexagon Service Solutions'),
                'telephone' => config('company.phone', '972-789-2983'),
                'email' => config('company.email', 'pools@hexagonfiberglasspools.com'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => config('company.address', '603 Munger Ave Suite 100-243A'),
                    'addressLocality' => config('company.city', 'Dallas'),
                    'addressRegion' => config('company.state', 'TX'),
                    'postalCode' => config('company.zip', '75202'),
                    'addressCountry' => 'US'
                ],
                'sameAs' => [
                    'https://www.facebook.com/hexagonservicesolutions'
                ]
            ],
            'areaServed' => [
                '@type' => 'City',
                'name' => 'Dallas-Fort Worth Metroplex'
            ],
            'url' => $this->url,
            'serviceType' => $this->name
        ];
        
        // Add image if available
        if ($this->featured_image_url) {
            $schema['image'] = $this->featured_image_url;
        }
        
        // Add offers/pricing if needed
        if ($this->hasChildren()) {
            $schema['hasOfferCatalog'] = [
                '@type' => 'OfferCatalog',
                'name' => $this->name . ' Services',
                'itemListElement' => $this->children->map(function($child) {
                    return [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => $child->name,
                            'description' => $child->description
                        ]
                    ];
                })->toArray()
            ];
        }
        
        return $schema;
    }
    
    /**
     * Get all schema markup combined
     */
    public function getAllSchemaAttribute(): string
    {
        $schemas = [];
        
        // Add breadcrumb schema
        $schemas[] = $this->breadcrumb_schema;
        
        // Add service schema
        $schemas[] = $this->service_schema;
        
        // Add custom JSON-LD if exists
        if ($this->json_ld) {
            $customSchema = is_string($this->json_ld) ? json_decode($this->json_ld, true) : $this->json_ld;
            if ($customSchema && is_array($customSchema)) {
                $schemas[] = $customSchema;
            }
        }
        
        // If this is a specific service type, add specialized schema
        if ($this->template && $this->template !== 'default') {
            $schemas[] = $this->getSpecializedSchema();
        }
        
        $output = '';
        foreach ($schemas as $schema) {
            if (!empty($schema)) {
                $output .= '<script type="application/ld+json">' . "\n";
                $output .= json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                $output .= "\n" . '</script>' . "\n";
            }
        }
        
        return $output;
    }
    
    /**
     * Get specialized schema based on template type
     */
    private function getSpecializedSchema(): array
    {
        $schema = [];
        
        switch($this->template) {
            case 'pool-resurfacing':
            case 'fiberglass-pool-resurfacing':
            case 'plaster-marcite-resurfacing':
                $schema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'HowTo',
                    'name' => 'How to Get ' . $this->name,
                    'description' => 'Professional ' . $this->name . ' process and benefits',
                    'step' => [
                        [
                            '@type' => 'HowToStep',
                            'name' => 'Initial Consultation',
                            'text' => 'Schedule a free consultation to assess your pool condition'
                        ],
                        [
                            '@type' => 'HowToStep',
                            'name' => 'Pool Inspection',
                            'text' => 'Our experts inspect your pool and provide recommendations'
                        ],
                        [
                            '@type' => 'HowToStep',
                            'name' => 'Service Execution',
                            'text' => 'Professional ' . $this->name . ' service performed'
                        ],
                        [
                            '@type' => 'HowToStep',
                            'name' => 'Quality Check',
                            'text' => 'Final inspection and quality assurance'
                        ]
                    ]
                ];
                break;
                
            case 'pool-repair':
            case 'pool-crack-repair':
                $schema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'How quickly can you repair my pool?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Most pool repairs can be completed within 1-3 days depending on the severity of the issue.'
                            ]
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Do you offer emergency pool repair services?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Yes, we offer 24/7 emergency pool repair services for urgent issues.'
                            ]
                        ]
                    ]
                ];
                break;
        }
        
        return $schema;
    }

    /**
     * Scope for active silos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for root silos (no parent)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for ordered silos
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}