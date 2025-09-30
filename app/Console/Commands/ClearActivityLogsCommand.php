<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClearActivityLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear
                            {--days=30 : Number of days to keep}
                            {--type= : Specific log type to clear}
                            {--all : Clear all logs (use with caution)}
                            {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old activity logs from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $clearAll = $this->option('all');
        $logType = $this->option('type');
        $daysToKeep = $this->option('days');

        if ($clearAll) {
            if (!$this->confirm('⚠️  Are you sure you want to delete ALL activity logs? This cannot be undone!')) {
                $this->info('Operation cancelled.');
                return 0;
            }

            $query = Activity::query();
            $count = $query->count();

            if (!$dryRun) {
                $query->delete();
                DB::statement('ALTER TABLE activities AUTO_INCREMENT = 1');
                $this->info("✅ Successfully deleted all {$count} activity log entries.");
            } else {
                $this->info("🔍 Dry run: Would delete all {$count} activity log entries.");
            }

            return 0;
        }

        // Build the query based on options
        $query = Activity::query();

        // Filter by date
        $cutoffDate = Carbon::now()->subDays($daysToKeep);
        $query->where('created_at', '<', $cutoffDate);

        // Filter by type if specified
        if ($logType) {
            $query->where('log_type', $logType);
        }

        $count = $query->count();

        if ($count === 0) {
            $this->info('No logs found matching the criteria.');
            return 0;
        }

        // Show what will be deleted
        $this->info("Found {$count} log entries to delete:");
        $this->table(
            ['Criteria', 'Value'],
            [
                ['Older than', $cutoffDate->format('Y-m-d H:i:s')],
                ['Log type', $logType ?: 'All types'],
                ['Total entries', $count],
            ]
        );

        if ($dryRun) {
            $this->info("🔍 Dry run mode - no logs were deleted.");

            // Show sample of logs that would be deleted
            $sampleLogs = $query->take(5)->get(['id', 'log_type', 'action', 'created_at']);
            if ($sampleLogs->count() > 0) {
                $this->info("\nSample of logs that would be deleted:");
                $this->table(
                    ['ID', 'Type', 'Action', 'Created At'],
                    $sampleLogs->map(function ($log) {
                        return [
                            $log->id,
                            $log->log_type,
                            $log->action,
                            $log->created_at->format('Y-m-d H:i:s'),
                        ];
                    })
                );
            }
            return 0;
        }

        // Confirm deletion
        if (!$this->confirm("Do you want to delete {$count} log entries?")) {
            $this->info('Operation cancelled.');
            return 0;
        }

        // Delete the logs
        $query->delete();

        // Reset auto-increment if table is empty
        if (Activity::count() === 0) {
            DB::statement('ALTER TABLE activities AUTO_INCREMENT = 1');
            $this->info('Table auto-increment reset to 1.');
        }

        $this->info("✅ Successfully deleted {$count} activity log entries.");

        // Show remaining logs summary
        $remaining = Activity::count();
        $this->info("Remaining logs in database: {$remaining}");

        if ($remaining > 0) {
            $oldestLog = Activity::oldest()->first();
            $newestLog = Activity::latest()->first();

            $this->table(
                ['Metric', 'Value'],
                [
                    ['Total remaining', $remaining],
                    ['Oldest log', $oldestLog->created_at->format('Y-m-d H:i:s')],
                    ['Newest log', $newestLog->created_at->format('Y-m-d H:i:s')],
                ]
            );
        }

        return 0;
    }
}