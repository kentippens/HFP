<?php

namespace App\Filament\Widgets;

use App\Models\Service;
use App\Models\BlogPost;
use App\Models\CorePage;
use App\Models\LandingPage;
use App\Traits\HandlesWidgetErrors;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuickStatsOverview extends BaseWidget
{
    use HandlesWidgetErrors;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        return $this->measureOperation('getQuickStats', function () {
            return [
                $this->safeStat('Active Services', function () {
                    return $this->getCachedStat('active_services', function () {
                        return $this->safeQuery(fn() => Service::where('is_active', true)->count(), null, 0, 0);
                    }, 600); // Cache for 10 minutes
                }, [
                    'description' => function () {
                        $totalServices = $this->getCachedStat('total_services', function () {
                            return $this->safeQuery(fn() => Service::count(), null, 0, 0);
                        }, 1800); // Cache for 30 minutes
                        return 'Total: ' . $totalServices;
                    },
                    'descriptionIcon' => 'heroicon-m-wrench-screwdriver',
                    'color' => 'success',
                    'url' => function() {
                        try {
                            return route('filament.admin.resources.services.index');
                        } catch (\Exception $e) {
                            return null;
                        }
                    }
                ]),

                $this->safeStat('Published Posts', function () {
                    return $this->getCachedStat('published_posts', function () {
                        return $this->safeQuery(fn() => BlogPost::where('is_published', true)->count(), null, 0, 0);
                    }, 600); // Cache for 10 minutes
                }, [
                    'description' => function () {
                        $drafts = $this->getCachedStat('draft_posts', function () {
                            return $this->safeQuery(fn() => BlogPost::where('is_published', false)->count(), null, 0, 0);
                        }, 600);
                        return 'Drafts: ' . $drafts;
                    },
                    'descriptionIcon' => 'heroicon-m-document-text',
                    'color' => 'primary',
                    'url' => function() {
                        try {
                            return route('filament.admin.resources.blog-posts.index');
                        } catch (\Exception $e) {
                            return null;
                        }
                    }
                ]),

                $this->safeStat('Active Pages', function () {
                    return $this->getCachedStat('active_pages', function () {
                        $corePages = $this->safeQuery(fn() => CorePage::where('is_active', true)->count(), null, 0, 0);
                        $landingPages = $this->safeQuery(fn() => LandingPage::where('is_active', true)->count(), null, 0, 0);
                        return $corePages + $landingPages;
                    }, 600); // Cache for 10 minutes
                }, [
                    'description' => function () {
                        $corePages = $this->getCachedStat('active_core_pages', function () {
                            return $this->safeQuery(fn() => CorePage::where('is_active', true)->count(), null, 0, 0);
                        }, 600);
                        $landingPages = $this->getCachedStat('active_landing_pages', function () {
                            return $this->safeQuery(fn() => LandingPage::where('is_active', true)->count(), null, 0, 0);
                        }, 600);
                        return "Core: {$corePages} | Landing: {$landingPages}";
                    },
                    'descriptionIcon' => 'heroicon-m-document-duplicate',
                    'color' => 'warning',
                    'url' => function() {
                        try {
                            return route('filament.admin.resources.core-pages.index');
                        } catch (\Exception $e) {
                            return null;
                        }
                    }
                ]),
            ];
        });
    }
}