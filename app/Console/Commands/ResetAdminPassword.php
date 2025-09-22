<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password 
                            {email : The email address of the admin user}
                            {--password= : The new password (will prompt if not provided)}
                            {--show : Show the password in the console output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely reset an admin user password, handling special characters correctly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Find the user
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }
        
        // Get password
        $password = $this->option('password');
        
        if (!$password) {
            $password = $this->secret('Enter new password (hidden for security)');
            $confirmPassword = $this->secret('Confirm new password');
            
            if ($password !== $confirmPassword) {
                $this->error('Passwords do not match.');
                return 1;
            }
        }
        
        // Validate password
        $validator = Validator::make(
            ['password' => $password],
            ['password' => ['required', 'string', 'min:8']]
        );
        
        if ($validator->fails()) {
            $this->error('Password validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error('  - ' . $error);
            }
            return 1;
        }
        
        // Update password - Hash::make handles special characters correctly
        $user->password = Hash::make($password);
        $user->save();
        
        // Clear any cached user data
        cache()->forget('user.' . $user->id);
        
        $this->info("✓ Password successfully reset for {$email}");
        
        if ($this->option('show')) {
            $this->warn("New password: {$password}");
        }
        
        // Additional information
        $this->line('');
        $this->info('Additional steps:');
        $this->line('1. Clear application cache: php artisan cache:clear');
        $this->line('2. Clear config cache: php artisan config:clear');
        $this->line('3. Test login at: ' . url('/admin'));
        
        if ($user->is_admin) {
            $this->info('✓ User has admin access');
        } else {
            $this->warn('⚠ User does not have admin access. Run: php artisan admin:grant ' . $email);
        }
        
        return 0;
    }
}