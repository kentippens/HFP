{{-- Fallback content for service display errors --}}
<div class="service-error-fallback">
    <div class="title-txt">
        <h3>{{ $service->name ?? 'Service' }}</h3>
    </div>
    
    @if($service->short_description)
    <div class="pera-text mt-20">
        <p>{{ $service->short_description }}</p>
    </div>
    @endif
    
    <div class="service-cta mt-40">
        <p>For more information about this service, please contact us.</p>
        <a href="{{ route('contact.index') }}" class="btn btn-primary">
            Contact Us
        </a>
    </div>
</div>