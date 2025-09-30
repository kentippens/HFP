<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\User;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogPostImportService extends BaseImportService
{
    protected function getModel(): string
    {
        return BlogPost::class;
    }

    public function getValidationRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:1000',
            'author_email' => 'nullable|email|exists:users,email',
            'author_id' => 'nullable|integer|exists:users,id',
            'category_name' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:blog_categories,id',
            'tags' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'reading_time' => 'nullable|integer|min:1',
            'featured_image' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
        ];
    }

    protected function transformRow(array $row): array
    {
        // Generate slug if not provided
        if (empty($row['slug']) && !empty($row['title'])) {
            $row['slug'] = Str::slug($row['title']);

            // Ensure slug uniqueness
            $originalSlug = $row['slug'];
            $counter = 1;
            while (BlogPost::where('slug', $row['slug'])->exists()) {
                $row['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle author resolution
        if (!empty($row['author_email'])) {
            $author = User::where('email', $row['author_email'])->first();
            if ($author) {
                $row['author_id'] = $author->id;
            }
            unset($row['author_email']);
        }

        // If no author specified, use first admin user
        if (empty($row['author_id'])) {
            $row['author_id'] = User::first()?->id;
        }

        // Handle category resolution
        if (!empty($row['category_name'])) {
            $category = BlogCategory::firstOrCreate(
                ['name' => $row['category_name']],
                ['slug' => Str::slug($row['category_name'])]
            );
            $row['category_id'] = $category->id;
            unset($row['category_name']);
        }

        // Convert string booleans to actual booleans
        $row['is_published'] = $this->convertToBoolean($row['is_published'] ?? false);
        $row['is_featured'] = $this->convertToBoolean($row['is_featured'] ?? false);

        // Handle published_at date
        if (!empty($row['published_at'])) {
            try {
                $row['published_at'] = Carbon::parse($row['published_at']);
            } catch (\Exception $e) {
                $row['published_at'] = null;
            }
        } elseif ($row['is_published']) {
            $row['published_at'] = now();
        }

        // Keep tags as string for validation, model will handle conversion
        if (!empty($row['tags']) && is_string($row['tags'])) {
            $row['tags'] = trim($row['tags']);
        }

        // Calculate reading time if not provided
        if (empty($row['reading_time']) && !empty($row['content'])) {
            $wordCount = str_word_count(strip_tags($row['content']));
            $row['reading_time'] = max(1, round($wordCount / 200)); // Average reading speed: 200 words per minute
        }

        // Generate excerpt if not provided
        if (empty($row['excerpt']) && !empty($row['content'])) {
            $row['excerpt'] = Str::limit(strip_tags($row['content']), 300);
        }

        // Remove sort_order as it doesn't exist in the table
        unset($row['sort_order']);

        return $row;
    }

    protected function createRecord(array $data): void
    {
        // Ensure title is present (BlogPost uses 'name' field for title)
        if (isset($data['title']) && !isset($data['name'])) {
            $data['name'] = $data['title'];
            unset($data['title']);
        }

        BlogPost::create($data);
    }

    protected function convertToBoolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {
            $value = strtolower(trim($value));
            return in_array($value, ['1', 'true', 'yes', 'on', 'published', 'featured']);
        }

        return (bool) $value;
    }

    protected function getSampleData(): array
    {
        return [
            [
                'title' => 'Pool Maintenance Tips for Summer',
                'slug' => 'pool-maintenance-tips-summer',
                'content' => 'Summer is the perfect time to enjoy your pool, but it also requires extra maintenance. Here are some essential tips to keep your pool crystal clear and safe for swimming...',
                'excerpt' => 'Essential summer pool maintenance tips to keep your pool clean and safe.',
                'author_email' => 'admin@example.com',
                'category_name' => 'Pool Care',
                'tags' => 'pool maintenance, summer, tips, cleaning',
                'is_published' => 'Yes',
                'is_featured' => 'Yes',
                'published_at' => '2024-06-01 10:00:00',
                'reading_time' => 5,
                'featured_image' => 'images/blog/pool-maintenance-summer.jpg',
                'meta_title' => 'Essential Pool Maintenance Tips for Summer',
                'meta_description' => 'Learn the best pool maintenance practices for summer season',
                'meta_keywords' => 'pool maintenance, summer pool care, swimming pool tips'
            ],
            [
                'title' => 'Choosing the Right Pool Resurfacing Material',
                'slug' => 'choosing-pool-resurfacing-material',
                'content' => 'When it comes time to resurface your pool, choosing the right material is crucial for both aesthetics and longevity. This comprehensive guide will help you make an informed decision...',
                'excerpt' => 'A comprehensive guide to selecting the best pool resurfacing materials.',
                'author_email' => 'admin@example.com',
                'category_name' => 'Pool Renovation',
                'tags' => 'pool resurfacing, materials, renovation, guide',
                'is_published' => 'Yes',
                'is_featured' => 'No',
                'published_at' => '2024-05-15 14:30:00',
                'reading_time' => 8,
                'featured_image' => 'images/blog/pool-resurfacing-materials.jpg',
                'meta_title' => 'Pool Resurfacing Materials: Complete Guide',
                'meta_description' => 'Compare different pool resurfacing materials and make the right choice',
                'meta_keywords' => 'pool resurfacing, pool materials, pool renovation'
            ]
        ];
    }
}