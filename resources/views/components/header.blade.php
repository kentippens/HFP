<!-- Home 2 Header  -->
<header class="bixol-header header-style-2">
    <div class="info-bar">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-md-10">
                    <div class="info-left">
                        <span><img src="{{ asset('images/icons/contact/mail.svg') }}" alt="Email" class="header-contact-icon"><strong>Email: </strong><a href="mailto:pools@hexagonfiberglasspools.com" style="color: #ffffff;">pools@hexagonfiberglasspools.com</a></span>
                        <span class="dealer-badge"><i class="fas fa-certificate" style="color: #ffd700;"></i> <strong>Exclusive North & Central Texas Fibre Tech™ Dealer</strong></span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2">
                    <div class="header-social">
                        <a href="https://www.facebook.com/hexagonservicesolutions">@icon('fa-facebook-f')</a>
                        <a href="#">@icon('fa-twitter')</a>
                        <a href="#">@icon('fa-instagram')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-1">
                    <div class="logo-wrapper">
                        <a href="{{ route('home') }}" class="desktop-logo">
                            <img src="{{ asset('images/logo/HFP-Logo-SQ.svg') }}" alt="{{ config('app.name') }}" class="header-logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 desktop-menu-wrapper">
                    <div class="desktop-menu">
                        <nav>
                            <ul>
                                <li class="{{ request()->is('pool-resurfacing*') ? 'active' : '' }}">
                                    <a href="{{ route('silo.pool_resurfacing') }}">Pool Resurfacing</a>
                                </li>
                                <li class="{{ request()->is('pool-conversions*') ? 'active' : '' }}">
                                    <a href="{{ route('silo.pool_conversions') }}">Pool Conversions</a>
                                </li>
                                <li class="{{ request()->is('pool-remodeling*') ? 'active' : '' }}">
                                    <a href="{{ route('silo.pool_remodeling') }}">Pool Remodeling</a>
                                </li>
                                <li class="{{ request()->is('pool-repair-service*') ? 'active' : '' }}">
                                    <a href="{{ route('silo.pool_repair_service') }}">Pool Repair</a>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Areas Served</a>
                                    <ul>
                                        <li><a href="{{ route('texas') }}">Texas</a></li>
                                    </ul>
                                </li>
                                <li class="{{ request()->routeIs('contact*') ? 'active' : '' }}">
                                    <a href="{{ route('contact.index') }}">Contact</a>
                                </li>
                                @auth
                                    <li class="has-submenu {{ request()->is('admin*') ? 'active' : '' }}">
                                        <a href="#">{{ Auth::user()->name }}</a>
                                        <ul>
                                            <li><a href="/admin"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a></li>
                                            <li class="menu-divider"></li>
                                            <li><a href="/admin/services"><i class="fas fa-wrench"></i> Manage Services</a></li>
                                            <li><a href="/admin/blog-posts"><i class="fas fa-blog"></i> Manage Blog Posts</a></li>
                                            <li><a href="/admin/contact-submissions"><i class="fas fa-envelope"></i> Contact Submissions</a></li>
                                            <li><a href="/admin/landing-pages"><i class="fas fa-rocket"></i> Landing Pages</a></li>
                                            <li><a href="/admin/core-pages"><i class="fas fa-file-alt"></i> Core Pages</a></li>
                                            <li><a href="/admin/users"><i class="fas fa-users"></i> Manage Users</a></li>
                                            <li><a href="/admin/tracking-scripts"><i class="fas fa-code"></i> Tracking Scripts</a></li>
                                            <li class="menu-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" style="background: none; border: none; color: inherit; text-decoration: underline; cursor: pointer;"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @endauth
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-3 col-11">
                    <div class="header-right">
                        <!-- Phone CTA Button -->
                        <a href="tel:972-789-2983" class="phone-cta-button">
                            <i class="fas fa-phone-alt"></i>
                            <div class="cta-content">
                                <span class="cta-text">Call Now</span>
                                <span class="cta-number">972-789-2983</span>
                            </div>
                        </a>
                        <div class="bixol-mobile-hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header Area End -->

