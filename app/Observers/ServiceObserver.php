<?php

namespace App\Observers;

use App\Models\Service;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ServiceObserver
{
    /**
     * Handle the Service "created" event.
     */
    public function created(Service $service): void
    {
        $this->createServiceTemplate($service);
    }

    /**
     * Handle the Service "updated" event.
     */
    public function updated(Service $service): void
    {
        // If slug changed, rename the template file
        if ($service->isDirty('slug')) {
            $oldSlug = $service->getOriginal('slug');
            $this->renameServiceTemplate($oldSlug, $service->slug);
        }
    }

    /**
     * Handle the Service "deleted" event.
     */
    public function deleted(Service $service): void
    {
        // Optionally delete the template file when service is deleted
        // Commented out to preserve templates in case service is restored
        // $this->deleteServiceTemplate($service->slug);
    }

    /**
     * Create a blade template for the service
     */
    private function createServiceTemplate(Service $service): void
    {
        try {
            // Validate slug
            if (empty($service->slug) || !preg_match('/^[a-z0-9\-]+$/', $service->slug)) {
                Log::error('Invalid service slug for template creation', [
                    'service_id' => $service->id,
                    'slug' => $service->slug
                ]);
                return;
            }
            
            $templateDir = resource_path('views/services/templates');
            $templatePath = $templateDir . '/' . $service->slug . '.blade.php';
            
            // Ensure directory exists
            if (!File::isDirectory($templateDir)) {
                File::makeDirectory($templateDir, 0755, true);
            }
            
            // Only create if template doesn't already exist
            if (!File::exists($templatePath)) {
                $templateContent = $this->generateTemplateContent($service);
                
                // Validate template content
                if (empty($templateContent)) {
                    Log::error('Empty template content generated', [
                        'service_id' => $service->id,
                        'slug' => $service->slug
                    ]);
                    return;
                }
                
                // Write file with error handling
                if (File::put($templatePath, $templateContent) === false) {
                    Log::error('Failed to write service template file', [
                        'service_id' => $service->id,
                        'path' => $templatePath
                    ]);
                } else {
                    // Set proper permissions
                    chmod($templatePath, 0644);
                    
                    Log::info('Service template created successfully', [
                        'service_id' => $service->id,
                        'slug' => $service->slug,
                        'path' => $templatePath
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Exception creating service template', [
                'service_id' => $service->id,
                'slug' => $service->slug,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Rename service template when slug changes
     */
    private function renameServiceTemplate(string $oldSlug, string $newSlug): void
    {
        try {
            // Validate slugs
            if (empty($oldSlug) || empty($newSlug) || 
                !preg_match('/^[a-z0-9\-]+$/', $oldSlug) || 
                !preg_match('/^[a-z0-9\-]+$/', $newSlug)) {
                Log::error('Invalid slugs for template rename', [
                    'old_slug' => $oldSlug,
                    'new_slug' => $newSlug
                ]);
                return;
            }
            
            $oldPath = resource_path('views/services/templates/' . $oldSlug . '.blade.php');
            $newPath = resource_path('views/services/templates/' . $newSlug . '.blade.php');
            
            if (File::exists($oldPath)) {
                if (!File::exists($newPath)) {
                    if (!File::move($oldPath, $newPath)) {
                        Log::error('Failed to rename service template', [
                            'old_path' => $oldPath,
                            'new_path' => $newPath
                        ]);
                    } else {
                        Log::info('Service template renamed successfully', [
                            'old_slug' => $oldSlug,
                            'new_slug' => $newSlug
                        ]);
                    }
                } else {
                    Log::warning('Cannot rename template - destination already exists', [
                        'old_slug' => $oldSlug,
                        'new_slug' => $newSlug,
                        'new_path' => $newPath
                    ]);
                }
            } else {
                Log::warning('Cannot rename template - source file not found', [
                    'old_slug' => $oldSlug,
                    'old_path' => $oldPath
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception renaming service template', [
                'old_slug' => $oldSlug,
                'new_slug' => $newSlug,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Delete service template
     */
    private function deleteServiceTemplate(string $slug): void
    {
        $templatePath = resource_path('views/services/templates/' . $slug . '.blade.php');
        
        if (File::exists($templatePath)) {
            File::delete($templatePath);
        }
    }

    /**
     * Generate template content for a new service
     */
    private function generateTemplateContent(Service $service): string
    {
        $title = $service->title;
        
        return <<<BLADE
@extends('services.templates.base')

@section('service-content')
    <div class="title-txt">
        <h3>{{ \$service->title }}</h3>
    </div>
    @if(\$service->image)
    <div class="service-image mb-4">
        <img src="{{ \$service->image_url }}" alt="{{ \$service->title }}" class="img-fluid">
    </div>
    @endif
    <div class="pera-text mt-20">
        {{-- Custom content for $title --}}
        <h4>Professional $title Services</h4>
        <p>Experience our exceptional $title services designed to meet your specific needs.</p>
        
        {{-- Add custom service-specific content here --}}
        
        {{-- Include database content --}}
        {!! \$service->description ?: '<p>Professional service with experienced staff and quality results.</p>' !!}
    </div>

    @if(\$service->activeChildren->count() > 0)
    <div class="sub-services mt-40">
        <div class="title-txt">
            <h4>Related Sub-Services</h4>
        </div>
        <div class="row mt-20">
            @foreach(\$service->activeChildren as \$subService)
            <div class="col-md-6 mb-3">
                <div class="sub-service-item" style="background: #f8f9fa; padding: 20px; border-radius: 8px; height: 100%;">
                    <h5 style="margin-bottom: 10px;">
                        <a href="{{ route('services.show', \$subService->full_slug) }}" style="color: #333; text-decoration: none;">
                            {{ \$subService->title }}
                        </a>
                    </h5>
                    <p style="margin-bottom: 10px; font-size: 14px; color: #666;">
                        {{ Str::limit(strip_tags(\$subService->short_description ?: \$subService->description), 100) }}
                    </p>
                    <a href="{{ route('services.show', \$subService->full_slug) }}" class="read-more-link" style="color: #02154e; font-size: 14px; font-weight: 500;">
                        Learn More @icon("fas fa-arrow-right")
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="sr-details-bottom mt-40">
        <div class="row">
            <div class="col-lg-6">
                <div class="sr-details-left">
                    <div class="title-txt">
                        <h4>Service Overview</h4>
                    </div>
                    <div class="pera-txt mt-20">
                        <p>A neatly maintained building is an important asset to every organization. It reflects who you are and influences how your customers perceive you to complete depending on the size.</p>
                    </div>
                    <div class="pera-txt mt-20">
                        <p>Condition of your home. We work in teams of 2-4 or more. A team leader or the owner.</p>
                    </div>
                    <div class="srd-list mt-20">
                         <ul>
                            <li>@icon("fas fa-check")<p>The housekeepers we hired are professionals who take pride in doing excellent work and in exceeding expectations.</p></li>
                            <li>@icon("fas fa-check")<p>We carefully screen all of our cleaners, so you can rest assured that your home would receive the absolute highest quality of service providing.</p></li>
                            <li>@icon("fas fa-check")<p>Your time is precious, and we understand that cleaning is really just one more item on your to-do list.</p></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="srd-right-img">
                    <img src="{{ asset('images/services/services-rightsidebar.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
BLADE;
    }
}