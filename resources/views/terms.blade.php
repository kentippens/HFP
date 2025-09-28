@extends('layouts.app')

@section('title', 'Terms of Service')
@section('meta_description', 'Read our terms of service to understand the conditions and agreements for using Hexagon Fiberglass Pools professional pool resurfacing, conversion, and repair services.')
@section('meta_robots', 'index, follow')

@section('content')

<style>
    .terms-content {
        padding-top: 100px;
        padding-bottom: 100px;
    }
    .terms-content h1 {
        color: #02154e;
        margin-bottom: 30px;
        font-size: 36px;
        font-weight: 700;
    }
    .terms-content h2 {
        color: #02154e;
        margin-top: 40px;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: 600;
    }
    .terms-content h3 {
        color: #043f88;
        margin-top: 30px;
        margin-bottom: 15px;
        font-size: 20px;
        font-weight: 600;
    }
    .terms-content p {
        line-height: 1.8;
        margin-bottom: 20px;
        color: #333;
        font-size: 16px;
    }
    .terms-content ul {
        margin-bottom: 20px;
        padding-left: 30px;
    }
    .terms-content ul li {
        margin-bottom: 10px;
        line-height: 1.6;
        color: #333;
    }
    .last-updated {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 40px;
        border-left: 4px solid #02154e;
    }
    .contact-info {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 8px;
        margin-top: 40px;
    }
    .guarantee-box {
        background: #e3f2fd;
        padding: 25px;
        border-radius: 8px;
        margin: 30px 0;
        border-left: 4px solid #043f88;
    }
    .guarantee-box h3 {
        color: #02154e;
        margin-top: 0;
    }
    .warranty-box {
        background: #f3e5f5;
        padding: 25px;
        border-radius: 8px;
        margin: 30px 0;
        border-left: 4px solid #6a1b9a;
    }
    .warranty-box h3 {
        color: #02154e;
        margin-top: 0;
    }
</style>

