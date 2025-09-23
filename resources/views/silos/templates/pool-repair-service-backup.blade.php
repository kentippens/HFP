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
            <h1>Pool Repair Service</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>Pool Repair Service</span>
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
                    <h1 class="mb-4">Pool Repair | Fix Cracks & Stop Leaks | Permanent Solutions</h1>
                    <p class="lead"><strong>Stop Pool Damage Before It Gets Worse</strong> – Expert Structural Repairs That Last</p>
                </div>
            </div>
        </div>

        <!-- Main Content and Sidebar -->
        <div class="row">
            <!-- Main Body Content -->
            <div class="col-lg-8">
                <div class="main-content">
                    <h2>Your Pool's Structural Problems Need Professional Repair. We're the Permanent Solution.</h2>
                    <p>That crack you've been watching isn't just cosmetic. In North Texas clay soil, minor damage becomes major structural failure in just one season. Water loss, equipment strain, and safety risks compound daily.</p>

                    <p>As North Texas's exclusive Fibre Tech dealer, we deliver permanent structural repairs that others can't—backed by the industry's only 25-year transferable warranty.</p>

                    <div class="alert alert-info">
                        <strong>Schedule Your Free Structural Assessment:</strong> Call <a href="tel:972-789-2983">(972) 789-2983</a> or <a href="#get-quote">Book Online →</a>
                    </div>

                    <ul class="feature-list">
                        <li>✅ Expert structural repair specialists</li>
                        <li>✅ Insurance documentation specialists</li>
                        <li>✅ Exclusive Fibre Tech technology</li>
                        <li>✅ Dallas-owned since 1998</li>
                    </ul>

                    <hr class="my-5">

                    <h2>Complete Pool Repair Services</h2>

                    <h3>How Much Does Pool Resurfacing Cost in Dallas-Fort Worth?</h3>
                    <p>Pool resurfacing costs vary based on material choice and pool size. Here's what North Texas homeowners typically pay:</p>

                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pool Resurfacing Type</th>
                                    <th>Cost Per Sq Ft</th>
                                    <th>Average Total Cost</th>
                                    <th>Lifespan in Texas</th>
                                    <th>20-Year Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Plaster Resurfacing</strong></td>
                                    <td>$4-6</td>
                                    <td>$6,000-$8,000</td>
                                    <td>5-7 years</td>
                                    <td>$32,000</td>
                                </tr>
                                <tr>
                                    <td><strong>Marcite Resurfacing</strong></td>
                                    <td>$5-7</td>
                                    <td>$7,000-$10,000</td>
                                    <td>6-8 years</td>
                                    <td>$35,000</td>
                                </tr>
                                <tr>
                                    <td><strong>Pebble Resurfacing</strong></td>
                                    <td>$8-12</td>
                                    <td>$10,000-$15,000</td>
                                    <td>10-12 years</td>
                                    <td>$25,000</td>
                                </tr>
                                <tr>
                                    <td><strong>Quartz Resurfacing</strong></td>
                                    <td>$7-10</td>
                                    <td>$9,000-$13,000</td>
                                    <td>8-10 years</td>
                                    <td>$30,000</td>
                                </tr>
                                <tr>
                                    <td><strong>Gunite Resurfacing</strong></td>
                                    <td>$6-9</td>
                                    <td>$8,000-$12,000</td>
                                    <td>7-9 years</td>
                                    <td>$32,000</td>
                                </tr>
                                <tr class="table-info">
                                    <td><strong>Hexagon Conversion</strong></td>
                                    <td>Varies by pool size</td>
                                    <td>Call for Quote</td>
                                    <td>25+ years (warranty)</td>
                                    <td>Call for Quote</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="text-muted"><small>*Based on 15x30 ft pool (450 sq ft surface area) with normal prep work</small></p>
                    </div>

                    <h3>Hidden Costs of Traditional Pool Resurfacing</h3>
                    <p>Beyond the resurfacing itself, consider these recurring expenses:</p>

                    <h4>Every 2-3 Years:</h4>
                    <ul>
                        <li>Acid washing: $500-$800</li>
                        <li>Spot repairs: $300-$500</li>
                        <li>Extra chemicals for porous surfaces: $400/year</li>
                    </ul>

                    <h4>Every Resurfacing Cycle:</h4>
                    <ul>
                        <li>Water replacement: $200-$400</li>
                        <li>2-3 weeks pool downtime</li>
                        <li>Landscape repair from equipment</li>
                        <li>Disposal fees for old material</li>
                    </ul>

                    <h3>Pool Resurfacing Cost Calculator</h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="cost-box">
                                <h4>Your Current Path (Traditional Resurfacing):</h4>
                                <ul>
                                    <li>Initial resurface: $10,000</li>
                                    <li>Second resurface (year 8): $12,000</li>
                                    <li>Third resurface (year 16): $14,000</li>
                                    <li>Maintenance/repairs: $8,000</li>
                                    <li>Extra chemicals: $4,000</li>
                                </ul>
                                <p class="total-cost"><strong>20-Year Total: $48,000</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cost-box highlight">
                                <h4>Pool Resurfacing with Hexagon Fiberglass Pools:</h4>
                                <ul>
                                    <li>One-time conversion: Price Varies By Pool</li>
                                    <li>Maintenance: $2,000</li>
                                    <li>Chemical savings: -$2,000</li>
                                </ul>
                                <p class="total-cost"><strong>20-Year Total: $19,000</strong></p>
                                <p class="savings"><strong>Your Savings: $29,000</strong></p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5">

                    <h2>Types of Pool Resurfacing: Which Is Right for Your Texas Pool?</h2>

                    <h3>Traditional Pool Resurfacing Options (Temporary Solutions)</h3>

                    <h4>1. Plaster Pool Resurfacing</h4>
                    <p>The most economical initial option, plaster resurfacing involves applying white Portland cement mixed with marble dust.</p>

                    <div class="pros-cons">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Pros:</h5>
                                <ul class="pros-list">
                                    <li>• Lowest upfront cost</li>
                                    <li>• Smooth initial finish</li>
                                    <li>• Quick application</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Cons:</h5>
                                <ul class="cons-list">
                                    <li>• Roughens within 2-3 years</li>
                                    <li>• Stains easily in hard water</li>
                                    <li>• Requires frequent acid washing</li>
                                    <li>• 5-7 year lifespan in Texas</li>
                                </ul>
                            </div>
                        </div>
                        <p><strong>Best for:</strong> Budget-conscious homeowners planning to sell within 5 years</p>
                    </div>

                    <h4>2. Pebble Pool Resurfacing</h4>
                    <p>Aggregate finishes combine small pebbles with cement for improved durability.</p>

                    <div class="pros-cons">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Pros:</h5>
                                <ul class="pros-list">
                                    <li>• Longer lifespan than plaster</li>
                                    <li>• Natural appearance</li>
                                    <li>• Slip-resistant</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Cons:</h5>
                                <ul class="cons-list">
                                    <li>• Rough on feet</li>
                                    <li>• Traps algae in texture</li>
                                    <li>• Expensive to repair</li>
                                    <li>• Can feel like sandpaper</li>
                                </ul>
                            </div>
                        </div>
                        <p><strong>Best for:</strong> Homeowners prioritizing longevity over comfort</p>
                    </div>

                    <h4>3. Gunite Pool Resurfacing</h4>
                    <p>Pneumatically applied concrete mixture for structural and surface renovation.</p>

                    <div class="pros-cons">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Pros:</h5>
                                <ul class="pros-list">
                                    <li>• Can reshape pool</li>
                                    <li>• Structural reinforcement</li>
                                    <li>• Customizable</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Cons:</h5>
                                <ul class="cons-list">
                                    <li>• Develops cracks</li>
                                    <li>• Porous surface</li>
                                    <li>• High maintenance</li>
                                    <li>• Requires replastering</li>
                                </ul>
                            </div>
                        </div>
                        <p><strong>Best for:</strong> Pools needing structural work</p>
                    </div>

                    <h3>The Permanent Solution: Hexagon Pool Resurfacing</h3>

                    <h4>Exclusive Fiberglass Conversion Technology</h4>
                    <p>Unlike traditional pool resurfacing that applies another temporary layer, our conversion process permanently converts your pool to fiberglass.</p>

                    <div class="highlight-box">
                        <h5>Exclusive Benefits:</h5>
                        <ul class="benefits-list">
                            <li>• <strong>25-year warranty</strong> (materials by Fibre Tech™, labor by Hexagon)</li>
                            <li>• <strong>Non-porous surface</strong> reduces chemical use by 40%</li>
                            <li>• <strong>Crack-resistant</strong> flexible material adapts to ground movement</li>
                            <li>• <strong>Smooth forever</strong> no roughening or deterioration</li>
                            <li>• <strong>Algae-resistant</strong> nothing for algae to grab onto</li>
                            <li>• <strong>Energy efficient</strong> retains heat better than concrete</li>
                        </ul>

                        <h5>The Science Behind Our Pool Resurfacing & Conversion:</h5>
                        <ol>
                            <li>Multi-layer fiberglass mat construction</li>
                            <li>Vinyl ester resin for chemical resistance</li>
                            <li>UV-inhibited gel coat finish</li>
                            <li>Molecular bonding to existing structure</li>
                            <li>No excavation or structural modification</li>
                        </ol>

                        <p><strong>Best for:</strong> Homeowners who never want to resurface again</p>
                    </div>

                    <hr class="my-5">

                    <h2>The Pool Resurfacing Process: How We Transform Your Pool</h2>

                    <h3>Traditional Resurfacing Method (What Others Do)</h3>

                    <div class="process-timeline">
                        <h4>Week 1: Demolition</h4>
                        <ul>
                            <li>Drain pool completely</li>
                            <li>Chip out old plaster (extremely loud)</li>
                            <li>Haul away debris</li>
                            <li>Extensive dust and mess</li>
                        </ul>

                        <h4>Week 2: Preparation</h4>
                        <ul>
                            <li>Repair cracks temporarily</li>
                            <li>Apply bond coat</li>
                            <li>Install new plaster/pebble</li>
                            <li>Multiple crew visits</li>
                        </ul>

                        <h4>Week 3: Finishing</h4>
                        <ul>
                            <li>Fill pool slowly</li>
                            <li>Balance chemistry</li>
                            <li>Clean up damage to yard</li>
                            <li>Hope it lasts 7-10 years</li>
                        </ul>
                    </div>

                    <h3>The Hexagon Pool Resurfacing Process (5-7 Days)</h3>

                    <div class="process-timeline highlight">
                        <h4>Day 1: Assessment & Protection</h4>
                        <ul>
                            <li>Comprehensive inspection</li>
                            <li>Moisture and adhesion testing</li>
                            <li>Identify all cracks and damage</li>
                            <li>Document current condition</li>
                            <li>Cover plants and furniture</li>
                            <li>Begin controlled draining</li>
                        </ul>

                        <h4>Day 2: Surface Preparation</h4>
                        <p><strong>Without Excavation or Demolition:</strong></p>
                        <ul>
                            <li>Profile surface for optimal adhesion</li>
                            <li>Crack Repair</li>
                            <li>Zero damage to surrounding area</li>
                        </ul>

                        <h4>Days 3-4: Fibre Tech™ Application</h4>
                        <p><strong>Exclusive Multi-Layer Process:</strong></p>
                        <ul>
                            <li>Install using patented techniques</li>
                        </ul>
                        <p><strong>Quality Control:</strong></p>
                        <ul>
                            <li>Thickness testing at 25+ points</li>
                            <li>Detection for voids</li>
                            <li>Surface smoothness verification</li>
                            <li>Photo documentation</li>
                        </ul>

                        <h4>Day 5: Curing & Finishing</h4>
                        <ul>
                            <li>Controlled curing environment</li>
                            <li>Sand to perfect smoothness</li>
                            <li>Polish to glass-like finish</li>
                            <li>Restore tile and coping</li>
                            <li>Equipment integration</li>
                        </ul>

                        <h4>Day 6: Final Inspection</h4>
                        <ul>
                            <li>Complete surface examination</li>
                            <li>Leak test all penetrations</li>
                            <li>Verify warranty compliance</li>
                            <li>Clean entire work area</li>
                            <li>Remove all equipment</li>
                        </ul>

                        <h4>Day 7: Completion</h4>
                        <ul>
                            <li>Start water filling process (then hand over to homeowner)</li>
                            <li>Provide warranty documentation</li>
                            <li>Final walkthrough</li>
                            <li>Project complete</li>
                        </ul>

                        <p><strong>Note:</strong> We start the water filling, and then our work is complete. Pool water chemistry balancing is handled by your pool service provider.</p>
                    </div>

                    <hr class="my-5">

                    <h2>Why Pool Resurfacing Fails (And How Hexagon Fiberglass Pools Solves It)</h2>

                    <h3>Why Traditional Resurfacing Keeps Failing</h3>

                    <div class="failure-points">
                        <h4>1. Material Porosity</h4>
                        <ul>
                            <li>Plaster and concrete are naturally porous</li>
                            <li>Water penetrates, causing deterioration</li>
                            <li>Chemicals get absorbed, weakening structure</li>
                        </ul>
                        <p><strong>Hexagon Solution:</strong> Non-porous fiberglass surface</p>

                        <h4>2. Rigid Materials Can't Flex</h4>
                        <ul>
                            <li>Texas clay soil expands/contracts</li>
                            <li>Rigid plaster cracks under movement</li>
                            <li>Cracks grow larger each season</li>
                        </ul>
                        <p><strong>Hexagon Solution:</strong> Flexible material adapts to ground movement</p>

                        <h4>3. Chemical Degradation</h4>
                        <ul>
                            <li>Chlorine attacks plaster constantly</li>
                            <li>Salt systems accelerate deterioration</li>
                            <li>pH fluctuations damage surface</li>
                        </ul>
                        <p><strong>Hexagon Solution:</strong> Chemically inert fiberglass resists all pool chemicals</p>

                        <h4>4. Temperature Stress</h4>
                        <ul>
                            <li>100°F+ surface temperatures</li>
                            <li>Freezing winter conditions</li>
                            <li>Thermal expansion causes cracking</li>
                        </ul>
                        <p><strong>Hexagon Solution:</strong> Engineered for -40°F to 200°F</p>

                        <h4>5. Poor Installation</h4>
                        <ul>
                            <li>Improper mixing ratios</li>
                            <li>Rushed application</li>
                            <li>Inadequate curing time</li>
                        </ul>
                        <p><strong>Hexagon Solution:</strong> Factory-certified installation process</p>
                    </div>

                    <hr class="my-5">

                    <h2>Swimming Pool Resurfacing Near Me: North & Central Texas Coverage</h2>

                    <h3>Primary Service Areas for Pool Resurfacing</h3>

                    <div class="row">
                        <div class="col-md-6">
                            <h4>Dallas County Pool Resurfacing</h4>
                            <ul class="service-area-list">
                                <li>• Dallas Pool Resurfacing</li>
                                <li>• Richardson Pool Resurfacing</li>
                                <li>• Garland Pool Resurfacing</li>
                                <li>• Irving Pool Resurfacing</li>
                                <li>• Mesquite Pool Resurfacing</li>
                                <li>• Carrollton Pool Resurfacing</li>
                            </ul>

                            <h4>Collin County Pool Resurfacing</h4>
                            <ul class="service-area-list">
                                <li>• Plano Pool Resurfacing</li>
                                <li>• McKinney Pool Resurfacing</li>
                                <li>• Frisco Pool Resurfacing</li>
                                <li>• Allen Pool Resurfacing</li>
                                <li>• Wylie Pool Resurfacing</li>
                                <li>• Prosper Pool Resurfacing</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4>Tarrant County Pool Resurfacing</h4>
                            <ul class="service-area-list">
                                <li>• Fort Worth Pool Resurfacing</li>
                                <li>• Arlington Pool Resurfacing</li>
                                <li>• Bedford Pool Resurfacing</li>
                                <li>• Euless Pool Resurfacing</li>
                                <li>• Grapevine Pool Resurfacing</li>
                                <li>• Southlake Pool Resurfacing</li>
                            </ul>

                            <h4>Denton County Pool Resurfacing</h4>
                            <ul class="service-area-list">
                                <li>• Denton Pool Resurfacing</li>
                                <li>• Lewisville Pool Resurfacing</li>
                                <li>• Flower Mound Pool Resurfacing</li>
                                <li>• Highland Village Pool Resurfacing</li>
                                <li>• Trophy Club Pool Resurfacing</li>
                                <li>• Roanoke Pool Resurfacing</li>
                            </ul>
                        </div>
                    </div>

                    <h3>Extended Service Areas</h3>

                    <div class="row">
                        <div class="col-md-4">
                            <h5>Central Texas:</h5>
                            <ul class="service-area-list">
                                <li>• Austin Pool Resurfacing</li>
                                <li>• Round Rock Pool Resurfacing</li>
                                <li>• Georgetown Pool Resurfacing</li>
                                <li>• Cedar Park Pool Resurfacing</li>
                                <li>• Waco Pool Resurfacing</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h5>East Texas:</h5>
                            <ul class="service-area-list">
                                <li>• Tyler Pool Resurfacing</li>
                                <li>• Longview Pool Resurfacing</li>
                                <li>• Sherman Pool Resurfacing</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h5>Future Expansion Planned:</h5>
                            <ul class="service-area-list">
                                <li>• Oklahoma</li>
                                <li>• Louisiana</li>
                                <li>• Arkansas</li>
                            </ul>
                        </div>
                    </div>

                    <p class="alert alert-info"><strong>Note:</strong> The Houston area is serviced by a different Fibre Tech™ dealer. We focus exclusively on North & Central Texas.</p>

                    <hr class="my-5">

                    <h2>Pool Resurfacing FAQ: Your Questions Answered</h2>

                    <h3>General Pool Resurfacing Questions</h3>

                    <div class="faq-section">
                        <h5>Q: How often do pools need resurfacing?</h5>
                        <p>Traditional surfaces need resurfacing every 5-15 years depending on material. Plaster lasts 5-7 years, pebble 10-15 years in Texas climate. Our fiberglass resurfacing comes with a 25-year warranty and is designed to last decades beyond that.</p>

                        <h5>Q: How long does pool resurfacing take?</h5>
                        <p>Traditional resurfacing takes 2-3 weeks, including drying time. Our conversion completes in just 5-7 days total, with less mess and no excavation. If there is rain or other inclement weather, this may push the project duration out. If that's the case, we'll communicate with you about timeline adjustments.</p>

                        <h5>Q: Can you resurface a pool without draining it?</h5>
                        <p>No, all pool resurfacing methods require draining. However, our process is faster, allowing you to refill sooner than traditional methods.</p>

                        <h5>Q: What time of year is best for pool resurfacing?</h5>
                        <p>In North Texas, fall through early spring (October-March) is ideal. Moderate temperatures help materials cure properly. We work year-round, but summer scheduling fills quickly.</p>
                    </div>

                    <h3>Cost & Value Questions</h3>

                    <div class="faq-section">
                        <h5>Q: Is pool resurfacing worth it?</h5>
                        <p>Traditional resurfacing is necessary maintenance that you'll repeat every 7-10 years. Fiberglass resurfacing may cost more initially, but eliminates future resurfacing, saving $22,500+ over 20 years.</p>

                        <h5>Q: Does pool resurfacing increase home value?</h5>
                        <p>Yes, a newly resurfaced pool can add $5,000-$10,000 to home value. The 25-year <strong>Transferable</strong> warranty is particularly attractive to buyers as it eliminates a major maintenance concern.</p>

                        <h5>Q: Can I finance pool resurfacing?</h5>
                        <p>Yes, we offer 12-month 0% financing for qualified buyers. Many homeowners also use home equity lines or pool renovation loans. Ask your sales rep about our financing options.</p>
                    </div>

                    <h3>Technical Questions</h3>

                    <div class="faq-section">
                        <h5>Q: Can you resurface a gunite pool with fiberglass?</h5>
                        <p>Yes, gunite pool conversion is our specialty. Resurfacing permanently solves common gunite problems like cracking, rough texture, and high maintenance requirements.</p>

                        <h5>Q: What causes pool resurfacing to fail?</h5>
                        <p>In Texas: extreme temperatures, ground movement, chemical damage, and poor installation. Traditional materials can't handle these stresses. Fibre Tech™ is engineered specifically for these challenges.</p>

                        <h5>Q: Can you resurface a fiberglass pool?</h5>
                        <p>Yes, we can restore existing fiberglass pools with spider cracks, fading, or other damage using our Fibre Tech™ process.</p>
                    </div>

                    <h3>Service Questions</h3>

                    <div class="faq-section">
                        <h5>Q: Do you provide pool maintenance after resurfacing?</h5>
                        <p>No, we specialize in pool resurfacing only. Once we begin filling your pool, you'll need your regular pool service for water chemistry and maintenance. We provide the surface, you maintain the water.</p>

                        <h5>Q: What areas do you service?</h5>
                        <p>We're the exclusive Fibre Tech™ dealer for North & Central Texas, covering Dallas-Fort Worth to Austin. Houston has a different dealer. Call to confirm coverage in your area.</p>

                        <h5>Q: What warranty comes with pool resurfacing?</h5>
                        <p>Traditional resurfacing typically includes 1-3 year warranties. We include an exclusive 25-year manufacturer warranty, the longest in the industry.</p>
                    </div>

                    <hr class="my-5">

                    <h2>Gunite Pool Resurfacing: Special Considerations</h2>

                    <h3>Why Gunite Pools Need Special Attention</h3>
                    <p>Gunite pools represent the majority of North Texas pools and face unique resurfacing challenges:</p>

                    <h4>Common Gunite Problems:</h4>
                    <ul class="gunite-problems-list">
                        <li>• Structural cracks from ground movement</li>
                        <li>• Extreme surface roughness</li>
                        <li>• Calcium buildup in pores</li>
                        <li>• Rebar corrosion and rust stains</li>
                        <li>• Hollow spots (delamination)</li>
                    </ul>

                    <h3>Traditional Gunite Resurfacing Limitations</h3>

                    <h4>Replastering Gunite:</h4>
                    <ul class="gunite-limitations-list">
                        <li>• Only addresses surface, not structural issues</li>
                        <li>• New plaster bonds poorly to old gunite</li>
                        <li>• Cracks reappear within 2-3 years</li>
                        <li>• Roughness returns quickly</li>
                    </ul>

                    <h4>Why It Keeps Failing:</h4>
                    <ul class="gunite-failures-list">
                        <li>• Gunite continues deteriorating underneath</li>
                        <li>• Moisture penetrates through cracks</li>
                        <li>• Temperature changes cause separation</li>
                        <li>• Each resurface adheres worse than previous one</li>
                    </ul>

                    <h3>Fibre Tech™ for Gunite Pool Resurfacing</h3>

                    <div class="highlight-box">
                        <h4>Permanent Gunite Solutions:</h4>
                        <ol>
                            <li><strong>Crack Injection:</strong> Seal all cracks permanently before fiberglass application</li>
                            <li><strong>Structural Stabilization:</strong> Flexible fiberglass prevents future cracking</li>
                            <li><strong>Waterproof Barrier:</strong> Stops water penetration completely</li>
                            <li><strong>Smooth Forever:</strong> Eliminates gunite's natural roughness</li>
                        </ol>

                        <h4>Results:</h4>
                        <ul class="gunite-results-list">
                            <li>• No more replastering every 7 years</li>
                            <li>• 70% reduction in chemical usage</li>
                            <li>• Comfortable smooth surface</li>
                            <li>• 25-year warranty protection</li>
                        </ul>
                    </div>

                    <hr class="my-5">

                    <h2>Why Hexagon Fiberglass Pools?</h2>

                    <h3>North & Central Texas Exclusive Fibre Tech™ Dealer</h3>

                    <div class="row why-hexagon-section">
                        <div class="col-md-6">
                            <h4>Exclusive Dealer</h4>
                            <ul class="feature-list">
                                <li>• Only authorized Fibre Tech™ installer from Dallas to Austin</li>
                                <li>• Factory-trained and certified</li>
                                <li>• Direct manufacturer support</li>
                                <li>• Protected warranty coverage</li>
                            </ul>

                            <h4>Industry Leadership</h4>
                            <ul class="feature-list">
                                <li>• CPO Certified professionals</li>
                                <li>• Pool & Hot Tub Alliance member</li>
                                <li>• Texas License</li>
                                <li>• $2M liability insurance</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4>Local Expertise</h4>
                            <ul class="feature-list">
                                <li>• 173+ successful pool resurfacings</li>
                                <li>• Dallas-based, family-owned</li>
                                <li>• Understand Texas pool challenges</li>
                                <li>• Experienced with local permits</li>
                            </ul>

                            <h4>Proven Results</h4>
                            <ul class="feature-list">
                                <li>• 98% customer satisfaction</li>
                                <li>• 5.0 star average rating</li>
                                <li>• 75% referral business</li>
                                <li>• Zero warranty claims for failure</li>
                            </ul>
                        </div>
                    </div>

                    @if($silo->content)
                        <!-- Dynamic content from database -->
                        {!! $silo->content !!}
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
    font-weight: 600;
}

