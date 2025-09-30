@extends('layouts.app')

@section('title', $seoData->meta_title ?? 'Blog')
@section('meta_description', $seoData->meta_description ?? 'Read our latest articles about cleaning tips and industry news.')
@section('meta_robots', $seoData->meta_robots ?? 'index, follow')
@if($seoData && $seoData->canonical_url)
    @section('canonical_url', $seoData->canonical_url)
@endif
@if($seoData && $seoData->json_ld)
    @section('json_ld')
{!! $seoData->json_ld_string !!}
    @endsection
@endif

@section('content')

<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ asset('images/home1/hero-image-v.jpg') }}">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>Field Notes Blog</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>Blog</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Blog Content -->
<div class="blog-content-section pt-100 pb-100">
    <span class="star-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="blog-posts">
                    @forelse($posts as $post)
                    <div class="blog-single-post">
                        @if($post->thumbnail_url)
                        <div class="bixol-img-wrapper">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->name }}">
                            </a>
                            <div class="bixol-blog-date">
                                <span>{{ $post->published_at->format('d M') }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="bixol-blog-content">
                            @if($post->blogCategory)
                            <a href="{{ route('blog.category', $post->blogCategory->slug) }}" class="bixol-category">{{ $post->blogCategory->name }}</a>
                            @endif
                            <div class="bixol-blog-headline">
                                <a href="{{ route('blog.show', $post->slug) }}"><h5>{{ $post->name }}</h5></a>
                            </div>
                            <div class="bixol-blog-pera">
                                <p>{{ $post->excerpt }}</p>
                            </div>
                            <div class="bixol-blog-btn">
                                <a href="{{ route('blog.show', $post->slug) }}" class="bixol-primary-btn"> Read More <span>@icon("fas fa-plus")</span></a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-info">
                        <p>No blog posts found. Please check back later.</p>
                    </div>
                    @endforelse
                </div>
                
                @if($posts->hasPages())
                <div class="bixol-pagination">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
            <div class="col-lg-3">
                <div class="blog-sidebar">
                    <div class="sidebar-widget author-widget no-border" data-background="{{ asset('images/portfolio/Blog-BG.png') }}">
                        <div class="dot-1"><img src="{{ asset('images/portfolio/dot-1.png') }}" alt=""></div>
                        <div class="dot-2">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>                        
                        <div class="author-thumb">
                            <img src="{{ asset('images/portfolio/HSS-Logo-Circle.png') }}" alt="">
                        </div>
                        <div class="author-info">
                            <h5>Hex Team</h5>
                            <span>Building Services</span>
                        </div>
                        <div class="social-info">
                            <a href="https://www.facebook.com/hexagonservicesolutions" class="fb">@icon("fab fa-facebook-f")</a>
                            <a href="#" class="tw">@icon("fab fa-instagram")</a> 
                            <a href="#" class="tw">@icon("fab fa-twitter")</a>                            
                        </div>
                    </div>
                    <div class="sidebar-widget search-sidebar no-border">
                        <div class="search-form">
                            <form action="{{ route('blog.index') }}" method="GET">
                                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <button type="submit">@icon("fas fa-search")</button>
                            </form>
                        </div>
                    </div>
                    <div class="sidebar-widget category-widget">
                        <div class="widget-title">
                            <h5>Categories</h5>
                        </div>
                        <div class="list-nav">
                            <ul>
                                @forelse($categories as $category)
                                <li><a href="{{ route('blog.category', $category->slug) }}" {{ request()->is('blog/category/' . $category->slug) ? 'class=active' : '' }}>{{ $category->name }} ({{ $category->posts_count }})</a></li>
                                @empty
                                <li><a href="#" class="text-muted">No categories yet</a></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-widget recent-post-widget">
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog Content End -->

@endsection

@push('styles')
<style>
    /* Fix social media icon centering in author widget */
    .blog-sidebar .author-widget .social-info a {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none;
    }
    
    .blog-sidebar .author-widget .social-info a .icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 16px;
        height: 16px;
    }
    
    .blog-sidebar .author-widget .social-info a .icon svg {
        width: 100%;
        height: 100%;
        display: block;
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