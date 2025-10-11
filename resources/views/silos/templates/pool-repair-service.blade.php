@extends('layouts.app')

@section('title', 'Pool Repair | Fix Structural Cracks | Equipment Repair | HFP')
@section('meta_description', 'Proudly Repairing Swiming Pool Structural Damage, Cracks & Equipment Repair across Texas. Up to a 25-year Warranty. Free Estimate: 972-702-7586.')
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

<!-- Pool Repair Main Content Start -->
<section class="pool-resurfacing-section pt-5 pb-5" style="overflow: visible !important;">
    <div class="container">
        <!-- Hero Section -->
        <div class="intro-section mb-5">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-4">Expert Pool Repair Texas – Hexagon Fiberglass Pools' Permanent Structural Solutions</h1>
                    <p class="lead"><strong>That crack isn't just cosmetic.</strong> In Texas challenging conditions, minor damage becomes $10,000+ structural failure within 6 months. Water loss accelerates 20% monthly. Equipment strain compounds daily. Safety liability increases exponentially.</p><br>
                    <p>Hexagon Fiberglass Pools delivers permanent structural repairs that eliminate recurring damage—backed by Texas' only 25-Year Transferable Warranty using exclusive Fibre Tech™ technology.</p><br>
                    <div class="alert alert-warning mt-3">
                        <strong>Permanent Repairs in 7-10 Days. Up to a 25-Year Transferable Warranty. Certified Structural Specialists.</strong>
                    </div>                    
                    <ul class="feature-list" style="margin-left: 10px">
                        <li>✅ Expert Structural Specialists Serving all of Texas</li>
                        <li>✅ Insurance documentation included</li>
                        <li>✅ Exclusive Repair Technology & Techniques</li>
                        <li>✅ Dallas Based & Family-Owned</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Main Content and Sidebar -->
        <div class="row">
            <!-- Main Body Content -->
            <div class="col-lg-8">
                <div class="main-content">
                    <h2>Hexagon's Complete Pool Repair Services</h2>

                    <h3>Structural Crack Repair – From Hairline to Major Failures</h3>
                    <p>Hexagon Fiberglass Pools permanently resolves all crack classifications using graduated intervention protocols designed for Texas conditions.</p>

                    <h4><strong>Minor Surface Cracks</strong></h4>
                    <p><strong>Characteristics:</strong> Plaster crazing, gel coat spider cracks, cosmetic imperfections<br>
                    <strong>Hexagon Solution:</strong> Surface sealing prevents water penetration<br>
                    <strong>Warranty:</strong> 1 year</p>

                    <h4><strong>Major Structural Cracks</strong></h4>
                    <p><strong>Characteristics:</strong> Through-wall failures, stress point separation, active leaks<br>
                    <strong>Hexagon Solution:</strong> Deep structural intervention<br>
                    <strong>Warranty:</strong> 3-5 years</p>
                    <br>
                    <h4><strong>Hexagon's Proven Repair Methods</strong></h4>

                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Repair Technology</th>
                                    <th>Application</th>
                                    <th>Investment</th>
                                    <th>Hexagon Warranty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Surface Sealing</strong></td>
                                    <td>Cosmetic cracks</td>
                                    <td>$500-1,500</td>
                                    <td>1 year</td>
                                </tr>
                                <tr>
                                    <td><strong>Epoxy Injection</strong></td>
                                    <td>Stable structural</td>
                                    <td>$1,500-3,000</td>
                                    <td>3 years</td>
                                </tr>
                                <tr>
                                    <td><strong>Torque Lock Staples</strong></td>
                                    <td>Expanding cracks</td>
                                    <td>$3,000-6,000</td>
                                    <td>5 years</td>
                                </tr>
                                <tr class="table-success">
                                    <td><strong>Hexagon Fiberglass Conversion</strong></td>
                                    <td>Permanent solution</td>
                                    <td>Custom Quote</td>
                                    <td>25 years</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-danger">
                        <strong>Critical:</strong> 87% of "minor" cracks become structural within 12 months in Texas soil. Early intervention saves $5,000-8,000.
                    </div>

                    <div class="text-center mt-4 mb-5">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-check"></i> Schedule Crack Assessment → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>Gunite Pool Repair & Conversion – Hexagon's Permanent Solution</h2>

                    <h3>Why 73% of Texas Pools Need Hexagon's Transformation</h3>
                    <p>Gunite pools dominate Texas construction—yet 92% develop structural failures within 10 years. Rather than perpetuate the repair-fail-repeat cycle, Hexagon Fiberglass Pools permanently converts gunite pools to maintenance-free fiberglass surfaces.</p>

                    <h4>Gunite Problems Hexagon Eliminates Forever:</h4>
                    <ul style="margin-left: 10px">
                        <li>• Delamination (plaster separating from gunite): Affecting 34% of pools</li>
                        <li>• Spalling (concrete deterioration): Damaging 28% of pools</li>
                        <li>• Recurring cracks: Returning within 24 months in 67% of repairs</li>
                        <li>• Chemical demand: 40% higher than necessary</li>
                    </ul>

                    <h3>Hexagon's Gunite-to-Fiberglass Conversion Process</h3>

                    <div class="process-timeline highlight">
                        <h4>Days 1-2: Gunite Stabilization</h4>
                        <ul style="margin-left: 10px">
                            <li>Sound testing identifies all compromised areas</li>
                            <li>Structural preparation for fiberglass application</li>
                            <li>Crack injection and void filling</li>
                            <li>Surface profiling for optimal adhesion</li>
                        </ul>

                        <h4>Days 3-4: Fiberglass Transformation with HexConvert</h4>
                        <ul style="margin-left: 10px">
                            <li>Complete encapsulation of gunite substrate</li>
                        </ul>

                        <h4>Days 5-7: Finishing & Perfection</h4>
                        <ul style="margin-left: 10px">
                            <li>Progressive sanding to glass-smooth finish</li>
                            <li>UV-Resistant gel coat application</li>
                            <li>Equipment Integration</li>
                            <li>25-year warranty activation</li>
                        </ul>
                    </div>

                    <div class="highlight-box mt-4">
                        <h4>Why Repair Gunite When You Can Eliminate Problems Forever?</h4>
                        <p>Traditional gunite repair costs $6,000-15,000 and fails again within 5-7 years. Hexagon's conversion costs marginally more but includes a 25-year warranty—saving $30,000+ over 20 years.</p>
                        <p><strong>Hexagon Warranty:</strong> 25 Years & Transferable<br>
                        <strong>Timeline:</strong> 7-10 days to permanent solution</p>
                    </div>

                    <div class="text-center mt-4 mb-5">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-tools"></i> Convert Your Gunite Pool → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>Bond Beam Repair – The Critical Fix Most Companies Avoid</h2>

                    <h3>Why Hexagon Tackles Complex Bond Beam Repairs</h3>
                    <p>Your pool's bond beam—the reinforced concrete collar supporting 4,500 pounds per linear foot—represents the most critical structural element. When it fails, you need engineering expertise. Hexagon remains 1 of only 3 Texas contractors properly equipped for bond beam reconstruction.</p>

                    <h4>Bond Beam Failure Indicators:</h4>
                    <ul style="margin-left: 10px">
                        <li>• Horizontal tile line cracks (87% require immediate repair)</li>
                        <li>• Coping stone movement (indicates 50% strength loss)</li>
                        <li>• Deck-to-pool separation (progressive failure imminent)</li>
                        <li>• Visible edge gaps (water infiltration accelerating damage)</li>
                    </ul>

                    <h3>Hexagon's Bond Beam Reconstruction Protocol</h3>
                    <ol style="margin-left: 10px">
                        <li><strong>Complete Demolition:</strong> Remove 100% of compromised concrete</li>
                        <li><strong>Steel Reinforcement:</strong> Install #4 rebar with epoxy anchors (6" spacing)</li>
                        <li><strong>Engineered Pour:</strong> 4,000 PSI concrete to specifications</li>
                        <li><strong>Expansion Joints:</strong> Restore proper movement allowance (missing in 60% of pools)</li>
                        <li><strong>Waterproofing:</strong> Membrane application prevents future infiltration</li>
                        <li><strong>Restoration:</strong> New tile and coping installation</li>
                    </ol>

                    <p><strong>Timeline:</strong> 5-7 days<br>
                    <strong>Hexagon Warranty:</strong> 5 years</p>
                    <br>
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> Bond beam failure affects home insurance. Document immediately.
                    </div>

                    <div class="text-center mt-4 mb-5">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-exclamation-triangle"></i> Emergency Bond Beam Evaluation → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>Concrete Cancer – Why Hexagon Converts, Not Repairs</h2>

                    <h3>Understanding Concrete Cancer in Texas Pools</h3>
                    <p>Concrete cancer—the progressive corrosion of reinforcing steel—affects aging gunite pools when moisture penetrates concrete, causing rebar to rust and expand up to 4x its original volume. This expansion force cracks surrounding concrete, accelerating deterioration.</p>

                    <h4>Signs Your Pool Has Concrete Cancer:</h4>
                    <ul style="margin-left: 10px">
                        <li>• Rust stains bleeding through plaster</li>
                        <li>• Concrete spalling (chunks breaking away)</li>
                        <li>• Exposed, corroding rebar</li>
                        <li>• Progressive crack patterns around rust points</li>
                    </ul>

                    <h3>Why Repair Fails, Conversion Succeeds</h3>

                    <h4><strong>Traditional Repair Attempts:</strong></h4>
                    <p>Other companies offer temporary patches—removing damaged concrete, treating rebar, and replastering. These repairs fail within 2-3 years because moisture continues penetrating porous gunite, restarting the corrosion cycle.</p>

                    <h4><strong>Hexagon's Permanent Solution:</strong></h4>
                    <p>Complete fiberglass conversion encapsulates the entire structure, creating an impermeable barrier that stops moisture infiltration permanently. No moisture = no corrosion = problem solved forever.</p>
                    <br>
                    <div class="cost-box">
                        <h4>Investment Comparison:</h4>
                        <ul style="margin-left: 10px">
                            <li>Temporary repairs: $3,000-8,000 (fails within 3 years)</li>
                            <li>Second repair: $5,000-10,000 (damage spreads)</li>
                            <li>Third attempt: $8,000-15,000 (structural compromise)</li>
                            <li><strong>Hexagon Conversion with HexConvert: One Time Investment in a Solution. (25-year warranty, permanent solution)</strong></li>
                        </ul>
                    </div>

                    <p><strong>The Bottom Line:</strong> After 2-3 failed repairs, you've spent more than conversion would have cost—and still have concrete cancer.</p>

                    <div class="text-center mt-4 mb-5">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-shield-alt"></i> Eliminate Concrete Cancer Permanently → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>Fiberglass Pool Repair – Hexagon's Exclusive Expertise</h2>

                    <h3>Texas' Only Certified Fibre Tech™ Repair Specialist</h3>
                    <p>As the exclusive certified Fibre Tech™ installer across Texas, Hexagon Fiberglass Pools repairs fiberglass pools using technology and materials unavailable through other contractors.</p>

                    <h4>Hexagon's Fiberglass-Specific Capabilities:</h4>
                    <ul style="margin-left: 10px">
                        <li>• Gel coat restoration with perfect color matching</li>
                        <li>• Spider crack elimination (permanent solution)</li>
                        <li>• Osmotic blister repair (warranty-backed)</li>
                        <li>• Structural fiberglass rebuilding</li>
                        <li>• Complete refinishing for 20+ year pools</li>
                    </ul>

                    <h3>Why Convert to Fiberglass with HexConvert:</h3>

                    <h4>Permanent Problem Resolution:</h4>
                    <ul style="margin-left: 10px">
                        <li>• Eliminates crack recurrence (100% success rate)</li>
                        <li>• Non-porous surface (0% water absorption)</li>
                        <li>• 40% chemical reduction (documented savings)</li>
                        <li>• Glass-smooth luxury finish</li>
                        <li>• Flexibility prevents future damage</li>
                        <li>• 25-year Hexagon warranty (exclusive)</li>
                    </ul>

                    <div class="text-center mt-4 mb-5">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-swimmer"></i> Explore Fiberglass Solutions → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>Pool Equipment & Plumbing Repair</h2>

                    <h3>Complete Mechanical System Restoration by Hexagon</h3>
                    <p>Beyond structural repairs, Hexagon Fiberglass Pools restores all pool mechanical systems to optimal performance.</p>

                    <h4><strong>Skimmer Replacement Expertise</strong></h4>
                    <p>Cracked skimmers require complete replacement—patches fail within 6 months.</p>

                    <div class="highlight-box">
                        <h5>Hexagon's Skimmer Replacement Process:</h5>
                        <ul style="margin-left: 10px">
                            <li>• Complete removal of the damaged unit</li>
                            <li>• Structural integration with the pool shell</li>
                            <li>• Precision height and level alignment</li>
                            <li>• Waterproof seal (guaranteed 5 years)</li>
                            <li>• Seamless integration</li>
                        </ul>
                        <br>
                        <p><strong>Timeline:</strong> 1-2 days</p>
                    </div>

                    <h4><strong>Equipment Hexagon Repairs/Replaces</strong></h4>
                    <p><strong>Pumps & Motors:</strong> All brands, variable-speed upgrades<br>
                    <strong>Filter Systems:</strong> Sand, cartridge, DE restoration<br>
                    <strong>Returns/Drains:</strong> Safety compliance upgrades<br>
                    <strong>Automation:</strong> System integration and updates</p>
                    <br>
                    <div class="alert alert-success">
                        <strong>Energy Efficiency Upgrade:</strong> New variable-speed pump saves 70% electricity—$1,200 annual savings pays for equipment in 14 months.
                    </div>

                    <div class="text-center mt-4 mb-5">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-cogs"></i> Schedule Equipment Inspection → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>Why Texas Pools Need Hexagon's Structural Expertise</h2>

                    <h3>The Perfect Storm Creating Pool Damage</h3>

                    <h4><strong>Expansive Soil Challenge</strong></h4>
                    <p>Texas sits on clay that expands 30% when wet, creating:</p>
                    <ul style="margin-left: 10px">
                        <li>• 4,000 PSI lateral pressure (concrete fails at 3,500 PSI)</li>
                        <li>• 2-6 inches annual movement</li>
                        <li>• Differential settling patterns</li>
                        <li>• Continuous structural stress</li>
                    </ul>

                    <h4><strong>Extreme Weather Cycles</strong></h4>
                    <ul style="margin-left: 10px">
                        <li>• 105°F summers to 15°F winters (90°F range)</li>
                        <li>• 90+ freeze-thaw cycles annually</li>
                        <li>• 40°F temperature swings within 24 hours</li>
                        <li>• Drought-to-flood extremes</li>
                    </ul>

                    <h4><strong>Construction Deficiencies (Found in 60% of Texas Pools)</strong></h4>
                    <ul style="margin-left: 10px">
                        <li>• Insufficient steel reinforcement (builder cost-cutting)</li>
                        <li>• Gunite below 4" minimum thickness</li>
                        <li>• Missing expansion joints</li>
                        <li>• Inadequate soil preparation</li>
                        <li>• Insufficient rebar coverage</li>
                    </ul>
                    <br>
                    <div class="alert alert-danger">
                    <p>Without repairs addressing these specific conditions, damage returns within 12-24 months. Hexagon's engineering accounts for all Texas-specific challenges.</p>
                    </div>

                    <hr class="my-5">

                    <h2>Critical Questions Answered</h2>

                    <div class="faq-section">
                        <h3>How do I know if my crack needs Hexagon's structural repair?</h3>

                        <h4>Structural cracks requiring immediate attention:</h4>
                        <ul style="margin-left: 10px">
                            <li>• Run through plaster AND gunite substrate</li>
                            <li>• Measure wider than 1/8 inch</li>
                            <li>• Show displacement or offset</li>
                            <li>• Display rust stains nearby</li>
                            <li>• Continue through tile line</li>
                            <li>• Leak water (any amount)</li>
                        </ul>

                        <h4>Cosmetic cracks (monitor only):</h4>
                        <ul style="margin-left: 10px">
                            <li>• Limited to plaster surface</li>
                            <li>• Hairline width (<1/16 inch)</li>
                            <li>• No water loss</li>
                            <li>• No rust staining</li>
                        </ul>
                        <br>
                        <p><strong>When uncertain:</strong> Hexagon's free professional assessment identifies 100% of structural issues. Call <a href="tel:972-702-7586">972-702-7586</a>.</p>
                    </div>

                    <div class="faq-section">
                        <h3>What about leak detection services?</h3>
                        <p>Hexagon partners with certified leak detection specialists for underground leaks. Once located, Hexagon handles all repairs. This two-expert approach ensures proper diagnosis and permanent repair.</p>
                        <p><strong>Hexagon's leak repair success rate:</strong> 98% first-time resolution</p>
                    </div>

                    <div class="faq-section">
                        <h3>How quickly can Hexagon complete repairs?</h3>
                        <h4>Standard Timeline:</h4>
                        <ul style="margin-left: 10px">
                            <li>• Day 1: Assessment and quote</li>
                            <li>• Day 2-3: Preparation and drainage (if needed)</li>
                            <li>• Day 3-7: Structural repair work</li>
                            <li>• Day 7-10: Curing and finishing</li>
                            <li>• Day 10: Pool refill and startup</li>
                        </ul>
                        <br>
                        <p>Most Hexagon repairs complete within 7-10 days. Emergency repairs available within 24-48 hours statewide.</p>
                    </div>

                    <div class="faq-section">
                        <h3>Will Hexagon's repairs withstand Texas conditions?</h3>
                        <p>Yes—when properly engineered. Hexagon designs every repair for Texas-specific challenges:</p>
                        <ul style="margin-left: 10px">
                            <li>• Deep-set anchors accommodate soil movement</li>
                            <li>• Flexible compounds handle temperature swings</li>
                            <li>• Proper drainage prevents hydraulic pressure</li>
                            <li>• Movement-tolerant materials prevent recracking</li>
                        </ul>
                        <br>
                        <p>Our 25-year warranty on fiberglass conversions guarantees performance.</p>
                    </div>

                    <div class="faq-section">
                        <h3>Does insurance cover Hexagon repairs?</h3>
                        <p>Often yes. Hexagon documents:</p>
                        <ul style="margin-left: 10px">
                            <li>• Storm and freeze damage (covered events)</li>
                            <li>• Tree root damage (typically covered)</li>
                            <li>• "Sudden failure" situations (not wear/tear)</li>
                            <li>• Ground movement (check policy)</li>
                        </ul>
                        <br>
                        <p>Hexagon works directly with adjusters. Our detailed documentation achieves 93% claim approval rate—highest in Texas.</p>
                    </div>

                    <div class="text-center mt-4 mb-5">
                        <a href="tel:972-702-7586" class="btn btn-primary btn-lg">
                            <i class="fas fa-file-invoice-dollar"></i> Start Insurance Claim → 972-702-7586
                        </a>
                    </div>

                    <hr class="my-5">

                    <h2>The True Cost of Delaying Repairs</h2>

                    <h3>Every Month Costs More Than Hexagon's Immediate Repair</h3>

                    <h4>Damage Progression Timeline:</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Delay Period</th>
                                    <th>Additional Damage</th>
                                    <th>Extra Cost</th>
                                    <th>Water Loss</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>30 days</strong></td>
                                    <td>20% progression</td>
                                    <td>$500-1,000</td>
                                    <td>3,000 gallons</td>
                                </tr>
                                <tr>
                                    <td><strong>90 days</strong></td>
                                    <td>Damage doubles</td>
                                    <td>$2,000-5,000</td>
                                    <td>13,500 gallons</td>
                                </tr>
                                <tr>
                                    <td><strong>6 months</strong></td>
                                    <td>Structural compromise</td>
                                    <td>$5,000-10,000</td>
                                    <td>54,000 gallons</td>
                                </tr>
                                <tr>
                                    <td><strong>12 months</strong></td>
                                    <td>Complete reconstruction</td>
                                    <td>$10,000-25,000</td>
                                    <td>182,500 gallons</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4>Daily Operating Losses Without Repair:</h4>
                    <ul style="margin-left: 10px">
                        <li>• Water: 100-500 gallons ($5-25/day)</li>
                        <li>• Chemicals: Wasted in leaking water ($3-10/day)</li>
                        <li>• Energy: Pumps running overtime ($5-15/day)</li>
                        <li>• <strong>Total Daily Loss: $13-50</strong></li>
                    </ul>

                    <p><strong>Monthly Impact:</strong> $390-1,500 in operating losses alone</p>
                    <br>
                    <div class="alert alert-danger">
                        <strong>Critical Point:</strong> Today's $2,000 Hexagon repair becomes next year's $10,000 reconstruction. Every week matters.
                    </div>

                    <div class="text-center mt-4 mb-5">
                        <a href="tel:972-702-7586" class="btn btn-danger btn-lg">
                            <i class="fas fa-stop-circle"></i> Stop Losses Today → 972-702-7586
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

                    <h2>Take Action: Schedule Your Hexagon Assessment</h2>

                    <h3>Step 1: Free Structural Evaluation</h3>
                    <p>Call <a href="tel:972-702-7586">972-702-7586</a> now for a comprehensive assessment:</p>
                    <ul style="margin-left: 10px">
                        <li>• 27-point structural inspection</li>
                        <li>• Photo documentation</li>
                        <li>• Written repair plan</li>
                        <li>• Insurance guidance</li>
                    </ul>

                    <h3>Step 2: Review Hexagon Solutions</h3>
                    <p>Receive a detailed proposal including:</p>
                    <ul style="margin-left: 10px">
                        <li>• Repair vs. replacement analysis</li>
                        <li>• Multiple solution options</li>
                        <li>• Warranty comparison</li>
                        <li>• Financing availability</li>
                        <li>• Timeline projection</li>
                    </ul>

                    <h3>Step 3: Hexagon Implementation</h3>
                    <p>Professional execution:</p>
                    <ul style="margin-left: 10px">
                        <li>• Dedicated project manager</li>
                        <li>• Daily progress updates</li>
                        <li>• Quality checkpoints</li>
                        <li>• Final inspection</li>
                        <li>• Warranty activation</li>
                    </ul>

                    <div class="text-center mt-5 mb-4">
                        <a href="tel:972-702-7586" class="btn btn-success btn-lg">
                            <i class="fas fa-clipboard-check"></i> Book Free Assessment Now → 972-702-7586
                        </a>
                    </div>

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
                                <input type="hidden" name="type" value="pool_repair_quote">
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
                                        <option value="pool-repair" {{ old('service') == 'pool-repair' ? 'selected' : '' }}>Pool Repair</option>
                                        <option value="pool-resurfacing-conversion" {{ old('service') == 'pool-resurfacing-conversion' ? 'selected' : '' }}>Pool Resurfacing & Conversion</option>
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
                                <p>Book your pool repair assessment this month and receive:</p>
                                <ul class="offer-list">
                                    <li>✓ <strong>$500 OFF</strong> any structural repair over $5,000</li>
                                    <li>✓ <strong>FREE</strong> 27-Point Inspection ($350 value)</li>
                                    <li>✓ <strong>0% Financing</strong> for 12 months (qualified buyers)</li>
                                    <li>✓ <strong>Emergency Repairs</strong> within 24-48 hours</li>
                                    <li>✓ <strong>Insurance Documentation</strong> included</li>
                                </ul>
                                <p class="text-center"><strong>Only 8 spots remaining for Q1 2026</strong></p>
                                <a href="tel:972-789-2983" class="cta-offer-button">
                                    <i class="fas fa-phone-alt"></i>
                                    <span class="button-text">Schedule Emergency Repair</span>
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
<!-- Pool Repair Main Content End -->

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
            <h2 class="cta-heading">Ready to Fix Your Pool Problems Permanently?</h2>

            <!-- Subheading -->
            <p class="cta-subheading">Join 173+ Dallas-Fort Worth homeowners who chose permanent repairs over temporary fixes</p>

            <!-- Value Props -->
            <div class="cta-value-props">
                <div class="value-item">
                    <i class="fas fa-calendar-check"></i>
                    <span><strong>8 Spots</strong> Remaining for Q1 2026</span>
                </div>
                <div class="value-item">
                    <i class="fas fa-tag"></i>
                    <span><strong>Save $500</strong> This Month Only</span>
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
                        <span class="btn-main-text">Call Now for Free Assessment</span>
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

<!-- Custom Styles for Pool Repair Page -->
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

/* FAQ Section */
.faq-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.faq-section h3 {
    color: #333;
    font-weight: 600;
    margin-bottom: 15px;
    font-size: 1.2rem;
}

.faq-section h4 {
    color: #444;
    font-weight: 600;
    margin-bottom: 10px;
    margin-top: 15px;
    font-size: 1rem;
}

.faq-section p {
    margin-bottom: 15px;
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
    .intro-section h1, .col-lg-12 h1 {
        font-size: 32px !important;
    }

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

@media (max-width: 576px) {
    .intro-section h1, .col-lg-12 h1 {
        font-size: 28px !important;
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

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}
</style>

@endsection