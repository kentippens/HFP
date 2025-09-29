<?php

namespace App\Filament\Resources\ActivityLogResource\Widgets;

use App\Models\Activity;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class ActivityLogStats extends BaseWidget
{
    protected function getStats(): array
    {
        $todayActivities = Activity::today()->count();
        $weekActivities = Activity::thisWeek()->count();
        $failedLogins = Activity::today()->where('event', 'failed_login')->count();
        $uniqueUsers = Activity::today()
            ->whereNotNull('causer_id')
            ->distinct('causer_id')
            ->count('causer_id');

        return [
            Stat::make('Today\'s Activities', $todayActivities)
                ->description($this->getTrend($todayActivities, 'daily'))
                ->descriptionIcon($this->getTrendIcon($todayActivities, 'daily'))
                ->color($todayActivities > 0 ? 'success' : 'gray')
                ->chart($this->getDailyChart()),

            Stat::make('This Week', $weekActivities)
                ->description($this->getTrend($weekActivities, 'weekly'))
                ->descriptionIcon($this->getTrendIcon($weekActivities, 'weekly'))
                ->color('info')
                ->chart($this->getWeeklyChart()),

            Stat::make('Failed Logins Today', $failedLogins)
                ->description($failedLogins > 0 ? 'Requires attention' : 'All secure')
                ->descriptionIcon($failedLogins > 0 ? 'heroicon-m-shield-exclamation' : 'heroicon-m-shield-check')
                ->color($failedLogins > 0 ? 'danger' : 'success'),

            Stat::make('Active Users Today', $uniqueUsers)
                ->description('Unique users with activities')
                ->descriptionIcon('heroicon-m-users')
                ->color($uniqueUsers > 0 ? 'primary' : 'gray'),
        ];
    }

    protected function getTrend($current, $period): string
    {
        if ($period === 'daily') {
            $yesterday = Activity::whereDate('created_at', Carbon::yesterday())->count();
            $diff = $current - $yesterday;
        } else {
            $lastWeek = Activity::whereBetween('created_at', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek(),
            ])->count();
            $diff = $current - $lastWeek;
        }

        if ($diff > 0) {
            return "+{$diff} from " . ($period === 'daily' ? 'yesterday' : 'last week');
        } elseif ($diff < 0) {
            return "{$diff} from " . ($period === 'daily' ? 'yesterday' : 'last week');
        }

        return 'No change from ' . ($period === 'daily' ? 'yesterday' : 'last week');
    }

    protected function getTrendIcon($current, $period): string
    {
        if ($period === 'daily') {
            $yesterday = Activity::whereDate('created_at', Carbon::yesterday())->count();
            $diff = $current - $yesterday;
        } else {
            $lastWeek = Activity::whereBetween('created_at', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek(),
            ])->count();
            $diff = $current - $lastWeek;
        }

        if ($diff > 0) {
            return 'heroicon-m-arrow-trending-up';
        } elseif ($diff < 0) {
            return 'heroicon-m-arrow-trending-down';
        }

        return 'heroicon-m-minus';
    }

    protected function getDailyChart(): array
    {
        $data = [];
        for ($i = 23; $i >= 0; $i--) {
            $hour = Carbon::now()->subHours($i);
            $data[] = Activity::whereRaw('HOUR(created_at) = ?', [$hour->hour])
                ->whereDate('created_at', $hour->toDateString())
                ->count();
        }
        return $data;
    }

    protected function getWeeklyChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $data[] = Activity::whereDate('created_at', $date)->count();
        }
        return $data;
    }
}