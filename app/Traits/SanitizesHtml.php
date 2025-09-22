<?php

namespace App\Traits;

use Mews\Purifier\Facades\Purifier;

trait SanitizesHtml
{
    /**
     * Boot the trait
     */
    public static function bootSanitizesHtml()
    {
        static::saving(function ($model) {
            $model->sanitizeHtmlFields();
        });
    }

    /**
     * Fields that should be sanitized as HTML
     */
    protected function getHtmlFields(): array
    {
        return property_exists($this, 'htmlFields') 
            ? $this->htmlFields 
            : ['description', 'content', 'body', 'overview'];
    }

    /**
     * Fields that should be stripped of HTML
     */
    protected function getStripFields(): array
    {
        return property_exists($this, 'stripFields')
            ? $this->stripFields
            : ['name', 'title', 'meta_title', 'meta_description'];
    }

    /**
     * Get purifier config for this model
     */
    protected function getPurifierConfig(): string
    {
        return property_exists($this, 'purifierConfig')
            ? $this->purifierConfig
            : 'default';
    }

    /**
     * Sanitize HTML fields before saving
     */
    protected function sanitizeHtmlFields(): void
    {
        $config = $this->getPurifierConfig();

        // Sanitize HTML fields
        foreach ($this->getHtmlFields() as $field) {
            if (isset($this->attributes[$field]) && !empty($this->attributes[$field])) {
                $this->attributes[$field] = Purifier::clean($this->attributes[$field], $config);
            }
        }

        // Strip HTML from text fields
        foreach ($this->getStripFields() as $field) {
            if (isset($this->attributes[$field]) && !empty($this->attributes[$field])) {
                $this->attributes[$field] = strip_tags($this->attributes[$field]);
            }
        }

        // Sanitize JSON fields containing HTML
        $this->sanitizeJsonFields();
    }

    /**
     * Sanitize JSON fields that might contain HTML
     */
    protected function sanitizeJsonFields(): void
    {
        // Handle benefits array
        if (isset($this->attributes['benefits']) && is_array($this->benefits)) {
            $sanitized = [];
            foreach ($this->benefits as $benefit) {
                $sanitized[] = strip_tags($benefit);
            }
            $this->attributes['benefits'] = json_encode($sanitized);
        }

        // Handle features array
        if (isset($this->attributes['features']) && is_array($this->features)) {
            $sanitized = [];
            foreach ($this->features as $feature) {
                $sanitized[] = strip_tags($feature);
            }
            $this->attributes['features'] = json_encode($sanitized);
        }
    }

    /**
     * Get sanitized HTML attribute
     */
    public function getSafeHtmlAttribute(string $attribute, ?string $config = null): ?string
    {
        $value = $this->getAttribute($attribute);
        
        if (empty($value)) {
            return $value;
        }

        $config = $config ?? $this->getPurifierConfig();
        
        return Purifier::clean($value, $config);
    }

    /**
     * Get escaped attribute for safe display
     */
    public function getEscapedAttribute(string $attribute): ?string
    {
        $value = $this->getAttribute($attribute);
        
        if (empty($value)) {
            return $value;
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
}