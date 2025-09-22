<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TrackingScript extends Model
{
    use HasFactory;

    // Script locations
    public const SCRIPT_POSITIONS = [
        'head' => 'In <head> section',
        'body_start' => 'After <body> opening tag',
        'body_end' => 'Before </body> closing tag',
    ];

    protected $fillable = [
        'name',
        'script_content',
        'location',
        'is_active'
    ];

    protected $casts = [
        'id' => 'string',
        'is_active' => 'boolean',
    ];

    protected $keyType = 'string';
    public $incrementing = false;
    
    public $skipValidation = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            if (!($model->skipValidation ?? false)) {
                $model->validateModel();
            }
        });

        static::updating(function ($model) {
            if (!($model->skipValidation ?? false)) {
                $model->validateModel();
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }

    public function scopeByPosition($query, $location)
    {
        return $query->where('location', $location);
    }

    // Validation rules
    public static function rules($id = null)
    {
        return [
            'name' => 'required|string|max:255',
            'script_content' => 'required|string',
            'location' => 'required|string|in:' . implode(',', array_keys(self::SCRIPT_POSITIONS)),
            'is_active' => 'boolean',
        ];
    }

    // Custom validation messages
    public static function messages()
    {
        return [
            'location.in' => 'The script location must be one of: ' . implode(', ', array_values(self::SCRIPT_POSITIONS)),
        ];
    }

    // Helper method to get formatted script code
    public function getFormattedScriptAttribute()
    {
        // Add proper script tags if not present for certain types
        $code = $this->script_content;
        
        if (!str_contains($code, '<script') && !str_contains($code, '<!-- ')) {
            // Wrap in script tags if it's just JavaScript code
            $code = "<script>\n" . $code . "\n</script>";
        }

        return $code;
    }

    // Validate the entire model
    public function validateModel()
    {
        $validator = Validator::make($this->attributes, static::rules(), static::messages());
        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        
        // Additional script-specific validation
        if (!$this->validateScriptCode()) {
            throw new ValidationException(
                Validator::make([], ['script_code' => 'required'], [
                    'script_code.required' => $this->getScriptValidationMessage()
                ])
            );
        }
        
        // Check for potential security issues
        $this->validateScriptSecurity();
    }
    
    // Helper method to validate script code
    public function validateScriptCode()
    {
        $code = $this->script_content;
        
        if (empty($code)) {
            return false;
        }
        
        // Since we removed the type field, just check if script content exists
        return true;
    }
    
    // Get validation message for script code
    private function getScriptValidationMessage()
    {
        return 'Script content is required.';
    }
    
    // Validate script for security issues
    private function validateScriptSecurity()
    {
        $code = $this->script_content;
        
        // Check for potentially dangerous patterns
        $dangerousPatterns = [
            '/eval\(/i',
            '/document\.write\(/i',
            '/innerHTML\s*=/i',
            '/outerHTML\s*=/i',
            '/javascript:/i',
            '/data:text\/html/i',
            '/vbscript:/i',
        ];
        
        foreach ($dangerousPatterns as $pattern) {
            if (preg_match($pattern, $code)) {
                $patternName = str_replace(['/', 'i'], '', $pattern);
                throw new ValidationException(
                    Validator::make([], ['script_code' => 'required'], [
                        'script_code.required' => 'Script contains potentially dangerous code pattern: ' . $patternName
                    ])
                );
            }
        }
        
        // Check for external script sources that might be suspicious
        if (preg_match('/<script[^>]*src\s*=\s*["\']([^"\'\/][^:]*:\/\/[^"\']*)["\']/i', $code, $matches)) {
            $domain = parse_url($matches[1], PHP_URL_HOST);
            if ($domain && !$this->isAllowedDomain($domain)) {
                throw new ValidationException(
                    Validator::make([], ['script_code' => 'required'], [
                        'script_code.required' => 'Script source domain "' . $domain . '" is not in the allowed list.'
                    ])
                );
            }
        }
    }
    
    // Check if domain is allowed for script sources
    private function isAllowedDomain($domain)
    {
        $allowedDomains = [
            'www.googletagmanager.com',
            'www.google-analytics.com',
            'www.clarity.ms',
            'connect.facebook.net',
            'www.facebook.com',
            'analytics.google.com',
            'tagmanager.google.com',
        ];
        
        return in_array(strtolower($domain), $allowedDomains);
    }
    
    // Safe method to get formatted script with error handling
    public function getSafeFormattedScript()
    {
        try {
            return $this->getFormattedScriptAttribute();
        } catch (\Exception $e) {
            \Log::error('Error formatting tracking script: ' . $e->getMessage(), [
                'script_id' => $this->id,
                'script_name' => $this->name,
                'script_location' => $this->location
            ]);
            return '';
        }
    }
}
