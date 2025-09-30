<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use Carbon\Carbon;

class CleanupActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'activity-logs:cleanup
                           {--days=90 : Number of days to retain logs}
                           {--batch-size=1000 : Number of records to delete per batch}
                           {--dry-run : Show what would be deleted without actually deleting}
                           {--log-types= : Specific log types to cleanup (comma separated)}
                           {--exclude-events= : Events to exclude from cleanup (comma separated)}';

    /**
     * The console command description.
     */
    protected $description = 'Clean up old activity logs to maintain database performance';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');
        $batchSize = (int) $this->option('batch-size');
        $isDryRun = $this->option('dry-run');
        $logTypes = $this->option('log-types');
        $excludeEvents = $this->option('exclude-events');

        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Activity Log Cleanup");
        $this->info("==================");
        $this->info("Cutoff Date: {$cutoffDate->format('Y-m-d H:i:s')}");
        $this->info("Retention Period: {$days} days");
        $this->info("Batch Size: {$batchSize}");
        $this->info("Dry Run: " . ($isDryRun ? 'Yes' : 'No'));

        // Build the query
        $query = Activity::where('created_at', '<', $cutoffDate);

        if ($logTypes) {
            $types = array_map('trim', explode(',', $logTypes));
            $query->whereIn('log_name', $types);
            $this->info("Log Types: " . implode(', ', $types));
        }

        if ($excludeEvents) {
            $events = array_map('trim', explode(',', $excludeEvents));
            $query->whereNotIn('event', $events);
            $this->info("Excluded Events: " . implode(', ', $events));
        }

        // Get total count
        $totalCount = $query->count();

        if ($totalCount === 0) {
            $this->info("No activity logs found matching the criteria.");
            return 0;
        }

        $this->info("Records to be processed: {$totalCount}");

        // Show breakdown by log type
        $this->showBreakdownByType($cutoffDate, $logTypes, $excludeEvents);

        if (!$isDryRun) {
            if (!$this->confirm("Are you sure you want to delete these {$totalCount} activity log records?")) {
                $this->info("Operation cancelled.");
                return 0;
            }
        }

        // Start cleanup process
        $this->info("\n" . ($isDryRun ? "Simulating" : "Starting") . " cleanup process...");

        $deletedCount = 0;
        $bar = $this->output->createProgressBar(ceil($totalCount / $batchSize));
        $bar->start();

        do {
            $batch = Activity::where('created_at', '<', $cutoffDate);

            if ($logTypes) {
                $types = array_map('trim', explode(',', $logTypes));
                $batch->whereIn('log_name', $types);
            }

            if ($excludeEvents) {
                $events = array_map('trim', explode(',', $excludeEvents));
                $batch->whereNotIn('event', $events);
            }

            $batchRecords = $batch->limit($batchSize)->get();

            if ($batchRecords->isEmpty()) {
                break;
            }

            if (!$isDryRun) {
                foreach ($batchRecords as $record) {
                    $record->delete();
                }
            }

            $deletedCount += $batchRecords->count();
            $bar->advance();

            // Small delay to prevent overwhelming the database
            usleep(10000); // 10ms

        } while (true);

        $bar->finish();

        $this->newLine(2);
        $this->info($isDryRun ?
            "Dry run completed. Would have deleted {$deletedCount} records." :
            "Cleanup completed successfully. Deleted {$deletedCount} records."
        );

        // Show updated statistics
        if (!$isDryRun) {
            $this->showCurrentStatistics();
        }

        return 0;
    }

    /**
     * Show breakdown by log type.
     */
    protected function showBreakdownByType(Carbon $cutoffDate, ?string $logTypes, ?string $excludeEvents): void
    {
        $this->info("\nBreakdown by log type:");
        $this->info("----------------------");

        $query = Activity::where('created_at', '<', $cutoffDate)
            ->selectRaw('log_name, COUNT(*) as count')
            ->groupBy('log_name')
            ->orderBy('count', 'desc');

        if ($logTypes) {
            $types = array_map('trim', explode(',', $logTypes));
            $query->whereIn('log_name', $types);
        }

        if ($excludeEvents) {
            $events = array_map('trim', explode(',', $excludeEvents));
            $query->whereNotIn('event', $events);
        }

        $breakdown = $query->get();

        $headers = ['Log Type', 'Count'];
        $rows = $breakdown->map(function ($item) {
            return [$item->log_name, number_format($item->count)];
        })->toArray();

        $this->table($headers, $rows);
    }

    /**
     * Show current activity log statistics.
     */
    protected function showCurrentStatistics(): void
    {
        $this->info("\nCurrent Activity Log Statistics:");
        $this->info("--------------------------------");

        $totalActivities = Activity::count();
        $todayActivities = Activity::whereDate('created_at', Carbon::today())->count();
        $thisWeekActivities = Activity::where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $thisMonthActivities = Activity::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        $this->info("Total Activities: " . number_format($totalActivities));
        $this->info("Today's Activities: " . number_format($todayActivities));
        $this->info("This Week's Activities: " . number_format($thisWeekActivities));
        $this->info("This Month's Activities: " . number_format($thisMonthActivities));

        // Show database size estimation
        $avgRecordSize = 1024; // Estimated average record size in bytes
        $estimatedSize = $totalActivities * $avgRecordSize;
        $this->info("Estimated Database Size: " . $this->formatBytes($estimatedSize));
    }

    /**
     * Format bytes to human readable format.
     */
    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }
}