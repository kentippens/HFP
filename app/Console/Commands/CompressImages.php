<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class CompressImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:compress 
                            {--path= : Specific path to compress images from}
                            {--quality=85 : JPEG compression quality (1-100)}
                            {--backup : Create backups of original images}
                            {--dry-run : Show what would be compressed without actually doing it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compress large images to optimize for web';

    /**
     * Large images that need compression
     */
    private $targetImages = [
        'public/images/home2/faqs-background.png',
        'public/images/slider/home2/hero-image-hp.png',
        'public/images/home1/hero-image-v.png',
        'public/images/home1/contactform-background.png',
        'public/images/about/about-history.png',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $quality = (int) $this->option('quality');
        $backup = $this->option('backup');
        $dryRun = $this->option('dry-run');
        $path = $this->option('path');
        
        if ($dryRun) {
            $this->info('🔍 DRY RUN MODE - No files will be modified');
        }
        
        $this->info('Starting image compression...');
        $this->newLine();
        
        // Get images to process
        $images = $path ? $this->getImagesFromPath($path) : $this->targetImages;
        
        $totalSaved = 0;
        $processedCount = 0;
        
        foreach ($images as $imagePath) {
            $fullPath = base_path($imagePath);
            
            if (!File::exists($fullPath)) {
                $this->warn("File not found: $imagePath");
                continue;
            }
            
            $originalSize = filesize($fullPath);
            $originalSizeHuman = $this->formatBytes($originalSize);
            
            $this->info("Processing: $imagePath");
            $this->line("  Original size: $originalSizeHuman");
            
            if ($dryRun) {
                // Estimate compressed size (roughly 30-40% of original for PNG to JPEG)
                $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                $estimatedSize = $extension === 'png' ? $originalSize * 0.35 : $originalSize * 0.7;
                $estimatedSaved = $originalSize - $estimatedSize;
                $this->line("  Estimated size after compression: " . $this->formatBytes($estimatedSize));
                $this->line("  Estimated savings: " . $this->formatBytes($estimatedSaved) . " (" . round(($estimatedSaved / $originalSize) * 100, 1) . "%)");
                $totalSaved += $estimatedSaved;
                $processedCount++;
                continue;
            }
            
            try {
                // Create backup if requested
                if ($backup) {
                    $backupPath = $fullPath . '.backup';
                    File::copy($fullPath, $backupPath);
                    $this->line("  Backup created: " . basename($backupPath));
                }
                
                // Load and compress image
                $manager = new ImageManager(new Driver());
                $image = $manager->read($fullPath);
                
                // Get image dimensions
                $width = $image->width();
                $height = $image->height();
                
                // Resize if image is too large (max 1920px width for hero images)
                if ($width > 1920 && strpos($imagePath, 'hero') !== false) {
                    $image->scale(width: 1920);
                    $this->line("  Resized from {$width}px to 1920px width");
                }
                
                // Save with compression
                $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                
                if ($extension === 'png') {
                    // Convert large PNGs to JPEG for better compression
                    // (unless they have transparency)
                    if ($this->canConvertToJpeg($fullPath)) {
                        $jpegPath = str_replace('.png', '.jpg', $fullPath);
                        $image->toJpeg(quality: $quality)->save($jpegPath);
                        
                        // Delete original PNG
                        File::delete($fullPath);
                        
                        $newSize = filesize($jpegPath);
                        $this->line("  Converted PNG to JPEG");
                        $this->info("  ✓ New size: " . $this->formatBytes($newSize));
                        
                        // Update references in code
                        $this->updateImageReferences($imagePath, str_replace('.png', '.jpg', $imagePath));
                    } else {
                        // Keep as PNG but compress
                        $image->toPng()->save($fullPath);
                        $newSize = filesize($fullPath);
                        $this->info("  ✓ Compressed PNG size: " . $this->formatBytes($newSize));
                    }
                } else {
                    // Compress JPEG
                    $image->toJpeg(quality: $quality)->save($fullPath);
                    $newSize = filesize($fullPath);
                    $this->info("  ✓ New size: " . $this->formatBytes($newSize));
                }
                
                $saved = $originalSize - $newSize;
                $savedPercent = round(($saved / $originalSize) * 100, 1);
                
                if ($saved > 0) {
                    $this->info("  💾 Saved: " . $this->formatBytes($saved) . " ({$savedPercent}%)");
                    $totalSaved += $saved;
                } else {
                    $this->warn("  ⚠️  No size reduction achieved");
                }
                
                $processedCount++;
                
            } catch (\Exception $e) {
                $this->error("  ❌ Error: " . $e->getMessage());
            }
            
            $this->newLine();
        }
        
        // Summary
        $this->info('🎉 Compression complete!');
        $this->info("Processed: {$processedCount} images");
        $this->info("Total saved: " . $this->formatBytes($totalSaved));
        
        if ($dryRun) {
            $this->newLine();
            $this->warn('This was a dry run. Run without --dry-run to actually compress images.');
        }
        
        return Command::SUCCESS;
    }
    
    /**
     * Get images from a specific path
     */
    private function getImagesFromPath($path): array
    {
        $fullPath = base_path($path);
        
        if (!File::isDirectory($fullPath)) {
            return File::exists($fullPath) ? [$path] : [];
        }
        
        $files = File::allFiles($fullPath);
        $images = [];
        
        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                // Only include files over 500KB
                if ($file->getSize() > 500 * 1024) {
                    $relativePath = str_replace(base_path() . '/', '', $file->getPathname());
                    $images[] = $relativePath;
                }
            }
        }
        
        return $images;
    }
    
    /**
     * Check if PNG can be converted to JPEG (no transparency)
     */
    private function canConvertToJpeg($pngPath): bool
    {
        try {
            $image = imagecreatefrompng($pngPath);
            $transparent = imagecolortransparent($image);
            
            if ($transparent >= 0) {
                imagedestroy($image);
                return false;
            }
            
            // Check for alpha channel
            if (imageistruecolor($image) && imagecolorsforindex($image, 0)['alpha'] ?? 0) {
                imagedestroy($image);
                return false;
            }
            
            imagedestroy($image);
            return true;
            
        } catch (\Exception $e) {
            // If we can't determine, assume it has transparency to be safe
            return false;
        }
    }
    
    /**
     * Update image references in code
     */
    private function updateImageReferences($oldPath, $newPath): void
    {
        // Skip if paths are the same
        if ($oldPath === $newPath) {
            return;
        }
        
        $oldFilename = basename($oldPath);
        $newFilename = basename($newPath);
        
        $this->line("  Updating references: {$oldFilename} → {$newFilename}");
        
        // Update in Blade files
        $bladeFiles = File::glob(resource_path('views/**/*.blade.php'));
        
        foreach ($bladeFiles as $file) {
            $content = File::get($file);
            if (strpos($content, $oldFilename) !== false) {
                $content = str_replace($oldFilename, $newFilename, $content);
                File::put($file, $content);
                $this->line("    Updated: " . str_replace(base_path() . '/', '', $file));
            }
        }
        
        // Update in CSS files
        $cssFiles = File::glob(public_path('css/*.css'));
        
        foreach ($cssFiles as $file) {
            $content = File::get($file);
            if (strpos($content, $oldFilename) !== false) {
                $content = str_replace($oldFilename, $newFilename, $content);
                File::put($file, $content);
                $this->line("    Updated: " . str_replace(base_path() . '/', '', $file));
            }
        }
    }
    
    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}