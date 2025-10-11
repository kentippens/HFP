<?php

namespace App\Repositories;

use App\Models\Silo;
use Illuminate\Database\Eloquent\Collection;

class SiloRepository extends BaseRepository
{
    public function __construct(Silo $model)
    {
        $this->model = $model;
    }

    /**
     * Find active root silo by slug
     */
    public function findActiveRootBySlug(string $slug): ?Silo
    {
        return $this->model
            ->active()
            ->root()
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Find active child by parent and slug
     */
    public function findActiveChild(Silo $parent, string $slug): ?Silo
    {
        return $parent->activeChildren()
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Get active children ordered
     */
    public function getActiveChildren(Silo $parent): Collection
    {
        return $parent->activeChildren()->ordered()->get();
    }

    /**
     * Get all active silos ordered
     */
    public function getAllActive(): Collection
    {
        return $this->model
            ->active()
            ->ordered()
            ->get();
    }

    /**
     * Get active silos by sort order
     */
    public function getActiveBySortOrder(): Collection
    {
        return $this->model
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
