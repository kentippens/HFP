@extends('layouts.app')

@section('title', $page->meta_title ?: $page->name)
@section('meta_description', $page->meta_description)
@section('meta_robots', $page->meta_robots ?? 'index, follow')
@if($page->canonical_url)
    @section('canonical_url', $page->canonical_url)
@endif
@if($page->json_ld)
    @section('json_ld')
{!! $page->json_ld_string !!}
    @endsection
@endif

@if($page->custom_css)
@push('styles')
<style>
{!! $page->custom_css !!}
</style>
@endpush
@endif

@section('content')

<!-- Landing Page Content -->
<div class="landing-page-content">
    {!! $page->content !!}
</div>

@endsection

@if($page->custom_js)
@push('scripts')
<script>
{!! $page->custom_js !!}
</script>
@endpush
@endif

@if($page->conversion_tracking_code)
@push('scripts')
{!! $page->conversion_tracking_code !!}
@endpush
@endif