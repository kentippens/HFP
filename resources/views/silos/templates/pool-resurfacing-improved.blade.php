@extends('layouts.app')

@section('title', 'Pool Resurfacing Dallas TX | 25-Year Warranty | Save $22,500')
@section('meta_description', 'Pool resurfacing with exclusive Fibre Tech 25-year warranty. Transform any pool to fiberglass in 5-7 days. No excavation. North & Central Texas. Free quote.')
@section('meta_robots', $silo->meta_robots ?? 'index, follow')

@if($silo->canonical_url)
    @section('canonical_url', $silo->canonical_url)
@endif

@section('json_ld')
{!! $silo->all_schema ?? '' !!}
@endsection

@section('content')
<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ asset('images/home1/hero-image-v.jpg') }}" style="background-image: url('{{ asset('images/home1/hero-image-v.jpg') }}');">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>Pool Resurfacing</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>Pool Resurfacing</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Pool Resurfacing Main Content Start -->
<section class="pool-resurfacing-section pt-5 pb-5" style="overflow: visible !important;">
    <div class="container">
        <!-- Hero Section -->
        <div class="intro-section mb-5">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-3">Pool Resurfacing with 25-Year Warranty</h1>
                    <p class="subtitle mb-4">North & Central Texas' Permanent Solution</p>
                    <p class="lead"><strong>Stop the endless cycle of replastering.</strong> One-time pool resurfacing with exclusive Fibre Tech™ technology saves Dallas-Fort Worth homeowners $22,500 over 20 years.</p>

                    <!-- Quick Benefits Bar -->
                    <div class="quick-benefits mt-4">
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <div class="benefit-card">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>25-Year Warranty</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="benefit-card">
                                    <i class="fas fa-calendar-check"></i>
                                    <span>5-7 Day Install</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="benefit-card">
                                    <i class="fas fa-dollar-sign"></i>
                                    <span>Save $22,500</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="benefit-card">
                                    <i class="fas fa-ban"></i>
                                    <span>No Excavation</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jump Links Navigation -->
        <div class="jump-links mb-4">
            <div class="jump-links-wrapper">
                <a href="#cost-analysis" class="jump-link">Cost Analysis</a>
                <a href="#resurfacing-types" class="jump-link">Types & Options</a>
                <a href="#our-process" class="jump-link">Our Process</a>
                <a href="#service-areas" class="jump-link">Service Areas</a>
                <a href="#faq" class="jump-link">FAQ</a>
                <a href="#get-quote" class="jump-link btn-primary">Get Free Quote</a>
            </div>
        </div>

        <!-- Main Content and Sidebar -->
        <div class="row">
            <!-- Main Body Content -->
            <div class="col-lg-8">
                <div class="main-content">
                    <!-- Problem/Solution Section -->
                    <div class="content-section">
                        <h2>The Pool Resurfacing Challenge in Texas</h2>

                        <div class="problem-solution-grid">
                            <div class="problem-card">
                                <h3><i class="fas fa-times-circle"></i> The Problem</h3>
                                <ul>
                                    <li>Replaster every 7-10 years</li>
                                    <li>$8,000-$15,000 per resurface</li>
                                    <li>3 weeks of downtime</li>
                                    <li>Rough, stained surfaces</li>
                                </ul>
                            </div>
                            <div class="solution-card">
                                <h3><i class="fas fa-check-circle"></i> Our Solution</h3>
                                <ul>
                                    <li>One-time permanent fix</li>
                                    <li>25-year transferable warranty</li>
                                    <li>5-7 days completion</li>
                                    <li>Smooth forever finish</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr class="section-divider">

                    <!-- Cost Analysis Section -->
                    <div class="content-section" id="cost-analysis">
                        <h2>Pool Resurfacing Cost Analysis</h2>

                        <!-- Cost Comparison Cards for Mobile -->
                        <div class="cost-cards d-lg-none">
                            <div class="cost-card">
                                <h4>Plaster</h4>
                                <div class="price">$6,000-$8,000</div>
                                <div class="lifespan">Lasts 5-7 years</div>
                                <div class="total-cost">20-yr cost: <span class="text-danger">$32,000</span></div>
                            </div>
                            <div class="cost-card">
                                <h4>Pebble</h4>
                                <div class="price">$10,000-$15,000</div>
                                <div class="lifespan">Lasts 10-12 years</div>
                                <div class="total-cost">20-yr cost: <span class="text-danger">$25,000</span></div>
                            </div>
                            <div class="cost-card featured">
                                <div class="badge">BEST VALUE</div>
                                <h4>Hexagon Fiberglass</h4>
                                <div class="price">Call for Quote</div>
                                <div class="lifespan">25+ Year Warranty</div>
                                <div class="total-cost">20-yr cost: <span class="text-success">One-Time Investment</span></div>
                                <a href="#get-quote" class="btn btn-primary btn-sm mt-2">Get Quote</a>
                            </div>
                        </div>

                        <!-- Desktop Table -->
                        <div class="table-responsive d-none d-lg-block mb-4">
                            <table class="table table-hover comparison-table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Initial Cost</th>
                                        <th>Lifespan</th>
                                        <th>20-Year Cost</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plaster</td>
                                        <td>$6,000-$8,000</td>
                                        <td>5-7 years</td>
                                        <td class="text-danger">$32,000</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Pebble</td>
                                        <td>$10,000-$15,000</td>
                                        <td>10-12 years</td>
                                        <td class="text-danger">$25,000</td>
                                        <td>-</td>
                                    </tr>
                                    <tr class="table-featured">
                                        <td><strong>Hexagon Fiberglass</strong></td>
                                        <td>Call for Quote</td>
                                        <td><strong>25+ Year Warranty</strong></td>
                                        <td class="text-success"><strong>One-Time</strong></td>
                                        <td><a href="#get-quote" class="btn btn-primary btn-sm">Get Quote</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Savings Calculator Visual -->
                        <div class="savings-visual">
                            <h4>Your 20-Year Savings</h4>
                            <div class="savings-bar">
                                <div class="traditional-cost">
                                    <span class="label">Traditional</span>
                                    <span class="amount">$48,000</span>
                                </div>
                                <div class="hexagon-cost">
                                    <span class="label">Hexagon</span>
                                    <span class="amount">$19,000</span>
                                </div>
                                <div class="savings-amount">
                                    <span>You Save</span>
                                    <strong>$29,000</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="section-divider">

                    <!-- Process Section -->
                    <div class="content-section" id="our-process">
                        <h2>Our 5-7 Day Process</h2>

                        <div class="process-timeline-visual">
                            <div class="timeline-item">
                                <div class="day">Day 1</div>
                                <div class="content">
                                    <h4>Assessment</h4>
                                    <p>Inspection & protection</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="day">Day 2</div>
                                <div class="content">
                                    <h4>Preparation</h4>
                                    <p>Surface prep, no demolition</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="day">Days 3-4</div>
                                <div class="content">
                                    <h4>Application</h4>
                                    <p>Fibre Tech™ installation</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="day">Day 5</div>
                                <div class="content">
                                    <h4>Finishing</h4>
                                    <p>Polish & perfect</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="day">Days 6-7</div>
                                <div class="content">
                                    <h4>Completion</h4>
                                    <p>Final inspection & fill</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="section-divider">

                    <!-- Service Areas -->
                    <div class="content-section" id="service-areas">
                        <h2>Service Areas</h2>

                        <div class="service-area-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#dallas">Dallas Area</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#fortworth">Fort Worth Area</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#central">Central Texas</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="dallas">
                                    <div class="cities-grid">
                                        <span>Dallas</span>
                                        <span>Plano</span>
                                        <span>Richardson</span>
                                        <span>Garland</span>
                                        <span>Irving</span>
                                        <span>McKinney</span>
                                        <span>Frisco</span>
                                        <span>Allen</span>
                                    </div>
                                </div>
                                <div class="tab-pane" id="fortworth">
                                    <div class="cities-grid">
                                        <span>Fort Worth</span>
                                        <span>Arlington</span>
                                        <span>Bedford</span>
                                        <span>Euless</span>
                                        <span>Grapevine</span>
                                        <span>Southlake</span>
                                        <span>Keller</span>
                                        <span>Colleyville</span>
                                    </div>
                                </div>
                                <div class="tab-pane" id="central">
                                    <div class="cities-grid">
                                        <span>Austin</span>
                                        <span>Round Rock</span>
                                        <span>Georgetown</span>
                                        <span>Cedar Park</span>
                                        <span>Waco</span>
                                        <span>Temple</span>
                                        <span>Killeen</span>
                                        <span>Bryan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="section-divider">

                    <!-- FAQ Section -->
                    <div class="content-section" id="faq">
                        <h2>Frequently Asked Questions</h2>

                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        How often do pools need resurfacing?
                                    </button>
                                </h3>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Traditional surfaces need resurfacing every 5-15 years. Plaster lasts 5-7 years, pebble 10-15 years. Our fiberglass resurfacing comes with a 25-year warranty and is designed to last decades beyond that.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        How long does pool resurfacing take?
                                    </button>
                                </h3>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Traditional resurfacing takes 2-3 weeks. Our conversion completes in just 5-7 days total, with less mess and no excavation.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Is pool resurfacing worth it?
                                    </button>
                                </h3>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Traditional resurfacing is necessary maintenance you'll repeat every 7-10 years. Fiberglass resurfacing may cost more initially, but eliminates future resurfacing, saving $22,500+ over 20 years.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                        What warranty comes with pool resurfacing?
                                    </button>
                                </h3>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Traditional resurfacing typically includes 1-3 year warranties. We include an exclusive 25-year manufacturer warranty, the longest in the industry.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($silo->content)
                        <!-- Dynamic content from database -->
                        {!! $silo->content !!}
                    @endif
                </div>
            </div>

            <!-- Sticky Sidebar -->
            <div class="col-lg-4" id="get-quote">
                <div class="sidebar-sticky-wrapper" style="height: 100%;">
                    <div class="sticky-sidebar" style="position: sticky; position: -webkit-sticky; top: 100px; z-index: 100;">
                        <!-- Contact Form Widget -->
                        <div class="appoinment-form sidebar-form" data-background="{{ asset('images/home2/form-bg.jpg') }}">
                            <div class="appoinment-title">
                                <h4 style="color: #ffffff;">Get Your Free Quote</h4>
                                <p style="color: #ffffff; font-size: 0.9rem; margin: 0;">Takes 60 seconds • No obligation</p>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST" id="sidebar-contact-form">
                                @csrf
                                <input type="hidden" name="type" value="pool_resurfacing_quote">
                                <input type="text" name="name" placeholder="Your Name" required>
                                <input type="tel" name="phone" placeholder="Phone Number*" required maxlength="20">
                                <input type="email" name="address" placeholder="Email Address">
                                <select name="service" required>
                                    <option value="request-callback">Request A Callback</option>
                                    <option value="pool-resurfacing-conversion">Pool Resurfacing & Conversion</option>
                                    <option value="pool-repair">Pool Repair</option>
                                    <option value="pool-remodeling">Pool Remodeling</option>
                                </select>
                                <textarea name="message" placeholder="Pool size, current surface type, any issues..." rows="4"></textarea>

                                @include('components.recaptcha-button', [
                                    'formId' => 'sidebar-contact-form',
                                    'buttonText' => 'Get Free Quote',
                                    'buttonClass' => 'bixol-primary-btn',
                                    'buttonIcon' => 'fa-arrow-right'
                                ])
                            </form>
                        </div>

                        <!-- Trust Indicators -->
                        <div class="trust-indicators mt-4">
                            <div class="trust-item">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <strong>Prefer to Call?</strong>
                                    <a href="tel:972-789-2983">972-789-2983</a>
                                </div>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <strong>Response Time</strong>
                                    <span>Within 2 hours</span>
                                </div>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-star"></i>
                                <div>
                                    <strong>5.0 Rating</strong>
                                    <span>173+ Projects</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mobile CTA Button -->
