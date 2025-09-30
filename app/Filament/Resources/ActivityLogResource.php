<?php

namespace App\Filament\Resources;

use App\Models\ActivityLog;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Models\Activity;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?int $navigationSort = 10;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-clipboard-document-list';
    }

    public static function getNavigationLabel(): string
    {
        return 'Activity Logs';
    }

    public static function getModelLabel(): string
    {
        return 'Activity Log';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Activity Logs';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'System Configuration';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Log Details')
                    ->schema([
                        Forms\Components\TextInput::make('log_name')
                            ->label('Log Type')
                            ->disabled(),
                        Forms\Components\TextInput::make('event')
                            ->label('Event')
                            ->disabled(),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(2)
                            ->disabled(),
                    ])->columns(2),

                Schemas\Components\Section::make('Subject Information')
                    ->schema([
                        Forms\Components\TextInput::make('subject_type')
                            ->label('Subject Type')
                            ->disabled(),
                        Forms\Components\TextInput::make('subject_id')
                            ->label('Subject ID')
                            ->disabled(),
                    ])->columns(2),

                Schemas\Components\Section::make('Causer Information')
                    ->schema([
                        Forms\Components\TextInput::make('causer.name')
                            ->label('Performed By')
                            ->disabled(),
                        Forms\Components\TextInput::make('causer_type')
                            ->label('Causer Type')
                            ->disabled(),
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled(),
                    ])->columns(3),

                Schemas\Components\Section::make('Properties')
                    ->schema([
                        Forms\Components\KeyValue::make('properties')
                            ->label('Properties')
                            ->disabled(),
                    ])
                    ->collapsed(),

                Schemas\Components\Section::make('Changes')
                    ->schema([
                        Forms\Components\KeyValue::make('changes.old')
                            ->label('Old Values')
                            ->disabled(),
                        Forms\Components\KeyValue::make('changes.attributes')
                            ->label('New Values')
                            ->disabled(),
                    ])
                    ->columns(2)
                    ->collapsed(),

                Schemas\Components\Section::make('Technical Information')
                    ->schema([
                        Forms\Components\Textarea::make('user_agent')
                            ->label('User Agent')
                            ->disabled(),
                        Forms\Components\TextInput::make('batch_uuid')
                            ->label('Batch ID')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Timestamp')
                            ->disabled(),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('M j, g:i A')
                    ->sortable()
                    ->since(),

                Tables\Columns\IconColumn::make('event')
                    ->label('')
                    ->getStateUsing(fn ($record) => $record->getIcon())
                    ->color(fn ($record) => $record->getColor())
                    ->tooltip(fn ($record) => $record->getEventLabel()),

                Tables\Columns\TextColumn::make('log_name')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match($state) {
                        'auth' => 'success',
                        'model' => 'info',
                        'contact' => 'warning',
                        'export' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('event')
                    ->label('Event')
                    ->formatStateUsing(fn ($record) => $record->getEventLabel())
                    ->badge(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->formatStateUsing(fn ($record) => $record->getFormattedDescription())
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->getFormattedDescription()),

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Subject')
                    ->formatStateUsing(fn ($state) => $state ? class_basename($state) : '-')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('User')
                    ->default('System')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('has_changes')
                    ->label('Changes')
                    ->getStateUsing(fn ($record) => $record->hasRecordedChanges())
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('log_name')
                    ->label('Log Type')
                    ->options([
                        'auth' => 'Authentication',
                        'model' => 'Model Changes',
                        'contact' => 'Contact Forms',
                        'export' => 'Data Exports',
                        'custom' => 'Custom Actions',
                    ]),

                SelectFilter::make('event')
                    ->label('Event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                        'login' => 'Login',
                        'logout' => 'Logout',
                        'failed_login' => 'Failed Login',
                        'exported' => 'Exported',
                    ]),

                Filter::make('today')
                    ->label('Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),

                Filter::make('this_week')
                    ->label('This Week')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('created_at', [
                        now()->startOfWeek(),
                        now()->endOfWeek(),
                    ])),

                Filter::make('has_causer')
                    ->label('Has User')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('causer_id')),

                Filter::make('system_actions')
                    ->label('System Actions')
                    ->query(fn (Builder $query): Builder => $query->whereNull('causer_id')),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk actions for activity logs
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // Show count of today's activities
        $count = Activity::today()->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        // Show warning if there are failed login attempts today
        $failedLogins = Activity::today()
            ->where('event', 'failed_login')
            ->count();

        return $failedLogins > 0 ? 'danger' : 'primary';
    }


    /**
     * Determine if the user can view any records.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('logs.view') ?? false;
    }

    /**
     * Determine if the user can view the record.
     */
    public static function canView($record): bool
    {
        return auth()->user()?->hasPermission('logs.view') ?? false;
    }

    /**
     * ActivityLogs are read-only - edit and delete return false
     */
    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }}