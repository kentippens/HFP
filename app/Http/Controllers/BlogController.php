<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with('blogCategory')->published()->recent();

        // Handle search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Handle category filter
        if ($request->has('category')) {
            $categorySlug = $request->get('category');
            $category = BlogCategory::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $posts = $query->paginate(5);

        // Get categories with post counts
        $categories = BlogCategory::withCount(['posts' => function($query) {
            $query->published();
        }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = BlogPost::published()->recent()->take(5)->get();

        // Get archive data
        $archives = BlogPost::published()
            ->selectRaw('YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

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
        $post = BlogPost::with('blogCategory')->where('slug', $slug)->published()->firstOrFail();

        // Get previous and next posts
        $previousPost = BlogPost::published()
            ->where('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $nextPost = BlogPost::published()
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        // Get related posts
        $relatedPosts = BlogPost::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->recent()
            ->take(3)
            ->get();

        // Get categories with post counts for sidebar
        $categories = BlogCategory::withCount(['posts' => function($query) {
            $query->published();
        }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = BlogPost::published()->recent()->take(5)->get();

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
        
        $posts = BlogPost::with('blogCategory')->published()
            ->where('category_id', $categoryModel->id)
            ->recent()
            ->paginate(5);

        // Get categories with post counts for sidebar
        $categories = BlogCategory::withCount(['posts' => function($query) {
            $query->published();
        }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = BlogPost::published()->recent()->take(5)->get();

        return view('blog.category', compact('posts', 'categoryModel', 'categories', 'recentPosts'));
    }

    public function archive($year, $month = null)
    {
        $query = BlogPost::with('blogCategory')->published()
            ->whereYear('published_at', $year);

        if ($month) {
            $query->whereMonth('published_at', $month);
        }

        $posts = $query->recent()->paginate(5);

        return view('blog.archive', compact('posts', 'year', 'month'));
    }
}