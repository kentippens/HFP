@extends('layouts.app')

@section('title', 'Pool Resurfacing & Refinishing | 25-Year Warranty | Save $22K')
@section('meta_description', 'Fiberglass pool resurfacing and refinishing with exclusive 25-year warranty. Install in 7-10 days. Zero Excavation. Book this month for Fall Discounts.')
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
                    <h1 class="mb-4">Permanent Pool Resurfacing with 25-Year Warranty – North & Central Texas' Exclusive Fibre Tech™ Solution</h1>
                    <p class="lead"><strong>Stop replastering every 7 years.</strong> Your Texas pool deserves Hexagon Fiberglass Pools' permanent resurfacing solution that eliminates $43,900 in recurring costs over 20 years.</p><br>
                    <p>As North Texas' exclusive Fibre Tech™ dealer, Hexagon Fiberglass Pools converts deteriorating gunite and plaster pools into maintenance-free fiberglass surfaces—backed by the industry's only 25-year manufacturer warranty.</p>
                    <br>
                    <div class="alert alert-warning mt-3">
                        <strong>March installations 70% booked. Lock in 2026 pricing before 8% increase on January 1, 2026.</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content and Sidebar -->
        <div class="row">
            <!-- Main Body Content -->
            <div class="col-lg-8">
                <div class="main-content">
                    <h2>Understanding Pool Resurfacing in Texas</h2>

                    <h3>The $43,900 Problem Texas Homeowners Face</h3>
                    <p>Pool resurfacing is the process of applying new surface material to a deteriorating pool interior. In North Texas, harsh weather and clay soil movement mean pools require resurfacing every 7-10 years using traditional methods like plaster, marcite, or pebble finishes.</p><br>

                    <p>Traditional resurfacing materials—plaster, marcite, pebble, quartz—provide temporary solutions that fail predictably. Each replastering investment of $8,000-$15,000 deteriorates within the decade, creating an endless cycle that costs Texas homeowners $43,900 over 20 years.</p><br>

                    <h3>Why Traditional Resurfacing Continuously Fails in Texas</h3>
                    <p>Four critical factors guarantee traditional resurfacing failure across our state:</p>

                    <ul class="failure-list" style="margin-left: 10px">
                        <li><strong>Material Porosity:</strong> Plaster and concrete surfaces contain 14-18% porosity, allowing water penetration that accelerates chemical degradation and structural deterioration.</li><br>
                        <li><strong>Thermal Incompatibility:</strong> Rigid surfaces cannot accommodate Texas' extreme temperature swings, creating expansion stress that manifests as spider cracks within 24 months.</li><br>
                        <li><strong>Chemical Vulnerability:</strong> Extended swim seasons (March-November in South Texas) require constant chlorination that attacks cementitious materials, reducing surface integrity by 15% annually.</li><br>
                        <li><strong>Soil Movement:</strong> Texas' diverse soil conditions—from Blackland Prairie clay to coastal sand—create unique structural stresses that traditional surfaces cannot withstand.</li>
                    </ul>

                    <h3>The Hexagon Solution: Permanent Pool Transformation</h3>
                    <p>Hexagon Fiberglass Pools eliminates the resurfacing cycle through our exclusive pool conversion process—permanently transforming your existing pool into a non-porous fiberglass surface using patented HexConvert™ technology.</p><br>

                    <div class="alert alert-success">
                        <strong>One investment. One warranty. Forever resolved.</strong>
                    </div>

                    <hr class="my-5">

                    <h2>Hexagon Pool Resurfacing Cost Analysis: 20-Year Financial Impact</h2>

                    <h3>Current Market Pricing Across Texas</h3>
                    <p>Investment requirements for pool resurfacing vary by region and material selection. Texas homeowners encounter these typical costs:</p>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Resurfacing Type</th>
                                    <th>Per Sq Ft</th>
                                    <th>450 Sq Ft Pool</th>
                                    <th>Texas Lifespan</th>
                                    <th>20-Year Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Plaster</strong></td>
                                    <td>$4-6</td>
                                    <td>$6,000-8,000</td>
                                    <td>5-7 years</td>
                                    <td>$32,000</td>
                                </tr>
                                <tr>
                                    <td><strong>Marcite</strong></td>
                                    <td>$5-7</td>
                                    <td>$7,000-10,000</td>
                                    <td>6-8 years</td>
                                    <td>$35,000</td>
                                </tr>
                                <tr>
                                    <td><strong>Pebble</strong></td>
                                    <td>$8-12</td>
                                    <td>$10,000-15,000</td>
                                    <td>8-10 years</td>
                                    <td>$30,000</td>
                                </tr>
                                <tr>
                                    <td><strong>Quartz</strong></td>
                                    <td>$7-10</td>
                                    <td>$9,000-13,000</td>
                                    <td>7-9 years</td>
                                    <td>$33,000</td>
                                </tr>
                                <tr>
                                    <td><strong>Gunite</strong></td>
                                    <td>$6-9</td>
                                    <td>$8,000-12,000</td>
                                    <td>6-8 years</td>
                                    <td>$34,000</td>
                                </tr>
                                <tr class="table-success">
                                    <td><strong>Hexagon Fiberglass</strong></td>
                                    <td>Custom</td>
                                    <td><a href="tel:972-702-7586">Get Quote</a></td>
                                    <td>25+ years</td>
                                    <td>Single Investment</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="text-muted"><em>*Analysis based on 15x30 ft pool with standard prep requirements</em></p>
                    </div>

                    <h3>Hidden Expenses Traditional Contractors Omit</h3>
                    <p>Beyond surface application costs, recurring maintenance compounds your investment:</p>

                    <div class="row">
                        <div class="col-md-6">
                            <h4>Annual Requirements:</h4>
                            <ul style="margin-left: 10px">
                                <li>Acid washing: $500-800 (required every 24 months)</li>
                                <li>Spot repairs: $300-500 (average 2.3 annually)</li>
                                <li>Excess chemicals: $400/year (40% above fiberglass)</li>
                                <li>Water replacement: $200-400 per resurface</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4>Per-Cycle Disruption:</h4>
                            <ul style="margin-left: 10px">
                                <li>14-21 days without pool access</li>
                                <li>Landscape restoration: $500-1,200</li>
                                <li>Equipment recalibration: $150-300</li>
                                <li>Disposal fees: $400-600</li>
                            </ul>
                        </div>
                    </div>

                    <h3>Your Personalized Hexagon Savings Calculator</h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="cost-box">
                                <h4>Traditional Path (Your Current Trajectory):</h4>
                                <ul>
                                    <li>Initial resurface (Year 1): $10,000</li>
                                    <li>Second resurface (Year 8): $12,000</li>
                                    <li>Third resurface (Year 16): $14,000</li>
                                    <li>Cumulative maintenance: $8,000</li>
                                    <li>Chemical premium: $4,000</li>
                                </ul>
                                <div class="total-cost">
                                    <strong>20-Year Investment: $48,000</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cost-box highlight">
                                <h4>Hexagon Fiberglass Conversion:</h4>
                                <ul>
                                    <li>One-time conversion: <a href="tel:972-702-7586">[Custom Quote]</a></li>
                                    <li>Routine maintenance: $2,000</li>
                                    <li>Chemical savings: -$2,000</li>
                                </ul>
                                <div class="total-cost">
                                    <strong>20-Year Investment: Initial Cost Only</strong>
                                </div>
                                <div class="savings">
                                    <strong>Your Net Savings: $29,000-35,000</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-calculator"></i> Calculate My Exact Savings → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>Resurfacing Options: Temporary Fixes vs. Hexagon's Permanent Solution</h2>

                    <h3>Traditional Resurfacing Methods (Recurring Investments)</h3>

                    <h4><strong>Plaster Pool Resurfacing</strong></h4>
                    <p>White Portland cement combined with marble dust creates the industry's most economical surface—temporarily.</p>

                    <div class="pros-cons">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Initial Advantages:</h5>
                                <ul class="pros-list">
                                    <li>• Lowest entry investment ($6,000-8,000)</li>
                                    <li>• 3-5 day application timeline</li>
                                    <li>• Smooth initial texture</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Inevitable Failures:</h5>
                                <ul class="cons-list">
                                    <li>• Roughness emerges within 24-36 months</li>
                                    <li>• Staining accelerates in Texas hard water</li>
                                    <li>• Acid washing requirement damages surface integrity</li>
                                    <li>• 5-7 year replacement cycle in Texas climate</li>
                                </ul>
                            </div>
                        </div>
                        <p><strong>Suitable For:</strong> Homeowners selling within 5 years</p>
                    </div>

                    <h4><strong>Pebble Pool Resurfacing</strong></h4>
                    <p>Aggregate surfaces combine small stones with cement for enhanced durability—at comfort's expense.</p>

                    <div class="pros-cons">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Performance Characteristics:</h5>
                                <ul class="pros-list">
                                    <li>• Extended lifespan (8-10 years in Texas)</li>
                                    <li>• Natural aesthetic appeal</li>
                                    <li>• Slip-resistant properties</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Comfort Compromises:</h5>
                                <ul class="cons-list">
                                    <li>• Abrasive texture causes foot discomfort</li>
                                    <li>• Algae colonizes textured surface</li>
                                    <li>• $10,000-15,000 investment required</li>
                                    <li>• Spot repairs visible and expensive</li>
                                </ul>
                            </div>
                        </div>
                        <p><strong>Suitable For:</strong> Investors prioritizing longevity over comfort</p>
                    </div>

                    <h4><strong>Gunite Pool Resurfacing</strong></h4>
                    <p>Pneumatic concrete application addresses structural and surface requirements simultaneously.</p>

                    <div class="pros-cons">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Structural Benefits:</h5>
                                <ul class="pros-list">
                                    <li>• Reinforces compromised shells</li>
                                    <li>• Allows shape modifications</li>
                                    <li>• Customizable thickness</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Predictable Problems:</h5>
                                <ul class="cons-list">
                                    <li>• Develops shrinkage cracks</li>
                                    <li>• Requires protective coating</li>
                                    <li>• High maintenance burden</li>
                                    <li>• Secondary plastering necessary</li>
                                </ul>
                            </div>
                        </div>
                        <p><strong>Suitable For:</strong> Pools requiring structural rehabilitation</p>
                    </div>

                    <h3>The Hexagon Fiberglass Solution: Permanent Pool Transformation</h3>

                    <h4>Why Hexagon Fiberglass Pools Succeeds Where Others Fail</h4>
                    <p>Unlike surface applications that fail repeatedly, Hexagon Fiberglass Pools creates a monolithic fiberglass shell using our proprietary process:</p>

                    <div class="highlight-box">
                        <h5>Hexagon's Multi-Layer Construction:</h5>
                        <ul style="margin-left: 10px">
                            <li>• Vinyl ester resin (chemical immunity)</li>
                            <li>• Chopped strand mat (structural integrity)</li>
                            <li>• UV-inhibited gel coat (color stability)</li>
                            <li>• Molecular substrate bonding (permanent adhesion)</li>
                        </ul>

                        <h5>Measurable Hexagon Advantages:</h5>
                        <ul class="benefits-list" style='margin-left:10px'>
                            <li>• 25-year manufacturer warranty (exclusive to Hexagon Fiberglass Pools)</li>
                            <li>• 0% porosity (eliminates water penetration)</li>
                            <li>• 40% chemical reduction (documented savings)</li>
                            <li>• Glass-smooth surface (permanent comfort)</li>
                            <li>• Algae-resistant properties (nothing adheres)</li>
                            <li>• Thermal efficiency (15% heat retention improvement)</li>
                        </ul>

                        <p><strong>Ideal For:</strong> Texas homeowners seeking permanent pool solutions</p>
                    </div>

                    <hr class="my-5">

                    <h2>The Hexagon Installation Process: 5-7 Day Transformation</h2>

                    <h3>Traditional Resurfacing Disruption (Industry Standard)</h3>

                    <div class="process-timeline">
                        <h4>Week 1: Demolition Chaos</h4>
                        <ul style="margin-left: 10px">
                            <li>Complete pool drainage</li>
                            <li>Jackhammer removal (85-90 decibels)</li>
                            <li>Debris hauling (3-5 truckloads)</li>
                            <li>Dust contamination radius (50 feet)</li>
                        </ul>

                        <h4>Week 2: Preparation</h4>
                        <ul style="margin-left: 10px">
                            <li>Crack bandaging (temporary)</li>
                            <li>Bond coat application</li>
                            <li>Surface installation</li>
                            <li>Multiple crew disruptions</li>
                        </ul>

                        <h4>Week 3: Recovery</h4>
                        <ul style="margin-left: 10px">
                            <li>Gradual filling process</li>
                            <li>Chemistry stabilization</li>
                            <li>Landscape restoration</li>
                            <li>Equipment recalibration</li>
                        </ul>

                        <p><strong>Total disruption: 21 days minimum</strong></p>
                    </div>

                    <h3>The Hexagon Method: Controlled 5-7 Day Process</h3>

                    <div class="process-timeline highlight">
                        <h4>Day 1: Hexagon Professional Assessment</h4>
                        <ul style="margin-left: 10px">
                            <li>Comprehensive structural evaluation by Hexagon technicians</li>
                            <li>Moisture content analysis (≤3% requirement)</li>
                            <li>Crack documentation and mapping</li>
                            <li>Photographic condition baseline</li>
                            <li>Protective covering installation</li>
                            <li>Controlled drainage initiation</li>
                            <li>Zero landscape impact</li>
                        </ul>

                        <h4>Day 2: Hexagon Surface Preparation</h4>
                        <p><strong>Without Demolition:</strong></p>
                        <ul style="margin-left: 10px">
                            <li>Diamond grinding surface profiling</li>
                            <li>Crack injection with epoxy resin</li>
                            <li>Surface contamination removal</li>
                            <li>Adhesion optimization treatment</li>
                        </ul>
                        <p><strong>Hexagon Quality Metrics:</strong></p>
                        <ul style="margin-left: 10px">
                            <li>Surface profile: 3-5 mils</li>
                            <li>Cleanliness: White metal standard</li>
                            <li>Temperature: 50-90°F verified</li>
                        </ul>

                        <h4>Days 3-4: HexConvert Application</h4>
                        <p><strong>Proprietary Installation:</strong></p>
                        <ul style="margin-left: 10px">
                            <li>Multi-layer mat positioning</li>
                            <li>Catalyzed resin application</li>
                            <li>Vacuum consolidation process</li>
                            <li>Thickness verification</li>
                        </ul>
                        <p><strong>Hexagon Quality Control:</strong></p>
                        <ul style="margin-left: 10px">
                            <li>Layer adhesion testing</li>
                            <li>Void detection scanning</li>
                            <li>Thickness mapping</li>
                            <li>Photo documentation</li>
                        </ul>

                        <h4>Day 5: Hexagon Curing & Finishing</h4>
                        <p><strong>Surface Perfection:</strong></p>
                        <ul style="margin-left: 10px">
                            <li>Controlled cure environment</li>
                            <li>Progressive sanding (400-1500 grit)</li>
                            <li>Glass-like polish application</li>
                            <li>Equipment integration</li>
                        </ul>

                        <h4>Day 6: Hexagon Final Inspection</h4>
                        <p><strong>Comprehensive Validation:</strong></p>
                        <ul style="margin-left: 10px">
                            <li>Complete surface examination</li>
                            <li>Penetration leak testing</li>
                            <li>Warranty compliance verification</li>
                            <li>Site restoration completion</li>
                        </ul>

                        <h4>Day 7: Hexagon Project Completion</h4>
                        <p><strong>Handover Process:</strong></p>
                        <ul style="margin-left: 10px">
                            <li>Water filling initiation</li>
                            <li>Hexagon warranty documentation delivery</li>
                            <li>Maintenance guidance provision</li>
                            <li>Final walkthrough with the Hexagon team</li>
                        </ul>
                        <br>
                        <p class="alert alert-info"><strong>Note:</strong> Water chemistry balancing is managed by your pool service provider.</p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-check"></i> Reserve Your Hexagon Installation → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>Hexagon Fiberglass Pools Service Territory: Statewide Texas Coverage</h2>

                    <h3>Major Texas Metropolitan Areas</h3>

                    <h4>North Texas Region</h4>
                    <p><strong>Dallas-Fort Worth Metroplex:</strong><br>
                    Serving Dallas, Fort Worth, Plano, Arlington, Irving, Garland, McKinney, Frisco, Denton, Richardson, Carrollton, Lewisville, Allen, Flower Mound, Mansfield</p>

                    <h4>Central Texas Region</h4>
                    <p><strong>Austin-San Antonio Corridor:</strong><br>
                    Coverage includes Austin, Round Rock, San Antonio, Cedar Park, Georgetown, New Braunfels, San Marcos, Pflugerville, Kyle, Buda</p>

                    <p><strong>Rio Grande Valley & Coastal Bend:</strong><br>
                    Coverage for Corpus Christi, McAllen, Brownsville, Laredo, Victoria, Harlingen</p>

                    <h4>East Texas Service Area</h4>
                    <p><strong>Piney Woods Region:</strong><br>
                    Including Tyler, Longview, Texarkana, Lufkin, Nacogdoches, Marshall</p>

                    <h3>Hexagon Fiberglass Pools Statewide Commitment</h3>
                    <ul>
                        <li>72-hour response anywhere in Texas</li>
                        <li>Regional crews minimize travel time</li>
                        <li>Same warranty coverage statewide</li>
                    </ul>

                    <div class="text-center mt-4">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-map-marker-alt"></i> Verify Hexagon Service in Your Area → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>Frequently Asked Questions About Hexagon Fiberglass Pools</h2>

                    <h3>Investment & Value Questions</h3>

                    <div class="faq-section">
                        <h5>Q: How does Hexagon pool resurfacing cost compare over 20 years?</h5>
                        <p>Traditional resurfacing requires 3-4 applications over 20 years, totaling $32,000-48,000 across Texas. Hexagon Fiberglass Pools' conversion represents a single investment with our exclusive 25-year warranty protection, eliminating recurring costs and saving homeowners $22,500-35,000.</p>

                        <h5>Q: Does Hexagon fiberglass resurfacing increase property value?</h5>
                        <p>Professional appraisals document $8,000-15,000 property value increases following Hexagon conversions. Our transferable 25-year warranty particularly appeals to buyers, eliminating a $40,000+ maintenance concern and accelerating sale negotiations. Individual results will vary based on market conditions and other factors. Consult with a real estate professional for an in-depth valuation.</p>

                        <h5>Q: What financing options does Hexagon Fiberglass Pools offer?</h5>
                        <p>Hexagon offers 12-month 0% financing for qualified buyers, with extended terms available through our lending partners. Home equity lines provide tax-advantaged funding, while Hexagon seasonal promotions reduce investment by $1,000-1,500.</p>
                    </div>

                    <h3>Technical & Process Questions</h3>

                    <div class="faq-section">
                        <h5>Q: Can Hexagon resurface gunite pools with fiberglass?</h5>
                        <p>Gunite pool conversion represents Hexagon Fiberglass Pools' specialty, with 11,847 successful Texas transformations. Our process permanently resolves gunite-specific challenges, including structural cracks, surface roughness, and excessive maintenance requirements.</p>

                        <h5>Q: How long does Hexagon pool resurfacing take?</h5>
                        <p>Traditional replastering requires 14-21 days including curing time. Hexagon's conversion completes in 5-7 days, weather permitting. Hexagon maintains 92% on-time completion rates with clear communication regarding any weather-related adjustments.</p>

                        <h5>Q: What causes pool resurfacing failure in Texas?</h5>
                        <p>Four factors accelerate failure: temperature extremes (varies by region), soil movement (clay to sand), chemical degradation (extended swim seasons), and poor installation quality. Traditional materials cannot withstand these stresses, while Hexagon's engineering specifically addresses each challenge.</p>
                    </div>

                    <h3>Service & Warranty Questions</h3>

                    <div class="faq-section">
                        <h5>Q: What warranty does Hexagon Fiberglass Pools provide?</h5>
                        <p>Traditional resurfacing includes 1-3 year limited warranties. Hexagon provides an exclusive 25-year manufacturer warranty on our Fibre Tech™ materials plus Hexagon's comprehensive labor warranty, creating industry-leading protection that transfers to new owners.</p>

                        <h5>Q: Does Hexagon handle pool maintenance after resurfacing?</h5>
                        <p>Hexagon Fiberglass Pools specializes exclusively in pool resurfacing and conversion. Following project completion and filling initiation, your regular pool service provider manages water chemistry and routine maintenance. Our surface reduces chemical requirements by 40%.</p>

                        <h5>Q: Which Texas areas does Hexagon Fiberglass Pools service?</h5>
                        <p>Hexagon Fiberglass Pools operates statewide across Texas, from El Paso to Beaumont, Amarillo to Brownsville. Our regional crews ensure prompt service anywhere in Texas. Coverage verification takes 30 seconds via phone.</p>
                    </div>

                    <hr class="my-5">

                    <h2>Gunite Pool Resurfacing: Hexagon's Specialized Solutions</h2>

                    <h3>The Gunite Challenge Across Texas</h3>
                    <p>Gunite pools dominate the Texas market (73% of existing pools), yet face accelerated deterioration from regional conditions:</p>

                    <div class="row">
                        <div class="col-md-6">
                            <h4><strong>Structural Vulnerabilities:</strong></h4>
                            <ul style="margin-left: 10px">
                                <li>Soil movement creates varying pressure (clay to limestone)</li>
                                <li>Temperature cycling causes 0.3% dimensional change</li>
                                <li>Calcium leaching weakens matrix by 2% annually</li>
                                <li>Rebar corrosion expands, creating delamination</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4><strong>Surface Failures:</strong></h4>
                            <ul style="margin-left: 10px">
                                <li>Plaster bond failure occurs within 5-7 years</li>
                                <li>Surface porosity reaches 18% over time</li>
                                <li>Roughness index increases 300% by year 5</li>
                                <li>Chemical demand escalates 45% versus new</li>
                            </ul>
                        </div>
                    </div>

                    <h3>Why Gunite Replastering Repeatedly Fails</h3>
                    <p><strong>Deteriorating Substrate:</strong> Each replastering adheres to increasingly compromised gunite. Previous plaster layers create weak bonding planes. Moisture infiltration continues beneath new surfaces. Result: Shorter lifespan with each application.</p>

                    <h3>The Hexagon Gunite Solution</h3>
                    <p>Hexagon Fiberglass Pools' gunite conversion process addresses root causes:</p>

                    <div class="highlight-box">
                        <h4>Hexagon Structural Stabilization:</h4>
                        <ul>
                            <li>Epoxy injection seals all cracks permanently</li>
                            <li>Flexible fiberglass accommodates movement</li>
                            <li>Waterproof barrier prevents infiltration</li>
                            <li>25-year structural integrity guarantee from Hexagon</li>
                        </ul>

                        <h4>Hexagon Surface Transformation:</h4>
                        <ul>
                            <li>Permanent smooth texture (0.5 micron finish)</li>
                            <li>70% chemical reduction versus plaster</li>
                            <li>Zero porosity eliminates staining</li>
                            <li>Comfort restoration for bare feet</li>
                        </ul>

                        <h4>Hexagon's Documented Results:</h4>
                        <ul>
                            <li>Gunite conversions completed statewide</li>
                            <li>98% customer satisfaction rating</li>
                            <li>Zero warranty claims for structural failure</li>
                            <li>$2,100 average annual savings</li>
                        </ul>
                    </div>

                    <div class="text-center mt-4">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-tools"></i> Transform Your Gunite Pool with Hexagon → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>Why Hexagon Fiberglass Pools?</h2>

                    <h3>North & Central Texas Exclusive Fibre Tech™ Dealer</h3>

                    <div class="row why-hexagon-section">
                        <div class="col-md-6">
                            <h4 style="color: #043f88;">Exclusive Dealer</h4>
                            <ul class="feature-list">
                                <li>• Only authorized Fibre Tech™ installer from Dallas to Austin</li>
                                <li>• Factory-trained and certified</li>
                                <li>• Direct manufacturer support</li>
                                <li>• Protected warranty coverage</li>
                            </ul>

                            <h4 style="color: #043f88;">Industry Leadership</h4>
                            <ul class="feature-list">
                                <li>• CPO Certified professionals</li>
                                <li>• Pool & Hot Tub Alliance member</li>
                                <li>• Texas License</li>
                                <li>• $2M liability insurance</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4 style="color: #043f88;">Local Expertise</h4>
                            <ul class="feature-list">
                                <li>• 173+ successful pool resurfacings</li>
                                <li>• Dallas-based, family-owned</li>
                                <li>• Understand Texas pool challenges</li>
                                <li>• Experienced with local permits</li>
                            </ul>

                            <h4 style="color: #043f88;">Proven Results</h4>
                            <ul class="feature-list">
                                <li>• 98% customer satisfaction</li>
                                <li>• 5.0 star average rating</li>
                                <li>• 75% referral business</li>
                                <li>• Zero warranty claims for failure</li>
                            </ul>
                        </div>
                    </div>

                    <hr class="my-5">

                    <h2>Take Action: Your Hexagon Pool Transformation Begins Today</h2>

                    <h3>Step 1: Complimentary Hexagon Assessment (This Week)</h3>
                    <p>Call <a href="tel:972-702-7586">972-702-7586</a> now to secure your no-obligation evaluation. A Hexagon Certified Pool Operator technician will:</p>
                    <ul style="margin-left: 10px">
                        <li>Perform a comprehensive 25-point inspection</li>
                        <li>Document current conditions</li>
                        <li>Calculate your 25-year savings with Hexagon Fiberglass Pools</li>
                        <li>Present conversion timeline</li>
                    </ul><br>
                    <p><strong>Available Hexagon appointments this week: Call for Options</strong></p>

                    <h3>Step 2: Hexagon Investment Analysis</h3>
                    <p>Review your personalized pool resurfacing proposal, including:</p>
                    <ul style="margin-left: 10px">
                        <li>Detailed cost comparison (20-year view)</li>
                        <li>Hexagon warranty documentation review</li>
                        <li>Color and finish selection</li>
                        <li>Flexible payment options through Hexagon</li>
                    </ul>

                    <h3>Step 3: Installation Scheduling</h3>
                    <p>Select your convenient 5-7 day window:</p>
                    <ul style="margin-left: 10px">
                        <li>Spring schedule filling rapidly (70% booked)</li>
                        <li>Weather windows optimized by Hexagon crews</li>
                        <li>Minimal lifestyle disruption</li>
                        <li>Defined completion date</li>
                    </ul>

                    <h3>Step 4: Permanent Pool Enjoyment</h3>
                    <p>Experience the Hexagon difference:</p>
                    <ul style="margin-left: 10px">
                        <li>25-year Hexagon warranty protection begins</li>
                        <li>20+% chemical reduction realized</li>
                        <li>Maintenance eliminated permanently</li>
                        <li>Transferable Fiberglass Pool Warranty</li>
                    </ul>

                    @if($silo->content)
                        <!-- Dynamic content from database -->
                        {!! \App\Helpers\HtmlHelper::safe($silo->content, 'admin') !!}
                    @endif
                </div>
            </div>

            <!-- Sticky Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar-sticky-wrapper" style="height: 100%;">
                    <div class="sticky-sidebar" style="position: sticky; position: -webkit-sticky; top: 100px; z-index: 100;">
                        <!-- Contact Form Widget -->
                        <div class="appoinment-form sidebar-form" data-background="{{ asset('images/home2/form-bg.jpg') }}">
                            <div class="appoinment-title">
                                <h4 style="color: #ffffff;">👉 Free Online Quote 👈</h4>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                    <ul style="margin: 0; padding-left: 20px;">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST" id="sidebar-contact-form">
                                @csrf
                                <input type="hidden" name="type" value="pool_resurfacing_quote">
                                <div class="name-field-wrapper" style="position: relative;">
                                    <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required
                                           class="{{ $errors->has('name') ? 'error' : '' }}">
                                </div>
                                <input type="tel" name="phone" placeholder="Phone Number*" value="{{ old('phone') }}" required
                                       class="{{ $errors->has('phone') ? 'error' : '' }}" maxlength="20" autocomplete="tel">
                                <input type="email" name="address" placeholder="Email Address" value="{{ old('address') }}"
                                       class="{{ $errors->has('address') ? 'error' : '' }}">
                                <div class="select-field">
                                    <select name="service" required class="{{ $errors->has('service') ? 'error' : '' }}">
                                        <option value="request-callback" {{ old('service') == 'request-callback' || old('service') === null ? 'selected' : '' }}>Request A Callback</option>
                                        <option value="pool-resurfacing-conversion" {{ old('service') == 'pool-resurfacing-conversion' ? 'selected' : '' }}>Pool Resurfacing & Conversion</option>
                                        <option value="pool-repair" {{ old('service') == 'pool-repair' ? 'selected' : '' }}>Pool Repair</option>
                                        <option value="pool-remodeling" {{ old('service') == 'pool-remodeling' ? 'selected' : '' }}>Pool Remodeling</option>
                                    </select>
                                </div>
                                <textarea name="message" placeholder="Notes for our team..." rows="8"
                                          class="{{ $errors->has('message') ? 'error' : '' }}">{{ old('message') }}</textarea>

                                @include('components.recaptcha-button', [
                                    'formId' => 'sidebar-contact-form',
                                    'buttonText' => 'Get A Quote',
                                    'buttonClass' => 'bixol-primary-btn',
                                    'buttonIcon' => 'fa-paper-plane'
                                ])
                            </form>
                        </div>

                        <!-- Limited Time Offer Widget -->
                        <div class="offer-widget mt-4">
                            <h3 class="widget-title mb-3 text-center">Limited Time Offer</h3>
                            <div class="offer-box">
                                <h4>January 2026 Special - North Texas Homeowners</h4>
                                <p>Book your pool resurfacing assessment this month and receive:</p>
                                <ul class="offer-list">
                                    <li>✓ <strong>$1,000 OFF</strong> any pool resurfacing over $15,000</li>
                                    <li>✓ <strong>FREE</strong> Comprehensive Inspection ($500 value)</li>
                                    <li>✓ <strong>0% Financing</strong> for 12 months (qualified buyers)</li>
                                    <li>✓ <strong>Priority Scheduling</strong> for February/March completion</li>
                                    <li>✓ <strong>Lock 2026 Prices</strong> before spring increases</li>
                                </ul>
                                <p class="text-center"><strong>Only 8 spots remaining for Q1 2026 installation</strong></p>
                                <a href="tel:972-789-2983" class="cta-offer-button">
                                    <i class="fas fa-phone-alt"></i>
                                    <span class="button-text">Lock in Your $1,000 Savings</span>
                                    <span class="button-subtext">Call Now: 972-789-2983</span>
                                </a>
                            </div>
                        </div>

                        <!-- Trust Badges Widget -->
                        <div class="trust-badges-widget mt-4">
                            <h3 class="widget-title mb-3 text-center">Why Choose Us</h3>
                            <div class="trust-badges">
                                @php
                                    $logos = [
                                        'flag-of-the-united-states.svg',
                                        'flag-of-texas.svg',
                                        'PHTA-Member-Logo.png',
                                        'North-Dallas-Chamber-icon.png',
                                        'north-texas-food-bank.png',
                                        'WWP_ProudSupporterLockup.svg'
                                    ];
                                @endphp

                                <div class="row g-3 align-items-center">
                                    @foreach($logos as $logo)
                                        @if(file_exists(public_path('images/homepage-logos/' . $logo)))
                                            <div class="col-6 text-center">
                                                <div class="trust-badge-wrapper">
                                                    <img src="{{ asset('images/homepage-logos/' . $logo) }}"
                                                         alt="{{ pathinfo($logo, PATHINFO_FILENAME) }}"
                                                         class="trust-badge-img">
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Pool Resurfacing Main Content End -->

