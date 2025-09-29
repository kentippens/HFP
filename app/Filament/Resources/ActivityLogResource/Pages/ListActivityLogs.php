<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action for activity logs
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