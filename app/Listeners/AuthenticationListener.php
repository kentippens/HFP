<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Request;

class AuthenticationListener
{
    /**
     * Handle user login events.
     */
    public function handleLogin(Login $event): void
    {
        try {
            ActivityLogger::logLogin($event->user);
        } catch (\Exception $e) {
            \Log::warning('Failed to log login activity', [
                'user_id' => $event->user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle user logout events.
     */
    public function handleLogout(Logout $event): void
    {
        try {
            if ($event->user) {
                ActivityLogger::logLogout($event->user);
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to log logout activity', [
                'user_id' => $event->user?->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle failed login attempts.
     */
    public function handleFailed(Failed $event): void
    {
        try {
            $email = $event->credentials['email'] ?? 'unknown';
            ActivityLogger::logFailedLogin($email, 'Invalid credentials');

            // Log additional details for security monitoring
            ActivityLogger::log()
                ->useLog('security')
                ->event('failed_access_attempt')
                ->withDescription("Failed access attempt from IP " . Request::ip())
                ->withProperties([
                    'attempted_email' => $email,
                    'ip_address' => Request::ip(),
                    'user_agent' => Request::userAgent(),
                    'timestamp' => now()->toISOString(),
                    'guard' => $event->guard ?? 'web'
                ])
                ->save();

        } catch (\Exception $e) {
            \Log::warning('Failed to log authentication failure', [
                'credentials' => array_keys($event->credentials),
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle account lockouts.
     */
    public function handleLockout(Lockout $event): void
    {
        try {
            $email = $event->request->input('email', 'unknown');

            ActivityLogger::log()
                ->useLog('security')
                ->event('account_lockout')
                ->withDescription("Account locked due to too many failed attempts: {$email}")
                ->withProperties([
                    'email' => $email,
                    'ip_address' => Request::ip(),
                    'user_agent' => Request::userAgent(),
                    'timestamp' => now()->toISOString(),
                    'lockout_duration' => config('auth.throttle.decay_minutes', 60) . ' minutes'
                ])
                ->save();

        } catch (\Exception $e) {
            \Log::warning('Failed to log account lockout', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle password reset events.
     */
    public function handlePasswordReset(PasswordReset $event): void
    {
        try {
            ActivityLogger::logPasswordChanged($event->user);
        } catch (\Exception $e) {
            \Log::warning('Failed to log password reset activity', [
                'user_id' => $event->user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle login attempts (before authentication).
     */
    public function handleAttempting(Attempting $event): void
    {
        try {
            $email = $event->credentials['email'] ?? 'unknown';

            // Only log if it's a suspicious attempt (optional - can be enabled for detailed monitoring)
            $suspiciousIndicators = [
                'repeated_attempts' => $this->isRepeatedAttempt($email),
                'unusual_user_agent' => $this->isUnusualUserAgent(),
                'suspicious_ip' => $this->isSuspiciousIP()
            ];

            if (array_filter($suspiciousIndicators)) {
                ActivityLogger::log()
                    ->useLog('security')
                    ->event('suspicious_login_attempt')
                    ->withDescription("Suspicious login attempt for {$email}")
                    ->withProperties([
                        'attempted_email' => $email,
                        'ip_address' => Request::ip(),
                        'user_agent' => Request::userAgent(),
                        'indicators' => $suspiciousIndicators,
                        'timestamp' => now()->toISOString()
                    ])
                    ->save();
            }

        } catch (\Exception $e) {
            \Log::warning('Failed to log login attempt', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            Login::class => 'handleLogin',
            Logout::class => 'handleLogout',
            Failed::class => 'handleFailed',
            Lockout::class => 'handleLockout',
            PasswordReset::class => 'handlePasswordReset',
            Attempting::class => 'handleAttempting',
        ];
    }

    /**
     * Check if this is a repeated attempt from the same IP/email.
     */
    protected function isRepeatedAttempt(string $email): bool
    {
        $recentAttempts = \App\Models\Activity::where('log_name', 'auth')
            ->where('event', 'failed_login')
            ->where('created_at', '>=', now()->subMinutes(15))
            ->where('ip_address', Request::ip())
            ->count();

        return $recentAttempts >= 3;
    }

    /**
     * Check if the user agent is unusual or suspicious.
     */
    protected function isUnusualUserAgent(): bool
    {
        $userAgent = Request::userAgent();

        // Check for common bot/scanner indicators
        $suspiciousPatterns = [
            '/curl/i',
            '/wget/i',
            '/scanner/i',
            '/bot/i',
            '/python/i',
            '/perl/i'
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the IP is suspicious (implement your own logic).
     */
    protected function isSuspiciousIP(): bool
    {
        $ip = Request::ip();

        // Add your own IP reputation/blacklist checking here
        // For now, just return false
        return false;
    }
}