<?php

namespace App\Filament\Exports;

use App\Models\BlogPost;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class BlogPostExporter extends Exporter
{
    protected static ?string $model = BlogPost::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('title')
                ->label('Title'),

            ExportColumn::make('slug')
                ->label('URL Slug'),

            ExportColumn::make('content')
                ->label('Content')
                ->limit(200),

            ExportColumn::make('excerpt')
                ->label('Excerpt')
                ->limit(100),

            ExportColumn::make('author.name')
                ->label('Author')
                ->formatStateUsing(fn ($state, $record) => $record->author?->name ?? 'Unknown'),

            ExportColumn::make('category.name')
                ->label('Category')
                ->formatStateUsing(fn ($state, $record) => $record->category?->name ?? 'Uncategorized'),

            ExportColumn::make('tags')
                ->label('Tags')
                ->formatStateUsing(function ($state) {
                    if (is_array($state)) {
                        return implode(', ', $state);
                    }
                    return $state;
                }),

            ExportColumn::make('is_published')
                ->label('Published')
                ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No'),

            ExportColumn::make('is_featured')
                ->label('Featured')
                ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No'),

            ExportColumn::make('published_at')
                ->label('Published Date')
                ->formatStateUsing(fn ($state) => $state?->format('Y-m-d H:i:s')),

            ExportColumn::make('reading_time')
                ->label('Reading Time (minutes)'),

            ExportColumn::make('view_count')
                ->label('View Count'),

            ExportColumn::make('featured_image')
                ->label('Featured Image Path'),

            ExportColumn::make('meta_title')
                ->label('SEO Title'),

            ExportColumn::make('meta_description')
                ->label('SEO Description')
                ->limit(80),

            ExportColumn::make('meta_keywords')
                ->label('SEO Keywords'),

            ExportColumn::make('sort_order')
                ->label('Sort Order'),

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
        $body = 'Your blog posts export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}