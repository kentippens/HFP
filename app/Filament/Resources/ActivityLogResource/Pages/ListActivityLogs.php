<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use App\Models\Activity;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('clearLogs')
                ->label('Clear Activity Logs')
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
                ->modalHeading('Clear Activity Logs')
                ->modalDescription('This will permanently delete activity logs based on your selection.')
                ->modalSubmitActionLabel('Clear Logs')
                ->form([
                    Forms\Components\Radio::make('clear_option')
                        ->label('Select what to clear')
                        ->options([
                            'all' => 'Clear all activity logs',
                            'older_than' => 'Clear logs older than a specific date',
                            'by_type' => 'Clear logs by type',
                            'keep_recent' => 'Keep only recent logs',
                        ])
                        ->default('older_than')
                        ->reactive()
                        ->required(),

                    Forms\Components\DatePicker::make('date')
                        ->label('Clear logs before this date')
                        ->default(now()->subMonths(3))
                        ->maxDate(now()->subDays(1))
                        ->visible(fn (Forms\Get $get) => $get('clear_option') === 'older_than')
                        ->required(fn (Forms\Get $get) => $get('clear_option') === 'older_than'),

                    Forms\Components\Select::make('log_types')
                        ->label('Select log types to clear')
                        ->multiple()
                        ->options(function () {
                            return Activity::distinct()
                                ->pluck('log_type', 'log_type')
                                ->toArray();
                        })
                        ->visible(fn (Forms\Get $get) => $get('clear_option') === 'by_type')
                        ->required(fn (Forms\Get $get) => $get('clear_option') === 'by_type'),

                    Forms\Components\Select::make('keep_days')
                        ->label('Keep logs from the last')
                        ->options([
                            7 => '7 days',
                            30 => '30 days',
                            60 => '60 days',
                            90 => '90 days',
                            180 => '180 days',
                            365 => '1 year',
                        ])
                        ->default(30)
                        ->visible(fn (Forms\Get $get) => $get('clear_option') === 'keep_recent')
                        ->required(fn (Forms\Get $get) => $get('clear_option') === 'keep_recent'),

                    Forms\Components\Placeholder::make('warning')
                        ->content('⚠️ This action cannot be undone. Consider exporting logs before clearing them.'),
                ])
                ->action(function (array $data): void {
                    $count = 0;

                    switch ($data['clear_option']) {
                        case 'all':
                            $count = Activity::count();
                            Activity::query()->delete();
                            break;

                        case 'older_than':
                            $count = Activity::where('created_at', '<', $data['date'])->count();
                            Activity::where('created_at', '<', $data['date'])->delete();
                            break;

                        case 'by_type':
                            $count = Activity::whereIn('log_type', $data['log_types'])->count();
                            Activity::whereIn('log_type', $data['log_types'])->delete();
                            break;

                        case 'keep_recent':
                            $cutoffDate = Carbon::now()->subDays($data['keep_days']);
                            $count = Activity::where('created_at', '<', $cutoffDate)->count();
                            Activity::where('created_at', '<', $cutoffDate)->delete();
                            break;
                    }

                    // Reset auto-increment if all logs were deleted
                    if (Activity::count() === 0) {
                        DB::statement('ALTER TABLE activities AUTO_INCREMENT = 1');
                    }

                    Notification::make()
                        ->title('Activity Logs Cleared')
                        ->body("Successfully deleted {$count} activity log entries.")
                        ->success()
                        ->send();
                }),

            Action::make('exportLogs')
                ->label('Export Logs')
                ->color('gray')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    Forms\Components\Select::make('format')
                        ->label('Export Format')
                        ->options([
                            'csv' => 'CSV',
                            'json' => 'JSON',
                        ])
                        ->default('csv')
                        ->required(),

                    Forms\Components\DatePicker::make('from_date')
                        ->label('From Date')
                        ->default(now()->subMonth()),

                    Forms\Components\DatePicker::make('to_date')
                        ->label('To Date')
                        ->default(now())
                        ->after('from_date'),
                ])
                ->action(function (array $data): \Symfony\Component\HttpFoundation\StreamedResponse {
                    $logs = Activity::query()
                        ->when($data['from_date'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                        ->when($data['to_date'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '<=', $date))
                        ->orderBy('created_at', 'desc')
                        ->get();

                    if ($data['format'] === 'csv') {
                        return response()->streamDownload(function () use ($logs) {
                            $output = fopen('php://output', 'w');

                            // Header row
                            fputcsv($output, [
                                'ID',
                                'Log Type',
                                'Action',
                                'Description',
                                'User ID',
                                'User Name',
                                'IP Address',
                                'User Agent',
                                'Created At',
                                'Data'
                            ]);

                            // Data rows
                            foreach ($logs as $log) {
                                fputcsv($output, [
                                    $log->id,
                                    $log->log_type,
                                    $log->action,
                                    $log->description,
                                    $log->user_id,
                                    $log->user?->name,
                                    $log->ip_address,
                                    $log->user_agent,
                                    $log->created_at,
                                    json_encode($log->data),
                                ]);
                            }

                            fclose($output);
                        }, 'activity-logs-' . now()->format('Y-m-d-His') . '.csv');
                    }

                    // JSON format
                    return response()->streamDownload(function () use ($logs) {
                        echo $logs->toJson(JSON_PRETTY_PRINT);
                    }, 'activity-logs-' . now()->format('Y-m-d-His') . '.json');
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ActivityLogResource\Widgets\ActivityLogStats::class,
        ];
    }

    public function getTitle(): string
    {
        return 'Activity Logs';
    }

    public function getSubheading(): ?string
    {
        return 'Monitor all system activities, user actions, and audit trail';
    }
}