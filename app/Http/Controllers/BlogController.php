<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Repositories\BlogPostRepository;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(
        protected BlogPostRepository $blogPostRepository
    ) {}
    public function index(Request $request)
    {
        // Handle search
        if ($request->has('search')) {
            $posts = $this->blogPostRepository->search($request->get('search'));
        }
        // Handle category filter
        elseif ($request->has('category')) {
            $categorySlug = $request->get('category');
            $category = BlogCategory::where('slug', $categorySlug)->first();
            $posts = $category
                ? $this->blogPostRepository->getByCategory($category->id)
                : $this->blogPostRepository->getPaginatedPublished(5);
        }
        else {
            $posts = $this->blogPostRepository->getPaginatedPublished(5);
        }

        // Get categories with post counts
        $categories = BlogCategory::withCount(['posts' => function($query) {
            $query->published();
        }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = $this->blogPostRepository->getPublishedRecent(5);

        // Get archive data
        $archives = $this->blogPostRepository->getArchiveData();

        // Get SEO data for blog index page
        $seoData = $this->getSeoData('blog', [
            'meta_title' => 'Blog',
            'meta_description' => 'Read our latest articles about cleaning tips and industry news.',
            'meta_keywords' => 'blog, cleaning tips, industry news, articles',
        ]);
        
        return view('blog.index', compact('posts', 'categories', 'recentPosts', 'archives', 'seoData'));
    }

    public function show($slug)
    {
        $post = $this->blogPostRepository->findPublishedBySlug($slug);

        // Get previous and next posts
        $previousPost = $this->blogPostRepository->getPreviousPost($post);
        $nextPost = $this->blogPostRepository->getNextPost($post);

        // Get related posts
        $relatedPosts = $this->blogPostRepository->getRelatedPosts($post, 3);

        // Get categories with post counts for sidebar
        $categories = BlogCategory::withCount(['posts' => function($query) {
            $query->published();
        }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = $this->blogPostRepository->getPublishedRecent(5);

        // Sample comments for now (could be made dynamic later)
        $comments = [
            [
                'name' => 'Jennifer Smith',
                'avatar' => 'client-thumb-1.jpg',
                'date' => 'November 19, 2024 AT 11:00 AM',
                'message' => 'These cleaning tips are incredibly helpful! I\'ve been struggling to keep up with household cleaning with my busy schedule.'
            ],
            [
                'name' => 'Robert Davis',
                'avatar' => 'client-thumb-2.jpg',
                'date' => 'November 20, 2024 AT 2:30 PM',
                'message' => 'Professional advice that actually works. Thank you for sharing your expertise with families like mine.'
            ]
        ];

        return view('blog.show', compact('post', 'comments', 'previousPost', 'nextPost', 'relatedPosts', 'categories', 'recentPosts'));
    }

    public function comment(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        // In a real application, you would save the comment to the database
        // For now, we'll just redirect back with a success message
        
        return redirect()->route('blog.show', $slug)
            ->with('success', 'Thank you for your comment! It has been submitted successfully.');
    }

    public function category($category)
    {
        // Find category by slug
        $categoryModel = BlogCategory::where('slug', $category)->firstOrFail();

        // Block carpet cleaning category
        if (strtolower($category) === 'carpet-cleaning') {
            abort(404);
        }

        $posts = $this->blogPostRepository->getByCategory($categoryModel->id, 5);

        // Get categories with post counts for sidebar
        $categories = BlogCategory::withCount(['posts' => function($query) {
            $query->published();
        }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = $this->blogPostRepository->getPublishedRecent(5);

        return view('blog.category', compact('posts', 'categoryModel', 'categories', 'recentPosts'));
    }

    public function archive($year, $month = null)
    {
        $posts = $this->blogPostRepository->getByArchive($year, $month, 5);

        return view('blog.archive', compact('posts', 'year', 'month'));
    }
}