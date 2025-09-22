<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiloResource\Pages;
use App\Filament\Resources\SiloResource\RelationManagers;
use App\Models\Silo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Forms\Get;

class SiloResource extends Resource
{
    protected static ?string $model = Silo::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    
    protected static ?string $navigationGroup = 'Content Management';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $navigationLabel = 'Silos';
    
    protected static ?string $pluralLabel = 'Silos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->minLength(3)
                            ->live(debounce: 1000)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->rules(['required', 'string', 'min:3', 'max:255']),
                            
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL-friendly version of the name')
                            ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                            ->rules([
                                'required',
                                'string',
                                'max:255',
                                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                            ]),
                            
                        Forms\Components\Select::make('parent_id')
                            ->label('Parent Silo')
                            ->options(function (?Silo $record) {
                                return Silo::query()
                                    ->when($record, fn ($query) => $query->where('id', '!=', $record->id))
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->placeholder('None (Top Level)')
                            ->helperText('Select a parent to create a sub-silo'),
                            
                        Forms\Components\Select::make('template')
                            ->options([
                                'default' => 'Default',
                                'fiberglass-pool-resurfacing' => 'Fiberglass Pool Resurfacing',
                                'plaster-marcite-resurfacing' => 'Plaster Marcite Resurfacing',
                                'pool-crack-repair' => 'Pool Crack Repair',
                                'pool-tile-remodeling' => 'Pool Tile Remodeling',
                            ])
                            ->default('default')
                            ->required(),
                            
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'table',
                                'undo',
                            ]),
                            
                        Forms\Components\Textarea::make('overview')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),
                    
                Forms\Components\Section::make('Features & Benefits')
                    ->schema([
                        Forms\Components\Repeater::make('features')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                            
                        Forms\Components\Repeater::make('benefits')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                    ]),
                    
                Forms\Components\Section::make('Images')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->directory('silos/featured')
                            ->imageEditor()
                            ->maxSize(5120),
                            
                        Forms\Components\FileUpload::make('homepage_image')
                            ->image()
                            ->directory('silos/homepage')
                            ->imageEditor()
                            ->maxSize(5120),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(255)
                            ->helperText('Leave empty to use the silo name'),
                            
                        Forms\Components\Textarea::make('meta_description')
                            ->maxLength(350)
                            ->rows(3)
                            ->helperText('Recommended: 150-160 characters'),
                            
                        Forms\Components\TextInput::make('canonical_url')
                            ->url()
                            ->maxLength(255),
                            
                        Forms\Components\Select::make('meta_robots')
                            ->options([
                                'index, follow' => 'Index, Follow',
                                'noindex, follow' => 'No Index, Follow',
                                'index, nofollow' => 'Index, No Follow',
                                'noindex, nofollow' => 'No Index, No Follow',
                            ])
                            ->default('index, follow'),
                            
                        Forms\Components\Textarea::make('json_ld')
                            ->label('JSON-LD Schema')
                            ->rows(10)
                            ->helperText('Enter valid JSON for structured data')
                            ->columnSpanFull()
                            ->afterStateUpdated(function ($state, $component) {
                                if ($state) {
                                    try {
                                        json_decode($state);
                                        if (json_last_error() !== JSON_ERROR_NONE) {
                                            $component->state(null);
                                            throw new \Exception('Invalid JSON: ' . json_last_error_msg());
                                        }
                                    } catch (\Exception $e) {
                                        $component->state(null);
                                    }
                                }
                            }),
                    ])
                    ->columns(2)
                    ->collapsed(),
                    
                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->helperText('Inactive silos will not be displayed on the website'),
                            
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug copied!')
                    ->copyMessageDuration(1500),
                    
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent')
                    ->sortable()
                    ->placeholder('Top Level'),
                    
                Tables\Columns\TextColumn::make('template')
                    ->badge()
                    ->color('info'),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->label('Order'),
                    
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
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Parent')
                    ->options([
                        '' => 'Top Level Only',
                    ] + Silo::root()->pluck('name', 'id')->toArray())
                    ->placeholder('All Silos'),
                    
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
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
            'index' => Pages\ListSilos::route('/'),
            'create' => Pages\CreateSilo::route('/create'),
            'edit' => Pages\EditSilo::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}