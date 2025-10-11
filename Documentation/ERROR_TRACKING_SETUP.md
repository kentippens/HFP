# Error Tracking Setup Guide

Complete guide for implementing production-grade error tracking with Sentry.

## Why Error Tracking?

**Without error tracking, you're flying blind:**
- Users experience errors you never know about
- No visibility into production issues
- Hard to debug problems users report
- No performance monitoring
- Can't identify error trends

**With error tracking:**
- ✅ Instant notifications when errors occur
- ✅ Detailed stack traces with context
- ✅ User impact assessment
- ✅ Performance monitoring
- ✅ Release tracking
- ✅ Error trends and analytics

## Recommended Solution: Sentry

**Selected for:**
- Best Laravel integration
- Comprehensive free tier (5,000 events/month)
- Performance monitoring included
- Frontend JavaScript tracking
- Release and deployment tracking
- Open-source option available

## Installation

### 1. Install Sentry Package

```bash
# Install via Composer
composer require sentry/sentry-laravel

# Publish configuration
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```

### 2. Create Sentry Account

1. Go to https://sentry.io/signup/
2. Create account (free tier available)
3. Create new project:
   - Platform: Laravel
   - Project name: HexService-Production
   - Team: Create or select team

4. Copy your DSN (Data Source Name)
   - Format: `https://[key]@sentry.io/[project-id]`

### 3. Configure Environment

Add to `.env`:

```bash
# Sentry Configuration
SENTRY_LARAVEL_DSN=https://your-public-key@sentry.io/your-project-id
SENTRY_TRACES_SAMPLE_RATE=0.2
SENTRY_PROFILES_SAMPLE_RATE=0.2
SENTRY_ENVIRONMENT=production
SENTRY_RELEASE=1.0.0
```

**Environment-Specific Settings:**

```bash
# Production (.env)
SENTRY_LARAVEL_DSN=https://prod-key@sentry.io/prod-project
SENTRY_ENVIRONMENT=production
SENTRY_TRACES_SAMPLE_RATE=0.2

# Staging (.env.staging)
SENTRY_LARAVEL_DSN=https://staging-key@sentry.io/staging-project
SENTRY_ENVIRONMENT=staging
SENTRY_TRACES_SAMPLE_RATE=1.0  # Monitor 100% in staging

# Local (.env.local)
SENTRY_LARAVEL_DSN=  # Empty - don't send from local
SENTRY_ENVIRONMENT=local
```

### 4. Configure Sentry

Copy the recommended configuration:

```bash
cp config/sentry-recommended.php config/sentry.php
```

Or merge manually into existing `config/sentry.php`.

### 5. Test Configuration

```bash
# Test that Sentry is working
php artisan sentry:test

# Should output:
# [Sentry] DSN correctly configured.
# [Sentry] Generating test Event
# [Sentry] Sending test Event
# [Sentry] Event sent: event-id-here
```

Visit your Sentry dashboard - you should see the test event.

## Advanced Configuration

### User Context Tracking

Add to `app/Providers/AppServiceProvider.php`:

```php
use Sentry\State\Scope;

public function boot()
{
    // Configure Sentry user context
    if (app()->bound('sentry')) {
        \Sentry\configureScope(function (Scope $scope): void {
            if ($user = auth()->user()) {
                $scope->setUser([
                    'id' => $user->id,
                    'username' => $user->name,
                    'email' => $user->email,
                    'ip_address' => request()->ip(),
                ]);

                $scope->setTag('user_role', $user->is_admin ? 'admin' : 'user');
            }
        });
    }
}
```

### Custom Context in Controllers

Add contextual information for better debugging:

```php
// app/Http/Controllers/ContactController.php

use Sentry\State\Scope;

public function store(Request $request)
{
    // Add breadcrumb for debugging
    \Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
        \Sentry\Breadcrumb::LEVEL_INFO,
        \Sentry\Breadcrumb::TYPE_DEFAULT,
        'http',
        'Contact form submission received',
        [
            'service' => $request->input('service'),
            'type' => $request->input('type'),
        ]
    ));

    try {
        // Process form...
        $submission = ContactSubmission::create($validated);

        // Add more context
        \Sentry\configureScope(function (Scope $scope) use ($submission): void {
            $scope->setContext('submission', [
                'id' => $submission->id,
                'service' => $submission->service,
                'type' => $submission->type,
            ]);
        });

    } catch (\Exception $e) {
        // Exception will automatically be sent to Sentry
        // with all the context and breadcrumbs
        \Sentry\captureException($e);

        return back()->with('error', 'Something went wrong');
    }
}
```

### Release Tracking

**Option 1: Git Commit Hash (Automatic)**

Already configured in `config/sentry.php`:

```php
'release' => trim(exec('git --git-dir ' . base_path('.git') . ' log --pretty="%h" -n1 HEAD')),
```

**Option 2: Semantic Versioning (Manual)**

```bash
# In .env
SENTRY_RELEASE=1.0.0

# Update on each release
SENTRY_RELEASE=1.0.1
```

**Option 3: Deployment Script**

