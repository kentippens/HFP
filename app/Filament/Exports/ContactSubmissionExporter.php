<?php

namespace App\Filament\Exports;

use App\Models\ContactSubmission;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ContactSubmissionExporter extends Exporter
{
    protected static ?string $model = ContactSubmission::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('created_at')
                ->label('Date Submitted')
                ->formatStateUsing(fn ($state) => $state?->format('Y-m-d H:i:s')),
            ExportColumn::make('name')
                ->label('Full Name'),
            ExportColumn::make('first_name')
                ->label('First Name'),
            ExportColumn::make('last_name')
                ->label('Last Name'),
            ExportColumn::make('email')
                ->label('Email'),
            ExportColumn::make('phone')
                ->label('Phone'),
            ExportColumn::make('service_requested')
                ->label('Service Requested')
                ->formatStateUsing(fn ($state) => $state ? ucwords(str_replace(['-', '_'], ' ', $state)) : 'N/A'),
            ExportColumn::make('message')
                ->label('Message'),
            ExportColumn::make('source')
                ->label('Source')
                ->formatStateUsing(fn ($state) => \App\Filament\Resources\ContactSubmissionResource::getSourceLabel($state)),
            ExportColumn::make('source_uri')
                ->label('Source URI'),
            ExportColumn::make('is_read')
                ->label('Read Status')
                ->formatStateUsing(fn ($state) => $state ? 'Read' : 'Unread'),
            ExportColumn::make('ip_address')
                ->label('IP Address'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your contact submission export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
