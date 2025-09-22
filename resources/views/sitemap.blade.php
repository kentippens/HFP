<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Core Pages -->
    @if(isset($corePages))
        @foreach($corePages as $corePage)
            @php
                $url = match($corePage->slug) {
                    'homepage' => url('/'),
                    'services' => url('/services'),
                    'about' => url('/about'),
                    'contact' => url('/contact'),
                    default => url('/' . $corePage->slug)
                };
                
                $priority = match($corePage->slug) {
                    'homepage' => '1.0',
                    'services' => '0.9',
                    'about' => '0.8',
                    'contact' => '0.8',
                    default => '0.7'
                };
                
                $changefreq = match($corePage->slug) {
                    'homepage' => 'weekly',
                    'services' => 'weekly',
                    'about' => 'monthly',
                    'contact' => 'monthly',
                    default => 'monthly'
                };
            @endphp
            <url>
                <loc>{{ $url }}</loc>
                <lastmod>{{ $corePage->updated_at->toISOString() }}</lastmod>
                <changefreq>{{ $changefreq }}</changefreq>
                <priority>{{ $priority }}</priority>
            </url>
        @endforeach
    @endif
    
    <!-- Blog Index -->
    <url>
        <loc>{{ url('/blog') }}</loc>
        <lastmod>{{ now()->toISOString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    
    <!-- Services -->
    @if(isset($services))
        @foreach($services as $service)
            <url>
                <loc>{{ url('/services/' . $service->slug) }}</loc>
                <lastmod>{{ $service->updated_at->toISOString() }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
    @endif
    
    <!-- Blog Posts -->
    @if(isset($blogPosts))
        @foreach($blogPosts as $post)
            <url>
                <loc>{{ url('/blog/' . $post->slug) }}</loc>
                <lastmod>{{ $post->updated_at->toISOString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.7</priority>
            </url>
        @endforeach
    @endif
    
    <!-- Landing Pages -->
    @if(isset($landingPages))
        @foreach($landingPages as $page)
            <url>
                <loc>{{ url('/lp/' . $page->slug) }}</loc>
                <lastmod>{{ $page->updated_at->toISOString() }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.6</priority>
            </url>
        @endforeach
    @endif
</urlset>