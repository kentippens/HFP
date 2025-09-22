<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;

class TestDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:test {--detailed : Show detailed connection information}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test database connection and perform basic operations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Testing database connection...');
        
        try {
            // Test basic connection
            DB::connection()->getPdo();
            $this->info('✅ Database connection successful!');
            
            // Get connection details (without password)
            $config = config('database.connections.' . config('database.default'));
            
            if ($this->option('detailed')) {
                $this->table(
                    ['Property', 'Value'],
                    [
                        ['Driver', $config['driver'] ?? 'N/A'],
                        ['Host', $config['host'] ?? 'N/A'],
                        ['Port', $config['port'] ?? 'N/A'],
                        ['Database', $config['database'] ?? 'N/A'],
                        ['Username', $config['username'] ?? 'N/A'],
                        ['Connection', config('database.default')],
                    ]
                );
            }
            
            // Test read operation
            $this->info("\nTesting read operations...");
            $tableCount = 0;
            
            // Get tables for MySQL/MariaDB
            $tables = DB::select('SHOW TABLES');
            
            $tableCount = count($tables);
            $this->info("✅ Found {$tableCount} tables in database");
            
            // Test specific tables
            $tablesToCheck = ['users', 'services', 'blog_posts', 'contact_submissions'];
            foreach ($tablesToCheck as $table) {
                try {
                    $count = DB::table($table)->count();
                    $this->info("✅ Table '{$table}': {$count} records");
                } catch (Exception $e) {
                    $this->error("❌ Table '{$table}': Not found or error accessing");
                }
            }
            
            // Test write operation (non-destructive)
            $this->info("\nTesting write operations...");
            DB::beginTransaction();
            try {
                // Try to insert and immediately rollback
                DB::table('contact_submissions')->insert([
                    'first_name' => 'Database',
                    'last_name' => 'Test',
                    'email' => 'test@test.com',
                    'phone' => '555-0123',
                    'service' => 'test',
                    'message' => 'This is a database connection test',
                    'source' => 'cli_test',
                    'source_uri' => 'cli',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::rollback();
                $this->info('✅ Write operations working correctly');
            } catch (Exception $e) {
                DB::rollback();
                $this->error('❌ Write operation failed: ' . $e->getMessage());
            }
            
            // Test migrations status
            $this->info("\nChecking migration status...");
            $pendingMigrations = $this->getPendingMigrations();
            if (empty($pendingMigrations)) {
                $this->info('✅ All migrations are up to date');
            } else {
                $this->warn('⚠️  There are ' . count($pendingMigrations) . ' pending migrations');
                if ($this->option('detailed')) {
                    foreach ($pendingMigrations as $migration) {
                        $this->line('  - ' . $migration);
                    }
                }
            }
            
            $this->newLine();
            $this->info('🎉 Database test completed successfully!');
            
            return Command::SUCCESS;
            
        } catch (Exception $e) {
            $this->error('❌ Database connection failed!');
            $this->error('Error: ' . $e->getMessage());
            
            // Provide helpful troubleshooting tips
            $this->newLine();
            $this->warn('Troubleshooting tips:');
            $this->line('1. Check your .env file has correct database credentials');
            $this->line('2. Ensure database service is running');
            $this->line('3. Verify database exists and user has proper permissions');
            $this->line('4. For SQLite, ensure database file exists and is writable');
            
            return Command::FAILURE;
        }
    }
    
    /**
     * Get pending migrations
     *
     * @return array
     */
    private function getPendingMigrations()
    {
        $migrator = app('migrator');
        $files = $migrator->getMigrationFiles($migrator->paths());
        $ran = $migrator->getRepository()->getRan();
        
        return array_diff(array_keys($files), $ran);
    }
}