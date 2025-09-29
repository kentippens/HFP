<?php

namespace App\Filament\Widgets;

use App\Models\Service;
use App\Models\BlogPost;
use App\Models\User;
use App\Models\ContactSubmission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SystemHealthWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        return [
            $this->getDatabaseHealthStat(),
            $this->getCacheHealthStat(),
            $this->getContentHealthStat(),
            $this->getUserActivityStat(),
        ];
    }

    protected function getDatabaseHealthStat(): Stat
    {
        try {
            $startTime = microtime(true);
            DB::select('SELECT 1');
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);

            // Get database size
            $dbSize = $this->getDatabaseSize();

            // Get table counts
            $totalRecords = ContactSubmission::count() +
                           Service::count() +
                           BlogPost::count() +
                           User::count();

            $status = $responseTime < 50 ? 'success' : ($responseTime < 200 ? 'warning' : 'danger');
            $statusText = $responseTime < 50 ? 'Healthy' : ($responseTime < 200 ? 'Slow' : 'Critical');

            return Stat::make('Database Health', $statusText)
                ->description("{$responseTime}ms response | {$dbSize} | {$totalRecords} records")
                ->descriptionIcon($status === 'success' ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle')
                ->color($status)
                ->chart($this->getResponseTimeChart());
        } catch (\Exception $e) {
            return Stat::make('Database Health', 'Error')
                ->description('Database connection failed')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger');
        }
    }

    protected function getCacheHealthStat(): Stat
    {
        try {
            $cacheKey = 'health_check_' . time();
            Cache::put($cacheKey, true, 1);
            $cacheWorking = Cache::get($cacheKey) === true;
            Cache::forget($cacheKey);

            // Get cache stats if available
            $cacheDriver = config('cache.default');
            $cacheHits = Cache::get('cache_hits', 0);
            $cacheMisses = Cache::get('cache_misses', 0);
            $hitRate = $cacheHits + $cacheMisses > 0
                ? round(($cacheHits / ($cacheHits + $cacheMisses)) * 100, 1)
                : 0;

            if ($cacheWorking) {
                return Stat::make('Cache System', 'Operational')
                    ->description("Driver: {$cacheDriver} | Hit rate: {$hitRate}%")
                    ->descriptionIcon('heroicon-m-bolt')
                    ->color('success');
            } else {
                return Stat::make('Cache System', 'Issues Detected')
                    ->description("Driver: {$cacheDriver} | Check configuration")
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('warning');
            }
        } catch (\Exception $e) {
            return Stat::make('Cache System', 'Error')
                ->description('Cache system not responding')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger');
        }
    }

    protected function getContentHealthStat(): Stat
    {
        // Check for content issues
        $activeServices = Service::where('is_active', true)->count();
        $totalServices = Service::count();
        $publishedPosts = BlogPost::where('is_published', true)->count();
        $totalPosts = BlogPost::count();

        // Check for missing SEO data
        $servicesWithoutSEO = Service::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('meta_title')
                      ->orWhereNull('meta_description');
            })->count();

        $postsWithoutSEO = BlogPost::where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('meta_title')
                      ->orWhereNull('meta_description');
            })->count();

        $seoIssues = $servicesWithoutSEO + $postsWithoutSEO;

        if ($seoIssues > 0) {
            return Stat::make('Content Health', "{$seoIssues} SEO Issues")
                ->description("{$activeServices}/{$totalServices} services | {$publishedPosts}/{$totalPosts} posts")
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning')
                ->url(route('filament.admin.resources.services.index'));
        }

        return Stat::make('Content Health', 'All Good')
            ->description("{$activeServices} active services | {$publishedPosts} published posts")
            ->descriptionIcon('heroicon-m-check-circle')
            ->color('success');
    }

    protected function getUserActivityStat(): Stat
    {
        $activeUsers = User::where('last_login_at', '>=', Carbon::now()->subDays(7))->count();
        $totalUsers = User::count();
        $lockedUsers = User::where('locked_until', '>', now())->count();
        $failedLogins = User::where('failed_login_attempts', '>', 0)
            ->sum('failed_login_attempts');

        $status = 'success';
        $description = "{$activeUsers}/{$totalUsers} active this week";

        if ($lockedUsers > 0) {
            $status = 'warning';
            $description .= " | {$lockedUsers} locked";
        }

        if ($failedLogins > 10) {
            $status = 'danger';
            $description .= " | {$failedLogins} failed logins";
        }

        return Stat::make('User Activity', "{$activeUsers} Active Users")
            ->description($description)
            ->descriptionIcon($status === 'success' ? 'heroicon-m-users' : 'heroicon-m-shield-exclamation')
            ->color($status)
            ->chart($this->getUserActivityChart());
    }

    protected function getDatabaseSize(): string
    {
        try {
            $result = DB::select("
                SELECT
                    table_schema AS 'database',
                    SUM(data_length + index_length) / 1024 / 1024 AS 'size_mb'
                FROM information_schema.tables
                WHERE table_schema = ?
                GROUP BY table_schema
            ", [config('database.connections.mysql.database')]);

            if (!empty($result)) {
                $sizeMB = round($result[0]->size_mb, 2);
                if ($sizeMB > 1024) {
                    return round($sizeMB / 1024, 2) . ' GB';
                }
                return $sizeMB . ' MB';
            }
        } catch (\Exception $e) {
            // Fallback for permission issues
        }

        return 'N/A';
    }

    protected function getResponseTimeChart(): array
    {
        // Simulate response time data (in production, you'd track this)
        $data = [];
        for ($i = 0; $i < 7; $i++) {
            $data[] = rand(10, 100);
        }
        return $data;
    }

    protected function getUserActivityChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $data[] = User::whereDate('last_login_at', $date)->count();
        }
        return $data;
    }
}