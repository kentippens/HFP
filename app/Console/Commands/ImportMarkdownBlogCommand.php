<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MarkdownBlogImportService;

class ImportMarkdownBlogCommand extends Command
{
    protected $signature = 'import:markdown-blog
                          {path : Path to markdown file or directory}
                          {--preview : Preview the import without saving}
                          {--recursive : Recursively search subdirectories for markdown files}';

    protected $description = 'Import blog posts from markdown files with frontmatter';

    public function handle()
    {
        $path = $this->argument('path');
        $preview = $this->option('preview');
        $recursive = $this->option('recursive');

        $importer = new MarkdownBlogImportService();

        // Check if path is file or directory
        if (is_file($path)) {
            $this->importFile($path, $importer, $preview);
        } elseif (is_dir($path)) {
            $this->importDirectory($path, $importer, $preview, $recursive);
        } else {
            $this->error("Path not found: {$path}");
            return 1;
        }

        return 0;
    }

    protected function importFile($filePath, $importer, $preview)
    {
        // Check file extension
        if (pathinfo($filePath, PATHINFO_EXTENSION) !== 'md') {
            $this->error("File is not a markdown file: {$filePath}");
            return;
        }

        $this->info("Processing: " . basename($filePath));
        $this->line('=' . str_repeat('=', 50));

        if ($preview) {
            // Preview mode
            $this->info('📋 Preview Mode');

            $result = $importer->previewFile($filePath);

            if ($result['success']) {
                $data = $result['data'];

                $this->info("\nExtracted Data:");
                $this->table(
                    ['Field', 'Value'],
                    [
                        ['Title', $data['name'] ?? 'N/A'],
                        ['Slug', $data['slug'] ?? 'N/A'],
                        ['Author ID', $data['author_id'] ?? 'N/A'],
                        ['Category ID', $data['category_id'] ?? 'N/A'],
                        ['Published', $data['is_published'] ? 'Yes' : 'No'],
                        ['Featured', $data['is_featured'] ? 'Yes' : 'No'],
                        ['Published At', $data['published_at'] ?? 'N/A'],
                        ['Reading Time', ($data['reading_time'] ?? 0) . ' minutes'],
                        ['Tags', $data['tags'] ?? 'N/A'],
                        ['Featured Image', $data['featured_image'] ?? 'N/A'],
                    ]
                );

                $this->info("\nContent Preview:");
                $this->line($result['html_preview']);

                if (!empty($result['frontmatter'])) {
                    $this->info("\nFrontmatter:");
                    foreach ($result['frontmatter'] as $key => $value) {
                        if (is_array($value)) {
                            $this->line("  {$key}: " . implode(', ', $value));
                        } else {
                            $this->line("  {$key}: {$value}");
                        }
                    }
                }

                if (!$this->confirm('Do you want to import this file?')) {
                    $this->info('Import cancelled');
                    return;
                }
            } else {
                $this->error("Preview failed: {$result['error']}");
                return;
            }
        }

        // Perform the import
        $this->info('🚀 Importing...');

        $result = $importer->importFile($filePath);

        if ($result['success']) {
            $this->info("✅ {$result['message']}");
            $blogPost = $result['blog_post'];
            $this->line("   URL: /blog/{$blogPost->slug}");
        } else {
            $this->error("❌ Import failed: {$result['error']}");
        }
    }

    protected function importDirectory($directory, $importer, $preview, $recursive)
    {
        $this->info("Scanning directory: {$directory}");

        // Get markdown files
        if ($recursive) {
            $files = $this->getMarkdownFilesRecursive($directory);
        } else {
            $files = glob($directory . '/*.md');
        }

        if (empty($files)) {
            $this->warn("No markdown files found in {$directory}");
            return;
        }

        $this->info("Found " . count($files) . " markdown file(s)");
        $this->line('=' . str_repeat('=', 50));

        if ($preview) {
            // Show list of files that will be imported
            $this->info("Files to import:");
            foreach ($files as $file) {
                $this->line("  • " . str_replace($directory . '/', '', $file));
            }

            if (!$this->confirm('Do you want to proceed with importing these files?')) {
                $this->info('Import cancelled');
                return;
            }
        }

        // Import all files
        $progressBar = $this->output->createProgressBar(count($files));
        $progressBar->start();

        $successful = 0;
        $failed = 0;
        $errors = [];

        foreach ($files as $file) {
            $result = $importer->importFile($file);

            if ($result['success']) {
                $successful++;
            } else {
                $failed++;
                $errors[] = [
                    'file' => basename($file),
                    'error' => $result['error'],
                ];
            }

            $progressBar->advance();
        }

        $progressBar->finish();

        // Show summary
        $this->info("\n\n✅ Import completed!");
        $this->line('=' . str_repeat('=', 50));

        $this->info("Import Summary:");
        $this->line("  Successful: {$successful} posts");
        $this->line("  Failed: {$failed} posts");

        if (!empty($errors)) {
            $this->warn("\nErrors:");
            foreach ($errors as $error) {
                $this->line("  • {$error['file']}: {$error['error']}");
            }
        }
    }

    protected function getMarkdownFilesRecursive($directory)
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'md') {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }
}