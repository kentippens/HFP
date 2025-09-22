<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SafeDataRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:safe-refresh 
                            {--force : Force refresh even in protected environments (requires additional flags)}
                            {--skip-backup : Skip creating a backup before refresh}
                            {--only-seeds : Only run seeders without migrations}
                            {--class= : Specific seeder class to run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely refresh database with protection for production environments';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $environment = App::environment();
        $protectedEnvironments = config('seeder.protected_environments', ['production', 'staging']);

        // Check if we're in a protected environment
        if (in_array($environment, $protectedEnvironments)) {
            if (!$this->handleProtectedEnvironment()) {
                return 1;
            }
        }

        $this->info("🚀 Starting safe data refresh in {$environment} environment...");

        // Create backup if not skipped
        if (!$this->option('skip-backup') && config('seeder.backup_before_seed', false)) {
            $this->createBackup();
        }

        // Log the operation
        $this->logOperation('Starting safe data refresh');

        try {
            if (!$this->option('only-seeds')) {
                // Run migrations
                $this->info('Running migrations...');
                Artisan::call('migrate', [], $this->output);
            }

            // Run seeders
            $this->runSeeders();

            $this->logOperation('Completed safe data refresh');
            $this->info('✅ Data refresh completed successfully!');

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Data refresh failed: ' . $e->getMessage());
            $this->logOperation('Failed data refresh: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Handle protected environment checks
     */
    protected function handleProtectedEnvironment(): bool
    {
        $environment = App::environment();

        $this->warn("⚠️  WARNING: You are in a protected environment: {$environment}");
        $this->warn("This operation could potentially delete important data!");

        // Check for force flags
        if (!$this->option('force')) {
            $this->error("❌ Operation cancelled. Use --force flag if you really want to proceed.");
            return false;
        }

        // Check environment variables
        $forceFlags = config('seeder.force_flags');
        if (!$forceFlags['force_seed'] || !$forceFlags['acknowledge_risk']) {
            $this->error("❌ Additional confirmation required for {$environment} environment.");
            $this->info("Set the following in your .env file:");
            $this->info("  FORCE_SEED_DESTRUCTIVE=true");
            $this->info("  I_UNDERSTAND_THIS_WILL_DELETE_DATA=true");
            return false;
        }

        // Final confirmation
        $this->warn("🚨 FINAL WARNING 🚨");
        $this->warn("You are about to refresh data in {$environment} environment.");
        $this->warn("This may DELETE existing data!");

        if (!$this->confirm('Are you absolutely sure you want to proceed?', false)) {
            $this->info("Operation cancelled.");
            return false;
        }

        // Double confirmation for production
        if ($environment === 'production') {
            $confirmText = 'DELETE PRODUCTION DATA';
            $input = $this->ask("Type '{$confirmText}' to confirm");
            
            if ($input !== $confirmText) {
                $this->error("❌ Confirmation failed. Operation cancelled.");
                return false;
            }
        }

        return true;
    }

    /**
     * Create a database backup
     */
    protected function createBackup(): void
    {
        $this->info('📦 Creating database backup...');

        try {
            // If spatie/laravel-backup is installed
            if (class_exists(\Spatie\Backup\Commands\BackupCommand::class)) {
                Artisan::call('backup:run', ['--only-db' => true], $this->output);
                $this->info('✅ Backup created successfully');
            } else {
                // Manual backup using mysqldump
                $this->manualBackup();
            }
        } catch (\Exception $e) {
            $this->warn('⚠️  Could not create backup: ' . $e->getMessage());
            
            if (!$this->confirm('Continue without backup?', false)) {
                throw new \Exception('Operation cancelled - backup failed');
            }
        }
    }

    /**
     * Create manual database backup using mysqldump
     */
    protected function manualBackup(): void
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "backup_{$database}_{$timestamp}.sql";
        $path = storage_path("app/backups/{$filename}");

        // Ensure backup directory exists
        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $command = sprintf(
            'mysqldump -h %s -u %s -p%s %s > %s 2>/dev/null',
            escapeshellarg($host),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($path)
        );

        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            $this->info("✅ Manual backup created: {$filename}");
        } else {
            throw new \Exception('mysqldump failed');
        }
    }

    /**
     * Run database seeders
     */
    protected function runSeeders(): void
    {
        $this->info('🌱 Running seeders...');

        if ($seederClass = $this->option('class')) {
            // Run specific seeder
            Artisan::call('db:seed', ['--class' => $seederClass], $this->output);
        } else {
            // Run all seeders using safe versions
            $seeders = [
                \Database\Seeders\AdminUserSeeder::class,
                \Database\Seeders\CorePageSeeder::class,
                \Database\Seeders\AdditionalCorePagesSeeder::class,
                \Database\Seeders\BlogCategorySeeder::class,
                \Database\Seeders\SafePoolResurfacingServiceSeeder::class,
            ];

            foreach ($seeders as $seeder) {
                $this->info("Running: " . class_basename($seeder));
                Artisan::call('db:seed', ['--class' => $seeder], $this->output);
            }
        }
    }

    /**
     * Log seeding operation
     */
    protected function logOperation(string $message): void
    {
        if (config('seeder.audit_logging.enabled', true)) {
            $logEntry = [
                'timestamp' => now()->toIso8601String(),
                'environment' => App::environment(),
                'user' => get_current_user(),
                'command' => $this->signature,
                'message' => $message,
                'options' => $this->options(),
            ];

            logger()->channel(config('seeder.audit_logging.channel', 'single'))
                ->info('Seeder Operation', $logEntry);
        }
    }
}