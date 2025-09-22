<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Exceptions\RbacException;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        try {
            // Validate permissions parameter
            if (empty($permissions)) {
                Log::error('CheckPermission middleware called without permissions', [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                ]);
                throw new RbacException('No permissions specified for authorization check');
            }
            
            // Check authentication
            if (!$request->user()) {
                Log::warning('Unauthenticated access attempt to permission-protected route', [
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                    'required_permissions' => $permissions,
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

            // Validate each permission exists
            foreach ($permissions as $permission) {
                if (!\App\Models\Permission::where('slug', $permission)->exists()) {
                    Log::error('Invalid permission specified in middleware', [
                        'permission' => $permission,
                        'url' => $request->fullUrl(),
                    ]);
                    throw new RbacException("Invalid permission specified: {$permission}");
                }
            }

            // Check if user has any of the specified permissions
            if (!$request->user()->hasAnyPermission($permissions)) {
                Log::warning('Unauthorized access attempt to permission-protected route', [
                    'user_id' => $request->user()->id,
                    'user_email' => $request->user()->email,
                    'url' => $request->fullUrl(),
                    'required_permissions' => $permissions,
                    'user_permissions' => $request->user()->getAllPermissions()->pluck('slug')->toArray(),
                ]);
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Forbidden.',
                        'error' => 'You do not have the required permission to access this resource.',
                        'required_permissions' => $permissions
                    ], 403);
                }
                abort(403, 'You do not have the required permission to access this resource.');
            }
            
            // Log successful authorization
            Log::info('Permission authorization successful', [
                'user_id' => $request->user()->id,
                'url' => $request->fullUrl(),
                'required_permissions' => $permissions,
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