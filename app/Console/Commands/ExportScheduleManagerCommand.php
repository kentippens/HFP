<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ExportScheduleManagerCommand extends Command
{
    protected $signature = 'export:manage
                          {action : Action to perform (status|cleanup|test)}
                          {--model= : Specific model to manage}
                          {--days= : Days for cleanup (default: 30)}';

    protected $description = 'Manage scheduled export operations';

    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'status':
                $this->showStatus();
                break;
            case 'cleanup':
                $this->cleanupOldExports();
                break;
            case 'test':
                $this->testExports();
                break;
            default:
                $this->error("Unknown action: {$action}");
                $this->info("Available actions: status, cleanup, test");
                return 1;
        }

        return 0;
    }

    protected function showStatus()
    {
        $this->info('📊 Export Schedule Status');
        $this->line('========================');

        // Show scheduled tasks
        $this->call('schedule:list');

        // Show recent export files
        $this->line('');
        $this->info('📁 Recent Export Files:');
        $files = collect(Storage::disk('local')->allFiles())
            ->filter(fn($file) => str_ends_with($file, '.csv'))
            ->sort()
            ->take(10);

        if ($files->isEmpty()) {
            $this->line('   No export files found');
        } else {
            foreach ($files as $file) {
                $size = Storage::disk('local')->size($file);
                $modified = Storage::disk('local')->lastModified($file);
                $this->line("   {$file} (" . $this->formatBytes($size) . ") - " . Carbon::createFromTimestamp($modified)->diffForHumans());
            }
        }

        // Show disk usage
        $this->line('');
        $this->info('💾 Storage Usage:');
        $totalSize = collect(Storage::disk('local')->allFiles())
            ->filter(fn($file) => str_ends_with($file, '.csv'))
            ->sum(fn($file) => Storage::disk('local')->size($file));

        $this->line("   Total CSV files: " . $this->formatBytes($totalSize));
    }

    protected function cleanupOldExports()
    {
        $days = $this->option('days') ?? 30;
        $cutoff = Carbon::now()->subDays($days);

        $this->info("🧹 Cleaning up export files older than {$days} days...");

        $files = collect(Storage::disk('local')->allFiles())
            ->filter(fn($file) => str_ends_with($file, '.csv'))
            ->filter(function ($file) use ($cutoff) {
                $modified = Storage::disk('local')->lastModified($file);
                return Carbon::createFromTimestamp($modified)->lt($cutoff);
            });

        if ($files->isEmpty()) {
            $this->info('   No old files to clean up');
            return;
        }

        $totalSize = $files->sum(fn($file) => Storage::disk('local')->size($file));

        if ($this->confirm("Delete {$files->count()} files (" . $this->formatBytes($totalSize) . ")?")) {
            foreach ($files as $file) {
                Storage::disk('local')->delete($file);
                $this->line("   Deleted: {$file}");
            }

            $this->info("✅ Cleaned up {$files->count()} files, freed " . $this->formatBytes($totalSize));
        } else {
            $this->info('Cleanup cancelled');
        }
    }

    protected function testExports()
    {
        $this->info('🧪 Testing Export Commands');
        $this->line('=========================');

        $models = ['contacts', 'services', 'users'];
        $model = $this->option('model');

        if ($model) {
            $models = [$model];
        }

        foreach ($models as $modelName) {
            $this->line('');
            $this->info("Testing {$modelName} export...");

            $exitCode = $this->call('export:scheduled', [
                'model' => $modelName,
                '--period' => 'all',
                '--storage' => 'local'
            ]);

            if ($exitCode === 0) {
                $this->info("✅ {$modelName} export successful");
            } else {
                $this->error("❌ {$modelName} export failed");
            }
        }
    }

    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}