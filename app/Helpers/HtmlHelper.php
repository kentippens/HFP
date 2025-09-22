<?php

namespace App\Helpers;

use Mews\Purifier\Facades\Purifier;

class HtmlHelper
{
    /**
     * Safely output HTML content with purification
     * Returns HtmlString to prevent Blade double-escaping
     */
    public static function safe($content, $config = 'default')
    {
        if (empty($content)) {
            return new \Illuminate\Support\HtmlString('');
        }

        $clean = Purifier::clean($content, $config);
        return new \Illuminate\Support\HtmlString($clean);
    }

    /**
     * Output user-generated content with strict purification
     */
    public static function userContent($content)
    {
        return self::safe($content, 'strict');
    }

    /**
     * Output admin-generated content with more permissive purification
     */
    public static function adminContent($content)
    {
        return self::safe($content, 'admin');
    }

    /**
     * Output escaped HTML
     */
    public static function escape($content)
    {
        if (empty($content)) {
            return '';
        }

        return htmlspecialchars($content, ENT_QUOTES, 'UTF-8', false);
    }

    /**
     * Strip all HTML tags
     */
    public static function strip($content)
    {
        if (empty($content)) {
            return '';
        }

        return strip_tags($content);
    }

    /**
     * Truncate HTML content safely
     */
    public static function truncate($content, $length = 100, $suffix = '...')
    {
        $content = self::strip($content);
        
        if (strlen($content) <= $length) {
            return $content;
        }

        return substr($content, 0, $length) . $suffix;
    }

    /**
     * Check if content contains potentially dangerous HTML
     */
    public static function containsDangerousHtml($content)
    {
        $dangerous = [
            '<script',
            'javascript:',
            'onclick',
            'onload',
            'onerror',
            'onmouseover',
            'onfocus',
            'onblur',
            '<iframe',
            '<embed',
            '<object',
            'data:text/html',
            'vbscript:',
            '<form',
            '<input',
            'document.cookie',
            'document.write',
            '.innerHTML',
            'eval(',
            'setTimeout(',
            'setInterval(',
        ];

        $lowerContent = strtolower($content);
        
        foreach ($dangerous as $pattern) {
            if (strpos($lowerContent, strtolower($pattern)) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Sanitize content for safe display
     */
    public static function sanitize($content, $allowedTags = null)
    {
        if (empty($content)) {
            return '';
        }

        // Check for dangerous content
        if (self::containsDangerousHtml($content)) {
            // Log potential XSS attempt
            \Log::warning('Potentially dangerous HTML detected', [
                'content' => substr($content, 0, 500),
                'ip' => request()->ip(),
                'user_id' => auth()->id(),
            ]);
            
            // Return stripped content
            return self::strip($content);
        }

        // Use custom allowed tags or default
        if ($allowedTags === null) {
            $allowedTags = '<p><br><strong><em><u><a><ul><ol><li><blockquote>';
        }

        return strip_tags($content, $allowedTags);
    }
}