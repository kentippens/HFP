<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PoolRemodelingFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful form submission with valid data
     */
    public function test_valid_pool_remodeling_form_submission()
    {
        $response = $this->post('/contact', [
            'type' => 'pool_remodeling_quote',
            'name' => 'John Doe',
            'phone' => '972-555-1234',
            'address' => 'john@example.com',
            'service' => 'tile-replacement',
            'message' => 'I need tile replacement for my pool.'
        ]);

        $response->assertSessionHas('success');
        $response->assertRedirect();

        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'John Doe',
            'phone' => '972-555-1234',
            'email' => 'john@example.com',
            'service' => 'tile-replacement',
        ]);
    }

    /**
     * Test form validation for missing required fields
     */
    public function test_form_requires_name()
    {
        $response = $this->post('/contact', [
            'type' => 'pool_remodeling_quote',
            'phone' => '972-555-1234',
            'service' => 'coping-installation',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test form validation for invalid phone number
     */
    public function test_form_validates_phone_format()
    {
        $response = $this->post('/contact', [
            'type' => 'pool_remodeling_quote',
            'name' => 'Jane Smith',
            'phone' => '123',  // Too short
            'service' => 'gelcoat-refinishing',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    /**
     * Test form validation for invalid email format
     */
    public function test_form_validates_email_format()
    {
        $response = $this->post('/contact', [
            'type' => 'pool_remodeling_quote',
            'name' => 'Bob Johnson',
            'phone' => '214-555-9876',
            'address' => 'not-an-email',
            'service' => 'pool-remodeling',
        ]);

        $response->assertSessionHasErrors(['address']);
    }

    /**
     * Test new service option - tile-replacement
     */
    public function test_accepts_tile_replacement_service()
    {
        $response = $this->post('/contact', [
            'type' => 'pool_remodeling_quote',
            'name' => 'Alice Brown',
            'phone' => '469-555-3333',
            'service' => 'tile-replacement',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
    }

    /**
     * Test new service option - coping-installation
     */
    public function test_accepts_coping_installation_service()
    {
        $response = $this->post('/contact', [
            'type' => 'pool_remodeling_quote',
            'name' => 'Charlie Davis',
            'phone' => '817-555-4444',
            'service' => 'coping-installation',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
    }

    /**
     * Test new service option - gelcoat-refinishing
     */
    public function test_accepts_gelcoat_refinishing_service()
    {
        $response = $this->post('/contact', [
            'type' => 'pool_remodeling_quote',
            'name' => 'Diana Evans',
            'phone' => '940-555-5555',
            'service' => 'gelcoat-refinishing',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
    }

    /**
     * Test rejection of invalid service option
     */
    public function test_rejects_invalid_service_option()
    {
        $response = $this->post('/contact', [
            'type' => 'pool_remodeling_quote',
            'name' => 'Frank Green',
            'phone' => '682-555-6666',
            'service' => 'invalid-service',
        ]);

        $response->assertSessionHasErrors(['service']);
    }

    /**
     * Test message validation - too short
     */
    public function test_validates_message_minimum_length()
    {
        $response = $this->post('/contact', [
            'type' => 'pool_remodeling_quote',
            'name' => 'Grace Hill',
            'phone' => '903-555-7777',
            'service' => 'pool-remodeling',
            'message' => 'Hi'  // Too short
        ]);

        $response->assertSessionHasErrors(['message']);
    }

    /**
     * Test all pool remodeling service options
     */
    public function test_all_pool_remodeling_services()
    {
        $services = [
            'request-callback',
            'pool-resurfacing-conversion',
            'pool-repair',
            'pool-remodeling',
            'tile-replacement',
            'coping-installation',
            'gelcoat-refinishing'
        ];

        foreach ($services as $service) {
            $response = $this->post('/contact', [
                'type' => 'pool_remodeling_quote',
                'name' => 'Test User',
                'phone' => '972-888-9999',
                'service' => $service,
            ]);

            $response->assertSessionHasNoErrors();
            $response->assertSessionHas('success');
        }
    }

    /**
     * Test form handles empty optional fields correctly
     */
    public function test_handles_optional_fields()
    {
        $response = $this->post('/contact', [
            'type' => 'pool_remodeling_quote',
            'name' => 'Minimal User',
            'phone' => '214-777-8888',
            'service' => 'tile-replacement',
            // No email (address) or message provided
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'Minimal User',
            'phone' => '214-777-8888',
            'service' => 'tile-replacement',
        ]);
    }
}