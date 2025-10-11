#!/bin/bash

# Sentry Error Tracking Setup Script
# This script helps you set up Sentry for production error tracking

echo "🔍 Sentry Error Tracking Setup"
echo "=============================="
echo ""

# Check if Sentry is already installed
if composer show | grep -q "sentry/sentry-laravel"; then
    echo "✅ Sentry package already installed"
else
    echo "📦 Installing Sentry package..."
    composer require sentry/sentry-laravel

    if [ $? -eq 0 ]; then
        echo "   ✅ Sentry package installed successfully"
    else
        echo "   ❌ Failed to install Sentry package"
        exit 1
    fi
fi

echo ""

# Publish configuration
echo "📝 Publishing Sentry configuration..."
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider" --force

if [ $? -eq 0 ]; then
    echo "   ✅ Configuration published"
else
    echo "   ⚠️  Configuration publish failed (may already exist)"
fi

echo ""

# Check if DSN is configured
if grep -q "SENTRY_LARAVEL_DSN=" .env && [ -n "$(grep SENTRY_LARAVEL_DSN .env | cut -d'=' -f2)" ]; then
    echo "✅ Sentry DSN already configured in .env"
    echo ""
    echo "📊 Testing Sentry connection..."
    php artisan sentry:test
else
    echo "⚠️  Sentry DSN not configured"
    echo ""
    echo "📋 Setup Instructions:"
    echo "   1. Go to https://sentry.io/signup/"
    echo "   2. Create account (free tier available)"
    echo "   3. Create new Laravel project"
    echo "   4. Copy your DSN"
    echo "   5. Add to .env file:"
    echo ""
    echo "      SENTRY_LARAVEL_DSN=https://your-key@sentry.io/your-project-id"
    echo "      SENTRY_TRACES_SAMPLE_RATE=0.2"
    echo "      SENTRY_PROFILES_SAMPLE_RATE=0.2"
    echo "      SENTRY_ENVIRONMENT=production"
    echo "      SENTRY_RELEASE=1.0.0"
    echo ""
    echo "   6. Run this script again to test"
    echo ""

    read -p "   Would you like to configure DSN now? (y/n): " -n 1 -r
    echo ""

    if [[ $REPLY =~ ^[Yy]$ ]]; then
        read -p "   Enter your Sentry DSN: " DSN

        # Add to .env
        if grep -q "SENTRY_LARAVEL_DSN=" .env; then
            # Update existing
            sed -i "s|SENTRY_LARAVEL_DSN=.*|SENTRY_LARAVEL_DSN=$DSN|" .env
        else
            # Add new
            echo "" >> .env
            echo "# Sentry Error Tracking" >> .env
            echo "SENTRY_LARAVEL_DSN=$DSN" >> .env
            echo "SENTRY_TRACES_SAMPLE_RATE=0.2" >> .env
            echo "SENTRY_PROFILES_SAMPLE_RATE=0.2" >> .env
            echo "SENTRY_ENVIRONMENT=production" >> .env
            echo "SENTRY_RELEASE=1.0.0" >> .env
        fi

        echo "   ✅ DSN configured in .env"
        echo ""
        echo "   📊 Testing connection..."
        php artisan sentry:test
    fi
fi

echo ""
echo "📚 Next Steps:"
echo "   1. Review Documentation/ERROR_TRACKING_SETUP.md for detailed setup"
echo "   2. Configure Slack/email notifications in Sentry dashboard"
echo "   3. Set up alert rules for critical errors"
echo "   4. Add frontend JavaScript tracking (see docs)"
echo "   5. Configure user context in AppServiceProvider"
echo ""
echo "💡 Useful Commands:"
echo "   php artisan sentry:test          - Test Sentry connection"
echo "   php artisan tinker               - Test manually: \Sentry\captureMessage('Test')"
echo "   ./cache-all.sh                   - Cache config after changes"
echo ""
echo "✨ Setup complete!"