<!-- Call to Action Section -->
<section class="final-cta-section">
    <div class="cta-background-overlay"></div>
    <div class="container">
        <div class="cta-content">
            <!-- Badge -->
            <div class="cta-badge">
                <span class="badge-text">LIMITED TIME OFFER</span>
            </div>

            <!-- Main Heading -->
            <h2 class="cta-heading">Ready to End the Pool Resurfacing Cycle Forever?</h2>

            <!-- Subheading -->
            <p class="cta-subheading">Join 173+ Dallas-Fort Worth homeowners who never have to resurface again</p>

            <!-- Value Props -->
            <div class="cta-value-props">
                <div class="value-item">
                    <i class="fas fa-calendar-check"></i>
                    <span><strong>8 Spots</strong> Remaining for Q1 2026</span>
                </div>
                <div class="value-item">
                    <i class="fas fa-tag"></i>
                    <span><strong>Save $1,000</strong> This Month Only</span>
                </div>
                <div class="value-item">
                    <i class="fas fa-shield-alt"></i>
                    <span><strong>25-Year</strong> Transferable Warranty</span>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="cta-buttons-wrapper">
                <a href="tel:972-789-2983" class="cta-btn cta-btn-primary">
                    <i class="fas fa-phone-alt"></i>
                    <div class="btn-content">
                        <span class="btn-main-text">Call Now for Free Quote</span>
                        <span class="btn-sub-text">972-789-2983</span>
                    </div>
                </a>
                <a href="/pool-repair-quote" class="cta-btn cta-btn-secondary">
                    <i class="fas fa-calculator"></i>
                    <div class="btn-content">
                        <span class="btn-main-text">Get Online Quote</span>
                        <span class="btn-sub-text">60-Second Form</span>
                    </div>
                </a>
            </div>

            <!-- Trust Line -->
            <div class="cta-trust-line">
                <p><strong>Hexagon Fiberglass Pools</strong> • North & Central Texas' Exclusive Fibre Tech™ Dealer • CPO Certified • $2M Insurance</p>
            </div>
        </div>
    </div>
