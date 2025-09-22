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
        Schema::table('core_pages', function (Blueprint $table) {
            $table->text('json_ld')->nullable()->after('meta_robots');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('core_pages', function (Blueprint $table) {
            $table->dropColumn('json_ld');
        });
    }
};
