<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Rules\SecurePassword;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-users';
    }

    public static function getNavigationLabel(): string
    {
        return 'Users';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'User Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 10;
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Full Name')
                            ->validationMessages([
                                'required' => 'Full name is required.',
                                'max' => 'Full name cannot exceed 255 characters.',
                            ]),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(User::class, 'email', ignoreRecord: true)
                            ->maxLength(255)
                            ->label('Email Address')
                            ->validationMessages([
                                'required' => 'Email address is required.',
                                'email' => 'Please enter a valid email address.',
                                'unique' => 'This email address is already registered.',
                                'max' => 'Email address cannot exceed 255 characters.',
                            ]),
                    ])->columns(2),
                    
                Schemas\Components\Section::make('Password')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->rule(function (string $context, $state, $record) {
                                if ($context === 'create' || filled($state)) {
                                    $userName = $record?->name ?? '';
                                    $userEmail = $record?->email ?? '';
                                    return new SecurePassword($userName, $userEmail);
                                }
                                return 'nullable';
                            })
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->label('Password')
                            ->helperText('Must be at least 12 characters with uppercase, lowercase, numbers, and symbols. Leave blank to keep current password when editing.')
                            ->validationMessages([
                                'required' => 'Password is required for new users.',
                            ])
                            ->confirmed(),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->requiredWith('password')
                            ->dehydrated(false)
                            ->label('Confirm Password')
                            ->validationMessages([
                                'required_with' => 'Password confirmation is required when setting a password.',
                            ]),
                    ])->columns(2)
                    ->hiddenOn('view'),
                    
                Schemas\Components\Section::make('Account Status')
                    ->schema([
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->helperText('Set to mark email as verified'),
                        Forms\Components\Toggle::make('force_password_change')
                            ->label('Force Password Change')
                            ->helperText('User must change password on next login'),
                        Forms\Components\TextInput::make('failed_login_attempts')
                            ->numeric()
                            ->disabled()
                            ->label('Failed Login Attempts'),
                        Forms\Components\DateTimePicker::make('locked_until')
                            ->label('Account Locked Until')
                            ->helperText('Leave empty to unlock account'),
                    ])->columns(2)
                    ->hiddenOn('create'),
                    
                Schemas\Components\Section::make('Login History')
                    ->schema([
                        Forms\Components\DateTimePicker::make('last_login_at')
                            ->disabled()
                            ->label('Last Login'),
                        Forms\Components\TextInput::make('last_login_ip')
                            ->disabled()
                            ->label('Last Login IP'),
                        Forms\Components\DateTimePicker::make('password_changed_at')
                            ->disabled()
                            ->label('Password Last Changed'),
                    ])->columns(3)
                    ->hiddenOn('create')
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Full Name'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Email Address')
                    ->copyable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->boolean()
                    ->label('Verified')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_locked')
                    ->boolean()
                    ->getStateUsing(fn (User $record): bool => $record->isLocked())
                    ->label('Locked')
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-lock-open')
                    ->trueColor('danger')
                    ->falseColor('success'),
                Tables\Columns\TextColumn::make('failed_login_attempts')
                    ->label('Failed Logins')
                    ->badge()
                    ->color(fn (int $state): string => match(true) {
                        $state >= 5 => 'danger',
                        $state >= 3 => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('last_login_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Last Login')
                    ->since(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verified')
                    ->nullable(),
                Tables\Filters\TernaryFilter::make('is_locked')
                    ->label('Account Locked')
                    ->queries(
                        true: fn (Builder $query) => $query->where('locked_until', '>', now()),
                        false: fn (Builder $query) => $query->where(function ($query) {
                            $query->whereNull('locked_until')
                                  ->orWhere('locked_until', '<=', now());
                        }),
                    ),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Remove password fields if they're empty
                        if (empty($data['password'])) {
                            unset($data['password']);
                        }
                        return $data;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('User updated')
                            ->body('The user has been successfully updated.')
                    )
                    ->failureNotification(
                        Notification::make()
                            ->danger()
                            ->title('Update failed')
                            ->body('There was an error updating the user. Please check the form for errors.')
                    ),
                Action::make('unlock')
                    ->label('Unlock')
                    ->icon('heroicon-o-lock-open')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (User $record): bool => $record->isLocked())
                    ->action(function (User $record): void {
                        try {
                            $record->unlockAccount();
                            Notification::make()
                                ->success()
                                ->title('Account unlocked')
                                ->body("User {$record->email} has been unlocked.")
                                ->send();
                        } catch (Throwable $e) {
                            Log::error('Failed to unlock user account', [
                                'user_id' => $record->id,
                                'error' => $e->getMessage()
                            ]);
                            Notification::make()
                                ->danger()
                                ->title('Unlock failed')
                                ->body('Failed to unlock the user account.')
                                ->send();
                        }
                    }),
                Action::make('forcePasswordChange')
                    ->label('Force Password Change')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (User $record): bool => !$record->force_password_change)
                    ->action(function (User $record): void {
                        try {
                            $record->update(['force_password_change' => true]);
                            Notification::make()
                                ->success()
                                ->title('Password change required')
                                ->body("User {$record->email} must change password on next login.")
                                ->send();
                        } catch (Throwable $e) {
                            Log::error('Failed to force password change', [
                                'user_id' => $record->id,
                                'error' => $e->getMessage()
                            ]);
                            Notification::make()
                                ->danger()
                                ->title('Action failed')
                                ->body('Failed to force password change.')
                                ->send();
                        }
                    }),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete user')
                    ->modalDescription('Are you sure you want to delete this user? This action cannot be undone.')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('User deleted')
                            ->body('The user has been permanently deleted.')
                    ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('unlock')
                        ->label('Unlock Selected')
                        ->icon('heroicon-o-lock-open')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records): void {
                            $count = 0;
                            foreach ($records as $record) {
                                try {
                                    $record->unlockAccount();
                                    $count++;
                                } catch (Throwable $e) {
                                    Log::error('Failed to unlock user in bulk action', [
                                        'user_id' => $record->id,
                                        'error' => $e->getMessage()
                                    ]);
                                }
                            }
                            Notification::make()
                                ->success()
                                ->title('Users unlocked')
                                ->body("{$count} user(s) have been unlocked.")
                                ->send();
                        }),
                    DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50, 100]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }


    /**
     * Determine if the user can view any records.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('viewAny', User::class) ?? false;
    }

    /**
     * Determine if the user can create records.
     */
    public static function canCreate(): bool
    {
        return auth()->user()?->can('create', User::class) ?? false;
    }

    /**
     * Determine if the user can edit the record.
     */
    public static function canEdit($record): bool
    {
        return auth()->user()?->can('update', $record) ?? false;
    }

    /**
     * Determine if the user can delete the record.
     */
    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete', $record) ?? false;
    }

    /**
     * Determine if the user can view the record.
     */
    public static function canView($record): bool
    {
        return auth()->user()?->can('view', $record) ?? false;
    }}