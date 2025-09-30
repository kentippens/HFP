<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

// Get recent posts
$recentPosts = \App\Models\BlogPost::published()
    ->with('blogCategory')
    ->latest('published_at')
    ->take(3)
    ->get();

echo "=== Recent Posts Debug ===\n\n";

foreach ($recentPosts as $index => $post) {
    $num = $index + 1;
    echo "Post #{$num}: {$post->name}\n";
    echo "  - Slug: {$post->slug}\n";
    echo "  - Has Category: " . ($post->blogCategory ? 'Yes' : 'No') . "\n";
    if ($post->blogCategory) {
        echo "  - Category Name: {$post->blogCategory->name}\n";
        echo "  - Category Slug: {$post->blogCategory->slug}\n";
    }
    echo "  - Thumbnail URL: {$post->thumbnail_url}\n";
    echo "\n";
}

// Check if there's any view composer or service provider adding extra data
echo "=== Checking View Composers ===\n";
$viewServiceProvider = new \App\Providers\ViewServiceProvider(app());
echo "ViewServiceProvider exists: " . (class_exists('\App\Providers\ViewServiceProvider') ? 'Yes' : 'No') . "\n";