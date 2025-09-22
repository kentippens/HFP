<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TrackingScript;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TrackingScriptTest extends TestCase
{
    use RefreshDatabase;

    public function test_tracking_script_can_be_created()
    {
        $script = TrackingScript::create([
            'name' => 'Test GA4 Script',
            'type' => 'ga4',
            'script_code' => '<script>gtag("config", "G-XXXXXXXXXX");</script>',
            'position' => 'head',
            'is_active' => true,
            'description' => 'Test script',
            'sort_order' => 10
        ]);

        $this->assertInstanceOf(TrackingScript::class, $script);
        $this->assertEquals('Test GA4 Script', $script->name);
        $this->assertEquals('ga4', $script->type);
        $this->assertTrue($script->is_active);
        $this->assertNotNull($script->id);
        $this->assertTrue(is_string($script->id));
    }

    public function test_tracking_script_automatically_generates_uuid()
    {
        $script = TrackingScript::create([
            'name' => 'Test Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'head'
        ]);

        $this->assertNotNull($script->id);
        $this->assertIsString($script->id);
        $this->assertMatchesRegularExpression('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $script->id);
    }

    public function test_tracking_script_defaults()
    {
        $script = new TrackingScript([
            'name' => 'Test Script',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head'
        ]);
        $script->skipValidation = true;
        $script->save();

        $this->assertTrue($script->is_active);
        $this->assertEquals(0, $script->sort_order);
    }

    public function test_active_scope()
    {
        TrackingScript::create([
            'name' => 'Active Script',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head',
            'is_active' => true
        ]);

        TrackingScript::create([
            'name' => 'Inactive Script',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head',
            'is_active' => false
        ]);

        $activeScripts = TrackingScript::active()->get();
        $this->assertCount(1, $activeScripts);
        $this->assertEquals('Active Script', $activeScripts->first()->name);
    }

    public function test_ordered_scope()
    {
        TrackingScript::create([
            'name' => 'Script C',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head',
            'sort_order' => 30
        ]);

        TrackingScript::create([
            'name' => 'Script A',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head',
            'sort_order' => 10
        ]);

        TrackingScript::create([
            'name' => 'Script B',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head',
            'sort_order' => 20
        ]);

        $orderedScripts = TrackingScript::ordered()->get();
        $this->assertEquals('Script A', $orderedScripts->first()->name);
        $this->assertEquals('Script C', $orderedScripts->last()->name);
    }

    public function test_by_position_scope()
    {
        TrackingScript::create([
            'name' => 'Head Script',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'head'
        ]);

        TrackingScript::create([
            'name' => 'Body Script',
            'type' => 'custom',
            'script_code' => '<script>test</script>',
            'position' => 'body_start'
        ]);

        $headScripts = TrackingScript::byPosition('head')->get();
        $this->assertCount(1, $headScripts);
        $this->assertEquals('Head Script', $headScripts->first()->name);
    }

    public function test_validation_rules()
    {
        $rules = TrackingScript::rules();
        
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('type', $rules);
        $this->assertArrayHasKey('script_code', $rules);
        $this->assertArrayHasKey('position', $rules);
        $this->assertArrayHasKey('is_active', $rules);
        
        $this->assertStringContainsString('required', $rules['name']);
        $this->assertStringContainsString('required', $rules['type']);
        $this->assertStringContainsString('required', $rules['script_code']);
        $this->assertStringContainsString('required', $rules['position']);
    }

    public function test_formatted_script_attribute()
    {
        $scriptWithoutTags = TrackingScript::create([
            'name' => 'JS Only Script',
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
        $this->assertStringContainsString('<script>console.log("test");</script>', $scriptWithTags->formatted_script);
    }

    public function test_validate_script_code_for_ga4()
    {
        $validGA4 = new TrackingScript([
            'name' => 'Valid GA4',
            'type' => 'ga4',
            'script_code' => '<script>gtag("config", "G-XXXXXXXXXX");</script>',
            'position' => 'head'
        ]);

        $invalidGA4 = new TrackingScript([
            'name' => 'Invalid GA4',
            'type' => 'ga4',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'head'
        ]);

        $this->assertTrue($validGA4->validateScriptCode());
        $this->assertFalse($invalidGA4->validateScriptCode());
    }

    public function test_validate_script_code_for_clarity()
    {
        $validClarity = new TrackingScript([
            'name' => 'Valid Clarity',
            'type' => 'clarity',
            'script_code' => '<script>clarity("track", "test");</script>',
            'position' => 'head'
        ]);

        $invalidClarity = new TrackingScript([
            'name' => 'Invalid Clarity',
            'type' => 'clarity',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'head'
        ]);

        $this->assertTrue($validClarity->validateScriptCode());
        $this->assertFalse($invalidClarity->validateScriptCode());
    }

    public function test_validate_script_code_for_gtm()
    {
        $validGTM = new TrackingScript([
            'name' => 'Valid GTM',
            'type' => 'gtm',
            'script_code' => '<script>GTM-XXXXXXXXX</script>',
            'position' => 'head'
        ]);

        $invalidGTM = new TrackingScript([
            'name' => 'Invalid GTM',
            'type' => 'gtm',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'head'
        ]);

        $this->assertTrue($validGTM->validateScriptCode());
        $this->assertFalse($invalidGTM->validateScriptCode());
    }

    public function test_validate_script_code_for_facebook()
    {
        $validFB = new TrackingScript([
            'name' => 'Valid Facebook',
            'type' => 'facebook',
            'script_code' => '<script>fbq("track", "PageView");</script>',
            'position' => 'head'
        ]);

        $invalidFB = new TrackingScript([
            'name' => 'Invalid Facebook',
            'type' => 'facebook',
            'script_code' => '<script>console.log("test");</script>',
            'position' => 'head'
        ]);

        $this->assertTrue($validFB->validateScriptCode());
        $this->assertFalse($invalidFB->validateScriptCode());
    }

    public function test_validate_script_code_for_custom()
    {
        $customScript = new TrackingScript([
            'name' => 'Custom Script',
            'type' => 'custom',
            'script_code' => '<script>console.log("anything");</script>',
            'position' => 'head'
        ]);

        $this->assertTrue($customScript->validateScriptCode());
    }

    public function test_script_types_constant()
    {
        $expectedTypes = [
            'ga4' => 'Google Analytics 4',
            'clarity' => 'Microsoft Clarity',
            'gtm' => 'Google Tag Manager',
            'facebook' => 'Facebook Pixel',
            'custom' => 'Custom Script',
        ];

        $this->assertEquals($expectedTypes, TrackingScript::SCRIPT_TYPES);
    }

    public function test_script_positions_constant()
    {
        $expectedPositions = [
            'head' => 'In <head> section',
            'body_start' => 'After <body> opening tag',
            'body_end' => 'Before </body> closing tag',
        ];

        $this->assertEquals($expectedPositions, TrackingScript::SCRIPT_POSITIONS);
    }

    public function test_validation_messages()
    {
        $messages = TrackingScript::messages();
        
        $this->assertArrayHasKey('type.in', $messages);
        $this->assertArrayHasKey('position.in', $messages);
        $this->assertStringContainsString('Google Analytics 4', $messages['type.in']);
        $this->assertStringContainsString('In <head> section', $messages['position.in']);
    }

    public function test_fillable_attributes()
    {
        $script = new TrackingScript();
        $expectedFillable = [
            'name',
            'type',
            'script_code',
            'position',
            'is_active',
            'description',
            'sort_order'
        ];

        $this->assertEquals($expectedFillable, $script->getFillable());
    }

    public function test_casts()
    {
        $script = new TrackingScript();
        $casts = $script->getCasts();
        
        $this->assertEquals('string', $casts['id']);
        $this->assertEquals('boolean', $casts['is_active']);
        $this->assertEquals('integer', $casts['sort_order']);
    }

    public function test_key_type_is_string()
    {
        $script = new TrackingScript();
        $this->assertEquals('string', $script->getKeyType());
        $this->assertFalse($script->getIncrementing());
    }
}