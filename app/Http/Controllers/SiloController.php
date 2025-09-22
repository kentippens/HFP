<?php

namespace App\Http\Controllers;

use App\Models\Silo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiloController extends Controller
{
    /**
     * Display the specified silo and its children
     */
    public function show(Request $request, ?string $path = null): View
    {
        try {
            // Get the current route name to determine the root slug
            $routeName = $request->route()->getName();
            $rootSlug = str_replace('silo.', '', $routeName);
            $rootSlug = str_replace('_', '-', $rootSlug);
            
            // Find the root silo
            $silo = Silo::active()
                ->root()
                ->where('slug', $rootSlug)
                ->first();
                
            if (!$silo) {
                abort(404, "The requested silo '{$rootSlug}' was not found.");
            }
            
            // If there's a path, traverse the hierarchy
            if ($path) {
                $segments = explode('/', trim($path, '/'));
                foreach ($segments as $segment) {
                    if (empty($segment)) continue;
                    
                    $child = $silo->activeChildren()
                        ->where('slug', $segment)
                        ->first();
                        
                    if (!$child) {
                        abort(404, "The page '{$segment}' was not found under '{$silo->name}'.");
                    }
                    
                    $silo = $child;
                }
            }
        } catch (\Exception $e) {
            \Log::error('Silo display error', [
                'path' => $path,
                'route' => $routeName ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                throw $e;
            }
            
            abort(500, 'An error occurred while loading the page.');
        }
        
        // Get active children for display
        $children = $silo->activeChildren()->ordered()->get();
        
        // Determine which view template to use
        $template = $this->getTemplate($silo);
        
        return view($template, compact('silo', 'children'));
    }
    
    /**
     * Determine which template to use for the silo
     */
    private function getTemplate(Silo $silo): string
    {
        try {
            // Check if a custom template exists
            if (!empty($silo->template) && $silo->template !== 'default') {
                $customTemplate = 'silos.templates.' . $silo->template;
                if (view()->exists($customTemplate)) {
                    return $customTemplate;
                }
                
                // Log missing template for debugging
                \Log::warning('Silo template not found', [
                    'silo' => $silo->name,
                    'template' => $silo->template,
                    'expected_path' => $customTemplate
                ]);
            }
            
            // Check if this is a parent silo (has children)
            if ($silo->hasActiveChildren()) {
                if (view()->exists('silos.index')) {
                    return 'silos.index';
                }
            }
            
            // Default to the show template
            if (view()->exists('silos.show')) {
                return 'silos.show';
            }
            
            // Ultimate fallback
            \Log::error('No silo view template found', [
                'silo' => $silo->name,
                'template' => $silo->template
            ]);
            
            abort(500, 'Template configuration error. Please contact support.');
            
        } catch (\Exception $e) {
            \Log::error('Error determining silo template', [
                'silo' => $silo->name,
                'error' => $e->getMessage()
            ]);
            
            // Return default template as fallback
            return 'silos.show';
        }
    }
}