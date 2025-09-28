@extends('layouts.app')

@section('title', 'Investor Relations - Pool Industry Growth Opportunities')
@section('meta_description', 'Explore investment opportunities with Hexagon Fiberglass Pools. Join us in revolutionizing the $15B pool services industry with cutting-edge fiberglass technology.')
@section('meta_robots', 'index, follow')

@section('content')

<style>
    .investor-hero {
        background: linear-gradient(135deg, #02154e 0%, #043f88 100%);
        padding: 120px 0 80px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .investor-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('{{ asset("images/portfolio/Blog-BG.png") }}') center/cover;
        opacity: 0.1;
        z-index: 1;
    }
    .investor-hero .container {
        position: relative;
        z-index: 2;
    }
    .investor-hero h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
        color: white;
    }
    .investor-hero .subtitle {
        font-size: 20px;
        margin-bottom: 30px;
        opacity: 0.9;
        color: white;
    }
    .investor-content {
        padding: 80px 0;
    }
    .opportunity-card {
        background: white;
        border-radius: 12px;
        padding: 40px 30px;
        margin-bottom: 30px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-top: 4px solid #043f88;
    }
    .opportunity-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    .opportunity-card .icon {
        color: #043f88;
        font-size: 48px;
        margin-bottom: 20px;
    }
    .opportunity-card h3 {
        color: #02154e;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 15px;
    }
    .stats-section {
        background: #f8f9fa;
        padding: 80px 0;
    }
    .stat-item {
        text-align: center;
        margin-bottom: 40px;
    }
    .stat-number {
        font-size: 48px;
        font-weight: 700;
        color: #043f88;
        display: block;
    }
    .stat-label {
        font-size: 16px;
        color: #666;
        margin-top: 10px;
    }
    .inquiry-form {
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        margin-top: 40px;
    }
    .inquiry-form h3 {
        color: #02154e;
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: 600;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        color: #02154e;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
        background: white;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #043f88;
        box-shadow: 0 0 0 3px rgba(4, 63, 136, 0.1);
    }
    .submit-btn {
        background: #043f88;
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        width: 100%;
    }
    .submit-btn:hover {
        background: #02154e;
    }
    .growth-timeline {
        background: #02154e;
        padding: 80px 0;
        color: white;
    }
    .timeline-item {
        margin-bottom: 40px;
        padding-left: 60px;
        position: relative;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        width: 20px;
        height: 20px;
        background: #043f88;
        border-radius: 50%;
        border: 4px solid white;
    }
    .timeline-year {
        color: #043f88;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .timeline-content h4 {
        color: white;
        margin-bottom: 10px;
    }
    .timeline-content p {
        color: white;
        opacity: 0.9;
    }
    .alert {
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        font-size: 16px;
    }
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    @media (max-width: 768px) {
        .investor-hero h1 {
            font-size: 36px;
        }
        .investor-hero .subtitle {
            font-size: 18px;
        }
        .opportunity-card {
            padding: 30px 20px;
        }
        .stat-number {
            font-size: 36px;
        }
    }
</style>

<!-- Hero Section -->
<section class="investor-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1>Invest in the Future of Pool Technology</h1>
                <p class="subtitle">Join Hexagon Fiberglass Pools in revolutionizing the $15 billion pool services industry with advanced fiberglass technology and innovative pool solutions across Texas and beyond.</p>
                <div class="hero-stats d-flex flex-wrap">
                    <div class="me-4 mb-3">
                        <strong style="font-size: 24px;">25+ Years</strong><br>
                        <span style="opacity: 0.8;">Warranty Protection</span>
                    </div>
                    <div class="me-4 mb-3">
                        <strong style="font-size: 24px;">98%</strong><br>
                        <span style="opacity: 0.8;">Customer Satisfaction</span>
                    </div>
                    <div class="me-4 mb-3">
                        <strong style="font-size: 24px;">10.6M</strong><br>
                        <span style="opacity: 0.8;">US Pool Owners</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Investment Opportunities -->
<section class="investor-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center mb-5">
                <h2 style="color: #02154e; font-size: 42px; font-weight: 700; margin-bottom: 20px;">Investment Opportunities</h2>
                <p style="font-size: 18px; color: #666;">Partner with us to transform the pool industry with cutting-edge fiberglass technology</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="opportunity-card">
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Franchise Opportunities</h3>
                    <p>Establish your own Hexagon Fiberglass Pools franchise specializing in fiberglass pool conversions and resurfacing. Proven business model with industry-leading technology.</p>
                    <ul style="color: #666; margin-top: 20px;">
                        <li>Exclusive fiberglass technology licensing</li>
                        <li>Protected territory rights</li>
                        <li>Comprehensive technical training</li>
                        <li>25-year warranty backing</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="opportunity-card">
                    <div class="icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Strategic Partnerships</h3>
                    <p>Join forces with us to expand our pool services portfolio. Ideal for pool builders, contractors, real estate developers, and property management companies.</p>
                    <ul style="color: #666; margin-top: 20px;">
                        <li>Preferred contractor programs</li>
                        <li>Volume pricing agreements</li>
                        <li>Co-marketing opportunities</li>
                        <li>Technical support & training</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="opportunity-card">
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h3>Investment Capital</h3>
                    <p>Provide growth capital to fuel our expansion of fiberglass pool technology across North America. Multiple investment levels for qualified investors.</p>
                    <ul style="color: #666; margin-top: 20px;">
                        <li>High-growth pool services sector</li>
                        <li>Proprietary technology advantage</li>
                        <li>Recurring revenue model</li>
                        <li>Experienced management team</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Growth Statistics -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center mb-5">
                <h2 style="color: #02154e; font-size: 36px; font-weight: 700; margin-bottom: 20px;">Pool Industry Market Opportunity</h2>
                <p style="font-size: 18px; color: #666;">The pool services industry continues to experience explosive growth</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">$15B</span>
                    <div class="stat-label">US Pool Services Market</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">7.3%</span>
                    <div class="stat-label">Annual Growth Rate</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">1.2M</span>
                    <div class="stat-label">Texas Pool Owners</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">70%</span>
                    <div class="stat-label">Need Resurfacing</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Growth Timeline -->
