@props([
    'badges' => [
        ['icon' => 'fa-shield-alt', 'text' => '25-Year Warranty'],
        ['icon' => 'fa-clock', 'text' => '5-7 Day Installation'],
        ['icon' => 'fa-award', 'text' => 'Licensed & Insured'],
        ['icon' => 'fa-users', 'text' => '500+ Happy Customers']
    ]
])

<div class="trust-badges-widget">
    <h3 class="widget-title">Why Choose Us</h3>
    <div class="badges-grid">
        @foreach($badges as $badge)
            <div class="trust-badge">
                <i class="fas {{ $badge['icon'] }}"></i>
                <span>{{ $badge['text'] }}</span>
            </div>
        @endforeach
    </div>
</div>