<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ContactSubmission;
use App\Models\User;
use App\Filament\Resources\ContactSubmissionResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

class ContactSubmissionExportIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        
        // Create admin user for Filament access
        $this->adminUser = User::factory()->create([
            'email' => 'admin@test.com',
            'name' => 'Admin User'
        ]);
    }

    public function test_export_respects_record_limits()
    {
        // Set a low limit for testing
        Config::set('app.max_export_records', 5);
        
        // Create more records than the limit
        ContactSubmission::factory()->count(10)->create();
        
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('exceeds the maximum limit');
        
        ContactSubmissionResource::validateRecordCount(10);
    }

    public function test_export_handles_large_messages()
    {
        $submission = ContactSubmission::factory()->create([
            'message' => str_repeat('This is a very long message. ', 100), // ~3000 chars
        ]);

        $row = ContactSubmissionResource::formatSubmissionRow($submission);
        
        // Message should be truncated to 1000 chars + "..."
        $this->assertLessThanOrEqual(1003, strlen($row[7])); // message field
        if (strlen($submission->message) > 1000) {
            $this->assertStringEndsWith('...', $row[7]);
        }
    }

    public function test_export_handles_special_characters_in_data()
    {
        $submission = ContactSubmission::factory()->create([
            'name' => 'José Müller-Smith',
            'email' => 'josé@müller-smith.com',
            'message' => "Message with \"quotes\" and 'apostrophes' and \n newlines \t tabs",
            'source_uri' => '/contact?utm_source=test&utm_medium=email',
        ]);

        $row = ContactSubmissionResource::formatSubmissionRow($submission);
        
        // Should handle special characters without breaking CSV
        $this->assertEquals('José Müller-Smith', $row[1]);
        $this->assertEquals('josé@müller-smith.com', $row[4]);
        $this->assertIsString($row[7]); // message
        $this->assertIsString($row[9]); // source_uri
    }

    public function test_export_handles_null_and_empty_values()
    {
        $submission = ContactSubmission::factory()->create([
            'first_name' => null,
            'last_name' => '',
            'phone' => null,
            'message' => '',
            'service_requested' => null,
            'source_uri' => null,
            'ip_address' => '',
        ]);

        $row = ContactSubmissionResource::formatSubmissionRow($submission);
        
        $this->assertEquals('', $row[2]); // first_name (null)
        $this->assertEquals('', $row[3]); // last_name (empty)
        $this->assertEquals('', $row[5]); // phone (null)
        $this->assertEquals('', $row[7]); // message (empty)
        $this->assertEquals('N/A', $row[6]); // service_requested (null)
        $this->assertEquals('', $row[9]); // source_uri (null)
        $this->assertEquals('', $row[11]); // ip_address (empty)
    }

    public function test_export_handles_different_service_types()
    {
        $services = [
            'house-cleaning' => 'House Cleaning',
            'office-cleaning' => 'Office Cleaning',
            'carpet_cleaning' => 'Carpet Cleaning',
            'COMMERCIAL-CLEANING' => 'COMMERCIAL CLEANING', // ucwords works correctly
            null => 'N/A',
            '' => 'N/A',
        ];

        foreach ($services as $input => $expected) {
            $result = ContactSubmissionResource::formatServiceRequested($input);
            $this->assertEquals($expected, $result, "Failed for input: " . ($input ?? 'null'));
        }
    }

    public function test_export_handles_different_source_types()
    {
        $sources = [
            'homepage_form' => 'Homepage Hero',
            'contact_page' => 'Contact Page',
            'service_house-cleaning' => 'Service: House Cleaning',
            'service_custom-service' => 'Service: Custom Service',
            'unknown_source' => 'Unknown Source',
        ];

        foreach ($sources as $input => $expected) {
            $result = ContactSubmissionResource::getSourceLabel($input);
            $this->assertEquals($expected, $result, "Failed for input: $input");
        }
    }

    public function test_memory_conversion_utility()
    {
        $tests = [
            '1K' => 1024,
            '2k' => 2048,
            '1M' => 1024 * 1024,
            '2m' => 2 * 1024 * 1024,
            '1G' => 1024 * 1024 * 1024,
            '2g' => 2 * 1024 * 1024 * 1024,
            '512' => 512,
        ];

        foreach ($tests as $input => $expected) {
            $result = ContactSubmissionResource::convertToBytes($input);
            $this->assertEquals($expected, $result, "Failed for input: $input");
        }
    }

    public function test_safe_filename_generation_edge_cases()
    {
        $testCases = [
            null => null,
            '' => null,
            'normal-filter' => 'normal-filter',
            'filter/with\\slashes' => 'filter-with-slashes',
            'filter@with#special$chars!' => 'filter-with-special-chars',
        ];

        foreach ($testCases as $input => $expectedContains) {
            $filename = ContactSubmissionResource::generateSafeFilename($input);
            
            $this->assertStringStartsWith('contact-submissions-', $filename);
            $this->assertStringEndsWith('.csv', $filename);
            
            if ($expectedContains) {
                $this->assertStringContainsString($expectedContains, $filename);
            }
            
            // Should not contain invalid filename characters
            $this->assertDoesNotMatchRegularExpression('/[\/\\\\:*?"<>|]/', $filename);
        }
        
        // Test long filter info truncation
        $longFilterInfo = str_repeat('very-long-', 20);
        $filename = ContactSubmissionResource::generateSafeFilename($longFilterInfo);
        $this->assertLessThan(150, strlen($filename)); // Should be reasonable length
    }

    public function test_csv_row_writing_with_various_data_types()
    {
        // Test that formatSubmissionRow handles various data types correctly
        $submission = ContactSubmission::factory()->create([
            'name' => 123, // Number
            'email' => true, // Boolean (converted to string)
            'phone' => 0, // Zero
            'created_at' => now(),
        ]);

        $row = ContactSubmissionResource::formatSubmissionRow($submission);
        
        // All row values should be strings or handle conversion gracefully
        foreach ($row as $index => $value) {
            $this->assertIsString($value, "Row index $index should be a string, got: " . gettype($value));
        }
    }

    public function test_export_with_malformed_dates()
    {
        // Test safe formatting with null input (should return fallback)
        $result1 = ContactSubmissionResource::safeFormat(null, function($date) {
            return $date->format('Y-m-d H:i:s');
        }, 'no-date');
        $this->assertEquals('no-date', $result1);
        
        // Test safe formatting with empty string (should return fallback)
        $result2 = ContactSubmissionResource::safeFormat('', function($date) {
            return $date->format('Y-m-d H:i:s');
        }, 'empty-date');
        $this->assertEquals('empty-date', $result2);
        
        // Test safe formatting with exception in formatter
        $result3 = ContactSubmissionResource::safeFormat('some-value', function($date) {
            throw new \Exception('Test exception');
        }, 'error-fallback');
        $this->assertEquals('error-fallback', $result3);
    }

    public function test_export_performance_with_moderate_dataset()
    {
        // Create a moderate dataset to test performance
        $submissions = ContactSubmission::factory()->count(100)->create();
        
        $startTime = microtime(true);
        
        // Format all submissions
        foreach ($submissions as $submission) {
            ContactSubmissionResource::formatSubmissionRow($submission);
        }
        
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        
        // Should complete within reasonable time (adjust threshold as needed)
        $this->assertLessThan(5.0, $executionTime, 'Export formatting took too long');
    }

    public function test_source_options_generation()
    {
        // Create submissions with various sources
        ContactSubmission::factory()->create(['source' => 'service_custom-cleaning']);
        ContactSubmission::factory()->create(['source' => 'service_window-washing']);
        ContactSubmission::factory()->create(['source' => 'homepage_form']);
        
        $options = ContactSubmissionResource::getSourceOptions();
        
        $this->assertIsArray($options);
        $this->assertArrayHasKey('homepage_form', $options);
        $this->assertArrayHasKey('service_custom-cleaning', $options);
        $this->assertArrayHasKey('service_window-washing', $options);
        
        // Check that service sources are properly labeled
        $this->assertEquals('Service: Custom Cleaning', $options['service_custom-cleaning']);
        $this->assertEquals('Service: Window Washing', $options['service_window-washing']);
    }

    public function test_export_configuration_respects_environment()
    {
        // Test default configuration
        $defaultLimit = config('app.max_export_records');
        $this->assertEquals(50000, $defaultLimit);
        
        // Test custom configuration
        Config::set('app.max_export_records', 1000);
        $customLimit = config('app.max_export_records');
        $this->assertEquals(1000, $customLimit);
    }
}