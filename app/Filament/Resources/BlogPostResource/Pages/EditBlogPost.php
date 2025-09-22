<?php

namespace App\Filament\Resources\BlogPostResource\Pages;

use App\Filament\Resources\BlogPostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\BlogValidationException;
use Exception;

class EditBlogPost extends EditRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function () {
                    Log::info('Blog post deletion initiated', [
                        'id' => $this->record->id,
                        'title' => $this->record->name,
                        'user_id' => auth()->id()
                    ]);
                })
                ->after(function () {
                    cache()->forget('blog_posts');
                    cache()->forget('blog_categories');
                    cache()->forget('recent_posts');
                    
                    Notification::make()
                        ->title('Blog post deleted')
                        ->body('The blog post has been permanently deleted.')
                        ->warning()
                        ->send();
                }),
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->url(fn () => route('blog.show', $this->record->slug))
                ->openUrlInNewTab()
                ->color('info'),
        ];
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Blog post updated successfully';
    }
    
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            // Start database transaction
            DB::beginTransaction();
            
            // Store original data for comparison
            $originalData = $record->toArray();
            
            // Validate image uploads if they've changed
            if (isset($data['featured_image']) && $data['featured_image'] !== $record->featured_image) {
                $this->validateImageUpload($data['featured_image'], 'featured_image');
            }
            
            if (isset($data['thumbnail']) && $data['thumbnail'] !== $record->thumbnail) {
                $this->validateImageUpload($data['thumbnail'], 'thumbnail');
            }
            
            // Ensure slug is unique (excluding current record)
            if ($data['slug'] !== $record->slug) {
                $data['slug'] = $this->ensureUniqueSlug($data['slug'], $record->id);
            }
            
            // Update published_at if publishing for the first time
            if ($data['is_published'] && !$record->is_published && empty($data['published_at'])) {
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
            
            // Update the blog post
            $record->update($data);
            
            // Log the update with changes
            $changes = array_diff_assoc($data, $originalData);
            Log::info('Blog post updated successfully', [
                'id' => $record->id,
                'title' => $record->name,
                'user_id' => auth()->id(),
                'changed_fields' => array_keys($changes)
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
            
            Log::warning('Blog post update validation failed', [
                'id' => $record->id,
                'error' => $e->getMessage(),
                'data' => array_diff_key($data, array_flip(['content', 'json_ld']))
            ]);
            
            throw $e;
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the error
            Log::error('Failed to update blog post', [
                'id' => $record->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => array_diff_key($data, array_flip(['content', 'json_ld']))
            ]);
            
            Notification::make()
                ->title('Error Updating Blog Post')
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
        
        // Handle both new uploads and existing paths
        if (is_array($imagePath)) {
            // This is a new upload from Filament
            return; // Filament has already validated it
        }
        
        $fullPath = storage_path('app/public/' . $imagePath);
        
        if (!file_exists($fullPath)) {
            // It might be an old path or external URL
            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                return; // It's a valid URL
            }
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
            if ($e instanceof ValidationException) {
                throw $e;
            }
            throw new BlogValidationException("The {$fieldName} could not be processed: " . $e->getMessage());
        }
    }
    
    protected function ensureUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $originalSlug = $slug;
        $count = 1;
        
        $query = static::getModel()::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            
            $query = static::getModel()::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
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
        
        // Remove data URIs that could contain scripts
        $content = preg_replace('#data:[^;]*;base64[^"\']*#is', '', $content);
        
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
    
    protected function afterSave(): void
    {
        // Clear blog cache
        cache()->forget('blog_posts');
        cache()->forget('blog_categories');
        cache()->forget('recent_posts');
        cache()->forget('blog_post_' . $this->record->slug);
        
        // Send success notification
        Notification::make()
            ->title('Success!')
            ->body('Blog post has been updated successfully.')
            ->success()
            ->duration(5000)
            ->send();
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure meta_robots has a value
        if (empty($data['meta_robots'])) {
            $data['meta_robots'] = 'index, follow';
        }
        
        // Set updated_at
        $data['updated_at'] = now();
        
        return $data;
    }
}

