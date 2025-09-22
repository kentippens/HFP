<div class="sr-sidebar">
    <div class="sidebar-widget sr-list-widget">
        <div class="widget-title">
            <h5>All Services</h5>
        </div>
        <div class="list-nav">
            <ul>
                @php
                    $allServices = \App\Models\Service::active()
                        ->topLevel()
                        ->with('activeChildren')
                        ->ordered()
                        ->get();
                @endphp
                @foreach($allServices as $sidebarService)
                    @php
                        // Check if this service or any of its children is active
                        $isParentActive = $service->id === $sidebarService->id;
                        $hasActiveChild = false;
                        foreach($sidebarService->activeChildren as $child) {
                            if($service->id === $child->id) {
                                $hasActiveChild = true;
                                break;
                            }
                        }
                        $shouldExpand = $isParentActive || $hasActiveChild;
                    @endphp
                    <li class="has-children {{ $sidebarService->activeChildren->count() > 0 ? 'has-sub-services' : '' }}">
                        <a href="{{ route('services.show', $sidebarService->full_slug) }}" class="service-link {{ $isParentActive ? 'active' : '' }}" style="display: flex; justify-content: space-between; align-items: center;">
                            <span>{{ $sidebarService->name }}</span>
                            @if($sidebarService->activeChildren->count() > 0)
                                <span class="service-nav-icon toggle-icon" style="width: 16px; height: 16px; flex-shrink: 0; cursor: pointer;" data-expanded="{{ $shouldExpand ? 'true' : 'false' }}" data-service-id="{{ $sidebarService->id }}">
                                    @if($shouldExpand)
                                        @icon('fa-angle-down')
                                    @else
                                        @icon('fa-angle-right')
                                    @endif
                                </span>
                            @else
                                <span class="service-nav-icon" style="width: 16px; height: 16px; flex-shrink: 0;">@icon('fa-angle-right')</span>
                            @endif
                        </a>
                        @if($sidebarService->activeChildren->count() > 0)
                            <ul class="sub-services-list" style="padding-left: 20px; margin-top: 5px; {{ $shouldExpand ? '' : 'display: none;' }}">
                                @foreach($sidebarService->activeChildren as $childService)
                                    <li>
                                        <a href="{{ route('services.show', $childService->full_slug) }}" class="service-link {{ $service->id === $childService->id ? 'active' : '' }}" style="display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
                                            <span>{{ $childService->name }}</span>
                                            <span class="service-nav-icon" style="width: 14px; height: 14px; flex-shrink: 0;">@icon('fa-angle-right')</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="sidebar-widget sr-btn-widget" data-background="{{ asset('images/services/sidebar.png') }}">
        <span class="subtitle">Service Overview</span>
        <h5>Service Data Sheets</h5>
        <div class="download-btns">            
            <a href="#" class="btn-2">House Cleaning Flyer<span>@icon("fa-file-pdf") </span></a>
            <a href="#" class="btn-2">Pool Cleaning Flyer<span>@icon("fa-file-pdf") </span></a>
        </div>
    </div>
</div>