<style>
/* Phone CTA Button Styles */
.phone-cta-button {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    margin-right: 20px;
}

.phone-cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
    color: #ffffff;
    text-decoration: none;
}

.phone-cta-button i {
    font-size: 16px;
    animation: phone-ring 2s infinite;
}

.phone-cta-button .cta-content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    line-height: 1.2;
}

.phone-cta-button .cta-text {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.9;
    font-weight: 500;
}

.phone-cta-button .cta-number {
    font-size: 16px;
    font-weight: 700;
}

/* Shimmer Effect */
.phone-cta-button::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        45deg,
        transparent 30%,
        rgba(255, 255, 255, 0.3) 50%,
        transparent 70%
    );
    transform: rotate(45deg);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% {
        transform: translateX(-100%) translateY(-100%) rotate(45deg);
    }
    100% {
        transform: translateX(100%) translateY(100%) rotate(45deg);
    }
}

@keyframes phone-ring {
    0%, 100% {
        transform: rotate(0deg);
    }
    10%, 30% {
        transform: rotate(-25deg);
    }
    20%, 40% {
        transform: rotate(25deg);
    }
}

/* Header Top Bar - Single Line Layout */
.info-bar .info-left {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: nowrap;
    white-space: nowrap;
}

.info-bar .info-left span {
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
}

.info-bar .info-left strong {
    margin-right: 5px;
    font-size: 0.85em;
}

.info-bar .info-left a {
    font-size: 0.85em;
}

/* Dealer Badge Styling */
.dealer-badge {
    background: rgba(255, 215, 0, 0.15);
    padding: 2px 10px;
    border-radius: 20px;
    margin-left: auto;
    border: 1px solid rgba(255, 215, 0, 0.3);
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
}

.dealer-badge strong {
    color: #ffd700;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    font-weight: 600;
    font-size: 0.85em;
    margin-right: 0;
}

.dealer-badge i {
    margin-right: 5px;
    animation: pulse-gold 2s infinite;
}

@keyframes pulse-gold {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.1);
    }
}

/* Responsive adjustments */
@media (max-width: 1399px) {
    .info-bar .info-left {
        font-size: 0.9em;
    }

    .dealer-badge {
        margin-left: 10px;
        padding: 2px 8px;
    }
}

@media (max-width: 1199px) {
    .phone-cta-button {
        padding: 8px 16px;
    }
    
    .phone-cta-button .cta-text {
        font-size: 10px;
    }
    
    .phone-cta-button .cta-number {
        font-size: 14px;
    }
}

@media (max-width: 991px) {
    .phone-cta-button {
        padding: 8px 14px;
        margin-right: 10px;
    }
    
    .phone-cta-button i {
        font-size: 14px;
    }
    
    .phone-cta-button .cta-text {
        font-size: 9px;
    }
    
    .phone-cta-button .cta-number {
        font-size: 13px;
    }
}

@media (max-width: 575px) {
    .phone-cta-button {
        padding: 6px 12px;
        margin-right: 8px;
    }
    
    .phone-cta-button i {
        font-size: 12px;
    }
    
    .phone-cta-button .cta-text {
        font-size: 8px;
        display: block; /* Keep "Call Now" visible */
    }
    
    .phone-cta-button .cta-number {
        font-size: 11px;
    }
}

