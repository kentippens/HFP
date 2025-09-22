<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->needsPasswordChange()) {
            // Allow access to password change page and logout
            $allowedPaths = [
                'admin/edit-profile',
                'admin/logout',
                'logout',
                'api/password-strength'
            ];

            $currentPath = $request->path();
            $isAllowed = false;

            foreach ($allowedPaths as $path) {
                if (str_starts_with($currentPath, $path)) {
                    $isAllowed = true;
                    break;
                }
            }

            if (!$isAllowed) {
                return redirect('/admin/edit-profile')
                    ->with('warning', 'Your password has expired. Please update it to continue.');
            }
        }

        return $next($request);
    }
}