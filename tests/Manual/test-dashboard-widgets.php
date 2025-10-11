<?php

/**
 * Comprehensive test script for Dashboard Analytics Widgets
 * Run with: php test-dashboard-widgets.php
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Service;
use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\User;
use App\Models\CorePage;
use App\Models\LandingPage;
use App\Filament\Widgets\ContactSubmissionsStatsWidget;
use App\Filament\Widgets\RecentContactSubmissionsWidget;
use App\Filament\Widgets\ServicePopularityWidget;
use App\Filament\Widgets\SystemHealthWidget;
use App\Filament\Widgets\QuickStatsOverview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n=== Testing Dashboard Analytics Widgets ===\n\n";

// Helper function to print results
function printResult($test, $passed, $details = '') {
    echo $passed ? "✅ " : "❌ ";
    echo "$test\n";
    if ($details) {
        echo "   $details\n";
    }
    return $passed;
}

// Helper to safely call widget methods
function safeWidgetCall(callable $callback, string $widgetName, string $method = 'getData') {
    try {
        return $callback();
    } catch (\Exception $e) {
        echo "❌ {$widgetName}::{$method} failed: " . $e->getMessage() . "\n";
        return null;
    }
}

// Test counters
$totalTests = 0;
$passedTests = 0;

echo "1. Testing Contact Submissions Stats Widget\n";
echo "-------------------------------------------\n";

try {
    $widget = new ContactSubmissionsStatsWidget();

    // Test widget instantiation
    $totalTests++;
    if (printResult("ContactSubmissionsStatsWidget instantiation", $widget !== null)) {
        $passedTests++;
    }

    // Test stats generation
    $stats = safeWidgetCall(function() use ($widget) {
        // Use reflection to access protected method
        $reflection = new ReflectionClass($widget);
        $method = $reflection->getMethod('getStats');
        $method->setAccessible(true);
        return $method->invoke($widget);
    }, 'ContactSubmissionsStatsWidget', 'getStats');

    $totalTests++;
    if (printResult("Contact stats generation", $stats !== null && is_array($stats))) {
        $passedTests++;

        // Test individual stats
        $totalTests++;
        if (printResult("  ↳ Stats array contains 4 elements", count($stats) === 4)) {
            $passedTests++;
        }

        // Test stat objects
        foreach ($stats as $index => $stat) {
            $totalTests++;
            $statName = ['Today\'s', 'Week', 'Month', 'Unread'][$index] ?? "Stat $index";
            if (printResult("  ↳ {$statName} stat is valid",
                is_object($stat) && method_exists($stat, 'getState'))) {
                $passedTests++;
            }
        }
    }

    // Test chart generation methods
    $chartMethods = ['getHourlyChart', 'getDailyChart', 'getWeeklyChart'];
    foreach ($chartMethods as $methodName) {
        $chart = safeWidgetCall(function() use ($widget, $methodName) {
            $reflection = new ReflectionClass($widget);
            $method = $reflection->getMethod($methodName);
            $method->setAccessible(true);
            return $method->invoke($widget);
        }, 'ContactSubmissionsStatsWidget', $methodName);

        $totalTests++;
        if (printResult("  ↳ {$methodName} generates array",
            $chart !== null && is_array($chart))) {
            $passedTests++;
        }
    }

} catch (\Exception $e) {
    echo "❌ ContactSubmissionsStatsWidget testing failed: " . $e->getMessage() . "\n";
}

echo "\n2. Testing Recent Contact Submissions Widget\n";
echo "---------------------------------------------\n";

try {
    $widget = new RecentContactSubmissionsWidget();

    $totalTests++;
    if (printResult("RecentContactSubmissionsWidget instantiation", $widget !== null)) {
        $passedTests++;
    }

    // Test table configuration
    $table = safeWidgetCall(function() use ($widget) {
        return $widget->table(new \Filament\Tables\Table($widget));
    }, 'RecentContactSubmissionsWidget', 'table');

    $totalTests++;
    if (printResult("Table configuration", $table !== null)) {
        $passedTests++;

        // Test if query returns results without errors
        try {
            $query = $table->getQuery();
            $count = $query->count();
            $totalTests++;
            if (printResult("  ↳ Query executes successfully", $count >= 0)) {
                $passedTests++;
            }
        } catch (\Exception $e) {
            $totalTests++;
            printResult("  ↳ Query executes successfully", false, $e->getMessage());
        }
    }

} catch (\Exception $e) {
    echo "❌ RecentContactSubmissionsWidget testing failed: " . $e->getMessage() . "\n";
}

echo "\n3. Testing Service Popularity Widget\n";
echo "------------------------------------\n";

try {
    $widget = new ServicePopularityWidget();

    $totalTests++;
    if (printResult("ServicePopularityWidget instantiation", $widget !== null)) {
        $passedTests++;
    }

    // Test data generation
    $data = safeWidgetCall(function() use ($widget) {
        $reflection = new ReflectionClass($widget);
        $method = $reflection->getMethod('getData');
        $method->setAccessible(true);
        return $method->invoke($widget);
    }, 'ServicePopularityWidget', 'getData');

    $totalTests++;
    if (printResult("Service popularity data generation", $data !== null && is_array($data))) {
        $passedTests++;

        // Validate data structure
        $totalTests++;
        if (printResult("  ↳ Data has required structure",
            isset($data['datasets']) && isset($data['labels']))) {
            $passedTests++;
        }

        // Test chart options
        $options = safeWidgetCall(function() use ($widget) {
            $reflection = new ReflectionClass($widget);
            $method = $reflection->getMethod('getOptions');
            $method->setAccessible(true);
            return $method->invoke($widget);
        }, 'ServicePopularityWidget', 'getOptions');

        $totalTests++;
        if (printResult("  ↳ Chart options generated",
            $options !== null && is_array($options))) {
            $passedTests++;
        }
    }

    // Test service name formatting
    $testServices = ['pool-resurfacing-conversion', 'general_inquiry', 'unknown-service'];
    foreach ($testServices as $service) {
        $formattedName = safeWidgetCall(function() use ($widget, $service) {
            $reflection = new ReflectionClass($widget);
            $method = $reflection->getMethod('formatServiceName');
            $method->setAccessible(true);
            return $method->invoke($widget, $service);
        }, 'ServicePopularityWidget', 'formatServiceName');

        $totalTests++;
        if (printResult("  ↳ Service name formatting: {$service}",
            !empty($formattedName) && is_string($formattedName))) {
            $passedTests++;
        }
    }

} catch (\Exception $e) {
    echo "❌ ServicePopularityWidget testing failed: " . $e->getMessage() . "\n";
}

echo "\n4. Testing System Health Widget\n";
echo "-------------------------------\n";

try {
    $widget = new SystemHealthWidget();

    $totalTests++;
    if (printResult("SystemHealthWidget instantiation", $widget !== null)) {
        $passedTests++;
    }

    // Test stats generation
    $stats = safeWidgetCall(function() use ($widget) {
        $reflection = new ReflectionClass($widget);
        $method = $reflection->getMethod('getStats');
        $method->setAccessible(true);
        return $method->invoke($widget);
    }, 'SystemHealthWidget', 'getStats');

    $totalTests++;
    if (printResult("System health stats generation", $stats !== null && is_array($stats))) {
        $passedTests++;

        $totalTests++;
        if (printResult("  ↳ Stats array contains 4 elements", count($stats) === 4)) {
            $passedTests++;
        }
    }

    // Test individual health check methods
    $healthMethods = ['getDatabaseHealthStat', 'getCacheHealthStat', 'getContentHealthStat', 'getUserActivityStat'];
    foreach ($healthMethods as $methodName) {
        $stat = safeWidgetCall(function() use ($widget, $methodName) {
            $reflection = new ReflectionClass($widget);
            $method = $reflection->getMethod($methodName);
            $method->setAccessible(true);
            return $method->invoke($widget);
        }, 'SystemHealthWidget', $methodName);

        $totalTests++;
        if (printResult("  ↳ {$methodName}",
            $stat !== null && is_object($stat))) {
            $passedTests++;
        }
    }

    // Test database size calculation
    $dbSize = safeWidgetCall(function() use ($widget) {
        $reflection = new ReflectionClass($widget);
        $method = $reflection->getMethod('getDatabaseSize');
        $method->setAccessible(true);
        return $method->invoke($widget);
    }, 'SystemHealthWidget', 'getDatabaseSize');

    $totalTests++;
    if (printResult("  ↳ Database size calculation",
        $dbSize !== null && is_string($dbSize))) {
        $passedTests++;
    }

} catch (\Exception $e) {
    echo "❌ SystemHealthWidget testing failed: " . $e->getMessage() . "\n";
}

echo "\n5. Testing Quick Stats Overview Widget\n";
echo "--------------------------------------\n";

try {
    $widget = new QuickStatsOverview();

    $totalTests++;
    if (printResult("QuickStatsOverview instantiation", $widget !== null)) {
        $passedTests++;
    }

    // Test stats generation
    $stats = safeWidgetCall(function() use ($widget) {
        $reflection = new ReflectionClass($widget);
        $method = $reflection->getMethod('getStats');
        $method->setAccessible(true);
        return $method->invoke($widget);
    }, 'QuickStatsOverview', 'getStats');

    $totalTests++;
    if (printResult("Quick stats generation", $stats !== null && is_array($stats))) {
        $passedTests++;

        $totalTests++;
        if (printResult("  ↳ Stats array contains 3 elements", count($stats) === 3)) {
            $passedTests++;
        }

        // Test if all stats have required properties
        foreach ($stats as $index => $stat) {
            $statNames = ['Active Services', 'Published Posts', 'Active Pages'];
            $totalTests++;
            if (printResult("  ↳ {$statNames[$index]} stat is valid",
                is_object($stat) && method_exists($stat, 'getState'))) {
                $passedTests++;
            }
        }
    }

} catch (\Exception $e) {
    echo "❌ QuickStatsOverview testing failed: " . $e->getMessage() . "\n";
}

echo "\n6. Testing Database Operations and Data Integrity\n";
echo "-------------------------------------------------\n";

try {
    // Test basic model counts
    $serviceCount = Service::count();
    $blogPostCount = BlogPost::count();
    $contactCount = ContactSubmission::count();
    $userCount = User::count();

    $totalTests++;
    if (printResult("Model counts accessible",
        $serviceCount >= 0 && $blogPostCount >= 0 && $contactCount >= 0 && $userCount >= 0)) {
        $passedTests++;
        echo "   Services: {$serviceCount}, Posts: {$blogPostCount}, Contacts: {$contactCount}, Users: {$userCount}\n";
    }

    // Test database connection
    try {
        $startTime = microtime(true);
        DB::select('SELECT 1');
        $responseTime = round((microtime(true) - $startTime) * 1000, 2);

        $totalTests++;
        if (printResult("Database connection and performance", $responseTime < 1000)) {
            $passedTests++;
            echo "   Response time: {$responseTime}ms\n";
        }
    } catch (\Exception $e) {
        $totalTests++;
        printResult("Database connection and performance", false, $e->getMessage());
    }

    // Test cache functionality
    try {
        $testKey = 'widget_test_' . time();
        Cache::put($testKey, 'test_value', 60);
        $retrieved = Cache::get($testKey);
        Cache::forget($testKey);

        $totalTests++;
        if (printResult("Cache system functionality", $retrieved === 'test_value')) {
            $passedTests++;
        }
    } catch (\Exception $e) {
        $totalTests++;
        printResult("Cache system functionality", false, $e->getMessage());
    }

} catch (\Exception $e) {
    echo "❌ Database operations testing failed: " . $e->getMessage() . "\n";
}

echo "\n7. Testing Widget Error Handling\n";
echo "--------------------------------\n";

try {
    // Test widgets with potentially problematic data

    // Create a mock ContactSubmission with unusual data
    if (ContactSubmission::count() === 0) {
        ContactSubmission::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '123-456-7890',
            'service' => 'test-service-with-very-long-name-that-might-cause-issues',
            'source' => 'test_source',
            'message' => 'Test message',
            'is_read' => false,
        ]);
        echo "   Created test ContactSubmission for error handling tests\n";
    }

    // Test widget resilience with edge cases
    $widget = new ContactSubmissionsStatsWidget();

    // Test with date ranges that might have no data
    $reflection = new ReflectionClass($widget);
    $method = $reflection->getMethod('getStats');
    $method->setAccessible(true);

    $stats = $method->invoke($widget);
    $totalTests++;
    if (printResult("Widget handles edge case data gracefully",
        $stats !== null && is_array($stats) && count($stats) === 4)) {
        $passedTests++;
    }

    // Test service popularity widget with no data
    $popularity = new ServicePopularityWidget();
    $reflection = new ReflectionClass($popularity);
    $method = $reflection->getMethod('getData');
    $method->setAccessible(true);

    $data = $method->invoke($popularity);
    $totalTests++;
    if (printResult("Service popularity handles no-data case",
        $data !== null && isset($data['labels']) && isset($data['datasets']))) {
        $passedTests++;
    }

} catch (\Exception $e) {
    echo "❌ Widget error handling testing failed: " . $e->getMessage() . "\n";
}

echo "\n8. Testing Widget Performance\n";
echo "-----------------------------\n";

try {
    $widgets = [
        'ContactSubmissionsStatsWidget' => new ContactSubmissionsStatsWidget(),
        'ServicePopularityWidget' => new ServicePopularityWidget(),
        'SystemHealthWidget' => new SystemHealthWidget(),
        'QuickStatsOverview' => new QuickStatsOverview(),
    ];

    foreach ($widgets as $widgetName => $widget) {
        $startTime = microtime(true);

        try {
            $reflection = new ReflectionClass($widget);
            if ($widgetName === 'ServicePopularityWidget') {
                $method = $reflection->getMethod('getData');
            } else {
                $method = $reflection->getMethod('getStats');
            }
            $method->setAccessible(true);
            $method->invoke($widget);

            $executionTime = round((microtime(true) - $startTime) * 1000, 2);

            $totalTests++;
            if (printResult("{$widgetName} performance", $executionTime < 2000)) {
                $passedTests++;
                echo "   Execution time: {$executionTime}ms\n";
            }
        } catch (\Exception $e) {
            $totalTests++;
            printResult("{$widgetName} performance", false, $e->getMessage());
        }
    }

} catch (\Exception $e) {
    echo "❌ Widget performance testing failed: " . $e->getMessage() . "\n";
}

echo "\n=============================\n";
echo "Test Results Summary\n";
echo "=============================\n";
echo "Total Tests: $totalTests\n";
echo "Passed: $passedTests\n";
echo "Failed: " . ($totalTests - $passedTests) . "\n";
echo "Success Rate: " . ($totalTests > 0 ? round(($passedTests / $totalTests) * 100, 2) : 0) . "%\n";

// Dashboard statistics
echo "\nDashboard Data Summary:\n";
echo "----------------------\n";
echo "Services: " . Service::count() . " (Active: " . Service::where('is_active', true)->count() . ")\n";
echo "Blog Posts: " . BlogPost::count() . " (Published: " . BlogPost::where('is_published', true)->count() . ")\n";
echo "Contact Submissions: " . ContactSubmission::count() . " (Unread: " . ContactSubmission::where('is_read', false)->count() . ")\n";
echo "Core Pages: " . CorePage::count() . " (Active: " . CorePage::where('is_active', true)->count() . ")\n";
echo "Landing Pages: " . LandingPage::count() . " (Active: " . LandingPage::where('is_active', true)->count() . ")\n";
echo "Users: " . User::count() . "\n";

// Contact submissions by time period
echo "\nContact Submissions by Period:\n";
echo "------------------------------\n";
echo "Today: " . ContactSubmission::whereDate('created_at', Carbon::today())->count() . "\n";
echo "This Week: " . ContactSubmission::where('created_at', '>=', Carbon::now()->startOfWeek())->count() . "\n";
echo "This Month: " . ContactSubmission::where('created_at', '>=', Carbon::now()->startOfMonth())->count() . "\n";

// Service requests breakdown
echo "\nService Requests (Last 30 days):\n";
echo "---------------------------------\n";
$serviceRequests = ContactSubmission::where('created_at', '>=', Carbon::now()->subDays(30))
    ->whereNotNull('service')
    ->select('service', DB::raw('count(*) as count'))
    ->groupBy('service')
    ->orderByDesc('count')
    ->limit(10)
    ->get();

if ($serviceRequests->count() > 0) {
    foreach ($serviceRequests as $request) {
        echo "- {$request->service}: {$request->count} requests\n";
    }
} else {
    echo "- No service requests in the last 30 days\n";
}

if ($passedTests === $totalTests) {
    echo "\n✅ All dashboard widget tests passed successfully!\n";
    echo "Dashboard Analytics system is working correctly.\n";
} else {
    echo "\n⚠️  Some tests failed. Please review the results above.\n";
}

echo "\n";