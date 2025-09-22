<?php

namespace App\Exceptions;

use Filament\Notifications\Notification;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class FilamentExceptionHandler
{
    /**
     * Handle Filament-specific exceptions
     */
    public static function handle(Throwable $exception): void
    {
        // Log the exception
        Log::error('Filament Exception', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'user_id' => auth()->id(),
            'url' => request()->fullUrl(),
        ]);

        // Send appropriate notification based on exception type
        if ($exception instanceof ValidationException) {
            self::handleValidationException($exception);
        } elseif ($exception instanceof QueryException) {
            self::handleDatabaseException($exception);
        } else {
            self::handleGenericException($exception);
        }
    }

    /**
     * Handle validation exceptions
     */
    protected static function handleValidationException(ValidationException $exception): void
    {
        $errors = $exception->errors();
        $message = 'Please check the following fields: ' . implode(', ', array_keys($errors));

        Notification::make()
            ->danger()
            ->title('Validation Error')
            ->body($message)
            ->persistent()
            ->send();
    }

    /**
     * Handle database exceptions
     */
    protected static function handleDatabaseException(QueryException $exception): void
    {
        $message = 'A database error occurred.';

        // Provide more specific messages for common errors
        if (str_contains($exception->getMessage(), 'Duplicate entry')) {
            $message = 'This record already exists. Please check for duplicates.';
        } elseif (str_contains($exception->getMessage(), 'foreign key constraint')) {
            $message = 'This record cannot be modified because it is referenced by other records.';
        } elseif (str_contains($exception->getMessage(), 'Connection refused')) {
            $message = 'Cannot connect to the database. Please try again later.';
        } elseif (str_contains($exception->getMessage(), 'Unknown column')) {
            $message = 'Database structure error. Please contact support.';
        }

        Notification::make()
            ->danger()
            ->title('Database Error')
            ->body($message)
            ->persistent()
            ->send();
    }

    /**
     * Handle generic exceptions
     */
    protected static function handleGenericException(Throwable $exception): void
    {
        $message = 'An unexpected error occurred. Please try again.';

        // Provide more context for specific error types
        if (str_contains($exception->getMessage(), 'memory')) {
            $message = 'The operation ran out of memory. Please try with less data.';
        } elseif (str_contains($exception->getMessage(), 'timeout')) {
            $message = 'The operation timed out. Please try again with less data.';
        } elseif (str_contains($exception->getMessage(), 'permission')) {
            $message = 'You do not have permission to perform this action.';
        }

        Notification::make()
            ->danger()
            ->title('Error')
            ->body($message)
            ->persistent()
            ->send();
    }

    /**
     * Check if exception should be reported
     */
    public static function shouldReport(Throwable $exception): bool
    {
        // Don't report validation exceptions
        if ($exception instanceof ValidationException) {
            return false;
        }

        // Don't report common user errors
        $dontReport = [
            'No query results',
            'User not found',
            'Record not found',
        ];

        foreach ($dontReport as $message) {
            if (str_contains($exception->getMessage(), $message)) {
                return false;
            }
        }

        return true;
    }
}