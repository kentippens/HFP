<!-- Modern Mobile Menu -->
<div class="mobile-menu-wrapper" id="mobileMenu">
    <!-- Menu Overlay -->
    <div class="mobile-menu-overlay"></div>
    
    <!-- Menu Panel -->
    <div class="mobile-menu-panel">
        <!-- Menu Header -->
        <div class="mobile-menu-header">
            <a href="{{ route('home') }}" class="mobile-logo">
                <img src="{{ asset('images/logo/HFP-Logo-SQ.svg') }}" alt="{{ config('app.name') }}">
            </a>
            <button class="mobile-menu-close" aria-label="Close menu">
                <span></span>
                <span></span>
            </button>
        </div>
        
        <!-- Menu Body -->
        <div class="mobile-menu-body">
            <!-- Call Button -->
            <div class="mobile-call-section">
                <a href="tel:972-789-2983" class="mobile-call-btn">
                    <span class="call-text">Call Now</span>
                    <span class="call-number">972-789-2983</span>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="mobile-nav">
                <ul>
                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    
                    <li class="has-dropdown {{ request()->routeIs('services.*') && request()->is('*resurfacing*') ? 'active' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            Pool Resurfacing
                            <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12">
                                <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            </svg>
                        </a>
                        <ul class="dropdown-menu">
                            @if(isset($services) && $services->count() > 0)
                                @php
                                    $resurfacingServices = $services->filter(function($service) {
                                        return str_contains(strtolower($service->name), 'resurfacing') || 
                                               str_contains(strtolower($service->name), 'plaster') || 
                                               str_contains(strtolower($service->name), 'marcite');
                                    });
                                @endphp
                                @foreach($resurfacingServices as $service)
                                    <li><a href="{{ route('services.show', $service->full_slug) }}">{{ $service->name }}</a></li>
                                @endforeach
                            @else
                                <li><a href="{{ route('services.index') }}">View Resurfacing Services</a></li>
                            @endif
                        </ul>
                    </li>
                    
                    <li class="has-dropdown {{ request()->routeIs('services.*') && (request()->is('*remodel*') || request()->is('*tile*') || request()->is('*repair*')) ? 'active' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            Pool Remodeling
                            <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12">
                                <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            </svg>
                        </a>
                        <ul class="dropdown-menu">
                            @if(isset($services) && $services->count() > 0)
                                @php
                                    $remodelingServices = $services->filter(function($service) {
                                        return str_contains(strtolower($service->name), 'tile') || 
                                               str_contains(strtolower($service->name), 'remodel') || 
                                               str_contains(strtolower($service->name), 'repair') || 
                                               str_contains(strtolower($service->name), 'crack');
                                    });
                                @endphp
                                @foreach($remodelingServices as $service)
                                    <li><a href="{{ route('services.show', $service->full_slug) }}">{{ $service->name }}</a></li>
                                @endforeach
                            @else
                                <li><a href="{{ route('services.index') }}">View Remodeling Services</a></li>
                            @endif
                        </ul>
                    </li>
                    
                    <li class="{{ request()->routeIs('pool-conversions') ? 'active' : '' }}">
                        <a href="#">Pool Conversions</a>
                    </li>
                    
                    <li class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">
                        <a href="{{ route('blog.index') }}">Blog</a>
                    </li>

                    <li class="has-dropdown {{ request()->routeIs('texas') ? 'active' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            Areas Served
                            <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12">
                                <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            </svg>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('texas') }}">Texas</a></li>
                        </ul>
                    </li>

                    {{-- <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                        <a href="{{ route('about') }}">About</a>
                    </li> --}}

                    <li class="{{ request()->routeIs('contact*') ? 'active' : '' }}">
                        <a href="{{ route('contact.index') }}" class="quote-link">Get A Free Quote</a>
                    </li>
                    
                    @auth
                        <li class="has-dropdown {{ request()->is('admin*') ? 'active' : '' }}">
                            <a href="#" class="dropdown-toggle">
                                {{ Auth::user()->name }}
                                <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12">
                                    <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                </svg>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/admin">Admin Dashboard</a></li>
                                <li><a href="/admin/services">Manage Services</a></li>
                                <li><a href="/admin/blog-posts">Manage Blog</a></li>
                                <li class="divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="logout-btn">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
        
        <!-- Menu Footer -->
        <div class="mobile-menu-footer">
            <div class="social-links">
                <a href="https://www.facebook.com/hexagonservicesolutions" aria-label="Facebook">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M12 2H15V7H12.5C12.5 7 12.5 8.5 12.5 9H15L14.5 12H12.5V20H8V12H5V9H8V6C8 3.5 9.5 2 12 2Z"/>
                    </svg>
                </a>
                <a href="#" aria-label="Twitter">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M19 4.5c-.7.3-1.5.5-2.4.6.9-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1-1.5-1.6-4-1.7-5.6-.2-1 1-1.5 2.5-1.3 3.9-3.4-.2-6.5-1.8-8.5-4.3-1.1 1.9-.6 4.3 1.3 5.5-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.7 3.3 4.1-.6.2-1.2.2-1.9.1.5 1.7 2.1 2.8 3.9 2.9-1.5 1.1-3.3 1.8-5.1 1.8-.3 0-.7 0-1-.1 1.9 1.2 4.1 1.9 6.4 1.9 7.7 0 12-6.4 12-12v-.6c.8-.6 1.5-1.3 2.1-2.2z"/>
                    </svg>
                </a>
                <a href="#" aria-label="Instagram">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <rect x="2" y="2" width="16" height="16" rx="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <circle cx="15" cy="5" r="1" fill="currentColor"/>
                    </svg>
                </a>
            </div>
            <p class="copyright">© {{ date('Y') }} Hexagon Fiberglass Pools</p>
        </div>
    </div>
</div>