<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\SecurePassword;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PasswordStrengthController extends Controller
{
    /**
     * Check password strength and return feedback
     */
    public function check(Request $request): JsonResponse
    {
        $password = $request->input('password', '');
        $username = $request->input('username');
        $email = $request->input('email');

        if (empty($password)) {
            return response()->json([
                'strength' => 0,
                'score' => 0,
                'feedback' => ['Password is required'],
                'isValid' => false,
            ]);
        }

        $rule = new SecurePassword($username, $email);
        $isValid = $rule->passes('password', $password);
        $score = $rule->getStrengthScore($password);

        // Determine strength level
        $strength = $this->getStrengthLevel($score);

        // Get detailed feedback
        $feedback = $rule->getFailures();
        
        // Add positive feedback if password is strong
        if ($score >= 80) {
            $feedback[] = 'Strong password!';
        } elseif ($score >= 60 && empty($feedback)) {
            $feedback[] = 'Good password strength.';
        }

        // Calculate time to crack estimate
        $timeToCrack = $this->estimateTimeToCrack($password);

        return response()->json([
            'strength' => $strength,
            'score' => $score,
            'feedback' => $feedback,
            'isValid' => $isValid,
            'timeToCrack' => $timeToCrack,
            'requirements' => $this->getRequirements(),
        ]);
    }

    /**
     * Get strength level from score
     */
    protected function getStrengthLevel(int $score): string
    {
        if ($score >= 80) {
            return 'very-strong';
        } elseif ($score >= 60) {
            return 'strong';
        } elseif ($score >= 40) {
            return 'medium';
        } elseif ($score >= 20) {
            return 'weak';
        }
        
        return 'very-weak';
    }

    /**
     * Estimate time to crack password
     */
    protected function estimateTimeToCrack(string $password): string
    {
        $length = strlen($password);
        $charset = 0;

        // Calculate character set size
        if (preg_match('/[a-z]/', $password)) $charset += 26;
        if (preg_match('/[A-Z]/', $password)) $charset += 26;
        if (preg_match('/[0-9]/', $password)) $charset += 10;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $charset += 32;

        if ($charset === 0) return 'instantly';

        // Calculate number of possible combinations
        $combinations = pow($charset, $length);

        // Assume 10 billion attempts per second (modern GPU)
        $secondsToCrack = $combinations / 10000000000;

        return $this->formatTime($secondsToCrack);
    }

    /**
     * Format time in human readable format
     */
    protected function formatTime(float $seconds): string
    {
        if ($seconds < 1) {
            return 'instantly';
        } elseif ($seconds < 60) {
            return round($seconds) . ' seconds';
        } elseif ($seconds < 3600) {
            return round($seconds / 60) . ' minutes';
        } elseif ($seconds < 86400) {
            return round($seconds / 3600) . ' hours';
        } elseif ($seconds < 2592000) {
            return round($seconds / 86400) . ' days';
        } elseif ($seconds < 31536000) {
            return round($seconds / 2592000) . ' months';
        } elseif ($seconds < 315360000) {
            return round($seconds / 31536000) . ' years';
        } elseif ($seconds < 3153600000) {
            return round($seconds / 315360000) . ' decades';
        } elseif ($seconds < 31536000000) {
            return round($seconds / 3153600000) . ' centuries';
        }
        
        return 'millennia';
    }

    /**
     * Get password requirements
     */
    protected function getRequirements(): array
    {
        return [
            'minLength' => config('security.auth.password.min_length', 12),
            'requireUppercase' => config('security.auth.password.require_uppercase', true),
            'requireLowercase' => config('security.auth.password.require_lowercase', true),
            'requireNumbers' => config('security.auth.password.require_numbers', true),
            'requireSymbols' => config('security.auth.password.require_symbols', true),
            'preventCommon' => true,
            'preventPersonalInfo' => true,
            'preventRepeating' => true,
            'preventSequential' => true,
        ];
    }
}