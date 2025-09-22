<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaCode123EdgeCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_various_123_area_code_formats_are_rejected()
    {
        $invalidPhoneFormats = [
            // Standard formats
            '123-456-7890',
            '(123) 456-7890',
            '123.456.7890',
            '123 456 7890',
            '1234567890',
            
            // International formats
            '+1 123-456-7890',
            '+1-123-456-7890',
            '+1.123.456.7890',
            '+1 (123) 456-7890',
            '+11234567890',
            
            // With extra characters
            '123-456-7890 ext 123',
            '123-456-7890x123',
            'tel:123-456-7890',
            
            // Mixed formatting
            '123/456/7890',
            '123_456_7890',
        ];

        foreach ($invalidPhoneFormats as $phone) {
            $formData = [
                'type' => 'appointment',
                'name' => 'Test User',
                'phone' => $phone,
                'service' => 'request-callback',
            ];

            $response = $this->post(route('contact.store'), $formData);
            
            $response->assertSessionHasErrors(['phone']);
            
            $errors = session('errors');
            $phoneErrors = $errors->get('phone');
            $this->assertStringContainsString('Area code 123', $phoneErrors[0], 
                "Failed to reject phone number: {$phone}");
        }
    }

    public function test_valid_numbers_with_123_elsewhere_are_accepted()
    {
        $validPhoneNumbers = [
            // 123 in the middle or end (not area code)
            '555-123-4567',
            '555-456-1234',
            '(555) 123-4567',
            '+1 555-123-4567',
            
            // Numbers that start with 12 but not 123
            '124-456-7890',
            '122-456-7890',
            '121-456-7890',
            '120-456-7890',
            
            // Numbers that contain 123 but in different positions
            '512-345-6789',
            '612-345-6789',
        ];

        foreach ($validPhoneNumbers as $phone) {
            $formData = [
                'type' => 'appointment',
                'name' => 'Test User',
                'phone' => $phone,
                'service' => 'request-callback',
            ];

            $response = $this->post(route('contact.store'), $formData);
            
            $response->assertRedirect();
            $response->assertSessionHas('success');
            $response->assertSessionDoesntHaveErrors(['phone']);
        }
    }

    public function test_edge_case_phone_numbers()
    {
        // Test very short numbers that might contain 123
        $shortInvalidNumbers = [
            '123',
            '1234',
            '12345',
        ];

        foreach ($shortInvalidNumbers as $phone) {
            $formData = [
                'type' => 'appointment',
                'name' => 'Test User',
                'phone' => $phone,
                'service' => 'request-callback',
            ];

            $response = $this->post(route('contact.store'), $formData);
            
            // These should fail either due to length or area code 123
            $response->assertSessionHasErrors(['phone']);
        }
    }

    public function test_international_non_123_numbers_work()
    {
        $validInternationalNumbers = [
            '+44 20 7946 0958', // UK
            '+33 1 42 86 83 26', // France  
            '+49 30 12345678', // Germany
            '+1 555-123-4567', // US with valid area code
        ];

        foreach ($validInternationalNumbers as $phone) {
            $formData = [
                'type' => 'appointment',
                'name' => 'Test User',
                'phone' => $phone,
                'service' => 'request-callback',
            ];

            $response = $this->post(route('contact.store'), $formData);
            
            $response->assertRedirect();
            $response->assertSessionHas('success');
            $response->assertSessionDoesntHaveErrors(['phone']);
        }
    }
}