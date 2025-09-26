@extends('layouts.app')

@section('title', $seoData->meta_title ?? 'Pool Services in Texas')
@section('meta_description', $seoData->meta_description ?? 'Professional pool resurfacing and remodeling services across Texas.')
@section('meta_robots', $seoData->meta_robots ?? 'index, follow')
@if($seoData && $seoData->canonical_url)
    @section('canonical_url', $seoData->canonical_url)
@endif

@section('json_ld')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "Hexagon Fiberglass Pools - Texas",
    "description": "Professional pool resurfacing, remodeling, and repair services across Texas",
    "url": "{{ url('/texas') }}",
    "telephone": "972-789-2983",
    "email": "pools@hexagonservicesolutions.com",
    "areaServed": {
        "@type": "State",
        "name": "Texas",
        "containsPlace": [
            {"@type": "City", "name": "Dallas"},
            {"@type": "City", "name": "Fort Worth"},
            {"@type": "City", "name": "Austin"},
            {"@type": "City", "name": "Houston"},
            {"@type": "City", "name": "San Antonio"}
        ]
    },
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "603 Munger Ave Suite 100-243A",
        "addressLocality": "Dallas",
        "addressRegion": "TX",
        "postalCode": "75202",
        "addressCountry": "US"
    }
}
</script>
@endsection

@section('content')

<!-- Hero Section with Texas Map Background -->
<section class="texas-hero" style="background: linear-gradient(135deg, #043f88 0%, #0066cc 100%); position: relative; overflow: hidden;">
    <div class="container">
        <div class="row align-items-center min-vh-50 py-5">
            <div class="col-lg-7">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-3">Pool Services in Texas</h1>
                    <p class="lead mb-4">From the Panhandle to the Gulf Coast, Hexagon Fiberglass Pools delivers premium pool resurfacing, remodeling, and repair services across the Lone Star State.</p>
                    <div class="hero-stats d-flex flex-wrap gap-4 mb-4">
                        <div class="stat-item">
                            <h3 class="mb-0" style="color: #ffcc00;">1.2M+</h3>
                            <p class="mb-0 small">Texas Pools</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="mb-0" style="color: #ffcc00;">254</h3>
                            <p class="mb-0 small">Counties Served</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="mb-0" style="color: #ffcc00;">25 Year</h3>
                            <p class="mb-0 small">Warranty</p>
                        </div>
                    </div>
                    <div class="hero-cta d-flex flex-wrap gap-3">
                        <a href="tel:972-789-2983" class="btn btn-warning btn-lg">
                            <i class="fas fa-phone-alt me-2"></i>Call (972) 789-2983
                        </a>
                        <a href="/pool-repair-quote" class="btn btn-outline-light btn-lg">
                            Get Free Quote
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="texas-map-wrapper text-center">
                    <img src="{{ asset('images/flag-of-texas.svg') }}" alt="Texas" style="max-width: 300px; opacity: 0.3;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Bar -->
<section class="trust-bar py-3" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-6 col-md-3">
                <img src="{{ asset('images/homepage-logos/PHTA-Member-Logo.png') }}" alt="Pool & Hot Tub Alliance" style="height: 40px;">
            </div>
            <div class="col-6 col-md-3">
                <p class="mb-0 text-muted"><strong>Licensed & Insured</strong><br>$2M Liability Coverage</p>
            </div>
            <div class="col-6 col-md-3">
                <p class="mb-0 text-muted"><strong>CPO Certified</strong><br>Professional Standards</p>
            </div>
            <div class="col-6 col-md-3">
                <p class="mb-0 text-muted"><strong>Family Owned</strong><br>Texas Business</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="services-overview py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Pool Services We Offer in Texas</h2>
            <p class="lead">Comprehensive solutions for every pool need across the state</p>
        </div>

        <div class="row g-4">
            @foreach($coreServices as $service)
            <div class="col-lg-6">
                <div class="service-card h-100 border rounded-3 p-4 shadow-sm hover-lift">
                    <div class="d-flex align-items-start">
                        <div class="service-icon me-3">
                            <i class="fas fa-swimming-pool text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="h4 mb-2">{{ $service->name }}</h3>
                            <p class="text-muted mb-3">{{ $service->short_description }}</p>
                            <a href="/{{ $service->slug }}" class="btn btn-sm btn-outline-primary">Learn More →</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Additional Services -->
        <div class="mt-5 p-4 bg-light rounded-3">
            <h3 class="mb-3">Specialized Texas Pool Services</h3>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Fiberglass Pool Conversions</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Custom Tile & Coping Installation</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Crack Repair & Structural Fixes</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Pool Floor Mosaic Designs</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Gelcoat Refinishing</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Equipment Upgrades & Automation</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>LED Lighting Installation</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Water Feature Integration</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Texas Climate Challenges -->
