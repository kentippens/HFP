<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_contact_form()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Free Online Quote');
        $response->assertSee('name="name"', false);
        $response->assertSee('name="phone"', false);
        $response->assertSee('name="address"', false);
        $response->assertSee('name="service"', false);
        $response->assertSee('name="message"', false);
    }

    public function test_can_submit_homepage_contact_form_with_valid_data()
    {
        $formData = [
            'type' => 'appointment',
            'name' => 'John Doe',
            'phone' => '+15554567890',
            'address' => 'john@example.com',
            'service' => 'request-callback',
            'message' => 'Please call me back regarding your services.',
        ];

        $response = $this->post(route('contact.store'), $formData);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_homepage_form_validates_required_fields()
    {
        $response = $this->post(route('contact.store'), [
            'type' => 'appointment'
        ]);

        $response->assertSessionHasErrors(['name', 'phone', 'service']);
        $response->assertSessionDoesntHaveErrors(['message']);
    }

    public function test_homepage_form_validates_email_format()
    {
        $formData = [
            'type' => 'appointment',
            'name' => 'John Doe',
            'phone' => '+15554567890',
            'address' => 'invalid-email',
            'service' => 'request-callback',
            'message' => 'Test message',
        ];

        $response = $this->post(route('contact.store'), $formData);

        $response->assertSessionHasErrors(['address']);
    }

    public function test_homepage_form_validates_phone_number()
    {
        $formData = [
            'type' => 'appointment',
            'name' => 'John Doe',
            'phone' => '', // Empty phone
            'address' => 'john@example.com',
            'service' => 'request-callback',
            'message' => 'Test message',
        ];

        $response = $this->post(route('contact.store'), $formData);

        $response->assertSessionHasErrors(['phone']);
    }

    public function test_homepage_form_accepts_different_services()
    {
        $services = ['request-callback', 'carpet-cleaning', 'commercial-cleaning', 'house-cleaning'];

        foreach ($services as $service) {
            $formData = [
                'type' => 'appointment',
                'name' => 'John Doe',
                'phone' => '+15554567890',
                'address' => 'john@example.com',
                'service' => $service,
                'message' => 'Test message for ' . $service,
            ];

            $response = $this->post(route('contact.store'), $formData);
            $response->assertRedirect();
            $response->assertSessionHas('success');
        }
    }

    public function test_homepage_form_validates_name_length()
    {
        $formData = [
            'type' => 'appointment',
            'name' => str_repeat('a', 256), // Too long
            'phone' => '+15554567890',
            'address' => 'john@example.com',
            'service' => 'request-callback',
            'message' => 'Test message',
        ];

        $response = $this->post(route('contact.store'), $formData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_homepage_form_validates_phone_length()
    {
        $formData = [
            'type' => 'appointment',
            'name' => 'John Doe',
            'phone' => str_repeat('1', 21), // Too long
            'address' => 'john@example.com',
            'service' => 'request-callback',
            'message' => 'Test message',
        ];

        $response = $this->post(route('contact.store'), $formData);

        $response->assertSessionHasErrors(['phone']);
    }

    public function test_homepage_form_handles_special_characters()
    {
        $formData = [
            'type' => 'appointment',
            'name' => 'José María O\'Connor',
            'phone' => '+1 (555) 123-4567',
            'address' => 'josé@example.com',
            'service' => 'house-cleaning',
            'message' => 'Test message with special chars: àáâãäå',
        ];

        $response = $this->post(route('contact.store'), $formData);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_homepage_form_sanitizes_input()
    {
        $formData = [
            'type' => 'appointment',
            'name' => '<script>alert("xss")</script>John Doe',
            'phone' => '+15554567890',
            'address' => 'john@example.com',
            'service' => 'request-callback',
            'message' => '<p>Test message</p>',
        ];

        $response = $this->post(route('contact.store'), $formData);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_homepage_form_handles_empty_optional_fields()
    {
        $formData = [
            'type' => 'appointment',
            'name' => 'John Doe',
            'phone' => '+15554567890',
            'address' => '', // Optional email
            'service' => 'request-callback',
            'message' => '', // Optional message
        ];

        $response = $this->post(route('contact.store'), $formData);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_homepage_form_message_field_is_optional()
    {
        $formData = [
            'type' => 'appointment',
            'name' => 'John Doe',
            'phone' => '+15554567890',
            'service' => 'request-callback',
            // No message field provided
        ];

        $response = $this->post(route('contact.store'), $formData);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionDoesntHaveErrors(['message']);
    }

    public function test_homepage_form_validates_message_length_when_provided()
    {
        $formData = [
            'type' => 'appointment',
            'name' => 'John Doe',
            'phone' => '+15554567890',
            'service' => 'request-callback',
            'message' => 'Short', // Less than 10 characters
        ];

        $response = $this->post(route('contact.store'), $formData);

        $response->assertSessionHasErrors(['message']);
    }

    public function test_homepage_form_rejects_area_code_123()
    {
        $invalidPhoneNumbers = [
            '123-456-7890',
            '(123) 456-7890',
            '1234567890',
            '+1 123-456-7890',
            '+1-123-456-7890',
            '123 456 7890',
        ];

        foreach ($invalidPhoneNumbers as $phone) {
            $formData = [
                'type' => 'appointment',
                'name' => 'John Doe',
                'phone' => $phone,
                'service' => 'request-callback',
            ];

            $response = $this->post(route('contact.store'), $formData);
            $response->assertSessionHasErrors(['phone']);
            
            // Check that the error message mentions area code 123
            $errors = session('errors');
            $phoneErrors = $errors->get('phone');
            $this->assertStringContainsString('Area code 123', $phoneErrors[0]);
        }
    }

    public function test_homepage_form_accepts_valid_area_codes()
    {
        $validPhoneNumbers = [
            '212-456-7890', // NYC
            '310-456-7890', // LA
            '415-456-7890', // SF
            '713-456-7890', // Houston
            '(555) 123-4567', // Common test number
        ];

        foreach ($validPhoneNumbers as $phone) {
            $formData = [
                'type' => 'appointment',
                'name' => 'John Doe',
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