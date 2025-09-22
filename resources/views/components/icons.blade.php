{{-- Optimized Icon Component --}}
@php
$iconMap = [
    // Font Awesome replacements with simple SVGs
    'fa-angle-double-right' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M4.5 2L3 3.5 8.5 8 3 12.5 4.5 14 11 8z"/><path d="M8.5 2L7 3.5 12.5 8 7 12.5 8.5 14 15 8z"/></svg>',
    'fa-plus' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 2v12M2 8h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
    'fa-check' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M14 4L6 12L2 8L3.4 6.6L6 9.2L12.6 2.6L14 4Z" fill="currentColor"/></svg>',
    'fa-angle-right' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M6 2L5 3L10 8L5 13L6 14L12 8z"/></svg>',
    'fa-angle-down' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M2 6L3 5L8 10L13 5L14 6L8 12z"/></svg>',
    'fa-check-circle' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1" fill="none"/><path d="M5 8l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'fa-calendar-alt' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="2" y="3" width="12" height="11" rx="1" stroke="currentColor" stroke-width="1" fill="none"/><path d="M5 1v3M11 1v3M2 7h12" stroke="currentColor" stroke-width="1"/></svg>',
    'fa-user' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="5" r="3" stroke="currentColor" stroke-width="1" fill="none"/><path d="M2 14c0-3.5 2.5-6 6-6s6 2.5 6 6" stroke="currentColor" stroke-width="1" fill="none"/></svg>',
    'fa-angle-double-left' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M11.5 2L13 3.5 7.5 8 13 12.5 11.5 14 5 8z"/><path d="M7.5 2L9 3.5 3.5 8 9 12.5 7.5 14 1 8z"/></svg>',
    'fa-search' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="6.5" cy="6.5" r="4.5" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="10 10l4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
    'fa-long-arrow-alt-right' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M2 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'fa-arrow-right' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M2 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'fa-play' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M5 3l8 5-8 5V3z"/></svg>',
    'fa-phone-alt' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M3 1c-.5 0-1 .5-1 1v1c0 6.5 5.5 12 12 12h1c.5 0 1-.5 1-1v-3c0-.5-.5-1-1-1h-2c-.5 0-1 .5-1 1v1c-4.5 0-8-3.5-8-8h1c.5 0 1-.5 1-1V1c0-.5-.5-1-1-1H3z"/></svg>',
    'fa-envelope' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="3" width="14" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="none"/><path d="M1 4l7 5 7-5" stroke="currentColor" stroke-width="1" stroke-linecap="round"/></svg>',
    'fa-map-marker-alt' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 1C5.5 1 3.5 3 3.5 5.5c0 4 4.5 8.5 4.5 8.5s4.5-4.5 4.5-8.5C12.5 3 10.5 1 8 1z" stroke="currentColor" stroke-width="1" fill="none"/><circle cx="8" cy="5.5" r="1.5" fill="currentColor"/></svg>',
    'fa-phone' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M3 1c-.5 0-1 .5-1 1v1c0 6.5 5.5 12 12 12h1c.5 0 1-.5 1-1v-3c0-.5-.5-1-1-1h-2c-.5 0-1 .5-1 1v1c-4.5 0-8-3.5-8-8h1c.5 0 1-.5 1-1V1c0-.5-.5-1-1-1H3z"/></svg>',
    'fa-home' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M1 8l7-6 7 6v6a1 1 0 01-1 1H9v-4H7v4H2a1 1 0 01-1-1V8z" stroke="currentColor" stroke-width="1" fill="none"/></svg>',
    'fa-folder' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M1 3a1 1 0 011-1h3l1 2h7a1 1 0 011 1v7a1 1 0 01-1 1H2a1 1 0 01-1-1V3z" stroke="currentColor" stroke-width="1" fill="none"/></svg>',
    'fa-file-pdf' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M3 1a1 1 0 00-1 1v12a1 1 0 001 1h10a1 1 0 001-1V5L10 1H3z" stroke="currentColor" stroke-width="1" fill="none"/><path d="M10 1v4h4" stroke="currentColor" stroke-width="1" fill="none"/><text x="8" y="10" text-anchor="middle" font-size="6" fill="currentColor">PDF</text></svg>',
    'fa-paper-plane' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M1 1l14 7-14 7V9l10-2L1 5V1z" stroke="currentColor" stroke-width="1" fill="currentColor"/></svg>',
    
    // Social Media Icons (simple versions)
    'fa-facebook-f' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M9.5 3H12V0H9.5C7.57 0 6 1.57 6 3.5V5H4v3h2v8h3V8h2.5l.5-3H9V3.5C9 3.22 9.22 3 9.5 3z"/></svg>',
    'fa-twitter' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M16 3c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.6-2.1.8-.6-.6-1.5-1-2.4-1-1.8 0-3.3 1.5-3.3 3.3 0 .3 0 .5.1.7-2.7-.1-5.2-1.4-6.8-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.4-.4v.1c0 1.6 1.1 2.9 2.6 3.2-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4-.3 0-.5 0-.8-.1 1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4c.7-.5 1.3-1.1 1.7-1.8z"/></svg>',
    'fa-instagram' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="1" width="14" height="14" rx="4" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="8" cy="8" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="12" cy="4" r="1" fill="currentColor"/></svg>',
    'fa-telegram-plane' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M1 8l3.5 1.5L6 14l2-2 3.5 1L16 1 1 8zm4.5 0L12 4l-6 8-1.5-4z"/></svg>',
    'fa-dribbble' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M2.5 10.5c3-1 6-1 9 0M13.5 5.5c-2 2-5 3-8 2M6.5 2.5c1 3 2 6 4 8" stroke="currentColor" stroke-width="1" fill="none"/></svg>',
    'fa-behance' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M6 5.5c0-.8.7-1.5 1.5-1.5H9c.8 0 1.5.7 1.5 1.5S9.8 7 9 7H7.5C6.7 7 6 6.3 6 5.5zM6 10.5c0-.8.7-1.5 1.5-1.5H10c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5H7.5c-.8 0-1.5-.7-1.5-1.5zM10 3h4v1h-4z"/></svg>',
];

