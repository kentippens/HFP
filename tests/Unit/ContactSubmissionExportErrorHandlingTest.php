<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ContactSubmission;
use App\Filament\Resources\ContactSubmissionResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactSubmissionExportErrorHandlingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_validate_export_preconditions_checks_database_connection()
    {
        // This test verifies that the method exists and can be called
        $this->assertTrue(method_exists(ContactSubmissionResource::class, 'validateExportPreconditions'));
        
        // Test that it doesn't throw an exception with a valid database connection
        $this->expectNotToPerformAssertions();
        ContactSubmissionResource::validateExportPreconditions();
    }

    public function test_validate_record_count_throws_exception_for_zero_records()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No records found matching the current filters');
        
        ContactSubmissionResource::validateRecordCount(0);
    }

    public function test_validate_record_count_throws_exception_for_too_many_records()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('exceeds the maximum limit');
        
        // Use a number higher than the default config limit
        ContactSubmissionResource::validateRecordCount(100000);
    }

    public function test_validate_record_count_accepts_valid_count()
    {
        $this->expectNotToPerformAssertions();
        
        ContactSubmissionResource::validateRecordCount(100); // Should not throw
    }

    public function test_safe_string_value_handles_null_values()
    {
        $result = ContactSubmissionResource::safeStringValue(null);
        $this->assertEquals('', $result);
    }

    public function test_safe_string_value_limits_length()
    {
        $longString = str_repeat('a', 1000);
        $result = ContactSubmissionResource::safeStringValue($longString, 100);
        
        $this->assertEquals(100, strlen($result));
        $this->assertStringEndsWith('...', $result);
    }

    public function test_safe_string_value_removes_control_characters()
    {
        $stringWithControlChars = "Hello\x00\x01\x02World\x1F";
        $result = ContactSubmissionResource::safeStringValue($stringWithControlChars);
        
        $this->assertEquals('HelloWorld', $result);
    }

    public function test_format_service_requested_handles_null()
    {
        $result = ContactSubmissionResource::formatServiceRequested(null);
        $this->assertEquals('N/A', $result);
    }

    public function test_format_service_requested_formats_correctly()
    {
        $result = ContactSubmissionResource::formatServiceRequested('house-cleaning');
        $this->assertEquals('House Cleaning', $result);
    }

    public function test_generate_safe_filename_handles_null_filter_info()
    {
        $filename = ContactSubmissionResource::generateSafeFilename(null);
        
        $this->assertStringStartsWith('contact-submissions-', $filename);
        $this->assertStringEndsWith('.csv', $filename);
        $this->assertMatchesRegularExpression('/contact-submissions-\d{4}-\d{2}-\d{2}-\d{2}-\d{2}-\d{2}\.csv/', $filename);
    }

    public function test_generate_safe_filename_sanitizes_filter_info()
    {
        $filename = ContactSubmissionResource::generateSafeFilename('today/source@test#filter');
        
        $this->assertStringContainsString('today-source-test-filter', $filename);
        $this->assertStringEndsWith('.csv', $filename);
    }

    public function test_generate_safe_filename_limits_length()
    {
        $longFilterInfo = str_repeat('very-long-filter-name-', 10);
        $filename = ContactSubmissionResource::generateSafeFilename($longFilterInfo);
        
        // Should not exceed reasonable filename length
        $this->assertLessThan(150, strlen($filename));
    }

    public function test_convert_to_bytes_handles_different_units()
    {
        $this->assertEquals(1024, ContactSubmissionResource::convertToBytes('1K'));
        $this->assertEquals(1024 * 1024, ContactSubmissionResource::convertToBytes('1M'));
        $this->assertEquals(1024 * 1024 * 1024, ContactSubmissionResource::convertToBytes('1G'));
        $this->assertEquals(512, ContactSubmissionResource::convertToBytes('512'));
    }

    public function test_safe_format_handles_exceptions()
    {
        $result = ContactSubmissionResource::safeFormat('invalid-date', function($value) {
            throw new \Exception('Test exception');
        }, 'fallback');
        
        $this->assertEquals('fallback', $result);
    }

    public function test_safe_format_handles_null_values()
    {
        $result = ContactSubmissionResource::safeFormat(null, function($value) {
            return $value->format('Y-m-d');
        }, 'no-date');
        
        $this->assertEquals('no-date', $result);
    }

    public function test_validate_export_data_accepts_valid_collection()
    {
        $submissions = ContactSubmission::factory()->count(3)->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        
        $this->expectNotToPerformAssertions();
        ContactSubmissionResource::validateExportData($submissions);
    }

    public function test_validate_export_data_throws_for_invalid_type()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid data type for export');
        
        ContactSubmissionResource::validateExportData(['not', 'a', 'collection']);
    }

    public function test_format_submission_row_handles_all_fields()
    {
        $submission = ContactSubmission::factory()->create([
            'name' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '123-456-7890',
            'service_requested' => 'house-cleaning',
            'message' => 'Test message',
            'source' => 'contact_page',
            'source_uri' => '/contact',
            'is_read' => true,
            'ip_address' => '127.0.0.1',
            'created_at' => now(),
        ]);

        $row = ContactSubmissionResource::formatSubmissionRow($submission);
        
        $this->assertCount(12, $row);
        $this->assertEquals('John Doe', $row[1]); // name
        $this->assertEquals('john@example.com', $row[4]); // email
        $this->assertEquals('House Cleaning', $row[6]); // service_requested
        $this->assertEquals('Read', $row[10]); // is_read
    }

    public function test_format_submission_row_handles_missing_fields()
    {
        $submission = ContactSubmission::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'first_name' => null,
            'last_name' => null,
            'phone' => null,
            'service_requested' => null,
            'message' => null,
            'source_uri' => null,
            'ip_address' => null,
            'created_at' => now(),
            'is_read' => false,
        ]);

        $row = ContactSubmissionResource::formatSubmissionRow($submission);
        
        $this->assertCount(12, $row);
        $this->assertEquals('Test User', $row[1]); // name
        $this->assertEquals('', $row[2]); // first_name (null)
        $this->assertEquals('N/A', $row[6]); // service_requested (null)
        $this->assertEquals('Unread', $row[10]); // is_read
    }
}