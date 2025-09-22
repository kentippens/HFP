<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InvitationToken extends Model
{
    protected $fillable = [
        'token',
        'email',
        'invited_by',
        'used',
        'used_at',
        'used_by_user_id',
        'expires_at',
        'notes',
    ];

    protected $casts = [
        'used' => 'boolean',
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public static function generateToken(): string
    {
        do {
            $token = Str::random(32);
        } while (self::where('token', $token)->exists());
        
        return $token;
    }

    public function markAsUsed($userId): void
    {
        $this->update([
            'used' => true,
            'used_at' => now(),
            'used_by_user_id' => $userId,
        ]);
    }

    public function isValid(): bool
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'used_by_user_id');
    }
}
