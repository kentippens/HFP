<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Request;

class LogAuthentication
{
    /**
     * Handle login events.
     */
    public function handleLogin(Login $event): void
    {
        // Update user's last login info
        $event->user->update([
            'last_login_at' => now(),
            'last_login_ip' => Request::ip(),
            'failed_login_attempts' => 0,
        ]);

        ActivityLogger::logLogin($event->user);
    }

    /**
     * Handle logout events.
     */
    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            ActivityLogger::logLogout($event->user);
        }
    }

    /**
     * Handle failed login events.
     */
    public function handleFailed(Failed $event): void
    {
        $email = $event->credentials['email'] ?? 'unknown';

        // Find the user and increment failed attempts
        if ($email !== 'unknown') {
            $user = \App\Models\User::where('email', $email)->first();
            if ($user) {
                $user->increment('failed_login_attempts');

                // Lock the account after 5 failed attempts
                if ($user->failed_login_attempts >= 5) {
                    $user->update(['locked_until' => now()->addMinutes(30)]);
                    ActivityLogger::log()
                        ->useLog('auth')
                        ->event('account_locked')
                        ->performedOn($user)
                        ->withDescription("Account locked due to {$user->failed_login_attempts} failed login attempts")
                        ->save();
                }
            }
        }

        ActivityLogger::logFailedLogin($email, 'Invalid credentials');
    }

    /**
     * Handle password reset events.
     */
    public function handlePasswordReset(PasswordReset $event): void
    {
        ActivityLogger::logPasswordChanged($event->user);
    }

    /**
     * Handle account lockout events.
     */
    public function handleLockout(Lockout $event): void
    {
        $email = $event->request->input('email', 'unknown');

        ActivityLogger::log()
            ->useLog('auth')
            ->event('lockout')
            ->withDescription("Too many login attempts for {$email}")
            ->withProperties([
                'email' => $email,
                'ip' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ])
            ->save();
    }

    /**
     * Handle login attempt events.
     */
    public function handleAttempting(Attempting $event): void
    {
        // Only log suspicious attempts (e.g., from blocked IPs or after hours)
        $ip = Request::ip();
        $hour = now()->hour;

        // Log attempts outside business hours or from suspicious IPs
        if ($hour < 6 || $hour > 22 || $this->isSuspiciousIp($ip)) {
            ActivityLogger::log()
                ->useLog('auth')
                ->event('suspicious_attempt')
                ->withDescription("Login attempt from {$ip} at unusual hour")
                ->withProperties([
                    'email' => $event->credentials['email'] ?? 'unknown',
                    'ip' => $ip,
                    'hour' => $hour,
                    'user_agent' => Request::userAgent(),
                ])
                ->save();
        }
    }

    /**
     * Check if IP is suspicious.
     */
    protected function isSuspiciousIp(string $ip): bool
    {
        // Check if there have been multiple failed attempts from this IP
        $recentFailures = \App\Models\Activity::where('log_name', 'auth')
            ->where('event', 'failed_login')
            ->where('ip_address', $ip)
            ->where('created_at', '>', now()->subHours(1))
            ->count();

        return $recentFailures > 3;
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe($events): array
    {
        return [
            Login::class => 'handleLogin',
            Logout::class => 'handleLogout',
            Failed::class => 'handleFailed',
            PasswordReset::class => 'handlePasswordReset',
            Lockout::class => 'handleLockout',
            Attempting::class => 'handleAttempting',
        ];
    }
}