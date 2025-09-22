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
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('services', 'overview')) {
                $table->text('overview')->nullable()->after('short_description');
            }
            if (!Schema::hasColumn('services', 'features')) {
                $table->json('features')->nullable()->after('overview');
            }
            if (!Schema::hasColumn('services', 'benefits')) {
                $table->json('benefits')->nullable()->after('features');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'overview')) {
                $table->dropColumn('overview');
            }
            if (Schema::hasColumn('services', 'features')) {
                $table->dropColumn('features');
            }
            if (Schema::hasColumn('services', 'benefits')) {
                $table->dropColumn('benefits');
            }
        });
    }
};