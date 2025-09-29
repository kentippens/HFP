<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use App\Traits\HasRoles;
use App\Traits\LogsActivity;
use App\Models\BlogPost;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'password_changed_at',
        'force_password_change',
        'failed_login_attempts',
        'locked_until',
        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'password_changed_at' => 'datetime',
            'force_password_change' => 'boolean',
            'locked_until' => 'datetime',
            'two_factor_enabled' => 'boolean',
            'two_factor_recovery_codes' => 'array',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Activity log configuration.
     */
    protected $activityLogOptions = [
        'identifier' => 'name',
        'log_name' => 'user',
        'except' => ['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes', 'updated_at', 'created_at'],
    ];

    /**
     * Password history relationship
     */
    public function passwordHistories(): HasMany
    {
        return $this->hasMany(PasswordHistory::class)->orderBy('created_at', 'desc');
    }

    /**
     * Blog posts authored by this user
     */
    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    /**
     * Get published blog posts by this user
     */
    public function publishedBlogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'author_id')
            ->where('is_published', true)
            ->whereNotNull('published_at');
    }

    /**
     * Get the author's bio or description
     * This can be extended later with a user profile table
     */
    public function getAuthorBioAttribute(): string
    {
        // This could come from a user_profiles table in the future
        // For now, return a default bio based on role
        if ($this->isSuperAdmin() || $this->is_admin) {
            return 'Administrator at Hexagon Service Solutions, specializing in pool resurfacing and maintenance.';
        }
        
        if ($this->hasRole('author')) {
            return 'Content writer and pool industry expert at Hexagon Service Solutions.';
        }
        
        return 'Team member at Hexagon Service Solutions.';
    }

    /**
     * Get the total number of published posts by this author
     */
    public function getPublishedPostsCountAttribute(): int
    {
        return $this->publishedBlogPosts()->count();
    }

    /**
     * Check if user can edit a specific blog post
     */
    public function canEditBlogPost(BlogPost $post): bool
    {
        // Super admins and admins can edit any post
        if ($this->isSuperAdmin() || $this->is_admin) {
            return true;
        }
        
        // Authors can edit their own posts
        if ($this->hasPermission('blog.edit') && $post->author_id === $this->id) {
            return true;
        }
        
        // Managers with blog.edit permission can edit any post
        if ($this->hasRole('manager') && $this->hasPermission('blog.edit')) {
            return true;
        }
        
        return false;
    }

    /**
     * Check if account is locked
     */
    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    /**
     * Lock the account for a specified duration
     */
    public function lockAccount(int $minutes = 15): void
    {
        $this->update([
            'locked_until' => now()->addMinutes($minutes),
        ]);
    }

    /**
     * Unlock the account
     */
    public function unlockAccount(): void
    {
        $this->update([
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    /**
     * Increment failed login attempts
     */
    public function incrementFailedAttempts(): void
    {
        $this->increment('failed_login_attempts');
        
        // Lock account after 5 failed attempts
        if ($this->failed_login_attempts >= config('security.auth.login.max_attempts', 5)) {
            $this->lockAccount(config('security.auth.login.lockout_duration_minutes', 15));
        }
    }

    /**
     * Reset failed login attempts
     */
    public function resetFailedAttempts(): void
    {
        $this->update([
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    /**
     * Record successful login
     */
    public function recordLogin(string $ip): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    /**
     * Check if password needs to be changed
     */
    public function needsPasswordChange(): bool
    {
        if ($this->force_password_change) {
            return true;
        }

        // Check password age
        $maxAge = config('security.auth.password.max_age_days', 90);
        if ($maxAge > 0 && $this->password_changed_at) {
            return $this->password_changed_at->addDays($maxAge)->isPast();
        }

        return false;
    }

    /**
     * Update password with history tracking
     */
    public function updatePassword(string $password): bool
    {
        // Check password history
        if ($this->isPasswordInHistory($password)) {
            return false;
        }

        // Record current password in history before changing
        if ($this->password) {
            PasswordHistory::recordPassword($this->id, $this->password);
        }

        // Update password
        $this->update([
            'password' => Hash::make($password),
            'password_changed_at' => now(),
            'force_password_change' => false,
        ]);

        // Clean up old password history entries
        PasswordHistory::cleanupOldEntries($this->id, config('security.auth.password.history_count', 5));

        return true;
    }

    /**
     * Check if password exists in history
     */
    public function isPasswordInHistory(string $password): bool
    {
        $historyCount = config('security.auth.password.history_count', 5);
        
        $recentPasswords = $this->passwordHistories()
            ->take($historyCount)
            ->get();

        foreach ($recentPasswords as $history) {
            if ($history->matches($password)) {
                return true;
            }
        }

        // Also check current password
        if (Hash::check($password, $this->password)) {
            return true;
        }

        return false;
    }

    /**
     * Get password age in days
     */
    public function getPasswordAge(): int
    {
        if (!$this->password_changed_at) {
            return 999; // Very old if never changed
        }

        return $this->password_changed_at->diffInDays(now());
    }

    /**
     * Check if user can perform admin actions
     */
    public function canAccessFilament(): bool
    {
        return ($this->is_admin || $this->hasAnyRole(['super-admin', 'admin'])) && !$this->isLocked();
    }

    /**
     * Determine if the user can access the given Filament panel.
     * This method is required by the FilamentUser interface.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Allow admin users or users with admin roles who are not locked
        return ($this->is_admin || $this->hasAnyRole(['super-admin', 'admin'])) && !$this->isLocked();
    }
}
