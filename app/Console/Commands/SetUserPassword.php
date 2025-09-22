<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Rules\SecurePassword;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:set-password {email} {--force : Force password change on next login}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a new password for a user with security validation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }

        $this->info("Setting password for: {$user->name} ({$user->email})");
        $this->newLine();

        // Show password requirements
        $this->line('Password Requirements:');
        $this->line('- Minimum ' . config('security.auth.password.min_length', 12) . ' characters');
        $this->line('- At least one uppercase letter');
        $this->line('- At least one lowercase letter');
        $this->line('- At least one number');
        $this->line('- At least one special character');
        $this->line('- Cannot be a common password');
        $this->line('- Cannot contain personal information');
        $this->newLine();

        $password = $this->secret('Enter new password');
        $passwordConfirmation = $this->secret('Confirm new password');

        if ($password !== $passwordConfirmation) {
            $this->error('Passwords do not match.');
            return 1;
        }

        // Validate password
        $rule = new SecurePassword($user->name, $user->email);
        
        if (!$rule->passes('password', $password)) {
            $this->error('Password validation failed:');
            foreach ($rule->getFailures() as $failure) {
                $this->error('- ' . $failure);
            }
            return 1;
        }

        // Check password history
        if ($user->isPasswordInHistory($password)) {
            $this->error('This password has been used recently. Please choose a different password.');
            return 1;
        }

        // Calculate and show password strength
        $score = $rule->getStrengthScore($password);
        $strength = $this->getStrengthLabel($score);
        
        $this->info("Password strength: {$strength} ({$score}/100)");
        
        if ($score < 60) {
            if (!$this->confirm('This password is relatively weak. Do you want to continue?')) {
                return 1;
            }
        }

        // Update password
        $user->updatePassword($password);

        if ($this->option('force')) {
            $user->update(['force_password_change' => true]);
            $this->info('Password updated. User will be required to change password on next login.');
        } else {
            $this->info('Password updated successfully.');
        }

        // Show password info
        $this->newLine();
        $this->table(
            ['Property', 'Value'],
            [
                ['Password Changed At', $user->password_changed_at->format('Y-m-d H:i:s')],
                ['Password Age', $user->getPasswordAge() . ' days'],
                ['Force Change Required', $user->force_password_change ? 'Yes' : 'No'],
                ['Account Locked', $user->isLocked() ? 'Yes' : 'No'],
            ]
        );

        return 0;
    }

    protected function getStrengthLabel(int $score): string
    {
        if ($score >= 80) {
            return 'Very Strong';
        } elseif ($score >= 60) {
            return 'Strong';
        } elseif ($score >= 40) {
            return 'Medium';
        } elseif ($score >= 20) {
            return 'Weak';
        }
        
        return 'Very Weak';
    }
}