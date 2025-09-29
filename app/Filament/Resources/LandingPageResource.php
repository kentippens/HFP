<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandingPageResource\Pages;
use App\Filament\Resources\LandingPageResource\RelationManagers;
use App\Models\LandingPage;
use App\Rules\ValidJsonLd;
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

class LandingPageResource extends Resource
{
    protected static ?string $model = LandingPage::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-rectangle-stack';
    }

    public static function getNavigationLabel(): string
    {
        return 'Landing Pages';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Content Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 30;
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
                            ->label('Page Title')
                            ->reactive()
                            ->afterStateUpdated(fn ($state, Schemas\Set $set) => $set('slug', \Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label('Slug')
                            ->helperText('Used in the URL (e.g., /lp/slug)'),
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->label('Page Content')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('landing-pages')
                            ->fileAttachmentsVisibility('public'),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Active'),
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
                            ->options(\App\Models\LandingPage::META_ROBOTS_OPTIONS)
                            ->default('index, follow')
                            ->required()
                            ->helperText('Control how search engines crawl and index this page')
                            ->suffixIcon('heroicon-m-eye')
                            ->suffixIconColor('secondary'),
                        Forms\Components\Textarea::make('json_ld')
                            ->label('JSON-LD Structured Data')
                            ->rows(8)
                            ->placeholder('{"@context": "https://schema.org", "@type": "WebPage", "name": "Your Landing Page Title"}')
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
                            ->placeholder('/lp/special-offer')
                            ->helperText('Enter a relative path (e.g., /lp/special-offer) or full URL (e.g., https://example.com/path). Used to avoid duplicate content issues.')
                            ->suffixIcon('heroicon-m-link')
                            ->suffixIconColor('primary'),
                        Forms\Components\Toggle::make('include_in_sitemap')
                            ->required()
                            ->default(true)
                            ->label('Include in Sitemap')
                            ->helperText('Whether this landing page should appear in sitemap.xml'),
                    ])
                    ->columns(1),
                Schemas\Components\Section::make('Custom Code')
                    ->schema([
                        Forms\Components\Textarea::make('custom_css')
                            ->label('Custom CSS')
                            ->rows(6)
                            ->helperText('Custom CSS for this landing page')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('custom_js')
                            ->label('Custom JavaScript')
                            ->rows(6)
                            ->helperText('Custom JavaScript for this landing page')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('conversion_tracking_code')
                            ->label('Conversion Tracking Code')
                            ->rows(4)
                            ->helperText('Tracking code for conversions (e.g., Google Ads, Facebook Pixel)')
                            ->columnSpanFull(),
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
                    ->limit(50)
                    ->label('Page Title'),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ]);
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
            'index' => Pages\ListLandingPages::route('/'),
            'create' => Pages\CreateLandingPage::route('/create'),
            'edit' => Pages\EditLandingPage::route('/{record}/edit'),
        ];
    }
}