/* Offer CTA Button Styling */
.cta-offer-button {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 18px 20px;
    background: linear-gradient(135deg, #ff6b35 0%, #ff4517 100%);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    border: none;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.cta-offer-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
    color: white;
    text-decoration: none;
}

.cta-offer-button:active {
    transform: translateY(0);
}

.cta-offer-button i {
    font-size: 1.2rem;
    margin-bottom: 5px;
    animation: ring 1s ease-in-out infinite;
}

.cta-offer-button .button-text {
    font-size: 1.1rem;
    font-weight: 700;
    display: block;
    margin-bottom: 3px;
}

.cta-offer-button .button-subtext {
    font-size: 0.9rem;
    font-weight: 400;
    opacity: 0.95;
}

/* Phone ring animation */
@keyframes ring {
    0%, 100% { transform: rotate(0deg); }
    10%, 30% { transform: rotate(-10deg); }
    20%, 40% { transform: rotate(10deg); }
    50% { transform: rotate(0deg); }
}

/* Pulsing effect for urgency */
.cta-offer-button::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
    transform: translate(-50%, -50%);
    opacity: 0;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.8);
    }
    50% {
        opacity: 0.3;
    }
    100% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(1.2);
    }
}

/* Sidebar Form Styles */
.sidebar-form.appoinment-form {
    background-size: cover;
    background-position: center;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.sidebar-form .appoinment-title {
    text-align: center;
    margin-bottom: 20px;
}

.sidebar-form .appoinment-title h4 {
    font-size: 20px;
    font-weight: 600;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

.sidebar-form input,
.sidebar-form select,
.sidebar-form textarea {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.sidebar-form .select-field select {
    background-color: #fff;
}

.sidebar-form .bixol-primary-btn {
    width: 100%;
    padding: 12px 20px;
    background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
    color: #fff;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.sidebar-form .bixol-primary-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.name-field-wrapper::after {
    content: "Mr. Mrs. Ms.";
    position: absolute;
    right: 15px;
    top: 12px;
    font-style: italic;
    color: #999;
    pointer-events: none;
    font-size: 14px;
}

.name-field-wrapper input[name="name"] {
    padding-right: 100px;
}

/* Intro Section Styles */
.intro-section {
    padding: 2rem 0;
    border-bottom: 2px solid #f0f0f0;
}

.intro-section h1 {
    color: #333;
    font-weight: 700;
    font-size: 1.75rem;
    line-height: 1.3;
}

.intro-section .lead {
    font-size: 1.1rem;
    color: #666;
    line-height: 1.5;
}

/* Sidebar column needs proper setup for sticky */
.pool-resurfacing-section .col-lg-4 {
    align-self: stretch !important;
    position: relative;
}

/* Sidebar Styles - Complete sticky setup */
.sticky-sidebar {
    position: -webkit-sticky !important;
    position: sticky !important;
    top: 100px !important;
    z-index: 100 !important;
    will-change: transform;
}

.widget-title {
    color: #333;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.trust-badges-widget {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

/* Trust Badge Image Styling */
.trust-badge-wrapper {
    padding: 10px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.trust-badge-wrapper:hover {
    background: #e9ecef;
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.trust-badge-img {
    max-width: 100%;
    max-height: 60px;
    width: auto;
    height: auto;
    object-fit: contain;
}

/* Gunite Section Lists Styling */
.gunite-problems-list,
.gunite-limitations-list,
.gunite-failures-list,
.gunite-results-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 1.5rem;
}

.gunite-problems-list li,
.gunite-limitations-list li,
.gunite-failures-list li {
    padding: 8px 0;
    color: #dc3545;
    font-size: 0.95rem;
    line-height: 1.6;
    border-left: 3px solid #dc3545;
    padding-left: 15px;
    margin-bottom: 8px;
    background: linear-gradient(to right, #fff5f5 0%, transparent 100%);
}

.gunite-results-list li {
    padding: 8px 0;
    color: #28a745;
    font-size: 0.95rem;
    line-height: 1.6;
    border-left: 3px solid #28a745;
    padding-left: 15px;
    margin-bottom: 8px;
    background: linear-gradient(to right, #f0f9ff 0%, transparent 100%);
}

/* Service Area Lists Styling */
.service-area-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 1.5rem;
}

.service-area-list li {
    padding: 6px 0;
    color: #333;
    font-size: 0.95rem;
    line-height: 1.6;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.service-area-list li:last-child {
    border-bottom: none;
}

.service-area-list li:hover {
    padding-left: 10px;
    color: #2196f3;
    background: linear-gradient(to right, #f8f9fa 0%, transparent 100%);
}

/* Why Hexagon Section Styling */
.why-hexagon-section {
    margin-top: 2rem;
}

.why-hexagon-section h4 {
    color: #2196f3;
    border-bottom: 2px solid #e3f2fd;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.feature-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 2rem;
}

.feature-list li {
    padding: 8px 0;
    color: #555;
    font-size: 0.95rem;
    line-height: 1.6;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.feature-list li:last-child {
    border-bottom: none;
}

.feature-list li:hover {
    padding-left: 10px;
    color: #333;
    background: linear-gradient(to right, #f8f9fa 0%, transparent 100%);
}

/* Final CTA Section - Complete Redesign */
.final-cta-section {
    position: relative;
    padding: 80px 0;
    background: #043f88;
    overflow: hidden;
}

.cta-background-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') bottom center no-repeat;
    background-size: cover;
    opacity: 0.3;
}

.cta-content {
    position: relative;
    z-index: 1;
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
}

/* CTA Badge */
.cta-badge {
    display: inline-block;
    margin-bottom: 20px;
}

.badge-text {
    background: linear-gradient(135deg, #ff6b35 0%, #ff4517 100%);
    color: white;
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 1px;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    animation: pulse-badge 2s infinite;
}

@keyframes pulse-badge {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* CTA Heading */
.cta-heading {
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    line-height: 1.2;
}

.cta-subheading {
    color: rgba(255,255,255,0.9);
    font-size: 1.2rem;
    margin-bottom: 40px;
    font-weight: 400;
}

/* Value Props */
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

.value-item span {
    font-size: 1rem;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

/* CTA Buttons */
.cta-buttons-wrapper {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    padding: 20px 35px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;
}

.cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}

.cta-btn i {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.btn-content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    text-align: left;
}

.btn-main-text {
    font-size: 1.1rem;
    font-weight: 700;
    display: block;
}

.btn-sub-text {
    font-size: 0.9rem;
    opacity: 0.9;
    display: block;
}

/* Primary Button */
.cta-btn-primary {
    background: linear-gradient(135deg, #ff6b35 0%, #ff4517 100%);
    color: white;
    border: none;
}

.cta-btn-primary::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.cta-btn-primary:hover::before {
    width: 300px;
    height: 300px;
}

.cta-btn-primary:hover {
    color: white;
    text-decoration: none;
}

/* Secondary Button */
.cta-btn-secondary {
    background: rgba(255,255,255,0.95);
    color: #043f88;
    border: 2px solid rgba(255,255,255,0.3);
}

.cta-btn-secondary:hover {
    background: white;
    color: #043f88;
    text-decoration: none;
    border-color: white;
}

/* Trust Line */
.cta-trust-line {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid rgba(255,255,255,0.2);
}

.cta-trust-line p {
    color: rgba(255,255,255,0.8);
    font-size: 0.9rem;
    margin: 0;
    letter-spacing: 0.5px;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .final-cta-section {
        padding: 60px 0;
    }

    .cta-heading {
        font-size: 1.8rem;
    }

    .cta-subheading {
        font-size: 1rem;
    }

    .cta-value-props {
        flex-direction: column;
        gap: 20px;
        align-items: center;
    }

    .cta-buttons-wrapper {
        flex-direction: column;
        align-items: stretch;
    }

    .cta-btn {
        width: 100%;
        justify-content: center;
        text-align: center;
    }

    .btn-content {
        align-items: center;
    }

    .cta-trust-line p {
        font-size: 0.8rem;
        line-height: 1.5;
    }
}

/* Animation for phone icon */
.cta-btn-primary i {
    animation: ring-phone 1.5s ease-in-out infinite;
}

@keyframes ring-phone {
    0%, 100% { transform: rotate(0deg); }
    10%, 30% { transform: rotate(-15deg); }
    20%, 40% { transform: rotate(15deg); }
    50% { transform: rotate(0deg); }
}

/* Responsive Styles */
@media (max-width: 991px) {
    .sticky-sidebar {
        position: relative !important;
        top: auto !important;
        margin-top: 2rem;
    }

    .main-content {
        padding-right: 0;
        margin-bottom: 2rem;
    }
}

@media (max-width: 767px) {
    .intro-section h1 {
        font-size: 1.4rem;
    }

    .main-content h2 {
        font-size: 1.3rem;
    }

    .main-content h3 {
        font-size: 1.15rem;
    }

    .main-content h4 {
        font-size: 1.05rem;
    }

    .trust-badge-wrapper {
        height: 60px;
        padding: 8px;
    }

    .trust-badge-img {
        max-height: 40px;
    }
}
</style>

<!-- JavaScript for Sticky Sidebar Fallback -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if CSS sticky is supported
    var testEl = document.createElement('div');
    testEl.style.position = 'sticky';
    var isSticky = testEl.style.position === 'sticky';

    if (!isSticky) {
        // Fallback for browsers that don't support sticky
        var sidebar = document.querySelector('.sticky-sidebar');
        var sidebarParent = sidebar.parentElement;
        var mainContent = document.querySelector('.main-content').parentElement;

        window.addEventListener('scroll', function() {
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            var sidebarTop = sidebarParent.offsetTop;
            var mainContentHeight = mainContent.offsetHeight;
            var sidebarHeight = sidebar.offsetHeight;

            if (scrollTop > sidebarTop - 100) {
                var maxScroll = sidebarTop + mainContentHeight - sidebarHeight - 100;
                if (scrollTop < maxScroll) {
                    sidebar.style.position = 'fixed';
                    sidebar.style.top = '100px';
                    sidebar.style.width = sidebarParent.offsetWidth + 'px';
                } else {
                    sidebar.style.position = 'absolute';
                    sidebar.style.top = (maxScroll - sidebarTop) + 'px';
                }
            } else {
                sidebar.style.position = 'static';
                sidebar.style.top = 'auto';
            }
        });
    }

    // Ensure parent containers don't have overflow hidden
    var section = document.querySelector('.pool-resurfacing-section');
    if (section) {
        section.style.overflow = 'visible';
    }
});
</script>
@endsection