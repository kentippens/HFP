<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class ActivityLogger
{
    protected string $logName = 'default';
    protected ?string $description = null;
    protected ?Model $subject = null;
    protected ?Model $causer = null;
    protected ?string $event = null;
    protected array $properties = [];
    protected ?array $changes = null;
    protected bool $logOnlyDirty = true;
    protected array $attributesToIgnore = [];

    /**
     * Start a new activity log entry.
     */
    public static function log(): self
    {
        return new static();
    }

    /**
     * Set the log name.
     */
    public function useLog(string $logName): self
    {
        $this->logName = $logName;
        return $this;
    }

    /**
     * Set the description.
     */
    public function withDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set the subject of the activity.
     */
    public function performedOn(?Model $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Set the causer of the activity.
     */
    public function causedBy(?Model $causer): self
    {
        $this->causer = $causer;
        return $this;
    }

    /**
     * Automatically set the causer to the authenticated user.
     */
    public function causedByAuth(): self
    {
        $this->causer = Auth::user();
        return $this;
    }

    /**
     * Set the event name.
     */
    public function event(string $event): self
    {
        $this->event = $event;
        return $this;
    }

    /**
     * Set custom properties.
     */
    public function withProperties(array $properties): self
    {
        $this->properties = array_merge($this->properties, $properties);
        return $this;
    }

    /**
     * Set a single property.
     */
    public function withProperty(string $key, mixed $value): self
    {
        $this->properties[$key] = $value;
        return $this;
    }

    /**
     * Log changes between old and new values.
     */
    public function withChanges(array $old, array $new): self
    {
        // Filter out unchanged values and ignored attributes
        $old = $this->filterAttributes($old);
        $new = $this->filterAttributes($new);

        if ($this->logOnlyDirty) {
            $old = array_intersect_key($old, array_diff_assoc($new, $old));
            $new = array_intersect_key($new, array_diff_assoc($new, $old));
        }

        if (!empty($old) || !empty($new)) {
            $this->changes = [
                'old' => $old,
                'attributes' => $new,
            ];
        }

        return $this;
    }

    /**
     * Set attributes to ignore when logging changes.
     */
    public function ignoreAttributes(array $attributes): self
    {
        $this->attributesToIgnore = array_merge($this->attributesToIgnore, $attributes);
        return $this;
    }

    /**
     * Filter out ignored attributes.
     */
    protected function filterAttributes(array $attributes): array
    {
        // Always ignore these attributes
        $defaultIgnored = ['created_at', 'updated_at', 'deleted_at', 'remember_token', 'password'];
        $ignored = array_merge($defaultIgnored, $this->attributesToIgnore);

        return array_diff_key($attributes, array_flip($ignored));
    }

    /**
     * Save the activity log entry.
     */
    public function save(): Activity
    {
        // Auto-detect causer if not set
        if (!$this->causer && Auth::check()) {
            $this->causer = Auth::user();
        }

        // Auto-generate description if not set
        if (!$this->description) {
            $this->description = $this->generateDescription();
        }

        // Create the activity log entry
        $activity = Activity::create([
            'log_name' => $this->logName,
            'description' => $this->description,
            'subject_type' => $this->subject?->getMorphClass(),
            'subject_id' => $this->subject?->getKey(),
            'event' => $this->event,
            'causer_type' => $this->causer?->getMorphClass(),
            'causer_id' => $this->causer?->getKey(),
            'properties' => $this->properties,
            'changes' => $this->changes,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'batch_uuid' => $this->getBatchUuid(),
        ]);

        // Reset the logger for next use
        $this->reset();

        return $activity;
    }

    /**
     * Generate a batch UUID for grouping related activities.
     */
    protected function getBatchUuid(): ?string
    {
        return Request::header('X-Batch-Id') ?? session('activity_batch_id');
    }

    /**
     * Generate a description based on the event and subject.
     */
    protected function generateDescription(): string
    {
        $event = $this->event ?? 'performed action';
        $subject = $this->subject ? class_basename($this->subject) : 'resource';
        $subjectId = $this->subject?->getKey() ?? '';

        return ":causer {$event} on {$subject}" . ($subjectId ? " #{$subjectId}" : '');
    }

    /**
     * Reset the logger.
     */
    protected function reset(): void
    {
        $this->logName = 'default';
        $this->description = null;
        $this->subject = null;
        $this->causer = null;
        $this->event = null;
        $this->properties = [];
        $this->changes = null;
        $this->attributesToIgnore = [];
    }

    /**
     * Log a model created event.
     */
    public static function logCreated(Model $model, ?string $description = null): Activity
    {
        $description = $description ?? ":causer created " . class_basename($model) . " #{$model->getKey()}";

        return static::log()
            ->useLog('model')
            ->event('created')
            ->performedOn($model)
            ->withDescription($description)
            ->withProperties(['attributes' => $model->getAttributes()])
            ->save();
    }

    /**
     * Log a model updated event.
     */
    public static function logUpdated(Model $model, array $oldAttributes, ?string $description = null): Activity
    {
        $description = $description ?? ":causer updated " . class_basename($model) . " #{$model->getKey()}";

        return static::log()
            ->useLog('model')
            ->event('updated')
            ->performedOn($model)
            ->withDescription($description)
            ->withChanges($oldAttributes, $model->getAttributes())
            ->save();
    }

    /**
     * Log a model deleted event.
     */
    public static function logDeleted(Model $model, ?string $description = null): Activity
    {
        $description = $description ?? ":causer deleted " . class_basename($model) . " #{$model->getKey()}";

        return static::log()
            ->useLog('model')
            ->event('deleted')
            ->performedOn($model)
            ->withDescription($description)
            ->withProperties(['attributes' => $model->getAttributes()])
            ->save();
    }

    /**
     * Log a model restored event.
     */
    public static function logRestored(Model $model, ?string $description = null): Activity
    {
        $description = $description ?? ":causer restored " . class_basename($model) . " #{$model->getKey()}";

        return static::log()
            ->useLog('model')
            ->event('restored')
            ->performedOn($model)
            ->withDescription($description)
            ->save();
    }

    /**
     * Log a login event.
     */
    public static function logLogin(Model $user): Activity
    {
        return static::log()
            ->useLog('auth')
            ->event('login')
            ->causedBy($user)
            ->withDescription(':causer logged in')
            ->withProperties([
                'ip' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ])
            ->save();
    }

    /**
     * Log a logout event.
     */
    public static function logLogout(Model $user): Activity
    {
        return static::log()
            ->useLog('auth')
            ->event('logout')
            ->causedBy($user)
            ->withDescription(':causer logged out')
            ->save();
    }

    /**
     * Log a failed login attempt.
     */
    public static function logFailedLogin(string $email, ?string $reason = null): Activity
    {
        return static::log()
            ->useLog('auth')
            ->event('failed_login')
            ->withDescription("Failed login attempt for {$email}")
            ->withProperties([
                'email' => $email,
                'reason' => $reason ?? 'Invalid credentials',
                'ip' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ])
            ->save();
    }

    /**
     * Log a password change.
     */
    public static function logPasswordChanged(Model $user): Activity
    {
        return static::log()
            ->useLog('auth')
            ->event('password_changed')
            ->causedBy($user)
            ->performedOn($user)
            ->withDescription(':causer changed password')
            ->save();
    }

    /**
     * Log a file download.
     */
    public static function logDownload(string $filename, ?Model $relatedModel = null): Activity
    {
        return static::log()
            ->useLog('file')
            ->event('downloaded')
            ->performedOn($relatedModel)
            ->withDescription(":causer downloaded file {$filename}")
            ->withProperties(['filename' => $filename])
            ->save();
    }

    /**
     * Log an export action.
     */
    public static function logExport(string $type, int $count, ?array $filters = null): Activity
    {
        return static::log()
            ->useLog('export')
            ->event('exported')
            ->withDescription(":causer exported {$count} {$type}")
            ->withProperties([
                'type' => $type,
                'count' => $count,
                'filters' => $filters,
            ])
            ->save();
    }

    /**
     * Log a custom action.
     */
    public static function logCustom(string $action, ?Model $subject = null, array $properties = []): Activity
    {
        return static::log()
            ->useLog('custom')
            ->event($action)
            ->performedOn($subject)
            ->withProperties($properties)
            ->save();
    }
}