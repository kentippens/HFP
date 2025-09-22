<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ContactSubmission;
use App\Models\User;
use App\Filament\Resources\ContactSubmissionResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactSubmissionExportWebContextTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        
        // Create admin user for testing
        $this->adminUser = User::factory()->create([
            'email' => 'admin@test.com',
            'name' => 'Admin User'
        ]);
    }

    public function test_export_preconditions_work_in_web_context()
    {
        // This test verifies that validateExportPreconditions works in web context
        // without the STDOUT constant error
        
        $this->expectNotToPerformAssertions();
        
        // Should not throw an exception about STDOUT
        ContactSubmissionResource::validateExportPreconditions();
    }

    public function test_export_can_generate_csv_content_in_web_context()
    {
        // Create some test data
        ContactSubmission::factory()->count(3)->create();
        
        // Test that we can create the CSV generation components
        $submissions = ContactSubmission::all();
        
        // Validate the data
        ContactSubmissionResource::validateExportData($submissions);
        
        // Test CSV row formatting
        foreach ($submissions as $submission) {
            $row = ContactSubmissionResource::formatSubmissionRow($submission);
            $this->assertIsArray($row);
            $this->assertCount(12, $row);
        }
        
        // Test filename generation
        $filename = ContactSubmissionResource::generateSafeFilename('test-filter');
        $this->assertStringStartsWith('contact-submissions-', $filename);
        $this->assertStringEndsWith('.csv', $filename);
    }

    public function test_csv_stream_operations_work_in_web_context()
    {
        // Test that we can perform the basic stream operations that the export uses
        
        // Test php://memory (used in validation)
        $memoryHandle = fopen('php://memory', 'w');
        $this->assertIsResource($memoryHandle);
        
        $result = fputcsv($memoryHandle, ['test', 'data', 'row']);
        $this->assertNotFalse($result, 'fputcsv should work with memory stream');
        
        fclose($memoryHandle);
        
        // Test php://temp (alternative for testing)
        $tempHandle = fopen('php://temp', 'w');
        $this->assertIsResource($tempHandle);
        
        $result = fputcsv($tempHandle, ['another', 'test', 'row']);
        $this->assertNotFalse($result, 'fputcsv should work with temp stream');
        
        fclose($tempHandle);
    }

    public function test_export_error_handling_works_in_web_context()
    {
        // Test various error conditions that should be handled gracefully
        
        // Test with empty dataset
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No records found');
        ContactSubmissionResource::validateRecordCount(0);
    }

    public function test_memory_utilities_work_in_web_context()
    {
        // Test memory conversion utility
        $bytes = ContactSubmissionResource::convertToBytes('1M');
        $this->assertEquals(1024 * 1024, $bytes);
        
        // Test string sanitization
        $safe = ContactSubmissionResource::safeStringValue("test\x00string\x1F");
        $this->assertEquals('teststring', $safe);
        
        // Test service formatting
        $formatted = ContactSubmissionResource::formatServiceRequested('house-cleaning');
        $this->assertEquals('House Cleaning', $formatted);
    }
}