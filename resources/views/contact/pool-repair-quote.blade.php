@extends('layouts.app')

@section('title', 'Get a Pool Repair Quote - ' . config('app.name'))
@section('meta_description', 'Get a free quote for pool resurfacing and repair services. Expert fiberglass and plaster resurfacing in Texas.')

@section('content')

<!-- Hero Section -->
<section class="quote-hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title">Get a Quote From Texas' Premier Pool Repair Experts</h1>
                    <p class="hero-description">
                        Transform your pool with our expert resurfacing services. From fiberglass coatings to crack repairs, we bring decades of experience to every project. Get your free, no-obligation quote today and discover why homeowners across Texas trust us with their pool renovations.
                    </p>
                    
                    <div class="trust-indicators">
                        <div class="indicator-item">
                            <span class="indicator-icon">✓</span>
                            <span>Licensed & Insured</span>
                        </div>
                        <div class="indicator-item">
                            <span class="indicator-icon">✓</span>
                            <span>Free Estimates</span>
                        </div>
                        <div class="indicator-item">
                            <span class="indicator-icon">✓</span>
                            <span>Lifetime Warranty</span>
                        </div>
                    </div>

                    <!-- Review Stars -->
                    <div class="review-section">
                        <div class="stars">
                            @for($i = 0; $i < 5; $i++)
                                <span class="star">★</span>
                            @endfor
                        </div>
                        <p class="review-text">
                            <strong>Joe Williams</strong><br>
                            <em>"Exceptional service from start to finish. The team was professional, punctual, and the results exceeded our expectations. Our pool looks brand new!"</em>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="quote-form-wrapper">
                    <div class="form-card">
                        <h2 class="form-title">Contact Us</h2>
                        <p class="form-subtitle">Fill out the form below and we'll contact you within 24 hours</p>
                        
                        <!-- Form placeholder - you mentioned you'll create the form separately -->
                        <div class="form-placeholder">
                            <p class="text-center text-muted py-5">
                                [Quote Form Will Be Added Here]
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="statistics-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-number">950+</div>
                    <div class="stat-label">Pools Resurfaced</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-number">32</div>
                    <div class="stat-label">Years Experience</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-number">3,800</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-number">80+</div>
                    <div class="stat-label">5-Star Reviews</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Areas Section -->
<section class="service-areas-section">
    <div class="container">
        <h2 class="section-title text-center">Proudly Serving Texas from Our Dallas Location</h2>
        <p class="text-center lead mb-5" style="color: #6c757d; font-size: 1.1rem;">
            Based in Dallas, we provide professional pool resurfacing, repair, and remodeling services throughout the great state of Texas. From the Panhandle to the Gulf Coast, our team brings expert craftsmanship and decades of experience to every corner of the Lone Star State.
        </p>

        <div class="row mt-5 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="area-card">
                    <div class="area-icon">📍</div>
                    <h4>Dallas Office</h4>
                    <p>Proudly serving all of Texas including Dallas-Fort Worth, Houston, San Antonio, Austin, and everywhere in between</p>
                    <a href="tel:972-789-2983" class="area-phone">(972) 789-2983</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="texas-coverage-info text-center">
                    <h5 style="color: #2c3e50; font-weight: 600; margin-bottom: 20px;">Our Statewide Coverage</h5>
                    <p style="color: #6c757d; max-width: 800px; margin: 0 auto; line-height: 1.8;">
                        No matter where you are in Texas, our expert team is ready to transform your pool. We service residential and commercial properties across all major metropolitan areas including Dallas-Fort Worth, Houston, Austin, San Antonio, El Paso, Corpus Christi, and surrounding communities. Whether you need emergency repairs, complete resurfacing, or custom remodeling, we bring quality service directly to your location.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container text-center">
        <h2>Ready to Transform Your Pool?</h2>
        <p class="lead">Get started with a free quote today</p>
        <a href="#quote-form" class="btn btn-primary btn-lg">Get Free Quote</a>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Hero Section */
.quote-hero-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 600px;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    line-height: 1.2;
}

.hero-description {
    font-size: 1.1rem;
    color: #5a6c7d;
    margin-bottom: 30px;
    line-height: 1.6;
}

.trust-indicators {
    display: flex;
    gap: 30px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.indicator-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.indicator-icon {
    background: #28a745;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: bold;
}

/* Review Section */
.review-section {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-top: 30px;
}

.stars {
    display: flex;
    gap: 5px;
    margin-bottom: 10px;
}

.star {
    color: #ffc107;
    font-size: 24px;
}

.review-text {
    font-size: 0.95rem;
    color: #495057;
    margin: 0;
}

.review-text strong {
    color: #2c3e50;
}

/* Quote Form */
.quote-form-wrapper {
    padding: 20px;
}

.form-card {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.form-title {
    font-size: 2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.form-subtitle {
    color: #6c757d;
    margin-bottom: 30px;
}

/* Statistics Section */
.statistics-section {
    background: #1a3a52;
    padding: 60px 0;
    margin-top: -50px;
    position: relative;
    z-index: 1;
}

.stat-card {
    text-align: center;
    padding: 30px 20px;
    color: white;
}

.stat-number {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.9;
}

/* Service Areas */
.service-areas-section {
    padding: 80px 0;
    background: #f8f9fa;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 50px;
}

.area-card {
    background: white;
    padding: 30px 20px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    height: 100%;
}

.area-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.area-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
}

.area-card h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.area-card p {
    color: #6c757d;
    margin-bottom: 15px;
    font-size: 0.95rem;
}

.area-phone {
    color: #007bff;
    font-weight: 600;
    text-decoration: none;
    font-size: 1.1rem;
}

.area-phone:hover {
    color: #0056b3;
}

/* CTA Section */
.cta-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.cta-section h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
}

.cta-section .lead {
    font-size: 1.25rem;
    margin-bottom: 30px;
    opacity: 0.95;
}

.cta-section .btn {
    padding: 15px 40px;
    font-size: 1.1rem;
    border-radius: 50px;
    background: white;
    color: #667eea;
    border: none;
    transition: all 0.3s ease;
}

.cta-section .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .trust-indicators {
        gap: 15px;
    }
    
    .form-card {
        padding: 25px;
    }
}
</style>
@endpush