<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\ContactSubmissionsStatsWidget;
use App\Filament\Widgets\RecentContactSubmissionsWidget;
use App\Filament\Widgets\ServicePopularityWidget;
use App\Filament\Widgets\SystemHealthWidget;
use App\Filament\Widgets\QuickStatsOverview;
use App\Filament\Widgets\RecentActivityWidget;

class Dashboard extends BaseDashboard
{
    protected static ?int $navigationSort = -2;

    public function getHeading(): string
    {
        return 'Dashboard Analytics';
    }

    public function getSubheading(): ?string
    {
        return 'Monitor your business performance and system health';
    }

    public function getColumns(): int | array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'lg' => 4,
        ];
    }

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            QuickStatsOverview::class,
            ContactSubmissionsStatsWidget::class,
            SystemHealthWidget::class,
            RecentContactSubmissionsWidget::class,
            ServicePopularityWidget::class,
            RecentActivityWidget::class,
        ];
    }
}