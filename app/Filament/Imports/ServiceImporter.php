<?php

namespace App\Filament\Imports;

use App\Models\Service;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Str;

class ServiceImporter extends Importer
{
    protected static ?string $model = Service::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255']),

            ImportColumn::make('slug')
                ->rules(['nullable', 'string', 'max:255', 'unique:services,slug'])
                ->example('pool-resurfacing'),

            ImportColumn::make('description')
                ->rules(['nullable', 'string'])
                ->example('Complete pool resurfacing service'),

            ImportColumn::make('short_description')
                ->rules(['nullable', 'string', 'max:500'])
                ->example('Professional pool resurfacing'),

            ImportColumn::make('price_range')
                ->rules(['nullable', 'string', 'max:100'])
                ->example('$3000-$8000'),

            ImportColumn::make('is_active')
                ->boolean()
                ->rules(['nullable', 'boolean'])
                ->example('Yes'),

            ImportColumn::make('is_featured')
                ->boolean()
                ->rules(['nullable', 'boolean'])
                ->example('No'),

            ImportColumn::make('sort_order')
                ->numeric()
                ->rules(['nullable', 'integer', 'min:0'])
                ->example('1'),

            ImportColumn::make('meta_title')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('Professional Pool Resurfacing Services'),

            ImportColumn::make('meta_description')
                ->rules(['nullable', 'string', 'max:500'])
                ->example('Expert pool resurfacing services'),

            ImportColumn::make('meta_keywords')
                ->rules(['nullable', 'string'])
                ->example('pool resurfacing, pool repair'),

            ImportColumn::make('features')
                ->rules(['nullable', 'string'])
                ->example('Durable materials, Professional installation'),

            ImportColumn::make('benefits')
                ->rules(['nullable', 'string'])
                ->example('Increased property value, Enhanced appearance'),

            ImportColumn::make('overview')
                ->rules(['nullable', 'string'])
                ->example('Transform your old pool with our service'),

            ImportColumn::make('homepage_image')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('images/services/pool-resurfacing.jpg'),
        ];
    }

    public function resolveRecord(): ?Service
    {
        $data = $this->data;

        // Generate slug if not provided
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);

            // Ensure slug uniqueness
            $originalSlug = $data['slug'];
            $counter = 1;
            while (Service::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Convert features and benefits from comma-separated strings to arrays
        if (!empty($data['features'])) {
            $data['features'] = array_map('trim', explode(',', $data['features']));
        }

        if (!empty($data['benefits'])) {
            $data['benefits'] = array_map('trim', explode(',', $data['benefits']));
        }

        // Set default sort_order if not provided
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = Service::max('sort_order') + 1;
        }

        return new Service($data);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your service import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}