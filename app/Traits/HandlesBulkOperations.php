<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\ActivityLogger;

trait HandlesBulkOperations
{
    /**
     * Execute a bulk operation with error handling and notifications
     */
    protected static function executeBulkOperation(
        Collection $records,
        callable $operation,
        string $operationName,
        string $successMessage,
        string $logEvent = null
    ): void {
        $successCount = 0;
        $failedCount = 0;
        $errors = [];
        $successfulRecords = [];

        DB::beginTransaction();

        try {
            foreach ($records as $record) {
                try {
                    $operation($record);
                    $successCount++;
                    $successfulRecords[] = $record;
                } catch (\Exception $e) {
                    $failedCount++;
                    $identifier = $record->name ?? $record->title ?? $record->id;
                    $errors[] = "'{$identifier}': " . $e->getMessage();

                    Log::warning("Bulk {$operationName} failed for individual record", [
                        'record_id' => $record->id,
                        'model' => get_class($record),
                        'error' => $e->getMessage()
                    ]);
                }
            }

            if ($failedCount === 0) {
                DB::commit();

                // Log the successful operation
                if ($logEvent) {
                    ActivityLogger::log()
                        ->useLog('bulk')
                        ->event($logEvent)
                        ->withDescription(":causer {$operationName} {$successCount} " . class_basename($records->first()))
                        ->withProperties([
                            'count' => $successCount,
                            'ids' => collect($successfulRecords)->pluck('id')->toArray()
                        ])
                        ->save();
                }

                Notification::make()
                    ->title('Operation Successful')
                    ->body(sprintf($successMessage, $successCount))
                    ->success()
                    ->send();
            } else {
                DB::rollBack();

                $errorMessage = $failedCount === count($records)
                    ? "All operations failed."
                    : "Partial failure: {$successCount} succeeded, {$failedCount} failed.";

                if (count($errors) <= 3) {
                    $errorMessage .= " Errors: " . implode('; ', $errors);
                } else {
                    $errorMessage .= " First 3 errors: " . implode('; ', array_slice($errors, 0, 3));
                    $errorMessage .= " ...and " . (count($errors) - 3) . " more.";
                }

                Notification::make()
                    ->title('Operation Failed')
                    ->body($errorMessage)
                    ->danger()
                    ->persistent()
                    ->send();
            }
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Bulk {$operationName} failed completely", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'record_count' => count($records)
            ]);

            Notification::make()
                ->title('Operation Failed')
                ->body('An unexpected error occurred: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    /**
     * Execute a bulk update with specific field changes
     */
    protected static function executeBulkUpdate(
        Collection $records,
        array $updateData,
        string $operationName,
        string $logEvent = null
    ): void {
        static::executeBulkOperation(
            $records,
            function ($record) use ($updateData) {
                $record->update($updateData);
            },
            $operationName,
            "Successfully updated %d record(s).",
            $logEvent
        );
    }

    /**
     * Execute a bulk duplication operation
     */
    protected static function executeBulkDuplicate(
        Collection $records,
        string $nameSuffix = ' (Copy)'
    ): void {
        $successCount = 0;
        $failedCount = 0;
        $errors = [];
        $newRecords = [];

        DB::beginTransaction();

        try {
            foreach ($records as $record) {
                try {
                    $duplicate = $record->replicate();

                    // Update common fields
                    if (isset($duplicate->name)) {
                        $duplicate->name = $record->name . $nameSuffix;
                    }
                    if (isset($duplicate->title)) {
                        $duplicate->title = $record->title . $nameSuffix;
                    }
                    if (isset($duplicate->slug)) {
                        $duplicate->slug = $record->slug . '-copy-' . time() . '-' . $successCount;
                    }
                    if (isset($duplicate->is_active)) {
                        $duplicate->is_active = false;
                    }
                    if (isset($duplicate->is_published)) {
                        $duplicate->is_published = false;
                        $duplicate->published_at = null;
                    }

                    $duplicate->save();
                    $newRecords[] = $duplicate;
                    $successCount++;
                } catch (\Exception $e) {
                    $failedCount++;
                    $identifier = $record->name ?? $record->title ?? $record->id;
                    $errors[] = "Failed to duplicate '{$identifier}': " . $e->getMessage();

                    Log::warning('Bulk duplicate failed for record', [
                        'record_id' => $record->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            if ($failedCount === 0) {
                DB::commit();

                ActivityLogger::log()
                    ->useLog('bulk')
                    ->event('bulk_duplicate')
                    ->withDescription(":causer duplicated {$successCount} records")
                    ->withProperties([
                        'original_ids' => $records->pluck('id')->toArray(),
                        'new_ids' => collect($newRecords)->pluck('id')->toArray()
                    ])
                    ->save();

                Notification::make()
                    ->title('Duplication Successful')
                    ->body("Successfully duplicated {$successCount} record(s).")
                    ->success()
                    ->send();
            } else {
                DB::rollBack();

                Notification::make()
                    ->title('Duplication Failed')
                    ->body("Failed to duplicate some records. Errors: " . implode('; ', array_slice($errors, 0, 3)))
                    ->danger()
                    ->persistent()
                    ->send();
            }
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Bulk duplicate failed completely', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            Notification::make()
                ->title('Duplication Failed')
                ->body('An unexpected error occurred: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    /**
     * Validate records before bulk operation
     */
    protected static function validateBulkOperation(
        Collection $records,
        callable $validator = null
    ): array {
        $errors = [];

        if (count($records) === 0) {
            $errors[] = 'No records selected for operation.';
            return $errors;
        }

        if (count($records) > 1000) {
            $errors[] = 'Too many records selected. Maximum 1000 records allowed per operation.';
            return $errors;
        }

        if ($validator) {
            foreach ($records as $record) {
                $validationError = $validator($record);
                if ($validationError) {
                    $identifier = $record->name ?? $record->title ?? $record->id;
                    $errors[] = "'{$identifier}': {$validationError}";
                }
            }
        }

        return $errors;
    }
}