<section class="texas-challenges py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-6 fw-bold mb-4">Texas Pools Face Unique Challenges</h2>
                <p class="lead mb-4">Our state's extreme weather conditions demand specialized pool solutions designed for Texas.</p>

                <div class="challenge-list">
                    <div class="challenge-item mb-3">
                        <h4 class="h5"><i class="fas fa-temperature-high text-danger me-2"></i>Extreme Heat (100°F+ Summers)</h4>
                        <p class="text-muted">UV damage and surface deterioration accelerate in Texas heat. Our fiberglass solutions withstand temperatures up to 200°F.</p>
                    </div>

                    <div class="challenge-item mb-3">
                        <h4 class="h5"><i class="fas fa-snowflake text-info me-2"></i>Freeze Events & Temperature Swings</h4>
                        <p class="text-muted">From 110°F to below freezing - Texas pools expand and contract. Our flexible materials prevent cracking.</p>
                    </div>

                    <div class="challenge-item mb-3">
                        <h4 class="h5"><i class="fas fa-layer-group text-warning me-2"></i>Clay Soil Movement</h4>
                        <p class="text-muted">Texas clay expands 30% when wet, contracts when dry. Traditional surfaces crack - ours adapt.</p>
                    </div>

                    <div class="challenge-item mb-3">
                        <h4 class="h5"><i class="fas fa-tint text-primary me-2"></i>Hard Water & Mineral Deposits</h4>
                        <p class="text-muted">High calcium levels in Texas water damage traditional surfaces. Our non-porous finish resists mineral buildup.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="comparison-table">
                    <h3 class="h4 mb-3 text-center">Why Texas Pools Need Better Solutions</h3>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Challenge</th>
                                <th>Traditional Surface</th>
                                <th>Our Solution</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Heat Resistance</strong></td>
                                <td class="text-danger">Deteriorates rapidly</td>
                                <td class="text-success">Engineered for 200°F+</td>
                            </tr>
                            <tr>
                                <td><strong>Freeze Protection</strong></td>
                                <td class="text-danger">Cracks & separates</td>
                                <td class="text-success">Flexible, adapts to changes</td>
                            </tr>
                            <tr>
                                <td><strong>Soil Movement</strong></td>
                                <td class="text-danger">Structural damage</td>
                                <td class="text-success">Moves with ground</td>
                            </tr>
                            <tr>
                                <td><strong>Chemical Resistance</strong></td>
                                <td class="text-danger">Porous, absorbs chemicals</td>
                                <td class="text-success">Non-porous, inert surface</td>
                            </tr>
                            <tr>
                                <td><strong>Lifespan in Texas</strong></td>
                                <td class="text-danger">5-10 years</td>
                                <td class="text-success">25+ year warranty</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Areas -->
