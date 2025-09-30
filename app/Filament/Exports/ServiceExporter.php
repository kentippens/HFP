<?php

namespace App\Filament\Exports;

use App\Models\Service;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ServiceExporter extends Exporter
{
    protected static ?string $model = Service::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('name')
                ->label('Service Name'),

            ExportColumn::make('slug')
                ->label('URL Slug'),

            ExportColumn::make('description')
                ->label('Description')
                ->limit(100),

            ExportColumn::make('short_description')
                ->label('Short Description')
                ->limit(50),

            ExportColumn::make('price_range')
                ->label('Price Range'),

            ExportColumn::make('is_active')
                ->label('Active')
                ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No'),

            ExportColumn::make('is_featured')
                ->label('Featured')
                ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No'),

            ExportColumn::make('sort_order')
                ->label('Sort Order'),

            ExportColumn::make('meta_title')
                ->label('SEO Title'),

            ExportColumn::make('meta_description')
                ->label('SEO Description')
                ->limit(80),

            ExportColumn::make('meta_keywords')
                ->label('SEO Keywords'),

            ExportColumn::make('features')
                ->label('Features')
                ->formatStateUsing(function ($state) {
                    if (is_array($state)) {
                        return implode(', ', $state);
                    }
                    return $state;
                }),

            ExportColumn::make('benefits')
                ->label('Benefits')
                ->formatStateUsing(function ($state) {
                    if (is_array($state)) {
                        return implode(', ', $state);
                    }
                    return $state;
                }),

            ExportColumn::make('overview')
                ->label('Overview')
                ->limit(100),

            ExportColumn::make('homepage_image')
                ->label('Homepage Image Path'),

            ExportColumn::make('created_at')
                ->label('Created Date')
                ->formatStateUsing(fn ($state) => $state?->format('Y-m-d H:i:s')),

            ExportColumn::make('updated_at')
                ->label('Updated Date')
                ->formatStateUsing(fn ($state) => $state?->format('Y-m-d H:i:s')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your services export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}