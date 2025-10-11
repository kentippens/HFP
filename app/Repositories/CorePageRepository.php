<?php

namespace App\Repositories;

use App\Models\CorePage;
use Illuminate\Database\Eloquent\Collection;

class CorePageRepository extends BaseRepository
{
    public function __construct(CorePage $model)
    {
        $this->model = $model;
    }

    /**
     * Get all active core pages
     */
    public function getAllActive(): Collection
    {
        return $this->model->active()->get();
    }

    /**
     * Get active core pages included in sitemap
     */
    public function getActiveInSitemap(): Collection
    {
        return $this->model->active()->inSitemap()->get();
    }

    /**
     * Find active core page by slug
     */
    public function findActiveBySlug(string $slug): ?CorePage
    {
        return $this->model->getBySlug($slug);
    }
}
