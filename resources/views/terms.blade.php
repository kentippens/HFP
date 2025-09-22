@extends('layouts.app')

@section('title', 'Terms of Service')
@section('meta_description', 'Read our terms of service to understand the conditions and agreements for using our professional home services including cleaning, pool maintenance, and home improvement.')
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
                    <strong>Last Updated:</strong> January 21, 2025
                </div>

                <h1>Terms of Service</h1>

                <p>Welcome to Hexagon Service Solutions. These Terms of Service ("Terms") govern your use of our professional home services and website. By scheduling services with us or using our website, you agree to be bound by these Terms.</p>

                <h2>1. Service Agreement</h2>

                <h3>Service Scope</h3>
                <p>Hexagon Service Solutions provides professional home services including but not limited to:</p>
                <ul>
                    <li>Residential house cleaning</li>
                    <li>Pool cleaning and maintenance (bi-weekly service plans)</li>
                    <li>Vinyl fence installation</li>
                    <li>Gutter and leaf guard installation</li>
                    <li>Christmas light installation (seasonal)</li>
                    <li>Deep cleaning services</li>
                    <li>Move-in/move-out cleaning</li>
                </ul>

                <h3>Service Scheduling</h3>
                <p>Services may be scheduled through our website, phone, or email. All service appointments are subject to availability and confirmation from our team.</p>

                <div class="guarantee-box">
                    <h3>The Hexagon Guarantee™</h3>
                    <p><strong>Right the 1st Time. Every Time.</strong></p>
                    <p>We put your satisfaction first by delivering excellent service. If our work doesn't meet your expectations, we'll return to re-clean the area at no extra cost within 24 hours of the original service.</p>
                </div>

                <h2>2. Pricing and Payment</h2>

                <h3>Service Rates</h3>
                <p>Our pricing is based on factors including:</p>
                <ul>
                    <li>Type and scope of service (cleaning, pool maintenance, installation, etc.)</li>
                    <li>Property size and condition</li>
                    <li>Frequency of service (one-time, recurring, seasonal)</li>
                    <li>Materials required (chemicals, fencing materials, gutters, etc.)</li>
                    <li>Special requirements or add-on services</li>
                </ul>

                <h3>Payment Terms</h3>
                <ul>
                    <li>Payment is due upon completion of services unless other arrangements are made</li>
                    <li>We accept cash, check, and major credit cards</li>
                    <li>Late payment fees may apply to overdue accounts</li>
                    <li>Prices quoted are valid for 30 days unless otherwise specified</li>
                </ul>

                <h3>Cancellation Policy</h3>
                <p>Service cancellations must be made at least 24 hours in advance. Cancellations made with less than 24 hours notice may be subject to a cancellation fee.</p>

                <h2>3. Client Responsibilities</h2>

                <p>To ensure the best service experience, clients are responsible for:</p>
                <ul>
                    <li>Providing safe and reasonable access to all areas to be cleaned</li>
                    <li>Securing or removing valuable, fragile, or personal items</li>
                    <li>Notifying us of any pets, security systems, or special considerations</li>
                    <li>Providing accurate contact information and property details</li>
                    <li>Being present during the initial service or providing access instructions</li>
                    <li>Reporting any concerns or issues within 24 hours of service completion</li>
                </ul>

                <h2>4. Liability and Insurance</h2>

                <h3>Our Coverage</h3>
                <p>Hexagon Service Solutions is fully bonded and insured. Our insurance coverage includes:</p>
                <ul>
                    <li>General liability insurance</li>
                    <li>Worker's compensation coverage</li>
                    <li>Bonding for employee protection</li>
                </ul>

                <h3>Limitation of Liability</h3>
                <p>Our liability is limited to the cost of the service provided. We are not responsible for:</p>
                <ul>
                    <li>Pre-existing damage to property or items</li>
                    <li>Damage to items not properly secured by the client</li>
                    <li>Damage caused by pets or third parties</li>
                    <li>Indirect, consequential, or incidental damages</li>
                </ul>

                <h3>Damage Claims</h3>
                <p>Any damage claims must be reported within 24 hours of service completion. Claims will be investigated and resolved in accordance with our insurance policies.</p>

                <h2>5. Service Standards and Expectations</h2>

                <h3>Quality Commitment</h3>
                <p>We are committed to providing professional, reliable home services that meet or exceed industry standards. Our team members are thoroughly vetted, trained, and equipped with professional-grade supplies and equipment appropriate for each service type.</p>

                <h3>Eco-Friendly Practices</h3>
                <p>We use environmentally responsible products whenever possible and follow sustainable practices across all our services to protect both your health and the environment.</p>

                <h3>Service Adjustments</h3>
                <p>Service details may be adjusted based on property conditions, client preferences, or safety considerations. Any significant changes will be communicated and agreed upon before implementation.</p>

                <h2>6. Service-Specific Terms</h2>

                <h3>Pool Cleaning and Maintenance</h3>
                <ul>
                    <li>Bi-weekly service plans include all necessary chemicals</li>
                    <li>10-point water testing performed at each visit</li>
                    <li>Equipment inspection and maintenance recommendations provided</li>
                    <li>Crystal Clear Guarantee applies - we'll return within 48 hours if water clarity issues arise</li>
                    <li>Service reports with photos provided after each visit</li>
                    <li>Client must maintain proper water levels between visits</li>
                </ul>

                <h3>Vinyl Fence Installation</h3>
                <ul>
                    <li>All installations include property line verification</li>
                    <li>Client responsible for HOA approval where applicable</li>
                    <li>Underground utility marking required before installation</li>
                    <li>Warranty terms vary by manufacturer - details provided with quote</li>
                    <li>Installation timeline subject to weather conditions</li>
                </ul>

                <h3>Gutter and Leaf Guard Installation</h3>
                <ul>
                    <li>Free inspection and measurement before final quote</li>
                    <li>Removal of old gutters included when applicable</li>
                    <li>Proper drainage and downspout placement included</li>
                    <li>Manufacturer warranties apply to materials</li>
                    <li>Installation warranty provided for workmanship</li>
                </ul>

                <h3>Christmas Light Installation</h3>
                <ul>
                    <li>Seasonal service available October through January</li>
                    <li>Installation includes lights, extension cords, and timers</li>
                    <li>Client may provide own lights or rent from us</li>
                    <li>Takedown service included in seasonal packages</li>
                    <li>Storage options available for client-owned decorations</li>
                    <li>Service scheduling subject to weather conditions</li>
                </ul>

                <h2>7. Privacy and Confidentiality</h2>

                <p>We respect your privacy and maintain strict confidentiality regarding your property and personal information. Our employees are trained to:</p>
                <ul>
                    <li>Maintain professional boundaries and discretion</li>
                    <li>Protect your personal property and information</li>
                    <li>Follow security protocols and access procedures</li>
                </ul>

                <h2>8. Service Area and Travel</h2>

                <p>We primarily serve the DFW metroplex. Services beyond our standard service area may be available with an additional travel fee. Please contact us to discuss service availability in your area.</p>

                <h2>9. Dispute Resolution</h2>

                <p>We are committed to resolving any service issues promptly and fairly. Our dispute resolution process includes:</p>
                <ul>
                    <li>Direct communication with our customer service team</li>
                    <li>Investigation and assessment of the concern</li>
                    <li>Appropriate remedial action, including re-cleaning if necessary</li>
                    <li>Follow-up to ensure satisfaction</li>
                </ul>

                <h2>10. Termination of Service</h2>

                <p>Either party may terminate ongoing service agreements with reasonable notice. We reserve the right to discontinue service for:</p>
                <ul>
                    <li>Non-payment or repeated late payments</li>
                    <li>Unsafe working conditions</li>
                    <li>Violation of these terms</li>
                    <li>Inappropriate behavior toward our staff</li>
                </ul>

                <h2>11. Changes to Terms</h2>

                <p>We may update these Terms of Service from time to time to reflect changes in our services or legal requirements. Updated terms will be posted on our website with a new "Last Updated" date. Continued use of our services constitutes acceptance of any changes.</p>

                <h2>12. Governing Law</h2>

                <p>These Terms are governed by the laws of the State of Texas. Any disputes will be resolved in the appropriate courts of Dallas County, Texas.</p>

                <h2>13. Contact Information</h2>

                <div class="contact-info">
                    <p>If you have any questions about these Terms of Service or our home services, please contact us:</p>
                    
                    <p><strong>Hexagon Service Solutions</strong><br>
                    603 Munger Ave, Suite 100-243<br>
                    Dallas, Texas 75202</p>
                    
                    <p><strong>Email:</strong> <a href="mailto:hello@hexagonservicesolutions.com">hello@hexagonservicesolutions.com</a><br>
                    <strong>Phone:</strong> <a href="tel:9727027586">(972) 702-7586</a></p>
                    
                    <p><strong>Business Hours:</strong><br>
                    Monday - Friday: 9:00 AM - 6:30 PM<br>
                    Saturday: 9:00 AM - 12:00 PM<br>
                    Sunday: Closed</p>
                </div>

                <p><em>By using our services, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.</em></p>

            </div>
        </div>
    </div>
</section>

@endsection