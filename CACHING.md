# Application Caching Guide

This document explains how to manage Laravel application caching for optimal performance.

## What Gets Cached?

Laravel caches several aspects of the application:

1. **Configuration** - All config files merged into single file
2. **Routes** - Route definitions compiled for faster lookup
3. **Events** - Event-listener mappings optimized
4. **Views** - Blade templates pre-compiled to PHP

## Quick Commands

### Helper Scripts (Recommended)

```bash
# Check cache status
./cache-status.sh

# Enable all caches (production)
./cache-all.sh

# Clear all caches (development)
./clear-cache.sh
```

### Manual Artisan Commands

```bash
# Cache individual components
php artisan config:cache
php artisan route:cache
php artisan event:cache
php artisan view:cache

# Clear individual caches
php artisan config:clear
php artisan route:clear
php artisan event:clear
php artisan view:clear

# Clear all application cache
php artisan cache:clear

# Check status
php artisan about
```

## When to Cache

### ✅ Cache in Production

Always enable caching in production environments:
- Significant performance improvements
- Reduced file I/O operations
- Faster application bootstrap
- Lower memory usage

```bash
# On production server after deployment
./cache-all.sh
```

### ⚠️ Clear Cache During Development

Clear caches when:
- Adding/modifying routes
- Changing configuration files
- Adding new environment variables
- Debugging routing issues
- Working with events/listeners

```bash
# When developing
./clear-cache.sh
```

## Performance Impact

With caching enabled:

| Component | Performance Gain | File Size |
|-----------|------------------|-----------|
| Config | ~40ms faster bootstrap | ~40KB |
| Routes | ~100ms faster routing | ~148KB |
| Events | ~10ms faster dispatch | ~4KB |
| Views | ~50ms per page render | Varies |

**Total Bootstrap Improvement: ~200ms per request**

## Cache Files Location

All cache files are stored in `bootstrap/cache/`:

```
bootstrap/cache/
├── config.php          # Configuration cache
├── routes-v7.php       # Route cache
├── events.php          # Event cache
├── compiled.php        # Compiled classes (optional)
└── packages.php        # Package manifest
```

## Important Notes

### Route Cache Limitations

⚠️ **Route caching does NOT work with closure-based routes**

This will fail with route cache:
```php
Route::get('/example', function() {
    return view('example');
});
```

This works with route cache:
```php
Route::get('/example', [ExampleController::class, 'index']);
```

All routes in this application use controller methods, so route caching is safe.

### Config Cache and .env

When config is cached:
- Changes to `.env` file are **ignored**
- Must clear cache to see env changes
- Use `env()` helper ONLY in config files
- Never use `env()` in application code

```php
// ✅ GOOD: In config files
'debug' => env('APP_DEBUG', false),

// ❌ BAD: In controllers/models
if (env('APP_DEBUG')) { ... }

// ✅ GOOD: In application code
if (config('app.debug')) { ... }
```

## Deployment Workflow

### Standard Deployment

```bash
# 1. Pull latest code
git pull origin main

# 2. Update dependencies
composer install --optimize-autoloader --no-dev
npm ci
npm run build

# 3. Run migrations
php artisan migrate --force

# 4. Clear old caches
./clear-cache.sh

# 5. Rebuild caches
./cache-all.sh

# 6. Restart services
sudo systemctl restart php8.3-fpm
sudo systemctl reload nginx
```

### Zero-Downtime Deployment

```bash
# In new release directory
composer install --optimize-autoloader --no-dev
npm ci && npm run build
./cache-all.sh

# Then atomically switch symlink
ln -sfn /path/to/new/release /var/www/current
sudo systemctl reload php8.3-fpm
```

## Troubleshooting

### Routes Not Working

**Symptoms:** 404 errors, routes not found

**Solution:**
```bash
php artisan route:clear
php artisan route:cache
```

### Config Changes Ignored

**Symptoms:** Environment variables not updating

**Solution:**
```bash
php artisan config:clear
php artisan config:cache
```

### View Changes Not Showing

**Symptoms:** Blade template changes not visible

**Solution:**
```bash
php artisan view:clear
```

### Nuclear Option (Clear Everything)

```bash
./clear-cache.sh
# Or manually:
php artisan optimize:clear
```

## Monitoring Cache Status

Check if caching is enabled:

```bash
./cache-status.sh
```

Or use Laravel's built-in command:

```bash
php artisan about
```

Look for the "Cache" section:
```
Cache
  Config ............... CACHED
  Events ............... CACHED
  Routes ............... CACHED
  Views ................ CACHED
```

## Best Practices

1. **Always cache in production** - Never deploy without caching
2. **Clear before caching** - Run `clear-cache.sh` before `cache-all.sh`
3. **Cache after deployment** - Rebuild caches after each deployment
4. **Test after caching** - Verify application works with caches enabled
5. **Monitor performance** - Compare response times with/without cache
6. **Automate in CI/CD** - Add caching to deployment scripts

## CI/CD Integration

### GitHub Actions Example

```yaml
- name: Cache Application
  run: |
    php artisan config:cache
    php artisan route:cache
    php artisan event:cache
    php artisan view:cache
```

### Deployment Script Hook

```bash
# In your deploy.sh
if [ "$APP_ENV" = "production" ]; then
    echo "Caching application..."
    ./cache-all.sh
fi
```

## Related Commands

```bash
# Optimize autoloader
composer dump-autoload -o

# Optimize entire application
php artisan optimize

# Clear all optimization
php artisan optimize:clear

# Cache Blade components (Filament)
php artisan icons:cache
php artisan filament:cache-components
```

## Support

For issues or questions:
1. Check `./cache-status.sh` output
2. Review Laravel logs: `storage/logs/laravel.log`
3. Clear all caches: `./clear-cache.sh`
4. Test without cache first
