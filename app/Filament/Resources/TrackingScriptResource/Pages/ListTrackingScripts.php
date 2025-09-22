<?php

namespace App\Filament\Resources\TrackingScriptResource\Pages;

use App\Filament\Resources\TrackingScriptResource;
use App\Services\TrackingScriptService;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class ListTrackingScripts extends ListRecords
{
    protected static string $resource = TrackingScriptResource::class;

    public function getTitle(): string
    {
        return 'Tracking Scripts';
    }

    public function getSubheading(): ?string
    {
        return 'Manage tracking scripts that will be automatically included on all live pages of your website. Scripts are executed in the order specified by the sort order.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('validate_all')
                ->label('Validate All Scripts')
                ->icon('heroicon-o-shield-check')
                ->color('info')
                ->action(function () {
                    $service = app(TrackingScriptService::class);
                    $results = $service->validateAllScripts();
                    
                    $validCount = collect($results)->where('is_valid', true)->count();
                    $totalCount = count($results);
                    $invalidCount = $totalCount - $validCount;
                    
                    if ($invalidCount === 0) {
                        Notification::make()
                            ->title('All Scripts Valid')
                            ->body("All {$totalCount} tracking scripts passed validation.")
                            ->success()
                            ->send();
                    } else {
                        $invalidScripts = collect($results)
                            ->where('is_valid', false)
                            ->pluck('script_name')
                            ->join(', ');
                            
                        Notification::make()
                            ->title('Validation Issues Found')
                            ->body("{$invalidCount} of {$totalCount} scripts failed validation: {$invalidScripts}")
                            ->warning()
                            ->send();
                    }
                }),
            Actions\Action::make('clear_cache')
                ->label('Clear Cache')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->action(function () {
                    app(TrackingScriptService::class)->clearCache();
                    Notification::make()
                        ->title('Cache Cleared')
                        ->body('All tracking scripts cache has been cleared.')
                        ->success()
                        ->send();
                }),
            Actions\Action::make('view_stats')
                ->label('View Statistics')
                ->icon('heroicon-o-chart-bar')
                ->color('gray')
                ->action(function () {
                    $service = app(TrackingScriptService::class);
                    $stats = $service->getScriptStats();
                    
                    $message = "Total Scripts: {$stats['total_scripts']}\n";
                    $message .= "Active: {$stats['active_scripts']}, Inactive: {$stats['inactive_scripts']}\n";
                    
                    if (!empty($stats['scripts_by_type'])) {
                        $message .= "\nBy Type:\n";
                        foreach ($stats['scripts_by_type'] as $type => $count) {
                            $message .= "- {$type}: {$count}\n";
                        }
                    }
                    
                    Notification::make()
                        ->title('Script Statistics')
                        ->body($message)
                        ->info()
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }
}
