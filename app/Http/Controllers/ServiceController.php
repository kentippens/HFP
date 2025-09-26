<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        // Define the core services with their root-level routes
        $coreServices = collect([
            (object)[
                'name' => 'Pool Resurfacing',
                'slug' => 'pool-resurfacing',
                'url' => route('silo.pool_resurfacing'),
                'short_description' => 'Transform your pool with our premium resurfacing solutions. Long-lasting, beautiful finishes backed by a 25-year warranty.',
                'icon' => 'swimming-pool.svg'
            ],
            (object)[
                'name' => 'Pool Conversions',
                'slug' => 'pool-conversions',
                'url' => route('silo.pool_conversions'),
                'short_description' => 'Convert your traditional pool to modern fiberglass. Upgrade to a low-maintenance, energy-efficient swimming experience.',
                'icon' => 'swimming-pool.svg'
            ],
            (object)[
                'name' => 'Pool Remodeling',
                'slug' => 'pool-remodeling',
                'url' => route('silo.pool_remodeling'),
                'short_description' => 'Complete pool remodeling services including tile, coping, and equipment upgrades for a total pool transformation.',
                'icon' => 'swimming-pool.svg'
            ],
            (object)[
                'name' => 'Pool Repair',
                'slug' => 'pool-repair-service',
                'url' => route('silo.pool_repair_service'),
                'short_description' => 'Expert pool repair services for cracks, leaks, and structural issues. Permanent solutions with warranty protection.',
                'icon' => 'swimming-pool.svg'
            ]
        ]);

        $services = $coreServices;
        $seoData = $this->getSeoData('services', [
            'meta_title' => 'Our Services | Pool Resurfacing, Conversions, Remodeling & Repair',
            'meta_description' => 'Professional pool services including resurfacing, conversions, remodeling, and repair. 25-year warranty. Serving Dallas-Fort Worth.',
        ]);

        return view('services.index', compact('services', 'seoData'));
    }

    public function show($path)
    {
        try {
            // Check for empty segments in original request
            $originalPath = request()->path();
            if (str_contains($originalPath, '//') || str_ends_with($originalPath, '/')) {
                \Log::warning('Invalid service path with empty segments', [
                    'path' => $path,
                    'original_path' => $originalPath,
                    'ip' => request()->ip()
                ]);
                abort(404, 'Service not found');
            }

            // Validate path format
            if (!preg_match('/^[a-z0-9\-\/]+$/', $path)) {
                \Log::warning('Invalid service path format', [
                    'path' => $path,
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent()
                ]);
                abort(404, 'Service not found');
            }

            // Split the path into segments
            $segments = explode('/', $path);
            
            // Limit path depth to prevent abuse
            if (count($segments) > 10) {
                \Log::warning('Service path too deep', [
                    'path' => $path,
                    'segments_count' => count($segments),
                    'ip' => request()->ip()
                ]);
                abort(404, 'Service not found');
            }
            
            // Find the service by traversing the path
            $service = null;
            $currentParent = null;
            $breadcrumbPath = [];
            
            foreach ($segments as $index => $slug) {
                // Validate each slug
                if (empty($slug) || strlen($slug) > 255) {
                    abort(404, 'Service not found');
                }
                
                $query = Service::active()->where('slug', $slug);
                
                if ($currentParent) {
                    $query->where('parent_id', $currentParent->id);
                } else {
                    $query->whereNull('parent_id');
                }
                
                $service = $query->first();
                
                if (!$service) {
                    // Log failed service lookup
                    \Log::info('Service not found in hierarchy', [
                        'slug' => $slug,
                        'parent_id' => $currentParent?->id,
                        'path_so_far' => implode('/', array_slice($segments, 0, $index + 1)),
                        'full_path' => $path
                    ]);
                    abort(404, 'Service not found');
                }
                
                $breadcrumbPath[] = $service->slug;
                $currentParent = $service;
            }
            
            // Verify the full path matches what we expect
            $expectedPath = implode('/', $breadcrumbPath);
            if ($path !== $expectedPath) {
                \Log::warning('Service path mismatch', [
                    'requested_path' => $path,
                    'expected_path' => $expectedPath
                ]);
                // Redirect to the correct path
                return redirect()->route('services.show', $expectedPath);
            }
            
            // Load children for the found service
            $service->load('activeChildren');
            
            // Log successful service view
            \Log::info('Service viewed', [
                'service_id' => $service->id,
                'path' => $path,
                'has_children' => $service->activeChildren->count() > 0
            ]);
            
            // Check if a specific template exists for this service
            $templatePath = 'services.templates.' . $service->slug;
            
            try {
                if (view()->exists($templatePath)) {
                    // Verify the template file is not empty
                    $templateFile = resource_path('views/services/templates/' . $service->slug . '.blade.php');
                    if (file_exists($templateFile) && filesize($templateFile) > 0) {
                        return view($templatePath, compact('service'));
                    } else {
                        \Log::warning('Service template exists but is empty', [
                            'service_id' => $service->id,
                            'service_slug' => $service->slug,
                            'template_path' => $templatePath,
                            'file_size' => file_exists($templateFile) ? filesize($templateFile) : 'file not found'
                        ]);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error rendering service template', [
                    'service_id' => $service->id,
                    'service_slug' => $service->slug,
                    'template_path' => $templatePath,
                    'error' => $e->getMessage()
                ]);
            }
            
            // Fall back to default template
            try {
                return view('services.templates.default', compact('service'));
            } catch (\Exception $e) {
                \Log::critical('Default service template not found', [
                    'service_id' => $service->id,
                    'error' => $e->getMessage()
                ]);
                abort(500, 'Service template configuration error');
            }
            
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            // Re-throw 404 exceptions
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error loading service', [
                'path' => $path,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            abort(500, 'Error loading service');
        }
    }
}
