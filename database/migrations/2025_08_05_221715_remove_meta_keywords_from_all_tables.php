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
        // List of tables that may have meta_keywords column
        $tables = [
            'services',
            'blog_posts',
            'blog_categories',
            'landing_pages',
            'core_pages'
        ];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'meta_keywords')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('meta_keywords');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore meta_keywords columns if needed
        $tables = [
            'services',
            'blog_posts',
            'blog_categories',
            'landing_pages',
            'core_pages'
        ];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'meta_keywords')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->text('meta_keywords')->nullable()->after('meta_description');
                });
            }
        }
    }
};