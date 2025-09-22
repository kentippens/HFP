<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\TrackingScript;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class TrackingScriptFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_tracking_script_validation_fails_with_invalid_type()
    {
        $this->expectException(ValidationException::class);
        
        TrackingScript::create([
            'name' => 'Invalid Script',
            'type' => 'invalid_type',
            'script_code' => '<script>test</script>',
            'position' => 'head'
        ]);
    }

    public function test_tracking_script_validation_fails_with_invalid_position()
    {
        $this->expectException(ValidationException::class);
        
        TrackingScript::create([
            'name' => 'Invalid Script',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'invalid_position'
        ]);
    }

    public function test_tracking_script_validation_fails_with_empty_name()
    {
        $this->expectException(ValidationException::class);
        
        TrackingScript::create([
            'name' => '',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head'
        ]);
    }

    public function test_tracking_script_validation_fails_with_empty_script_code()
    {
        $this->expectException(ValidationException::class);
        
        TrackingScript::create([
            'name' => 'Test Script',
            'type' => 'custom',
            'script_code' => '',
            'position' => 'head'
        ]);
    }

    public function test_tracking_script_validation_fails_with_name_too_long()
    {
        $this->expectException(ValidationException::class);
        
        TrackingScript::create([
            'name' => str_repeat('a', 256),
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head'
        ]);
    }

    public function test_tracking_script_can_be_created_with_valid_data()
    {
        $script = TrackingScript::create([
            'name' => 'Valid Script',
            'type' => 'ga4',
            'script_code' => '<script>gtag("config", "G-XXXXXXXXXX");</script>',
            'position' => 'head',
            'is_active' => true,
            'description' => 'Test description',
            'sort_order' => 10
        ]);

        $this->assertDatabaseHas('tracking_scripts', [
            'name' => 'Valid Script',
            'type' => 'ga4',
            'position' => 'head',
            'is_active' => true
        ]);
    }

    public function test_tracking_script_can_be_updated()
    {
        $script = TrackingScript::create([
            'name' => 'Original Script',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head'
        ]);

        $script->update([
            'name' => 'Updated Script',
            'type' => 'ga4',
            'is_active' => false
        ]);

        $this->assertDatabaseHas('tracking_scripts', [
            'id' => $script->id,
            'name' => 'Updated Script',
            'type' => 'ga4',
            'is_active' => false
        ]);
    }

    public function test_tracking_script_can_be_deleted()
    {
        $script = TrackingScript::create([
            'name' => 'Test Script',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head'
        ]);

        $scriptId = $script->id;
        $script->delete();

        $this->assertDatabaseMissing('tracking_scripts', [
            'id' => $scriptId
        ]);
    }

    public function test_multiple_scripts_can_be_created_with_different_positions()
    {
        $headScript = TrackingScript::create([
            'name' => 'Head Script',
            'type' => 'ga4',
            'script_code' => '<script>gtag("config", "G-XXXXXXXXXX");</script>',
            'position' => 'head'
        ]);

        $bodyStartScript = TrackingScript::create([
            'name' => 'Body Start Script',
            'type' => 'gtm',
            'script_code' => '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"></iframe></noscript>',
            'position' => 'body_start'
        ]);

        $bodyEndScript = TrackingScript::create([
            'name' => 'Body End Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("end");</script>',
            'position' => 'body_end'
        ]);

        $this->assertDatabaseHas('tracking_scripts', ['position' => 'head']);
        $this->assertDatabaseHas('tracking_scripts', ['position' => 'body_start']);
        $this->assertDatabaseHas('tracking_scripts', ['position' => 'body_end']);
    }

    public function test_scripts_are_ordered_by_sort_order()
    {
        TrackingScript::create([
            'name' => 'Script 3',
            'type' => 'custom',
            'script_code' => '<script>console.log("3");</script>',
            'position' => 'head',
            'sort_order' => 30
        ]);

        TrackingScript::create([
            'name' => 'Script 1',
            'type' => 'custom',
            'script_code' => '<script>console.log("1");</script>',
            'position' => 'head',
            'sort_order' => 10
        ]);

        TrackingScript::create([
            'name' => 'Script 2',
            'type' => 'custom',
            'script_code' => '<script>console.log("2");</script>',
            'position' => 'head',
            'sort_order' => 20
        ]);

        $scripts = TrackingScript::ordered()->get();
        $this->assertEquals('Script 1', $scripts[0]->name);
        $this->assertEquals('Script 2', $scripts[1]->name);
        $this->assertEquals('Script 3', $scripts[2]->name);
    }

    public function test_only_active_scripts_are_returned_by_active_scope()
    {
        TrackingScript::create([
            'name' => 'Active Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("active");</script>',
            'position' => 'head',
            'is_active' => true
        ]);

        TrackingScript::create([
            'name' => 'Inactive Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("inactive");</script>',
            'position' => 'head',
            'is_active' => false
        ]);

        $activeScripts = TrackingScript::active()->get();
        $this->assertCount(1, $activeScripts);
        $this->assertEquals('Active Script', $activeScripts->first()->name);
    }

    public function test_scripts_can_be_filtered_by_position()
    {
        TrackingScript::create([
            'name' => 'Head Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("head");</script>',
            'position' => 'head'
        ]);

        TrackingScript::create([
            'name' => 'Body Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("body");</script>',
            'position' => 'body_start'
        ]);

        $headScripts = TrackingScript::byPosition('head')->get();
        $bodyScripts = TrackingScript::byPosition('body_start')->get();

        $this->assertCount(1, $headScripts);
        $this->assertCount(1, $bodyScripts);
        $this->assertEquals('Head Script', $headScripts->first()->name);
        $this->assertEquals('Body Script', $bodyScripts->first()->name);
    }

    public function test_ga4_script_validation_passes_with_valid_code()
    {
        $script = TrackingScript::create([
            'name' => 'Valid GA4',
            'type' => 'ga4',
            'script_code' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>',
            'position' => 'head'
        ]);

        $this->assertTrue($script->validateScriptCode());
    }

    public function test_clarity_script_validation_passes_with_valid_code()
    {
        $script = TrackingScript::create([
            'name' => 'Valid Clarity',
            'type' => 'clarity',
            'script_code' => '<script>(function(c,l,a,r,i,t,y){...})(window, document, "clarity", "script", "XXXXXXXXXX");</script>',
            'position' => 'head'
        ]);

        $this->assertTrue($script->validateScriptCode());
    }

    public function test_gtm_script_validation_passes_with_valid_code()
    {
        $script = TrackingScript::create([
            'name' => 'Valid GTM',
            'type' => 'gtm',
            'script_code' => '<script>(function(w,d,s,l,i){...})(window,document,"script","dataLayer","GTM-XXXXXXX");</script>',
            'position' => 'head'
        ]);

        $this->assertTrue($script->validateScriptCode());
    }

    public function test_facebook_script_validation_passes_with_valid_code()
    {
        $script = TrackingScript::create([
            'name' => 'Valid Facebook',
            'type' => 'facebook',
            'script_code' => '<script>!function(f,b,e,v,n,t,s){...}(window,document,"script","https://connect.facebook.net/en_US/fbevents.js");</script>',
            'position' => 'head'
        ]);

        $this->assertTrue($script->validateScriptCode());
    }

    public function test_script_code_is_formatted_correctly()
    {
        $scriptWithoutTags = TrackingScript::create([
            'name' => 'JS Only',
            'type' => 'custom',
            'script_code' => 'console.log("test");',
            'position' => 'head'
        ]);

        $scriptWithTags = TrackingScript::create([
            'name' => 'Complete Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'head'
        ]);

        $this->assertStringContainsString('<script>', $scriptWithoutTags->formatted_script);
        $this->assertStringContainsString('</script>', $scriptWithoutTags->formatted_script);
        $this->assertEquals('<script>console.log("test");</script>', $scriptWithTags->formatted_script);
    }

    public function test_script_with_sort_order_zero_is_handled_correctly()
    {
        $script = TrackingScript::create([
            'name' => 'Zero Order Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("zero");</script>',
            'position' => 'head',
            'sort_order' => 0
        ]);

        $this->assertEquals(0, $script->sort_order);
        $this->assertIsInt($script->sort_order);
    }

    public function test_script_description_can_be_null()
    {
        $script = TrackingScript::create([
            'name' => 'No Description Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'head',
            'description' => null
        ]);

        $this->assertNull($script->description);
    }

    public function test_script_description_can_be_long_text()
    {
        $longDescription = str_repeat('This is a long description. ', 100);
        
        $script = TrackingScript::create([
            'name' => 'Long Description Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'head',
            'description' => $longDescription
        ]);

        $this->assertEquals($longDescription, $script->description);
    }
}