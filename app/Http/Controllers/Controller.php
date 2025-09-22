<?php

namespace App\Http\Controllers;

use App\Models\CorePage;

abstract class Controller
{
    /**
     * Get SEO data for a page with fallback values
     */
    protected function getSeoData($slug, $fallbacks = [])
    {
        $seoData = CorePage::getBySlug($slug);
        
        if (!$seoData) {
            // Create default object with fallback values
            $defaults = [
                'meta_title' => ucfirst($slug),
                'meta_description' => 'Professional cleaning services for homes and offices.',
                'meta_keywords' => 'cleaning, services, professional',
                'meta_robots' => 'index, follow',
                'canonical_url' => null,
                'json_ld' => null,
                'json_ld_string' => null,
            ];
            
            // Merge with provided fallbacks
            $data = array_merge($defaults, $fallbacks);
            $seoData = (object) $data;
        }
        
        return $seoData;
    }
}
