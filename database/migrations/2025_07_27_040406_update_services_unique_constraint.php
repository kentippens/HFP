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
        Schema::table('services', function (Blueprint $table) {
            // Drop the existing unique constraint on slug
            $table->dropUnique(['slug']);
            
            // Add a composite unique constraint on slug + parent_id
            $table->unique(['slug', 'parent_id'], 'services_slug_parent_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique('services_slug_parent_unique');
            
            // Restore the original unique constraint on slug
            $table->unique('slug');
        });
    }
};
