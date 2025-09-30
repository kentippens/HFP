@extends('layouts.app')

@section('title', 'Blog - ' . $categoryModel->name)
@section('meta_description', 'Browse our ' . $categoryModel->name . ' articles and tips.')

@section('content')

<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ asset('images/home1/breadcrumb.jpg') }}">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>{{ $categoryModel->name }}</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <a href="{{ route('blog.index') }}">Blog @icon("fas fa-angle-double-right")</a>
            <span>{{ $categoryModel->name }}</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Blog Content -->
<div class="blog-content-section pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
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
                        <p>No blog posts found in this category.</p>
                    </div>
                    @endforelse
                </div>
                
                @if($posts->hasPages())
                <div class="bixol-pagination">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Blog Content End -->

@endsection