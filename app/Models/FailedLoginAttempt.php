<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedLoginAttempt extends Model
{
    protected $fillable = [
        'email',
        'ip_address',
        'user_agent',
        'attempts',
        'last_attempt_at',
        'locked_until',
    ];

    protected $casts = [
        'last_attempt_at' => 'datetime',
        'locked_until' => 'datetime',
    ];

    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function incrementAttempts(): void
    {
        $this->increment('attempts');
        $this->last_attempt_at = now();
        
        if ($this->attempts >= 5) {
            $this->locked_until = now()->addMinutes(15);
        }
        
        $this->save();
    }

    public function resetAttempts(): void
    {
        $this->attempts = 0;
        $this->locked_until = null;
        $this->save();
    }
}