```bash
# In your deploy.sh
SENTRY_RELEASE=$(git rev-parse HEAD)
echo "SENTRY_RELEASE=$SENTRY_RELEASE" >> .env
php artisan config:cache

# Notify Sentry of deployment
curl https://sentry.io/api/0/organizations/your-org/releases/ \
  -X POST \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN" \
  -H "Content-Type: application/json" \
  -d "{
    \"version\": \"$SENTRY_RELEASE\",
    \"projects\": [\"hexservice-production\"]
  }"
```

### Frontend JavaScript Tracking

Add to `resources/views/layouts/app.blade.php` before closing `</body>`:

```html
@production
<script src="https://browser.sentry-cdn.com/7.119.0/bundle.min.js"
        integrity="sha384-..."
        crossorigin="anonymous"></script>
<script>
  Sentry.init({
    dsn: "{{ config('sentry.dsn') }}",
    environment: "{{ config('app.env') }}",
    release: "{{ config('sentry.release') }}",

    // Performance monitoring
    tracesSampleRate: 0.1,

    // Integrations
    integrations: [
      new Sentry.BrowserTracing(),
      new Sentry.Replay({
        maskAllText: true,
        blockAllMedia: true,
      }),
    ],

    // Session replay (10% of sessions)
    replaysSessionSampleRate: 0.1,
    replaysOnErrorSampleRate: 1.0,

    // Filter out noise
    beforeSend(event, hint) {
      // Filter out ResizeObserver errors (browser noise)
      if (event.exception?.values?.[0]?.type === 'ResizeObserver loop limit exceeded') {
        return null;
      }

      // Filter out network errors (user's connection issues)
      if (event.exception?.values?.[0]?.type === 'NetworkError') {
        return null;
      }

      return event;
    },

    // Ignore specific errors
    ignoreErrors: [
      'Non-Error promise rejection captured',
      'ResizeObserver loop limit exceeded',
      'Script error',
    ],
  });

  // Set user context if available
  @auth
  Sentry.setUser({
    id: "{{ auth()->id() }}",
    email: "{{ auth()->user()->email }}",
  });
  @endauth
</script>
@endproduction
```

### Performance Monitoring

Sentry automatically tracks:
- HTTP request duration
- Database query performance
- External API calls
- Job queue processing

**Custom performance tracking:**

```php
// Track custom transactions
$transaction = \Sentry\startTransaction([
    'op' => 'task',
    'name' => 'Import Blog Posts',
]);

\Sentry\SentrySdk::getCurrentHub()->setSpan($transaction);

try {
    // Create child span for database operation
    $span = $transaction->startChild([
        'op' => 'db.query',
        'description' => 'Bulk insert blog posts',
    ]);

    // Your code here
    BlogPost::insert($posts);

    $span->finish();

} finally {
    $transaction->finish();
}
```

## Alerting & Notifications

### 1. Configure Slack Integration

**In Sentry Dashboard:**
1. Settings → Integrations
2. Find Slack → Install
3. Choose channel: `#production-errors`
4. Configure alert rules

**Recommended Alert Rules:**

```yaml
New Issue:
  - When: A new issue is created
  - Notify: #production-errors
  - For: All issues

High Volume:
  - When: Issue occurs 10+ times in 1 hour
  - Notify: #production-errors, @oncall
  - For: All issues

Regression:
  - When: Resolved issue happens again
  - Notify: #production-errors
  - For: All issues

Critical Error:
  - When: Exception type = Critical
  - Notify: #production-errors, @oncall, SMS
  - For: Fatal errors, database errors
```

### 2. Email Notifications

**Settings → Alerts → Create Alert Rule:**

```yaml
Name: Production Critical Errors
Conditions:
  - Event Level: Error or Fatal
  - Tags: environment = production
Actions:
  - Send email to: team@company.com
  - Frequency: Real-time
```

### 3. Custom Alert Rules

```php
// Tag errors as critical in your code
try {
    // Critical operation
    DB::transaction(function () {
        // Important logic
    });
} catch (\Exception $e) {
    \Sentry\configureScope(function (Scope $scope): void {
        $scope->setLevel(\Sentry\Severity::fatal());
        $scope->setTag('critical', 'true');
    });

    \Sentry\captureException($e);

    throw $e;
}
```

## Best Practices

### 1. Don't Send Sensitive Data

```php
// config/sentry.php
'send_default_pii' => false,  // Never send PII by default

'before_send' => function (\Sentry\Event $event): ?\Sentry\Event {
    // Remove sensitive data
    if ($event->getRequest()) {
        $request = $event->getRequest();

        // Scrub passwords
        $data = $request->getData();
        if (isset($data['password'])) {
            $data['password'] = '***REDACTED***';
        }
        $request->setData($data);
    }

    return $event;
},
```

### 2. Filter Noise

```php
// Don't send validation errors
'integrations' => [
    new \Sentry\Integration\IgnoreErrorsIntegration([
        'ignore_exceptions' => [
            \Illuminate\Validation\ValidationException::class,
            \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
        ],
    ]),
],
```

### 3. Use Breadcrumbs Wisely

