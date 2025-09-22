<?php

namespace App\Services;

use App\Models\FailedLoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginSecurityService
{
    const MAX_ATTEMPTS_PER_IP = 20;
    const MAX_ATTEMPTS_PER_EMAIL = 5;
    const LOCKOUT_DURATION_MINUTES = 15;
    const IP_BLOCK_DURATION_MINUTES = 60;
    const SUSPICIOUS_PATTERNS = [
        'sql_injection' => '/(\bunion\b|\bselect\b|\bdrop\b|\binsert\b|\bupdate\b|\bdelete\b|\bfrom\b|\bwhere\b|\btable\b|\bdatabase\b)/i',
        'script_injection' => '/<script[^>]*>|<\/script>|javascript:|onerror=|onload=/i',
        'path_traversal' => '/\.\.\/|\.\.\\\\/',
        'null_byte' => '/\x00/',
    ];

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function checkSuspiciousActivity(): array
    {
        $issues = [];
        
        // Check for suspicious patterns in input
        $email = $this->request->input('email', '');
        $password = $this->request->input('password', '');
        
        foreach (self::SUSPICIOUS_PATTERNS as $type => $pattern) {
            if (preg_match($pattern, $email) || preg_match($pattern, $password)) {
                $issues[] = $type;
                Log::warning('Suspicious login pattern detected', [
                    'type' => $type,
                    'ip' => $this->request->ip(),
                    'user_agent' => $this->request->userAgent()
                ]);
            }
        }
        
        // Check for automated bot patterns
        if ($this->detectBotPatterns()) {
            $issues[] = 'bot_detected';
        }
        
        // Check for IP reputation
        if ($this->checkIPReputation()) {
            $issues[] = 'suspicious_ip';
        }
        
        return $issues;
    }

    public function isIPBlocked(): bool
    {
        $ip = $this->request->ip();
        return Cache::has("blocked_ip:{$ip}");
    }

    public function blockIP(int $minutes = null): void
    {
        $minutes = $minutes ?? self::IP_BLOCK_DURATION_MINUTES;
        $ip = $this->request->ip();
        
        Cache::put("blocked_ip:{$ip}", true, now()->addMinutes($minutes));
        
        Log::warning('IP address blocked', [
            'ip' => $ip,
            'duration_minutes' => $minutes,
            'user_agent' => $this->request->userAgent()
        ]);
    }

    public function getFailedAttemptsForIP(): int
    {
        return FailedLoginAttempt::where('ip_address', $this->request->ip())
            ->where('created_at', '>', now()->subHour())
            ->sum('attempts');
    }

    public function getFailedAttemptsForEmail(string $email): int
    {
        return FailedLoginAttempt::where('email', $email)
            ->where('created_at', '>', now()->subHour())
            ->sum('attempts');
    }

    public function shouldRequireCaptcha(string $email): bool
    {
        // Require CAPTCHA after 3 attempts for specific email or 10 attempts from IP
        $emailAttempts = $this->getFailedAttemptsForEmail($email);
        $ipAttempts = $this->getFailedAttemptsForIP();
        
        return $emailAttempts >= 3 || $ipAttempts >= 10;
    }

    public function recordSuccessfulLogin(string $email): void
    {
        // Clear failed attempts for this email/IP combination
        FailedLoginAttempt::where('email', $email)
            ->where('ip_address', $this->request->ip())
            ->delete();
        
        // Clear rate limiting
        RateLimiter::clear($this->getThrottleKey($email));
        
        // Log successful login
        Log::info('Successful login', [
            'email' => $email,
            'ip' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
            'timestamp' => now()->toIso8601String()
        ]);
    }

    public function getThrottleKey(string $email): string
    {
        return Str::transliterate(Str::lower($email) . '|' . $this->request->ip());
    }

    public function getRateLimitAttempts(): int
    {
        // Dynamic rate limiting based on failed attempts
        $failedAttempts = $this->getFailedAttemptsForIP();
        
        if ($failedAttempts >= 15) {
            return 1; // Very strict rate limiting
        } elseif ($failedAttempts >= 10) {
            return 3;
        } elseif ($failedAttempts >= 5) {
            return 5;
        }
        
        return 10; // Default
    }

    protected function detectBotPatterns(): bool
    {
        $userAgent = strtolower($this->request->userAgent() ?? '');
        
        // Check for common bot patterns
        $botPatterns = [
            'bot', 'crawler', 'spider', 'scraper', 'curl', 'wget',
            'python', 'java/', 'perl/', 'ruby/', 'go-http-client'
        ];
        
        foreach ($botPatterns as $pattern) {
            if (str_contains($userAgent, $pattern)) {
                return true;
            }
        }
        
        // Check for missing or suspicious headers
        if (empty($userAgent) || 
            !$this->request->hasHeader('Accept') || 
            !$this->request->hasHeader('Accept-Language')) {
            return true;
        }
        
        return false;
    }

    protected function checkIPReputation(): bool
    {
        $ip = $this->request->ip();
        
        // Check if IP has excessive failed attempts across all emails
        $totalAttempts = FailedLoginAttempt::where('ip_address', $ip)
            ->where('created_at', '>', now()->subDay())
            ->sum('attempts');
        
        return $totalAttempts > 50;
    }

    public function logSecurityEvent(string $event, array $context = []): void
    {
        $defaultContext = [
            'ip' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
            'url' => $this->request->fullUrl(),
            'timestamp' => now()->toIso8601String()
        ];
        
        Log::channel('security')->warning($event, array_merge($defaultContext, $context));
    }
}