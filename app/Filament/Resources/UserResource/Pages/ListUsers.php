<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Exports\UserExporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->exporter(UserExporter::class)
                ->formats([
                    ExportFormat::Csv,
                ])
                ->fileName(fn () => 'users-export-' . date('Y-m-d-His'))
                ->label('Export Users')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray'),
        ];
    }
}
