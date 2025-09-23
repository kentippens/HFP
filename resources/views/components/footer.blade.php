<!-- Footer -->
<footer class="bixol-footer" data-background="{{ asset('images/home2/footer-bg.jpg') }}">
    <a href="{{ route('home') }}" class="bixol-footer-logo">
        <img src="{{ asset('images/logo/HFP-Logo-SQ.svg') }}" alt="{{ config('app.name') }}">
    </a>
    <div class="container">
        <div class="row">
            <!-- Open Hours - Left -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="bixol-footer-widget">
                    <h4>Open Hours</h4>
                    <div class="footer-office-time">
                        <span>Mon - Fri: 9 AM - 6:30 PM</span>
                        <span>Sat: 9 AM - 12 PM</span>
                        <span>Sunday: CLOSED</span>
                    </div>
                    <p class="mt-3">DFW's Premier Pool Resurfacing Company</p>
                </div>
            </div>
            <!-- Quick Links - Middle Left -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="bixol-footer-widget">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('services.index') }}" style="color: #ffffff;">Our Services</a></li>
                        <li><a href="{{ route('about') }}" style="color: #ffffff;">About Us</a></li>
                        <li><a href="{{ route('blog.index') }}" style="color: #ffffff;">Blog</a></li>
                        <li><a href="{{ route('contact.index') }}" style="color: #ffffff;">Contact Us</a></li>
                        <li><a href="/pool-repair-quote" style="color: #ffffff;">Get Free Quote</a></li>
                    </ul>
                </div>
            </div>
            <!-- Newsletter - Middle Right -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="bixol-footer-widget">
                    <h4>Newsletter</h4>
                    <p>Subscribe for pool maintenance tips and exclusive offers</p>
                    <div class="bixol-footer-form">
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="newsletter">
                            <input type="email" name="email" placeholder="Your mail address" required>
                            <button type="submit">@icon('fa-paper-plane')</button>
                        </form>
                    </div>
                    <div class="bixol-footer-social">
                        <a href="https://www.facebook.com/hexagonservicesolutions" class="facebook">@icon('fa-facebook-f')</a>
                        <a href="#" class="instagram">@icon('fa-instagram')</a>
                        <a href="#" class="twitter">@icon('fa-twitter')</a>
                    </div>
                </div>
            </div>
            <!-- Official Contact - Right -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="bixol-footer-widget">
                    <h4>Official Contact</h4>
                    <div class="bixol-footer-address">
                        <ul>
                            <li><img src="{{ asset('images/icons/contact/location.svg') }}" alt="Location" class="footer-icon"><span style="color: #ffffff;">603 Munger Ave <br>Suite 100-243 <br>Dallas, Texas 75202</span></li>
                            <li><img src="{{ asset('images/icons/contact/calling.svg') }}" alt="Phone" class="footer-icon"><a href="tel:9727892983" style="color: #ffffff;">972-789-2983</a></li>
                            <li><img src="{{ asset('images/icons/contact/mail.svg') }}" alt="Email" class="footer-icon"><a href="mailto:hello@hexagonservicesolutons.com" style="color: #ffffff;" >hello@hexagonservicesolutons.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <p>{{ date('Y') }} &copy; All Rights Reserved by Hexagon Service Solutions LLC. | <a href="{{ route('privacy') }}" style="color: #ffffff;">Privacy Policy</a> | <a href="{{ route('terms') }}" style="color: #ffffff;">Terms of Service</a> | <a href="{{ route('html-sitemap') }}" style="color: #ffffff;">Sitemap</a> | <a href="{{ route('investor.relations') }}" style="color: #ffffff;">Investor Relations</a></p>
    </div>
</footer>
<!-- Footer End -->
