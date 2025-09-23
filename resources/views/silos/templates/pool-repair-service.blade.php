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
                        <li>✅ Dallas Based & Family Owned</li>
                    </ul>

                    <hr class="my-5">

                    <h3>Major & Minor Crack Repair</h3>
                    <p><strong>From hairline cracks to structural failures—we fix them all permanently.</strong></p>

                    <h4>Minor Surface Cracks</h4>
                    <ul>
                        <li>• Plaster crazing and checking</li>
                        <li>• Gel coat spider cracks (fiberglass)</li>
                        <li>• Cosmetic imperfections</li>
                        <li>• Surface-level repairs that prevent water penetration</li>
                    </ul>

                    <h4>Major Structural Cracks</h4>
                    <ul>
                        <li>• Through-wall cracks compromising integrity</li>
                        <li>• Cracks at stress points (skimmers, returns, lights)</li>
                        <li>• Separation at joints and seams</li>
                        <li>• Active leaks requiring immediate attention</li>
                    </ul>

                    <h4>Our Proven Repair Methods:</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Repair Type</th>
                                    <th>Application</th>
                                    <th>Investment</th>
                                    <th>Warranty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Surface Sealing</td>
                                    <td>Cosmetic cracks</td>
                                    <td>$500-1,500</td>
                                    <td>1 year</td>
                                </tr>
                                <tr>
                                    <td>Epoxy Injection</td>
                                    <td>Stable structural cracks</td>
                                    <td>$1,500-3,000</td>
                                    <td>3 years</td>
                                </tr>
                                <tr>
                                    <td>Torque Lock Staples</td>
                                    <td>Recurring/expanding cracks</td>
                                    <td>$3,000-6,000</td>
                                    <td>5 years</td>
                                </tr>
                                <tr class="table-info">
                                    <td><strong>Fiberglass Conversion</strong></td>
                                    <td><strong>Permanent solution</strong></td>
                                    <td><strong>Varies By Pool</strong></td>
                                    <td><strong>25 years</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-5">

                    <h3>Gunite & Plaster Structural Repair</h3>
                    <p>Gunite pools face unique challenges in North Texas. Our expansive soil and weather extremes cause:</p>
                    <ul>
                        <li>• Delamination (plaster separating from gunite)</li>
                        <li>• Spalling (surface deterioration)</li>
                        <li>• Pop-offs (circular areas of failed plaster)</li>
                        <li>• Hollow spots that crack under pressure</li>
                    </ul>

                    <h4>Complete Gunite Restoration Process:</h4>
                    <ol>
                        <li>Sound testing to identify all compromised areas</li>
                        <li>Complete removal of failed material</li>
                        <li>Structural substrate preparation</li>
                        <li>Professional bonding agent application</li>
                        <li>New gunite/shotcrete application (where needed)</li>
                        <li>Premium plaster finish</li>
                        <li>Proper curing and startup</li>
                    </ol>
                    <p><strong>Investment:</strong> $6,000-15,000 depending on pool size and damage extent</p>

                    <hr class="my-5">

                    <h3>Bond Beam Repair & Reconstruction</h3>
                    <p><strong>The critical repair most companies won't touch</strong></p>
                    <p>Your pool's bond beam—the reinforced concrete collar at the top edge—bears tremendous structural loads. When it fails, you need engineering expertise, not handyman repairs.</p>

                    <h4>Signs of Bond Beam Failure:</h4>
                    <ul>
                        <li>• Tile line cracks (horizontal through tiles)</li>
                        <li>• Loose or shifting coping stones</li>
                        <li>• Separation between deck and pool</li>
                        <li>• Visible gaps at pool edge</li>
                    </ul>

                    <h4>Our Bond Beam Reconstruction:</h4>
                    <ul>
                        <li>• Remove all compromised concrete</li>
                        <li>• Install new steel reinforcement with epoxy anchors</li>
                        <li>• Form and pour to engineering specifications</li>
                        <li>• Restore proper expansion joints (often missing)</li>
                        <li>• Waterproof membrane application</li>
                        <li>• New tile and coping installation</li>
                    </ul>
                    <p>This complex repair requires expertise most companies lack. We're one of only three contractors in Dallas properly equipped for bond beam reconstruction.</p>

                    <hr class="my-5">

                    <h3>Concrete Cancer (Alkali-Silica Reaction)</h3>
                    <p><strong>The progressive disease destroying older pools</strong></p>
                    <p>Concrete cancer occurs when moisture penetrates concrete, causing rebar to rust and expand. The expansion force—7x stronger than concrete—causes progressive failure that accelerates exponentially.</p>

                    <h4>Identification:</h4>
                    <ul>
                        <li>• Rust stains bleeding through plaster</li>
                        <li>• Concrete spalling (chunks breaking off)</li>
                        <li>• Exposed, corroding rebar</li>
                        <li>• Map cracking around rust points</li>
                        <li>• White calcium deposits (efflorescence)</li>
                    </ul>

                    <h4>Treatment Protocol:</h4>
                    <ul>
                        <li><strong>Early Stage</strong> ($2,500-5,000): Remove affected concrete, treat rebar, rebuild</li>
                        <li><strong>Advanced Stage</strong> ($5,000-12,000): Major reconstruction required</li>
                        <li><strong>Permanent Cure</strong> ($8,000-15,000): Fiberglass encapsulation stops it forever</li>
                    </ul>
                    <p class="alert alert-warning"><em>Warning: Delays cost 20% more every 6 months as damage spreads</em></p>

                    <hr class="my-5">

                    <h3>Fiberglass Pool Repair</h3>
                    <p><strong>Exclusive Fibre Tech expertise for permanent solutions</strong></p>
                    <p>As the ONLY certified Fibre Tech installer in North Texas, we repair fiberglass pools using exclusive technology and materials unavailable elsewhere.</p>

                    <h4>Fiberglass-Specific Repairs:</h4>
                    <ul>
                        <li>• Gel coat restoration and color matching</li>
                        <li>• Spider crack elimination</li>
                        <li>• Osmotic blister repair</li>
                        <li>• Structural fiberglass rebuilding</li>
                        <li>• Full refinishing for older pools</li>
                    </ul>

                    <h4>Why Convert to Fiberglass?</h4>
                    <ul>
                        <li>• Eliminates crack problems permanently</li>
                        <li>• Non-porous surface resists algae</li>
                        <li>• 40% less chemical usage</li>
                        <li>• Smooth, luxurious finish</li>
                        <li>• Flexibility prevents future cracking</li>
                        <li>• 25-year warranty (exclusive to Fibre Tech)</li>
                    </ul>

                    <hr class="my-5">

                    <h3>Pool Equipment & Plumbing Repair</h3>
                    <p><strong>Complete mechanical system restoration</strong></p>

                    <h4>Skimmer Replacement</h4>
                    <p>Cracked skimmers can't be patched—they need replacement:</p>
                    <ul>
                        <li>• Complete removal of damaged unit</li>
                        <li>• Structural integration with pool shell</li>
                        <li>• Proper height and level alignment</li>
                        <li>• Waterproof seal guaranteed</li>
                        <li>• Plaster integration for seamless finish</li>
                    </ul>

                    <h4>Equipment We Repair/Replace:</h4>
                    <ul>
                        <li>• Pool pumps and motors (all brands)</li>
                        <li>• Filter systems (sand, cartridge, DE)</li>
                        <li>• Plumbing and valves</li>
                        <li>• Returns and main drains</li>
                        <li>• Automation systems</li>
                    </ul>

                    <p class="alert alert-success"><strong>Energy Upgrade Special:</strong> New variable-speed pump saves 70% on electricity—pays for itself in 14 months.</p>

                    <hr class="my-5">

                    <h2>Why North Texas Pools Need Structural Repair</h2>

                    <h3>The Perfect Storm of Damage</h3>

                    <h4>Expansive Clay Soil</h4>
                    <p>Dallas sits on clay that expands 30% when wet, shrinks dramatically when dry. This creates:</p>
                    <ul>
                        <li>• 4,000 PSI of lateral pressure</li>
                        <li>• 2-6 inches of annual movement</li>
                        <li>• Differential settling</li>
                        <li>• Continuous stress on pool structures</li>
                    </ul>

                    <h4>Extreme Weather Cycles</h4>
                    <ul>
                        <li>• 105°F summers to 15°F winters</li>
                        <li>• 90+ freeze-thaw cycles annually</li>
                        <li>• Rapid 40°F temperature swings</li>
                        <li>• Drought-to-flood extremes</li>
                    </ul>

                    <h4>Construction Deficiencies (Found in 60% of Pools)</h4>
                    <ul>
                        <li>• Insufficient steel reinforcement</li>
                        <li>• Gunite thickness below standards</li>
                        <li>• Missing expansion joints</li>
                        <li>• Poor soil compaction</li>
                        <li>• Inadequate concrete coverage over rebar</li>
                    </ul>

                    <p>Without proper repair that addresses these conditions, damage returns quickly.</p>

                    <hr class="my-5">

                    <h2>Investment & Value</h2>

                    <h3>Clear Pricing Structure</h3>

                    <h4>Assessment & Evaluation</h4>
                    <ul>
                        <li>• Structural assessment: FREE with repair</li>
                        <li>• Insurance documentation: Included</li>
                        <li>• Detailed repair plan: No charge</li>
                    </ul>

                    <h4>Repair Investments</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Service Category</th>
                                    <th>Typical Range</th>
                                    <th>Complex Projects</th>
                                    <th>Warranty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Surface Repairs</strong></td>
                                    <td>$500-2,000</td>
                                    <td>$2,000-4,000</td>
                                    <td>1-2 years</td>
                                </tr>
                                <tr>
                                    <td><strong>Structural Cracks</strong></td>
                                    <td>$2,000-6,000</td>
                                    <td>$6,000-10,000</td>
                                    <td>3-5 years</td>
                                </tr>
                                <tr>
                                    <td><strong>Gunite Restoration</strong></td>
                                    <td>$6,000-10,000</td>
                                    <td>$10,000-15,000</td>
                                    <td>3 years</td>
                                </tr>
                                <tr>
                                    <td><strong>Bond Beam</strong></td>
                                    <td>$3,000-6,000</td>
                                    <td>$6,000-12,000</td>
                                    <td>5 years</td>
                                </tr>
                                <tr>
                                    <td><strong>Concrete Cancer</strong></td>
                                    <td>$2,500-8,000</td>
                                    <td>$8,000-15,000</td>
                                    <td>3-5 years</td>
                                </tr>
                                <tr>
                                    <td><strong>Equipment</strong></td>
                                    <td>$500-2,500</td>
                                    <td>$2,500-5,000</td>
                                    <td>1 year + MFG</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-5">

                    <h2>Proven Results from Dallas Neighbors</h2>

                    <div class="testimonial-section">
                        <div class="testimonial">
                            <h4>"Saved our pool and $40,000"</h4>
                            <p>"Three companies recommended complete replacement. Hexagon's structural repair with Torque Lock staples fixed everything for $5,500. Two years later, still perfect."</p>
                            <p class="text-muted">— <em>Michael Richardson, Highland Park</em></p>
                        </div>

                        <div class="testimonial">
                            <h4>"Finally fixed after 3 failed attempts"</h4>
                            <p>"Other companies just patched over concrete cancer. Hexagon explained the real problem and fixed it permanently with fiberglass. Should have called them first."</p>
                            <p class="text-muted">— <em>Tom Harrison, Richardson</em></p>
                        </div>

                        <div class="testimonial">
                            <h4>"Insurance covered everything"</h4>
                            <p>"Their documentation was so thorough, insurance approved our $9,200 claim immediately. Other companies couldn't even explain what was wrong."</p>
                            <p class="text-muted">— <em>Jennifer Kim, Frisco</em></p>
                        </div>
                    </div>

                    <hr class="my-5">

                    <h2>Common Questions</h2>

                    <h3>How do I know if my crack is structural?</h3>
                    <h4>Structural cracks:</h4>
                    <ul>
                        <li>• Run through plaster AND gunite</li>
                        <li>• Wider than 1/8 inch</li>
                        <li>• Show displacement or offset</li>
                        <li>• Have rust stains nearby</li>
                        <li>• Continue through tile line</li>
                        <li>• Leak water</li>
                    </ul>

                    <h4>Cosmetic cracks:</h4>
                    <ul>
                        <li>• Only in plaster surface</li>
                        <li>• Hairline width</li>
                        <li>• No water loss</li>
                        <li>• No rust staining</li>
                    </ul>
                    <p>When in doubt, get our free professional assessment. Call <a href="tel:972-789-2983">(972) 789-2983</a>.</p>

                    <h3>What about leak detection?</h3>
                    <p>We partner with certified leak detection specialists when underground leaks are suspected. Once they locate the leak, we handle all repairs. This two-step approach ensures you get the right expertise for each phase.</p>

                    <h3>How long do repairs take?</h3>
                    <h4>Typical timeline:</h4>
                    <ul>
                        <li>• Day 1: Assessment and quote</li>
                        <li>• Day 2-3: Preparation and drainage (if needed)</li>
                        <li>• Day 3-7: Structural repair work</li>
                        <li>• Day 7-10: Curing and finishing</li>
                        <li>• Day 10: Pool refill and startup</li>
                    </ul>
                    <p>Most repairs complete within 7-10 days, weather permitting.</p>

                    <h3>Will repairs last in Texas soil?</h3>
                    <p>Yes—when done correctly. We engineer every repair specifically for North Texas conditions:</p>
                    <ul>
                        <li>• Deep-set anchors for soil movement</li>
                        <li>• Flexible joint compounds</li>
                        <li>• Proper drainage solutions</li>
                        <li>• Movement-tolerant materials</li>
                    </ul>
                    <p>Our 25-year warranty on fiberglass conversions proves our confidence.</p>

                    <h3>Is this covered by insurance?</h3>
                    <p>Often, yes. We document:</p>
                    <ul>
                        <li>• Storm and freeze damage</li>
                        <li>• Tree root damage</li>
                        <li>• "Sudden failure" situations</li>
                        <li>• Ground movement (if covered)</li>
                    </ul>
                    <p>We work directly with adjusters and have a 93% approval rate on documented claims.</p>

                    <hr class="my-5">

                    <h2>The Cost of Waiting</h2>

                    <h3>Every Month of Delay Costs More</h3>
                    <ul>
                        <li><strong>30 days:</strong> 20% more damage, $500-1,000 additional cost</li>
                        <li><strong>90 days:</strong> Damage doubles, $2,000-5,000 additional cost</li>
                        <li><strong>6 months:</strong> Structural compromise, $5,000-10,000 additional cost</li>
                        <li><strong>1 year:</strong> Often requires complete reconstruction</li>
                    </ul>

                    <p>Plus daily losses:</p>
                    <ul>
                        <li>• Water: 100-500 gallons ($5-25/day)</li>
                        <li>• Chemicals: Wasted in leaking water ($3-10/day)</li>
                        <li>• Energy: Pumps running longer ($5-15/day)</li>
                        <li>• Property damage risk increasing daily</li>
                    </ul>

                    <p class="alert alert-danger"><strong>Bottom line:</strong> Today's $2,000 repair becomes next year's $10,000 reconstruction.</p>
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