// Simplified Flaticon equivalents (using geometric shapes)
$flaticonMap = [
    'flaticon-telephone' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M3 1c-.5 0-1 .5-1 1v1c0 6.5 5.5 12 12 12h1c.5 0 1-.5 1-1v-3c0-.5-.5-1-1-1h-2c-.5 0-1 .5-1 1v1c-4.5 0-8-3.5-8-8h1c.5 0 1-.5 1-1V1c0-.5-.5-1-1-1H3z"/></svg>',
    'flaticon-chat-box' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="2" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1" fill="none"/><path d="M4 8l8-4v8z" fill="currentColor"/></svg>',
    'flaticon-gear' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="8" r="2" fill="currentColor"/><path d="M8 1l1 2h2l-1 2 2 1v2l-2 1 1 2h-2l-1 2-2-1v-2l-2-1 1-2H2l1-2V3l2-1L6 1h2z" stroke="currentColor" stroke-width="1" fill="none"/></svg>',
    'flaticon-phone' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M3 1c-.5 0-1 .5-1 1v1c0 6.5 5.5 12 12 12h1c.5 0 1-.5 1-1v-3c0-.5-.5-1-1-1h-2c-.5 0-1 .5-1 1v1c-4.5 0-8-3.5-8-8h1c.5 0 1-.5 1-1V1c0-.5-.5-1-1-1H3z"/></svg>',
    'flaticon-mail' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="3" width="14" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="none"/><path d="M1 4l7 5 7-5" stroke="currentColor" stroke-width="1" stroke-linecap="round"/></svg>',
    'flaticon-pin' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 1C5.5 1 3.5 3 3.5 5.5c0 4 4.5 8.5 4.5 8.5s4.5-4.5 4.5-8.5C12.5 3 10.5 1 8 1z" stroke="currentColor" stroke-width="1" fill="none"/><circle cx="8" cy="5.5" r="1.5" fill="currentColor"/></svg>',
    'flaticon-alarm-clock' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1" fill="none"/><path d="M8 4v4l3 3" stroke="currentColor" stroke-width="1" stroke-linecap="round"/><path d="M2 3l2 2M14 3l-2 2" stroke="currentColor" stroke-width="1"/></svg>',
    'flaticon-garment' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M5 3h6v10H5V3z" stroke="currentColor" stroke-width="1" fill="none"/><path d="M5 5h6M5 7h6M5 9h6" stroke="currentColor" stroke-width="1"/></svg>',
    'flaticon-meeting' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="5" cy="5" r="2" stroke="currentColor" stroke-width="1" fill="none"/><circle cx="11" cy="5" r="2" stroke="currentColor" stroke-width="1" fill="none"/><path d="M1 14c0-2 1.5-4 4-4s4 2 4 4M7 14c0-2 1.5-4 4-4s4 2 4 4" stroke="currentColor" stroke-width="1" fill="none"/></svg>',
    'flaticon-screen' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="2" width="14" height="9" rx="1" stroke="currentColor" stroke-width="1" fill="none"/><rect x="6" y="11" width="4" height="2" rx="1" stroke="currentColor" stroke-width="1" fill="none"/><path d="M4 13h8" stroke="currentColor" stroke-width="1"/></svg>',
    'flaticon-trophy' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M5 3h6v5c0 1.5-1.5 3-3 3s-3-1.5-3-3V3z" stroke="currentColor" stroke-width="1" fill="none"/><path d="M3 5h2M11 5h2M6 11v2h4v-2M5 13h6" stroke="currentColor" stroke-width="1"/></svg>',
    'flaticon-factory' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="2" y="8" width="12" height="6" stroke="currentColor" stroke-width="1" fill="none"/><path d="M4 2v6M8 4v4M12 2v6" stroke="currentColor" stroke-width="1"/><circle cx="6" cy="11" r="1" fill="currentColor"/><circle cx="10" cy="11" r="1" fill="currentColor"/></svg>',
    'flaticon-client' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="5" r="3" stroke="currentColor" stroke-width="1" fill="none"/><path d="M2 14c0-3.5 2.5-6 6-6s6 2.5 6 6" stroke="currentColor" stroke-width="1" fill="none"/></svg>',
    'flaticon-business-and-finance' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="2" y="6" width="12" height="8" stroke="currentColor" stroke-width="1" fill="none"/><path d="M4 2v4M8 4v2M12 3v3" stroke="currentColor" stroke-width="1"/><path d="M6 9h4M6 11h4" stroke="currentColor" stroke-width="1"/></svg>',
    'flaticon-business-and-finance-1' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1" fill="none"/><path d="M8 5v6M6 7l2-2 2 2" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'flaticon-arrow' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 2v10M4 8l4-4 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    
    // Additional icons for homepage steps
    'fas fa-calendar-alt' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="2" y="3" width="12" height="11" rx="1" stroke="currentColor" stroke-width="1" fill="none"/><path d="M5 1v3M11 1v3M2 7h12" stroke="currentColor" stroke-width="1"/></svg>',
    'fas fa-clock' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1" fill="none"/><path d="M8 4v4l3 3" stroke="currentColor" stroke-width="1" stroke-linecap="round"/></svg>',
    'fas fa-route' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="4" cy="4" r="2" stroke="currentColor" stroke-width="1" fill="none"/><circle cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1" fill="none"/><path d="M6 6l4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M4 8c2 0 4-2 4 0s2 4 4 0" stroke="currentColor" stroke-width="1" fill="none"/></svg>',
    'fas fa-building' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="3" y="2" width="10" height="12" stroke="currentColor" stroke-width="1" fill="none"/><rect x="5" y="4" width="2" height="2" stroke="currentColor" stroke-width="1" fill="none"/><rect x="9" y="4" width="2" height="2" stroke="currentColor" stroke-width="1" fill="none"/><rect x="5" y="7" width="2" height="2" stroke="currentColor" stroke-width="1" fill="none"/><rect x="9" y="7" width="2" height="2" stroke="currentColor" stroke-width="1" fill="none"/><rect x="7" y="10" width="2" height="4" stroke="currentColor" stroke-width="1" fill="none"/></svg>',
];

// Get the icon name from the parameters
$iconClass = $class ?? '';
$iconName = '';

// Handle direct icon names (e.g., 'fa-check')
if (strpos($iconClass, 'fa-') === 0 || strpos($iconClass, 'flaticon') === 0) {
    $iconName = $iconClass;
} 
// Extract icon name from class (e.g., 'fas fa-check')
elseif (preg_match('/fa[bsr]?\s+fa-([a-z-]+)/', $iconClass, $matches)) {
    $iconName = 'fa-' . $matches[1];
} elseif (preg_match('/flaticon(?:-([a-z-]+))?/', $iconClass, $matches)) {
    $iconName = 'flaticon' . (isset($matches[1]) ? '-' . $matches[1] : '');
}

// Get the SVG
$svg = $iconMap[$iconName] ?? $flaticonMap[$iconName] ?? '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="8" r="2" fill="currentColor"/></svg>';
@endphp

<i class="icon">{!! $svg !!}</i>