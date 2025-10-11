#!/bin/bash

# Clear All Caches - Reset application to development mode
# Use this when developing or debugging issues

echo "🧹 Clearing All Application Caches..."
echo ""

# Clear configuration cache
echo "📦 Clearing configuration cache..."
php artisan config:clear
if [ $? -eq 0 ]; then
    echo "   ✅ Configuration cache cleared"
else
    echo "   ❌ Configuration clear failed"
fi

# Clear route cache
echo "🛣️  Clearing route cache..."
php artisan route:clear
if [ $? -eq 0 ]; then
    echo "   ✅ Route cache cleared"
else
    echo "   ❌ Route clear failed"
fi

# Clear event cache
echo "📡 Clearing event cache..."
php artisan event:clear
if [ $? -eq 0 ]; then
    echo "   ✅ Event cache cleared"
else
    echo "   ❌ Event clear failed"
fi

# Clear view cache
echo "👁️  Clearing view cache..."
php artisan view:clear
if [ $? -eq 0 ]; then
    echo "   ✅ View cache cleared"
else
    echo "   ❌ View clear failed"
fi

# Clear application cache
echo "💾 Clearing application cache..."
php artisan cache:clear
if [ $? -eq 0 ]; then
    echo "   ✅ Application cache cleared"
else
    echo "   ❌ Application cache clear failed"
fi

# Clear compiled classes
echo "🔧 Clearing compiled classes..."
php artisan clear-compiled
if [ $? -eq 0 ]; then
    echo "   ✅ Compiled classes cleared"
else
    echo "   ❌ Compiled clear failed"
fi

# Optional: Clear icon cache (Filament)
echo "🎨 Clearing icon cache..."
php artisan icons:clear 2>/dev/null
if [ $? -eq 0 ]; then
    echo "   ✅ Icon cache cleared"
else
    echo "   ⚠️  Icon cache skip (command may not be available)"
fi

echo ""
echo "✨ All caches cleared successfully!"
echo ""
echo "📊 Current cache status:"
php artisan about | grep -A 5 "Cache"
echo ""
echo "💡 To rebuild caches for production, run: ./cache-all.sh"
