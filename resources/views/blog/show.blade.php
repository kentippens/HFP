@extends('layouts.app')

@section('title', $post->meta_title ?: $post->name)
@section('meta_description', $post->meta_description ?: $post->excerpt)
@section('meta_robots', $post->meta_robots ?? 'index, follow')
@if($post->canonical_url)
    @section('canonical_url', $post->canonical_url)
@endif
@if($post->json_ld)
    @section('json_ld')
{{ \App\Helpers\HtmlHelper::adminContent($post->json_ld_string) }}
    @endsection
@endif

@section('content')

<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ asset('/images/home1/hero-image-v.jpg') }}">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>{{ $post->name }}</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <a href="{{ route('blog.index') }}">Blog @icon("fas fa-angle-double-right")</a>
            <span>{{ Str::limit($post->name, 30) }}</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Blog Content -->
<div class="blog-content-section blog-details pt-100 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-posts">
                    <div class="blog-details-post">
                        @if($post->featured_image_url)
                        <div class="blog-thumbnail">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->name }}">
                        </div>
                        @endif
                        <div class="details-blog-meta mt-20">
                            <div class="blog-date">
                                <span>@icon("fas fa-calendar-alt"){{ $post->published_at->format('F d, Y') }}</span>
                            </div>
                            <div class="blog-author">
                                <span>@icon("far fa-user"){{ $post->author_name }}</span>
                            </div>
                            @if($post->blogCategory)
                            <div class="blog-categories">
                                <span>@icon("far fa-folder"){{ $post->blogCategory->name }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="blog-content mt-20">
                            {!! \App\Helpers\HtmlHelper::adminContent($post->content_html) !!}
                        </div>
                        
                    </div>

                    <div class="single-blog-pagination">
                        @if($previousPost)
                        <a href="{{ route('blog.show', $previousPost->slug) }}" class="prev-post">@icon("fas fa-angle-double-left")Previous Post</a>
                        @endif
                        @if($nextPost)
                        <a href="{{ route('blog.show', $nextPost->slug) }}" class="next-post">Next Post @icon("fas fa-angle-double-right")</a>
                        @endif
                    </div>
                    
                    <div class="seperator mt-30 mb-30"><hr></div>
                    <div class="blog-content-bottom">
                        <div class="social-share">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="fb">@icon("fab fa-facebook-f")</a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->name) }}" target="_blank" class="tw">@icon("fab fa-twitter")</a>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog-sidebar blog-details-sidebar">
                    <div class="sidebar-widget contact-widget no-border" data-background="{{ asset('images/blog/sidebar-bg.png') }}">
                        <div class="widget-content">
                            <span class="subtitle">Quick Quote</span>
                            <span class="title">Let's get started?</span>
                            <p>We're standing ready to help with your home service needs.</p>
                            <a href="{{ route('contact.index') }}">Get Started @icon("fas fa-long-arrow-alt-right")</a>
                        </div>
                    </div>
                    <div class="sidebar-widget recent-post-widget no-border">
                        <div class="widget-title">
                            <h5>Recent posts</h5>
                        </div>
                        @forelse($recentPosts as $recentPost)
                        <div class="recent-post-single">
                            <div class="recent-post-content">
                                <div class="title">
                                    <a href="{{ route('blog.show', $recentPost->slug) }}"><h6>{{ Str::limit($recentPost->name, 35) }}</h6></a>
                                </div>
                                <div class="blog-meta">
                                    <span>{{ $recentPost->published_at->format('F d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-info" style="padding: 10px; font-size: 14px;">
                            <p>No recent posts yet.</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="sidebar-widget category-widget no-border">
                        <div class="widget-title">
                            <h5>Categories</h5>
                        </div>
                        <div class="list-nav">
                            <ul>
                                @forelse($categories as $category)
                                <li><a href="{{ route('blog.category', $category->slug) }}" {{ $post->category_id == $category->id ? 'class=active' : '' }}>{{ $category->name }} ({{ $category->posts_count }})</a></li>
                                @empty
                                <li><a href="#" class="text-muted">No categories yet</a></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog Content End -->

@endsection

@push('styles')
<style>
/* Blog Content Table Styles */
.blog-content table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
    border: 1px solid #ddd;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.blog-content table thead {
    background-color: #f8f9fa;
    font-weight: 600;
}

.blog-content table th,
.blog-content table td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

.blog-content table th {
    background-color: #043f88;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 0.5px;
}

.blog-content table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

.blog-content table tbody tr:hover {
    background-color: #e9ecef;
    transition: background-color 0.3s ease;
}

/* Make tables responsive */
@media (max-width: 768px) {
    .blog-content table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .blog-content h1 {
        font-size: 28px;
    }

    .blog-content h2 {
        font-size: 24px;
    }

    .blog-content h3 {
        font-size: 20px;
    }
}

/* Blog Content Lists */
.blog-content ul,
.blog-content ol {
    margin: 15px 0;
    padding-left: 30px;
}

.blog-content ul li,
.blog-content ol li {
    margin: 8px 0;
    line-height: 1.6;
}

/* Blog Content Headings */
.blog-content h1 {
    font-size: 40px;
    margin-top: 30px;
    margin-bottom: 20px;
    color: #043f88;
    font-weight: 700;
}

.blog-content h2,
.blog-content h3,
.blog-content h4 {
    margin-top: 30px;
    margin-bottom: 15px;
    color: #043f88;
}

.blog-content h2 {
    font-size: 28px;
    font-weight: 600;
    border-bottom: 2px solid #043f88;
    padding-bottom: 10px;
}

.blog-content h3 {
    font-size: 22px;
    font-weight: 600;
}

.blog-content h4 {
    font-size: 18px;
    font-weight: 600;
}

/* Blog Content Paragraphs */
.blog-content p {
    margin: 15px 0;
    line-height: 1.8;
    color: #333;
}

/* Blog Content Blockquotes */
.blog-content blockquote {
    margin: 20px 0;
    padding: 15px 20px;
    background-color: #f8f9fa;
    border-left: 4px solid #043f88;
    font-style: italic;
    color: #555;
}

/* Code blocks if any */
.blog-content pre,
.blog-content code {
    background-color: #f4f4f4;
    padding: 2px 5px;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
}

.blog-content pre {
    padding: 15px;
    overflow-x: auto;
    margin: 20px 0;
}

/* Recent Posts Widget Fixes */
.recent-post-widget .recent-post-single {
    display: flex;
    align-items: flex-start;
    margin-bottom: 8px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eee;
}

.recent-post-widget .recent-post-single:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.recent-post-widget .recent-post-content {
    flex: 1;
}

.recent-post-widget .recent-post-content .title h6 {
    font-size: 14px;
    line-height: 1.2;
    margin-bottom: 3px;
    margin-top: 0;
    font-weight: 600;
}

.recent-post-widget .recent-post-content .title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
}

.recent-post-widget .recent-post-content .title a:hover {
    color: #043f88;
}

.recent-post-widget .blog-meta {
    font-size: 12px;
    color: #999;
    margin: 0;
}

.recent-post-widget .blog-meta span {
    display: inline-block;
}

/* Remove any unwanted blue link styles */
.recent-post-widget a:not(.title a) {
    display: inline-block;
}

/* Fix for any category/tag links or icon elements that might appear */
.recent-post-widget .category-link,
.recent-post-widget .tag-link,
.recent-post-widget .bixol-category,
.recent-post-widget .blog-categories,
.recent-post-widget .blog-tags,
.recent-post-widget .icon:empty,
.recent-post-widget i.icon:not(:has(svg)) {
    display: none !important;
}

/* Ensure blog meta only shows the date */
.recent-post-widget .blog-meta {
    font-size: 12px;
    color: #999;
    margin: 0;
}

.recent-post-widget .blog-meta > :not(span:first-child) {
    display: none !important;
}

/* Ensure recent post single layout is clean */
.recent-post-widget .recent-post-single {
    display: flex;
    align-items: flex-start;
    margin-bottom: 8px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eee;
    background: transparent !important;
}

/* Ensure no blue background on any child elements */
.recent-post-widget .recent-post-single * {
    background-color: transparent !important;
}

.recent-post-widget .recent-post-single a:not(.title a) {
    display: inline-block;
    background-color: transparent !important;
    color: inherit !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Social share functionality
    $('.social-share a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (url !== '#') {
            window.open(url, 'share', 'width=600,height=400,resizable=yes');
        }
    });
});
</script>
@endpush