</section>

<!-- Custom Styles for Pool Resurfacing Page -->
<style>
/* CRITICAL FIX: Override global section overflow hidden that breaks sticky */
section.pool-resurfacing-section {
    overflow: visible !important;
    overflow: clip !important; /* Fallback for older browsers */
}

/* Ensure main element doesn't have overflow issues */
main {
    overflow: visible !important;
}

/* H1 Styling for Hero Section */
.intro-section h1, .col-lg-12 h1 {
    font-size: 40px !important;
}

/* Content Styling */
.main-content h2 {
    color: #333;
    margin-top: 2rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
    font-size: 1.5rem;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 0.5rem;
}

.main-content h3 {
    color: #444;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
    font-size: 1.25rem;
}

.main-content h4 {
    color: #555;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-weight: 500;
    font-size: 1.1rem;
}

.main-content h5 {
    color: #666;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
    font-size: 1rem;
}

/* Tables */
.table {
    margin-top: 1rem;
    margin-bottom: 2rem;
}

.table-responsive {
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    border-radius: 5px;
}

/* Cost Boxes */
.cost-box {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 2px solid #e9ecef;
}

.cost-box.highlight {
    background: #e8f5e9;
    border-color: #4caf50;
}

.cost-box h4 {
    color: #333;
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.cost-box ul {
    padding-left: 20px;
}

.total-cost {
    font-size: 1.2rem;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 2px solid #dee2e6;
}

.savings {
    color: #4caf50;
    font-size: 1.3rem;
    margin-top: 10px;
}

/* Pros/Cons Sections */
.pros-cons {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.pros-cons h5 {
    color: #333;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 15px;
}

.pros-list, .cons-list, .benefits-list {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.pros-list li, .cons-list li, .benefits-list li {
    padding: 6px 0;
    font-size: 0.95rem;
    line-height: 1.6;
}

.pros-list li {
    color: #28a745;
}

.cons-list li {
    color: #dc3545;
}

.benefits-list li {
    color: #333;
    padding: 8px 0;
}

/* Highlight Box */
.highlight-box {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    padding: 25px;
    border-radius: 10px;
    margin: 20px 0;
    border-left: 4px solid #2196f3;
}

.highlight-box h4 {
    color: #333;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 15px;
}

.highlight-box h5 {
    color: #333;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 10px;
}

/* Process Timeline */
.process-timeline {
    position: relative;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    margin: 20px 0;
}

.process-timeline.highlight {
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    border-left: 4px solid #4caf50;
}

.process-timeline h4 {
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 1.1rem;
}

/* Failure Points */
.failure-points {
    background: #fff3e0;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #ff9800;
}

.failure-points h4 {
    color: #e65100;
    font-size: 1.1rem;
    margin-bottom: 10px;
}

/* FAQ Section */
.faq-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.faq-section h5 {
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 1rem;
}

.faq-section p {
    margin-bottom: 20px;
    padding-left: 20px;
}

/* Offer Widget */
.offer-widget {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    border: 2px solid #ff6b35;
}

.offer-box h4 {
    color: #ff6b35;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.offer-list {
    list-style: none;
    padding: 0;
    margin: 15px 0;
}

.offer-list li {
    padding: 5px 0;
    color: #333;
}

.btn-block {
    width: 100%;
    padding: 12px;
    background: linear-gradient(45deg, #ff6b35, #ff8f5a);
    color: white;
    text-decoration: none;
    border-radius: 5px;
    display: block;
    text-align: center;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-block:hover {
    background: linear-gradient(45deg, #ff5722, #ff6b35);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255,107,53,0.3);
}

/* Trust Badges */
.trust-badges-widget {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.widget-title {
    color: #333;
    font-size: 1.25rem;
    font-weight: 600;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
}

.trust-badge-wrapper {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.trust-badge-img {
    max-width: 100%;
    max-height: 60px;
    height: auto;
    object-fit: contain;
}

/* Service Area Lists */
.service-area-list {
    list-style: none;
    padding-left: 0;
}

.service-area-list li {
    padding: 5px 0;
    color: #333;
}

/* Gunite specific lists */
.gunite-problems-list,
.gunite-limitations-list,
.gunite-failures-list,
.gunite-results-list {
    padding-left: 20px;
    margin: 15px 0;
}

.gunite-problems-list li,
.gunite-limitations-list li,
.gunite-failures-list li,
.gunite-results-list li {
    padding: 5px 0;
    color: #333;
}

/* Feature List */
.feature-list {
    list-style: none;
    padding-left: 0;
    margin: 15px 0;
}

.feature-list li {
    padding: 8px 0;
    color: #333;
    line-height: 1.6;
}

/* Why Hexagon Section */
.why-hexagon-section {
    margin: 20px 0;
}

/* Sticky Sidebar Specific */
.sidebar-sticky-wrapper {
    position: relative;
}

.sticky-sidebar {
    will-change: position;
}

/* Mobile Responsiveness */
@media (max-width: 991px) {
    .sticky-sidebar {
        position: relative !important;
        top: 0 !important;
    }

    .col-lg-4 {
        margin-top: 30px;
    }
}

/* Form Styling */
.appoinment-form {
    background-size: cover;
    background-position: center;
    padding: 25px;
    border-radius: 8px;
    position: relative;
}

.appoinment-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(4, 63, 136, 0.9);
    border-radius: 8px;
}

.appoinment-form > * {
    position: relative;
    z-index: 1;
}

.appoinment-title h4 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.5rem;
}

.appoinment-form input,
.appoinment-form select,
.appoinment-form textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: white;
    font-size: 14px;
}

.appoinment-form input.error,
.appoinment-form select.error,
.appoinment-form textarea.error {
    border-color: #dc3545;
}

.select-field select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 30px;
}

/* CTA Offer Button */
.cta-offer-button {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(45deg, #ff6b35, #ff8f5a);
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    text-decoration: none;
    margin-top: 20px;
    transition: all 0.3s ease;
    gap: 10px;
}

.cta-offer-button:hover {
    background: linear-gradient(45deg, #ff5722, #ff6b35);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255,107,53,0.3);
    color: white;
    text-decoration: none;
}

.cta-offer-button .button-text {
    font-weight: 600;
    font-size: 1rem;
    display: block;
}

.cta-offer-button .button-subtext {
    font-size: 0.85rem;
    opacity: 0.9;
    display: block;
}

/* Final CTA Section */
.final-cta-section {
    position: relative;
    padding: 80px 0;
    background: linear-gradient(135deg, #043f88 0%, #0557b5 100%);
    margin-top: 50px;
}

.cta-background-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('/images/home1/pattern.png');
    opacity: 0.1;
}

.cta-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.cta-badge {
    display: inline-block;
    margin-bottom: 20px;
}

.badge-text {
    background: #ff6b35;
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    letter-spacing: 1px;
}

.cta-heading {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: white;
}

.cta-subheading {
    font-size: 1.25rem;
    margin-bottom: 30px;
    opacity: 0.95;
    color: white;
}

.cta-value-props {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.value-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: white;
}

.value-item i {
    font-size: 1.5rem;
    color: #ffd700;
}

.cta-buttons-wrapper {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.cta-btn {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 18px 30px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 600;
}

.cta-btn-primary {
    background: linear-gradient(45deg, #ff6b35, #ff8f5a);
    color: white;
    border: 2px solid transparent;
}

.cta-btn-primary:hover {
    background: linear-gradient(45deg, #ff5722, #ff6b35);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(255,107,53,0.4);
    color: white;
    text-decoration: none;
}

.cta-btn-secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.cta-btn-secondary:hover {
    background: white;
    color: #043f88;
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(255,255,255,0.3);
    text-decoration: none;
}

.btn-content {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.btn-main-text {
    font-size: 1rem;
    line-height: 1.2;
}

.btn-sub-text {
    font-size: 0.85rem;
    opacity: 0.9;
}

.cta-trust-line {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.2);
}

.cta-trust-line p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.95rem;
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .cta-heading {
        font-size: 1.8rem;
    }

    .cta-value-props {
        flex-direction: column;
        gap: 20px;
    }

    .cta-buttons-wrapper {
        flex-direction: column;
        align-items: center;
    }

    .cta-btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

/* Additional Alert Styles */
.alert {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.alert-warning {
    background-color: #fff3cd;
    border: 1px solid #ffeeba;
    color: #856404;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-info {
    background-color: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}
</style>

@endsection