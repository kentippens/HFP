<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->logSeeding('Starting AdminUserSeeder');
        
        // Never truncate users table - it's in protected tables list
        // Always use firstOrCreate for users
        
        // Use environment variable for default password to avoid hardcoding
        $defaultPassword = env('ADMIN_DEFAULT_PASSWORD', 'password');
        
        // Create primary admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@hexagonservicesolutions.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make($defaultPassword),
                'is_admin' => true,
            ]
        );
        
        if ($adminUser->wasRecentlyCreated) {
            $this->command->info('Admin user created: admin@hexagonservicesolutions.com');
            
            // Only show password in local environment
            if (app()->environment('local')) {
                $this->command->warn('Default password: ' . $defaultPassword);
                $this->command->line('To change password, run: php artisan admin:reset-password admin@hexagonservicesolutions.com');
            }
        }
        
        // Create Ken Tippens account
        $kenUser = User::firstOrCreate(
            ['email' => 'ken.tippens@outlook.com'],
            [
                'name' => 'Ken Tippens',
                'password' => Hash::make($defaultPassword),
                'is_admin' => true,
            ]
        );
        
        if ($kenUser->wasRecentlyCreated) {
            $this->command->info('Ken Tippens user created: ken.tippens@outlook.com');
        }
        
        // Ensure admin flags are set (in case users existed without admin access)
        User::whereIn('email', ['admin@hexagonservicesolutions.com', 'ken.tippens@outlook.com'])
            ->update(['is_admin' => true]);
    }
}