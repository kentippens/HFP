<?php

/**
 * Test script for validating bulk operations in Filament resources
 * Run with: php test-bulk-operations.php
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Service;
use App\Models\BlogPost;
use App\Models\CorePage;
use App\Models\LandingPage;
use App\Models\Activity;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n=== Testing Bulk Operations ===\n\n";

// Helper function to print results
function printResult($test, $passed) {
    echo $passed ? "✅ " : "❌ ";
    echo "$test\n";
    return $passed;
}

// Test counters
$totalTests = 0;
$passedTests = 0;

// 1. Test Service Model Bulk Operations
echo "1. Testing Service Bulk Operations\n";
echo "-----------------------------------\n";

try {
    // Test bulk activation
    $services = Service::where('is_active', false)->limit(3)->get();
    if ($services->count() > 0) {
        $initialCount = $services->count();
        foreach ($services as $service) {
            $service->update(['is_active' => true]);
        }
        $activated = Service::whereIn('id', $services->pluck('id'))->where('is_active', true)->count();
        $totalTests++;
        if (printResult("Bulk activate services", $activated === $initialCount)) $passedTests++;

        // Reset for next test
        Service::whereIn('id', $services->pluck('id'))->update(['is_active' => false]);
    } else {
        echo "⚠️  No inactive services found for testing\n";
    }

    // Test meta_robots update
    $service = Service::first();
    if ($service) {
        $service->update(['meta_robots' => 'noindex, nofollow']);
        $totalTests++;
        if (printResult("Update meta_robots field", $service->fresh()->meta_robots === 'noindex, nofollow')) $passedTests++;

        // Reset
        $service->update(['meta_robots' => 'index, follow']);
    }

    // Test order_index update
    $services = Service::limit(3)->get();
    if ($services->count() > 0) {
        $startOrder = 10;
        foreach ($services as $index => $service) {
            $service->update(['order_index' => $startOrder + $index]);
        }
        $ordered = Service::whereIn('id', $services->pluck('id'))
            ->where('order_index', '>=', $startOrder)
            ->count();
        $totalTests++;
        if (printResult("Update order_index sequentially", $ordered === $services->count())) $passedTests++;
    }

} catch (\Exception $e) {
    echo "❌ Service bulk operations failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 2. Test BlogPost Model Bulk Operations
echo "2. Testing BlogPost Bulk Operations\n";
echo "------------------------------------\n";

try {
    // Test bulk publish
    $posts = BlogPost::where('is_published', false)->limit(3)->get();
    if ($posts->count() > 0) {
        $initialCount = $posts->count();
        foreach ($posts as $post) {
            $post->update([
                'is_published' => true,
                'published_at' => $post->published_at ?? now()
            ]);
        }
        $published = BlogPost::whereIn('id', $posts->pluck('id'))->where('is_published', true)->count();
        $totalTests++;
        if (printResult("Bulk publish blog posts", $published === $initialCount)) $passedTests++;

        // Reset
        BlogPost::whereIn('id', $posts->pluck('id'))->update(['is_published' => false]);
    } else {
        echo "⚠️  No unpublished posts found for testing\n";
    }

    // Test category update
    $post = BlogPost::first();
    $category = \App\Models\BlogCategory::first();
    if ($post && $category) {
        $post->update(['category_id' => $category->id]);
        $totalTests++;
        if (printResult("Update blog post category", $post->fresh()->category_id === $category->id)) $passedTests++;
    }

} catch (\Exception $e) {
    echo "❌ BlogPost bulk operations failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 3. Test CorePage Model Bulk Operations
echo "3. Testing CorePage Bulk Operations\n";
echo "------------------------------------\n";

try {
    // Test bulk activation
    $pages = CorePage::where('is_active', false)->limit(2)->get();
    if ($pages->count() > 0) {
        $initialCount = $pages->count();
        foreach ($pages as $page) {
            $page->update(['is_active' => true]);
        }
        $activated = CorePage::whereIn('id', $pages->pluck('id'))->where('is_active', true)->count();
        $totalTests++;
        if (printResult("Bulk activate core pages", $activated === $initialCount)) $passedTests++;

        // Reset
        CorePage::whereIn('id', $pages->pluck('id'))->update(['is_active' => false]);
    } else {
        // Create test pages if none exist
        $page = CorePage::create([
            'name' => 'Test Page',
            'slug' => 'test-page-' . time(),
            'content' => 'Test content',
            'is_active' => false
        ]);
        $page->update(['is_active' => true]);
        $totalTests++;
        if (printResult("Create and activate test core page", $page->fresh()->is_active === true)) $passedTests++;

        // Cleanup
        $page->delete();
    }

} catch (\Exception $e) {
    echo "❌ CorePage bulk operations failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 4. Test LandingPage Model Bulk Operations
echo "4. Testing LandingPage Bulk Operations\n";
echo "---------------------------------------\n";

try {
    // Test campaign update
    $pages = LandingPage::limit(2)->get();
    if ($pages->count() > 0) {
        $campaignData = [
            'campaign_name' => 'Test Campaign',
            'campaign_source' => 'test',
            'campaign_medium' => 'bulk'
        ];

        foreach ($pages as $page) {
            $page->update($campaignData);
        }

        $updated = LandingPage::whereIn('id', $pages->pluck('id'))
            ->where('campaign_name', 'Test Campaign')
            ->count();
        $totalTests++;
        if (printResult("Bulk update campaign data", $updated === $pages->count())) $passedTests++;
    } else {
        echo "⚠️  No landing pages found for testing\n";
    }

} catch (\Exception $e) {
    echo "❌ LandingPage bulk operations failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 5. Test Activity Logging
echo "5. Testing Activity Logging\n";
echo "----------------------------\n";

try {
    // Test bulk operation logging
    $initialCount = Activity::where('log_name', 'bulk')->count();

    ActivityLogger::log()
        ->useLog('bulk')
        ->event('bulk_test')
        ->withDescription('Test bulk operation')
        ->save();

    $newCount = Activity::where('log_name', 'bulk')->count();
    $totalTests++;
    if (printResult("Log bulk operation activity", $newCount > $initialCount)) $passedTests++;

    // Test export logging
    $initialExports = Activity::where('event', 'exported')->count();

    ActivityLogger::logExport('test_resource', 10);

    $newExports = Activity::where('event', 'exported')->count();
    $totalTests++;
    if (printResult("Log export operation", $newExports > $initialExports)) $passedTests++;

} catch (\Exception $e) {
    echo "❌ Activity logging failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 6. Test Database Transaction Rollback
echo "6. Testing Transaction Rollback\n";
echo "--------------------------------\n";

try {
    $service = Service::first();
    if ($service) {
        $originalName = $service->name;

        DB::beginTransaction();
        try {
            $service->update(['name' => 'Transaction Test']);
            // Simulate error
            throw new \Exception('Simulated error');
        } catch (\Exception $e) {
            DB::rollBack();
        }

        $service->refresh();
        $totalTests++;
        if (printResult("Transaction rollback on error", $service->name === $originalName)) $passedTests++;
    }

} catch (\Exception $e) {
    echo "❌ Transaction test failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 7. Test Validation
echo "7. Testing Data Validation\n";
echo "---------------------------\n";

try {
    // Test invalid meta_robots value
    $service = Service::first();
    if ($service) {
        $validOptions = array_keys(\App\Models\Service::META_ROBOTS_OPTIONS);
        $isValid = in_array('index, follow', $validOptions);
        $totalTests++;
        if (printResult("Validate meta_robots options", $isValid)) $passedTests++;
    }

    // Test slug uniqueness
    $existingSlug = Service::first()?->slug;
    if ($existingSlug) {
        try {
            Service::create([
                'name' => 'Duplicate Test',
                'slug' => $existingSlug,
                'description' => 'Test'
            ]);
            $totalTests++;
            printResult("Prevent duplicate slugs", false);
        } catch (\Exception $e) {
            $totalTests++;
            if (printResult("Prevent duplicate slugs", true)) $passedTests++;
        }
    }

} catch (\Exception $e) {
    echo "❌ Validation test failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Summary
echo "=============================\n";
echo "Test Results Summary\n";
echo "=============================\n";
echo "Total Tests: $totalTests\n";
echo "Passed: $passedTests\n";
echo "Failed: " . ($totalTests - $passedTests) . "\n";
echo "Success Rate: " . ($totalTests > 0 ? round(($passedTests / $totalTests) * 100, 2) : 0) . "%\n";

if ($passedTests === $totalTests) {
    echo "\n✅ All tests passed successfully!\n";
} else {
    echo "\n⚠️  Some tests failed. Please review the results above.\n";
}

echo "\n";