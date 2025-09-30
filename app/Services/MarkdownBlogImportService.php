<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class MarkdownBlogImportService
{
    protected CommonMarkConverter $converter;
    protected ActivityLogger $logger;

    public function __construct()
    {
        // Configure CommonMark with GitHub Flavored Markdown
        $environment = new Environment([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new TableExtension());

        $this->converter = new CommonMarkConverter([], $environment);
        $this->logger = new ActivityLogger();
    }

    /**
     * Import a single markdown file as a blog post
     */
    public function importFile(string $filePath): array
    {
        try {
            if (!file_exists($filePath)) {
                throw new \Exception("File not found: {$filePath}");
            }

            $content = file_get_contents($filePath);

            // Parse frontmatter and content
            $document = YamlFrontMatter::parse($content);
            $frontmatter = $document->matter();
            $markdownContent = $document->body();

            // Convert markdown to HTML
            $htmlContent = $this->converter->convert($markdownContent)->getContent();

            // Process the blog post data
            $data = $this->processFrontmatter($frontmatter, $htmlContent);

            // Create the blog post
            $blogPost = $this->createBlogPost($data);

            $this->logger->log('blog_post_import', 'Blog post imported from markdown', [
                'file' => basename($filePath),
                'title' => $blogPost->name,
                'slug' => $blogPost->slug,
            ]);

            return [
                'success' => true,
                'blog_post' => $blogPost,
                'message' => "Successfully imported: {$blogPost->name}",
            ];

        } catch (\Exception $e) {
            $this->logger->logError('blog_post_import', $e->getMessage(), [
                'file' => basename($filePath),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Import multiple markdown files
     */
    public function importDirectory(string $directory): array
    {
        $results = [
            'successful' => 0,
            'failed' => 0,
            'imported_posts' => [],
            'errors' => [],
        ];

        if (!is_dir($directory)) {
            throw new \Exception("Directory not found: {$directory}");
        }

        $files = glob($directory . '/*.md');

        foreach ($files as $file) {
            $result = $this->importFile($file);

            if ($result['success']) {
                $results['successful']++;
                $results['imported_posts'][] = $result['blog_post'];
            } else {
                $results['failed']++;
                $results['errors'][] = [
                    'file' => basename($file),
                    'error' => $result['error'],
                ];
            }
        }

        return $results;
    }

    /**
     * Process frontmatter data and prepare for blog post creation
     */
    protected function processFrontmatter(array $frontmatter, string $htmlContent): array
    {
        $data = [
            'content' => $htmlContent,
        ];

        // Map frontmatter fields to blog post fields
        $data['name'] = $frontmatter['title'] ?? $frontmatter['name'] ?? 'Untitled Post';

        // Generate or use provided slug
        $data['slug'] = $frontmatter['slug'] ?? Str::slug($data['name']);
        $data['slug'] = $this->ensureUniqueSlug($data['slug']);

        // Extract excerpt
        if (isset($frontmatter['excerpt'])) {
            $data['excerpt'] = $frontmatter['excerpt'];
        } elseif (isset($frontmatter['description'])) {
            $data['excerpt'] = $frontmatter['description'];
        } else {
            // Auto-generate excerpt from content
            $data['excerpt'] = Str::limit(strip_tags($htmlContent), 300);
        }

        // Handle author
        if (isset($frontmatter['author'])) {
            $author = User::where('name', $frontmatter['author'])
                ->orWhere('email', $frontmatter['author'])
                ->first();

            $data['author_id'] = $author?->id ?? User::first()?->id;
        } elseif (isset($frontmatter['author_email'])) {
            $author = User::where('email', $frontmatter['author_email'])->first();
            $data['author_id'] = $author?->id ?? User::first()?->id;
        } else {
            $data['author_id'] = User::first()?->id;
        }

        // Handle category
        if (isset($frontmatter['category'])) {
            $category = BlogCategory::firstOrCreate(
                ['name' => $frontmatter['category']],
                ['slug' => Str::slug($frontmatter['category'])]
            );
            $data['category_id'] = $category->id;
        } elseif (isset($frontmatter['categories']) && is_array($frontmatter['categories'])) {
            // Use first category if multiple provided
            $categoryName = $frontmatter['categories'][0];
            $category = BlogCategory::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );
            $data['category_id'] = $category->id;
        }

        // Handle tags
        if (isset($frontmatter['tags'])) {
            if (is_array($frontmatter['tags'])) {
                $data['tags'] = implode(', ', $frontmatter['tags']);
            } else {
                $data['tags'] = $frontmatter['tags'];
            }
        }

        // Handle dates
        if (isset($frontmatter['date'])) {
            $data['published_at'] = Carbon::parse($frontmatter['date']);
        } elseif (isset($frontmatter['published_at'])) {
            $data['published_at'] = Carbon::parse($frontmatter['published_at']);
        } elseif (isset($frontmatter['created_at'])) {
            $data['published_at'] = Carbon::parse($frontmatter['created_at']);
        }

        // Handle publishing status
        $data['is_published'] = $frontmatter['published'] ?? $frontmatter['is_published'] ?? true;
        $data['is_featured'] = $frontmatter['featured'] ?? $frontmatter['is_featured'] ?? false;

        // Handle reading time
        if (isset($frontmatter['reading_time'])) {
            $data['reading_time'] = (int) $frontmatter['reading_time'];
        } else {
            // Calculate reading time (200 words per minute)
            $wordCount = str_word_count(strip_tags($htmlContent));
            $data['reading_time'] = max(1, round($wordCount / 200));
        }

        // Handle featured image
        if (isset($frontmatter['image'])) {
            $data['featured_image'] = $frontmatter['image'];
        } elseif (isset($frontmatter['featured_image'])) {
            $data['featured_image'] = $frontmatter['featured_image'];
        } elseif (isset($frontmatter['thumbnail'])) {
            $data['featured_image'] = $frontmatter['thumbnail'];
        }

        // Handle SEO metadata
        $data['meta_title'] = $frontmatter['meta_title'] ?? $frontmatter['seo_title'] ?? $data['name'];
        $data['meta_description'] = $frontmatter['meta_description'] ?? $frontmatter['seo_description'] ?? $data['excerpt'];
        $data['meta_keywords'] = $frontmatter['meta_keywords'] ?? $frontmatter['keywords'] ?? $data['tags'] ?? '';

        return $data;
    }

    /**
     * Ensure slug is unique
     */
    protected function ensureUniqueSlug(string $slug): string
    {
        $originalSlug = $slug;
        $counter = 1;

        while (BlogPost::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Create a blog post from processed data
     */
    protected function createBlogPost(array $data): BlogPost
    {
        return BlogPost::create($data);
    }

    /**
     * Preview markdown file without importing
     */
    public function previewFile(string $filePath): array
    {
        try {
            if (!file_exists($filePath)) {
                throw new \Exception("File not found: {$filePath}");
            }

            $content = file_get_contents($filePath);

            // Parse frontmatter and content
            $document = YamlFrontMatter::parse($content);
            $frontmatter = $document->matter();
            $markdownContent = $document->body();

            // Convert markdown to HTML
            $htmlContent = $this->converter->convert($markdownContent)->getContent();

            // Process the blog post data
            $data = $this->processFrontmatter($frontmatter, $htmlContent);

            return [
                'success' => true,
                'data' => $data,
                'frontmatter' => $frontmatter,
                'markdown_preview' => Str::limit($markdownContent, 500),
                'html_preview' => Str::limit(strip_tags($htmlContent), 500),
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}