<?php

namespace App\Filament\Widgets;

use App\Models\Service;
use App\Models\BlogPost;
use App\Models\CorePage;
use App\Models\LandingPage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuickStatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        return [
            Stat::make('Active Services', Service::where('is_active', true)->count())
                ->description('Total: ' . Service::count())
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('success')
                ->url(route('filament.admin.resources.services.index')),

            Stat::make('Published Posts', BlogPost::where('is_published', true)->count())
                ->description('Drafts: ' . BlogPost::where('is_published', false)->count())
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->url(route('filament.admin.resources.blog-posts.index')),

            Stat::make('Active Pages',
                CorePage::where('is_active', true)->count() +
                LandingPage::where('is_active', true)->count()
            )
                ->description('Core: ' . CorePage::where('is_active', true)->count() .
                             ' | Landing: ' . LandingPage::where('is_active', true)->count())
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('warning')
                ->url(route('filament.admin.resources.core-pages.index')),
        ];
    }
}