<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\CheckPasswordExpiration;
use App\Http\Middleware\HandleFilamentErrors;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\ContactSubmissionsStatsWidget;
use App\Filament\Widgets\RecentContactSubmissionsWidget;
use App\Filament\Widgets\ServicePopularityWidget;
use App\Filament\Widgets\SystemHealthWidget;
use App\Filament\Widgets\QuickStatsOverview;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->brandName('HexServices Admin')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
                EditProfile::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Dashboard widgets
                QuickStatsOverview::class,
                ContactSubmissionsStatsWidget::class,
                SystemHealthWidget::class,
                RecentContactSubmissionsWidget::class,
                ServicePopularityWidget::class,
                // Default widgets
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                HandleFilamentErrors::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                CheckPasswordExpiration::class,
            ])
            // Production security settings
            ->passwordReset()
            ->emailVerification()
            ->maxContentWidth('7xl')
            ->sidebarCollapsibleOnDesktop()
            ->unsavedChangesAlerts()
            ->databaseNotifications()
            ->brandLogo(asset('images/logo/HFP-Logo-SQ.svg'))
            ->favicon(asset('favicon.ico'))
            ->navigationGroups([
                'Dashboard & Analytics',
                'Customer Relations',
                'Content Management',
                'SEO & Marketing',
                'User Management',
                'System Configuration',
            ])
            ->collapsibleNavigationGroups(true);
    }
}
