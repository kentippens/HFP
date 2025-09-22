<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'password_hash',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the password history.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if a password matches this historical password
     */
    public function matches(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }

    /**
     * Create a new password history entry for a user
     */
    public static function recordPassword(int $userId, string $passwordHash): self
    {
        return self::create([
            'user_id' => $userId,
            'password_hash' => $passwordHash,
            'created_at' => now(),
        ]);
    }

    /**
     * Clean up old password history entries
     */
    public static function cleanupOldEntries(int $userId, int $keepCount = 5): void
    {
        $entriesToKeep = self::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take($keepCount)
            ->pluck('id');

        self::where('user_id', $userId)
            ->whereNotIn('id', $entriesToKeep)
            ->delete();
    }
}