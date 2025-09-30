<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Filament\Resources\BlogPostResource\RelationManagers;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Rules\ValidJsonLd;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;
use App\Services\ActivityLogger;
use App\Traits\HandlesBulkOperations;
use Filament\Notifications\Notification;
use App\Exceptions\BlogWorkflowException;

class BlogPostResource extends Resource
{
    use HandlesBulkOperations;
    protected static ?string $model = BlogPost::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationLabel(): string
    {
        return 'Blog Posts';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Blog Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(fn ($state, Schemas\Set $set) => $set('slug', \Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->relationship('blogCategory', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, Schemas\Set $set) => $set('slug', \Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(BlogCategory::class, 'slug'),
                                Forms\Components\Textarea::make('description')
                                    ->rows(2),
                                Forms\Components\Toggle::make('is_active')
                                    ->default(true),
                            ])
                            ->createOptionModalHeading('Create New Category'),
                        Forms\Components\TextInput::make('category')
                            ->label('Legacy Category')
                            ->disabled()
                            ->dehydrated(false)
                            ->hidden(fn ($record) => !$record || !$record->category),
                        Forms\Components\TextInput::make('author')
                            ->required()
                            ->default('Hexagon Team')
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->label('Blog Content')
                            ->helperText('Use the rich text editor to create engaging blog content. Images, links, and formatting are supported.')
                            ->placeholder('Start writing your blog post here...')
                            ->rules([
                                'required',
                                'string',
                                'min:50',
                                'max:50000',
                            ])
                            ->validationMessages([
                                'required' => 'Blog content is required.',
                                'min' => 'Blog content must be at least 50 characters long.',
                                'max' => 'Blog content cannot exceed 50,000 characters.',
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('blog')
                            ->fileAttachmentsVisibility('public'),
                        Forms\Components\Textarea::make('excerpt')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->disk('public')
                            ->directory('blog')
                            ->visibility('public')
                            ->label('Featured Image (for blog post details)')
                            ->deletable()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                            ->maxSize(5120)
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->nullable(),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->disk('public')
                            ->directory('blog')
                            ->visibility('public')
                            ->label('Thumbnail (for blog listing)')
                            ->deletable()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                            ->maxSize(5120)
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->nullable(),
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
                            ->options(\App\Models\BlogPost::META_ROBOTS_OPTIONS)
                            ->default('index, follow')
                            ->required()
                            ->helperText('Control how search engines crawl and index this page')
                            ->suffixIcon('heroicon-m-eye')
                            ->suffixIconColor('secondary'),
                        Forms\Components\Textarea::make('json_ld')
                            ->label('JSON-LD Structured Data')
                            ->rows(8)
                            ->placeholder('{"@context": "https://schema.org", "@type": "BlogPosting", "headline": "Your Blog Post Title"}')
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
                                
                                // Ensure we're working with a string
                                $jsonString = is_string($state) ? $state : (is_array($state) ? json_encode($state) : (string) $state);
                                
                                // Try to parse and format the JSON
                                $decoded = json_decode($jsonString, true);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    // Re-format the JSON with proper indentation
                                    $formatted = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                                    $set('json_ld', $formatted);
                                }
                            })
                            ->rules(['nullable', new ValidJsonLd()])
                            ->validationMessages([
                                'string' => 'The JSON-LD must be a string.',
                            ]),
                        Forms\Components\TextInput::make('canonical_url')
                            ->label('Canonical URL')
                            ->placeholder('/blog/post-slug')
                            ->helperText('Enter a relative path (e.g., /blog/post-slug) or full URL (e.g., https://example.com/path). Used to avoid duplicate content issues.')
                            ->suffixIcon('heroicon-m-link')
                            ->suffixIconColor('primary'),
                        Forms\Components\Toggle::make('include_in_sitemap')
                            ->required()
                            ->default(true)
                            ->label('Include in Sitemap')
                            ->helperText('Whether this blog post should appear in sitemap.xml'),
                    ])
                    ->columns(1),
                Schemas\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options(BlogPost::STATUSES)
                            ->required()
                            ->default(BlogPost::STATUS_DRAFT)
                            ->reactive()
                            ->afterStateUpdated(function ($state, Schemas\Set $set, $record) {
                                if ($state === BlogPost::STATUS_PUBLISHED && !$record?->published_at) {
                                    $set('published_at', now());
                                }
                            })
                            ->disabled(fn ($record) => $record && !$record->canTransitionTo($record->status))
                            ->helperText(fn ($record) => $record ? 'Current status: ' . $record->status_label : 'New posts start as drafts'),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->visible(fn (Schemas\Get $get) => $get('status') === BlogPost::STATUS_PUBLISHED)
                            ->required(fn (Schemas\Get $get) => $get('status') === BlogPost::STATUS_PUBLISHED),
                        Forms\Components\Select::make('reviewer_id')
                            ->label('Reviewer')
                            ->relationship('reviewer', 'name')
                            ->visible(fn (Schemas\Get $get) => in_array($get('status'), [BlogPost::STATUS_REVIEW, BlogPost::STATUS_PUBLISHED]))
                            ->disabled(),
                        Forms\Components\Textarea::make('review_notes')
                            ->label('Review Notes')
                            ->visible(fn (Schemas\Get $get) => in_array($get('status'), [BlogPost::STATUS_REVIEW, BlogPost::STATUS_PUBLISHED]))
                            ->rows(3),
                        Forms\Components\DateTimePicker::make('submitted_for_review_at')
                            ->label('Submitted for Review')
                            ->visible(fn (Schemas\Get $get) => $get('status') !== BlogPost::STATUS_DRAFT)
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('reviewed_at')
                            ->label('Reviewed At')
                            ->visible(fn (Schemas\Get $get) => in_array($get('status'), [BlogPost::STATUS_PUBLISHED, BlogPost::STATUS_ARCHIVED]))
                            ->disabled(),
                        Forms\Components\TextInput::make('version')
                            ->label('Version')
                            ->disabled()
                            ->default(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->limit(50)
                    ->label('Title'),
                Tables\Columns\TextColumn::make('blogCategory.name')
                    ->badge()
                    ->searchable()
                    ->label('Category')
                    ->sortable(),
                Tables\Columns\TextColumn::make('author')
                    ->searchable()
                    ->toggleable(),
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
                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular()
                    ->label('Featured Image')
                    ->toggleable(),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->circular()
                    ->label('Thumbnail')
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray' => BlogPost::STATUS_DRAFT,
                        'warning' => BlogPost::STATUS_REVIEW,
                        'success' => BlogPost::STATUS_PUBLISHED,
                        'danger' => BlogPost::STATUS_ARCHIVED,
                    ])
                    ->label('Status'),
                Tables\Columns\IconColumn::make('include_in_sitemap')
                    ->boolean()
                    ->label('In Sitemap')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Published Date'),
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
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('blogCategory', 'name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('status')
                    ->options(BlogPost::STATUSES)
                    ->label('Status'),
            ])
            ->actions([
                EditAction::make(),
                ViewAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('submit_for_review')
                        ->label('Submit for Review')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $count = 0;
                            $errors = [];

                            foreach ($records as $record) {
                                try {
                                    if ($record->status === BlogPost::STATUS_DRAFT && $record->submitForReview()) {
                                        $count++;
                                    }
                                } catch (BlogWorkflowException $e) {
                                    $errors[] = "Post '{$record->name}': {$e->getMessage()}";
                                } catch (\Exception $e) {
                                    $errors[] = "Post '{$record->name}': Unexpected error";
                                    \Log::error("Submit for review failed for post {$record->id}: " . $e->getMessage());
                                }
                            }

                            if ($count > 0) {
                                Notification::make()
                                    ->title("Submitted {$count} post(s) for review")
                                    ->success()
                                    ->send();
                            }

                            if (!empty($errors)) {
                                Notification::make()
                                    ->title('Some posts could not be submitted')
                                    ->body(implode("\n", $errors))
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('publish')
                        ->label('Publish')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $count = 0;
                            $errors = [];
                            $reviewerId = auth()->id();

                            if (!$reviewerId) {
                                Notification::make()
                                    ->title('Authentication required')
                                    ->body('You must be logged in to publish posts')
                                    ->danger()
                                    ->send();
                                return;
                            }

                            foreach ($records as $record) {
                                try {
                                    if ($record->status === BlogPost::STATUS_REVIEW && $record->approve($reviewerId)) {
                                        $count++;
                                    }
                                } catch (BlogWorkflowException $e) {
                                    $errors[] = "Post '{$record->name}': {$e->getMessage()}";
                                } catch (\Exception $e) {
                                    $errors[] = "Post '{$record->name}': Unexpected error";
                                    \Log::error("Publish failed for post {$record->id}: " . $e->getMessage());
                                }
                            }

                            if ($count > 0) {
                                Notification::make()
                                    ->title("Published {$count} post(s)")
                                    ->success()
                                    ->send();
                            }

                            if (!empty($errors)) {
                                Notification::make()
                                    ->title('Some posts could not be published')
                                    ->body(implode("\n", $errors))
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('archive')
                        ->label('Archive')
                        ->icon('heroicon-o-archive-box')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Archive Posts')
                        ->modalDescription('Are you sure you want to archive these posts? They will no longer be visible on the website.')
                        ->action(function (Collection $records): void {
                            $count = 0;
                            $errors = [];

                            foreach ($records as $record) {
                                try {
                                    if ($record->archive()) {
                                        $count++;
                                    }
                                } catch (BlogWorkflowException $e) {
                                    $errors[] = "Post '{$record->name}': {$e->getMessage()}";
                                } catch (\Exception $e) {
                                    $errors[] = "Post '{$record->name}': Unexpected error";
                                    \Log::error("Archive failed for post {$record->id}: " . $e->getMessage());
                                }
                            }

                            if ($count > 0) {
                                Notification::make()
                                    ->title("Archived {$count} post(s)")
                                    ->success()
                                    ->send();
                            }

                            if (!empty($errors)) {
                                Notification::make()
                                    ->title('Some posts could not be archived')
                                    ->body(implode("\n", $errors))
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('update_category')
                        ->label('Change Category')
                        ->icon('heroicon-o-tag')
                        ->form([
                            Forms\Components\Select::make('category_id')
                                ->label('Category')
                                ->options(BlogCategory::pluck('name', 'id'))
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            static::executeBulkUpdate(
                                $records,
                                ['category_id' => $data['category_id']],
                                'category update',
                                'bulk_category_update'
                            );
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('update_author')
                        ->label('Change Author')
                        ->icon('heroicon-o-user')
                        ->form([
                            Forms\Components\Select::make('author_id')
                                ->label('Author')
                                ->relationship('author', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            static::executeBulkUpdate(
                                $records,
                                ['author_id' => $data['author_id']],
                                'author update',
                                'bulk_author_update'
                            );
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('include_in_sitemap')
                        ->label('Include in Sitemap')
                        ->icon('heroicon-o-globe-alt')
                        ->color('info')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            static::executeBulkUpdate(
                                $records,
                                ['include_in_sitemap' => true],
                                'sitemap inclusion',
                                'bulk_sitemap_include'
                            );
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('exclude_from_sitemap')
                        ->label('Exclude from Sitemap')
                        ->icon('heroicon-o-eye-slash')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            static::executeBulkUpdate(
                                $records,
                                ['include_in_sitemap' => false],
                                'sitemap exclusion',
                                'bulk_sitemap_exclude'
                            );
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('update_meta_robots')
                        ->label('Update Meta Robots')
                        ->icon('heroicon-o-magnifying-glass')
                        ->form([
                            Forms\Components\Select::make('meta_robots')
                                ->label('Meta Robots')
                                ->options(\App\Models\BlogPost::META_ROBOTS_OPTIONS)
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            static::executeBulkUpdate(
                                $records,
                                ['meta_robots' => $data['meta_robots']],
                                'meta robots update',
                                'bulk_meta_robots_update'
                            );
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('duplicate')
                        ->label('Duplicate')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('secondary')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            static::executeBulkDuplicate($records, ' (Copy)');
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('export')
                        ->label('Export to CSV')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('primary')
                        ->action(function (Collection $records): \Symfony\Component\HttpFoundation\StreamedResponse {
                            $fileName = 'blog-posts-export-' . date('Y-m-d-His') . '.csv';

                            return response()->streamDownload(function () use ($records) {
                                $handle = fopen('php://output', 'w');

                                // Add CSV headers
                                fputcsv($handle, [
                                    'ID',
                                    'Title',
                                    'Slug',
                                    'Category',
                                    'Author',
                                    'Excerpt',
                                    'Published',
                                    'Published Date',
                                    'In Sitemap',
                                    'Meta Title',
                                    'Meta Description',
                                    'Meta Robots',
                                    'Created At',
                                    'Updated At',
                                ]);

                                // Add data rows
                                foreach ($records as $post) {
                                    fputcsv($handle, [
                                        $post->id,
                                        $post->name,
                                        $post->slug,
                                        $post->blogCategory?->name ?? $post->category ?? '',
                                        $post->author?->name ?? $post->author ?? '',
                                        $post->excerpt ?? '',
                                        $post->is_published ? 'Yes' : 'No',
                                        $post->published_at?->format('Y-m-d H:i:s') ?? '',
                                        $post->include_in_sitemap ? 'Yes' : 'No',
                                        $post->meta_title ?? '',
                                        $post->meta_description ?? '',
                                        $post->meta_robots ?? '',
                                        $post->created_at,
                                        $post->updated_at,
                                    ]);
                                }

                                fclose($handle);

                                ActivityLogger::logExport('blog posts', $records->count());
                            }, $fileName);
                        })
                        ->deselectRecordsAfterCompletion(),

                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
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
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }

    /**
     * Determine if the user can view any blog posts.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('viewAny', BlogPost::class) ?? false;
    }

    /**
     * Determine if the user can create blog posts.
     */
    public static function canCreate(): bool
    {
        return auth()->user()?->can('create', BlogPost::class) ?? false;
    }

    /**
     * Determine if the user can edit the blog post.
     */
    public static function canEdit($record): bool
    {
        return auth()->user()?->can('update', $record) ?? false;
    }

    /**
     * Determine if the user can delete the blog post.
     */
    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete', $record) ?? false;
    }

    /**
     * Determine if the user can view the blog post.
     */
    public static function canView($record): bool
    {
        return auth()->user()?->can('view', $record) ?? false;
    }

    /**
     * Apply authorization to Eloquent query.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // If user can only view their own posts, filter by author
        if (auth()->user() && !auth()->user()->isAdmin() && !auth()->user()->hasRole('manager')) {
            if (auth()->user()->hasPermission('blog.view')) {
                // Can view all posts
                return $query;
            } elseif (auth()->user()->hasPermission('blog.create') || auth()->user()->hasPermission('blog.edit')) {
                // Can only view/edit their own posts
                return $query->where('author_id', auth()->id());
            }
        }

        return $query;
    }
}