<section class="growth-timeline">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 style="color: white; font-size: 36px; font-weight: 700; margin-bottom: 40px;">Our Growth Story</h2>

                <div class="timeline-item">
                    <div class="timeline-year">Foundation</div>
                    <div class="timeline-content">
                        <h4>Technology Development</h4>
                        <p>Pioneered advanced fiberglass pool resurfacing technology with 25+ year durability, revolutionizing traditional pool renovation methods.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-year">Growth Phase</div>
                    <div class="timeline-content">
                        <h4>Service Expansion</h4>
                        <p>Expanded services to include complete pool conversions, remodeling, and structural repairs using proprietary fiberglass systems.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-year">2025</div>
                    <div class="timeline-content">
                        <h4>Investment & Scale</h4>
                        <p>Seeking strategic partners and investors to scale our proven technology across Texas and neighboring states.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-year">2026+</div>
                    <div class="timeline-content">
                        <h4>National Expansion</h4>
                        <p>Planned expansion into major US markets through franchise network and strategic partnerships with pool industry leaders.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div style="background: rgba(255,255,255,0.1); padding: 40px; border-radius: 12px; margin-top: 40px;">
                    <h3 style="color: white; margin-bottom: 20px;">Why Invest in Pool Services?</h3>
                    <ul style="color: white; line-height: 2;">
                        <li><strong>Recession-Resistant:</strong> Pool maintenance is essential, not optional</li>
                        <li><strong>Growing Market:</strong> 100,000+ new pools built annually in the US</li>
                        <li><strong>High Margins:</strong> 40-60% gross margins on resurfacing projects</li>
                        <li><strong>Recurring Revenue:</strong> Maintenance contracts provide stable income</li>
                        <li><strong>Technology Advantage:</strong> Our fiberglass system outlasts traditional methods 3:1</li>
                        <li><strong>Climate Tailwind:</strong> Warmer temperatures extending pool seasons nationwide</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Investment Inquiry Form -->
<section class="investor-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="inquiry-form">
                    <h3>Request Investment Information</h3>
                    <p style="color: #666; margin-bottom: 30px;">Interested in learning more about pool industry investment opportunities? Fill out the form below and our team will contact you with detailed information.</p>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('investor.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="investor_inquiry">
                        <input type="hidden" name="source" value="investor_relations_page">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company">Company/Organization</label>
                                    <input type="text" id="company" name="company" value="{{ old('company') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="investment_interest">Investment Interest *</label>
                            <select id="investment_interest" name="investment_interest" required>
                                <option value="">Select your area of interest</option>
                                <option value="franchise" {{ old('investment_interest') == 'franchise' ? 'selected' : '' }}>Pool Service Franchise</option>
                                <option value="partnership" {{ old('investment_interest') == 'partnership' ? 'selected' : '' }}>Strategic Partnership</option>
                                <option value="capital_investment" {{ old('investment_interest') == 'capital_investment' ? 'selected' : '' }}>Capital Investment</option>
                                <option value="technology_licensing" {{ old('investment_interest') == 'technology_licensing' ? 'selected' : '' }}>Technology Licensing</option>
                                <option value="general_inquiry" {{ old('investment_interest') == 'general_inquiry' ? 'selected' : '' }}>General Inquiry</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="investment_amount">Investment Amount Range</label>
                            <select id="investment_amount" name="investment_amount">
                                <option value="">Select investment range (optional)</option>
                                <option value="under_100k" {{ old('investment_amount') == 'under_100k' ? 'selected' : '' }}>Under $100,000</option>
                                <option value="100k_250k" {{ old('investment_amount') == '100k_250k' ? 'selected' : '' }}>$100,000 - $250,000</option>
                                <option value="250k_500k" {{ old('investment_amount') == '250k_500k' ? 'selected' : '' }}>$250,000 - $500,000</option>
                                <option value="500k_1m" {{ old('investment_amount') == '500k_1m' ? 'selected' : '' }}>$500,000 - $1,000,000</option>
                                <option value="over_1m" {{ old('investment_amount') == 'over_1m' ? 'selected' : '' }}>Over $1,000,000</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">Tell us about your investment goals and pool industry experience</label>
                            <textarea id="message" name="message" rows="5" placeholder="Please describe your investment experience, interest in the pool industry, and any specific questions about our technology and opportunities...">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane me-2"></i>Request Investment Information
                        </button>
                    </form>

                    <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; font-size: 14px; color: #666;">
                        <strong>Disclaimer:</strong> All investment opportunities are subject to qualification and availability. Past performance does not guarantee future results. Please consult with your financial advisor before making any investment decisions. Hexagon Fiberglass Pools is not offering securities for sale at this time.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection