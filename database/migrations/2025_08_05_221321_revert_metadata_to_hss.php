<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all metadata to use HSS instead of full company name
        
        // Update Services metadata
        $services = DB::table('services')->get();
        foreach ($services as $service) {
            $updates = [];
            
            // Update meta_title to use HSS
            if ($service->meta_title && str_contains($service->meta_title, 'Hexagon Service Solutions')) {
                $updates['meta_title'] = str_replace(' | Hexagon Service Solutions', ' | HSS', $service->meta_title);
            } elseif ($service->meta_title && !str_contains($service->meta_title, ' | HSS')) {
                // Add HSS suffix if missing
                $updates['meta_title'] = $service->meta_title . ' | HSS';
            }
            
            // Update meta_description if it contains the full company name
            if ($service->meta_description && str_contains($service->meta_description, 'Hexagon Service Solutions')) {
                $updates['meta_description'] = str_replace('Hexagon Service Solutions', 'HSS', $service->meta_description);
            }
            
            if (!empty($updates)) {
                DB::table('services')->where('id', $service->id)->update($updates);
            }
        }
        
        // Update Core Pages metadata
        $corePages = DB::table('core_pages')->get();
        foreach ($corePages as $page) {
            $updates = [];
            
            if ($page->meta_title && str_contains($page->meta_title, 'Hexagon Service Solutions')) {
                $updates['meta_title'] = str_replace('Hexagon Service Solutions', 'HSS', $page->meta_title);
            }
            
            if ($page->meta_description && str_contains($page->meta_description, 'Hexagon Service Solutions')) {
                $updates['meta_description'] = str_replace('Hexagon Service Solutions', 'HSS', $page->meta_description);
            }
            
            if (!empty($updates)) {
                DB::table('core_pages')->where('id', $page->id)->update($updates);
            }
        }
        
        // Update Blog Posts metadata
        $blogPosts = DB::table('blog_posts')->get();
        foreach ($blogPosts as $post) {
            $updates = [];
            
            if ($post->meta_title && str_contains($post->meta_title, 'Hexagon Service Solutions')) {
                $updates['meta_title'] = str_replace(' | Hexagon Service Solutions Blog', ' | HSS Blog', $post->meta_title);
                $updates['meta_title'] = str_replace('Hexagon Service Solutions', 'HSS', $updates['meta_title']);
            }
            
            if (!empty($updates)) {
                DB::table('blog_posts')->where('id', $post->id)->update($updates);
            }
        }
        
        // Update Landing Pages metadata
        $landingPages = DB::table('landing_pages')->get();
        foreach ($landingPages as $page) {
            $updates = [];
            
            if ($page->meta_title && str_contains($page->meta_title, 'Hexagon Service Solutions')) {
                $updates['meta_title'] = str_replace(' | Hexagon Service Solutions', ' | HSS', $page->meta_title);
            }
            
            if (!empty($updates)) {
                DB::table('landing_pages')->where('id', $page->id)->update($updates);
            }
        }
        
        // Set specific service meta titles to match original format
        $serviceMetaTitles = [
            'house-cleaning' => 'Professional House Cleaning Services | HSS',
            'commercial-cleaning' => 'Commercial Cleaning Services | HSS',
            'carpet-cleaning' => 'Professional Carpet Cleaning Services | HSS',
            'deep-cleaning' => 'Deep Cleaning Services | HSS',
            'window-cleaning' => 'Professional Window Cleaning Services | HSS',
            'post-construction-cleaning' => 'Post-Construction Cleaning Services | HSS',
            'pool-cleaning' => 'Professional Pool Cleaning Services | HSS',
            'gutter-leafguard-installation' => 'Gutter & Leaf Guard Installation | HSS',
            'christmas-light-installation' => 'Christmas Light Installation | HSS',
            'vinyl-fence-installation' => 'Vinyl Fence Installation | HSS'
        ];
        
        foreach ($serviceMetaTitles as $slug => $metaTitle) {
            DB::table('services')
                ->where('slug', $slug)
                ->update(['meta_title' => $metaTitle]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to full company name if needed
        $tables = ['services', 'core_pages', 'blog_posts', 'landing_pages'];
        
        foreach ($tables as $table) {
            DB::table($table)
                ->where('meta_title', 'LIKE', '%HSS%')
                ->orWhere('meta_description', 'LIKE', '%HSS%')
                ->get()
                ->each(function ($record) use ($table) {
                    $updates = [];
                    
                    if ($record->meta_title && str_contains($record->meta_title, 'HSS')) {
                        $updates['meta_title'] = str_replace(' | HSS', ' | Hexagon Service Solutions', $record->meta_title);
                        $updates['meta_title'] = str_replace('HSS Blog', 'Hexagon Service Solutions Blog', $updates['meta_title']);
                    }
                    
                    if ($record->meta_description && str_contains($record->meta_description, 'HSS')) {
                        $updates['meta_description'] = str_replace('HSS', 'Hexagon Service Solutions', $record->meta_description);
                    }
                    
                    if (!empty($updates)) {
                        DB::table($table)->where('id', $record->id)->update($updates);
                    }
                });
        }
    }
};