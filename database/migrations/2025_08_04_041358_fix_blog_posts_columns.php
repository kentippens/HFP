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
            // Rename title to name
            $table->renameColumn('title', 'name');
            
            // Add order_index column if it doesn't exist
            if (!Schema::hasColumn('blog_posts', 'order_index')) {
                $table->integer('order_index')->default(0)->after('is_published');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            
            if (Schema::hasColumn('blog_posts', 'order_index')) {
                $table->dropColumn('order_index');
            }
        });
    }
};