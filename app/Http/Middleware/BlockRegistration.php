<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class BlockRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log the attempt
        Log::warning('Registration attempt blocked', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'invitation_token' => $request->input('invitation_token')
        ]);
        
        // Check if invitation token is provided
        $token = $request->input('invitation_token') ?? $request->query('token');
        
        if (!$token || !$this->isValidInvitationToken($token)) {
            // Return 404 to hide that registration exists
            abort(404);
        }
        
        // Store token in session for the registration process
        session(['invitation_token' => $token]);
        
        return $next($request);
    }
    
    private function isValidInvitationToken($token): bool
    {
        // Check if token exists and is valid
        return \App\Models\InvitationToken::where('token', $token)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->exists();
    }
}
