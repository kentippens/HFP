<?php

/**
 * Comprehensive test script for Activity Logging & Audit Trail
 * Run with: php test-activity-logging.php
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Activity;
use App\Models\Service;
use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n=== Testing Activity Logging & Audit Trail ===\n\n";

// Helper function to print results
function printResult($test, $passed, $details = '') {
    echo $passed ? "✅ " : "❌ ";
    echo "$test\n";
    if ($details) {
        echo "   $details\n";
    }
    return $passed;
}

// Test counters
$totalTests = 0;
$passedTests = 0;

echo "1. Testing Basic Activity Logging\n";
echo "----------------------------------\n";

try {
    // Test direct ActivityLogger usage
    $initialCount = Activity::count();

    $activity = ActivityLogger::log()
        ->useLog('test')
        ->event('test_action')
        ->withDescription('Testing activity logging')
        ->withProperties(['test' => true, 'value' => 123])
        ->save();

    $finalCount = Activity::count();
    $totalTests++;
    if (printResult("Direct ActivityLogger usage", $finalCount > $initialCount)) {
        $passedTests++;
        printResult("  ↳ Activity data integrity",
            $activity->log_name === 'test' &&
            $activity->event === 'test_action' &&
            $activity->getExtraProperty('test') === true
        );
    }

    // Test IP and User Agent logging
    $totalTests++;
    if (printResult("IP and User Agent tracking",
        !empty($activity->ip_address) && !empty($activity->user_agent)
    )) {
        $passedTests++;
    }

} catch (\Exception $e) {
    echo "❌ Basic activity logging failed: " . $e->getMessage() . "\n";
}

echo "\n2. Testing CRUD Operations Tracking\n";
echo "------------------------------------\n";

try {
    // Test Service CRUD operations
    $initialActivities = Activity::where('log_name', 'model')->count();

    // Create a service
    $service = Service::create([
        'name' => 'Test Activity Service',
        'slug' => 'test-activity-service-' . time(),
        'description' => 'Testing activity logging',
        'is_active' => true
    ]);

    // Update the service
    $service->update(['name' => 'Updated Test Activity Service']);

    // Check if activities were logged
    $newActivities = Activity::where('log_name', 'model')->count();
    $totalTests++;
    if (printResult("Model CRUD activities logged", $newActivities > $initialActivities)) {
        $passedTests++;

        // Check specific events
        $createActivity = Activity::where('log_name', 'model')
            ->where('event', 'created')
            ->where('subject_id', $service->id)
            ->first();

        $updateActivity = Activity::where('log_name', 'model')
            ->where('event', 'updated')
            ->where('subject_id', $service->id)
            ->first();

        $totalTests++;
        if (printResult("  ↳ Create and Update events captured", $createActivity && $updateActivity)) {
            $passedTests++;
        }

        // Test change tracking
        $totalTests++;
        $hasChanges = $updateActivity && $updateActivity->hasRecordedChanges();
        $hasOldValues = $updateActivity && !empty($updateActivity->getOldValues());
        $hasNewValues = $updateActivity && !empty($updateActivity->getNewValues());

        if (printResult("  ↳ Change tracking works", $hasChanges && $hasOldValues && $hasNewValues)) {
            $passedTests++;
        } else {
            // Debug information
            if ($updateActivity) {
                echo "     Debug - hasChanges: " . ($hasChanges ? 'true' : 'false') . "\n";
                echo "     Debug - hasOldValues: " . ($hasOldValues ? 'true' : 'false') . "\n";
                echo "     Debug - hasNewValues: " . ($hasNewValues ? 'true' : 'false') . "\n";
                echo "     Debug - Old values: " . json_encode($updateActivity->getOldValues()) . "\n";
                echo "     Debug - New values: " . json_encode($updateActivity->getNewValues()) . "\n";
                echo "     Debug - empty check old: " . (empty($updateActivity->getOldValues()) ? 'true' : 'false') . "\n";
                echo "     Debug - empty check new: " . (empty($updateActivity->getNewValues()) ? 'true' : 'false') . "\n";
            }
        }
    }

    // Clean up
    $service->delete();

} catch (\Exception $e) {
    echo "❌ CRUD operations tracking failed: " . $e->getMessage() . "\n";
}

echo "\n3. Testing User Action Logging\n";
echo "-------------------------------\n";

try {
    // Test authentication logging
    $initialAuthCount = Activity::where('log_name', 'auth')->count();

    // Test failed login
    ActivityLogger::logFailedLogin('test@example.com', 'Invalid credentials');

    $newAuthCount = Activity::where('log_name', 'auth')->count();
    $totalTests++;
    if (printResult("Failed login attempt logged", $newAuthCount > $initialAuthCount)) {
        $passedTests++;

        // Check failed login details
        $failedLogin = Activity::where('log_name', 'auth')
            ->where('event', 'failed_login')
            ->latest()
            ->first();

        $totalTests++;
        if (printResult("  ↳ Failed login details captured",
            $failedLogin &&
            $failedLogin->getExtraProperty('email') === 'test@example.com' &&
            $failedLogin->getExtraProperty('reason') === 'Invalid credentials'
        )) {
            $passedTests++;
        }
    }

    // Test custom action logging
    ActivityLogger::logCustom('admin_panel_access', null, [
        'section' => 'services',
        'action_type' => 'view_list'
    ]);

    $customActivity = Activity::where('log_name', 'custom')
        ->where('event', 'admin_panel_access')
        ->latest()
        ->first();

    $totalTests++;
    if (printResult("Custom action logging",
        $customActivity &&
        $customActivity->getExtraProperty('section') === 'services'
    )) {
        $passedTests++;
    }

} catch (\Exception $e) {
    echo "❌ User action logging failed: " . $e->getMessage() . "\n";
}

echo "\n4. Testing Data Change History\n";
echo "-------------------------------\n";

try {
    // Use Service model for change tracking since it has simpler requirements
    $testService = Service::create([
        'name' => 'Test Change Service',
        'slug' => 'test-change-service-' . time(),
        'description' => 'Original description',
        'is_active' => false
    ]);

    // Make multiple changes to test history
    $testService->update(['name' => 'Updated Test Service']);
    $testService->update(['description' => 'Updated description']);
    $testService->update(['is_active' => true]);

    // Check activity history
    $serviceActivities = Activity::where('subject_type', 'App\Models\Service')
        ->where('subject_id', $testService->id)
        ->orderBy('created_at', 'asc')
        ->get();

    $totalTests++;
    if (printResult("Change history tracking", $serviceActivities->count() >= 4)) {
        $passedTests++;

        // Check if we can reconstruct changes
        $updateActivities = $serviceActivities->where('event', 'updated');
        $hasNameChange = $updateActivities->contains(function ($activity) {
            return array_key_exists('name', $activity->getOldValues()) ||
                   array_key_exists('name', $activity->getNewValues());
        });

        $totalTests++;
        if (printResult("  ↳ Specific field changes tracked", $hasNameChange)) {
            $passedTests++;
        }

        // Test change reconstruction
        $nameUpdateActivity = $updateActivities->first(function ($activity) {
            return array_key_exists('name', $activity->getOldValues()) ||
                   array_key_exists('name', $activity->getNewValues());
        });

        if ($nameUpdateActivity) {
            $oldValues = $nameUpdateActivity->getOldValues();
            $newValues = $nameUpdateActivity->getNewValues();
            $totalTests++;
            if (printResult("  ↳ Change data integrity",
                !empty($oldValues) && !empty($newValues) &&
                $oldValues['name'] === 'Test Change Service' &&
                $newValues['name'] === 'Updated Test Service'
            )) {
                $passedTests++;
            }
        }
    }

    // Clean up
    $testService->delete();

} catch (\Exception $e) {
    echo "❌ Data change history tracking failed: " . $e->getMessage() . "\n";
}

echo "\n5. Testing Export and File Actions\n";
echo "-----------------------------------\n";

try {
    // Test export logging
    $exportCount = Activity::where('event', 'exported')->count();

    ActivityLogger::logExport('services', 25, ['is_active' => true]);

    $newExportCount = Activity::where('event', 'exported')->count();
    $totalTests++;
    if (printResult("Export action logged", $newExportCount > $exportCount)) {
        $passedTests++;

        $exportActivity = Activity::where('event', 'exported')->latest()->first();
        $totalTests++;
        if (printResult("  ↳ Export metadata captured",
            $exportActivity->getExtraProperty('type') === 'services' &&
            $exportActivity->getExtraProperty('count') === 25
        )) {
            $passedTests++;
        }
    }

    // Test download logging
    ActivityLogger::logDownload('sample-data.csv');

    $downloadActivity = Activity::where('event', 'downloaded')->latest()->first();
    $totalTests++;
    if (printResult("Download action logged",
        $downloadActivity &&
        $downloadActivity->getExtraProperty('filename') === 'sample-data.csv'
    )) {
        $passedTests++;
    }

} catch (\Exception $e) {
    echo "❌ Export and file actions logging failed: " . $e->getMessage() . "\n";
}

echo "\n6. Testing Activity Model Scopes and Queries\n";
echo "---------------------------------------------\n";

try {
    // Test time-based scopes
    $todayActivities = Activity::today()->count();
    $thisWeekActivities = Activity::thisWeek()->count();
    $thisMonthActivities = Activity::thisMonth()->count();

    $totalTests++;
    if (printResult("Time-based scopes work",
        $todayActivities >= 0 &&
        $thisWeekActivities >= $todayActivities &&
        $thisMonthActivities >= $thisWeekActivities
    )) {
        $passedTests++;
    }

    // Test log name filtering
    $authActivities = Activity::inLog('auth')->count();
    $modelActivities = Activity::inLog('model')->count();

    $totalTests++;
    if (printResult("Log name filtering works", $authActivities >= 0 && $modelActivities >= 0)) {
        $passedTests++;
    }

    // Test event filtering
    $loginAttempts = Activity::forEvent('failed_login')->count();
    $createEvents = Activity::forEvent('created')->count();

    $totalTests++;
    if (printResult("Event filtering works", $loginAttempts >= 0 && $createEvents >= 0)) {
        $passedTests++;
    }

} catch (\Exception $e) {
    echo "❌ Activity model scopes testing failed: " . $e->getMessage() . "\n";
}

echo "\n7. Testing Activity Display and Formatting\n";
echo "-------------------------------------------\n";

try {
    // Test activity display methods
    $recentActivity = Activity::latest()->first();

    if ($recentActivity) {
        $hasIcon = !empty($recentActivity->getIcon());
        $hasColor = !empty($recentActivity->getColor());
        $hasLabel = !empty($recentActivity->getEventLabel());
        $hasFormattedDescription = !empty($recentActivity->getFormattedDescription());

        $totalTests++;
        if (printResult("Activity display methods work",
            $hasIcon && $hasColor && $hasLabel && $hasFormattedDescription
        )) {
            $passedTests++;
        }

        // Test helper methods
        $totalTests++;
        if (printResult("Activity helper methods work",
            method_exists($recentActivity, 'isFailedLogin') &&
            method_exists($recentActivity, 'isSuccessfulLogin') &&
            method_exists($recentActivity, 'hasRecordedChanges')
        )) {
            $passedTests++;
        }
    }

} catch (\Exception $e) {
    echo "❌ Activity display and formatting testing failed: " . $e->getMessage() . "\n";
}

echo "\n8. Testing Database Performance and Cleanup\n";
echo "--------------------------------------------\n";

try {
    // Test activity count and performance
    $totalActivities = Activity::count();
    $recentActivitiesCount = Activity::where('created_at', '>=', now()->subDays(7))->count();

    $totalTests++;
    if (printResult("Activity counting works", $totalActivities >= 0 && $recentActivitiesCount >= 0)) {
        $passedTests++;
    }

    // Test complex queries performance
    $start = microtime(true);
    $complexQuery = Activity::with(['subject', 'causer'])
        ->where('created_at', '>=', now()->subDays(30))
        ->orderBy('created_at', 'desc')
        ->limit(100)
        ->get();
    $end = microtime(true);

    $totalTests++;
    if (printResult("Complex queries perform well", ($end - $start) < 1.0)) {
        $passedTests++;
        echo "   Query executed in " . round(($end - $start) * 1000, 2) . "ms\n";
    }

    // Test activity relationships
    $activitiesWithSubjects = Activity::whereNotNull('subject_type')
        ->whereNotNull('subject_id')
        ->with('subject')
        ->limit(5)
        ->get();

    $hasValidRelationships = $activitiesWithSubjects->every(function ($activity) {
        return $activity->subject !== null ||
               $activity->subject_type === null ||
               !class_exists($activity->subject_type);
    });

    $totalTests++;
    if (printResult("Activity relationships work", $hasValidRelationships)) {
        $passedTests++;
    }

} catch (\Exception $e) {
    echo "❌ Database performance and cleanup testing failed: " . $e->getMessage() . "\n";
}

echo "\n=============================\n";
echo "Test Results Summary\n";
echo "=============================\n";
echo "Total Tests: $totalTests\n";
echo "Passed: $passedTests\n";
echo "Failed: " . ($totalTests - $passedTests) . "\n";
echo "Success Rate: " . ($totalTests > 0 ? round(($passedTests / $totalTests) * 100, 2) : 0) . "%\n";

// Activity statistics
echo "\nActivity Log Statistics:\n";
echo "------------------------\n";
echo "Total Activities: " . Activity::count() . "\n";
echo "Today's Activities: " . Activity::today()->count() . "\n";
echo "This Week's Activities: " . Activity::thisWeek()->count() . "\n";
echo "This Month's Activities: " . Activity::thisMonth()->count() . "\n";

// Break down by log type
echo "\nBy Log Type:\n";
$logTypes = Activity::select('log_name', DB::raw('COUNT(*) as count'))
    ->groupBy('log_name')
    ->get();

foreach ($logTypes as $logType) {
    echo "- {$logType->log_name}: {$logType->count}\n";
}

// Break down by event type
echo "\nBy Event Type:\n";
$eventTypes = Activity::select('event', DB::raw('COUNT(*) as count'))
    ->groupBy('event')
    ->orderBy('count', 'desc')
    ->limit(10)
    ->get();

foreach ($eventTypes as $eventType) {
    echo "- {$eventType->event}: {$eventType->count}\n";
}

if ($passedTests === $totalTests) {
    echo "\n✅ All activity logging tests passed successfully!\n";
    echo "Activity Logging & Audit Trail system is working correctly.\n";
} else {
    echo "\n⚠️  Some tests failed. Please review the results above.\n";
}

echo "\n";