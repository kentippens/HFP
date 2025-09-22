<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateServicePath
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if this is a service route
        if ($request->is('services/*')) {
            $uri = $request->getRequestUri();
            
            // Check for double slashes or trailing slashes in services paths
            if (preg_match('#/services/.*?//#', $uri) || preg_match('#/services/.+/$#', $uri)) {
                abort(404);
            }
        }
        
        return $next($request);
    }
}
