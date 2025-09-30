<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QueryDebugger
{
    protected static $queries = [];
    protected static $enabled = false;
    protected static $threshold = 10; // Log if more than N queries

    /**
     * Enable query debugging
     */
    public static function enable()
    {
        static::$enabled = true;
        static::$queries = [];

        DB::listen(function ($query) {
            if (static::$enabled) {
                static::$queries[] = [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time,
                ];

                // Detect potential N+1 queries
                static::detectN1Query($query);
            }
        });
    }

    /**
     * Disable query debugging
     */
    public static function disable()
    {
        static::$enabled = false;
        static::$queries = [];
    }

    /**
     * Get all logged queries
     */
    public static function getQueries()
    {
        return static::$queries;
    }

    /**
     * Get query count
     */
    public static function getQueryCount()
    {
        return count(static::$queries);
    }

    /**
     * Get total query time
     */
    public static function getTotalTime()
    {
        return array_sum(array_column(static::$queries, 'time'));
    }

    /**
     * Detect potential N+1 queries
     */
    protected static function detectN1Query($query)
    {
        // Pattern for detecting similar queries that might indicate N+1
        $sql = preg_replace('/\d+/', '?', $query->sql);
        $sql = preg_replace('/\s+/', ' ', trim($sql));

        // Count similar queries
        $similarCount = 0;
        foreach (static::$queries as $loggedQuery) {
            $loggedSql = preg_replace('/\d+/', '?', $loggedQuery['sql']);
            $loggedSql = preg_replace('/\s+/', ' ', trim($loggedSql));

            if ($sql === $loggedSql) {
                $similarCount++;
            }
        }

        // If we have more than 5 similar queries, it might be an N+1 problem
        if ($similarCount > 5) {
            Log::warning('Potential N+1 query detected', [
                'query' => $query->sql,
                'count' => $similarCount,
                'backtrace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5)
            ]);
        }
    }

    /**
     * Log query statistics
     */
    public static function logStats()
    {
        if (!static::$enabled) {
            return;
        }

        $stats = [
            'total_queries' => static::getQueryCount(),
            'total_time' => static::getTotalTime() . 'ms',
            'queries' => static::$queries,
        ];

        // Log if query count exceeds threshold
        if ($stats['total_queries'] > static::$threshold) {
            Log::warning('High query count detected', $stats);
        }

        return $stats;
    }

    /**
     * Get duplicate queries
     */
    public static function getDuplicates()
    {
        $queries = [];
        $duplicates = [];

        foreach (static::$queries as $query) {
            $sql = preg_replace('/\d+/', '?', $query['sql']);
            $sql = preg_replace('/\s+/', ' ', trim($sql));

            if (!isset($queries[$sql])) {
                $queries[$sql] = 1;
            } else {
                $queries[$sql]++;
                if ($queries[$sql] === 2) {
                    $duplicates[$sql] = 2;
                } else {
                    $duplicates[$sql] = $queries[$sql];
                }
            }
        }

        return $duplicates;
    }

    /**
     * Clear all queries
     */
    public static function clear()
    {
        static::$queries = [];
    }
}