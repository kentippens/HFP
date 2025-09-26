@extends('layouts.app')

@section('title', 'Pool Remodeling | Complete Pool Renovation | Dallas-Fort Worth')
@section('meta_description', 'Complete pool remodeling services in Dallas-Fort Worth. Update tiles, coping, equipment, and surfaces. Transform your pool with expert renovation. Free quote.')
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
            <h1>Pool Remodeling</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>Pool Remodeling</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Pool Remodeling Main Content Start -->
<section class="pool-resurfacing-section pt-5 pb-5" style="overflow: visible !important;">
    <div class="container">
        <!-- Hero Section -->
        <div class="intro-section mb-5">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-4">Transform Your Pool with Expert Tile & Coping Remodeling</h1>
                    <p class="lead"><strong>Is Your Outdated Pool Costing You Property Value Every Day?</strong></p>
                    <p class="lead">Cracked tiles, deteriorating coping stones, and dated designs aren't just eyesores—they're erasing thousands from your home's value while creating safety hazards for your family. In today's competitive Texas real estate market, an outdated pool can reduce your property value by $15,000-$25,000, while professionally remodeled pools with stunning tile work and custom designs add $25,000-$45,000 in market value.</p>
                    <br>
                    <p><strong>⚡ Spring Season Books Quickly - Schedule Early for Preferred Timing</strong></p>
                </div>
            </div>
        </div>

        <!-- Main Content and Sidebar -->
        <div class="row">
            <!-- Main Body Content -->
            <div class="col-lg-8">
                <div class="main-content">
                    <h2>Complete Pool Remodeling Services</h2>
                    <p>Welcome to Hexagon Fiberglass Pools, where we've completed extensive pool remodeling projects throughout North and Central Texas with stunning tile replacements, elegant coping upgrades, and custom tile designs that turn ordinary pools into extraordinary backyard masterpieces. While we're known for our exclusive Fibre Tech fiberglass installations, our <strong>pool remodeling expertise</strong> encompasses every aesthetic element that makes your pool truly spectacular.</p>

                    <div class="service-highlights mb-4">
                        <h3>Remodeling Services:</h3>
                        <ul>
                            <li>✅ Pool Tile Replacement & Custom Designs</li>
                            <li>✅ Coping Stone Installation & Repair</li>
                            <li>✅ Custom Pool Floor Mosaics</li>
                            <li>✅ Gelcoat Refinishing for Fiberglass Pools</li>
                            <li>✅ Water Feature Integration</li>
                        </ul>
                    </div>

                    <div class="why-choose mb-4">
                        <h3>Why Texas pool owners choose our remodeling services:</h3>
                        <ul>
                            <li>✅ Extensive experience in pool remodeling throughout Texas</li>
                            <li>✅ Custom tile design specialists for pool floors and features</li>
                            <li>✅ Premium material sourcing with professional installation</li>
                            <li>✅ Comprehensive warranties on all remodeling work</li>
                            <li>✅ Gelcoat refinishing expertise for existing fiberglass pools</li>
                        </ul>
                    </div>

                    <p>Whether you're dreaming of luminous glass tiles that capture sunlight, elegant natural stone coping that adds timeless sophistication, custom mosaic designs in your pool floor, or refreshing your existing fiberglass surface, we deliver remodeling results that exceed expectations and transform your entire pool experience.</p>
                    <br>
                    <p><em>*Pool remodeling typically provides positive return on investment | Typical completion: 8-12 days | Financing available with $0 down</em></p>

                    <hr class="my-5">

                    <h2>🚨 Warning Signs Your Pool Needs Tile & Coping Remodeling</h2>

                    <h3>Don't Let These Issues Cost You Thousands in Emergency Repairs</h3>

                    <div class="warning-sign mb-4">
                        <h4><b>Cracked or Missing Tiles</b> (Potential for Costly Repairs)</b></h4>
                        <p>When tiles crack or fall off, water infiltration begins immediately. Over time, this water damage can compromise your pool's structural integrity, leading to expensive shell repairs that cost significantly more than preventive tile replacement. Waterline tiles take the most abuse from chemical exposure and temperature changes.</p>
                    </div>

                    <div class="warning-sign mb-4">
                        <h4><b>Deteriorating Coping Stones (Liability Risk: High)</b></h4>
                        <p>Loose or cracked coping creates trip hazards that could result in serious injuries and potential lawsuits. Insurance companies increasingly scrutinize pool safety, and visible coping deterioration can affect coverage. Sharp edges from damaged coping can cause cuts and injuries to swimmers.</p>
                    </div>

                    <div class="warning-sign mb-4">
                        <h4><b>Outdated or Damaged Pool Floor Tiles</b></h4>
                        <p>Cracked, loose, or missing tiles in your pool floor create rough surfaces that harbor algae and bacteria while making swimming uncomfortable. These issues often start small but spread quickly, requiring increasingly expensive repairs the longer they're ignored.</p>
                    </div>

                    <div class="warning-sign mb-4">
                        <h4><b>Faded or Damaged Gelcoat on Fiberglass Pools</b></h4>
                        <p>If you have an existing fiberglass pool with a surface that looks chalky, has visible wear patterns, or shows discoloration, gelcoat refinishing can restore its original beauty at a fraction of replacement cost.</p>
                    </div>

                    <div class="alert alert-warning">
                        <p><strong>⏰ Age Factor: 10+ Year Consideration Zone</strong></p>
                        <p>Pools over 10 years old typically require major tile and coping updates. Waiting beyond 15 years often means more expensive emergency repairs compared to planned renovations.</p>
                    </div>

                    <div class="cta-box text-center mb-4">
                        <h3>🔍 GET YOUR FREE POOL REMODELING ASSESSMENT</h3>
                        <p><em>Includes Tile, Coping, and Design Consultation | No Obligation</em></p>
                    </div>

                    <hr class="my-5">
                    <h2>✨ Premium Pool Tile Replacement: Our Remodeling Specialization</h2>

                    <h3>Transform Your Pool with Stunning Tile Solutions & Custom Designs</h3>

                    <p><strong>Why Our Tile Installations Last 25+ Years While Others Fail in 5-7</strong></p>
                    <br>
                    <p>Our three-layer waterproofing system and pool-specific adhesives create permanent bonds that withstand chemical exposure, temperature swings, and constant submersion—conditions that destroy standard installations. Combined with our expertise in custom tile design, we create pools that are both beautiful and built to last.</p>

                    <div class="tile-option mb-4">
                        <h3>Glass Tile Excellence: The Ultimate Pool Upgrade</h3>
                        <p><strong>✨ Iridescent Glass Tiles</strong> create mesmerizing light effects that change throughout the day.</p>                        
                        <ul style="margin-left: 3%; padding: 10px;">                            
                            <li><strong>Lifespan</strong>: 30+ years with minimal maintenance</li>
                            <li><strong>Special Features</strong>: UV-resistant, chemical-proof, easy cleaning</li>
                            <li><strong>Best For</strong>: Luxury homes, waterline applications, feature walls</li>
                        </ul>
                        <p>Our clients consistently report that glass tile installations become neighborhood showpieces and significantly enhance their pool's visual appeal.</p>
                    </div>

                    <div class="tile-option mb-4">
                        <h3>Porcelain & Ceramic: Maximum Value Solutions</h3>
                        <p>Modern porcelain tiles offer luxury aesthetics at accessible prices, with advanced manufacturing creating designs that rival natural stone.</p>
                        <ul style="margin-left: 3%; padding: 10px;">                            
                            <li><strong>Durability</strong>: 15-20 years typical lifespan</li>
                            <li><strong>Maintenance</strong>: Minimal - weekly brushing sufficient</li>
                            <li><strong>Popular Styles</strong>: Wood-look, marble, geometric patterns</li>
                        </ul>
                    </div>

                    <div class="tile-option mb-4">
                        <h3>Natural Stone: Timeless Elegance</h3>
                        <p>Travertine, granite, and limestone bring authentic luxury that appreciates in value over time.</p>
                        <ul style="margin-left: 3%; padding: 10px;">                            
                            <li><strong>Character</strong>: Each stone unique with natural variations</li>
                            <li><strong>Temperature</strong>: Stays cooler than synthetic options</li>
                            <li><strong>Value</strong>: Highest resale appeal in luxury markets</li>
                        </ul>
                    </div>

                    <div class="remodeling-service mb-4">
                        <h3>Custom Pool Floor Tile Designs</h3>
                        <p><strong>Transform Your Pool Floor into Art</strong></p>
                        <p>Our custom mosaic installations create unique focal points that reflect your personality:</p>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li><strong>Family Crests & Monograms</strong>: Personalized designs that make your pool truly yours</li>
                            <li><strong>Geometric Patterns</strong>: Modern designs that complement contemporary architecture</li>
                            <li><strong>Sports Themes</strong>: Team logos, mascots, and athletic motifs</li>
                            <li><strong>Nature-Inspired</strong>: Dolphins, sea life, compass roses, and nautical themes</li>
                            <li><strong>Abstract Art</strong>: Custom artistic expressions in durable tile</li>
                        </ul>
                        <p><strong>Design Process</strong>: Our artists work with you to create sketches, select materials, and plan installation for maximum visual impact.</p>
                    </div>

                    <p><em>*Call to Get pricing for your exact pool size | Compare material options | See custom design examples</em></p>

                    <hr class="my-5">

                    <h2>🏛️ Coping Stone Mastery: Safety Meets Sophistication</h2>

                    <h3>Professional Coping That Protects Your Investment</h3>

                    <p>Your pool's coping does more than look good—it's your first line of defense against water damage and a critical safety feature for swimmers. Our coping replacement expertise transforms this essential element from a maintenance concern into a design opportunity that enhances both your pool's appearance and your property's overall appeal.</p>
                    <br>
                    <p><strong>📊 Did You Know?</strong> Properly installed coping prevents significant pool deck water damage while reducing slip-and-fall incidents through improved safety features.</p>

                                       
                    <div class="coping-option mb-4">                                          
                        <h3>Premium Natural Stone Options</h3>

                        <h4>Flagstone Coping | The Texas Standard</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Natural variations create unique character</li>
                            <li>Excellent heat resistance for Texas climate</li>
                            <li>Rustic elegance perfect for natural settings</li>
                            <li>Easy replacement of individual stones</li>
                        </ul>

                        <h4>Travertine Coping</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Non-slip surface even when wet</li>
                            <li>Stays cool under direct Texas sunlight</li>
                            <li>Complements any architectural style</li>
                            <li>25-year lifespan with proper maintenance</li>
                        </ul>

                        <h4>Granite Coping</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Exceptional durability and scratch resistance</li>
                            <li>Available in 15+ colors and finishes</li>
                            <li>Minimal maintenance requirements</li>
                            <li>Premium appearance that impresses guests</li>
                        </ul>                        
                    </div>

                    <div class="coping-option mb-4">
                        <h3>Budget-Friendly Alternatives That Don't Compromise Quality</h3>

                        <h4>Precast Concrete Coping</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Custom colors to match home architecture</li>
                            <li>Consistent dimensions for perfect installation</li>
                            <li>Modern profiles and edge treatments</li>
                            <li>Excellent value with professional appearance</li>
                        </ul>

                        <h4>Brick & Paver Coping</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Easy replacement of individual units</li>
                            <li>Classic or modern styling options</li>
                            <li>Excellent slip resistance</li>
                            <li>Perfect for traditional home styles</li>
                        </ul>
                    </div>

                    <div class="installation-process mb-4">
                        <h3>Our Professional Installation Process</h3>
                        <p style="margin-left: 1.5%; padding: 5px;">
                            <strong>Step 1</strong>: Precision removal of existing materials<br>
                            <strong>Step 2</strong>: Substrate preparation and leveling<br>
                            <strong>Step 3</strong>: Waterproof membrane installation<br>
                            <strong>Step 4</strong>: Professional coping placement with premium adhesives<br>
                            <strong>Step 5</strong>: Joint sealing and final finishing
                        </p>
                        <br>
                        <p><strong>Guarantee</strong>: All coping installations include 5-Year Structural Warranty</p>
                    </div>

                    <hr class="my-5">

                    <h2>Complete Pool Remodeling: Comprehensive Transformation Solutions</h2>

                    <h3>Beyond Tile and Coping: Full Pool Makeovers</h3>

                    <p><strong>Why Comprehensive Remodeling Delivers Maximum Value</strong></p>
                    <p>Individual updates over time can be significantly more expensive than coordinated remodeling projects, often resulting in inconsistent results and ongoing disruption. Our complete remodeling approach addresses all aesthetic and functional elements simultaneously for cohesive, stunning results.</p>

                    <div class="remodeling-service mb-4">
                        <h3>Gelcoat Refinishing for Existing Fiberglass Pools</h3>
                        <p><strong>Restore Your Fiberglass Pool's Original Beauty</strong></p>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Professional spray application for factory-quality finish</li>
                            <li>Color matching and custom tinting available</li>
                            <li>Repair surface damage, scratches, and wear patterns</li>
                            <li>Investment: Fraction of replacement cost</li>
                            <li>Extends surface life by 15-20 years</li>
                        </ul>
                        <br>
                        <p><strong>Signs Your Fiberglass Pool Needs Refinishing:</strong></p>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Chalky or faded appearance</li>
                            <li>Visible wear patterns or scratches</li>
                            <li>Loss of original color vibrancy</li>
                            <li>Surface roughness in high-traffic areas</li>
                        </ul>
                    </div>                    

                    <div class="remodeling-service mb-4">
                        <h3>Water Feature Integration</h3>
                        <p><strong>Popular 2025 Additions:</strong></p>
                        <ul>
                            <li>🌊 Spillover spas and hot tub connections</li>
                            <li>💡 LED-lit bubblers and fountains</li>
                            <li>⛲ Deck jets for interactive water play</li>
                            <li>🔥 Fire bowls and fire features for ambiance</li>
                        </ul>
                    </div>

                    <div class="remodeling-service mb-4">
                        <h3>Equipment & Technology Upgrades</h3>

                        <h4>Smart Pool Automation</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Smartphone-controlled lighting, heating, and cleaning</li>
                            <li>Energy monitoring that reduces costs by 35%</li>
                            <li>Remote water chemistry management</li>
                            <li>Smart scheduling for optimal efficiency</li>
                        </ul>

                        <h4>LED Lighting Systems</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Significant energy reduction compared to traditional lighting</li>
                            <li>Unlimited color options with app control</li>
                            <li>50,000+ hour lifespan</li>
                            <li>Dramatic nighttime ambiance enhancement</li>
                        </ul>

                        <h4>Energy-Efficient Equipment</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Variable speed pumps (substantial energy savings)</li>
                            <li>Salt water conversion systems</li>
                            <li>Advanced filtration upgrades</li>
                            <li>Smart chemical automation systems</li>
                        </ul>
                    </div>

                    <div class="remodeling-service mb-4">
                        <h3>Deck & Surrounding Area Coordination</h3>
                        <p><strong>Seamless Integration Services</strong></p>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Work with trusted partners for complete outdoor living spaces</li>
                            <li>Stamped concrete, pavers, and natural stone options</li>
                            <li>Coordinated color schemes and material selection</li>
                            <li>Proper drainage and safety considerations</li>
                        </ul>
                    </div>

                    <hr class="my-5">

                    <h2>Our Proven Pool Remodeling Process</h2>

                    <h3>From Consultation to Completion: What to Expect</h3>

                    <div class="process-timeline">
                        <h4>Step 1: Free Comprehensive Pool Assessment (Day 1)</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>90-minute on-site evaluation of existing tile and coping</li>
                            <li>Custom design consultation for floor tiles and features</li>                            
                            <li>Detailed written proposal with material options and pricing</li>
                        </ul>

                        <h4>Step 2: Design Development & Material Selection (Days 2-4)</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Tile and coping material selection with samples</li>
                            <li>Custom design approval for pool floor work</li>
                            <li>Equipment upgrade recommendations</li>
                            <li>Contract finalization and project scheduling</li>
                        </ul>

                        <h4>Step 3: Professional Site Preparation (Day 5)</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Pool draining if needed for extensive work</li>
                            <li>Equipment and furniture protection</li>
                            <li>Access preparation for materials and crews</li>                            
                        </ul>

                        <h4>Step 4: Demolition & Surface Preparation (Days 6-7)</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Careful removal of existing tiles and coping</li>
                            <li>Surface cleaning and preparation for new installations</li>
                            <li>Structural repairs if needed (cracks, bond beam issues)</li>
                            <li>Quality control inspection before new material installation</li>
                        </ul>

                        <h4>Step 5: Waterproofing & Substrate Preparation (Day 8)</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Advanced waterproofing membrane installation</li>
                            <li>Surface leveling and smoothing</li>
                            <li>Expansion joint preparation</li>
                            <li>Final substrate inspection and approval</li>
                        </ul>

                        <h4>Step 6: Professional Tile & Coping Installation (Days 9-12)</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Precision tile installation with pool-rated adhesives</li>
                            <li>Custom mosaic work for floor designs</li>
                            <li>Professional coping placement and leveling</li>
                            <li>Daily progress updates with photos</li>
                        </ul>

                        <h4>Step 7: Finishing & Final Inspection (Day 13)</h4>
                        <ul style="margin-left: 1.5%; padding: 5px;">
                            <li>Grouting and sealing with premium materials</li>
                            <li>Final cleaning and polishing</li>
                            <li>Pool refilling and equipment startup (if drained)</li>
                            <li>Customer walkthrough and warranty documentation</li>
                        </ul>
                    </div>

                    <p><strong>*Average Timeline: 8-13 business days (depending on scope)</strong><br>                    

                    <hr class="my-5">
                    <h2>Your Pool Remodeling Questions Answered</h2>

                    <h3>Expert Insights from Our Certified Specialists</h3>

                    <div class="faq-section">
                        <p><strong>Q: How long does pool tile replacement typically take?</strong><br>
                        <strong>A:</strong> Most residential projects complete in 8-12 days. Waterline-only replacements take 3-4 days, while full-pool retiling requires 10-14 days. Weather and complexity can affect timing, but we provide guaranteed completion dates with every contract.</p>

                        <p><strong>Q: Can I replace just the waterline tiles?</strong><br>
                        <strong>A:</strong> Absolutely! Waterline replacement is one of our most popular services. This targeted approach works perfectly when the main pool surface remains in good condition.</p>

                        <p><strong>Q: Will my property value really increase?</strong><br>
                        <strong>A:</strong> Many of our clients report positive impacts on their property values following professional pool remodeling. Quality tile work, custom designs, and updated coping typically enhance a pool's appeal to potential buyers. The actual value increase depends on many factors including your local market, the scope of work completed, and current real estate conditions. We can provide references and documentation from completed projects to support professional appraisals when needed.</p>

                        <p><strong>Q: What makes pool tiles different from regular tiles?</strong><br>
                        <strong>A:</strong> Pool tiles withstand constant water immersion, chemical exposure, and temperature fluctuations. They feature specialized glazes, lower absorption rates, and enhanced slip resistance. Regular tiles fail quickly in pool environments.</p>

                        <p><strong>Q: How often should coping be replaced?</strong><br>
                        <strong>A:</strong> Quality coping lasts 15-25 years with proper maintenance. Replace when you notice cracks, movement, rough edges, or visible deterioration. Proactive replacement prevents expensive structural damage.</p>

                        <p><strong>Q: Do you offer financing?</strong><br>
                        <strong>A:</strong> Yes! We provide $0-down financing with 12-month same-as-cash options and extended terms up to 24 months. Most clients qualify, and decisions are made within 24 hours.</p>

                        <p><strong>Q: What's your warranty coverage?</strong><br>
                        <strong>A:</strong> We provide 10-year structural warranties on installations and 5-year labor warranties. This comprehensive coverage protects your investment completely.</p>

                        <p><strong>Q: Can you work around my pool season?</strong><br>
                        <strong>A:</strong> We schedule projects year-round, though spring/early summer books fastest. Fall and winter scheduling often provides cost advantages and faster completion due to lower demand.</p>
                    </div>

                    <hr class="my-5">

                    <h2>Service Areas: Excellence Delivered Across Texas</h2>

                    <h3>Proudly Serving North and Central Texas with Consistent Quality</h3>

                    <div class="service-areas mb-4">
                        <h4><strong>Primary Service Zone</strong></h4>
                        <ul>
                            <li><strong>North Texas</strong>: Dallas, Plano, Frisco, McKinney, Allen, Richardson, Carrollton, Lewisville</li>
                            <li><strong>Central Texas</strong>: Austin, Round Rock, Cedar Park, Georgetown, Pflugerville, Leander</li>
                        </ul>                       
                    </div>

                    <div class="service-areas mb-4">
                        <h4><strong>Extended Service Areas</strong></h4>
                        <ul>
                            <li><strong>East Texas</strong>: Tyler, Longview, Marshall</li>
                            <li><strong>West Texas</strong>: Abilene, Midland, Lubbock</li>
                            <li><strong>South Texas</strong>: San Antonio, New Braunfels, San Marcos</li>
                        </ul>
                        <br>
                        <p>Same quality standards and 25-year warranty apply</p>
                        <p>Project coordination for optimal scheduling efficiency</p>
                    </div>

                    <div class="service-areas mb-4">
                        <h4>Texas-Specific Expertise Includes:</h4>
                        <ul>
                            <li>✅ Extreme heat resistance installation techniques</li>
                            <li>✅ Freeze protection for occasional winter conditions</li>
                            <li>✅ Local water chemistry optimization (hard water areas)</li>
                            <li>✅ HOA and municipal compliance throughout Texas</li>
                            <li>✅ Energy efficiency recommendations for Texas climate</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h4>Dallas-Fort Worth Metroplex Coverage:</h4>
                            <ul>
                                <li><strong>Dallas County</strong>: Complete coverage</li>
                                <li><strong>Collin County</strong>: Complete coverage</li>
                                <li><strong>Denton County</strong>: Complete coverage</li>
                                <li><strong>Tarrant County</strong>: Selected areas</li>
                                <li><strong>Rockwall County</strong>: Complete coverage</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4>Austin Metropolitan Area Coverage:</h4>
                            <ul>
                                <li><strong>Travis County</strong>: Complete coverage</li>
                                <li><strong>Williamson County</strong>: Complete coverage</li>
                                <li><strong>Hays County</strong>: Selected areas</li>
                            </ul>
                        </div>
                    </div>
                    <br>
                    <p><em>*Note: As the exclusive Fibre Tech dealer in North and Central Texas, we're the only authorized installer of this premium fiberglass system in our region.</em></p>


                    <hr class="my-5">

                    <h2>Why Choose Hexagon for Pool Remodeling?</h2>

                    <h3>Complete Pool Transformation Experts</h3>

                    <div class="row why-hexagon-section">
                        <div class="col-md-6">
                            <h4 style="color: #043f88;">Pool Remodeling Excellence</h4>
                            <ul class="feature-list">
                                <li>• Expert tile installation specialists</li>
                                <li>• Premium coping stone craftsmen</li>
                                <li>• Custom mosaic design capabilities</li>
                                <li>• Gelcoat refinishing for fiberglass pools</li>
                            </ul>

                            <h4 style="color: #043f88;">Industry Leadership</h4>
                            <ul class="feature-list">
                                <li>• CPO Certified professionals</li>
                                <li>• Pool & Hot Tub Alliance member</li>
                                <li>• Texas Licensed Contractors</li>
                                <li>• $2M liability insurance</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4 style="color: #043f88;">Local Expertise</h4>
                            <ul class="feature-list">
                                <li>• Hundreds of successful pool remodeling projects</li>
                                <li>• Dallas-based, family-owned</li>
                                <li>• Understand Texas pool challenges</li>
                                <li>• Experienced with local permits</li>
                            </ul>

                            <h4 style="color: #043f88;">Proven Results</h4>
                            <ul class="feature-list">
                                <li>• 98% customer satisfaction</li>
                                <li>• 5.0 star average rating</li>
                                <li>• 10-year structural warranties</li>
                                <li>• Premium material sourcing</li>
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
                                <input type="hidden" name="type" value="pool_remodeling_quote">
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
                                        <option value="tile-replacement" {{ old('service') == 'tile-replacement' ? 'selected' : '' }}>Tile Replacement</option>
                                        <option value="coping-installation" {{ old('service') == 'coping-installation' ? 'selected' : '' }}>Coping Installation</option>
                                        <option value="pool-remodeling" {{ old('service') == 'pool-remodeling' ? 'selected' : '' }}>Complete Pool Remodeling</option>
                                        <option value="gelcoat-refinishing" {{ old('service') == 'gelcoat-refinishing' ? 'selected' : '' }}>Gelcoat Refinishing</option>
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
                                <h4>Spring 2025 Special - Pool Remodeling</h4>
                                <p>Book your pool remodeling consultation this month and receive:</p>
                                <ul class="offer-list">
                                    <li>✓ <strong>$500 OFF</strong> tile & coping remodeling</li>
                                    <li>✓ <strong>FREE</strong> Design Consultation ($300 value)</li>
                                    <li>✓ <strong>0% Financing</strong> for 12 months (qualified buyers)</li>
                                    <li>✓ <strong>Priority Scheduling</strong> for spring completion</li>
                                    <li>✓ <strong>Custom Floor Design</strong> included with full remodeling</li>
                                </ul>
                                <p class="text-center"><strong>Spring season books quickly - reserve your spot now</strong></p>
                                <a href="tel:972-789-2983" class="cta-offer-button">
                                    <i class="fas fa-phone-alt"></i>
                                    <span class="button-text">Get Your Free Quote</span>
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
<!-- Pool Remodeling Main Content End -->

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
            <h2 class="cta-heading">Ready to Transform Your Pool with Expert Remodeling?</h2>

            <!-- Subheading -->
            <p class="cta-subheading">Join hundreds of Dallas-Fort Worth homeowners who've upgraded their pools with stunning tile and coping work</p>

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