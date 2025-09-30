# Automatic Export Setup Guide

## Overview

Automatic exports have been configured for the HexService Laravel application using Laravel's built-in task scheduler. This provides reliable, automated data exports without manual intervention.

## Current Schedule

### 📅 **Configured Automatic Exports:**

1. **Weekly Contact Submissions**
   - **When**: Every Monday at 9:00 AM
   - **Data**: Contact submissions from the past week
   - **Email**: Results sent to admin@hexagonservicesolutions.com
   - **Next Due**: 6 days from now

2. **Monthly Full Backup**
   - **When**: 1st of each month at 8:00 AM
   - **Data**: All data (contacts, services, blog posts, users)
   - **Email**: Results sent to admin@hexagonservicesolutions.com
   - **Next Due**: 1 day from now

3. **Daily Services Export** (Conditional)
   - **When**: Daily at 11:30 PM
   - **Data**: All services (only if services were updated that day)
   - **Email**: No email notification
   - **Next Due**: 2 minutes from now

4. **Weekly User Export**
   - **When**: Every Friday at 5:00 PM
   - **Data**: Users from the past week
   - **Email**: No email notification (logged to file)
   - **Next Due**: 3 days from now

## Setup Instructions

### 1. **Enable the Laravel Scheduler (Required)**

Add this cron job to your server's crontab:

```bash
# Run the setup script (one-time)
./setup-cron.sh

# Or manually add to crontab:
* * * * * cd /home/txmamba/projects/HexService-Laravel && php artisan schedule:run >> /dev/null 2>&1
```

### 2. **Verify Setup**

```bash
# Check scheduled tasks
php artisan schedule:list

# View export status
php artisan export:manage status

# Test exports manually
php artisan export:manage test
```

## Management Commands

### **Export Schedule Manager**

```bash
# View current status and recent files
php artisan export:manage status

# Clean up old export files (30+ days)
php artisan export:manage cleanup

# Clean up files older than specific days
php artisan export:manage cleanup --days=7

# Test all exports
php artisan export:manage test

# Test specific model export
php artisan export:manage test --model=contacts
```

### **Manual Export Commands**

```bash
# Export specific data with options
php artisan export:scheduled contacts --period=week --storage=local
php artisan export:scheduled services --period=all --storage=local
php artisan export:scheduled users --period=month --storage=local
php artisan export:scheduled all --period=week --storage=local

# Available periods: day, week, month, year, all
# Available models: contacts, services, posts, users, all
```

## File Locations

### **Export Files**
- **Location**: `storage/app/private/`
- **Format**: `{model}-{period}-export-{timestamp}.csv`
- **Examples**:
  - `contact-submissions-week-export-2025-09-29_09-00-15.csv`
  - `services-all-export-2025-09-29_23-30-22.csv`

### **Logs**
- **Scheduler Logs**: Laravel's default log files
- **Export Logs**: `storage/logs/exports.log` (for user exports)
- **Activity Logs**: Database activity_logs table

## Configuration

### **Schedule Configuration** (`routes/console.php`)

```php
// Weekly contact submissions export
app(Schedule::class)->command('export:scheduled contacts --period=week --storage=local')
    ->weekly()
    ->mondays()
    ->at('09:00')
    ->emailOutputTo('admin@hexagonservicesolutions.com');

// Monthly full backup
app(Schedule::class)->command('export:scheduled all --period=month --storage=local')
    ->monthly()
    ->at('08:00')
    ->emailOutputTo('admin@hexagonservicesolutions.com');

// Daily services export (conditional)
app(Schedule::class)->command('export:scheduled services --period=all --storage=local')
    ->daily()
    ->at('23:30')
    ->when(function () {
        return \App\Models\Service::whereDate('updated_at', today())->exists();
    });

// Weekly user export
app(Schedule::class)->command('export:scheduled users --period=week --storage=local')
    ->weekly()
    ->fridays()
    ->at('17:00')
    ->appendOutputTo(storage_path('logs/exports.log'));
```

### **Export Settings** (`config/export_schedules.php`)

- Email recipients configuration
- File retention policies
- Storage disk settings
- Notification preferences

## Customization Options

### **Change Schedule Times**

Edit `routes/console.php` and modify the time/frequency:

```php
// Change to daily at 6 AM
->daily()->at('06:00')

// Change to every Tuesday at 2 PM
->weekly()->tuesdays()->at('14:00')

// Change to 15th of each month
->monthly()->at('10:00')
```

### **Add Email Recipients**

```php
->emailOutputTo(['admin@example.com', 'manager@example.com'])
```

### **Add Conditions**

```php
->when(function () {
    // Only run on weekdays
    return now()->isWeekday();
})

->skip(function () {
    // Skip on holidays
    return now()->isHoliday();
})
```

### **Add Notifications**

```php
->onSuccess(function () {
    // Send success notification
    \Log::info('Export completed successfully');
})

->onFailure(function () {
    // Send failure notification
    \Mail::to('admin@example.com')->send(new ExportFailedMail());
})
```

## Monitoring

### **Check Scheduler Status**
```bash
php artisan schedule:list
```

### **View Recent Exports**
```bash
php artisan export:manage status
```

### **Monitor Logs**
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Export-specific logs
tail -f storage/logs/exports.log

# System cron logs
tail -f /var/log/cron.log
```

## Troubleshooting

### **Exports Not Running**

1. **Check cron job**: `crontab -l`
2. **Verify scheduler**: `php artisan schedule:list`
3. **Test manually**: `php artisan schedule:run`
4. **Check permissions**: Ensure www-data can write to storage

### **Email Notifications Not Working**

1. **Check mail configuration**: `.env` mail settings
2. **Test mail**: `php artisan tinker` → `Mail::raw('test', function($m) { $m->to('admin@example.com'); });`
3. **Check logs**: Look for mail errors in `storage/logs/laravel.log`

### **Export Files Missing**

1. **Check storage permissions**: `ls -la storage/app/`
2. **Verify disk space**: `df -h`
3. **Check command output**: `php artisan export:scheduled contacts --period=week --storage=local`

### **Large Export Files**

1. **Monitor memory**: Check PHP memory_limit
2. **Use periods**: Export smaller date ranges
3. **Clean up old files**: `php artisan export:manage cleanup`

## Production Recommendations

### **Security**
- Store exports on secure, backed-up storage
- Limit file access permissions
- Use encrypted storage for sensitive data
- Regularly rotate access keys

### **Performance**
- Schedule exports during low-traffic periods
- Monitor database performance during exports
- Use database indexes for export queries
- Set appropriate PHP memory limits

### **Backup**
- Store exports on separate backup systems
- Test export file integrity regularly
- Maintain export history for compliance
- Document retention policies

### **Monitoring**
- Set up alerts for failed exports
- Monitor storage usage
- Track export performance metrics
- Review logs regularly

## Success Verification

✅ **Scheduler is active**: `php artisan schedule:list` shows all exports
✅ **Cron job installed**: `crontab -l` shows Laravel scheduler
✅ **Exports working**: `php artisan export:manage test` completes successfully
✅ **Files generated**: `php artisan export:manage status` shows recent files
✅ **Email configured**: Email notifications are sent to admin

Your automatic export system is now fully operational and will run reliably according to the configured schedule.