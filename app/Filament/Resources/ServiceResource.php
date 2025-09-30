<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use App\Rules\ValidJsonLd;
use App\Rules\PreventCircularServiceReference;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;
use App\Services\ActivityLogger;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public static function getNavigationLabel(): string
    {
        return 'Services';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Content Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 20;
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('parent_id')
                            ->label('Parent Service')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->options(function (?Service $record) {
                                $query = Service::query()
                                    ->where('is_active', true)
                                    ->orderBy('order_index')
                                    ->orderBy('name');
                                
                                // Exclude current record and its children to prevent circular references
                                if ($record) {
                                    $excludeIds = [$record->id];
                                    $children = $record->children()->pluck('id')->toArray();
                                    $excludeIds = array_merge($excludeIds, $children);
                                    $query->whereNotIn('id', $excludeIds);
                                }
                                
                                return $query->pluck('name', 'id');
                            })
                            ->rules([
                                fn (?Service $record): PreventCircularServiceReference => new PreventCircularServiceReference($record?->id)
                            ])
                            ->helperText('Select a parent service to create a sub-service')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(fn ($state, Schemas\Set $set) => $set('slug', \Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('short_description')
                            ->rows(3)
                            ->label('Short Description')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->label('Full Description')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->disk('public')
                            ->directory('services')
                            ->visibility('public')
                            ->deletable()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                            ->maxSize(5120)
                            ->nullable(),
                        Forms\Components\FileUpload::make('breadcrumb_image')
                            ->label('Breadcrumb Background Image')
                            ->image()
                            ->disk('public')
                            ->directory('services/breadcrumbs')
                            ->visibility('public')
                            ->deletable()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(512) // Reduced from 5MB to 512KB
                            ->imageResizeTargetWidth(1920)
                            ->imageResizeTargetHeight(600)
                            ->nullable()
                            ->helperText('Background image for breadcrumb area (Max 512KB, will be resized to 1920x600)'),
                    ]),
                Schemas\Components\Section::make('SEO Settings')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(255)
                            ->label('Meta Title')
                            ->live(onBlur: true)
                            ->suffixIcon(fn ($state) => 
                                $state 
                                    ? (strlen($state) >= 50 && strlen($state) <= 60 
                                        ? 'heroicon-s-check-circle' 
                                        : 'heroicon-s-x-circle')
                                    : null
                            )
                            ->suffixIconColor(fn ($state) => 
                                $state 
                                    ? (strlen($state) >= 50 && strlen($state) <= 60 
                                        ? 'success' 
                                        : 'danger')
                                    : null
                            )
                            ->helperText(fn ($state) => 
                                $state 
                                    ? 'Current: ' . strlen($state) . ' characters (Optimal: 50-60) ' . 
                                      (strlen($state) >= 50 && strlen($state) <= 60 ? '✅' : '❌')
                                    : 'Optimal length: 50-60 characters'
                            ),
                        Forms\Components\Textarea::make('meta_description')
                            ->rows(3)
                            ->maxLength(160)
                            ->label('Meta Description')
                            ->live(onBlur: true)
                            ->helperText(fn ($state) => 
                                $state 
                                    ? 'Current: ' . strlen($state) . ' characters (Optimal: 150-160) ' . 
                                      (strlen($state) >= 150 && strlen($state) <= 160 ? '✅' : '❌')
                                    : 'Optimal length: 150-160 characters'
                            ),
                        Forms\Components\Select::make('meta_robots')
                            ->label('Meta Robots')
                            ->options(\App\Models\Service::META_ROBOTS_OPTIONS)
                            ->default('index, follow')
                            ->required()
                            ->helperText('Control how search engines crawl and index this page')
                            ->suffixIcon('heroicon-m-eye')
                            ->suffixIconColor('secondary'),
                        Forms\Components\Textarea::make('json_ld')
                            ->label('JSON-LD Structured Data')
                            ->rows(8)
                            ->placeholder('{"@context": "https://schema.org", "@type": "Service", "name": "Your Service"}')
                            ->helperText('Paste your JSON-LD structured data markup here. For multiple schemas, use an array: [{"@context":"...","@type":"..."},{"@context":"...","@type":"..."}]')
                            ->columnSpanFull()
                            ->formatStateUsing(function ($state) {
                                // When loading for edit, convert array to formatted JSON string
                                if (is_array($state)) {
                                    return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                                }
                                return $state;
                            })
                            ->dehydrateStateUsing(function ($state) {
                                // When saving, ensure it's properly formatted
                                if (empty($state)) {
                                    return null;
                                }
                                // Decode and re-encode to ensure proper format
                                $decoded = json_decode($state, true);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    return $decoded; // Return as array, model will handle conversion
                                }
                                return $state;
                            })
                            ->rules(['nullable', 'string', new ValidJsonLd()])
                            ->validationMessages([
                                'string' => 'The JSON-LD must be a string.',
                            ]),
                        Forms\Components\TextInput::make('canonical_url')
                            ->label('Canonical URL')
                            ->placeholder('/services/house-cleaning')
                            ->helperText('Enter a relative path (e.g., /services/house-cleaning) or full URL (e.g., https://example.com/path). Used to avoid duplicate content issues.')
                            ->suffixIcon('heroicon-m-link')
                            ->suffixIconColor('primary'),
                    ])
                    ->columns(1),
                Schemas\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Active'),
                        Forms\Components\Toggle::make('include_in_sitemap')
                            ->required()
                            ->default(true)
                            ->label('Include in Sitemap')
                            ->helperText('Whether this service should appear in sitemap.xml'),
                        Forms\Components\TextInput::make('order_index')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Sort Order (lower numbers appear first)'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_index')
                    ->label('#')
                    ->numeric()
                    ->sortable()
                    ->width(50),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->limit(50)
                    ->formatStateUsing(function ($state, $record) {
                        $prefix = '';
                        if ($record->parent) {
                            $prefix = '└─ ';
                            $parent = $record->parent;
                            while ($parent->parent) {
                                $prefix = '&nbsp;&nbsp;&nbsp;&nbsp;' . $prefix;
                                $parent = $parent->parent;
                            }
                        }
                        return new \Illuminate\Support\HtmlString($prefix . $state);
                    }),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent Service')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('short_description')
                    ->limit(70)
                    ->toggleable(),
                Tables\Columns\ImageColumn::make('image')
                    ->circular(),
                Tables\Columns\TextColumn::make('meta_robots')
                    ->label('Meta Robots')
                    ->toggleable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'index, follow' => 'success',
                        'noindex, follow', 'index, nofollow' => 'warning',
                        'noindex, nofollow', 'none' => 'danger',
                        default => 'primary',
                    }),
                Tables\Columns\IconColumn::make('json_ld')
                    ->label('JSON-LD')
                    ->toggleable()
                    ->getStateUsing(function ($record) {
                        if (empty($record->json_ld)) {
                            return 'empty';
                        }
                        return $record->hasValidJsonLd() ? 'valid' : 'invalid';
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'valid' => 'heroicon-o-check-circle',
                        'invalid' => 'heroicon-o-exclamation-circle',
                        'empty' => 'heroicon-o-minus-circle',
                        default => 'heroicon-o-x-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'valid' => 'success',
                        'invalid' => 'danger',
                        'empty' => 'gray',
                        default => 'warning',
                    })
                    ->tooltip(function ($record) {
                        if (empty($record->json_ld)) {
                            return 'No JSON-LD data';
                        }
                        if ($record->hasValidJsonLd()) {
                            return 'Valid JSON-LD';
                        }
                        return 'Invalid JSON-LD: ' . $record->getJsonLdError();
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\IconColumn::make('include_in_sitemap')
                    ->boolean()
                    ->label('In Sitemap')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $successCount = 0;
                            $failedCount = 0;
                            $errors = [];

                            DB::beginTransaction();
                            try {
                                foreach ($records as $record) {
                                    try {
                                        $record->update(['is_active' => true]);
                                        $successCount++;
                                    } catch (\Exception $e) {
                                        $failedCount++;
                                        $errors[] = "Service '{$record->name}': " . $e->getMessage();
                                        Log::error('Bulk activate service failed', [
                                            'service_id' => $record->id,
                                            'error' => $e->getMessage()
                                        ]);
                                    }
                                }

                                if ($failedCount === 0) {
                                    DB::commit();

                                    ActivityLogger::log()
                                        ->useLog('bulk')
                                        ->event('bulk_activate')
                                        ->withDescription(":causer activated {$successCount} services")
                                        ->save();

                                    Notification::make()
                                        ->title('Services Activated')
                                        ->body("Successfully activated {$successCount} service(s).")
                                        ->success()
                                        ->send();
                                } else {
                                    DB::rollBack();

                                    Notification::make()
                                        ->title('Bulk Activation Failed')
                                        ->body("Failed to activate services. Errors: " . implode(', ', $errors))
                                        ->danger()
                                        ->send();
                                }
                            } catch (\Exception $e) {
                                DB::rollBack();

                                Log::error('Bulk activate services failed completely', [
                                    'error' => $e->getMessage(),
                                    'trace' => $e->getTraceAsString()
                                ]);

                                Notification::make()
                                    ->title('Operation Failed')
                                    ->body('An unexpected error occurred: ' . $e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $count = 0;
                            foreach ($records as $record) {
                                $record->update(['is_active' => false]);
                                $count++;
                            }
                            ActivityLogger::log()
                                ->useLog('bulk')
                                ->event('bulk_deactivate')
                                ->withDescription(":causer deactivated {$count} services")
                                ->save();
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('include_in_sitemap')
                        ->label('Include in Sitemap')
                        ->icon('heroicon-o-globe-alt')
                        ->color('info')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(fn ($record) => $record->update(['include_in_sitemap' => true]));
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('exclude_from_sitemap')
                        ->label('Exclude from Sitemap')
                        ->icon('heroicon-o-eye-slash')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(fn ($record) => $record->update(['include_in_sitemap' => false]));
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('update_meta_robots')
                        ->label('Update Meta Robots')
                        ->icon('heroicon-o-magnifying-glass')
                        ->form([
                            Forms\Components\Select::make('meta_robots')
                                ->label('Meta Robots')
                                ->options(\App\Models\Service::META_ROBOTS_OPTIONS)
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each(fn ($record) => $record->update(['meta_robots' => $data['meta_robots']]));
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('update_order')
                        ->label('Update Display Order')
                        ->icon('heroicon-o-list-bullet')
                        ->form([
                            Forms\Components\TextInput::make('order_index')
                                ->label('Starting Order Number')
                                ->numeric()
                                ->required()
                                ->default(1)
                                ->minValue(0),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $order = $data['order_index'];
                            foreach ($records as $record) {
                                $record->update(['order_index' => $order]);
                                $order++;
                            }
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('duplicate')
                        ->label('Duplicate')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('secondary')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $duplicate = $record->replicate();
                                $duplicate->name = $record->name . ' (Copy)';
                                $duplicate->slug = $record->slug . '-copy-' . time();
                                $duplicate->is_active = false;
                                $duplicate->save();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('export')
                        ->label('Export to CSV')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('primary')
                        ->action(function (Collection $records): \Symfony\Component\HttpFoundation\StreamedResponse {
                            $fileName = 'services-export-' . date('Y-m-d-His') . '.csv';

                            return response()->streamDownload(function () use ($records) {
                                $handle = fopen('php://output', 'w');

                                // Add CSV headers
                                fputcsv($handle, [
                                    'ID',
                                    'Name',
                                    'Slug',
                                    'Parent Service',
                                    'Short Description',
                                    'Active',
                                    'In Sitemap',
                                    'Meta Title',
                                    'Meta Description',
                                    'Meta Robots',
                                    'Order',
                                    'Created At',
                                    'Updated At',
                                ]);

                                // Add data rows
                                foreach ($records as $service) {
                                    fputcsv($handle, [
                                        $service->id,
                                        $service->name,
                                        $service->slug,
                                        $service->parent?->name ?? '',
                                        $service->short_description ?? '',
                                        $service->is_active ? 'Yes' : 'No',
                                        $service->include_in_sitemap ? 'Yes' : 'No',
                                        $service->meta_title ?? '',
                                        $service->meta_description ?? '',
                                        $service->meta_robots ?? '',
                                        $service->order_index,
                                        $service->created_at,
                                        $service->updated_at,
                                    ]);
                                }

                                fclose($handle);

                                ActivityLogger::logExport('services', $records->count());
                            }, $fileName);
                        })
                        ->deselectRecordsAfterCompletion(),

                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order_index', 'asc')
            ->modifyQueryUsing(fn (Builder $query) => $query->with('parent'));
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

    /**
     * Determine if the user can view any services.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('viewAny', Service::class) ?? false;
    }

    /**
     * Determine if the user can create services.
     */
    public static function canCreate(): bool
    {
        return auth()->user()?->can('create', Service::class) ?? false;
    }

    /**
     * Determine if the user can edit the service.
     */
    public static function canEdit($record): bool
    {
        return auth()->user()?->can('update', $record) ?? false;
    }

    /**
     * Determine if the user can delete the service.
     */
    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete', $record) ?? false;
    }

    /**
     * Determine if the user can view the service.
     */
    public static function canView($record): bool
    {
        return auth()->user()?->can('view', $record) ?? false;
    }
}
