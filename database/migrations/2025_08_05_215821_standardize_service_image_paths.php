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
        // Standardize service image paths to use relative paths without leading slashes
        // This ensures consistency between local and production environments
        
        $services = DB::table('services')->get();
        
        foreach ($services as $service) {
            $updates = [];
            
            // Standardize icon path
            if ($service->icon) {
                $icon = str_replace(['public/', '/images/services/', 'images/services/'], '', $service->icon);
                $icon = ltrim($icon, '/');
                if (!empty($icon) && !str_starts_with($icon, 'services/')) {
                    $updates['icon'] = 'services/' . $icon;
                }
            }
            
            // Standardize main image path
            if ($service->image) {
                $image = str_replace(['public/', '/images/services/', 'images/services/'], '', $service->image);
                $image = ltrim($image, '/');
                if (!empty($image) && !str_starts_with($image, 'services/')) {
                    $updates['image'] = 'services/' . $image;
                }
            }
            
            // Standardize breadcrumb image path
            if ($service->breadcrumb_image) {
                $breadcrumb = str_replace(['public/', '/images/breadcrumb/', 'images/breadcrumb/', '/images/', 'images/'], '', $service->breadcrumb_image);
                $breadcrumb = ltrim($breadcrumb, '/');
                if (!empty($breadcrumb) && !str_starts_with($breadcrumb, 'breadcrumb/')) {
                    $updates['breadcrumb_image'] = 'breadcrumb/' . $breadcrumb;
                }
            }
            
            if (!empty($updates)) {
                DB::table('services')
                    ->where('id', $service->id)
                    ->update($updates);
            }
        }
        
        // Set default breadcrumb image for all services to ensure consistency
        DB::table('services')
            ->whereNull('breadcrumb_image')
            ->orWhere('breadcrumb_image', '')
            ->update(['breadcrumb_image' => 'breadcrumb/services-bg.jpg']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed as this is a data standardization
    }
};