<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Scheduled Export Commands
app(Schedule::class)->command('export:scheduled contacts --period=week --storage=local')
    ->weekly()
    ->mondays()
    ->at('09:00')
    ->emailOutputTo('admin@hexagonservicesolutions.com')
    ->onFailure(function () {
        // Log failure or send notification
        \Log::error('Weekly contact submissions export failed');
    });

app(Schedule::class)->command('export:scheduled all --period=month --storage=local')
    ->monthly()
    ->at('08:00')
    ->emailOutputTo('admin@hexagonservicesolutions.com')
    ->onSuccess(function () {
        \Log::info('Monthly full export completed successfully');
    });

app(Schedule::class)->command('export:scheduled services --period=all --storage=local')
    ->daily()
    ->at('23:30')
    ->when(function () {
        // Only run if services were updated today
        return \App\Models\Service::whereDate('updated_at', today())->exists();
    });

app(Schedule::class)->command('export:scheduled users --period=week --storage=local')
    ->weekly()
    ->fridays()
    ->at('17:00')
    ->appendOutputTo(storage_path('logs/exports.log'));

// Activity Log Cleanup
app(Schedule::class)->command('logs:clear --days=90')
    ->monthly()
    ->at('03:00')
    ->onSuccess(function () {
        \Log::info('Monthly activity log cleanup completed');
    })
    ->onFailure(function () {
        \Log::error('Activity log cleanup failed');
    });

// Aggressive cleanup for specific log types (daily)
app(Schedule::class)->command('logs:clear --days=7 --type=page_view')
    ->daily()
    ->at('02:00');

app(Schedule::class)->command('logs:clear --days=30 --type=api_request')
    ->weekly()
    ->sundays()
    ->at('02:30');
