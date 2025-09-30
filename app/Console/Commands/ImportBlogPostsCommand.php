<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BlogPostImportService;
use Illuminate\Http\UploadedFile;

class ImportBlogPostsCommand extends Command
{
    protected $signature = 'import:blog-posts
                          {file : Path to the CSV file to import}
                          {--preview : Preview the import without saving}
                          {--skip-errors : Continue import even if some rows fail}
                          {--limit=10 : Number of rows to preview (preview mode only)}';

    protected $description = 'Import blog posts from a CSV file';

    public function handle()
    {
        $filePath = $this->argument('file');
        $preview = $this->option('preview');
        $skipErrors = $this->option('skip-errors');
        $limit = $this->option('limit');

        // Validate file exists
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        // Create UploadedFile instance
        $uploadedFile = new UploadedFile(
            $filePath,
            basename($filePath),
            'text/csv',
            null,
            true
        );

        $importer = new BlogPostImportService();

        // Validate the file
        $this->info('Validating CSV file...');
        $errors = $importer->validateFile($uploadedFile);

        if (!empty($errors)) {
            $this->error('File validation failed:');
            foreach ($errors as $error) {
                $this->line("  - {$error}");
            }
            return 1;
        }

        $this->info('✅ File validation passed');

        if ($preview) {
            // Preview mode
            $this->info("\n📋 Preview Mode (first {$limit} rows)");
            $this->line('=' . str_repeat('=', 50));

            $previewData = $importer->previewData($uploadedFile, $limit);

            // Show headers
            $this->info("\nHeaders found:");
            foreach ($previewData['headers'] as $index => $header) {
                $this->line("  [{$index}] {$header}");
            }

            // Show field mapping
            $this->info("\nSuggested field mapping:");
            foreach ($previewData['field_mapping'] as $csvIndex => $modelField) {
                $csvHeader = $previewData['headers'][$csvIndex] ?? 'Unknown';
                $this->line("  {$csvHeader} → {$modelField}");
            }

            // Show sample data
            $this->info("\nSample data:");
            foreach ($previewData['sample_data'] as $index => $row) {
                $this->line("\nRow " . ($index + 1) . ":");
                $this->line("  Title: " . ($row['title'] ?? 'N/A'));
                $this->line("  Category: " . ($row['category_name'] ?? 'N/A'));
                $this->line("  Published: " . ($row['is_published'] ?? 'N/A'));
                $this->line("  Author: " . ($row['author_email'] ?? 'N/A'));
            }

            // Show validation errors if any
            if (!empty($previewData['validation_errors'])) {
                $this->warn("\n⚠️  Validation errors found:");
                foreach ($previewData['validation_errors'] as $rowKey => $errors) {
                    $this->line("  {$rowKey}:");
                    foreach ($errors as $field => $fieldErrors) {
                        foreach ($fieldErrors as $error) {
                            $this->line("    - {$field}: {$error}");
                        }
                    }
                }
            }

            $this->info("\nTotal rows in file: {$previewData['total_rows']}");

            if (!$this->confirm('Do you want to proceed with the import?')) {
                $this->info('Import cancelled');
                return 0;
            }
        }

        // Perform the import
        $this->info("\n🚀 Starting import...");

        $progressBar = $this->output->createProgressBar();
        $progressBar->start();

        try {
            // Use the suggested field mapping from preview
            $previewData = $importer->previewData($uploadedFile, 1);
            $fieldMapping = $previewData['field_mapping'];

            $result = $importer->import($uploadedFile, $fieldMapping, $skipErrors);

            $progressBar->finish();

            $this->info("\n\n✅ Import completed!");
            $this->line('=' . str_repeat('=', 50));

            // Show results
            $this->info("Import Summary:");
            $this->line("  Successful: {$result['successful_rows']} posts");
            $this->line("  Failed: {$result['failed_rows']} posts");
            $this->line("  Total: {$result['total_rows']} posts");
            $this->line("  Success Rate: {$result['success_rate']}%");

            // Show error summary if any
            if (!empty($result['error_summary'])) {
                $this->warn("\nError Summary:");
                foreach ($result['error_summary'] as $errorType => $count) {
                    $this->line("  {$errorType}: {$count} occurrences");
                }
            }

            // Show sample errors if any
            if (!empty($result['import_log']) && count($result['import_log']) > 0) {
                $this->warn("\nSample Errors (first 5):");
                $sampleErrors = array_slice($result['import_log'], 0, 5);
                foreach ($sampleErrors as $error) {
                    $this->line("  Row {$error['row']}: {$error['type']}");
                    if (!empty($error['details'])) {
                        foreach ($error['details'] as $detail) {
                            if (is_array($detail)) {
                                $this->line("    - " . implode(', ', $detail));
                            } else {
                                $this->line("    - {$detail}");
                            }
                        }
                    }
                }
            }

            return $result['failed_rows'] > 0 && !$skipErrors ? 1 : 0;

        } catch (\Exception $e) {
            $progressBar->finish();
            $this->error("\n\n❌ Import failed: " . $e->getMessage());
            return 1;
        }
    }
}