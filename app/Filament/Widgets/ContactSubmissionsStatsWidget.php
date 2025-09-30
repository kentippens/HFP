<?php

namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use App\Traits\HandlesWidgetErrors;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class ContactSubmissionsStatsWidget extends BaseWidget
{
    use HandlesWidgetErrors;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return $this->measureOperation('getStats', function () {
            $today = Carbon::today();
            $startOfWeek = Carbon::now()->startOfWeek();
            $startOfMonth = Carbon::now()->startOfMonth();
            $yesterday = Carbon::yesterday();
            $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
            $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
            $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
            $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

            // Today's submissions with caching and error handling
            $todayCount = $this->getCachedStat('today_count', function () use ($today) {
                return ContactSubmission::whereDate('created_at', $today)->count();
            }, 300);

            $yesterdayCount = $this->getCachedStat('yesterday_count', function () use ($yesterday) {
                return ContactSubmission::whereDate('created_at', $yesterday)->count();
            }, 3600);

            $todayChange = $this->safePercentageChange($todayCount, $yesterdayCount);

            // This week's submissions with caching
            $weekCount = $this->getCachedStat('week_count', function () use ($startOfWeek) {
                return ContactSubmission::where('created_at', '>=', $startOfWeek)->count();
            }, 600);

            $lastWeekCount = $this->getCachedStat('last_week_count', function () use ($lastWeekStart, $lastWeekEnd) {
                return ContactSubmission::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();
            }, 3600);

            $weekChange = $this->safePercentageChange($weekCount, $lastWeekCount);

            // This month's submissions with caching
            $monthCount = $this->getCachedStat('month_count', function () use ($startOfMonth) {
                return ContactSubmission::where('created_at', '>=', $startOfMonth)->count();
            }, 1800);

            $lastMonthCount = $this->getCachedStat('last_month_count', function () use ($lastMonthStart, $lastMonthEnd) {
                return ContactSubmission::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
            }, 7200);

            $monthChange = $this->safePercentageChange($monthCount, $lastMonthCount);

            // Unread submissions (short cache for real-time updates)
            $unreadCount = $this->getCachedStat('unread_count', function () {
                return ContactSubmission::where('is_read', false)->count();
            }, 60);

            return [
                $this->safeStat('Today\'s Submissions', fn() => $todayCount, [
                    'description' => $this->getChangeDescription($todayChange, 'yesterday'),
                    'descriptionIcon' => $this->getChangeIcon($todayChange),
                    'color' => $this->getChangeColor($todayChange),
                    'chart' => $this->safeChart(fn() => $this->getHourlyChart())
                ]),

                $this->safeStat('This Week', fn() => $weekCount, [
                    'description' => $this->getChangeDescription($weekChange, 'last week'),
                    'descriptionIcon' => $this->getChangeIcon($weekChange),
                    'color' => $this->getChangeColor($weekChange),
                    'chart' => $this->safeChart(fn() => $this->getDailyChart())
                ]),

                $this->safeStat('This Month', fn() => $monthCount, [
                    'description' => $this->getChangeDescription($monthChange, 'last month'),
                    'descriptionIcon' => $this->getChangeIcon($monthChange),
                    'color' => $this->getChangeColor($monthChange),
                    'chart' => $this->safeChart(fn() => $this->getWeeklyChart())
                ]),

                $this->safeStat('Unread', fn() => $unreadCount, [
                    'description' => 'Awaiting response',
                    'descriptionIcon' => 'heroicon-m-envelope',
                    'color' => $unreadCount > 0 ? 'warning' : 'success',
                    'url' => route('filament.admin.resources.contact-submissions.index') . '?tableFilters[is_read][value]=0'
                ]),
            ];
        });
    }


    protected function getHourlyChart(): array
    {
        return $this->getCachedStat('hourly_chart', function () {
            $data = [];
            for ($i = 23; $i >= 0; $i--) {
                $hour = Carbon::now()->subHours($i);
                $data[] = $this->safeQuery(function () use ($hour) {
                    return ContactSubmission::whereBetween('created_at', [
                        $hour->copy()->startOfHour(),
                        $hour->copy()->endOfHour()
                    ])->count();
                });
            }
            return $data;
        }, 300);
    }

    protected function getDailyChart(): array
    {
        return $this->getCachedStat('daily_chart', function () {
            $data = [];
            for ($i = 6; $i >= 0; $i--) {
                $day = Carbon::today()->subDays($i);
                $data[] = $this->safeQuery(function () use ($day) {
                    return ContactSubmission::whereDate('created_at', $day)->count();
                });
            }
            return $data;
        }, 600);
    }

    protected function getWeeklyChart(): array
    {
        return $this->getCachedStat('weekly_chart', function () {
            $data = [];
            for ($i = 3; $i >= 0; $i--) {
                $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
                $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
                $data[] = $this->safeQuery(function () use ($weekStart, $weekEnd) {
                    return ContactSubmission::whereBetween('created_at', [$weekStart, $weekEnd])->count();
                });
            }
            return $data;
        }, 1800);
    }
}