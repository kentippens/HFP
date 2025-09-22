<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SecurePassword implements Rule
{
    protected string $message = 'The password does not meet security requirements.';
    protected array $failures = [];
    protected ?string $username = null;
    protected ?string $email = null;
    
    /**
     * Common weak passwords to check against
     */
    protected array $commonPasswords = [
        'password', '12345678', '123456789', 'qwerty', 'abc123', 'password123',
        'admin', 'letmein', 'welcome', 'monkey', '1234567890', 'dragon',
        'baseball', 'iloveyou', 'trustno1', 'sunshine', 'master', 'hello',
        'freedom', 'whatever', 'shadow', 'ashley', 'football', 'jesus',
        'michael', 'ninja', 'mustang', 'password1', 'qwerty123'
    ];

    public function __construct(?string $username = null, ?string $email = null)
    {
        $this->username = $username;
        $this->email = $email;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->failures = [];

        // Check minimum length
        if (strlen($value) < config('security.auth.password.min_length', 12)) {
            $this->failures[] = 'Password must be at least ' . config('security.auth.password.min_length', 12) . ' characters long.';
        }

        // Check for uppercase letters
        if (config('security.auth.password.require_uppercase', true) && !preg_match('/[A-Z]/', $value)) {
            $this->failures[] = 'Password must contain at least one uppercase letter.';
        }

        // Check for lowercase letters
        if (config('security.auth.password.require_lowercase', true) && !preg_match('/[a-z]/', $value)) {
            $this->failures[] = 'Password must contain at least one lowercase letter.';
        }

        // Check for numbers
        if (config('security.auth.password.require_numbers', true) && !preg_match('/[0-9]/', $value)) {
            $this->failures[] = 'Password must contain at least one number.';
        }

        // Check for special characters
        if (config('security.auth.password.require_symbols', true) && !preg_match('/[^A-Za-z0-9]/', $value)) {
            $this->failures[] = 'Password must contain at least one special character.';
        }

        // Check against common passwords
        if ($this->isCommonPassword($value)) {
            $this->failures[] = 'This password is too common. Please choose a more unique password.';
        }

        // Check for personal information
        if ($this->containsPersonalInfo($value)) {
            $this->failures[] = 'Password should not contain personal information like username or email.';
        }

        // Check for repeated characters
        if ($this->hasRepeatedCharacters($value)) {
            $this->failures[] = 'Password should not contain repeated character sequences.';
        }

        // Check for sequential characters
        if ($this->hasSequentialCharacters($value)) {
            $this->failures[] = 'Password should not contain sequential characters.';
        }

        // Check entropy (randomness)
        if ($this->calculateEntropy($value) < 50) {
            $this->failures[] = 'Password is not complex enough. Mix different types of characters.';
        }

        // Set appropriate error message
        if (!empty($this->failures)) {
            $this->message = implode(' ', $this->failures);
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * Check if password is in common passwords list
     */
    protected function isCommonPassword(string $password): bool
    {
        $lowerPassword = strtolower($password);
        
        // Check against our common passwords list
        if (in_array($lowerPassword, $this->commonPasswords)) {
            return true;
        }

        // Check variations with numbers
        foreach ($this->commonPasswords as $common) {
            if (preg_match('/^' . preg_quote($common, '/') . '\d+$/i', $lowerPassword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if password contains personal information
     */
    protected function containsPersonalInfo(string $password): bool
    {
        $lowerPassword = strtolower($password);

        // Check username
        if ($this->username && strlen($this->username) > 3) {
            if (str_contains($lowerPassword, strtolower($this->username))) {
                return true;
            }
        }

        // Check email parts
        if ($this->email) {
            $emailParts = explode('@', $this->email);
            $localPart = strtolower($emailParts[0]);
            
            // Remove common separators
            $localPart = str_replace(['.', '_', '-'], '', $localPart);
            
            if (strlen($localPart) > 3 && str_contains($lowerPassword, $localPart)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for repeated character sequences
     */
    protected function hasRepeatedCharacters(string $password): bool
    {
        // Check for same character repeated 3+ times
        if (preg_match('/(.)\1{2,}/', $password)) {
            return true;
        }

        // Check for repeated patterns (e.g., "abcabc")
        $length = strlen($password);
        for ($patternLength = 2; $patternLength <= $length / 2; $patternLength++) {
            for ($i = 0; $i <= $length - $patternLength * 2; $i++) {
                $pattern = substr($password, $i, $patternLength);
                $nextPattern = substr($password, $i + $patternLength, $patternLength);
                
                if ($pattern === $nextPattern) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check for sequential characters
     */
    protected function hasSequentialCharacters(string $password): bool
    {
        $sequences = [
            'abcdefghijklmnopqrstuvwxyz',
            'zyxwvutsrqponmlkjihgfedcba',
            '01234567890',
            '09876543210',
            'qwertyuiop',
            'asdfghjkl',
            'zxcvbnm'
        ];

        $lowerPassword = strtolower($password);

        foreach ($sequences as $sequence) {
            // Check for any 4+ character substring
            for ($i = 0; $i <= strlen($sequence) - 4; $i++) {
                $substr = substr($sequence, $i, 4);
                if (str_contains($lowerPassword, $substr)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Calculate password entropy
     */
    protected function calculateEntropy(string $password): float
    {
        $charsets = [
            'lowercase' => 26,
            'uppercase' => 26,
            'numbers' => 10,
            'symbols' => 32,
            'extended' => 128
        ];

        $usedCharsets = 0;

        if (preg_match('/[a-z]/', $password)) {
            $usedCharsets += $charsets['lowercase'];
        }
        if (preg_match('/[A-Z]/', $password)) {
            $usedCharsets += $charsets['uppercase'];
        }
        if (preg_match('/[0-9]/', $password)) {
            $usedCharsets += $charsets['numbers'];
        }
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            $usedCharsets += $charsets['symbols'];
        }

        $entropy = strlen($password) * log($usedCharsets, 2);

        return $entropy;
    }

    /**
     * Get detailed validation failures
     */
    public function getFailures(): array
    {
        return $this->failures;
    }

    /**
     * Calculate password strength score (0-100)
     */
    public function getStrengthScore(string $password): int
    {
        $score = 0;
        $length = strlen($password);

        // Length score (max 25 points)
        $score += min(25, ($length - 8) * 2.5);

        // Character variety (max 25 points)
        if (preg_match('/[a-z]/', $password)) $score += 5;
        if (preg_match('/[A-Z]/', $password)) $score += 5;
        if (preg_match('/[0-9]/', $password)) $score += 5;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $score += 10;

        // Complexity (max 25 points)
        $entropy = $this->calculateEntropy($password);
        $score += min(25, $entropy / 4);

        // Deductions (max -25 points)
        if ($this->isCommonPassword($password)) $score -= 15;
        if ($this->containsPersonalInfo($password)) $score -= 10;
        if ($this->hasRepeatedCharacters($password)) $score -= 5;
        if ($this->hasSequentialCharacters($password)) $score -= 5;

        // Bonus for very long passwords
        if ($length >= 20) $score += 10;
        if ($length >= 30) $score += 15;

        return max(0, min(100, $score));
    }
}