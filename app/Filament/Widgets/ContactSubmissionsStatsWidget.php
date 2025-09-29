<?php

namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class ContactSubmissionsStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $yesterday = Carbon::yesterday();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Today's submissions
        $todayCount = ContactSubmission::whereDate('created_at', $today)->count();
        $yesterdayCount = ContactSubmission::whereDate('created_at', $yesterday)->count();
        $todayChange = $yesterdayCount > 0
            ? round((($todayCount - $yesterdayCount) / $yesterdayCount) * 100, 1)
            : ($todayCount > 0 ? 100 : 0);

        // This week's submissions
        $weekCount = ContactSubmission::where('created_at', '>=', $startOfWeek)->count();
        $lastWeekCount = ContactSubmission::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();
        $weekChange = $lastWeekCount > 0
            ? round((($weekCount - $lastWeekCount) / $lastWeekCount) * 100, 1)
            : ($weekCount > 0 ? 100 : 0);

        // This month's submissions
        $monthCount = ContactSubmission::where('created_at', '>=', $startOfMonth)->count();
        $lastMonthCount = ContactSubmission::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $monthChange = $lastMonthCount > 0
            ? round((($monthCount - $lastMonthCount) / $lastMonthCount) * 100, 1)
            : ($monthCount > 0 ? 100 : 0);

        // Unread submissions
        $unreadCount = ContactSubmission::where('is_read', false)->count();

        return [
            Stat::make('Today\'s Submissions', $todayCount)
                ->description($this->getChangeDescription($todayChange, 'yesterday'))
                ->descriptionIcon($this->getChangeIcon($todayChange))
                ->color($this->getChangeColor($todayChange))
                ->chart($this->getHourlyChart()),

            Stat::make('This Week', $weekCount)
                ->description($this->getChangeDescription($weekChange, 'last week'))
                ->descriptionIcon($this->getChangeIcon($weekChange))
                ->color($this->getChangeColor($weekChange))
                ->chart($this->getDailyChart()),

            Stat::make('This Month', $monthCount)
                ->description($this->getChangeDescription($monthChange, 'last month'))
                ->descriptionIcon($this->getChangeIcon($monthChange))
                ->color($this->getChangeColor($monthChange))
                ->chart($this->getWeeklyChart()),

            Stat::make('Unread', $unreadCount)
                ->description('Awaiting response')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unreadCount > 0 ? 'warning' : 'success')
                ->url(route('filament.admin.resources.contact-submissions.index') . '?tableFilters[is_read][value]=0'),
        ];
    }

    protected function getChangeDescription(float $change, string $period): string
    {
        if ($change > 0) {
            return "{$change}% increase from {$period}";
        } elseif ($change < 0) {
            return abs($change) . "% decrease from {$period}";
        }
        return "Same as {$period}";
    }

    protected function getChangeIcon(float $change): string
    {
        if ($change > 0) {
            return 'heroicon-m-arrow-trending-up';
        } elseif ($change < 0) {
            return 'heroicon-m-arrow-trending-down';
        }
        return 'heroicon-m-minus';
    }

    protected function getChangeColor(float $change): string
    {
        if ($change > 0) {
            return 'success';
        } elseif ($change < 0) {
            return 'danger';
        }
        return 'gray';
    }

    protected function getHourlyChart(): array
    {
        $data = [];
        for ($i = 23; $i >= 0; $i--) {
            $hour = Carbon::now()->subHours($i);
            $data[] = ContactSubmission::whereBetween('created_at', [
                $hour->copy()->startOfHour(),
                $hour->copy()->endOfHour()
            ])->count();
        }
        return $data;
    }

    protected function getDailyChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $data[] = ContactSubmission::whereDate('created_at', $day)->count();
        }
        return $data;
    }

    protected function getWeeklyChart(): array
    {
        $data = [];
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
            $data[] = ContactSubmission::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        }
        return $data;
    }
}