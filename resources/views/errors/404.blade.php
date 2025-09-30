@extends('layouts.app')

@section('title', 'Page Not Found - 404')
@section('meta_description', 'The page you are looking for could not be found. Let us help you find what you need.')

@section('content')
<!-- Modern 404 Section -->
<section class="modern-404-section">
    <div class="container">
        <div class="row align-items-center min-vh-60">
            <div class="col-lg-6">
                <div class="error-content">
                    <div class="error-code">
                        <h1>404</h1>
                        <div class="error-code-bg">404</div>
                    </div>
                    <h2>Oops! Page Not Found</h2>
                    <p class="lead">We can't seem to find the page you're looking for. It might have been moved, deleted, or maybe it never existed.</p>

                    <div class="error-actions">
                        <a href="{{ route('home') }}" class="bixol-primary-btn">
                            <i class="fas fa-home"></i> Back to Homepage
                        </a>
                        <a href="{{ route('contact.index') }}" class="bixol-secondary-btn">
                            <i class="fas fa-envelope"></i> Contact Support
                        </a>
                    </div>

                    <div class="helpful-links">
                        <h4>Helpful Links</h4>
                        <div class="quick-links">
                            <a href="{{ route('services.index') }}"><i class="fas fa-wrench"></i> Our Services</a>
                            <a href="{{ route('blog.index') }}"><i class="fas fa-newspaper"></i> Blog</a>
                            <a href="{{ url('/about') }}"><i class="fas fa-info-circle"></i> About Us</a>
                            <a href="{{ route('contact.index') }}"><i class="fas fa-phone"></i> Contact</a>
                        </div>
                    </div>

                    <div class="search-suggestion">
                        <p>Or try searching for what you need:</p>
                        <form action="{{ route('home') }}" method="GET" class="error-search-form">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search our site..." required>
                                <button type="submit" class="btn-search">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="error-illustration">
                    <svg viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg">
                        <!-- Animated construction worker with tools -->
                        <g class="worker-group">
                            <!-- Hard hat -->
                            <ellipse cx="250" cy="100" rx="60" ry="35" fill="#FFA500" class="animate-bounce"/>
                            <rect x="220" y="95" width="60" height="10" fill="#FF8C00"/>

                            <!-- Head -->
                            <circle cx="250" cy="130" r="35" fill="#FDBCB4"/>

                            <!-- Eyes -->
                            <circle cx="235" cy="125" r="3" fill="#333"/>
                            <circle cx="265" cy="125" r="3" fill="#333"/>

                            <!-- Confused expression -->
                            <path d="M 235 145 Q 250 135 265 145" stroke="#333" stroke-width="2" fill="none" class="animate-pulse"/>

                            <!-- Body -->
                            <rect x="220" y="160" width="60" height="80" rx="5" fill="#FF6B35"/>

                            <!-- Arms -->
                            <rect x="190" y="170" width="25" height="60" rx="5" fill="#FDBCB4" transform="rotate(-20 202 200)"/>
                            <rect x="285" y="170" width="25" height="60" rx="5" fill="#FDBCB4" transform="rotate(20 297 200)"/>

                            <!-- Tool (wrench) -->
                            <g transform="rotate(45 180 160)">
                                <rect x="170" y="140" width="8" height="40" fill="#666"/>
                                <circle cx="174" cy="135" r="8" fill="none" stroke="#666" stroke-width="6"/>
                            </g>

                            <!-- Legs -->
                            <rect x="230" y="235" width="20" height="60" rx="5" fill="#4A90E2"/>
                            <rect x="250" y="235" width="20" height="60" rx="5" fill="#4A90E2"/>

                            <!-- Boots -->
                            <ellipse cx="240" cy="300" rx="15" ry="10" fill="#333"/>
                            <ellipse cx="260" cy="300" rx="15" ry="10" fill="#333"/>
                        </g>

                        <!-- Question marks floating around -->
                        <text x="150" y="80" font-size="30" fill="#043f88" class="animate-float-1">?</text>
                        <text x="350" y="120" font-size="25" fill="#FF6B35" class="animate-float-2">?</text>
                        <text x="320" y="250" font-size="35" fill="#4A90E2" class="animate-float-3">?</text>

                        <!-- Broken road sign -->
                        <g class="sign-group">
                            <rect x="380" y="200" width="5" height="100" fill="#8B4513"/>
                            <rect x="340" y="160" width="80" height="50" rx="5" fill="#FFD700" transform="rotate(-10 380 185)"/>
                            <text x="355" y="190" font-size="14" fill="#333" transform="rotate(-10 380 185)">LOST?</text>
                        </g>

                        <!-- Ground -->
                        <rect x="0" y="310" width="500" height="90" fill="#E8E8E8"/>
                        <rect x="0" y="310" width="500" height="10" fill="#D0D0D0"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .modern-404-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
    }

    .min-vh-60 {
        min-height: 60vh;
    }

    .error-content {
        animation: slideInLeft 0.8s ease-out;
    }

    .error-code {
        position: relative;
        margin-bottom: 30px;
    }

    .error-code h1 {
        font-size: 120px;
        font-weight: 900;
        color: #043f88;
        margin: 0;
        line-height: 1;
        text-shadow: 3px 3px 0px rgba(255, 107, 53, 0.3);
        animation: pulse 2s infinite;
    }

    .error-code-bg {
        position: absolute;
        top: -20px;
        left: -20px;
        font-size: 180px;
        font-weight: 900;
        color: rgba(4, 63, 136, 0.05);
        z-index: -1;
    }

    .error-content h2 {
        font-size: 36px;
        color: #333;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .error-content .lead {
        font-size: 18px;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .error-actions {
        display: flex;
        gap: 15px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .bixol-secondary-btn {
        display: inline-block;
        padding: 15px 30px;
        background: transparent;
        color: #043f88;
        border: 2px solid #043f88;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .bixol-secondary-btn:hover {
        background: #043f88;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(4, 63, 136, 0.2);
    }

    .helpful-links {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #ddd;
    }

    .helpful-links h4 {
        font-size: 20px;
        color: #333;
        margin-bottom: 15px;
    }

    .quick-links {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .quick-links a {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
        text-decoration: none;
        font-size: 16px;
        transition: color 0.3s ease;
    }

    .quick-links a:hover {
        color: #043f88;
    }

    .quick-links a .icon {
        width: 18px;
        height: 18px;
    }

    .search-suggestion {
        margin-top: 30px;
        padding: 25px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .search-suggestion p {
        margin-bottom: 15px;
        color: #666;
        font-size: 16px;
    }

    .error-search-form .input-group {
        display: flex;
        border-radius: 50px;
        overflow: hidden;
        border: 2px solid #e0e0e0;
        transition: border-color 0.3s ease;
    }

    .error-search-form .input-group:focus-within {
        border-color: #043f88;
    }

    .error-search-form .form-control {
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        flex: 1;
        outline: none;
    }

    .error-search-form .btn-search {
        background: #043f88;
        color: white;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .error-search-form .btn-search:hover {
        background: #032d5f;
    }

    .error-illustration {
        animation: slideInRight 0.8s ease-out;
    }

    .error-illustration svg {
        width: 100%;
        height: auto;
        max-width: 500px;
    }

    /* Animations */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-bounce {
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .animate-pulse {
        animation: pulse-opacity 2s infinite;
    }

    @keyframes pulse-opacity {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    .animate-float-1 {
        animation: float1 4s ease-in-out infinite;
    }

    .animate-float-2 {
        animation: float2 5s ease-in-out infinite;
    }

    .animate-float-3 {
        animation: float3 6s ease-in-out infinite;
    }

    @keyframes float1 {
        0%, 100% { transform: translate(0, 0); }
        33% { transform: translate(10px, -10px); }
        66% { transform: translate(-10px, 10px); }
    }

    @keyframes float2 {
        0%, 100% { transform: translate(0, 0); }
        33% { transform: translate(-15px, -5px); }
        66% { transform: translate(15px, 5px); }
    }

    @keyframes float3 {
        0%, 100% { transform: translate(0, 0); }
        33% { transform: translate(5px, -15px); }
        66% { transform: translate(-5px, 15px); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .error-code h1 {
            font-size: 80px;
        }

        .error-code-bg {
            font-size: 120px;
        }

        .error-content h2 {
            font-size: 28px;
        }

        .error-actions {
            flex-direction: column;
        }

        .error-actions a {
            width: 100%;
            text-align: center;
        }

        .quick-links {
            flex-direction: column;
        }

        .error-illustration {
            margin-top: 40px;
        }
    }

    @media (max-width: 480px) {
        .error-code h1 {
            font-size: 60px;
        }

        .error-code-bg {
            font-size: 90px;
        }

        .error-content h2 {
            font-size: 24px;
        }

        .error-content .lead {
            font-size: 16px;
        }
    }
</style>
@endpush