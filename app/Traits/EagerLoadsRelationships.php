<?php

namespace App\Traits;

trait EagerLoadsRelationships
{
    /**
     * Boot the trait.
     */
    public static function bootEagerLoadsRelationships()
    {
        static::addGlobalScope('eager-load', function ($query) {
            $instance = new static;

            // Check if the model has defined relationships to eager load
            if (property_exists($instance, 'withDefault') && !empty($instance->withDefault)) {
                $query->with($instance->withDefault);
            }
        });
    }

    /**
     * Get a new query builder that doesn't have the eager load scope applied.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQueryWithoutEagerLoad()
    {
        return $this->newQueryWithoutScope('eager-load');
    }
}