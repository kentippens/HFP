<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'event',
        'causer_type',
        'causer_id',
        'properties',
        'changes',
        'ip_address',
        'user_agent',
        'batch_uuid',
    ];

    protected $casts = [
        'properties' => 'collection',
        'changes' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the subject of the activity log.
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the causer of the activity.
     */
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to only include activities for a given log.
     */
    public function scopeInLog(Builder $query, string ...$logNames): Builder
    {
        if (empty($logNames)) {
            return $query;
        }

        return $query->whereIn('log_name', $logNames);
    }

    /**
     * Scope a query to only include activities by a given causer.
     */
    public function scopeCausedBy(Builder $query, Model $causer): Builder
    {
        return $query
            ->where('causer_type', $causer->getMorphClass())
            ->where('causer_id', $causer->getKey());
    }

    /**
     * Scope a query to only include activities for a given subject.
     */
    public function scopeForSubject(Builder $query, Model $subject): Builder
    {
        return $query
            ->where('subject_type', $subject->getMorphClass())
            ->where('subject_id', $subject->getKey());
    }

    /**
     * Scope a query to only include activities with a given event.
     */
    public function scopeForEvent(Builder $query, string $event): Builder
    {
        return $query->where('event', $event);
    }

    /**
     * Scope a query to only include activities from today.
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Scope a query to only include activities from this week.
     */
    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }

    /**
     * Scope a query to only include activities from this month.
     */
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ]);
    }

    /**
     * Get the changes that were made.
     */
    public function getChangesAttribute($value): array
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }

        return $value ?? [];
    }

    /**
     * Get the old values from changes.
     */
    public function getOldValues(): array
    {
        return $this->changes['old'] ?? [];
    }

    /**
     * Get the new values from changes.
     */
    public function getNewValues(): array
    {
        return $this->changes['attributes'] ?? [];
    }

    /**
     * Check if the activity has recorded changes.
     */
    public function hasRecordedChanges(): bool
    {
        return !empty($this->changes);
    }

    /**
     * Get a specific property.
     */
    public function getExtraProperty(string $propertyName, mixed $default = null): mixed
    {
        return $this->properties->get($propertyName, $default);
    }

    /**
     * Get formatted description with causer name.
     */
    public function getFormattedDescription(): string
    {
        $causerName = $this->causer ? $this->causer->name : 'System';
        return str_replace(':causer', $causerName, $this->description);
    }

    /**
     * Check if this is a failed login attempt.
     */
    public function isFailedLogin(): bool
    {
        return $this->log_name === 'auth' && $this->event === 'failed_login';
    }

    /**
     * Check if this is a successful login.
     */
    public function isSuccessfulLogin(): bool
    {
        return $this->log_name === 'auth' && $this->event === 'login';
    }

    /**
     * Get activity icon based on event type.
     */
    public function getIcon(): string
    {
        return match($this->event) {
            'created' => 'heroicon-o-plus-circle',
            'updated' => 'heroicon-o-pencil',
            'deleted' => 'heroicon-o-trash',
            'restored' => 'heroicon-o-arrow-path',
            'login' => 'heroicon-o-arrow-right-on-rectangle',
            'logout' => 'heroicon-o-arrow-left-on-rectangle',
            'failed_login' => 'heroicon-o-shield-exclamation',
            'password_changed' => 'heroicon-o-key',
            'viewed' => 'heroicon-o-eye',
            'downloaded' => 'heroicon-o-arrow-down-tray',
            'exported' => 'heroicon-o-document-arrow-down',
            'imported' => 'heroicon-o-document-arrow-up',
            default => 'heroicon-o-information-circle',
        };
    }

    /**
     * Get activity color based on event type.
     */
    public function getColor(): string
    {
        return match($this->event) {
            'created' => 'success',
            'updated' => 'info',
            'deleted' => 'danger',
            'restored' => 'warning',
            'login' => 'success',
            'logout' => 'gray',
            'failed_login' => 'danger',
            'password_changed' => 'warning',
            default => 'gray',
        };
    }

    /**
     * Get humanized event name.
     */
    public function getEventLabel(): string
    {
        return match($this->event) {
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            'restored' => 'Restored',
            'login' => 'Logged In',
            'logout' => 'Logged Out',
            'failed_login' => 'Failed Login',
            'password_changed' => 'Password Changed',
            'viewed' => 'Viewed',
            'downloaded' => 'Downloaded',
            'exported' => 'Exported',
            'imported' => 'Imported',
            default => ucfirst($this->event),
        };
    }
}