<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ asset('images/portfolio/Blog-BG.png') }}" style="background-image: url('{{ asset('images/portfolio/Blog-BG.png') }}');">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>Terms of Service</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>Terms of Service</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<section class="terms-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">

                <div class="last-updated">
                    <strong>Last Updated:</strong> September 28, 2025
                </div>

                <h1>Terms of Service</h1>

                <p>Welcome to Hexagon Fiberglass Pools. These Terms of Service ("Terms") govern your use of our professional pool services and website. By scheduling services with us or using our website, you agree to be bound by these Terms.</p>

                <h2>1. Service Agreement</h2>

                <h3>Service Scope</h3>
                <p>Hexagon Fiberglass Pools specializes in advanced pool technology and services including:</p>
                <ul>
                    <li>Fiberglass pool resurfacing with 25+ year warranty</li>
                    <li>Pool conversions (vinyl to fiberglass, concrete to fiberglass)</li>
                    <li>Complete pool remodeling and renovation</li>
                    <li>Structural pool repairs (cracks, leaks, equipment)</li>
                    <li>Tile and coping replacement</li>
                    <li>Pool deck resurfacing</li>
                    <li>Equipment upgrades and automation</li>
                    <li>Pool inspections and assessments</li>
                </ul>

                <h3>Service Scheduling</h3>
                <p>Services may be scheduled through our website, phone, or email. All service appointments are subject to availability and confirmation from our team. Project timelines will be provided during consultation and may vary based on scope and weather conditions.</p>

                <div class="warranty-box">
                    <h3>Industry-Leading 25+ Year Warranty</h3>
                    <p><strong>The Strongest Protection in Pool Resurfacing</strong></p>
                    <p>Our fiberglass resurfacing comes with an unprecedented 25+ year warranty against delamination, cracking, and structural failure. This warranty demonstrates our confidence in our advanced fiberglass technology and commitment to lasting quality.</p>
                </div>

                <h2>2. Pricing and Payment</h2>

                <h3>Service Rates</h3>
                <p>Our pricing is based on factors including:</p>
                <ul>
                    <li>Pool size and dimensions (surface area, depth, perimeter)</li>
                    <li>Current pool condition and required preparation work</li>
                    <li>Type of service (resurfacing, conversion, repair, remodeling)</li>
                    <li>Materials selected (fiberglass type, tile options, equipment grade)</li>
                    <li>Access requirements and site conditions</li>
                    <li>Additional features (water features, lighting, automation)</li>
                </ul>

                <h3>Payment Terms</h3>
                <ul>
                    <li>Projects typically require a 30-50% deposit to schedule</li>
                    <li>Progress payments may be required for larger projects</li>
                    <li>Final payment due upon project completion</li>
                    <li>We accept cash, check, wire transfer, and major credit cards</li>
                    <li>Financing options available for qualified customers</li>
                    <li>Written estimates valid for 30 days unless otherwise specified</li>
                </ul>

                <h3>Project Changes</h3>
                <p>Any changes to the original scope of work must be agreed upon in writing. Additional charges may apply for change orders or unforeseen conditions discovered during the project.</p>

                <h2>3. Client Responsibilities</h2>

                <p>To ensure successful project completion, clients are responsible for:</p>
                <ul>
                    <li>Providing clear access to the pool area and work site</li>
                    <li>Ensuring pool is drained when required (we can arrange this service)</li>
                    <li>Obtaining necessary HOA or municipal permits where applicable</li>
                    <li>Maintaining proper water levels during curing period</li>
                    <li>Following all post-service care instructions</li>
                    <li>Keeping pets and children away from work areas</li>
                    <li>Providing access to water and electricity as needed</li>
                </ul>

                <h2>4. Warranty and Guarantees</h2>

                <h3>25+ Year Fiberglass Warranty</h3>
                <p>Our industry-leading warranty covers:</p>
                <ul>
                    <li>Delamination of fiberglass surface</li>
                    <li>Structural cracking or failure</li>
                    <li>Color fading beyond normal wear</li>
                    <li>Manufacturing defects in materials</li>
                </ul>

                <h3>Workmanship Guarantee</h3>
                <p>In addition to material warranties, we provide:</p>
                <ul>
                    <li>5-year workmanship warranty on all installations</li>
                    <li>1-year warranty on repair services</li>
                    <li>30-day satisfaction guarantee on completed work</li>
                </ul>

                <h3>Warranty Exclusions</h3>
                <p>Warranties do not cover damage caused by:</p>
                <ul>
                    <li>Improper chemical balance or maintenance</li>
                    <li>Acts of nature (earthquakes, floods, freeze damage)</li>
                    <li>Structural movement or settling of property</li>
                    <li>Unauthorized repairs or modifications</li>
                    <li>Normal wear and tear</li>
                </ul>

                <h2>5. Liability and Insurance</h2>

                <h3>Our Coverage</h3>
                <p>Hexagon Fiberglass Pools maintains comprehensive insurance including:</p>
                <ul>
                    <li>General liability insurance ($2 million coverage)</li>
                    <li>Professional liability coverage</li>
                    <li>Worker's compensation for all employees</li>
                    <li>Commercial vehicle insurance</li>
                    <li>Bonding as required by state regulations</li>
                </ul>

                <h3>Property Protection</h3>
                <p>We take extensive precautions to protect your property during our work. This includes:</p>
                <ul>
                    <li>Protective coverings for surrounding areas</li>
                    <li>Careful equipment operation and placement</li>
                    <li>Daily cleanup and site maintenance</li>
                    <li>Restoration of landscaping disturbed by our work</li>
                </ul>

                <h2>6. Project Timeline and Completion</h2>

                <h3>Typical Project Durations</h3>
                <ul>
                    <li>Fiberglass resurfacing: 3-5 days</li>
                    <li>Pool conversions: 1-2 weeks</li>
                    <li>Complete remodeling: 2-4 weeks</li>
                    <li>Structural repairs: 1-5 days depending on scope</li>
                </ul>

                <h3>Weather and Delays</h3>
                <p>Project timelines may be affected by:</p>
                <ul>
                    <li>Inclement weather (rain, extreme temperatures)</li>
                    <li>Unexpected structural issues discovered during work</li>
                    <li>Permit or inspection delays</li>
                    <li>Material availability (rare but possible)</li>
                </ul>

                <h2>7. Chemical and Maintenance Requirements</h2>

                <h3>Post-Service Care</h3>
                <p>Following our fiberglass installation, specific care requirements include:</p>
                <ul>
                    <li>Initial 30-day startup procedure (detailed instructions provided)</li>
                    <li>Proper chemical balance maintenance (pH 7.2-7.6)</li>
                    <li>Regular brushing during first month</li>
                    <li>Avoiding harsh chemicals or abrasive cleaning tools</li>
                </ul>

                <h3>Ongoing Maintenance</h3>
                <p>To maintain warranty coverage, pools must receive:</p>
                <ul>
                    <li>Regular chemical testing and balancing</li>
                    <li>Professional inspection annually (we offer this service)</li>
                    <li>Prompt attention to any surface concerns</li>
                </ul>

                <h2>8. Environmental Considerations</h2>

                <p>Hexagon Fiberglass Pools is committed to environmental responsibility:</p>
                <ul>
                    <li>Proper disposal of all removed materials</li>
                    <li>Use of eco-friendly products where possible</li>
                    <li>Water conservation practices during service</li>
                    <li>Compliance with all environmental regulations</li>
                    <li>Recycling of applicable materials</li>
                </ul>

                <h2>9. Service Area</h2>

                <p>We proudly serve all of Texas with primary service areas including:</p>
                <ul>
                    <li>Dallas-Fort Worth Metroplex</li>
                    <li>Houston and surrounding areas</li>
                    <li>Austin and Central Texas</li>
                    <li>San Antonio region</li>
                </ul>
                <p>Travel fees may apply for projects outside primary service areas. Contact us to discuss service availability in your location.</p>

                <h2>10. Dispute Resolution</h2>

                <p>We are committed to complete customer satisfaction. Our resolution process includes:</p>
                <ul>
                    <li>Direct communication with project managers</li>
                    <li>On-site inspection of any concerns</li>
                    <li>Prompt remedial action when warranted</li>
                    <li>Mediation services if necessary</li>
                    <li>All disputes governed by Texas law</li>
                </ul>

                <h2>11. Cancellation Policy</h2>

                <p>Project cancellations are subject to the following terms:</p>
                <ul>
                    <li>Cancellation before material order: Full deposit refund</li>
                    <li>Cancellation after material order: Deposit applied to material costs</li>
                    <li>Cancellation after work begins: Payment for work completed plus materials</li>
                    <li>Weather-related delays are not considered cancellations</li>
                </ul>

                <h2>12. Intellectual Property</h2>

                <p>Hexagon Fiberglass Pools' proprietary fiberglass technology, processes, and methods are protected intellectual property. Clients agree not to disclose, reproduce, or allow third parties to copy our techniques and processes.</p>

                <h2>13. Changes to Terms</h2>

                <p>We may update these Terms of Service periodically to reflect changes in our services, technology, or legal requirements. Updated terms will be posted on our website with a new "Last Updated" date. Continued use of our services constitutes acceptance of any changes.</p>

                <h2>14. Governing Law</h2>

                <p>These Terms are governed by the laws of the State of Texas. Any disputes will be resolved in the appropriate courts of the county where the service was performed.</p>

                <h2>15. Contact Information</h2>

                <div class="contact-info">
                    <p>For questions about these Terms of Service or our pool services, please contact us:</p>

                    <p><strong>Hexagon Fiberglass Pools</strong><br>
                    Texas Headquarters</p>

                    <p><strong>Email:</strong> <a href="mailto:pools@hexagonfiberglasspools.com">pools@hexagonfiberglasspools.com</a><br>
                    <strong>Phone:</strong> <a href="tel:9727892983">(972) 789-2983</a></p>

                    <p><strong>Business Hours:</strong><br>
                    Monday - Friday: 9:00 AM - 4:00 PM<br>
                    Saturday: Closed<br>
                    Sunday: Closed</p>

                    <p><strong>Emergency Service:</strong><br>
                    Available for urgent pool repairs - additional fees may apply</p>
                </div>

                <p><em>By using our services, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service. Thank you for choosing Hexagon Fiberglass Pools for your pool renovation needs.</em></p>

            </div>
        </div>
    </div>
</section>

@endsection