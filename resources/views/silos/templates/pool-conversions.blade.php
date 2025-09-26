@extends('layouts.app')

@section('title', 'Pool Conversion Services Texas | Transform to Fiberglass | 25-Year Warranty')
@section('meta_description', 'Convert your concrete, gunite, marcite, or vinyl liner pool to durable fiberglass in just 7-10 days with professional pool conversion services and a 25-year warranty.')
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
            <h1>Pool Conversions</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>Pool Conversions</span>
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
                    <h1 class="mb-4">Pool Conversion Services Texas | Transform Your Existing Pool to Fiberglass</h1>
                    <p class="lead"><strong>Convert your concrete, gunite, marcite, or vinyl liner pool to durable fiberglass in just 7-10 days with professional pool conversion services and a 25-year warranty.</strong></p>
                </div>
            </div>
        </div>

        <!-- Main Content and Sidebar -->
        <div class="row">
            <!-- Main Body Content -->
            <div class="col-lg-8">
                <div class="main-content">
                    <h2>How Much Does Pool Conversion Cost? Texas Pool Owners Discover the Smart Alternative</h2>
                    <p>Every weekend, you face the same frustrating routine: testing water chemistry, adding expensive chemicals, scrubbing algae stains, and dealing with a pool surface so rough it's uncomfortable to swim in.</p>

                    <p><strong>You're not alone in this struggle.</strong></p>

                    <p>Pool maintenance experts report that DIY pool care typically requires 3-8 hours of weekly maintenance during swimming season – time that could be spent actually enjoying your pool with family and friends.</p>

                    <p>But here's what's exciting: <strong>Hundreds of smart Texas families have discovered a permanent solution that cuts maintenance time by up to 70% and transforms their problem pools into the backyard oasis they always wanted.</strong></p>

                    <div class="text-center my-4">
                        <a href="tel:972-789-2983" class="btn btn-primary btn-lg">📞 Get Your Free Pool Assessment - Call 972-789-2983</a>
                    </div>

                    <h3>Pool Conversion vs Pool Replacement: Why Smart Texas Homeowners Choose Conversion:</h3>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Timeline:</strong> 7-10 days (not months like pool replacement)</li>
                        <li><strong>Warranty:</strong> 25 years with Fibre Tech system</li>
                        <li><strong>Maintenance Reduction:</strong> Up to 70% less weekly maintenance time*</li>
                        <li><strong>Cost:</strong> Fraction of pool replacement investment</li>
                        <li><strong>Availability:</strong> Serving Dallas-Fort Worth, Austin, San Antonio and surrounding Texas areas</li>
                    </ul>

                    <hr class="my-5">

                    <h2>What Is Pool Conversion? Pool Resurfacing vs Pool Replacement</h2>

                    <h3>Pool Conversion Process Explained</h3>
                    <p>Pool conversion is the process of transforming your existing concrete, gunite, marcite, plaster, or vinyl liner pool into a smooth, durable fiberglass surface without the need for excavation or starting over. This pool renovation method is also known as pool resurfacing with fiberglass, and it's revolutionizing how Texas pool owners approach pool remodeling.</p>

                    <p>Unlike complete pool replacement, which requires tearing out your entire pool and rebuilding from scratch, our pool conversion process works with your existing pool structure. We create a custom fiberglass shell by hand to fit your current pool's exact shape and dimensions.</p>

                    <h3>Who Needs Pool Conversion Services?</h3>
                    <p>Pool conversion is perfect for Texas homeowners whose pools are experiencing:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Surface Problems:</strong> Staining, algae buildup, rough textures that hurt bare feet</li>
                        <li><strong>Maintenance Nightmares:</strong> Constant chemical balancing, weekly cleaning, acid washing</li>
                        <li><strong>Structural Issues:</strong> Minor cracks, chips, or surface deterioration</li>
                        <li><strong>High Costs:</strong> Spending $150+ monthly on chemicals and maintenance</li>
                        <li><strong>Aesthetic Concerns:</strong> Outdated appearance, faded colors, permanent stains</li>
                    </ul>

                    <p><strong>The bottom line:</strong> If your pool works but doesn't bring you joy anymore, pool conversion might be your answer.</p>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">🏡 Schedule Your Free On-Site Assessment Today</a>
                    </div>

                    <h3>Pool Conversion Contractors in Texas: Types of Pool Conversions We Specialize In</h3>

                    <h4><strong>Convert Concrete Pool to Fiberglass</strong></h4>
                    <p>Concrete and gunite pool conversion is our specialty. Concrete and gunite pools are notorious for their porous surfaces that harbor algae and bacteria. The rough texture is harsh on skin and swimwear, while the alkaline concrete constantly throws off your water chemistry.</p>
                    <p><strong>Our gunite pool conversion solution:</strong> We transform your concrete pool into a smooth, non-porous fiberglass surface that's gentle on skin and resistant to algae growth.</p>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-primary">🔧 Convert Your Concrete Pool - Get Started Today</a>
                    </div>

                    <h4><strong>Convert Marcite Pool to Fiberglass</strong></h4>
                    <p>Marcite and plaster pool resurfacing with fiberglass is increasingly popular in Texas. Marcite and plaster surfaces deteriorate over time, becoming rough and stained. They require frequent acid washing and traditional resurfacing, making them expensive to maintain.</p>
                    <p><strong>Our marcite pool conversion solution:</strong> Replace your failing marcite with a durable fiberglass surface that maintains its smooth finish and vibrant color for decades.</p>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-primary">✨ Transform Your Marcite Pool - Free Assessment</a>
                    </div>

                    <h4><strong>Convert Vinyl Liner Pool to Fiberglass</strong></h4>
                    <p>Vinyl liner pool conversion eliminates the need for recurring liner replacements. Vinyl liners need replacement every 7-10 years, and they're susceptible to tears, fading, and wrinkles. The recurring replacement costs add up quickly.</p>
                    <p><strong>Our vinyl liner conversion solution:</strong> Eliminate liner replacements forever with a permanent fiberglass surface that flexes with ground movement and resists damage.</p>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-primary">🎯 End Liner Replacements Forever - Call Now</a>
                    </div>

                    <hr class="my-5">

                    <h2>Why Choose Professional Pool Conversion Services? The Hexagon Fiberglass Difference</h2>

                    <h3>Best Pool Conversion Company Texas: Hand-Crafted Excellence</h3>
                    <p>While other pool conversion contractors install pre-manufactured fiberglass shells (which often don't fit existing pools properly), we take a completely different approach. <strong>We create your fiberglass surface by hand, custom-fitted to your pool's exact dimensions and unique features.</strong></p>

                    <p>This means:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Perfect Fit:</strong> No awkward gaps or compromises</li>
                        <li><strong>Preserved Features:</strong> Keep your existing steps, benches, and custom shapes</li>
                        <li><strong>Superior Quality:</strong> Hand-laid fiberglass is stronger than mass-produced shells</li>
                        <li><strong>Unlimited Design Options:</strong> We're not limited by pre-made shell availability</li>
                    </ul>

                    <h3>Exclusive Fibre Tech Pool Conversion System</h3>
                    <p>Hexagon Fiberglass Pools is the exclusive Fibre Tech dealer for North and Central Texas, with expansion planned statewide. This exclusive partnership means:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Advanced Technology:</strong> Access to the latest fiberglass innovations</li>
                        <li><strong>Superior Materials:</strong> Premium resins and reinforcements not available elsewhere</li>
                        <li><strong>Expert Training:</strong> Our team is certified in Fibre Tech installation techniques</li>
                        <li><strong>Comprehensive Warranty:</strong> 25-year coverage backed by both Hexagon and Fibre Tech</li>
                    </ul>

                    <h3>Industry-Leading Pool Conversion Warranty</h3>
                    <p>We stand behind our pool conversion work with one of the longest warranties in the pool industry. Our 25-year Fibre Tech warranty covers:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Structural integrity of the fiberglass surface</li>
                        <li>Delamination and blistering</li>
                        <li>Osmosis protection</li>
                        <li>Color fade resistance</li>
                    </ul>

                    <p><strong>This isn't just a warranty – it's our commitment to your family's enjoyment for decades to come.</strong></p>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-primary">📋 Learn About Our Industry-Leading Warranty</a>
                    </div>

                    <h3>How Long Does Pool Conversion Take? Rapid 7-10 Day Completion**</h3>
                    <p><em>*Typical timeline. Actual completion time may vary based on pool size, condition, weather, and scope of work.</em></p>

                    <p>While pool replacement can take months, our pool conversion process typically takes just 7-10 days from start to finish. This means:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Minimal Disruption:</strong> Your pool is back in service quickly</li>
                        <li><strong>Less Stress:</strong> No extended construction period</li>
                        <li><strong>Faster Results:</strong> Start enjoying your "new" pool immediately</li>
                        <li><strong>Weather Independence:</strong> Shorter timeline reduces weather-related delays</li>
                    </ul>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-primary">⚡ Experience the Hexagon Difference - Book Your Assessment</a>
                    </div>

                    <hr class="my-5">

                    <h2>The Life-Changing Benefits of Fiberglass Pool Conversion</h2>

                    <h3>Maintenance Revolution: Dramatically Less Work</h3>
                    <p>The single biggest reason Texas families choose pool conversion is the significant reduction in maintenance. Here's what typically changes based on our customer feedback:</p>

                    <h4>Chemical Usage:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Before:</strong> 3-5 lbs of chlorine weekly, constant pH adjustments</li>
                        <li><strong>After:</strong> 1-2 lbs of chlorine weekly, more stable water chemistry</li>
                    </ul>

                    <h4>Cleaning Requirements:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Before:</strong> Weekly brushing, periodic acid washing, regular resurfacing</li>
                        <li><strong>After:</strong> Light cleaning as needed, no brushing required</li>
                    </ul>

                    <h4>Time Investment:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Before:</strong> 4-8 hours weekly maintenance</li>
                        <li><strong>After:</strong> 1-3 hours weekly maintenance</li>
                    </ul>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-primary">💸 Stop Wasting Money - Get Your Free Quote Now</a>
                    </div>

                    <h3>Cost Savings That Add Up</h3>
                    <p>Converting to fiberglass doesn't just save time – it can provide significant long-term savings:</p>

                    <h4>Typical Annual Savings (Based on Customer Reports):</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Chemicals:</strong> $800-1,200 annually (reduced usage)</li>
                        <li><strong>Professional Cleaning:</strong> $600-1,200 annually (if you hire help)</li>
                        <li><strong>Energy:</strong> $150-300 annually (improved efficiency)</li>
                        <li><strong>Surface Repairs:</strong> $300-800 annually (fewer issues)</li>
                    </ul>

                    <p><strong>Estimated Total Annual Savings:</strong> $1,850-3,500*</p>
                    <p><strong>Over 10 years, many customers report saving $15,000-25,000</strong> compared to maintaining their original surface, though individual results vary based on pool size, usage, and local costs.</p>
                    <p class="text-muted"><small>*Savings estimates based on customer surveys and vary by pool size, condition, and maintenance habits. Individual results may differ.</small></p>

                    <div class="text-center my-4">
                        <a href="tel:972-789-2983" class="btn btn-primary">📞 Get Your Personalized Savings Estimate - Free Consultation</a>
                    </div>

                    <h3>Durability Built for Texas</h3>
                    <p>Texas presents unique challenges for pool surfaces:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Extreme Heat:</strong> Temperatures over 100°F for weeks</li>
                        <li><strong>UV Exposure:</strong> Intense sunlight year-round</li>
                        <li><strong>Soil Movement:</strong> Expansive clay soils that shift with moisture</li>
                        <li><strong>Severe Weather:</strong> Hail, windstorms, and temperature swings</li>
                    </ul>

                    <p>Fiberglass handles all these challenges better than any other pool surface:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Flexibility:</strong> Moves with soil without cracking</li>
                        <li><strong>UV Resistance:</strong> Won't fade or deteriorate in Texas sun</li>
                        <li><strong>Temperature Stability:</strong> Handles extreme heat and cold cycles</li>
                        <li><strong>Impact Resistance:</strong> Withstands hail and debris</li>
                    </ul>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-primary">🛡️ Protect Your Pool Investment - Get Fiberglass Durability</a>
                    </div>

                    <h3>Comfort and Safety Improvements</h3>
                    <p><strong>Smooth, Non-Abrasive Surface:</strong> Unlike concrete or plaster, fiberglass won't scrape knees or wear out swimsuits. It's gentle enough for children's sensitive skin.</p>
                    <p><strong>Better Footing:</strong> The textured fiberglass finish provides secure footing without being rough or painful.</p>
                    <p><strong>Algae Resistance:</strong> The non-porous surface doesn't provide places for algae and bacteria to hide, creating a healthier swimming environment.</p>
                    <p><strong>Chemical Reduction:</strong> Less chemicals mean fewer skin and eye irritations, especially important for family pools.</p>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-primary">👨‍👩‍👧‍👦 Make Your Pool Family-Safe - Schedule Assessment</a>
                    </div>

                    <hr class="my-5">

                    <h2>Pool Conversion Process: Our Proven 7-Step System</h2>

                    <h3>How Does Pool Conversion Work? Complete Process Breakdown</h3>

                    <h4>Step 1: Pool Conversion Assessment and Consultation</h4>
                    <p>Every successful pool conversion starts with understanding your specific situation. During our free pool conversion consultation, we:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Evaluate Pool Structure:</strong> Check for any structural issues that need addressing</li>
                        <li><strong>Assess Current Condition:</strong> Document existing problems and opportunities</li>
                        <li><strong>Discuss Goals:</strong> Understand what you want from your converted pool</li>
                        <li><strong>Review Options:</strong> Explain different approaches and customization possibilities</li>
                        <li><strong>Provide Detailed Quote:</strong> Transparent pricing with no hidden costs</li>
                    </ul>
                    <p><strong>Timeline:</strong> 1-2 hours on-site</p>
                    <p>Ready to learn what's possible for your pool? Let's start with a free, no-obligation assessment.</p>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-primary">🏡 Schedule Your Free Pool Assessment</a>
                    </div>

                    <h4>Step 2: Pool Conversion Surface Preparation</h4>
                    <p>Proper preparation is crucial for a long-lasting pool conversion. We:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Deep Clean:</strong> Remove all debris, algae, and surface contaminants</li>
                        <li><strong>Profile Surface:</strong> Create proper adhesion for the fiberglass system</li>
                        <li><strong>Repair Damage:</strong> Fix any cracks, chips, or structural issues</li>
                        <li><strong>Prime Substrate:</strong> Apply specialized bonding agents for maximum adhesion</li>
                    </ul>
                    <p><strong>Timeline:</strong> 1-2 days</p>

                    <h4>Step 3: Pool Conversion Structural Repairs</h4>
                    <p>If needed, we address any structural issues during the pool conversion process:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Crack Repair:</strong> Permanent solutions for existing cracks</li>
                        <li><strong>Plumbing Updates:</strong> Modernize old plumbing if necessary</li>
                        <li><strong>Equipment Compatibility:</strong> Ensure all systems work with new surface</li>
                        <li><strong>Customizations:</strong> Add or modify features as requested</li>
                    </ul>
                    <p><strong>Timeline:</strong> 1-2 days (if needed)</p>

                    <h4>Step 4: Fiberglass Pool Conversion Application</h4>
                    <p>This is where the pool conversion magic happens. Our certified technicians:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Apply Base Coat:</strong> Specialized resin system designed for conversions</li>
                        <li><strong>Install Reinforcement:</strong> Multiple layers of premium fiberglass material</li>
                        <li><strong>Build Thickness:</strong> Achieve optimal thickness for durability and longevity</li>
                        <li><strong>Quality Control:</strong> Continuous monitoring throughout application</li>
                    </ul>
                    <p><strong>Timeline:</strong> 2-3 days</p>

                    <h4>Step 5: Pool Conversion Curing and Finishing</h4>
                    <p>Proper curing ensures maximum strength and durability:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Controlled Curing:</strong> Monitor temperature and humidity for optimal results</li>
                        <li><strong>Surface Finishing:</strong> Achieve the perfect smooth finish</li>
                        <li><strong>Color Application:</strong> Apply your chosen gel coat color</li>
                        <li><strong>Final Inspection:</strong> Thorough quality check before proceeding</li>
                    </ul>
                    <p><strong>Timeline:</strong> 1-2 days</p>

                    <h4>Step 6: Pool Conversion Quality Assurance</h4>
                    <p>Before filling your pool, we:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Visual Inspection:</strong> Check every inch for perfection</li>
                        <li><strong>Adhesion Testing:</strong> Ensure proper bonding throughout</li>
                        <li><strong>Surface Quality:</strong> Confirm smooth, even finish</li>
                        <li><strong>Final Systems Check:</strong> Verify all plumbing connections and equipment compatibility</li>
                    </ul>
                    <p><strong>Timeline:</strong> 1 day</p>

                    <h4>Step 7: Pool Conversion Startup and Training</h4>
                    <p>Your pool conversion isn't complete until you're fully satisfied:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Water Fill:</strong> Careful filling to protect new surface</li>
                        <li><strong>Equipment Startup:</strong> Test all systems and equipment</li>
                        <li><strong>Owner Training:</strong> Learn how to maintain your new fiberglass surface</li>
                        <li><strong>Final Walkthrough:</strong> Address any questions or concerns</li>
                        <li><strong>Care Instructions:</strong> Detailed guidance on initial water chemistry and ongoing maintenance</li>
                    </ul>
                    <p><strong>Timeline:</strong> 1 day</p>

                    <hr class="my-5">

                    <h2>Pool Conversion Cost: Investment and Financial Analysis</h2>

                    <h3>How Much Does Pool Conversion Cost? Understanding the Investment</h3>
                    <p>Pool conversion represents excellent value compared to pool replacement or ongoing maintenance costs. While investment varies based on your pool's size, condition, and customization options, here's what typically influences pool conversion pricing:</p>

                    <h4>Pool Conversion Cost Factors</h4>

                    <h5>Size Factors:</h5>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Surface area to be covered</li>
                        <li>Depth variations and complexity</li>
                        <li>Custom features and shapes</li>
                    </ul>

                    <h5>Condition Factors:</h5>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Amount of preparation work needed</li>
                        <li>Structural repairs required</li>
                        <li>Plumbing or equipment updates</li>
                    </ul>

                    <h5>Customization Options:</h5>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Color choices and finishes</li>
                        <li>Additional features or modifications</li>
                        <li>Upgraded materials or warranties</li>
                    </ul>

                    <h4>Pool Conversion vs Pool Replacement Cost</h4>
                    <p><strong>Investment Context:</strong></p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Pool Replacement:</strong> Typically $40,000-$80,000+ and 3-6 months</li>
                        <li><strong>Pool Conversion:</strong> Significantly less investment with 7-10 day completion</li>
                        <li><strong>Ongoing Maintenance:</strong> $2,000-$4,000 annually for problem pools</li>
                    </ul>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-primary">💵 Get Your Custom Conversion Quote Today</a>
                    </div>

                    <h3>Pool Conversion Financing Options Available</h3>
                    <p>We understand that pool conversion is a significant investment. That's why we offer:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Flexible Payment Plans:</strong> Spread the cost over time</li>
                        <li><strong>Competitive Interest Rates:</strong> Work with trusted lending partners</li>
                        <li><strong>Quick Approval Process:</strong> Get answers in 24-48 hours</li>
                        <li><strong>No Early Payment Penalties:</strong> Pay off early without fees</li>
                    </ul>

                    <h3>Is Pool Conversion Worth It? Return on Investment Analysis</h3>
                    <p>When you consider the total cost of ownership, pool conversion often provides strong returns:</p>

                    <h4>Pool Conversion Immediate Benefits</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Reduced monthly maintenance costs</li>
                        <li>Lower chemical usage</li>
                        <li>Decreased energy consumption</li>
                        <li>Eliminated periodic resurfacing costs</li>
                    </ul>

                    <h4>Pool Conversion Long-term Value</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Enhanced property value</li>
                        <li>25-year warranty protection</li>
                        <li>Improved pool functionality and appearance</li>
                        <li>Enhanced family enjoyment and usage</li>
                    </ul>

                    <p><strong>Payback Analysis:</strong> Many Texas families report that maintenance savings help offset their conversion investment within 5-8 years, though individual results vary.*</p>
                    <p class="text-muted"><small>*Payback period estimates based on customer feedback and vary significantly by pool size, usage patterns, previous maintenance costs, and individual circumstances.</small></p>

                    <div class="text-center my-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-primary">📊 Discuss Your ROI Potential - Free Consultation</a>
                    </div>

                    <h3>Free Pool Conversion Quote Process</h3>
                    <p>Getting started is easy and risk-free:</p>
                    <ol style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Schedule Consultation:</strong> Call or complete our online form</li>
                        <li><strong>On-site Assessment:</strong> Comprehensive evaluation of your pool</li>
                        <li><strong>Detailed Proposal:</strong> Written quote with all details and options</li>
                        <li><strong>Project Planning:</strong> Timeline and logistics discussion</li>
                        <li><strong>Contract Signing:</strong> Clear terms and warranty information</li>
                    </ol>
                    <p><strong>No obligation, no pressure, just honest answers to your questions.</strong></p>

                    <hr class="my-5">

                    <h2>Pool Conversion FAQ: Common Questions About Pool Conversion</h2>

                    <h3>How long does pool conversion take?</h3>
                    <p>Most pool conversions are completed in 7-10 working days. The exact pool conversion timeline depends on:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Pool size and complexity</li>
                        <li>Amount of preparation work needed</li>
                        <li>Weather conditions</li>
                        <li>Customization requests</li>
                    </ul>
                    <p>We provide a detailed timeline during your consultation and keep you updated throughout the pool conversion process.</p>

                    <h3>Can any pool be converted to fiberglass?</h3>
                    <p>The vast majority of pools can be successfully converted to fiberglass. However, some factors may affect pool conversion eligibility:</p>

                    <h4>Good Candidates for Pool Conversion:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Structurally sound concrete, gunite, or vinyl liner pools</li>
                        <li>Pools with minor surface damage or deterioration</li>
                        <li>Pools with standard depths and configurations</li>
                    </ul>

                    <h4>May Require Additional Work:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Pools with significant structural damage</li>
                        <li>Pools with unusual shapes or extreme depths</li>
                        <li>Pools with outdated plumbing or electrical systems</li>
                    </ul>
                    <p>During our pool conversion consultation, we'll assess your pool's conversion suitability and discuss any special requirements.</p>

                    <h3>What happens to existing plumbing during pool conversion?</h3>
                    <p>In most cases, your existing plumbing and equipment will work perfectly with your converted pool. However, we may recommend upgrades for:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Improved Efficiency:</strong> Modern pumps and filters that work better with fiberglass</li>
                        <li><strong>Better Performance:</strong> Equipment sized properly for your converted pool</li>
                        <li><strong>Enhanced Features:</strong> New automation, heating, or lighting systems</li>
                    </ul>
                    <p>Any recommended changes will be discussed during your pool conversion consultation with clear explanations of benefits and costs.</p>

                    <h3>How much does pool conversion cost in Texas?</h3>
                    <p>Pool conversion costs vary significantly based on individual factors. However, pool conversion typically costs 40-60% less than complete pool replacement while delivering many of the same benefits.</p>
                    <p>During your free pool conversion consultation, we'll provide a detailed written quote with no hidden costs or surprises.</p>

                    <h3>What warranty do you provide for pool conversion?</h3>
                    <p>We offer one of the industry's most comprehensive pool conversion warranties:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>25-Year Structural Warranty:</strong> Covers the fiberglass surface integrity</li>
                        <li><strong>Workmanship Guarantee:</strong> Our installation is backed by company warranty</li>
                        <li><strong>Material Coverage:</strong> Fibre Tech materials are warranted by manufacturer</li>
                        <li><strong>Service Commitment:</strong> Ongoing support throughout warranty period</li>
                    </ul>

                    <h3>How long will my converted pool last?</h3>
                    <p>With proper care, your pool conversion should last 25-30 years or more. Many fiberglass pools installed in the 1980s and 1990s are still performing excellently today.</p>
                    <p>Factors that affect pool conversion longevity:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Quality of Installation:</strong> Professional installation is crucial</li>
                        <li><strong>Proper Maintenance:</strong> Basic care extends life significantly</li>
                        <li><strong>Material Quality:</strong> Premium materials last longer</li>
                        <li><strong>Environmental Factors:</strong> Texas climate requires quality materials</li>
                    </ul>

                    <h3>Do you offer pool conversion financing?</h3>
                    <p>Yes, we work with several trusted lending partners to offer competitive pool conversion financing options. Benefits include:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Flexible payment terms</li>
                        <li>Competitive interest rates</li>
                        <li>Quick approval process</li>
                        <li>No prepayment penalties</li>
                    </ul>

                    <h3>What if I'm not satisfied with my pool conversion?</h3>
                    <p>Your satisfaction is our top priority with every pool conversion. We guarantee our work and won't consider the job complete until you're completely happy with the results. Our pool conversion process includes:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Multiple quality checkpoints throughout the project</li>
                        <li>Final walkthrough before project completion</li>
                        <li>30-day follow-up to ensure continued satisfaction</li>
                        <li>Ongoing support throughout warranty period</li>
                    </ul>

                    <hr class="my-5">

                    <h2>Built for Texas: Why Pool Conversion Makes Sense for Texas Pool Owners</h2>

                    <h3>Texas Climate Considerations</h3>
                    <p>Texas presents unique challenges that make fiberglass conversion especially valuable:</p>

                    <h4>Extreme Heat Management:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Fiberglass surfaces stay cooler than concrete in direct sunlight</li>
                        <li>Better energy efficiency reduces cooling costs</li>
                        <li>UV-resistant materials won't fade or deteriorate</li>
                        <li>Lower chemical usage in high-temperature conditions</li>
                    </ul>

                    <h4>Humidity and Moisture:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Non-porous surface resists algae in humid conditions</li>
                        <li>Better water chemistry stability year-round</li>
                        <li>Reduced need for shocking and chemical adjustments</li>
                        <li>Improved air quality around pool area</li>
                    </ul>

                    <h3>Soil Conditions and Pool Challenges</h3>
                    <p>Texas's expansive clay soils cause major problems for traditional pool surfaces:</p>

                    <h4>Ground Movement Issues:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Clay soil expansion and contraction cracks concrete</li>
                        <li>Rigid surfaces can't handle soil movement</li>
                        <li>Traditional repairs often fail due to continued movement</li>
                        <li>Pool decks and coping frequently require repair</li>
                    </ul>

                    <h4>Fiberglass Solutions:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Flexible surface moves with ground without cracking</li>
                        <li>Superior adhesion systems handle soil movement</li>
                        <li>Reduced likelihood of structural problems</li>
                        <li>Lower long-term maintenance and repair costs</li>
                    </ul>

                    <h3>Energy Efficiency in Texas Heat</h3>
                    <p>With electricity costs rising and extreme summer temperatures, energy efficiency matters:</p>

                    <h4>Improved Insulation:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Fiberglass provides better thermal properties than concrete</li>
                        <li>Pool heaters work more efficiently</li>
                        <li>Reduced heat loss overnight</li>
                        <li>Lower energy bills year-round</li>
                    </ul>

                    <h4>Pump Efficiency:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Smooth surfaces require less powerful pumps</li>
                        <li>Reduced filtering requirements</li>
                        <li>Variable speed pumps work more effectively</li>
                        <li>Lower electrical consumption</li>
                    </ul>

                    <h3>Statewide Regulations and Permitting</h3>
                    <p>As Texas pool conversion specialists, we understand:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Local building codes and requirements</li>
                        <li>Permit processes in different municipalities</li>
                        <li>State health department regulations</li>
                        <li>Insurance and liability considerations</li>
                    </ul>

                    <h3>Service Coverage Across Texas</h3>

                    <h4>Major Metropolitan Areas:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Dallas-Fort Worth Metroplex:</strong> Full service coverage including Dallas, Fort Worth, Plano, Irving, Arlington, and surrounding communities</li>
                        <li><strong>Austin Region:</strong> Austin, Round Rock, Cedar Park, Georgetown, and Central Texas</li>
                        <li><strong>San Antonio:</strong> San Antonio, New Braunfels, Seguin, and surrounding areas</li>
                    </ul>

                    <p><strong>Rural and Suburban Communities:</strong> We also serve smaller communities throughout Texas. Our mobile service capabilities and statewide logistics allow us to bring the same high-quality conversion services to rural and suburban areas.</p>

                    <h4>Specialized Logistics:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Coordinated material delivery statewide</li>
                        <li>Experienced crews familiar with different regions</li>
                        <li>Local support and follow-up service</li>
                        <li>Understanding of regional soil and climate variations</li>
                    </ul>

                    <hr class="my-5">

                    <h2>Serving Pool Owners Throughout Texas</h2>

                    <h3>Statewide Service Commitment</h3>
                    <p>Hexagon Fiberglass Pools is proud to serve pool owners throughout the great state of Texas. Our statewide service capability includes:</p>

                    <h4>Comprehensive Coverage:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>All major metropolitan areas</li>
                        <li>Suburban communities</li>
                        <li>Rural locations</li>
                        <li>Custom logistics for any location</li>
                    </ul>

                    <h4>Quality Consistency:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Same high standards statewide</li>
                        <li>Uniform training and certification</li>
                        <li>Consistent materials and processes</li>
                        <li>Reliable project management</li>
                    </ul>

                    <h3>Major Metropolitan Areas</h3>
                    <p><strong>Dallas-Fort Worth Metroplex:</strong> Serving Dallas, Fort Worth, Plano, Frisco, McKinney, Allen, Richardson, Irving, Grand Prairie, Arlington, Euless, Bedford, Grapevine, Southlake, Keller, and surrounding communities.</p>
                    <p><strong>Austin Region:</strong> Serving Austin, Round Rock, Cedar Park, Georgetown, Pflugerville, Leander, Lakeway, West Lake Hills, and Central Texas.</p>
                    <p><strong>San Antonio:</strong> Covering San Antonio, New Braunfels, Seguin, Schertz, Universal City, Helotes, and surrounding areas.</p>

                    <h3>Rural and Suburban Communities</h3>
                    <p>We understand that quality pool service shouldn't be limited to major cities. Our rural service capabilities include:</p>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Mobile Service Teams:</strong> Fully equipped crews travel to your location</li>
                        <li><strong>Coordinated Logistics:</strong> Efficient material delivery and project scheduling</li>
                        <li><strong>Local Partnerships:</strong> Relationships with local suppliers and contractors</li>
                        <li><strong>Extended Service Areas:</strong> We'll travel to serve Texas pool owners</li>
                    </ul>

                    <h3>Texas Licensing and Insurance</h3>

                    <h4>Professional Credentials:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Texas contractor licensing</li>
                        <li>Comprehensive liability insurance</li>
                        <li>Workers' compensation coverage</li>
                        <li>Bonded and insured operations</li>
                    </ul>

                    <h4>Regulatory Compliance:</h4>
                    <ul style="margin-left: 1.5%; padding: 5px;">
                        <li>Local building code expertise</li>
                        <li>Permit acquisition and management</li>
                        <li>Health department regulation compliance</li>
                        <li>Environmental protection protocols</li>
                    </ul>

                    <hr class="my-5">

                    <h2>Ready to Transform Your Pool? Start with a Free Consultation</h2>

                    <h3>Take the First Step Toward Pool Freedom</h3>
                    <p>Stop struggling with your high-maintenance pool. Join thousands of satisfied Texas families who have discovered the life-changing benefits of fiberglass pool conversion.</p>

                    <p><strong>Here's what happens next:</strong></p>
                    <ol style="margin-left: 1.5%; padding: 5px;">
                        <li><strong>Schedule Your Free Consultation:</strong> Call 972-789-2983 or complete our online form below</li>
                        <li><strong>On-Site Assessment:</strong> We'll evaluate your pool and discuss your goals (typically 60-90 minutes)</li>
                        <li><strong>Receive Your Detailed Proposal:</strong> Written quote with all options and timeline</li>
                        <li><strong>Ask Questions:</strong> We'll answer every question and address any concerns</li>
                        <li><strong>Make an Informed Decision:</strong> No pressure, just professional guidance</li>
                    </ol>


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