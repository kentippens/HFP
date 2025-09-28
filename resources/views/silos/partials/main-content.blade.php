@props(['silo'])

<article class="service-content">
    {{-- Page Title --}}
    <h1 class="page-title">{{ $silo->h1_heading ?? $silo->name }}</h1>

    {{-- Lead Paragraph --}}
    @if($silo->introduction)
        <div class="lead-content">
            {!! \App\Helpers\HtmlHelper::safe($silo->introduction, 'admin') !!}
        </div>
    @endif

    {{-- Main Content --}}
    @if($silo->content)
        <div class="main-content">
            {!! \App\Helpers\HtmlHelper::safe($silo->content, 'admin') !!}
        </div>
    @endif

    {{-- Features Section --}}
    @if($silo->features && is_array($silo->features))
        <div class="features-section">
            <h2>Key Features</h2>
            <div class="row">
                @foreach($silo->features as $feature)
                    <div class="col-md-6">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ $feature }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Benefits Section --}}
    @if($silo->benefits && is_array($silo->benefits))
        <div class="benefits-section">
            <h2>Benefits</h2>
            <ul class="benefits-list">
                @foreach($silo->benefits as $benefit)
                    <li>{{ $benefit }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FAQ Section --}}
    @if($silo->faqs && is_array($silo->faqs))
        <div class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="accordion" id="faqAccordion">
                @foreach($silo->faqs as $index => $faq)
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-{{ $index }}">
                            <button class="accordion-button @if($index !== 0) collapsed @endif"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq-{{ $index }}"
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-controls="faq-{{ $index }}">
                                {{ $faq['question'] ?? '' }}
                            </button>
                        </h3>
                        <div id="faq-{{ $index }}"
                             class="accordion-collapse collapse @if($index === 0) show @endif"
                             aria-labelledby="faq-heading-{{ $index }}"
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ $faq['answer'] ?? '' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</article>