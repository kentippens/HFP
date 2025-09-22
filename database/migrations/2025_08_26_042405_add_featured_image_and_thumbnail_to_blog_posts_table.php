<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // Add featured_image column if it doesn't exist
            if (!Schema::hasColumn('blog_posts', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('author');
            }
            
            // Add thumbnail column if it doesn't exist (rename thumbnail_url to thumbnail)
            if (!Schema::hasColumn('blog_posts', 'thumbnail') && Schema::hasColumn('blog_posts', 'thumbnail_url')) {
                $table->renameColumn('thumbnail_url', 'thumbnail');
            } elseif (!Schema::hasColumn('blog_posts', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('featured_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if (Schema::hasColumn('blog_posts', 'featured_image')) {
                $table->dropColumn('featured_image');
            }
            
            // Rename thumbnail back to thumbnail_url if needed
            if (Schema::hasColumn('blog_posts', 'thumbnail')) {
                $table->renameColumn('thumbnail', 'thumbnail_url');
            }
        });
    }
};
