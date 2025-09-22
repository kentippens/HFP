<?php

namespace App\Filament\Resources\BlogPostResource\Pages;

use App\Filament\Resources\BlogPostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\BlogValidationException;
use Exception;

class CreateBlogPost extends CreateRecord
{
    protected static string $resource = BlogPostResource::class;
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Blog post created successfully';
    }
    
    protected function handleRecordCreation(array $data): Model
    {
        try {
            // Start database transaction
            DB::beginTransaction();
            
            // Validate image uploads
            if (isset($data['featured_image'])) {
                $this->validateImageUpload($data['featured_image'], 'featured_image');
            }
            
            if (isset($data['thumbnail'])) {
                $this->validateImageUpload($data['thumbnail'], 'thumbnail');
            }
            
            // Ensure slug is unique
            $data['slug'] = $this->ensureUniqueSlug($data['slug']);
            
            // Set default published_at if publishing
            if ($data['is_published'] && empty($data['published_at'])) {
                $data['published_at'] = now();
            }
            
            // Clean and validate content
            if (isset($data['content'])) {
                $data['content'] = $this->sanitizeContent($data['content']);
                
                // Check for minimum content length
                if (strlen(strip_tags($data['content'])) < 50) {
                    throw new BlogValidationException('Blog content must be at least 50 characters long (excluding HTML tags).');
                }
            }
            
            // Validate and format JSON-LD
            if (!empty($data['json_ld'])) {
                $data['json_ld'] = $this->validateAndFormatJsonLd($data['json_ld']);
            }
            
            // Generate excerpt if not provided
            if (empty($data['excerpt']) && !empty($data['content'])) {
                $data['excerpt'] = $this->generateExcerpt($data['content']);
            }
            
            // Create the blog post
            $record = static::getModel()::create($data);
            
            // Log successful creation
            Log::info('Blog post created successfully', [
                'id' => $record->id,
                'title' => $record->name,
                'author' => $record->author,
                'user_id' => auth()->id()
            ]);
            
            DB::commit();
            
            return $record;
            
        } catch (BlogValidationException $e) {
            DB::rollBack();
            
            Notification::make()
                ->title('Validation Error')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->send();
            
            Log::warning('Blog post validation failed', [
                'error' => $e->getMessage(),
                'data' => array_diff_key($data, array_flip(['content', 'json_ld']))
            ]);
            
            throw $e;
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the error
            Log::error('Failed to create blog post', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => array_diff_key($data, array_flip(['content', 'json_ld']))
            ]);
            
            Notification::make()
                ->title('Error Creating Blog Post')
                ->body('An unexpected error occurred: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
            
            throw $e;
        }
    }
    
    protected function validateImageUpload($imagePath, $fieldName): void
    {
        if (empty($imagePath)) {
            return;
        }
        
        $fullPath = storage_path('app/public/' . $imagePath);
        
        if (!file_exists($fullPath)) {
            throw new BlogValidationException("The {$fieldName} file could not be found.");
        }
        
        // Check file size (5MB limit)
        $fileSize = filesize($fullPath);
        if ($fileSize > 5 * 1024 * 1024) {
            throw new BlogValidationException("The {$fieldName} exceeds the maximum size of 5MB.");
        }
        
        // Validate mime type
        $mimeType = mime_content_type($fullPath);
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        
        if (!in_array($mimeType, $allowedMimes)) {
            throw new BlogValidationException("The {$fieldName} must be a JPEG, PNG, GIF, or WebP image.");
        }
        
        // Check if image is corrupted
        try {
            $imageInfo = getimagesize($fullPath);
            if ($imageInfo === false) {
                throw new BlogValidationException("The {$fieldName} appears to be corrupted or invalid.");
            }
        } catch (\Exception $e) {
            throw new BlogValidationException("The {$fieldName} could not be processed: " . $e->getMessage());
        }
    }
    
    protected function ensureUniqueSlug(string $slug): string
    {
        $originalSlug = $slug;
        $count = 1;
        
        while (static::getModel()::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        return $slug;
    }
    
    protected function sanitizeContent(string $content): string
    {
        // Remove script tags and their content
        $content = preg_replace('#<script[^>]*>.*?</script>#is', '', $content);
        
        // Remove style tags and their content
        $content = preg_replace('#<style[^>]*>.*?</style>#is', '', $content);
        
        // Remove on* event attributes
        $content = preg_replace('#\s*on\w+\s*=\s*["\'][^"\']*["\']#is', '', $content);
        
        // Remove javascript: protocol
        $content = preg_replace('#javascript\s*:#is', '', $content);
        
        return $content;
    }
    
    protected function validateAndFormatJsonLd($jsonLd): ?array
    {
        if (empty($jsonLd)) {
            return null;
        }
        
        // If it's already an array, validate it
        if (is_array($jsonLd)) {
            $jsonString = json_encode($jsonLd);
            $decoded = json_decode($jsonString, true);
        } else {
            // Try to decode the JSON string
            $decoded = json_decode($jsonLd, true);
        }
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BlogValidationException('Invalid JSON-LD format: ' . json_last_error_msg());
        }
        
        // Basic schema validation
        if (isset($decoded['@type']) || isset($decoded[0]['@type']) || isset($decoded['@graph'])) {
            return $decoded;
        }
        
        throw new BlogValidationException('JSON-LD must contain a valid Schema.org structure with @type property.');
    }
    
    protected function generateExcerpt(string $content, int $length = 150): string
    {
        // Strip HTML tags
        $text = strip_tags($content);
        
        // Remove extra whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        // Truncate to specified length
        if (strlen($text) <= $length) {
            return $text;
        }
        
        // Cut at last word boundary
        $excerpt = substr($text, 0, $length);
        $lastSpace = strrpos($excerpt, ' ');
        
        if ($lastSpace !== false) {
            $excerpt = substr($excerpt, 0, $lastSpace);
        }
        
        return $excerpt . '...';
    }
    
    protected function afterCreate(): void
    {
        // Clear blog cache
        cache()->forget('blog_posts');
        cache()->forget('blog_categories');
        cache()->forget('recent_posts');
        
        // Send success notification
        Notification::make()
            ->title('Success!')
            ->body('Blog post has been created and published successfully.')
            ->success()
            ->duration(5000)
            ->send();
    }
    
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Add author if not set
        if (empty($data['author'])) {
            $data['author'] = auth()->user()->name ?? 'Hexagon Team';
        }
        
        // Ensure meta_robots has a default value
        if (empty($data['meta_robots'])) {
            $data['meta_robots'] = 'index, follow';
        }
        
        // Set created_at and updated_at
        $data['created_at'] = now();
        $data['updated_at'] = now();
        
        return $data;
    }
}

