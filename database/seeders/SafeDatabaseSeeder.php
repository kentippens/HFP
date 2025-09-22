<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\App;

class SafeDatabaseSeeder extends SafeSeeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->logSeeding('Starting SafeDatabaseSeeder');

        // Display current environment
        $environment = App::environment();
        $this->command->info("🌍 Running seeders in {$environment} environment");

        // Warning for production
        if ($this->isProduction()) {
            $this->command->warn("⚠️  Running in PRODUCTION - Using safe seeding methods");
            $this->command->info("💡 Data will be upserted (updated or created) without deletion");
        }

        // Create test user only in non-production
        if (!$this->isProduction()) {
            $this->command->info("Creating test user...");
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Run seeders in safe mode
        $seeders = $this->getSeeders();
        
        foreach ($seeders as $seeder) {
            $this->command->info("Running: " . class_basename($seeder));
            $this->call($seeder);
        }

        $this->logSeeding('Completed SafeDatabaseSeeder');
        $this->command->info("✅ All seeders completed successfully!");
    }

    /**
     * Get list of seeders to run based on environment
     */
    protected function getSeeders(): array
    {
        $coreSeeders = [
            AdminUserSeeder::class,
            CorePageSeeder::class,
            AdditionalCorePagesSeeder::class,
            BlogCategorySeeder::class,
            SafePoolResurfacingServiceSeeder::class, // Using safe version
        ];

        // Additional seeders for non-production environments
        $developmentSeeders = [];

        if (!$this->isProduction()) {
            // Uncomment to include sample data in development
            // $developmentSeeders = [
            //     BlogPostSeeder::class,
            //     LandingPageSeeder::class,
            // ];
        }

        return array_merge($coreSeeders, $developmentSeeders);
    }
}