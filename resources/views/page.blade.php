@extends('layouts.app')

@section('title', $seoData['meta_title'] ?? $corePage->name)
@section('meta_description', $seoData['meta_description'] ?? '')
@section('meta_robots', $seoData['meta_robots'] ?? 'index, follow')
@section('canonical_url', $seoData['canonical_url'] ?? '')

@if(!empty($seoData['json_ld']))
@section('json_ld')
{!! $seoData['json_ld'] !!}
@endsection
@endif

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>{{ $corePage->name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $corePage->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Page Content Start -->
<div class="page-content py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-wrapper">
                    {{-- Display content if available from a content field --}}
                    @if(isset($corePage->content))
                        {!! $corePage->content !!}
                    @else
                        <p>Content for this page is coming soon.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Content End -->
@endsection