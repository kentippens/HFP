<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('name')
                ->label('Full Name'),

            ExportColumn::make('first_name')
                ->label('First Name'),

            ExportColumn::make('last_name')
                ->label('Last Name'),

            ExportColumn::make('email')
                ->label('Email'),

            ExportColumn::make('roles.name')
                ->label('Roles')
                ->formatStateUsing(function ($state, $record) {
                    return $record->roles->pluck('name')->implode(', ') ?: 'No roles assigned';
                }),

            ExportColumn::make('permissions.name')
                ->label('Direct Permissions')
                ->formatStateUsing(function ($state, $record) {
                    return $record->permissions->pluck('name')->implode(', ') ?: 'No direct permissions';
                }),

            ExportColumn::make('email_verified_at')
                ->label('Email Verified')
                ->formatStateUsing(fn ($state) => $state ? $state->format('Y-m-d H:i:s') : 'Not verified'),

            ExportColumn::make('last_login_at')
                ->label('Last Login')
                ->formatStateUsing(fn ($state) => $state?->format('Y-m-d H:i:s') ?? 'Never'),

            ExportColumn::make('login_count')
                ->label('Login Count'),

            ExportColumn::make('failed_login_attempts')
                ->label('Failed Login Attempts'),

            ExportColumn::make('locked_until')
                ->label('Account Locked Until')
                ->formatStateUsing(fn ($state) => $state?->format('Y-m-d H:i:s') ?? 'Not locked'),

            ExportColumn::make('is_active')
                ->label('Active')
                ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No'),

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
        $body = 'Your users export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}