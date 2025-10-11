<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration verifies and adds any missing performance indexes
     * for frequently queried columns across the application.
     */
    public function up(): void
    {
        // Check and add indexes for silos table
        Schema::table('silos', function (Blueprint $table) {
            // Verify slug index exists (should already exist)
            if (!$this->indexExists('silos', 'silos_slug_index')) {
                $table->index('slug', 'silos_slug_index');
            }
        });

        // Check and add indexes for blog_posts table
        Schema::table('blog_posts', function (Blueprint $table) {
            // Verify status index exists (should already exist)
            if (!$this->indexExists('blog_posts', 'blog_posts_status_index')) {
                $table->index('status', 'blog_posts_status_index');
            }
        });

        // Check and add indexes for contact_submissions table
        Schema::table('contact_submissions', function (Blueprint $table) {
            // Verify created_at index exists (should already exist)
            if (!$this->indexExists('contact_submissions', 'contact_submissions_created_at_index')) {
                $table->index('created_at', 'contact_submissions_created_at_index');
            }
        });

        // Add composite index for common query patterns (NEW)
        Schema::table('blog_posts', function (Blueprint $table) {
            // Optimize for: WHERE status = 'published' ORDER BY published_at DESC
            if (!$this->indexExists('blog_posts', 'blog_posts_status_published_at_index')) {
                $table->index(['status', 'published_at'], 'blog_posts_status_published_at_index');
            }
        });

        // Add composite index for silo queries (NEW)
        Schema::table('silos', function (Blueprint $table) {
            // Optimize for: WHERE is_active = 1 ORDER BY sort_order
            if (!$this->indexExists('silos', 'silos_active_sort_index')) {
                $table->index(['is_active', 'sort_order'], 'silos_active_sort_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('silos', function (Blueprint $table) {
            $table->dropIndex('silos_active_sort_index');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex('blog_posts_status_published_at_index');
        });
    }

    /**
     * Check if an index exists on a table
     */
    private function indexExists(string $table, string $index): bool
    {
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$index]);
        return count($indexes) > 0;
    }
};
