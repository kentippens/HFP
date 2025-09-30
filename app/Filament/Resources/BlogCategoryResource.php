<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogCategoryResource\Pages;
use App\Filament\Resources\BlogCategoryResource\RelationManagers;
use App\Models\BlogCategory;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-tag';
    }
    
    public static function getNavigationLabel(): string
    {
        return 'Categories';
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Blog Management';
    }
    
    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Category Information')
                    ->description('Basic category details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(fn ($state, Schemas\Set $set) => $set('slug', \Str::slug($state)))
                            ->label('Category Name'),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(BlogCategory::class, 'slug', ignoreRecord: true)
                            ->label('URL Slug'),
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->maxLength(500)
                            ->label('Description')
                            ->helperText('A brief description of what this category covers'),
                    ])->columns(1),
                    
                Schemas\Components\Section::make('SEO Settings')
                    ->description('Search engine optimization')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(255)
                            ->label('Meta Title')
                            ->helperText('Leave empty to use category name'),
                        Forms\Components\TextInput::make('meta_description')
                            ->maxLength(160)
                            ->label('Meta Description')
                            ->helperText('Maximum 160 characters'),
                    ])->collapsible(),
                    
                Schemas\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Active')
                            ->helperText('Inactive categories will not be displayed on the website'),
                        Forms\Components\TextInput::make('order_index')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Category Name'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable()
                    ->label('URL Slug'),
                Tables\Columns\TextColumn::make('published_posts_count')
                    ->counts('posts', fn ($query) => $query->published())
                    ->label('Published Posts')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('order_index')
                    ->numeric()
                    ->sortable()
                    ->label('Order'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order_index', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->boolean()
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only')
                    ->native(false),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->before(function (BlogCategory $record) {
                        if ($record->posts()->exists()) {
                            \Filament\Notifications\Notification::make()
                                ->danger()
                                ->title('Cannot delete category')
                                ->body('This category has posts. Please reassign or delete them first.')
                                ->persistent()
                                ->send();
                            return false;
                        }
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->posts()->exists()) {
                                    \Filament\Notifications\Notification::make()
                                        ->danger()
                                        ->title('Cannot delete categories')
                                        ->body('Some categories have posts. Please reassign or delete them first.')
                                        ->persistent()
                                        ->send();
                                    return false;
                                }
                            }
                        }),
                ]),
            ])
            ->reorderable('order_index');
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
            'index' => Pages\ListBlogCategories::route('/'),
            'create' => Pages\CreateBlogCategory::route('/create'),
            'edit' => Pages\EditBlogCategory::route('/{record}/edit'),
        ];
    }


    /**
     * Determine if the user can view any records.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('viewAny', BlogCategory::class) ?? false;
    }

    /**
     * Determine if the user can create records.
     */
    public static function canCreate(): bool
    {
        return auth()->user()?->can('create', BlogCategory::class) ?? false;
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
