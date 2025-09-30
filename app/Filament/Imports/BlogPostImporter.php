<?php

namespace App\Filament\Imports;

use App\Models\BlogPost;
use App\Models\User;
use App\Models\BlogCategory;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogPostImporter extends Importer
{
    protected static ?string $model = BlogPost::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('title')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->example('Pool Maintenance Tips for Summer'),

            ImportColumn::make('slug')
                ->rules(['nullable', 'string', 'max:255', 'unique:blog_posts,slug'])
                ->example('pool-maintenance-tips-summer'),

            ImportColumn::make('content')
                ->requiredMapping()
                ->rules(['required', 'string'])
                ->example('Summer is the perfect time to enjoy your pool...'),

            ImportColumn::make('excerpt')
                ->rules(['nullable', 'string', 'max:1000'])
                ->example('Essential summer pool maintenance tips'),

            ImportColumn::make('author_email')
                ->rules(['nullable', 'email', 'exists:users,email'])
                ->example('admin@example.com'),

            ImportColumn::make('category_name')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('Pool Care'),

            ImportColumn::make('tags')
                ->rules(['nullable', 'string'])
                ->example('pool maintenance, summer, tips'),

            ImportColumn::make('is_published')
                ->boolean()
                ->rules(['nullable', 'boolean'])
                ->example('Yes'),

            ImportColumn::make('is_featured')
                ->boolean()
                ->rules(['nullable', 'boolean'])
                ->example('No'),

            ImportColumn::make('published_at')
                ->rules(['nullable', 'date'])
                ->example('2024-06-01 10:00:00'),

            ImportColumn::make('reading_time')
                ->numeric()
                ->rules(['nullable', 'integer', 'min:1'])
                ->example('5'),

            ImportColumn::make('featured_image')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('images/blog/pool-maintenance.jpg'),

            ImportColumn::make('meta_title')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('Essential Pool Maintenance Tips'),

            ImportColumn::make('meta_description')
                ->rules(['nullable', 'string', 'max:500'])
                ->example('Learn the best pool maintenance practices'),

            ImportColumn::make('meta_keywords')
                ->rules(['nullable', 'string'])
                ->example('pool maintenance, summer pool care'),
        ];
    }

    public function resolveRecord(): ?BlogPost
    {
        $data = $this->data;

        // Generate slug if not provided
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);

            // Ensure slug uniqueness
            $originalSlug = $data['slug'];
            $counter = 1;
            while (BlogPost::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle author resolution
        if (!empty($data['author_email'])) {
            $author = User::where('email', $data['author_email'])->first();
            if ($author) {
                $data['author_id'] = $author->id;
            }
            unset($data['author_email']);
        }

        // If no author specified, use first admin user
        if (empty($data['author_id'])) {
            $data['author_id'] = User::first()?->id;
        }

        // Handle category resolution
        if (!empty($data['category_name'])) {
            $category = BlogCategory::firstOrCreate(
                ['name' => $data['category_name']],
                ['slug' => Str::slug($data['category_name'])]
            );
            $data['category_id'] = $category->id;
            unset($data['category_name']);
        }

        // Handle published_at date
        if (!empty($data['published_at'])) {
            try {
                $data['published_at'] = Carbon::parse($data['published_at']);
            } catch (\Exception $e) {
                $data['published_at'] = null;
            }
        } elseif ($data['is_published'] ?? false) {
            $data['published_at'] = now();
        }

        // Convert tags from comma-separated string to array
        if (!empty($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }

        // Calculate reading time if not provided
        if (empty($data['reading_time']) && !empty($data['content'])) {
            $wordCount = str_word_count(strip_tags($data['content']));
            $data['reading_time'] = max(1, round($wordCount / 200));
        }

        // Generate excerpt if not provided
        if (empty($data['excerpt']) && !empty($data['content'])) {
            $data['excerpt'] = Str::limit(strip_tags($data['content']), 300);
        }

        // Remove sort_order as it doesn't exist in the table
        unset($data['sort_order']);

        return new BlogPost($data);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your blog post import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}