<div class="mobile-cta-button d-lg-none">
    <a href="#get-quote" class="btn btn-primary btn-lg">
        <i class="fas fa-calculator"></i> Get Free Quote
    </a>
</div>

<!-- Improved Styles -->
<style>
/* Base Typography Improvements */
body {
    font-size: 16px;
    line-height: 1.6;
    color: #333;
}

/* Hero Section */
.intro-section h1 {
    color: #333;
    font-weight: 700;
    font-size: 1.75rem;
    line-height: 1.2;
    margin-bottom: 0.5rem;
}

.intro-section .subtitle {
    color: #666;
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.intro-section .lead {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.5;
}

/* Quick Benefits Bar */
.quick-benefits {
    margin-top: 2rem;
}

.benefit-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #dee2e6;
    transition: transform 0.3s ease;
}

.benefit-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.benefit-card i {
    font-size: 1.5rem;
    color: #2196f3;
    display: block;
    margin-bottom: 8px;
}

.benefit-card span {
    font-size: 0.9rem;
    font-weight: 600;
    color: #333;
}

/* Jump Links Navigation */
.jump-links {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    position: sticky;
    top: 0;
    z-index: 50;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.jump-links-wrapper {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    white-space: nowrap;
    scrollbar-width: thin;
}

.jump-link {
    padding: 8px 16px;
    background: white;
    border-radius: 5px;
    color: #333;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.jump-link:hover {
    background: #2196f3;
    color: white;
    border-color: #2196f3;
}

.jump-link.btn-primary {
    background: #ff6b35;
    color: white;
    border-color: #ff6b35;
}

/* Content Sections */
.content-section {
    margin-bottom: 3rem;
}

.content-section h2 {
    color: #333;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #2196f3;
}

.content-section h3 {
    color: #444;
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

/* Section Divider */
.section-divider {
    margin: 3rem 0;
    border: none;
    height: 1px;
    background: linear-gradient(to right, transparent, #dee2e6, transparent);
}

/* Problem/Solution Grid */
.problem-solution-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin: 2rem 0;
}

.problem-card, .solution-card {
    padding: 20px;
    border-radius: 10px;
    border: 2px solid;
}

.problem-card {
    background: #fff5f5;
    border-color: #dc3545;
}

.solution-card {
    background: #f0f9ff;
    border-color: #28a745;
}

.problem-card h3 {
    color: #dc3545;
    font-size: 1.1rem;
    margin-bottom: 15px;
}

.solution-card h3 {
    color: #28a745;
    font-size: 1.1rem;
    margin-bottom: 15px;
}

.problem-card ul, .solution-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.problem-card li, .solution-card li {
    padding: 5px 0;
    font-size: 0.95rem;
}

/* Cost Cards (Mobile) */
.cost-cards {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin: 2rem 0;
}

.cost-card {
    background: white;
    border: 2px solid #dee2e6;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
}

.cost-card.featured {
    border-color: #28a745;
    background: linear-gradient(135deg, #f0f9ff 0%, #e6f4ea 100%);
    position: relative;
}

.cost-card .badge {
    position: absolute;
    top: -10px;
    right: 20px;
    background: #28a745;
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.cost-card h4 {
    font-size: 1.1rem;
    margin-bottom: 15px;
    color: #333;
}

.cost-card .price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2196f3;
    margin-bottom: 10px;
}

.cost-card .lifespan {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 10px;
}

.cost-card .total-cost {
    font-size: 0.95rem;
    padding-top: 10px;
    border-top: 1px solid #dee2e6;
}

/* Comparison Table */
.comparison-table {
    background: white;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
}

.comparison-table thead th {
    background: #f8f9fa;
    font-weight: 600;
    font-size: 0.95rem;
    border-bottom: 2px solid #dee2e6;
}

.comparison-table .table-featured {
    background: linear-gradient(135deg, #f0f9ff 0%, #e6f4ea 100%);
    font-weight: 600;
}

/* Savings Visual */
.savings-visual {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    padding: 25px;
    border-radius: 10px;
    margin: 2rem 0;
}

.savings-visual h4 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.savings-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
}

.traditional-cost, .hexagon-cost, .savings-amount {
    text-align: center;
    flex: 1;
}

.savings-bar .label {
    display: block;
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 5px;
}

.savings-bar .amount {
    display: block;
    font-size: 1.25rem;
    font-weight: 700;
}

.traditional-cost .amount {
    color: #dc3545;
}

.hexagon-cost .amount {
    color: #333;
}

.savings-amount {
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.savings-amount strong {
    color: #28a745;
    font-size: 1.5rem;
}

/* Process Timeline Visual */
.process-timeline-visual {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin: 2rem 0;
    padding: 20px 0;
}

.process-timeline-visual::before {
    content: '';
    position: absolute;
    top: 35px;
    left: 50px;
    right: 50px;
    height: 2px;
    background: linear-gradient(to right, #2196f3, #28a745);
}

.timeline-item {
    text-align: center;
    position: relative;
    flex: 1;
}

.timeline-item .day {
    background: #2196f3;
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-weight: 600;
    font-size: 0.9rem;
    position: relative;
    z-index: 1;
}

.timeline-item:last-child .day {
    background: #28a745;
}

.timeline-item h4 {
    font-size: 0.95rem;
    margin-bottom: 5px;
    color: #333;
}

.timeline-item p {
    font-size: 0.85rem;
    color: #666;
    margin: 0;
}

/* Service Area Tabs */
.service-area-tabs {
    margin: 2rem 0;
}

.service-area-tabs .nav-tabs {
    border-bottom: 2px solid #dee2e6;
}

.service-area-tabs .nav-link {
    color: #666;
    border: none;
    padding: 10px 20px;
    font-weight: 500;
}

.service-area-tabs .nav-link.active {
    color: #2196f3;
    background: none;
    border-bottom: 3px solid #2196f3;
}

.cities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 10px;
    padding: 20px 0;
}

.cities-grid span {
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 5px;
    text-align: center;
    font-size: 0.9rem;
}

/* FAQ Accordion */
.accordion-item {
    border: 1px solid #dee2e6;
    margin-bottom: 10px;
    border-radius: 8px;
    overflow: hidden;
}

.accordion-button {
    font-weight: 600;
    font-size: 1rem;
    color: #333;
    background: #f8f9fa;
}

.accordion-button:not(.collapsed) {
    background: #e3f2fd;
    color: #2196f3;
}

.accordion-body {
    padding: 20px;
    font-size: 0.95rem;
    line-height: 1.6;
}

/* Sidebar Improvements */
.sidebar-form {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.sidebar-form input,
.sidebar-form select,
.sidebar-form textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    background: white;
}

.sidebar-form input:focus,
.sidebar-form select:focus,
.sidebar-form textarea:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
}

/* Trust Indicators */
.trust-indicators {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.trust-item:last-child {
    margin-bottom: 0;
}

.trust-item i {
    font-size: 1.5rem;
    color: #2196f3;
    width: 30px;
}

.trust-item strong {
    display: block;
    font-size: 0.9rem;
    color: #333;
}

.trust-item span,
.trust-item a {
    font-size: 0.95rem;
    color: #666;
}

.trust-item a {
    color: #2196f3;
    text-decoration: none;
    font-weight: 600;
}

/* Mobile CTA Button */
.mobile-cta-button {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
}

.mobile-cta-button .btn {
    padding: 15px 30px;
    font-size: 1rem;
    font-weight: 600;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

/* Responsive Adjustments */
@media (max-width: 991px) {
    .problem-solution-grid {
        grid-template-columns: 1fr;
    }

    .process-timeline-visual {
        flex-direction: column;
        align-items: center;
    }

    .process-timeline-visual::before {
        display: none;
    }

    .timeline-item {
        margin-bottom: 20px;
    }

    .sticky-sidebar {
        position: relative !important;
        top: auto !important;
    }
}

@media (max-width: 767px) {
    .intro-section h1 {
        font-size: 1.4rem;
    }

    .jump-links {
        position: relative;
        top: auto;
    }

    .savings-bar {
        flex-direction: column;
        gap: 20px;
    }

    .cities-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Accessibility Improvements */
.btn:focus,
.jump-link:focus,
.accordion-button:focus {
    outline: 3px solid #2196f3;
    outline-offset: 2px;
}

/* High Contrast Mode Support */
@media (prefers-contrast: high) {
    .content-section h2 {
        border-bottom-width: 3px;
    }

    .cost-card,
    .problem-card,
    .solution-card {
        border-width: 3px;
    }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    * {
        animation: none !important;
        transition: none !important;
    }
}

/* Print Styles */
@media print {
    .jump-links,
    .mobile-cta-button,
    .sidebar-sticky-wrapper {
        display: none !important;
    }

    .col-lg-8 {
        width: 100% !important;
        max-width: 100% !important;
    }
}
</style>

<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for jump links
    document.querySelectorAll('.jump-link').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });

    // Highlight active section in jump links
    const sections = document.querySelectorAll('.content-section[id]');
    const jumpLinks = document.querySelectorAll('.jump-link');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (scrollY >= (sectionTop - 200)) {
                current = section.getAttribute('id');
            }
        });

        jumpLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });

    // Form validation feedback
    const form = document.getElementById('sidebar-contact-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('input[required], select[required]');
            inputs.forEach(input => {
                if (!input.value) {
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
        });
    }

    // Lazy load images
    if ('IntersectionObserver' in window) {
        const images = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });
        images.forEach(img => imageObserver.observe(img));
    }
});
</script>
@endsection