/* Header right section adjustment */
.header-right {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

/* Reduce horizontal spacing for all menu items to fit on one line */
.header-style-2 .desktop-menu ul li a {
    padding-left: 8px !important;
    padding-right: 8px !important;
    font-size: 15px !important; /* Slightly smaller font */
}

/* Reduce margin between all items */
.header-style-2 .desktop-menu ul li + li {
    margin-left: 2px !important;
}

/* Move the menu closer to the logo to use more space */
.header-style-2 .desktop-menu {
    padding-left: 5px !important;
}

/* Logo Sizing */
.header-logo {
    height: 128px;
    width: auto;
    object-fit: contain;
}

/* Move logo slightly to the left on desktop only */
@media (min-width: 992px) {
    .logo-wrapper {
        margin-left: -25px !important;
    }
}

/* Reset logo position on mobile */
@media (max-width: 991px) {
    .logo-wrapper {
        margin-left: 0 !important;
    }
}

.mobile-logo {
    height: 96px;
    width: auto;
    object-fit: contain;
}

/* Logo wrapper adjustments */
.logo-wrapper {
    display: flex;
    align-items: center;
}

.desktop-logo {
    display: inline-block;
}

/* Responsive logo sizing */
@media (max-width: 1199px) {
    .header-logo {
        height: 112px;
    }
}

@media (max-width: 991px) {
    .header-logo {
        height: 96px;
    }
    
    .mobile-logo {
        height: 88px;
    }
}

@media (max-width: 575px) {
    .header-logo {
        height: 80px;
    }
    
    .mobile-logo {
        height: 72px;
    }
}
</style>

<!-- Mobile Menu -->
<div class="bixol-mobile-menu">
    <a href="{{ route('home') }}" class="mobile-menu-logo">
        <img src="{{ asset('images/logo/HFP-Logo-SQ.svg') }}" alt="{{ config('app.name') }}" class="mobile-logo">
    </a>
    <ul>
        <li class="{{ request()->is('pool-resurfacing*') ? 'active' : '' }}">
            <a href="{{ route('silo.pool_resurfacing') }}">Pool Resurfacing</a>
        </li>
        <li class="{{ request()->is('pool-conversions*') ? 'active' : '' }}">
            <a href="{{ route('silo.pool_conversions') }}">Pool Conversions</a>
        </li>
        <li class="{{ request()->is('pool-remodeling*') ? 'active' : '' }}">
            <a href="{{ route('silo.pool_remodeling') }}">Pool Remodeling</a>
        </li>
        <li class="{{ request()->is('pool-repair-service*') ? 'active' : '' }}">
            <a href="{{ route('silo.pool_repair_service') }}">Repair</a>
        </li>
        <li class="has-submenu">
            <a href="#">Areas Served</a>
            <ul>
                <li><a href="#">Texas</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">
            <a href="{{ route('blog.index') }}">Blog</a>
        </li>
        <li class="{{ request()->routeIs('contact*') ? 'active' : '' }}">
            <a href="{{ route('contact.index') }}">Contact</a>
        </li>
        @auth
            <li class="has-submenu {{ request()->is('admin*') ? 'active' : '' }}">
                <a href="#">{{ Auth::user()->name }}</a>
                <ul>
                    <li><a href="/admin"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a></li>
                    <li class="menu-divider"></li>
                    <li><a href="/admin/services"><i class="fas fa-wrench"></i> Manage Services</a></li>
                    <li><a href="/admin/blog-posts"><i class="fas fa-blog"></i> Manage Blog Posts</a></li>
                    <li><a href="/admin/contact-submissions"><i class="fas fa-envelope"></i> Contact Submissions</a></li>
                    <li><a href="/admin/landing-pages"><i class="fas fa-rocket"></i> Landing Pages</a></li>
                    <li><a href="/admin/core-pages"><i class="fas fa-file-alt"></i> Core Pages</a></li>
                    <li><a href="/admin/users"><i class="fas fa-users"></i> Manage Users</a></li>
                    <li><a href="/admin/tracking-scripts"><i class="fas fa-code"></i> Tracking Scripts</a></li>
                    <li class="menu-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; text-decoration: underline; cursor: pointer;"><i class="fas fa-sign-out-alt"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        @endauth
    </ul>
</div>
<!-- Mobile Menu End -->
