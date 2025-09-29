<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CorePageResource\Pages;
use App\Filament\Resources\CorePageResource\RelationManagers;
use App\Models\CorePage;
use App\Rules\ValidJsonLd;
use App\Rules\ValidCanonicalUrl;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CorePageResource extends Resource
{
    protected static ?string $model = CorePage::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationLabel(): string
    {
        return 'Core Pages';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Content Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 10;
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Page Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Page Name'),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label('Slug')
                            ->helperText('Used for identifying the page (e.g., homepage, services, about, contact)'),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Active'),
                        Forms\Components\Toggle::make('include_in_sitemap')
                            ->required()
                            ->default(true)
                            ->label('Include in Sitemap')
                            ->helperText('Whether this page should appear in sitemap.xml'),
                    ])
                    ->columns(2),
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
                            ->options(\App\Models\CorePage::META_ROBOTS_OPTIONS)
                            ->default('index, follow')
                            ->required()
                            ->helperText('Control how search engines crawl and index this page')
                            ->suffixIcon('heroicon-m-eye')
                            ->suffixIconColor('secondary'),
                        Forms\Components\Textarea::make('json_ld')
                            ->label('JSON-LD Structured Data')
                            ->rows(8)
                            ->placeholder('{"@context": "https://schema.org", "@type": "Organization", "name": "Your Business"}')
                            ->helperText('Paste your JSON-LD structured data markup here. For multiple schemas, use an array: [{"@context":"...","@type":"..."},{"@context":"...","@type":"..."}]')
                            ->columnSpanFull()
                            ->live(onBlur: true)
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
                            ->afterStateUpdated(function ($state, Schemas\Set $set, $get) {
                                if (empty($state)) {
                                    return;
                                }
                                
                                // Try to parse and format the JSON
                                $decoded = json_decode($state, true);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    // Re-format the JSON with proper indentation
                                    $formatted = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                                    $set('json_ld', $formatted);
                                }
                            })
                            ->rules(['nullable', 'string', new ValidJsonLd()])
                            ->validationMessages([
                                'string' => 'The JSON-LD must be a string.',
                            ]),
                        Forms\Components\TextInput::make('canonical_url')
                            ->label('Canonical URL')
                            ->placeholder('/')
                            ->helperText('Enter a relative path (e.g., /, /about, /services) or full URL (e.g., https://example.com/path). Used to avoid duplicate content issues.')
                            ->suffixIcon('heroicon-m-link')
                            ->suffixIconColor('primary')
                            ->rules(['nullable', new ValidCanonicalUrl()])
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Schemas\Set $set) {
                                if (!empty($state)) {
                                    // Auto-format the URL
                                    $trimmed = trim($state);
                                    if ($trimmed !== $state) {
                                        $set('canonical_url', $trimmed);
                                    }
                                }
                            }),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Page Name'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->label('Slug'),
                Tables\Columns\TextColumn::make('meta_title')
                    ->limit(50)
                    ->label('Meta Title')
                    ->toggleable(),
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
                Tables\Columns\TextColumn::make('canonical_url')
                    ->limit(50)
                    ->label('Canonical URL')
                    ->toggleable()
                    ->url(fn ($record) => $record->canonical_url)
                    ->openUrlInNewTab(),
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
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Last Updated')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
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
            'index' => Pages\ListCorePages::route('/'),
            'create' => Pages\CreateCorePage::route('/create'),
            'edit' => Pages\EditCorePage::route('/{record}/edit'),
        ];
    }
}
