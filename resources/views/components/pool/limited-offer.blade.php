@props([
    'offerTitle' => 'Limited Time Offer',
    'discount' => '$2,500 OFF',
    'validUntil' => now()->addDays(30)->format('F d, Y'),
    'conditions' => 'Valid for new customers only'
])

<div class="limited-offer-widget">
    <div class="offer-header">
        <i class="fas fa-tags"></i>
        <h3>{{ $offerTitle }}</h3>
    </div>
    <div class="offer-body">
        <div class="discount-amount">{{ $discount }}</div>
        <p class="offer-text">Pool Resurfacing Services</p>
        <div class="offer-timer">
            <i class="fas fa-clock"></i>
            <span>Valid Until: {{ $validUntil }}</span>
        </div>
        @if($conditions)
            <p class="offer-conditions">{{ $conditions }}</p>
        @endif
        <a href="#{{ $formId ?? 'sidebar-contact-form' }}" class="btn btn-warning btn-block">
            Claim Offer Now
        </a>
    </div>
</div>