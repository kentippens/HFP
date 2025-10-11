#!/bin/bash

# Cache All - Optimize application for production performance
# This script caches configuration, routes, events, and views

echo "🚀 Caching Application for Production..."
echo ""

# Cache configuration
echo "📦 Caching configuration..."
php artisan config:cache
if [ $? -eq 0 ]; then
    echo "   ✅ Configuration cached"
else
    echo "   ❌ Configuration cache failed"
    exit 1
fi

# Cache routes
echo "🛣️  Caching routes..."
php artisan route:cache
if [ $? -eq 0 ]; then
    echo "   ✅ Routes cached"
else
    echo "   ❌ Route cache failed"
    exit 1
fi

# Cache events
echo "📡 Caching events..."
php artisan event:cache
if [ $? -eq 0 ]; then
    echo "   ✅ Events cached"
else
    echo "   ❌ Event cache failed"
    exit 1
fi

# Cache views
echo "👁️  Caching views..."
php artisan view:cache
if [ $? -eq 0 ]; then
    echo "   ✅ Views cached"
else
    echo "   ❌ View cache failed"
    exit 1
fi

# Optional: Cache icons (Filament)
echo "🎨 Caching Blade icons..."
php artisan icons:cache 2>/dev/null
if [ $? -eq 0 ]; then
    echo "   ✅ Icons cached"
else
    echo "   ⚠️  Icons cache skipped (command may not be available)"
fi

echo ""
echo "✨ All caches created successfully!"
echo ""
echo "📊 Current cache status:"
php artisan about | grep -A 5 "Cache"
echo ""
echo "💡 To clear all caches, run: ./clear-cache.sh"
