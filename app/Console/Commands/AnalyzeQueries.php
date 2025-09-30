<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AnalyzeQueries extends Command
{
    protected $signature = 'queries:analyze {url?}';
    protected $description = 'Analyze database queries for a given URL';

    protected $queries = [];

    public function handle()
    {
        $url = $this->argument('url') ?? $this->ask('Enter the URL to analyze');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            // If not a full URL, assume it's a path and prepend the app URL
            $url = config('app.url') . '/' . ltrim($url, '/');
        }

        $this->info("Analyzing queries for: {$url}");
        $this->newLine();

        // Enable query logging
        DB::enableQueryLog();

        try {
            // Make request to the URL
            $response = Http::get($url);

            if (!$response->successful()) {
                $this->error("Failed to fetch URL. Status: {$response->status()}");
                return 1;
            }
        } catch (\Exception $e) {
            $this->error("Error fetching URL: " . $e->getMessage());
            return 1;
        }

        // Get logged queries
        $queries = DB::getQueryLog();

        if (empty($queries)) {
            $this->info('No queries were logged.');
            return 0;
        }

        // Analyze queries
        $this->analyzeQueries($queries);

        return 0;
    }

    protected function analyzeQueries(array $queries)
    {
        $totalQueries = count($queries);
        $totalTime = array_sum(array_column($queries, 'time'));

        $this->info("Total Queries: {$totalQueries}");
        $this->info("Total Time: " . number_format($totalTime, 2) . "ms");
        $this->newLine();

        // Detect N+1 queries
        $this->detectN1Queries($queries);

        // Find slow queries
        $this->findSlowQueries($queries);

        // Find duplicate queries
        $this->findDuplicateQueries($queries);

        // Show query details
        if ($this->confirm('Show all query details?', false)) {
            $this->showQueryDetails($queries);
        }
    }

    protected function detectN1Queries(array $queries)
    {
        $patterns = [];

        foreach ($queries as $query) {
            // Normalize query for comparison
            $pattern = preg_replace('/\b\d+\b/', '?', $query['query']);
            $pattern = preg_replace('/\s+/', ' ', trim($pattern));

            if (!isset($patterns[$pattern])) {
                $patterns[$pattern] = [];
            }
            $patterns[$pattern][] = $query;
        }

        $n1Detected = false;
        foreach ($patterns as $pattern => $matchingQueries) {
            if (count($matchingQueries) > 3) {
                if (!$n1Detected) {
                    $this->warn('⚠️  Potential N+1 Queries Detected:');
                    $n1Detected = true;
                }

                $this->error("Query pattern repeated " . count($matchingQueries) . " times:");
                $this->line(substr($pattern, 0, 100) . '...');
                $this->newLine();
            }
        }

        if (!$n1Detected) {
            $this->info('✓ No obvious N+1 queries detected');
        }
        $this->newLine();
    }

    protected function findSlowQueries(array $queries)
    {
        $slowQueries = array_filter($queries, function ($query) {
            return $query['time'] > 50; // Queries taking more than 50ms
        });

        if (!empty($slowQueries)) {
            $this->warn('⚠️  Slow Queries (>50ms):');
            foreach ($slowQueries as $query) {
                $this->error("Time: {$query['time']}ms");
                $this->line(substr($query['query'], 0, 100) . '...');
                $this->newLine();
            }
        } else {
            $this->info('✓ No slow queries detected');
        }
        $this->newLine();
    }

    protected function findDuplicateQueries(array $queries)
    {
        $seen = [];
        $duplicates = [];

        foreach ($queries as $query) {
            $key = $query['query'] . serialize($query['bindings']);

            if (isset($seen[$key])) {
                if (!isset($duplicates[$key])) {
                    $duplicates[$key] = 2;
                } else {
                    $duplicates[$key]++;
                }
            } else {
                $seen[$key] = true;
            }
        }

        if (!empty($duplicates)) {
            $this->warn('⚠️  Duplicate Queries:');
            foreach ($duplicates as $query => $count) {
                $this->error("Executed {$count} times:");
                $this->line(substr($query, 0, 100) . '...');
                $this->newLine();
            }
        } else {
            $this->info('✓ No duplicate queries detected');
        }
        $this->newLine();
    }

    protected function showQueryDetails(array $queries)
    {
        $this->info('Query Details:');
        $this->newLine();

        foreach ($queries as $index => $query) {
            $this->line("Query #" . ($index + 1));
            $this->line("Time: {$query['time']}ms");
            $this->line("SQL: {$query['query']}");

            if (!empty($query['bindings'])) {
                $this->line("Bindings: " . json_encode($query['bindings']));
            }

            $this->newLine();
        }
    }
}