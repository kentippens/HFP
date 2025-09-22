<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\QueryException;
use App\Exceptions\DatabaseExceptionHandler;
use App\Exceptions\AuthenticationExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->append(\App\Http\Middleware\ValidateServicePath::class);
        
        // Add SanitizeInput middleware to web group
        $middleware->web(append: [
            \App\Http\Middleware\SanitizeInput::class,
        ]);
        
        // Register RBAC middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'role_or_permission' => \App\Http\Middleware\CheckRoleOrPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle database exceptions with custom error pages
        $exceptions->render(function (QueryException $e, Request $request) {
            if ($request->expectsJson()) {
                $errorInfo = DatabaseExceptionHandler::handle($e);
                return response()->json([
                    'message' => $errorInfo['user_message'],
                    'error' => config('app.debug') ? $errorInfo['technical_message'] : null,
                ], $errorInfo['code']);
            }
            
            // For web requests, check if it's a connection error
            if (DatabaseExceptionHandler::isConnectionError($e)) {
                return response()->view('errors.503', [], 503);
            }
            
            // For other database errors, show 500 page
            return response()->view('errors.500', [], 500);
        });
        
        // Handle authentication exceptions
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            
            return redirect()->guest('/admin/login')
                ->with('error', 'Please log in to continue.');
        });
        
        // Handle validation exceptions for login/register
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('login') || $request->is('register')) {
                AuthenticationExceptionHandler::logSuspiciousActivity($request, 'Validation failed');
            }
            
            // Let Laravel handle the response as normal
            return null;
        });
    })->create();
