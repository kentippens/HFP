<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\QueryDebugger;
use Illuminate\Support\Facades\Log;

class DetectN1Queries
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Only enable in development
        if (app()->environment('local', 'development')) {
            QueryDebugger::enable();
        }

        $response = $next($request);

        // Log statistics after request
        if (app()->environment('local', 'development')) {
            $stats = QueryDebugger::logStats();

            // Check for duplicates
            $duplicates = QueryDebugger::getDuplicates();
            if (!empty($duplicates)) {
                Log::warning('Duplicate queries detected', [
                    'url' => $request->fullUrl(),
                    'duplicates' => $duplicates,
                ]);
            }

            // Add debug headers in development
            if ($response->headers) {
                $response->headers->set('X-Debug-Query-Count', QueryDebugger::getQueryCount());
                $response->headers->set('X-Debug-Query-Time', QueryDebugger::getTotalTime() . 'ms');
            }

            QueryDebugger::disable();
        }

        return $response;
    }
}