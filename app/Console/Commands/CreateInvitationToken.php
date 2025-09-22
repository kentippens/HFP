<?php

namespace App\Console\Commands;

use App\Models\InvitationToken;
use Illuminate\Console\Command;

class CreateInvitationToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitation:create 
                            {--email= : The email address to invite (optional)}
                            {--days=7 : Number of days until expiration}
                            {--notes= : Notes about this invitation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an invitation token for user registration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = InvitationToken::generateToken();
        
        $invitation = InvitationToken::create([
            'token' => $token,
            'email' => $this->option('email'),
            'invited_by' => 'Console Command',
            'expires_at' => now()->addDays($this->option('days')),
            'notes' => $this->option('notes'),
        ]);
        
        $this->info('Invitation token created successfully!');
        $this->info('');
        $this->info('Token: ' . $token);
        $this->info('Registration URL: ' . route('register', ['token' => $token]));
        
        if ($invitation->email) {
            $this->info('For: ' . $invitation->email);
        }
        
        $this->info('Expires: ' . $invitation->expires_at->format('Y-m-d H:i:s'));
        
        return Command::SUCCESS;
    }
}
