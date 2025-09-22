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
        Schema::table('users', function (Blueprint $table) {
            // Password expiration
            $table->timestamp('password_changed_at')->nullable()->after('password');
            $table->boolean('force_password_change')->default(false)->after('password_changed_at');
            
            // Account lockout
            $table->integer('failed_login_attempts')->default(0)->after('force_password_change');
            $table->timestamp('locked_until')->nullable()->after('failed_login_attempts');
            
            // Password security settings
            $table->boolean('two_factor_enabled')->default(false)->after('locked_until');
            $table->string('two_factor_secret')->nullable()->after('two_factor_enabled');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            
            // Last login tracking
            $table->timestamp('last_login_at')->nullable()->after('two_factor_recovery_codes');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            
            // Indexes for performance
            $table->index('password_changed_at');
            $table->index('locked_until');
            $table->index('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'password_changed_at',
                'force_password_change',
                'failed_login_attempts',
                'locked_until',
                'two_factor_enabled',
                'two_factor_secret',
                'two_factor_recovery_codes',
                'last_login_at',
                'last_login_ip'
            ]);
        });
    }
};