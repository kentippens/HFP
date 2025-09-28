# Safe Database Seeding Guide

## Problem Solved
The original seeders used `Service::truncate()` which could accidentally delete all production data if run in the wrong environment. This guide shows how we've implemented safe seeding practices.

## Solution Overview

### 1. SafeSeeder Base Class
Located at: `database/seeders/SafeSeeder.php`

This base class provides:
- Environment detection (production vs development)
- Safe truncate with confirmations
- Upsert capabilities (update or create)
- Audit logging
- Protection mechanisms

### 2. Safe Seeding Methods

#### Method 1: Upsert (Recommended for Production)
```php
// Updates existing records or creates new ones
Service::upsert($data, ['slug']); // Match by slug, update other fields
```

#### Method 2: UpdateOrCreate
```php
// For individual records
Service::updateOrCreate(
    ['slug' => 'pool-cleaning'],  // Search criteria
    $serviceData                   // Data to update/create
);
```

#### Method 3: Skip Existing
```php
// Only insert if doesn't exist
if (!Service::where('slug', $slug)->exists()) {
    Service::create($data);
}
```

## Converting Existing Seeders

### Before (Dangerous):
```php
class ServiceSeeder extends Seeder
{
    public function run()
    {
        // DANGEROUS: Deletes all data!
        Service::truncate();
        
        Service::create([...]);
    }
}
```

### After (Safe):
```php
class SafeServiceSeeder extends SafeSeeder
{
    public function run()
    {
        $services = [...];
        
        // In production: uses upsert
        // In development: asks for confirmation before truncate
        if ($this->isProduction()) {
            $this->safeUpsert(Service::class, $services, ['slug']);
        } else {
            if ($this->confirmDestructive()) {
                $this->safeTruncate(Service::class);
                Service::insert($services);
            } else {
                $this->safeUpsert(Service::class, $services, ['slug']);
            }
        }
    }
}
```

## Configuration

### Config File: `config/seeder.php`

Key settings:
- `safe_environments`: Where destructive operations are allowed
- `protected_tables`: Tables that should never be truncated
- `strategy`: Default strategy per environment
- `force_flags`: Required environment variables for forcing operations

### Environment Variables

For production safety:
```env
# Never set these in production .env unless absolutely necessary
FORCE_SEED_DESTRUCTIVE=false
I_UNDERSTAND_THIS_WILL_DELETE_DATA=false

# Enable backup before seeding
BACKUP_BEFORE_SEED=true

# Enable audit logging
SEEDER_AUDIT_LOG=true
```

## Safe Commands

### 1. Safe Data Refresh Command
```bash
# Development (safe by default)
php artisan db:safe-refresh

# Only run seeders (skip migrations)
php artisan db:safe-refresh --only-seeds

# Run specific seeder
php artisan db:safe-refresh --class=SafePoolResurfacingServiceSeeder

# Production (requires multiple confirmations)
php artisan db:safe-refresh --force
```

### 2. Regular Seeding (Now Safe)
```bash
# Uses SafePoolResurfacingServiceSeeder
php artisan db:seed

# Specific seeder
php artisan db:seed --class=SafePoolResurfacingServiceSeeder
```

## Protection Levels

### Level 1: Environment Detection
- Automatically detects production/staging
- Changes behavior based on environment

### Level 2: Confirmation Prompts
- Asks for confirmation in development
- Requires multiple confirmations in production

### Level 3: Environment Variables
- Production requires explicit flags
- Both flags must be set to proceed

### Level 4: Protected Tables
- Some tables can never be truncated
- Defined in config/seeder.php

### Level 5: Audit Logging
- All operations are logged
- Includes timestamp, user, and action

## Best Practices

1. **Always extend SafeSeeder** for new seeders
2. **Use upsert** for production data
3. **Match by unique fields** (slug, email, etc.)
4. **Test in local** before deploying
5. **Review logs** after seeding
6. **Keep backups** before major operations

## Migration Path

To update existing seeders:

1. Create new safe version:
   ```bash
   cp ServiceSeeder.php SafeServiceSeeder.php
   ```

2. Extend SafeSeeder:
   ```php
   class SafeServiceSeeder extends SafeSeeder
   ```

3. Replace truncate with safe methods:
   ```php
   // Instead of: Service::truncate();
   $this->safeTruncate(Service::class);
   // Or better: use upsert
   $this->safeUpsert(Service::class, $data, ['slug']);
   ```

4. Update DatabaseSeeder to use safe version:
   ```php
   $this->call([
       SafeServiceSeeder::class, // Instead of ServiceSeeder::class
   ]);
   ```

## Testing

Test the safe seeders in different scenarios:

```bash
# Test in local (should ask for confirmation)
APP_ENV=local php artisan db:seed --class=SafePoolResurfacingServiceSeeder

# Test production protection (should use upsert)
APP_ENV=production php artisan db:seed --class=SafePoolResurfacingServiceSeeder

# Test force flags (only if needed)
FORCE_SEED_DESTRUCTIVE=true \
I_UNDERSTAND_THIS_WILL_DELETE_DATA=true \
php artisan db:safe-refresh --force
```

## Rollback Plan

If something goes wrong:

1. **Restore from backup**:
   ```bash
   mysql -u root -p hexservices < backup_hexservices_2025-09-09.sql
   ```

2. **Use previous seeder** (temporarily):
   ```php
   // In DatabaseSeeder, temporarily revert
   $this->call([
       PoolResurfacingServiceSeeder::class, // Old version
   ]);
   ```

3. **Check audit logs**:
   ```bash
   tail -f storage/logs/laravel.log | grep "Seeder Operation"
   ```

## Summary

This safe seeding implementation prevents accidental data loss by:
- Detecting environment automatically
- Using non-destructive methods in production
- Requiring multiple confirmations for dangerous operations
- Logging all operations for audit trail
- Providing safe alternatives to truncate

The system is backward compatible - old seeders still work, but new safe seeders are recommended for all future development.