<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class TrackingScriptErrorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_report_tracking_script_errors()
    {
        // Mock the Log facade
        Log::shouldReceive('error')
            ->twice()
            ->withArgs(function ($message, $context) {
                return str_contains($message, 'Client-side tracking script error') &&
                       isset($context['script_id']) &&
                       isset($context['script_name']) &&
                       isset($context['error_message']);
            });

        $errorData = [
            'errors' => [
                [
                    'scriptId' => 'test-script-id-1',
                    'scriptName' => 'Test GA4 Script',
                    'error' => 'ReferenceError: gtag is not defined',
                    'timestamp' => '2025-01-01T00:00:00.000Z'
                ],
                [
                    'scriptId' => 'test-script-id-2',
                    'scriptName' => 'Test Clarity Script',
                    'error' => 'TypeError: Cannot read property of undefined',
                    'timestamp' => '2025-01-01T00:01:00.000Z'
                ]
            ]
        ];

        $response = $this->postJson('/api/tracking-script-errors', $errorData);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Errors reported successfully',
                     'count' => 2
                 ]);
    }

    public function test_validates_required_error_fields()
    {
        $invalidData = [
            'errors' => [
                [
                    'scriptId' => 'test-script-id',
                    // Missing required fields
                ]
            ]
        ];

        $response = $this->postJson('/api/tracking-script-errors', $invalidData);

        $response->assertStatus(400)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Invalid error data format'
                 ])
                 ->assertJsonStructure(['errors']);
    }

    public function test_validates_errors_array_structure()
    {
        $invalidData = [
            'errors' => 'not-an-array'
        ];

        $response = $this->postJson('/api/tracking-script-errors', $invalidData);

        $response->assertStatus(400)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Invalid error data format'
                 ]);
    }

    public function test_handles_missing_errors_field()
    {
        $invalidData = [
            'other_field' => 'value'
        ];

        $response = $this->postJson('/api/tracking-script-errors', $invalidData);

        $response->assertStatus(400)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Invalid error data format'
                 ]);
    }

    public function test_handles_empty_errors_array()
    {
        $data = [
            'errors' => []
        ];

        $response = $this->postJson('/api/tracking-script-errors', $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Errors reported successfully',
                     'count' => 0
                 ]);
    }

    public function test_logs_additional_context_information()
    {
        Log::shouldReceive('error')
            ->once()
            ->withArgs(function ($message, $context) {
                return str_contains($message, 'Client-side tracking script error') &&
                       isset($context['script_id']) &&
                       isset($context['script_name']) &&
                       isset($context['error_message']) &&
                       isset($context['timestamp']) &&
                       isset($context['user_agent']) &&
                       isset($context['ip_address']);
            });

        $errorData = [
            'errors' => [
                [
                    'scriptId' => 'test-script-id',
                    'scriptName' => 'Test Script',
                    'error' => 'Test error message',
                    'timestamp' => '2025-01-01T00:00:00.000Z'
                ]
            ]
        ];

        $response = $this->postJson('/api/tracking-script-errors', $errorData, [
            'User-Agent' => 'Mozilla/5.0 (Test Browser)',
            'Referer' => 'https://example.com/test-page'
        ]);

        $response->assertStatus(200);
    }

    public function test_handles_malformed_json()
    {
        $response = $this->post('/api/tracking-script-errors', [], [
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(400);
    }

    public function test_handles_large_error_payload()
    {
        $largeErrorData = [
            'errors' => []
        ];

        // Create 100 error entries
        for ($i = 0; $i < 100; $i++) {
            $largeErrorData['errors'][] = [
                'scriptId' => 'test-script-id-' . $i,
                'scriptName' => 'Test Script ' . $i,
                'error' => 'Test error message ' . $i,
                'timestamp' => '2025-01-01T00:00:00.000Z'
            ];
        }

        Log::shouldReceive('error')->times(100);

        $response = $this->postJson('/api/tracking-script-errors', $largeErrorData);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'count' => 100
                 ]);
    }

    public function test_handles_special_characters_in_error_messages()
    {
        Log::shouldReceive('error')
            ->once()
            ->withArgs(function ($message, $context) {
                return str_contains($context['error_message'], 'Special chars: <script>alert("test")</script>');
            });

        $errorData = [
            'errors' => [
                [
                    'scriptId' => 'test-script-id',
                    'scriptName' => 'Test Script',
                    'error' => 'Special chars: <script>alert("test")</script>',
                    'timestamp' => '2025-01-01T00:00:00.000Z'
                ]
            ]
        ];

        $response = $this->postJson('/api/tracking-script-errors', $errorData);

        $response->assertStatus(200);
    }

    public function test_handles_long_error_messages()
    {
        $longErrorMessage = str_repeat('This is a very long error message. ', 100);

        Log::shouldReceive('error')
            ->once()
            ->withArgs(function ($message, $context) use ($longErrorMessage) {
                return str_contains($context['error_message'], $longErrorMessage);
            });

        $errorData = [
            'errors' => [
                [
                    'scriptId' => 'test-script-id',
                    'scriptName' => 'Test Script',
                    'error' => $longErrorMessage,
                    'timestamp' => '2025-01-01T00:00:00.000Z'
                ]
            ]
        ];

        $response = $this->postJson('/api/tracking-script-errors', $errorData);

        $response->assertStatus(200);
    }

    public function test_validates_individual_error_fields()
    {
        $invalidData = [
            'errors' => [
                [
                    'scriptId' => '', // Empty string
                    'scriptName' => 'Test Script',
                    'error' => 'Test error',
                    'timestamp' => '2025-01-01T00:00:00.000Z'
                ]
            ]
        ];

        $response = $this->postJson('/api/tracking-script-errors', $invalidData);

        $response->assertStatus(400)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Invalid error data format'
                 ]);
    }
}