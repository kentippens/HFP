# Robots.txt for {{ config('app.url') }}
# Generated: {{ now()->toRfc2822String() }}

# ===================================
# GENERAL CRAWLING RULES
# ===================================

# Allow all legitimate search engines
User-agent: *
Allow: /
Crawl-delay: 1

# ===================================
# SECURITY: BLOCK SENSITIVE PATHS
# ===================================

# Block admin and authentication paths
User-agent: *
Disallow: /admin
Disallow: /admin/*
Disallow: /login
Disallow: /register
Disallow: /password/*
Disallow: /email/*
Disallow: /api/*
Disallow: /nova
Disallow: /nova/*
Disallow: /telescope
Disallow: /telescope/*
Disallow: /horizon
Disallow: /horizon/*

# Block system and configuration files
User-agent: *
Disallow: /.env
Disallow: /.git
Disallow: /.gitignore
Disallow: /composer.json
Disallow: /composer.lock
Disallow: /package.json
Disallow: /webpack.mix.js
Disallow: /phpunit.xml
Disallow: /*.sql
Disallow: /*.log
Disallow: /*.bak
Disallow: /*.backup
Disallow: /*.old
Disallow: /*.save
Disallow: /*.orig
Disallow: /*.config

# Block application directories
User-agent: *
Disallow: /app/
Disallow: /bootstrap/
Disallow: /config/
Disallow: /database/
Disallow: /node_modules/
Disallow: /resources/
Disallow: /storage/
Disallow: /tests/
Disallow: /vendor/
Disallow: /zzTemplatesToCopy/

# Block build and source files
User-agent: *
Disallow: /public/build/
Disallow: /public/hot/
Disallow: /public/mix-manifest.json
Disallow: /public/css/filament/
Disallow: /public/js/filament/
Disallow: /public/vendor/

# ===================================
# SEO: PREVENT DUPLICATE CONTENT
# ===================================

# Block URL parameters that create duplicates
User-agent: *
Disallow: /*?*sort=
Disallow: /*?*order=
Disallow: /*?*filter=
Disallow: /*?*page=
Disallow: /*?*session=
Disallow: /*?*token=
Disallow: /*?*key=
Disallow: /*?*utm_
Disallow: /*?*ref=
Disallow: /*?*fbclid=
Disallow: /*?*gclid=

# Block print and mobile versions if they exist
User-agent: *
Disallow: /*/print
Disallow: /*/print/
Disallow: /print/

# ===================================
# PERFORMANCE: REDUCE CRAWLER LOAD
# ===================================

# Block asset directories from being indexed
User-agent: *
Disallow: /images/portfolio/
Disallow: /images/slider/
Disallow: /css/
Disallow: /js/
Disallow: /fonts/
Disallow: /sass/

# Allow CSS and JS for rendering
User-agent: Googlebot
Allow: /*.css
Allow: /*.js
Allow: /images/*.jpg
Allow: /images/*.jpeg
Allow: /images/*.png
Allow: /images/*.gif
Allow: /images/*.svg
Allow: /images/*.webp

User-agent: Bingbot
Allow: /*.css
Allow: /*.js
Allow: /images/*

# ===================================
# BLOCK MALICIOUS BOTS
# ===================================

# Block known bad bots and scrapers
User-agent: AhrefsBot
Disallow: /

User-agent: SemrushBot
Disallow: /

User-agent: DotBot
Disallow: /

User-agent: MJ12bot
Disallow: /

User-agent: Bytespider
Disallow: /

User-agent: PetalBot
Disallow: /

User-agent: AspiegelBot
Disallow: /

User-agent: DataForSeoBot
Disallow: /

User-agent: megaindex.ru
Disallow: /

User-agent: serpstatbot
Disallow: /

User-agent: SEOkicks-Robot
Disallow: /

User-agent: Screaming Frog SEO Spider
Crawl-delay: 5

# Block AI training bots (optional - uncomment if you don't want AI training)
# User-agent: GPTBot
# Disallow: /

# User-agent: ChatGPT-User
# Disallow: /

# User-agent: CCBot
# Disallow: /

# User-agent: anthropic-ai
# Disallow: /

# User-agent: Claude-Web
# Disallow: /

@if(config('app.env') === 'production')
# Production-specific rules
User-agent: *
Disallow: /health
Disallow: /health/*
@endif

# ===================================
# SEARCH ENGINE SPECIFIC RULES
# ===================================

# Google specific rules
User-agent: Googlebot
Allow: /
Crawl-delay: 0
# Google Image
User-agent: Googlebot-Image
Allow: /images/
Disallow: /images/portfolio/
Disallow: /images/slider/home2/

# Bing specific rules
User-agent: Bingbot
Allow: /
Crawl-delay: 1

# ===================================
# SITEMAP LOCATION
# ===================================

Sitemap: {{ config('app.url') }}/sitemap.xml

# ===================================
# SPECIAL PATHS
# ===================================

# Allow specific important pages
User-agent: *
Allow: /services
Allow: /services/*
Allow: /blog
Allow: /blog/*
Allow: /contact
Allow: /about
Allow: /crystal-clear-guarantee
Allow: /lp/*

# Block staging/development if accidentally exposed
User-agent: *
Disallow: /staging/
Disallow: /dev/
Disallow: /test/
Disallow: /demo/
Disallow: /backup/
Disallow: /old/
Disallow: /new/
Disallow: /tmp/
Disallow: /temp/

# ===================================
# NOTES
# ===================================
# - Crawl-delay is in seconds between requests
# - Some search engines ignore crawl-delay (like Google)
# - Update sitemap location if it changes
# - Review and update blocked bots periodically
# - Consider using robots meta tags for page-level control
# - This file is publicly accessible - don't expose sensitive paths