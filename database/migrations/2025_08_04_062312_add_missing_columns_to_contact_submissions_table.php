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
        Schema::table('contact_submissions', function (Blueprint $table) {
            // Add missing columns
            $table->string('subject')->nullable()->after('phone');
            $table->string('ip_address', 45)->nullable()->after('source_uri');
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->timestamp('submitted_at')->nullable()->after('user_agent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropColumn(['subject', 'ip_address', 'user_agent', 'submitted_at']);
        });
    }
};