<section class="service-areas py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Major Texas Cities We Serve</h2>
            <p class="lead">Professional pool services delivered throughout the Lone Star State</p>
        </div>

        <div class="row g-4">
            @foreach($majorCities as $city)
            <div class="col-lg-3 col-md-6">
                <div class="city-card text-center p-4 h-100 border rounded-3 hover-shadow">
                    <h3 class="h4 mb-3">{{ $city['name'] }}</h3>
                    <div class="city-stats mb-3">
                        <p class="mb-1 small text-muted">Population: <strong>{{ $city['population'] }}</strong></p>
                        <p class="mb-1 small text-muted">Est. Pools: <strong>{{ $city['pools'] }}</strong></p>
                    </div>
                    <p class="small">{{ $city['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Extended Coverage Areas -->
        <div class="mt-5">
            <h3 class="mb-4">Complete Texas Coverage</h3>
            <div class="row">
                <div class="col-md-3">
                    <h4 class="h6 text-primary mb-3">North Texas</h4>
                    <ul class="list-unstyled small">
                        <li>• Dallas</li>
                        <li>• Fort Worth</li>
                        <li>• Plano</li>
                        <li>• Arlington</li>
                        <li>• Frisco</li>
                        <li>• McKinney</li>
                        <li>• Denton</li>
                        <li>• Richardson</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="h6 text-primary mb-3">Central Texas</h4>
                    <ul class="list-unstyled small">
                        <li>• Austin</li>
                        <li>• Round Rock</li>
                        <li>• Georgetown</li>
                        <li>• Cedar Park</li>
                        <li>• Pflugerville</li>
                        <li>• San Marcos</li>
                        <li>• Temple</li>
                        <li>• Waco</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="h6 text-primary mb-3">South Texas</h4>
                    <ul class="list-unstyled small">
                        <li>• San Antonio</li>
                        <li>• New Braunfels</li>
                        <li>• Laredo</li>
                        <li>• McAllen</li>
                        <li>• Brownsville</li>
                        <li>• Corpus Christi</li>
                        <li>• Victoria</li>
                        <li>• Seguin</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="h6 text-primary mb-3">East/West Texas</h4>
                    <ul class="list-unstyled small">
                        <li>• Houston</li>
                        <li>• Tyler</li>
                        <li>• Longview</li>
                        <li>• Beaumont</li>
                        <li>• El Paso</li>
                        <li>• Midland</li>
                        <li>• Odessa</li>
                        <li>• Lubbock</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Texas Statistics -->
<section class="texas-stats py-5 bg-primary text-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Texas Pool Market Facts</h2>
            <p class="lead">Why Texas is America's premier pool market</p>
        </div>

        <div class="row text-center g-4">
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h3 class="display-4 fw-bold" style="color: #ffcc00;">1.2M+</h3>
                    <p>Residential Pools</p>
                    <small class="text-white-50">2nd highest in USA</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h3 class="display-4 fw-bold" style="color: #ffcc00;">8-9</h3>
                    <p>Months Pool Season</p>
                    <small class="text-white-50">March - November</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h3 class="display-4 fw-bold" style="color: #ffcc00;">$45K</h3>
                    <p>Avg. Pool Value Add</p>
                    <small class="text-white-50">To home value</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h3 class="display-4 fw-bold" style="color: #ffcc00;">35%</h3>
                    <p>Pool Growth Rate</p>
                    <small class="text-white-50">Last 5 years</small>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <p class="mb-0"><em>*Statistics based on Texas Pool & Spa Association data and industry reports</em></p>
        </div>
    </div>
</section>

<!-- Why Choose Us for Texas -->
<section class="why-choose-texas py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-6 fw-bold mb-4">Why Texas Homeowners Choose Hexagon</h2>

                <div class="feature-list">
                    <div class="feature-item d-flex mb-3">
                        <div class="feature-icon me-3">
                            <i class="fas fa-award text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h4 class="h5 mb-1">Exclusive Texas Fibre Tech™ Dealer</h4>
                            <p class="text-muted mb-0">Only authorized installer of premium fiberglass systems in North & Central Texas</p>
                        </div>
                    </div>

                    <div class="feature-item d-flex mb-3">
                        <div class="feature-icon me-3">
                            <i class="fas fa-shield-alt text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h4 class="h5 mb-1">25-Year Transferable Warranty</h4>
                            <p class="text-muted mb-0">Industry-leading protection that adds value to your Texas home</p>
                        </div>
                    </div>

                    <div class="feature-item d-flex mb-3">
                        <div class="feature-icon me-3">
                            <i class="fas fa-users text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h4 class="h5 mb-1">Texas Family-Owned Since Day One</h4>
                            <p class="text-muted mb-0">Local expertise, understanding Texas pool challenges firsthand</p>
                        </div>
                    </div>

                    <div class="feature-item d-flex mb-3">
                        <div class="feature-icon me-3">
                            <i class="fas fa-certificate text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h4 class="h5 mb-1">Licensed & Insured Statewide</h4>
                            <p class="text-muted mb-0">Full Texas licensing with $2M liability coverage for your protection</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="testimonial-box p-4 bg-light rounded-3">
                    <h3 class="h4 mb-4">What Texas Homeowners Say</h3>

                    <div class="testimonial mb-4">
                        <div class="stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-2"><em>"After the 2021 Texas freeze destroyed our pool surface, Hexagon's solution was the only one with a warranty that covers temperature extremes."</em></p>
                        <p class="mb-0"><strong>- Sarah M., Dallas</strong></p>
                    </div>

                    <div class="testimonial mb-4">
                        <div class="stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-2"><em>"Our Austin clay soil caused three replaster jobs in 10 years. Hexagon's flexible system finally solved the problem permanently."</em></p>
                        <p class="mb-0"><strong>- Robert K., Austin</strong></p>
                    </div>

                    <div class="testimonial">
                        <div class="stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-2"><em>"The Texas sun destroyed our previous surface. Hexagon's UV-resistant finish still looks new after 3 brutal summers."</em></p>
                        <p class="mb-0"><strong>- Maria G., San Antonio</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="texas-cta py-5 bg-dark text-white">
    <div class="container">
        <div class="text-center">
            <h2 class="display-5 fw-bold mb-3">Ready to Transform Your Texas Pool?</h2>
            <p class="lead mb-4">Join thousands of Texas homeowners who've chosen permanent pool solutions</p>

            <div class="cta-features d-flex justify-content-center flex-wrap gap-4 mb-5">
                <div class="cta-feature">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>Free Consultation</span>
                </div>
                <div class="cta-feature">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>25-Year Warranty</span>
                </div>
                <div class="cta-feature">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>Texas Licensed</span>
                </div>
                <div class="cta-feature">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>Financing Available</span>
                </div>
            </div>

            <div class="cta-buttons d-flex justify-content-center flex-wrap gap-3">
                <a href="tel:972-789-2983" class="btn btn-warning btn-lg px-5">
                    <i class="fas fa-phone-alt me-2"></i>
                    <span>Call (972) 789-2983</span>
                </a>
                <a href="/pool-repair-quote" class="btn btn-light btn-lg px-5">
                    Get Your Free Texas Quote
                </a>
            </div>

            <p class="mt-4 mb-0 text-white-50">
                <small>Serving all 254 Texas counties • Same-day callbacks • Se habla español</small>
            </p>
        </div>
    </div>
</section>

<!-- Custom Styles -->
<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

.hover-shadow {
    transition: box-shadow 0.3s ease;
}
.hover-shadow:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.min-vh-50 {
    min-height: 50vh;
}

.stat-box {
    padding: 1.5rem;
}

.challenge-item {
    padding-left: 1rem;
    border-left: 3px solid #043f88;
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2.5rem;
    }
    .display-5 {
        font-size: 2rem;
    }
    .display-6 {
        font-size: 1.75rem;
    }
}
</style>

@endsection