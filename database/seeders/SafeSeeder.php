<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

abstract class SafeSeeder extends Seeder
{
    /**
     * Determines if destructive operations are allowed
     */
    protected bool $allowDestructive = false;

    /**
     * Environments where destructive operations are allowed
     */
    protected array $safeEnvironments = ['local', 'testing'];

    /**
     * Check if we're in a production environment
     */
    protected function isProduction(): bool
    {
        return App::environment('production', 'staging');
    }

    /**
     * Check if destructive operations are allowed
     */
    protected function canRunDestructive(): bool
    {
        // Never allow destructive operations in production unless explicitly forced
        if ($this->isProduction() && !$this->isForced()) {
            return false;
        }

        // Check if we're in a safe environment
        return in_array(App::environment(), $this->safeEnvironments) || $this->isForced();
    }

    /**
     * Check if the seeder is being forced (with confirmation)
     */
    protected function isForced(): bool
    {
        // Check for force flag in environment or command
        return env('FORCE_SEED_DESTRUCTIVE', false) === true && 
               env('I_UNDERSTAND_THIS_WILL_DELETE_DATA', false) === true;
    }

    /**
     * Safely truncate a table with protection checks
     */
    protected function safeTruncate(string $modelClass): void
    {
        if (!$this->canRunDestructive()) {
            $this->command->warn("⚠️  Skipping truncate for {$modelClass} - running in production/staging environment");
            $this->command->info("💡 To force destructive operations, set both FORCE_SEED_DESTRUCTIVE=true and I_UNDERSTAND_THIS_WILL_DELETE_DATA=true in your .env file");
            return;
        }

        // Additional safety check - confirm if table has data
        $model = new $modelClass;
        $table = $model->getTable();
        $count = DB::table($table)->count();

        if ($count > 0) {
            $this->command->warn("⚠️  Table '{$table}' contains {$count} records");
            
            if ($this->isProduction()) {
                $this->command->error("❌ Cannot truncate table with data in production without explicit confirmation");
                return;
            }

            // In non-production, still warn but proceed
            $this->command->info("Proceeding with truncate in " . App::environment() . " environment...");
        }

        // Perform truncate with foreign key checks disabled
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $modelClass::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info("✅ Truncated {$table} table");
    }

    /**
     * Upsert data - safer alternative to truncate and insert
     */
    protected function safeUpsert(string $modelClass, array $data, array $uniqueBy = ['slug']): void
    {
        $model = new $modelClass;
        $table = $model->getTable();
        
        // Use upsert to update existing or insert new
        $modelClass::upsert($data, $uniqueBy);
        
        $this->command->info("✅ Upserted " . count($data) . " records into {$table} table");
    }

    /**
     * Create or update a single record
     */
    protected function safeCreateOrUpdate(string $modelClass, array $search, array $data): void
    {
        $modelClass::updateOrCreate($search, $data);
    }

    /**
     * Log seeding activity for audit trail
     */
    protected function logSeeding(string $action, string $details = ''): void
    {
        $message = sprintf(
            "[%s] %s: %s %s",
            now()->toDateTimeString(),
            App::environment(),
            $action,
            $details
        );

        // Log to Laravel log
        logger()->info($message);

        // Also output to console
        $this->command->info($message);
    }

    /**
     * Get confirmation for destructive operations
     */
    protected function confirmDestructive(string $operation = 'truncate'): bool
    {
        if (!$this->isProduction()) {
            return true;
        }

        // In production, require explicit environment variables
        if (!$this->isForced()) {
            $this->command->error("❌ Destructive operation '{$operation}' blocked in production");
            $this->command->warn("Set FORCE_SEED_DESTRUCTIVE=true and I_UNDERSTAND_THIS_WILL_DELETE_DATA=true to force");
            return false;
        }

        return true;
    }
}