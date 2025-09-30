<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Filament\Exports\ServiceExporter;
use App\Filament\Imports\ServiceImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Pages\ListRecords;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->importer(ServiceImporter::class)
                ->label('Import Services')
                ->color('gray')
                ->icon('heroicon-o-arrow-up-tray'),
            ExportAction::make()
                ->exporter(ServiceExporter::class)
                ->formats([
                    ExportFormat::Csv,
                ])
                ->fileName(fn () => 'services-export-' . date('Y-m-d-His'))
                ->label('Export Services')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray'),
        ];
    }
}
