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
        Schema::table('blog_posts', function (Blueprint $table) {
            // Add status field for workflow
            $table->enum('status', ['draft', 'review', 'published', 'archived'])
                  ->default('draft')
                  ->after('is_published')
                  ->index();

            // Add reviewer_id for tracking who reviewed the post
            $table->unsignedBigInteger('reviewer_id')->nullable()->after('author_id');
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('set null');

            // Add timestamps for workflow tracking
            $table->timestamp('submitted_for_review_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('archived_at')->nullable();

            // Add review notes field
            $table->text('review_notes')->nullable();

            // Add version tracking
            $table->unsignedInteger('version')->default(1);

            // Index for common queries
            $table->index(['status', 'published_at']);
        });

        // Migrate existing data: set status based on is_published flag
        DB::statement("UPDATE blog_posts SET status = CASE
            WHEN is_published = 1 THEN 'published'
            ELSE 'draft'
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropForeign(['reviewer_id']);
            $table->dropColumn([
                'status',
                'reviewer_id',
                'submitted_for_review_at',
                'reviewed_at',
                'archived_at',
                'review_notes',
                'version'
            ]);
        });
    }
};