```php
// Good: Adds context
\Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
    \Sentry\Breadcrumb::LEVEL_INFO,
    \Sentry\Breadcrumb::TYPE_DEFAULT,
    'payment',
    'Processing payment',
    ['amount' => 100, 'method' => 'credit_card']
));

// Bad: Too much detail, potential PII
\Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
    \Sentry\Breadcrumb::LEVEL_INFO,
    \Sentry\Breadcrumb::TYPE_DEFAULT,
    'user',
    'User data',
    $request->all()  // Don't send all request data!
));
```

### 4. Set Appropriate Sample Rates

```bash
# Production: 20% sampling (cost-effective)
SENTRY_TRACES_SAMPLE_RATE=0.2

# Staging: 100% sampling (catch everything)
SENTRY_TRACES_SAMPLE_RATE=1.0

# High-traffic: Lower rate
SENTRY_TRACES_SAMPLE_RATE=0.05
```

### 5. Use Environments Properly

```bash
# Separate projects for different environments
Production: https://prod-key@sentry.io/prod-project-id
Staging: https://staging-key@sentry.io/staging-project-id

# Or use same project with environment tag
SENTRY_ENVIRONMENT=production
SENTRY_ENVIRONMENT=staging
```

## Monitoring Dashboard

### Key Metrics to Watch

1. **Error Rate**
   - Spike = potential issue
   - Sustained high rate = critical problem

2. **Unique Users Affected**
   - Shows user impact
   - Prioritize issues affecting many users

3. **Error Frequency**
   - One-off errors vs. recurring issues
   - Recurring = systematic problem

4. **Performance Trends**
   - Slow endpoints
   - Database query performance
   - External API latency

### Setting Up Views

**Create these views in Sentry:**

1. **Critical Errors** (Priority 1)
   - Level: Error, Fatal
   - Environment: Production
   - Unresolved issues only

2. **High Volume Issues**
   - Events in last 24h: >100
   - Status: Unresolved

3. **Recent Regressions**
   - Status: Regressed
   - Last seen: Past 7 days

4. **Performance Issues**
   - Type: Performance
   - P95 Duration: >1000ms

## Cost Management

### Free Tier Limits

**Sentry Free:**
- 5,000 errors/month
- 10,000 performance units/month
- 1 project
- 7-day retention

**Staying Under Limits:**

```php
// 1. Sample transactions (not all requests)
'traces_sample_rate' => 0.2,  // 20% of requests

// 2. Filter out noise
'ignore_exceptions' => [
    \Illuminate\Validation\ValidationException::class,
],

// 3. Don't send from development
if (app()->environment('production')) {
    \Sentry\captureException($e);
}
```

### Monitoring Usage

**Sentry Dashboard:**
- Settings → Usage & Billing
- Monitor events per day
- Set quota alerts at 80%

**If you exceed:**
- Errors stop being captured
- Upgrade to paid plan ($26/month for 50K events)
- Or reduce sample rates

## Troubleshooting

### Events Not Appearing

```bash
# 1. Test connection
php artisan sentry:test

# 2. Check DSN is set
php artisan tinker
>>> config('sentry.dsn')

# 3. Check environment
>>> app()->environment()

# 4. Manually send test
\Sentry\captureMessage('Test from tinker');

# 5. Check logs
tail -f storage/logs/laravel.log
```

### Too Many Events

```php
// Reduce sample rate
'traces_sample_rate' => 0.1,  // 10% instead of 20%

// Add more ignored exceptions
'ignore_exceptions' => [
    // Add chatty exceptions
],

// Use before_send to filter
'before_send' => function ($event) {
    if (random_int(1, 100) > 50) {  // Send only 50%
        return null;
    }
    return $event;
},
```

### Missing Context

```php
// Add more breadcrumbs
\Sentry\addBreadcrumb(...);

// Set more tags
\Sentry\configureScope(function (Scope $scope): void {
    $scope->setTag('feature', 'checkout');
    $scope->setTag('user_type', 'premium');
});

// Add extra context
\Sentry\configureScope(function (Scope $scope): void {
    $scope->setContext('order', [
        'id' => $order->id,
        'total' => $order->total,
    ]);
});
```

## Deployment Checklist

```bash
# Before Launch
[ ] Sentry account created
[ ] Project configured
[ ] DSN added to .env
[ ] Test event sent successfully
[ ] Frontend tracking configured
[ ] Slack alerts configured
[ ] Team members invited
[ ] Alert rules created
[ ] Performance monitoring enabled

# After Launch
[ ] Monitor dashboard daily (first week)
[ ] Review and resolve critical errors
[ ] Adjust sample rates if needed
[ ] Set up weekly error review meeting
[ ] Create runbook for common errors
```

## Support

- **Sentry Documentation:** https://docs.sentry.io/platforms/php/guides/laravel/
- **Laravel Package:** https://github.com/getsentry/sentry-laravel
- **Community:** https://discord.gg/sentry
- **Support:** support@sentry.io (paid plans)

## Next Steps

After implementing Sentry:

1. **Week 1:** Monitor actively, resolve critical issues
2. **Week 2:** Create error response runbook
3. **Month 1:** Analyze trends, optimize sample rates
4. **Ongoing:** Weekly error review, continuous improvement
