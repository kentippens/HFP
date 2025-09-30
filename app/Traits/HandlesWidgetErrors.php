<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Filament\Widgets\StatsOverviewWidget\Stat;

trait HandlesWidgetErrors
{
    /**
     * Safely execute a database query with error handling and caching.
     */
    protected function safeQuery(callable $query, string $cacheKey = null, int $cacheTtl = 300, $defaultValue = 0)
    {
        try {
            // Use caching if cache key provided
            if ($cacheKey) {
                return Cache::remember($cacheKey, $cacheTtl, $query);
            }

            return $query();

        } catch (\Exception $e) {
            Log::warning('Widget query failed', [
                'widget' => get_class($this),
                'cache_key' => $cacheKey,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $defaultValue;
        }
    }

    /**
     * Create a safe stat with error handling.
     */
    protected function safeStat(string $label, callable $valueCallback, array $options = []): Stat
    {
        try {
            $value = $valueCallback();
            $stat = Stat::make($label, $value);

            // Apply optional configurations, evaluating closures if provided
            if (isset($options['description'])) {
                $description = is_callable($options['description']) ? $options['description']() : $options['description'];
                $stat = $stat->description($description);
            }

            if (isset($options['descriptionIcon'])) {
                $descriptionIcon = is_callable($options['descriptionIcon']) ? $options['descriptionIcon']() : $options['descriptionIcon'];
                $stat = $stat->descriptionIcon($descriptionIcon);
            }

            if (isset($options['color'])) {
                $color = is_callable($options['color']) ? $options['color']() : $options['color'];
                $stat = $stat->color($color);
            }

            if (isset($options['chart'])) {
                $chart = is_callable($options['chart']) ? $options['chart']() : $options['chart'];
                $stat = $stat->chart($chart);
            }

            if (isset($options['url'])) {
                try {
                    $url = is_callable($options['url']) ? $options['url']() : $options['url'];
                    if ($url) {
                        $stat = $stat->url($url);
                    }
                } catch (\Exception $e) {
                    // Route might not be available in testing context - just skip URL
                }
            }

            return $stat;

        } catch (\Exception $e) {
            Log::warning('Widget stat generation failed', [
                'widget' => get_class($this),
                'stat_label' => $label,
                'error' => $e->getMessage()
            ]);

            // Return error stat
            return Stat::make($label, 'Error')
                ->description('Data temporarily unavailable')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger');
        }
    }

    /**
     * Safely generate chart data with validation.
     */
    protected function safeChart(callable $chartCallback, array $defaultData = []): array
    {
        try {
            $data = $chartCallback();

            // Validate chart data
            if (!is_array($data)) {
                throw new \InvalidArgumentException('Chart data must be an array');
            }

            // Ensure no null values that could break charts
            $data = array_map(function($value) {
                return $value === null ? 0 : $value;
            }, $data);

            return $data;

        } catch (\Exception $e) {
            Log::warning('Widget chart generation failed', [
                'widget' => get_class($this),
                'error' => $e->getMessage()
            ]);

            return $defaultData;
        }
    }

    /**
     * Calculate percentage change safely.
     */
    protected function safePercentageChange($current, $previous): float
    {
        try {
            if ($previous == 0) {
                return $current > 0 ? 100 : 0;
            }

            $change = (($current - $previous) / $previous) * 100;

            // Prevent extreme values that could break UI
            if ($change > 9999) return 9999;
            if ($change < -9999) return -9999;

            return round($change, 1);

        } catch (\Exception $e) {
            Log::warning('Percentage calculation failed', [
                'widget' => get_class($this),
                'current' => $current,
                'previous' => $previous,
                'error' => $e->getMessage()
            ]);

            return 0;
        }
    }

    /**
     * Get color based on change value with fallback.
     */
    protected function getChangeColor(float $change): string
    {
        if ($change > 0) return 'success';
        if ($change < 0) return 'danger';
        return 'gray';
    }

    /**
     * Get icon based on change value with fallback.
     */
    protected function getChangeIcon(float $change): string
    {
        if ($change > 0) return 'heroicon-m-arrow-trending-up';
        if ($change < 0) return 'heroicon-m-arrow-trending-down';
        return 'heroicon-m-minus';
    }

    /**
     * Format change description safely.
     */
    protected function getChangeDescription(float $change, string $period): string
    {
        try {
            if ($change > 0) {
                return "{$change}% increase from {$period}";
            } elseif ($change < 0) {
                return abs($change) . "% decrease from {$period}";
            }
            return "Same as {$period}";
        } catch (\Exception $e) {
            return "Compared to {$period}";
        }
    }

    /**
     * Clear widget cache.
     */
    protected function clearWidgetCache(string $pattern = null): void
    {
        try {
            if ($pattern) {
                $keys = Cache::getRedis()->keys($pattern);
                if (!empty($keys)) {
                    Cache::getRedis()->del($keys);
                }
            } else {
                // Clear all widget caches for this class
                $widgetClass = str_replace('\\', '_', get_class($this));
                $pattern = "widget_{$widgetClass}_*";
                $keys = Cache::getRedis()->keys($pattern);
                if (!empty($keys)) {
                    Cache::getRedis()->del($keys);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to clear widget cache', [
                'widget' => get_class($this),
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get cached value or compute and cache it.
     */
    protected function getCachedStat(string $key, callable $callback, int $ttl = 300)
    {
        $cacheKey = $this->getWidgetCacheKey($key);
        return $this->safeQuery($callback, $cacheKey, $ttl);
    }

    /**
     * Generate consistent cache key for widget.
     */
    protected function getWidgetCacheKey(string $suffix): string
    {
        $widgetClass = str_replace('\\', '_', get_class($this));
        return "widget_{$widgetClass}_{$suffix}";
    }

    /**
     * Log widget performance metrics.
     */
    protected function logPerformanceMetric(string $operation, float $executionTime): void
    {
        if ($executionTime > 1000) { // Log if over 1 second
            Log::info('Widget performance metric', [
                'widget' => get_class($this),
                'operation' => $operation,
                'execution_time_ms' => round($executionTime, 2),
                'timestamp' => now()->toISOString()
            ]);
        }
    }

    /**
     * Measure and execute operation with performance logging.
     */
    protected function measureOperation(string $operation, callable $callback)
    {
        $startTime = microtime(true);
        $result = $callback();
        $executionTime = (microtime(true) - $startTime) * 1000;

        $this->logPerformanceMetric($operation, $executionTime);

        return $result;
    }
}