@extends('layouts.app')

@section('title', 'Investor Relations - Growth Opportunities')
@section('meta_description', 'Explore investment opportunities with Hexagon Service Solutions. Join us in expanding professional home services including cleaning, pool maintenance, and home improvement across the DFW area.')
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
                <h1>Invest in the Future of Clean</h1>
                <p class="subtitle">Join Hexagon Service Solutions in revolutionizing professional home services including cleaning, pool maintenance, and home improvement across the DFW metroplex and beyond.</p>
                <div class="hero-stats d-flex flex-wrap">
                    <div class="me-4 mb-3">
                        <strong style="font-size: 24px;">2023</strong><br>
                        <span style="opacity: 0.8;">Founded</span>
                    </div>
                    <div class="me-4 mb-3">
                        <strong style="font-size: 24px;">100%</strong><br>
                        <span style="opacity: 0.8;">Satisfaction Rate</span>
                    </div>
                    <div class="me-4 mb-3">
                        <strong style="font-size: 24px;">DFW+</strong><br>
                        <span style="opacity: 0.8;">Service Area</span>
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
                <p style="font-size: 18px; color: #666;">Partner with us to expand professional home services in high-growth markets</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4">
                <div class="opportunity-card">
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Franchise Opportunities</h3>
                    <p>Establish your own Hexagon Service Solutions franchise offering our full suite of home services. Proven business model across multiple revenue streams with comprehensive training and ongoing support.</p>
                    <ul style="color: #666; margin-top: 20px;">
                        <li>Multiple service lines: cleaning, pool maintenance, home improvement</li>
                        <li>Protected territory rights</li>
                        <li>Complete operational training for all services</li>
                        <li>Marketing support and materials</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="opportunity-card">
                    <div class="icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Strategic Partnerships</h3>
                    <p>Join forces with us to expand our diverse home services portfolio. Ideal for pool companies, home improvement contractors, property managers, and real estate professionals.</p>
                    <ul style="color: #666; margin-top: 20px;">
                        <li>Cross-referral programs across all service lines</li>
                        <li>Joint marketing for bundled services</li>
                        <li>Shared equipment and resource opportunities</li>
                        <li>Revenue sharing models</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="opportunity-card">
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h3>Investment Capital</h3>
                    <p>Provide growth capital to fuel our multi-service expansion across Texas and beyond. Multiple investment levels available for qualified investors.</p>
                    <ul style="color: #666; margin-top: 20px;">
                        <li>Competitive returns across 5+ service categories</li>
                        <li>Diversified portfolio: cleaning, pool, fencing, gutters, seasonal</li>
                        <li>Year-round revenue streams</li>
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
                <h2 style="color: #02154e; font-size: 36px; font-weight: 700; margin-bottom: 20px;">Market Opportunity</h2>
                <p style="font-size: 18px; color: #666;">The professional cleaning industry continues to experience strong growth</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">$330B</span>
                    <div class="stat-label">Global Cleaning Services Market</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">5.5%</span>
                    <div class="stat-label">Annual Growth Rate</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">7.8M</span>
                    <div class="stat-label">DFW Population</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">∞</span>
                    <div class="stat-label">Growth Potential</div>
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
                    <div class="timeline-year">2023</div>
                    <div class="timeline-content">
                        <h4>Company Founded</h4>
                        <p>Hexagon Service Solutions established with a vision to transform professional cleaning services in the DFW area.</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2024</div>
                    <div class="timeline-content">
                        <h4>Service Expansion</h4>
                        <p>Expanded beyond traditional cleaning to include pool maintenance, vinyl fence installation, gutter services, and seasonal holiday lighting installation.</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2025</div>
                    <div class="timeline-content">
                        <h4>Investment Phase</h4>
                        <p>Seeking strategic partners and investors to accelerate growth and expand our market presence across Texas.</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2026+</div>
                    <div class="timeline-content">
                        <h4>Regional Expansion</h4>
                        <p>Planned expansion into major Texas markets and surrounding states through franchise and partnership opportunities.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div style="background: rgba(255,255,255,0.1); padding: 40px; border-radius: 12px; margin-top: 40px;">
                    <h3 style="color: white; margin-bottom: 20px;">Why Invest with Us?</h3>
                    <ul style="color: white; line-height: 2;">
                        <li><strong>Proven Business Model:</strong> Established processes across 5 service categories</li>
                        <li><strong>Diversified Revenue:</strong> House cleaning, pool maintenance, fence installation, gutter services, and seasonal lighting</li>
                        <li><strong>Year-Round Income:</strong> Balanced portfolio of recurring and seasonal services</li>
                        <li><strong>Strong Market Demand:</strong> Essential home services with high customer retention</li>
                        <li><strong>Scalable Operations:</strong> Systems designed for rapid multi-service expansion</li>
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
                    <p style="color: #666; margin-bottom: 30px;">Interested in learning more about investment opportunities? Fill out the form below and our team will contact you with detailed information.</p>
                    
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
                                <option value="franchise" {{ old('investment_interest') == 'franchise' ? 'selected' : '' }}>Franchise Opportunities</option>
                                <option value="partnership" {{ old('investment_interest') == 'partnership' ? 'selected' : '' }}>Strategic Partnership</option>
                                <option value="capital_investment" {{ old('investment_interest') == 'capital_investment' ? 'selected' : '' }}>Capital Investment</option>
                                <option value="general_inquiry" {{ old('investment_interest') == 'general_inquiry' ? 'selected' : '' }}>General Inquiry</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="investment_amount">Investment Amount Range</label>
                            <select id="investment_amount" name="investment_amount">
                                <option value="">Select investment range (optional)</option>
                                <option value="under_50k" {{ old('investment_amount') == 'under_50k' ? 'selected' : '' }}>Under $50,000</option>
                                <option value="50k_100k" {{ old('investment_amount') == '50k_100k' ? 'selected' : '' }}>$50,000 - $100,000</option>
                                <option value="100k_250k" {{ old('investment_amount') == '100k_250k' ? 'selected' : '' }}>$100,000 - $250,000</option>
                                <option value="250k_500k" {{ old('investment_amount') == '250k_500k' ? 'selected' : '' }}>$250,000 - $500,000</option>
                                <option value="over_500k" {{ old('investment_amount') == 'over_500k' ? 'selected' : '' }}>Over $500,000</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Tell us about your investment goals and interests</label>
                            <textarea id="message" name="message" rows="5" placeholder="Please describe your investment experience, goals, and any specific questions you have about our opportunities...">{{ old('message') }}</textarea>
                        </div>
                        
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane me-2"></i>Request Information
                        </button>
                    </form>
                    
                    <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; font-size: 14px; color: #666;">
                        <strong>Disclaimer:</strong> All investment opportunities are subject to qualification and availability. Past performance does not guarantee future results. Please consult with your financial advisor before making any investment decisions.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection