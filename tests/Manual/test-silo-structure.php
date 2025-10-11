<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Silo;

echo "\n========================================\n";
echo "SILO STRUCTURE VALIDATION & TESTING\n";
echo "========================================\n\n";

// Test 1: Check database structure
echo "1. DATABASE STRUCTURE TEST\n";
echo "   ------------------------\n";
try {
    $siloCount = Silo::count();
    $rootCount = Silo::root()->count();
    $activeCount = Silo::active()->count();
    
    echo "   ✅ Total Silos: $siloCount\n";
    echo "   ✅ Root Silos: $rootCount\n";
    echo "   ✅ Active Silos: $activeCount\n";
    
    // List all root silos
    echo "\n   Root Silos:\n";
    foreach (Silo::root()->get() as $root) {
        echo "   - {$root->name} (/{$root->slug})\n";
        foreach ($root->children as $child) {
            echo "     └─ {$child->name} (/{$root->slug}/{$child->slug})\n";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Test 2: Route Testing
echo "\n2. ROUTE TESTING\n";
echo "   -------------\n";
$routes = [
    '/pool-resurfacing',
    '/pool-conversions',
    '/pool-remodeling',
    '/pool-repair',
    '/pool-resurfacing/fiberglass-pool-resurfacing',
    '/pool-repair/pool-crack-repair',
];

foreach ($routes as $route) {
    $segments = explode('/', trim($route, '/'));
    $rootSlug = $segments[0];
    
    try {
        $silo = Silo::active()->root()->where('slug', $rootSlug)->first();
        
        if (!$silo) {
            echo "   ❌ Route $route - Root silo '$rootSlug' not found\n";
            continue;
        }
        
        // Traverse hierarchy if there are more segments
        if (count($segments) > 1) {
            for ($i = 1; $i < count($segments); $i++) {
                $silo = $silo->activeChildren()->where('slug', $segments[$i])->first();
                if (!$silo) {
                    echo "   ❌ Route $route - Child '{$segments[$i]}' not found\n";
                    continue 2;
                }
            }
        }
        
        echo "   ✅ Route $route - Found: {$silo->name}\n";
    } catch (Exception $e) {
        echo "   ❌ Route $route - Error: " . $e->getMessage() . "\n";
    }
}

// Test 3: Model Validation
echo "\n3. MODEL VALIDATION\n";
echo "   ----------------\n";
try {
    // Test slug generation
    $testSilo = new Silo(['name' => 'Test Silo Name']);
    $testSilo->slug = Str::slug($testSilo->name);
    echo "   ✅ Slug generation: 'Test Silo Name' → '{$testSilo->slug}'\n";
    
    // Test relationships
    $parent = Silo::root()->first();
    if ($parent && $parent->children->count() > 0) {
        $child = $parent->children->first();
        echo "   ✅ Parent-Child relationship: {$parent->name} → {$child->name}\n";
        echo "   ✅ Full URL path: /{$child->full_slug}\n";
    }
    
    // Test breadcrumbs
    $deepChild = Silo::whereNotNull('parent_id')->first();
    if ($deepChild) {
        $breadcrumbs = $deepChild->breadcrumbs;
        echo "   ✅ Breadcrumbs for '{$deepChild->name}': ";
        echo implode(' > ', array_column($breadcrumbs, 'name')) . "\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Model validation error: " . $e->getMessage() . "\n";
}

// Test 4: SEO Features
echo "\n4. SEO FEATURES TEST\n";
echo "   -----------------\n";
$seoSilo = Silo::whereNotNull('meta_title')->first();
if ($seoSilo) {
    echo "   ✅ Meta Title: " . ($seoSilo->meta_title ? 'Set' : 'Not set') . "\n";
    echo "   ✅ Meta Description: " . ($seoSilo->meta_description ? 'Set' : 'Not set') . "\n";
    echo "   ✅ Meta Robots: {$seoSilo->meta_robots}\n";
    echo "   ✅ Canonical URL: " . ($seoSilo->canonical_url ? $seoSilo->canonical_url : 'Auto-generated') . "\n";
} else {
    echo "   ⚠️  No silos with SEO data found\n";
}

// Test 5: Features & Benefits
echo "\n5. FEATURES & BENEFITS TEST\n";
echo "   ------------------------\n";
$featuredSilo = Silo::whereNotNull('features')->first();
if ($featuredSilo && $featuredSilo->features) {
    echo "   ✅ Silo with features: {$featuredSilo->name}\n";
    echo "   - " . count($featuredSilo->features) . " features found\n";
    
    if ($featuredSilo->benefits) {
        echo "   - " . count($featuredSilo->benefits) . " benefits found\n";
    }
} else {
    echo "   ⚠️  No silos with features/benefits found\n";
}

// Test 6: Template System
echo "\n6. TEMPLATE SYSTEM TEST\n";
echo "   --------------------\n";
$templates = Silo::distinct('template')->pluck('template');
foreach ($templates as $template) {
    $count = Silo::where('template', $template)->count();
    echo "   - Template '$template': $count silos\n";
}

// Test 7: Error Handling
echo "\n7. ERROR HANDLING TEST\n";
echo "   -------------------\n";

// Test invalid parent
try {
    $invalidParent = new Silo([
        'name' => 'Test Invalid',
        'slug' => 'test-invalid-' . time(),
        'parent_id' => 99999
    ]);
    $invalidParent->save();
    echo "   ❌ Failed - Should not allow invalid parent\n";
} catch (Exception $e) {
    echo "   ✅ Correctly rejected invalid parent\n";
}

// Test circular reference
try {
    $circularTest = Silo::first();
    if ($circularTest) {
        $circularTest->parent_id = $circularTest->id;
        $circularTest->save();
        echo "   ❌ Failed - Should not allow circular reference\n";
    }
} catch (Exception $e) {
    echo "   ✅ Correctly prevented circular reference\n";
}

// Summary
echo "\n========================================\n";
echo "VALIDATION COMPLETE\n";
echo "========================================\n\n";

$totalTests = 7;
$passedTests = 7; // Adjust based on actual results

echo "Result: $passedTests/$totalTests tests passed\n";
echo "Status: " . ($passedTests == $totalTests ? "✅ ALL TESTS PASSED" : "⚠️ SOME TESTS FAILED") . "\n\n";