<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TrackingScript;
use App\Services\TrackingScriptService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TrackingScriptServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TrackingScriptService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TrackingScriptService();
    }

    public function test_get_scripts_for_position_returns_active_scripts()
    {
        // Create active script
        $activeScript = TrackingScript::create([
            'name' => 'Active Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("active");</script>',
            'position' => 'head',
            'is_active' => true,
            'sort_order' => 10
        ]);

        // Create inactive script
        TrackingScript::create([
            'name' => 'Inactive Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("inactive");</script>',
            'position' => 'head',
            'is_active' => false,
            'sort_order' => 20
        ]);

        $scripts = $this->service->getScriptsForPosition('head');
        
        $this->assertCount(1, $scripts);
        $this->assertStringContainsString('console.log("active")', $scripts[0]);
    }

    public function test_get_scripts_for_position_respects_sort_order()
    {
        TrackingScript::create([
            'name' => 'Script C',
            'type' => 'custom',
            'script_code' => '<script>console.log("C");</script>',
            'position' => 'head',
            'sort_order' => 30
        ]);

        TrackingScript::create([
            'name' => 'Script A',
            'type' => 'custom',
            'script_code' => '<script>console.log("A");</script>',
            'position' => 'head',
            'sort_order' => 10
        ]);

        TrackingScript::create([
            'name' => 'Script B',
            'type' => 'custom',
            'script_code' => '<script>console.log("B");</script>',
            'position' => 'head',
            'sort_order' => 20
        ]);

        $scripts = $this->service->getScriptsForPosition('head');
        
        $this->assertCount(3, $scripts);
        $this->assertStringContainsString('console.log("A")', $scripts[0]);
        $this->assertStringContainsString('console.log("B")', $scripts[1]);
        $this->assertStringContainsString('console.log("C")', $scripts[2]);
    }

    public function test_get_scripts_for_position_handles_errors_gracefully()
    {
        // Mock Log to capture error
        Log::shouldReceive('error')->once();
        
        // Create a script that will cause validation error
        $script = new TrackingScript([
            'name' => 'Invalid Script',
            'type' => 'ga4',
            'script_code' => '<script>console.log("invalid");</script>',
            'position' => 'head',
            'is_active' => true
        ]);
        
        // Force save without validation
        $script->saveQuietly();
        
        $scripts = $this->service->getScriptsForPosition('head');
        
        // Should return empty array on error
        $this->assertIsArray($scripts);
        $this->assertEmpty($scripts);
    }

    public function test_render_script_returns_null_for_inactive_script()
    {
        $script = TrackingScript::create([
            'name' => 'Inactive Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'head',
            'is_active' => false
        ]);

        $result = $this->service->renderScript($script);
        
        $this->assertNull($result);
    }

    public function test_render_script_wraps_with_error_handling()
    {
        $script = TrackingScript::create([
            'name' => 'Test Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'head',
            'is_active' => true
        ]);

        $result = $this->service->renderScript($script);
        
        $this->assertNotNull($result);
        $this->assertStringContainsString('try {', $result);
        $this->assertStringContainsString('catch (e) {', $result);
        $this->assertStringContainsString('console.error', $result);
    }

    public function test_render_script_preserves_external_scripts()
    {
        $script = TrackingScript::create([
            'name' => 'External Script',
            'type' => 'ga4',
            'script_code' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>',
            'position' => 'head',
            'is_active' => true
        ]);

        $result = $this->service->renderScript($script);
        
        $this->assertNotNull($result);
        $this->assertStringContainsString('src="https://www.googletagmanager.com/gtag/js', $result);
        // External scripts should not be wrapped with try-catch
        $this->assertStringNotContainsString('try {', $result);
    }

    public function test_render_script_handles_noscript_tags()
    {
        $script = TrackingScript::create([
            'name' => 'GTM Noscript',
            'type' => 'gtm',
            'script_code' => '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"></iframe></noscript>',
            'position' => 'body_start',
            'is_active' => true
        ]);

        $result = $this->service->renderScript($script);
        
        $this->assertNotNull($result);
        $this->assertStringContainsString('<noscript>', $result);
        $this->assertStringContainsString('<iframe', $result);
        // Noscript tags should not be wrapped with try-catch
        $this->assertStringNotContainsString('try {', $result);
    }

    public function test_get_all_scripts_by_position_returns_grouped_scripts()
    {
        TrackingScript::create([
            'name' => 'Head Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("head");</script>',
            'position' => 'head',
            'is_active' => true
        ]);

        TrackingScript::create([
            'name' => 'Body Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("body");</script>',
            'position' => 'body_start',
            'is_active' => true
        ]);

        $result = $this->service->getAllScriptsByPosition();
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('head', $result);
        $this->assertArrayHasKey('body_start', $result);
        $this->assertArrayHasKey('body_end', $result);
        
        $this->assertCount(1, $result['head']);
        $this->assertCount(1, $result['body_start']);
        $this->assertCount(0, $result['body_end']);
    }

    public function test_clear_cache_removes_all_position_caches()
    {
        // Set some cache values
        Cache::put('tracking_scripts_head', ['test'], 300);
        Cache::put('tracking_scripts_body_start', ['test'], 300);
        Cache::put('tracking_scripts_body_end', ['test'], 300);
        
        // Verify cache is set
        $this->assertTrue(Cache::has('tracking_scripts_head'));
        $this->assertTrue(Cache::has('tracking_scripts_body_start'));
        $this->assertTrue(Cache::has('tracking_scripts_body_end'));
        
        // Clear cache
        $this->service->clearCache();
        
        // Verify cache is cleared
        $this->assertFalse(Cache::has('tracking_scripts_head'));
        $this->assertFalse(Cache::has('tracking_scripts_body_start'));
        $this->assertFalse(Cache::has('tracking_scripts_body_end'));
    }

    public function test_get_script_stats_returns_correct_statistics()
    {
        TrackingScript::create([
            'name' => 'Active GA4',
            'type' => 'ga4',
            'script_code' => '<script>gtag("config", "G-XXXXXXXXXX");</script>',
            'position' => 'head',
            'is_active' => true
        ]);

        TrackingScript::create([
            'name' => 'Inactive Clarity',
            'type' => 'clarity',
            'script_code' => '<script>clarity("track", "test");</script>',
            'position' => 'head',
            'is_active' => false
        ]);

        TrackingScript::create([
            'name' => 'Active Custom',
            'type' => 'custom',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'body_start',
            'is_active' => true
        ]);

        $stats = $this->service->getScriptStats();
        
        $this->assertEquals(3, $stats['total_scripts']);
        $this->assertEquals(2, $stats['active_scripts']);
        $this->assertEquals(1, $stats['inactive_scripts']);
        
        $this->assertEquals(1, $stats['scripts_by_type']['ga4']);
        $this->assertEquals(1, $stats['scripts_by_type']['clarity']);
        $this->assertEquals(1, $stats['scripts_by_type']['custom']);
        
        $this->assertEquals(2, $stats['scripts_by_position']['head']);
        $this->assertEquals(1, $stats['scripts_by_position']['body_start']);
    }

    public function test_validate_all_scripts_returns_validation_results()
    {
        // Create valid script
        TrackingScript::create([
            'name' => 'Valid Script',
            'type' => 'ga4',
            'script_code' => '<script>gtag("config", "G-XXXXXXXXXX");</script>',
            'position' => 'head',
            'is_active' => true
        ]);

        // Create invalid script (force save without validation)
        $invalidScript = new TrackingScript([
            'name' => 'Invalid Script',
            'type' => 'ga4',
            'script_code' => '<script>console.log("invalid");</script>',
            'position' => 'head',
            'is_active' => true
        ]);
        $invalidScript->saveQuietly();

        $results = $this->service->validateAllScripts();
        
        $this->assertCount(2, $results);
        
        $validResult = collect($results)->firstWhere('script_name', 'Valid Script');
        $invalidResult = collect($results)->firstWhere('script_name', 'Invalid Script');
        
        $this->assertTrue($validResult['is_valid']);
        $this->assertEmpty($validResult['errors']);
        
        $this->assertFalse($invalidResult['is_valid']);
        $this->assertNotEmpty($invalidResult['errors']);
    }

    public function test_get_error_tracking_script_returns_client_side_error_handler()
    {
        $script = $this->service->getErrorTrackingScript();
        
        $this->assertStringContainsString('window.trackingScriptErrors', $script);
        $this->assertStringContainsString('window.reportTrackingErrors', $script);
        $this->assertStringContainsString('fetch(\'/api/tracking-script-errors\'', $script);
        $this->assertStringContainsString('addEventListener(\'load\'', $script);
    }

    public function test_service_handles_empty_database_gracefully()
    {
        // No scripts in database
        $scripts = $this->service->getScriptsForPosition('head');
        $this->assertEmpty($scripts);
        
        $allScripts = $this->service->getAllScriptsByPosition();
        $this->assertEmpty($allScripts['head']);
        $this->assertEmpty($allScripts['body_start']);
        $this->assertEmpty($allScripts['body_end']);
        
        $stats = $this->service->getScriptStats();
        $this->assertEquals(0, $stats['total_scripts']);
        $this->assertEquals(0, $stats['active_scripts']);
        $this->assertEquals(0, $stats['inactive_scripts']);
    }
}