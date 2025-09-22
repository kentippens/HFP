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
        // First, ensure all tables have the required metadata columns
        $tables = ['services', 'blog_posts', 'landing_pages', 'core_pages'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    // Add missing columns if they don't exist
                    if (!Schema::hasColumn($table->getTable(), 'meta_robots')) {
                        $table->string('meta_robots')->default('index, follow')->after('meta_keywords');
                    }
                    if (!Schema::hasColumn($table->getTable(), 'json_ld')) {
                        $table->json('json_ld')->nullable()->after('meta_robots');
                    }
                    if (!Schema::hasColumn($table->getTable(), 'canonical_url')) {
                        $table->string('canonical_url')->nullable()->after('json_ld');
                    }
                    if (!Schema::hasColumn($table->getTable(), 'include_in_sitemap')) {
                        $table->boolean('include_in_sitemap')->default(true)->after('canonical_url');
                    }
                });
            }
        }
        
        // Standardize company name in all metadata to use HSS
        $companyName = 'HSS';
        $companyNamePattern = '/(Hexagon Service Solutions|Hexagon Service|HexServices)/i';
        
        // Update Services metadata
        $services = DB::table('services')->get();
        foreach ($services as $service) {
            $updates = [];
            
            // Generate proper meta title if missing or using abbreviation
            if (!$service->meta_title || preg_match($companyNamePattern, $service->meta_title)) {
                $updates['meta_title'] = $service->name . ' | ' . $companyName;
            }
            
            // Generate meta description if missing
            if (!$service->meta_description || strlen($service->meta_description) < 50) {
                $shortDesc = strip_tags($service->short_description ?? '');
                if ($shortDesc) {
                    $updates['meta_description'] = substr($shortDesc, 0, 150) . '...';
                } else {
                    $updates['meta_description'] = 'Professional ' . strtolower($service->name) . ' services by ' . $companyName . '. Quality service, competitive pricing, and customer satisfaction guaranteed.';
                }
            }
            
            
            // Set canonical URL
            if (!$service->canonical_url) {
                $updates['canonical_url'] = '/services/' . $service->slug;
            }
            
            // Ensure meta_robots is set
            if (!$service->meta_robots || $service->meta_robots === '') {
                $updates['meta_robots'] = 'index, follow';
            }
            
            if (!empty($updates)) {
                DB::table('services')->where('id', $service->id)->update($updates);
            }
        }
        
        // Update Core Pages metadata (fix HSS abbreviation)
        DB::table('core_pages')
            ->where('meta_title', 'LIKE', '%HSS%')
            ->orWhere('meta_description', 'LIKE', '%HSS%')
            ->get()
            ->each(function ($page) use ($companyName) {
                $updates = [];
                
                if ($page->meta_title) {
                    $updates['meta_title'] = str_replace('HSS', $companyName, $page->meta_title);
                }
                
                if ($page->meta_description) {
                    $updates['meta_description'] = str_replace('HSS', $companyName, $page->meta_description);
                }
                
                if (!empty($updates)) {
                    DB::table('core_pages')->where('id', $page->id)->update($updates);
                }
            });
        
        // Update Blog Posts metadata
        DB::table('blog_posts')
            ->whereNull('meta_title')
            ->orWhere('meta_title', '')
            ->get()
            ->each(function ($post) use ($companyName) {
                DB::table('blog_posts')
                    ->where('id', $post->id)
                    ->update([
                        'meta_title' => $post->title . ' | ' . $companyName . ' Blog',
                        'meta_robots' => 'index, follow',
                        'canonical_url' => '/blog/' . $post->slug
                    ]);
            });
        
        // Update Landing Pages metadata
        DB::table('landing_pages')
            ->whereNull('meta_title')
            ->orWhere('meta_title', '')
            ->get()
            ->each(function ($page) use ($companyName) {
                DB::table('landing_pages')
                    ->where('id', $page->id)
                    ->update([
                        'meta_title' => $page->title . ' | ' . $companyName,
                        'meta_robots' => 'index, follow',
                        'canonical_url' => '/lp/' . $page->slug
                    ]);
            });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not reversible as it updates data
    }
};