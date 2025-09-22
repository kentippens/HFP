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
            $table->text('meta_keywords')->nullable()->after('meta_description');
            $table->string('meta_robots', 50)->default('index, follow')->after('meta_keywords');
            $table->text('json_ld')->nullable()->after('meta_robots');
            $table->string('canonical_url')->nullable()->after('json_ld');
            $table->boolean('include_in_sitemap')->default(true)->after('canonical_url');
            
            // Add indexes
            $table->index('meta_robots');
            $table->index('include_in_sitemap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex(['meta_robots']);
            $table->dropIndex(['include_in_sitemap']);
            
            $table->dropColumn([
                'meta_keywords',
                'meta_robots',
                'json_ld',
                'canonical_url',
                'include_in_sitemap'
            ]);
        });
    }
};