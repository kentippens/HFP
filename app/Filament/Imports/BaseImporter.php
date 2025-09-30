<?php

namespace App\Filament\Imports;

use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Collection;

abstract class BaseImporter extends Importer
{
    protected static ?string $model = null;

    abstract public static function getColumns(): array;

    public function resolveRecord(): ?array
    {
        $data = [];

        foreach (static::getColumns() as $column) {
            $attribute = $column->getAttribute();
            $value = $this->data[$attribute] ?? null;

            if ($value !== null) {
                $data[$attribute] = $column->formatStateUsing($value);
            }
        }

        return $data;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    public function getJobQueue(): ?string
    {
        return 'imports';
    }

    public function getJobConnection(): ?string
    {
        return config('queue.default');
    }

    public function getJobBatchName(): ?string
    {
        return 'import-' . class_basename(static::getModel()) . '-' . time();
    }

    protected function beforeSave(): void
    {
        // Override in child classes for custom logic before saving
    }

    protected function afterSave(): void
    {
        // Override in child classes for custom logic after saving
    }
}