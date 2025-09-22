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
                        <div class="blog-thumbnail">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->name }}">
                        </div>
                        <div class="details-blog-meta mt-20">
                            <div class="blog-date">
                                <span>@icon("fas fa-calendar-alt"){{ $post->published_at->format('F d, Y') }}</span>
                            </div>
                            <div class="blog-author">
                                <span>@icon("far fa-user"){{ $post->author }}</span>
                            </div>
                            @if($post->blogCategory)
                            <div class="blog-categories">
                                <span>@icon("far fa-folder"){{ $post->blogCategory->name }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="blog-content mt-20">
                            {{ \App\Helpers\HtmlHelper::adminContent($post->content) }}
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
                            <div class="post-thumbnail">
                                <a href="{{ route('blog.show', $recentPost->slug) }}">
                                    @if($recentPost->thumbnail_url)
                                        <img src="{{ $recentPost->thumbnail_url }}" alt="{{ $recentPost->name }}" style="width: 70px; height: 70px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/blog/rc-' . (($loop->index % 3) + 1) . '.jpg') }}" alt="{{ $recentPost->name }}">
                                    @endif
                                </a>
                            </div>
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