<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrackingScriptResource\Pages;
use App\Filament\Resources\TrackingScriptResource\RelationManagers;
use App\Models\TrackingScript;
use App\Services\TrackingScriptService;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\ValidationException;

class TrackingScriptResource extends Resource
{
    protected static ?string $model = TrackingScript::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-code-bracket';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Project Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Tracking Scripts';
    }

    public static function getModelLabel(): string
    {
        return 'Tracking Script';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tracking Scripts';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::active()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::active()->count() > 0 ? 'success' : 'warning';
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Script Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Script Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Google Analytics 4')
                            ->helperText('A descriptive name for this tracking script'),
                        
                        Forms\Components\Select::make('location')
                            ->label('Script Location')
                            ->required()
                            ->options(TrackingScript::SCRIPT_POSITIONS)
                            ->native(false)
                            ->default('head')
                            ->helperText('Where in the HTML document should this script be placed?'),
                    ])
                    ->columns(2),
                
                Schemas\Components\Section::make('Script Code')
                    ->schema([
                        Forms\Components\Textarea::make('script_content')
                            ->label('Script Content')
                            ->required()
                            ->rows(10)
                            ->columnSpanFull()
                            ->placeholder('<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());
  gtag(\'config\', \'G-XXXXXXXXXX\');
</script>')
                            ->helperText('Paste the complete tracking script code here, including <script> tags'),
                    ]),
                
                Schemas\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Enable or disable this tracking script'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Script Name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('location')
                    ->label('Location')
                    ->formatStateUsing(fn (string $state): string => TrackingScript::SCRIPT_POSITIONS[$state] ?? $state)
                    ->colors([
                        'primary' => 'head',
                        'success' => 'body_start',
                        'warning' => 'body_end',
                    ]),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('location')
                    ->options(TrackingScript::SCRIPT_POSITIONS),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->actions([
                EditAction::make(),
                Action::make('validate')
                    ->label('Validate')
                    ->icon('heroicon-o-shield-check')
                    ->color('info')
                    ->action(function (TrackingScript $record) {
                        try {
                            $record->validateModel();
                            Notification::make()
                                ->title('Script Valid')
                                ->body('The tracking script passed all validation checks.')
                                ->success()
                                ->send();
                        } catch (ValidationException $e) {
                            Notification::make()
                                ->title('Validation Failed')
                                ->body('Script validation failed: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('clear_cache')
                    ->label('Clear Cache')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->action(function () {
                        app(TrackingScriptService::class)->clearCache();
                        Notification::make()
                            ->title('Cache Cleared')
                            ->body('Tracking scripts cache has been cleared.')
                            ->success()
                            ->send();
                    }),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('validate_all')
                        ->label('Validate All')
                        ->icon('heroicon-o-shield-check')
                        ->color('info')
                        ->action(function ($records) {
                            $validationResults = [];
                            $failedCount = 0;
                            
                            foreach ($records as $record) {
                                try {
                                    $record->validateModel();
                                    $validationResults[] = $record->name . ': ✓ Valid';
                                } catch (ValidationException $e) {
                                    $validationResults[] = $record->name . ': ✗ ' . $e->getMessage();
                                    $failedCount++;
                                }
                            }
                            
                            $title = $failedCount > 0 ? 'Validation Issues Found' : 'All Scripts Valid';
                            $color = $failedCount > 0 ? 'warning' : 'success';
                            
                            Notification::make()
                                ->title($title)
                                ->body(implode('\n', $validationResults))
                                ->color($color)
                                ->send();
                        }),
                    BulkAction::make('toggle_active')
                        ->label('Toggle Active')
                        ->icon('heroicon-o-power')
                        ->color('warning')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['is_active' => !$record->is_active]);
                            }
                            
                            app(TrackingScriptService::class)->clearCache();
                            
                            Notification::make()
                                ->title('Scripts Updated')
                                ->body('Active status toggled for selected scripts.')
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
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
            'index' => Pages\ListTrackingScripts::route('/'),
            'create' => Pages\CreateTrackingScript::route('/create'),
            'edit' => Pages\EditTrackingScript::route('/{record}/edit'),
        ];
    }
    
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'script_content'];
    }
    
    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->name;
    }
    
    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Location' => TrackingScript::SCRIPT_POSITIONS[$record->location] ?? $record->location,
            'Status' => $record->is_active ? 'Active' : 'Inactive',
        ];
    }


    /**
     * Determine if the user can view any records.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('viewAny', TrackingScript::class) ?? false;
    }

    /**
     * Determine if the user can create records.
     */
    public static function canCreate(): bool
    {
        return auth()->user()?->can('create', TrackingScript::class) ?? false;
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
