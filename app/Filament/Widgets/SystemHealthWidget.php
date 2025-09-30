<?php

namespace App\Filament\Widgets;

use App\Models\Service;
use App\Models\BlogPost;
use App\Models\User;
use App\Models\ContactSubmission;
use App\Traits\HandlesWidgetErrors;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SystemHealthWidget extends BaseWidget
{
    use HandlesWidgetErrors;

    protected static ?int $sort = 4;

    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        return $this->measureOperation('getSystemHealthStats', function () {
            return [
                $this->getDatabaseHealthStat(),
                $this->getCacheHealthStat(),
                $this->getContentHealthStat(),
                $this->getUserActivityStat(),
            ];
        });
    }

    protected function getDatabaseHealthStat(): Stat
    {
        return $this->safeStat('Database Health', function () {
            return $this->getCachedStat('db_health', function () {
                $startTime = microtime(true);
                $this->safeQuery(fn() => DB::select('SELECT 1'));
                $responseTime = round((microtime(true) - $startTime) * 1000, 2);

                // Get database size with error handling
                $dbSize = $this->safeQuery(fn() => $this->getDatabaseSize(), null, 0, 'N/A');

                // Get table counts with error handling
                $totalRecords = $this->safeQuery(function () {
                    return ContactSubmission::count() +
                           Service::count() +
                           BlogPost::count() +
                           User::count();
                }, null, 0, 0);

                $status = $responseTime < 50 ? 'success' : ($responseTime < 200 ? 'warning' : 'danger');
                $statusText = $responseTime < 50 ? 'Healthy' : ($responseTime < 200 ? 'Slow' : 'Critical');

                return $statusText;
            }, 60);
        }, [
            'description' => function () {
                $responseTime = $this->getCachedStat('db_response_time', function () {
                    $startTime = microtime(true);
                    $this->safeQuery(fn() => DB::select('SELECT 1'));
                    return round((microtime(true) - $startTime) * 1000, 2);
                }, 30);

                $dbSize = $this->getCachedStat('db_size', fn() => $this->getDatabaseSize(), 300);
                $totalRecords = $this->getCachedStat('total_records', function () {
                    return $this->safeQuery(function () {
                        return ContactSubmission::count() + Service::count() + BlogPost::count() + User::count();
                    }, null, 0, 0);
                }, 120);

                return "{$responseTime}ms response | {$dbSize} | {$totalRecords} records";
            },
            'descriptionIcon' => function () {
                $responseTime = $this->getCachedStat('db_response_time_icon', function () {
                    $startTime = microtime(true);
                    $this->safeQuery(fn() => DB::select('SELECT 1'));
                    return round((microtime(true) - $startTime) * 1000, 2);
                }, 30);
                return $responseTime < 50 ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle';
            },
            'color' => function () {
                $responseTime = $this->getCachedStat('db_response_time_color', function () {
                    $startTime = microtime(true);
                    $this->safeQuery(fn() => DB::select('SELECT 1'));
                    return round((microtime(true) - $startTime) * 1000, 2);
                }, 30);
                return $responseTime < 50 ? 'success' : ($responseTime < 200 ? 'warning' : 'danger');
            },
            'chart' => fn() => $this->safeChart(fn() => $this->getResponseTimeChart())
        ]);
    }

    protected function getCacheHealthStat(): Stat
    {
        return $this->safeStat('Cache System', function () {
            return $this->safeQuery(function () {
                $cacheKey = 'health_check_' . time();
                Cache::put($cacheKey, true, 1);
                $cacheWorking = Cache::get($cacheKey) === true;
                Cache::forget($cacheKey);
                return $cacheWorking ? 'Operational' : 'Issues Detected';
            }, null, 0, 'Error');
        }, [
            'description' => function () {
                $cacheDriver = config('cache.default');
                $hitRate = $this->safeQuery(function () {
                    $cacheHits = Cache::get('cache_hits', 0);
                    $cacheMisses = Cache::get('cache_misses', 0);
                    return $cacheHits + $cacheMisses > 0
                        ? round(($cacheHits / ($cacheHits + $cacheMisses)) * 100, 1)
                        : 0;
                }, null, 0, 0);
                return "Driver: {$cacheDriver} | Hit rate: {$hitRate}%";
            },
            'descriptionIcon' => function () {
                $working = $this->safeQuery(function () {
                    $cacheKey = 'health_check_icon_' . time();
                    Cache::put($cacheKey, true, 1);
                    $result = Cache::get($cacheKey) === true;
                    Cache::forget($cacheKey);
                    return $result;
                }, null, 0, false);
                return $working ? 'heroicon-m-bolt' : 'heroicon-m-exclamation-triangle';
            },
            'color' => function () {
                $working = $this->safeQuery(function () {
                    $cacheKey = 'health_check_color_' . time();
                    Cache::put($cacheKey, true, 1);
                    $result = Cache::get($cacheKey) === true;
                    Cache::forget($cacheKey);
                    return $result;
                }, null, 0, false);
                return $working ? 'success' : 'danger';
            }
        ]);
    }

    protected function getContentHealthStat(): Stat
    {
        return $this->getCachedStat('content_health', function () {
            // Check for content issues with error handling
            $activeServices = $this->safeQuery(fn() => Service::where('is_active', true)->count(), null, 0, 0);
            $totalServices = $this->safeQuery(fn() => Service::count(), null, 0, 0);
            $publishedPosts = $this->safeQuery(fn() => BlogPost::where('is_published', true)->count(), null, 0, 0);
            $totalPosts = $this->safeQuery(fn() => BlogPost::count(), null, 0, 0);

            // Check for missing SEO data with error handling
            $servicesWithoutSEO = $this->safeQuery(function () {
                return Service::where('is_active', true)
                    ->where(function ($query) {
                        $query->whereNull('meta_title')
                              ->orWhereNull('meta_description');
                    })->count();
            }, null, 0, 0);

            $postsWithoutSEO = $this->safeQuery(function () {
                return BlogPost::where('is_published', true)
                    ->where(function ($query) {
                        $query->whereNull('meta_title')
                              ->orWhereNull('meta_description');
                    })->count();
            }, null, 0, 0);

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
        }, 600); // Cache for 10 minutes
    }

    protected function getUserActivityStat(): Stat
    {
        return $this->getCachedStat('user_activity', function () {
            $activeUsers = $this->safeQuery(fn() => User::where('last_login_at', '>=', Carbon::now()->subDays(7))->count(), null, 0, 0);
            $totalUsers = $this->safeQuery(fn() => User::count(), null, 0, 0);
            $lockedUsers = $this->safeQuery(fn() => User::where('locked_until', '>', now())->count(), null, 0, 0);
            $failedLogins = $this->safeQuery(function () {
                return User::where('failed_login_attempts', '>', 0)->sum('failed_login_attempts');
            }, null, 0, 0);

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
                ->chart($this->safeChart(fn() => $this->getUserActivityChart()));
        }, 300); // Cache for 5 minutes
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
        return $this->getCachedStat('user_activity_chart', function () {
            $data = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $data[] = $this->safeQuery(fn() => User::whereDate('last_login_at', $date)->count(), null, 0, 0);
            }
            return $data;
        }, 1800); // Cache for 30 minutes
    }
}