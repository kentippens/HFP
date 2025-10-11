<?php

namespace App\Repositories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogPostRepository extends BaseRepository
{
    public function __construct(BlogPost $model)
    {
        $this->model = $model;
    }

    /**
     * Get published posts with relationships, recent first
     */
    public function getPublishedRecent(int $limit = null): Collection
    {
        $query = $this->model
            ->with(['blogCategory', 'author'])
            ->published()
            ->recent();

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }

    /**
     * Get paginated published posts with relationships
     */
    public function getPaginatedPublished(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['blogCategory', 'author'])
            ->published()
            ->recent()
            ->paginate($perPage);
    }

    /**
     * Find published post by slug
     */
    public function findPublishedBySlug(string $slug): ?BlogPost
    {
        return $this->model
            ->with(['blogCategory', 'author'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();
    }

    /**
     * Get previous post (by published date)
     */
    public function getPreviousPost(BlogPost $post): ?BlogPost
    {
        return $this->model
            ->with(['blogCategory', 'author'])
            ->published()
            ->where('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
    }

    /**
     * Get next post (by published date)
     */
    public function getNextPost(BlogPost $post): ?BlogPost
    {
        return $this->model
            ->with(['blogCategory', 'author'])
            ->published()
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->first();
    }

    /**
     * Get related posts by category
     */
    public function getRelatedPosts(BlogPost $post, int $limit = 3): Collection
    {
        return $this->model
            ->with(['blogCategory', 'author'])
            ->published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->recent()
            ->take($limit)
            ->get();
    }

    /**
     * Search posts by term
     */
    public function search(string $term): LengthAwarePaginator
    {
        return $this->model
            ->with(['blogCategory', 'author'])
            ->published()
            ->where(function ($query) use ($term) {
                $query->where('title', 'like', "%{$term}%")
                    ->orWhere('content', 'like', "%{$term}%")
                    ->orWhere('excerpt', 'like', "%{$term}%");
            })
            ->recent()
            ->paginate(5);
    }

    /**
     * Get posts by category
     */
    public function getByCategory(int $categoryId, int $perPage = 5): LengthAwarePaginator
    {
        return $this->model
            ->with(['blogCategory', 'author'])
            ->published()
            ->where('category_id', $categoryId)
            ->recent()
            ->paginate($perPage);
    }

    /**
     * Get posts by year and optional month
     */
    public function getByArchive(int $year, ?int $month = null, int $perPage = 5): LengthAwarePaginator
    {
        $query = $this->model
            ->with(['blogCategory', 'author'])
            ->published()
            ->whereYear('published_at', $year);

        if ($month) {
            $query->whereMonth('published_at', $month);
        }

        return $query->recent()->paginate($perPage);
    }

    /**
     * Get archive data (year/month groupings with counts)
     */
    public function getArchiveData(): Collection
    {
        return $this->model
            ->published()
            ->selectRaw('YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }
}
