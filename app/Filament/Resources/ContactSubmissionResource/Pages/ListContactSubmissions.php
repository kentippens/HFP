<?php

namespace App\Filament\Resources\ContactSubmissionResource\Pages;

use App\Filament\Resources\ContactSubmissionResource;
use App\Filament\Exports\ContactSubmissionExporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Pages\ListRecords;

class ListContactSubmissions extends ListRecords
{
    protected static string $resource = ContactSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->exporter(ContactSubmissionExporter::class)
                ->formats([
                    ExportFormat::Csv,
                ])
                ->maxRows(50000)
                ->chunkSize(250)
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),
        ];
    }
}
