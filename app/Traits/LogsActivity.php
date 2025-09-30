<?php

namespace App\Traits;

use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    /**
     * Store for temporary old attributes
     */
    protected $temporaryOldAttributes = [];

    /**
     * Boot the trait and register model events.
     */
    public static function bootLogsActivity(): void
    {
        // Log when a model is created
        static::created(function (Model $model) {
            if ($model->shouldLogActivity('created')) {
                ActivityLogger::logCreated($model, $model->getActivityDescription('created'));
            }
        });

        // Log when a model is updated
        static::updating(function (Model $model) {
            if ($model->shouldLogActivity('updating')) {
                // Store old attributes in a non-database property
                $model->temporaryOldAttributes = $model->getOriginal();
            }
        });

        static::updated(function (Model $model) {
            if ($model->shouldLogActivity('updated') && !empty($model->temporaryOldAttributes)) {
                ActivityLogger::logUpdated(
                    $model,
                    $model->temporaryOldAttributes,
                    $model->getActivityDescription('updated')
                );
                $model->temporaryOldAttributes = [];
            }
        });

        // Log when a model is deleted
        static::deleted(function (Model $model) {
            if ($model->shouldLogActivity('deleted')) {
                ActivityLogger::logDeleted($model, $model->getActivityDescription('deleted'));
            }
        });

        // Log when a model is restored (if using SoftDeletes)
        if (method_exists(static::class, 'restored')) {
            static::restored(function (Model $model) {
                if ($model->shouldLogActivity('restored')) {
                    ActivityLogger::logRestored($model, $model->getActivityDescription('restored'));
                }
            });
        }
    }

    /**
     * Get the activity log options.
     */
    public function getActivityLogOptions(): array
    {
        return property_exists($this, 'activityLogOptions')
            ? $this->activityLogOptions
            : [];
    }

    /**
     * Determine if activity should be logged for the given event.
     */
    public function shouldLogActivity(string $event): bool
    {
        $options = $this->getActivityLogOptions();

        // Check if logging is enabled
        if (isset($options['enabled']) && !$options['enabled']) {
            return false;
        }

        // Check if specific events are configured
        if (isset($options['events'])) {
            return in_array($event, $options['events']);
        }

        // Default to logging all events
        return true;
    }

    /**
     * Get the description for the activity log.
     */
    public function getActivityDescription(string $event): ?string
    {
        $options = $this->getActivityLogOptions();

        if (isset($options['descriptions'][$event])) {
            return $options['descriptions'][$event];
        }

        // Generate default description
        $modelName = class_basename($this);
        $identifier = $this->getActivityIdentifier();

        return match($event) {
            'created' => ":causer created {$modelName} {$identifier}",
            'updated' => ":causer updated {$modelName} {$identifier}",
            'deleted' => ":causer deleted {$modelName} {$identifier}",
            'restored' => ":causer restored {$modelName} {$identifier}",
            default => ":causer performed {$event} on {$modelName} {$identifier}",
        };
    }

    /**
     * Get the identifier for the model in activity logs.
     */
    public function getActivityIdentifier(): string
    {
        $options = $this->getActivityLogOptions();

        if (isset($options['identifier'])) {
            $field = $options['identifier'];
            return $this->$field ?? "#{$this->getKey()}";
        }

        // Try common identifier fields
        foreach (['name', 'title', 'email', 'slug'] as $field) {
            if (isset($this->$field)) {
                return $this->$field;
            }
        }

        return "#{$this->getKey()}";
    }

    /**
     * Get the attributes that should be logged.
     */
    public function getActivityLoggableAttributes(): array
    {
        $options = $this->getActivityLogOptions();

        if (isset($options['only'])) {
            return array_intersect_key($this->getAttributes(), array_flip($options['only']));
        }

        if (isset($options['except'])) {
            return array_diff_key($this->getAttributes(), array_flip($options['except']));
        }

        return $this->getAttributes();
    }

    /**
     * Log a custom activity for this model.
     */
    public function logActivity(string $event, string $description = null, array $properties = []): void
    {
        ActivityLogger::log()
            ->useLog($this->getActivityLogName())
            ->event($event)
            ->performedOn($this)
            ->withDescription($description ?? $this->getActivityDescription($event))
            ->withProperties($properties)
            ->save();
    }

    /**
     * Get the log name for this model.
     */
    public function getActivityLogName(): string
    {
        $options = $this->getActivityLogOptions();
        return $options['log_name'] ?? 'model';
    }

    /**
     * Get the activity log relationship.
     */
    public function activities()
    {
        return $this->morphMany(\App\Models\Activity::class, 'subject');
    }

    /**
     * Get activities caused by this model.
     */
    public function causedActivities()
    {
        return $this->morphMany(\App\Models\Activity::class, 'causer');
    }
}