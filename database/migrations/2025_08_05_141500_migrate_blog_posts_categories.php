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
        // Map old category names to new category IDs
        $categoryMap = [
            'House Cleaning' => 'house-cleaning',
            'Commercial Cleaning' => 'commercial-cleaning',
            'Carpet Cleaning' => 'carpet-cleaning',
            'General' => 'general',
        ];

        // Update existing blog posts with category_id based on their category field
        foreach ($categoryMap as $oldCategory => $slug) {
            $category = DB::table('blog_categories')->where('slug', $slug)->first();
            
            if ($category) {
                DB::table('blog_posts')
                    ->where('category', $oldCategory)
                    ->update(['category_id' => $category->id]);
            }
        }

        // Set default category for posts without a category
        $generalCategory = DB::table('blog_categories')->where('slug', 'general')->first();
        if ($generalCategory) {
            DB::table('blog_posts')
                ->whereNull('category_id')
                ->update(['category_id' => $generalCategory->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear category_id from all blog posts
        DB::table('blog_posts')->update(['category_id' => null]);
    }
};