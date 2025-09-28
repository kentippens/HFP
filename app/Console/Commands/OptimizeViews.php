<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class OptimizeViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'views:optimize {--clear : Clear all view optimizations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize views by caching and splitting large templates';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('clear')) {
            $this->clearOptimizations();
            return Command::SUCCESS;
        }

        $this->info('Optimizing views...');

        // Clear existing caches
        $this->call('view:clear');

        // Analyze template sizes
        $this->analyzeTemplateSizes();

        // Cache views
        $this->call('view:cache');

        // Cache configuration and routes
        if (app()->environment('production')) {
            $this->call('config:cache');
            $this->call('route:cache');
        }

        $this->info('View optimization complete!');

        return Command::SUCCESS;
    }

    /**
     * Clear all optimizations
     */
    protected function clearOptimizations(): void
    {
        $this->info('Clearing view optimizations...');

        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('cache:clear');

        $this->info('View optimizations cleared!');
    }

    /**
     * Analyze template sizes and suggest optimizations
     */
    protected function analyzeTemplateSizes(): void
    {
        $this->info('Analyzing template sizes...');

        $viewPath = resource_path('views');
        $largeTemplates = [];

        // Find blade files
        $files = File::allFiles($viewPath);

        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $lineCount = count(file($file->getPathname()));

                if ($lineCount > 500) {
                    $relativePath = str_replace($viewPath . '/', '', $file->getPathname());
                    $largeTemplates[] = [
                        'file' => $relativePath,
                        'lines' => $lineCount,
                    ];
                }
            }
        }

        if (!empty($largeTemplates)) {
            $this->table(['File', 'Lines'], array_map(function ($template) {
                return [
                    $template['file'],
                    $template['lines'],
                ];
            }, array_slice($largeTemplates, 0, 10)));

            if (count($largeTemplates) > 10) {
                $this->warn('And ' . (count($largeTemplates) - 10) . ' more large templates...');
            }

            $this->warn('Consider splitting these templates into smaller components.');
        } else {
            $this->info('All templates are optimally sized!');
        }
    }
}