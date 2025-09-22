<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

/**
 * Main database seeder - now uses SafeSeeder for protection
 */
class DatabaseSeeder extends SafeSeeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->logSeeding('Starting DatabaseSeeder');
        
        // Display environment warning
        if ($this->isProduction()) {
            $this->command->warn('⚠️  Running seeders in PRODUCTION environment');
            $this->command->info('Using safe seeding methods - data will be upserted without deletion');
        }
        
        // Only create test user in non-production
        if (!$this->isProduction()) {
            User::firstOrCreate(
                ['email' => 'test@example.com'],
                [
                    'name' => 'Test User',
                    'password' => bcrypt('password'),
                ]
            );
        }

        $this->call([
            AdminUserSeeder::class,
            CorePageSeeder::class,
            AdditionalCorePagesSeeder::class,
            BlogCategorySeeder::class,
            PoolServicesSeeder::class, // Only the 4 pool services
            // RolesAndPermissionsSeeder::class, // Run if using RBAC
            // TrackingScriptSeeder::class, // Commented out due to validation issues
            // BlogPostSeeder::class, // Optional: Only if you want sample blog posts
            // LandingPageSeeder::class, // Optional: Only if you want sample landing pages
        ]);
        
        $this->logSeeding('Completed DatabaseSeeder');
    }
}
