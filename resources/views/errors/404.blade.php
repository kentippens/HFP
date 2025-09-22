@extends('layouts.app')

@section('title', 'Page Not Found')
@section('meta_description', 'The page you are looking for could not be found.')

@section('content')
<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ asset('images/home1/breadcrumb.jpg') }}">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>404</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>404</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- 404 Area -->
<section class="not-found-area pt-100 pb-150" data-background="{{ asset('images/404-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="404-content">
                    <div class="title-txt">
                        <h3>Sorry page not found</h3>
                    </div>
                    <div class="not-found-img">
                        <img src="{{ asset('images/404.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="not-found-btns">
            <a href="{{ route('home') }}" class="home-btn"><span>@icon("fas fa-home")</span>Go back home</a>
            <a href="#" class="sb-btn"><span>@icon("fab fa-telegram-plane")</span>Subscribe</a>
        </div>
    </div>
</section>
<!-- 404 End -->
@endsection