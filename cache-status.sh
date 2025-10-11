#!/bin/bash

# Cache Status - Check current caching state

echo "📊 Application Cache Status"
echo "=============================="
echo ""

php artisan about | grep -A 10 "Cache"

echo ""
echo "📁 Cache File Locations:"
echo "------------------------"

BOOTSTRAP_CACHE="bootstrap/cache"

# Check config cache
if [ -f "$BOOTSTRAP_CACHE/config.php" ]; then
    SIZE=$(du -h "$BOOTSTRAP_CACHE/config.php" | cut -f1)
    echo "✅ Config: $BOOTSTRAP_CACHE/config.php ($SIZE)"
else
    echo "❌ Config: Not cached"
fi

# Check routes cache
if [ -f "$BOOTSTRAP_CACHE/routes-v7.php" ]; then
    SIZE=$(du -h "$BOOTSTRAP_CACHE/routes-v7.php" | cut -f1)
    echo "✅ Routes: $BOOTSTRAP_CACHE/routes-v7.php ($SIZE)"
else
    echo "❌ Routes: Not cached"
fi

# Check events cache
if [ -f "$BOOTSTRAP_CACHE/events.php" ]; then
    SIZE=$(du -h "$BOOTSTRAP_CACHE/events.php" | cut -f1)
    echo "✅ Events: $BOOTSTRAP_CACHE/events.php ($SIZE)"
else
    echo "❌ Events: Not cached"
fi

# Check compiled classes
if [ -f "$BOOTSTRAP_CACHE/compiled.php" ]; then
    SIZE=$(du -h "$BOOTSTRAP_CACHE/compiled.php" | cut -f1)
    echo "✅ Compiled: $BOOTSTRAP_CACHE/compiled.php ($SIZE)"
else
    echo "ℹ️  Compiled: No compiled classes"
fi

echo ""
echo "💡 Commands:"
echo "  - Cache all:   ./cache-all.sh"
echo "  - Clear all:   ./clear-cache.sh"
echo "  - This status: ./cache-status.sh"
