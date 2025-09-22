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
            $table->string('meta_robots')->default('index, follow')->after('meta_keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('core_pages', function (Blueprint $table) {
            $table->dropColumn('meta_robots');
        });
    }
};
