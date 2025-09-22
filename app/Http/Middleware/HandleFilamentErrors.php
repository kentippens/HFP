<?php

namespace App\Http\Middleware;

use App\Exceptions\FilamentExceptionHandler;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class HandleFilamentErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (Throwable $e) {
            // Only handle errors for Filament routes
            if ($request->is('admin/*')) {
                FilamentExceptionHandler::handle($e);
            }
            
            // Re-throw the exception to let Laravel handle it normally
            throw $e;
        }
    }
}