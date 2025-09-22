<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleOrPermission
{
    /**
     * Handle an incoming request.
     * Checks if user has either the specified role OR permission
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roleOrPermission): Response
    {
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $user = $request->user();

        // Check if user has the role or permission
        if (!$user->hasRole($roleOrPermission) && !$user->hasPermission($roleOrPermission)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden. Insufficient privileges.'], 403);
            }
            abort(403, 'You do not have sufficient privileges to access this resource.');
        }

        return $next($request);
    }
}