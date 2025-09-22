<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Exceptions\RbacException;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        try {
            // Validate roles parameter
            if (empty($roles)) {
                Log::error('CheckRole middleware called without roles', [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                ]);
                throw new RbacException('No roles specified for authorization check');
            }
            
            // Check authentication
            if (!$request->user()) {
                Log::warning('Unauthenticated access attempt to role-protected route', [
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                    'required_roles' => $roles,
                ]);
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Unauthenticated.',
                        'error' => 'Authentication required'
                    ], 401);
                }
                return redirect()->route('login')
                    ->with('error', 'Please login to access this resource.');
            }

            // Validate each role exists
            foreach ($roles as $role) {
                if (!\App\Models\Role::where('slug', $role)->exists()) {
                    Log::error('Invalid role specified in middleware', [
                        'role' => $role,
                        'url' => $request->fullUrl(),
                    ]);
                    throw new RbacException("Invalid role specified: {$role}");
                }
            }

            // Check if user has any of the specified roles
            if (!$request->user()->hasAnyRole($roles)) {
                Log::warning('Unauthorized access attempt to role-protected route', [
                    'user_id' => $request->user()->id,
                    'user_email' => $request->user()->email,
                    'url' => $request->fullUrl(),
                    'required_roles' => $roles,
                    'user_roles' => $request->user()->roles->pluck('slug')->toArray(),
                ]);
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Forbidden.',
                        'error' => 'You do not have the required role to access this resource.',
                        'required_roles' => $roles
                    ], 403);
                }
                abort(403, 'You do not have the required role to access this resource.');
            }
            
            // Log successful authorization
            Log::info('Role authorization successful', [
                'user_id' => $request->user()->id,
                'url' => $request->fullUrl(),
                'required_roles' => $roles,
            ]);

            return $next($request);
            
        } catch (RbacException $e) {
            Log::error('RBAC middleware error', [
                'error' => $e->getMessage(),
                'context' => $e->getContext(),
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Authorization error',
                    'error' => $e->getMessage()
                ], 500);
            }
            abort(500, 'Authorization system error');
        }
    }
}