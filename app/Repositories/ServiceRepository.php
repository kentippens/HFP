<?php

namespace App\Repositories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class ServiceRepository extends BaseRepository
{
    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    /**
     * Get all active services
     */
    public function getAllActive(): Collection
    {
        return $this->model->active()->get();
    }

    /**
     * Get active services ordered
     */
    public function getActiveOrdered(): Collection
    {
        return $this->model->active()->ordered()->get();
    }

    /**
     * Get active parent services with children
     */
    public function getActiveParentsWithChildren(): Collection
    {
        return $this->model
            ->active()
            ->whereNull('parent_id')
            ->with('children')
            ->ordered()
            ->get();
    }

    /**
     * Get active services by slugs
     */
    public function getActiveBySlugs(array $slugs): Collection
    {
        return $this->model
            ->where('is_active', true)
            ->whereIn('slug', $slugs)
            ->orderBy('order_index')
            ->get();
    }

    /**
     * Find active service by slug
     */
    public function findActiveBySlug(string $slug): ?Service
    {
        return $this->model
            ->active()
            ->where('slug', $slug)
            ->first();
    }
}
