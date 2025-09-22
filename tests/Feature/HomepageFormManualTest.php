<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageFormManualTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that demonstrates various form scenarios
     */
    public function test_homepage_form_comprehensive_scenarios()
    {
        // Test 1: Valid form submission
        $validData = [
            'type' => 'appointment',
            'name' => 'John Doe',
            'phone' => '+1 (555) 123-4567',
            'address' => 'john@example.com',
            'service' => 'request-callback',
            'message' => 'Please call me back to discuss your cleaning services. I need weekly house cleaning.',
        ];

        $response = $this->post(route('contact.store'), $validData);
        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertStringContainsString('callback', session('success'));

        // Test 2: Missing required fields
        $invalidData = [
            'type' => 'appointment',
            'name' => '',
            'phone' => '',
            'service' => '',
            'message' => '',
        ];

        $response = $this->post(route('contact.store'), $invalidData);
        $response->assertSessionHasErrors(['name', 'phone', 'service']);
        $response->assertSessionDoesntHaveErrors(['message']); // Message is optional

        // Test 3: Invalid email format
        $invalidEmailData = [
            'type' => 'appointment',
            'name' => 'Jane Smith',
            'phone' => '+15554567890',
            'address' => 'not-an-email',
            'service' => 'house-cleaning',
            'message' => 'I need house cleaning service',
        ];

        $response = $this->post(route('contact.store'), $invalidEmailData);
        $response->assertSessionHasErrors(['address']);

        // Test 4: Invalid service selection
        $invalidServiceData = [
            'type' => 'appointment',
            'name' => 'Bob Wilson',
            'phone' => '+15554567890',
            'service' => 'invalid-service',
            'message' => 'Test message',
        ];

        $response = $this->post(route('contact.store'), $invalidServiceData);
        $response->assertSessionHasErrors(['service']);

        // Test 5: Message too short
        $shortMessageData = [
            'type' => 'appointment',
            'name' => 'Alice Brown',
            'phone' => '+15554567890',
            'service' => 'commercial-cleaning',
            'message' => 'Hi',
        ];

        $response = $this->post(route('contact.store'), $shortMessageData);
        $response->assertSessionHasErrors(['message']);

        // Test 6: All services work correctly
        $services = ['request-callback', 'carpet-cleaning', 'commercial-cleaning', 'house-cleaning'];
        
        foreach ($services as $service) {
            $serviceData = [
                'type' => 'appointment',
                'name' => 'Test User',
                'phone' => '+15554567890',
                'address' => 'test@example.com',
                'service' => $service,
                'message' => 'Testing service: ' . $service,
            ];

            $response = $this->post(route('contact.store'), $serviceData);
            $response->assertRedirect();
            $response->assertSessionHas('success');
        }
    }

    public function test_homepage_form_displays_correctly()
    {
        $response = $this->get('/');

        // Check form is present
        $response->assertStatus(200);
        $response->assertSee('Free Online Quote');
        
        // Check all form fields are present
        $response->assertSee('name="name"', false);
        $response->assertSee('name="phone"', false);
        $response->assertSee('name="address"', false);
        $response->assertSee('name="service"', false);
        $response->assertSee('name="message"', false);
        
        // Check service options are present
        $response->assertSee('Request A Callback');
        $response->assertSee('Carpet Cleaning');
        $response->assertSee('Commercial Cleaning');
        $response->assertSee('House Cleaning');
        
        // Check placeholders are correct
        $response->assertSee('Your Name');
        $response->assertSee('Phone Number*');
        $response->assertSee('Email Address');
        $response->assertSee('Notes for our team...');
    }

    public function test_form_preserves_data_on_validation_error()
    {
        $invalidData = [
            'type' => 'appointment',
            'name' => 'John Doe',
            'phone' => '123', // Too short
            'address' => 'john@example.com',
            'service' => 'house-cleaning',
            'message' => 'Test message for form persistence',
        ];

        $response = $this->post(route('contact.store'), $invalidData);
        
        // Should redirect back with errors
        $response->assertRedirect();
        $response->assertSessionHasErrors(['phone']);
        
        // Should preserve form data
        $this->assertEquals('John Doe', session('_old_input.name'));
        $this->assertEquals('123', session('_old_input.phone'));
        $this->assertEquals('john@example.com', session('_old_input.address'));
        $this->assertEquals('house-cleaning', session('_old_input.service'));
        $this->assertEquals('Test message for form persistence', session('_old_input.message'));
    }

    public function test_area_code_123_validation()
    {
        // Test various formats of 123 area code - all should be rejected
        $invalidPhones = [
            '123-456-7890',
            '(123) 456-7890', 
            '1234567890',
            '+1 123 456 7890',
            '123.456.7890',
        ];

        foreach ($invalidPhones as $invalidPhone) {
            $formData = [
                'type' => 'appointment',
                'name' => 'Test User',
                'phone' => $invalidPhone,
                'service' => 'request-callback',
            ];

            $response = $this->post(route('contact.store'), $formData);
            $response->assertSessionHasErrors(['phone']);
            
            // Verify the specific error message
            $errors = session('errors');
            $phoneErrors = $errors->get('phone');
            $this->assertStringContainsString('Area code 123 is not a valid area code', $phoneErrors[0]);
        }

        // Test that valid area codes still work
        $validFormData = [
            'type' => 'appointment',
            'name' => 'Test User',
            'phone' => '555-123-4567', // Valid area code
            'service' => 'request-callback',
        ];

        $response = $this->post(route('contact.store'), $validFormData);
        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionDoesntHaveErrors(['phone']);
    }
}