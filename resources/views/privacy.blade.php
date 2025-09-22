@extends('layouts.app')

@section('title', 'Privacy Policy')
@section('meta_description', 'Learn how Hexagon Service Solutions collects, uses, and protects your personal information in compliance with CCPA, GDPR, and modern privacy standards.')
@section('meta_robots', 'index, follow')

@section('content')

<style>
    .privacy-content {
        padding-top: 100px;
        padding-bottom: 100px;
    }
    .privacy-content h1 {
        color: #02154e;
        margin-bottom: 30px;
        font-size: 36px;
        font-weight: 700;
    }
    .privacy-content h2 {
        color: #02154e;
        margin-top: 40px;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: 600;
    }
    .privacy-content h3 {
        color: #043f88;
        margin-top: 30px;
        margin-bottom: 15px;
        font-size: 20px;
        font-weight: 600;
    }
    .privacy-content p {
        line-height: 1.8;
        margin-bottom: 20px;
        color: #333;
        font-size: 16px;
    }
    .privacy-content ul {
        margin-bottom: 20px;
        padding-left: 30px;
    }
    .privacy-content ul li {
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
    .privacy-notice {
        background: #e3f2fd;
        padding: 25px;
        border-radius: 8px;
        margin: 30px 0;
        border-left: 4px solid #043f88;
    }
    .privacy-notice h3 {
        color: #02154e;
        margin-top: 0;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    .data-table th,
    .data-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .data-table th {
        background-color: #f8f9fa;
        color: #02154e;
        font-weight: 600;
    }
    .rights-box {
        background: #f0f7ff;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
        border: 1px solid #d0e4ff;
    }
    .rights-box h4 {
        color: #02154e;
        margin-bottom: 10px;
    }
</style>

<!-- Breadcrumb Area -->
<div class="bixol-breadcrumb" data-background="{{ asset('images/portfolio/Blog-BG.png') }}" style="background-image: url('{{ asset('images/portfolio/Blog-BG.png') }}');">
    <span class="breadcrumb-object"><img src="{{ asset('images/home1/slider-object.png') }}" alt=""></span>
    <div class="container">
        <div class="breadcrumb-content">
            <h1>Privacy Policy</h1>
            <a href="{{ route('home') }}">Home @icon("fas fa-angle-double-right")</a>
            <span>Privacy Policy</span>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<section class="privacy-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                
                <div class="last-updated">
                    <strong>Effective Date:</strong> January 21, 2025<br>
                    <strong>Last Updated:</strong> August 1, 2025
                </div>

                <h1>Privacy Policy</h1>

                <p>Hexagon Service Solutions ("we," "our," "us," or the "Company") respects your privacy and is committed to protecting your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website <strong>hexagonservicesolutions.com</strong> (the "Site") or use our home services.</p>

                <p>This Privacy Policy complies with applicable data protection laws including the California Consumer Privacy Act (CCPA), General Data Protection Regulation (GDPR), and other privacy regulations.</p>

                <div class="privacy-notice">
                    <h3>Quick Privacy Summary</h3>
                    <ul>
                        <li>We collect information you provide and some data automatically</li>
                        <li>We use your data to provide services and improve our offerings</li>
                        <li>We don't sell your personal information</li>
                        <li>You have rights to access, correct, and delete your data</li>
                        <li>We use industry-standard security measures</li>
                    </ul>
                </div>

                <h2>1. Information We Collect</h2>

                <h3>1.1 Information You Provide Directly</h3>
                <p>We collect information you voluntarily provide when you:</p>
                <ul>
                    <li>Request a quote or schedule services</li>
                    <li>Create an account or customer profile</li>
                    <li>Contact us via phone, email, or contact forms</li>
                    <li>Subscribe to our newsletter or marketing communications</li>
                    <li>Submit reviews or testimonials</li>
                    <li>Apply for employment or investment opportunities</li>
                    <li>Participate in surveys or promotions</li>
                </ul>

                <h3>1.2 Categories of Personal Information</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Examples</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Identifiers</strong></td>
                            <td>Name, email address, phone number, postal address</td>
                        </tr>
                        <tr>
                            <td><strong>Customer Records</strong></td>
                            <td>Service history, preferences, property details</td>
                        </tr>
                        <tr>
                            <td><strong>Commercial Information</strong></td>
                            <td>Services purchased, quotes requested, payment history</td>
                        </tr>
                        <tr>
                            <td><strong>Internet Activity</strong></td>
                            <td>Browsing history on our Site, search queries, interaction with ads</td>
                        </tr>
                        <tr>
                            <td><strong>Geolocation Data</strong></td>
                            <td>Service address, approximate location from IP address</td>
                        </tr>
                        <tr>
                            <td><strong>Professional Information</strong></td>
                            <td>Employment applications, business inquiries</td>
                        </tr>
                    </tbody>
                </table>

                <h3>1.3 Information Collected Automatically</h3>
                <p>When you visit our Site, we automatically collect:</p>
                <ul>
                    <li><strong>Device Information:</strong> Browser type, operating system, device identifiers</li>
                    <li><strong>Log Data:</strong> IP address, access times, pages viewed, referring URLs</li>
                    <li><strong>Cookies and Tracking:</strong> See Section 8 for detailed cookie policy</li>
                    <li><strong>Analytics Data:</strong> Site usage patterns, feature interactions</li>
                </ul>

                <h2>2. How We Use Your Information</h2>

                <h3>2.1 Primary Purposes</h3>
                <ul>
                    <li><strong>Service Delivery:</strong> Schedule and provide our home services</li>
                    <li><strong>Customer Support:</strong> Respond to inquiries and resolve issues</li>
                    <li><strong>Account Management:</strong> Maintain customer profiles and service history</li>
                    <li><strong>Communications:</strong> Send service confirmations, updates, and notices</li>
                    <li><strong>Payment Processing:</strong> Process transactions and maintain records</li>
                    <li><strong>Quality Assurance:</strong> Improve our services based on feedback</li>
                </ul>

                <h3>2.2 Legal Bases for Processing (GDPR)</h3>
                <p>If you are in the European Economic Area, we process your data based on:</p>
                <ul>
                    <li><strong>Contract Performance:</strong> To provide the services you requested</li>
                    <li><strong>Legitimate Interests:</strong> To improve our services and conduct business</li>
                    <li><strong>Legal Obligations:</strong> To comply with applicable laws</li>
                    <li><strong>Consent:</strong> For marketing communications and optional features</li>
                </ul>

                <h2>3. Information Sharing and Disclosure</h2>

                <h3>3.1 We DO NOT Sell Personal Information</h3>
                <p>We do not sell, rent, or trade your personal information to third parties for their marketing purposes.</p>

                <h3>3.2 How We Share Information</h3>
                <p>We may share your information with:</p>

                <div class="data-table">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Recipient Category</th>
                                <th>Purpose</th>
                                <th>Examples</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Service Providers</strong></td>
                                <td>Help us operate our business</td>
                                <td>Payment processors, email services, scheduling software</td>
                            </tr>
                            <tr>
                                <td><strong>Professional Advisors</strong></td>
                                <td>Legal and business guidance</td>
                                <td>Attorneys, accountants, consultants</td>
                            </tr>
                            <tr>
                                <td><strong>Business Partners</strong></td>
                                <td>Joint services or referrals</td>
                                <td>Affiliated contractors (with consent)</td>
                            </tr>
                            <tr>
                                <td><strong>Legal Authorities</strong></td>
                                <td>Comply with legal obligations</td>
                                <td>Law enforcement, regulators, courts</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2>4. Your Privacy Rights</h2>

                <div class="privacy-notice">
                    <h3>Your Rights at a Glance</h3>
                    <p>Depending on your location, you may have the following rights:</p>
                </div>

                <h3>4.1 California Residents (CCPA/CPRA)</h3>
                <div class="rights-box">
                    <h4>California Privacy Rights</h4>
                    <ul>
                        <li><strong>Right to Know:</strong> Request information about data collection and use</li>
                        <li><strong>Right to Delete:</strong> Request deletion of your personal information</li>
                        <li><strong>Right to Correct:</strong> Request correction of inaccurate information</li>
                        <li><strong>Right to Opt-Out:</strong> Opt-out of sale/sharing (we don't sell data)</li>
                        <li><strong>Right to Limit Use:</strong> Limit use of sensitive personal information</li>
                        <li><strong>Right to Non-Discrimination:</strong> Equal service regardless of rights exercise</li>
                    </ul>
                </div>

                <h3>4.2 European Residents (GDPR)</h3>
                <div class="rights-box">
                    <h4>GDPR Privacy Rights</h4>
                    <ul>
                        <li><strong>Right to Access:</strong> Obtain a copy of your personal data</li>
                        <li><strong>Right to Rectification:</strong> Correct inaccurate or incomplete data</li>
                        <li><strong>Right to Erasure:</strong> Request deletion ("right to be forgotten")</li>
                        <li><strong>Right to Restrict:</strong> Limit processing of your data</li>
                        <li><strong>Right to Portability:</strong> Receive data in a portable format</li>
                        <li><strong>Right to Object:</strong> Object to certain processing activities</li>
                        <li><strong>Right to Withdraw Consent:</strong> Withdraw previously given consent</li>
                    </ul>
                </div>

                <h3>4.3 How to Exercise Your Rights</h3>
                <p>To exercise any of these rights:</p>
                <ul>
                    <li><strong>Email:</strong> privacy@hexagonservicesolutions.com</li>
                    <li><strong>Phone:</strong> (972) 702-7586</li>
                    <li><strong>Mail:</strong> 603 Munger Ave, Suite 100-243, Dallas, TX 75202</li>
                </ul>
                <p>We will respond to your request within 30 days (45 days for complex requests).</p>

                <h2>5. Data Security</h2>

                <p>We implement appropriate technical and organizational measures to protect your information:</p>
                <ul>
                    <li><strong>Encryption:</strong> SSL/TLS encryption for data transmission</li>
                    <li><strong>Access Controls:</strong> Limited access on a need-to-know basis</li>
                    <li><strong>Security Monitoring:</strong> Regular security assessments and monitoring</li>
                    <li><strong>Incident Response:</strong> Procedures for handling security incidents</li>
                    <li><strong>Employee Training:</strong> Regular privacy and security training</li>
                    <li><strong>Vendor Management:</strong> Security requirements for service providers</li>
                </ul>

                <h2>6. Data Retention</h2>

                <p>We retain personal information for as long as necessary to:</p>
                <ul>
                    <li>Provide our services and maintain your account</li>
                    <li>Comply with legal, tax, and accounting obligations</li>
                    <li>Resolve disputes and enforce agreements</li>
                    <li>Maintain business records for analysis</li>
                </ul>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Data Type</th>
                            <th>Retention Period</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Customer Account Data</td>
                            <td>Duration of relationship + 7 years</td>
                        </tr>
                        <tr>
                            <td>Service Records</td>
                            <td>7 years after service completion</td>
                        </tr>
                        <tr>
                            <td>Marketing Preferences</td>
                            <td>Until opt-out + 3 years</td>
                        </tr>
                        <tr>
                            <td>Website Analytics</td>
                            <td>26 months</td>
                        </tr>
                        <tr>
                            <td>Employment Applications</td>
                            <td>2 years</td>
                        </tr>
                    </tbody>
                </table>

                <h2>7. International Data Transfers</h2>

                <p>If you access our services from outside the United States:</p>
                <ul>
                    <li>Your information may be transferred to and processed in the United States</li>
                    <li>We use appropriate safeguards for international transfers</li>
                    <li>By using our services, you consent to this transfer</li>
                </ul>

                <h2>8. Cookies and Tracking Technologies</h2>

                <h3>8.1 Types of Cookies We Use</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Cookie Type</th>
                            <th>Purpose</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Essential</strong></td>
                            <td>Site functionality and security</td>
                            <td>Session</td>
                        </tr>
                        <tr>
                            <td><strong>Analytics</strong></td>
                            <td>Understand site usage (Google Analytics)</td>
                            <td>2 years</td>
                        </tr>
                        <tr>
                            <td><strong>Preferences</strong></td>
                            <td>Remember your settings</td>
                            <td>1 year</td>
                        </tr>
                        <tr>
                            <td><strong>Marketing</strong></td>
                            <td>Measure ad effectiveness</td>
                            <td>90 days</td>
                        </tr>
                    </tbody>
                </table>

                <h3>8.2 Managing Cookies</h3>
                <p>You can control cookies through:</p>
                <ul>
                    <li><strong>Browser Settings:</strong> Block or delete cookies in your browser</li>
                    <li><strong>Cookie Banner:</strong> Manage preferences when you visit our Site</li>
                    <li><strong>Opt-Out Links:</strong> Use industry opt-out tools</li>
                </ul>

                <h2>9. Third-Party Services</h2>

                <p>Our Site may use third-party services that have their own privacy policies:</p>
                <ul>
                    <li><strong>Google Analytics:</strong> Website analytics (anonymized IP)</li>
                    <li><strong>Google Maps:</strong> Service area display</li>
                    <li><strong>Payment Processors:</strong> Secure payment handling</li>
                    <li><strong>Email Services:</strong> Communication delivery</li>
                    <li><strong>Social Media:</strong> Optional sharing features</li>
                </ul>

                <h2>10. Children's Privacy</h2>

                <p>Our services are not directed to children under 16. We do not knowingly collect personal information from children. If we learn we have collected information from a child under 16, we will delete it promptly.</p>

                <h2>11. Do Not Track Signals</h2>

                <p>Some browsers transmit "Do Not Track" (DNT) signals. We currently do not respond to DNT signals, but we limit tracking as described in this policy.</p>

                <h2>12. Your California Privacy Rights</h2>

                <h3>12.1 Shine the Light</h3>
                <p>California residents can request information about personal information shared with third parties for marketing. We do not share information for third-party marketing.</p>

                <h3>12.2 Notice to California Residents</h3>
                <p>We have not sold or shared personal information in the preceding 12 months. We do not have actual knowledge of selling or sharing personal information of minors under 16.</p>

                <h2>13. Changes to This Privacy Policy</h2>

                <p>We may update this Privacy Policy to reflect changes in our practices or legal requirements. We will:</p>
                <ul>
                    <li>Post the updated policy on this page</li>
                    <li>Update the "Last Updated" date</li>
                    <li>Notify you of material changes via email or Site notice</li>
                </ul>

                <h2>14. Contact Information</h2>

                <div class="contact-info">
                    <h3>Privacy Contact Information</h3>
                    
                    <p><strong>Hexagon Service Solutions</strong><br>
                    Attn: Privacy Officer<br>
                    603 Munger Ave, Suite 100-243<br>
                    Dallas, Texas 75202</p>
                    
                    <p><strong>Email:</strong> <a href="mailto:privacy@hexagonservicesolutions.com">privacy@hexagonservicesolutions.com</a><br>
                    <strong>Phone:</strong> <a href="tel:9727027586">(972) 702-7586</a><br>
                    <strong>General Support:</strong> <a href="mailto:hello@hexagonservicesolutions.com">hello@hexagonservicesolutions.com</a></p>
                    
                    <p><strong>Business Hours:</strong><br>
                    Monday - Friday: 9:00 AM - 6:30 PM CST<br>
                    Saturday: 9:00 AM - 12:00 PM CST<br>
                    Sunday: Closed</p>

                    <p><strong>Response Time:</strong><br>
                    We aim to respond to all privacy inquiries within 2 business days and resolve requests within 30 days.</p>
                </div>

                <div class="privacy-notice" style="margin-top: 40px;">
                    <p><strong>Accessibility:</strong> If you need this Privacy Policy in an alternative format due to a disability, please contact us using the information above.</p>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection