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
        // Fix invitation_tokens table - rename column to match expected name
        Schema::table('invitation_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('invitation_tokens', 'used_by_user_id')) {
                // Drop foreign key constraint first
                $table->dropForeign(['used_by_user_id']);
            }
        });
        
        Schema::table('invitation_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('invitation_tokens', 'used_by_user_id')) {
                // Rename the column (it should be used_by, not used_by_user_id)
                $table->dropColumn('used_by_user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitation_tokens', function (Blueprint $table) {
            if (!Schema::hasColumn('invitation_tokens', 'used_by_user_id')) {
                $table->foreignId('used_by_user_id')->nullable()->constrained('users');
            }
        });
    }
};
