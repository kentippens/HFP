<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Exception;

class HealthCheckController extends Controller
{
    /**
     * Basic health check endpoint
     */
    public function health()
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
    
    /**
     * Detailed health check including database
     */
    public function detailed(Request $request)
    {
        // Check if API key is provided for security
        $apiKey = $request->header('X-Health-Check-Key');
        if ($apiKey !== config('app.health_check_key', 'default-health-check-key')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $health = [
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
            'checks' => [],
        ];
        
        // Check database
        $health['checks']['database'] = $this->checkDatabase();
        
        // Check cache
        $health['checks']['cache'] = $this->checkCache();
        
        // Check disk space
        $health['checks']['disk'] = $this->checkDiskSpace();
        
        // Check PHP version
        $health['checks']['php'] = [
            'status' => 'ok',
            'version' => PHP_VERSION,
            'required' => '8.2.0',
            'ok' => version_compare(PHP_VERSION, '8.2.0', '>='),
        ];
        
        // Overall status
        $hasFailures = collect($health['checks'])->contains(function ($check) {
            return $check['status'] !== 'ok';
        });
        
        $health['status'] = $hasFailures ? 'degraded' : 'ok';
        
        return response()->json($health, $hasFailures ? 503 : 200);
    }
    
    /**
     * Check database connectivity and performance
     */
    private function checkDatabase(): array
    {
        try {
            $start = microtime(true);
            
            // Test connection
            DB::connection()->getPdo();
            
            // Simple query test
            DB::select('SELECT 1');
            
            $responseTime = round((microtime(true) - $start) * 1000, 2);
            
            // Check if response time is acceptable (under 100ms)
            $status = $responseTime < 100 ? 'ok' : 'slow';
            
            return [
                'status' => $status,
                'response_time_ms' => $responseTime,
                'connection' => config('database.default'),
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Database connection failed',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ];
        }
    }
    
    /**
     * Check cache connectivity
     */
    private function checkCache(): array
    {
        try {
            $key = 'health_check_' . uniqid();
            $value = 'test_' . time();
            
            // Test write
            Cache::put($key, $value, 60);
            
            // Test read
            $retrieved = Cache::get($key);
            
            // Test delete
            Cache::forget($key);
            
            $status = $retrieved === $value ? 'ok' : 'error';
            
            return [
                'status' => $status,
                'driver' => config('cache.default'),
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Cache test failed',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ];
        }
    }
    
    /**
     * Check available disk space
     */
    private function checkDiskSpace(): array
    {
        try {
            $path = storage_path();
            $freeSpace = disk_free_space($path);
            $totalSpace = disk_total_space($path);
            $usedPercentage = round((($totalSpace - $freeSpace) / $totalSpace) * 100, 2);
            
            // Warning if over 90% used
            $status = $usedPercentage < 90 ? 'ok' : 'warning';
            
            return [
                'status' => $status,
                'used_percentage' => $usedPercentage,
                'free_gb' => round($freeSpace / 1073741824, 2),
                'total_gb' => round($totalSpace / 1073741824, 2),
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Disk check failed',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ];
        }
    }
}