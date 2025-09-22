<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageFormValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_form_accepts_empty_message(): void
    {
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'Test User',
            'phone' => '555-123-4567',
            'address' => 'test@example.com',
            'service' => 'house-cleaning',
            'message' => '',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionDoesntHaveErrors(['message']);

        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'Test User',
            'source' => 'homepage_form',
        ]);
    }

    public function test_homepage_form_accepts_null_message(): void
    {
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'Another User',
            'phone' => '555-987-6543',
            'address' => 'another@example.com',
            'service' => 'carpet-cleaning',
            // message field omitted entirely
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionDoesntHaveErrors(['message']);

        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'Another User',
            'source' => 'homepage_form',
        ]);
    }

    public function test_homepage_form_rejects_short_message(): void
    {
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'Test User',
            'phone' => '555-123-4567',
            'address' => 'test@example.com',
            'service' => 'house-cleaning',
            'message' => 'Hi', // Too short
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['message']);
    }

    public function test_homepage_form_validates_all_fields(): void
    {
        // Test missing name
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'phone' => '555-123-4567',
            'address' => 'test@example.com',
            'service' => 'house-cleaning',
        ]);
        $response->assertSessionHasErrors(['name']);

        // Test missing phone
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'Test User',
            'address' => 'test@example.com',
            'service' => 'house-cleaning',
        ]);
        $response->assertSessionHasErrors(['phone']);

        // Test invalid email
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'Test User',
            'phone' => '555-123-4567',
            'address' => 'not-an-email',
            'service' => 'house-cleaning',
        ]);
        $response->assertSessionHasErrors(['address']);

        // Test short phone
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'Test User',
            'phone' => '555',
            'address' => 'test@example.com',
            'service' => 'house-cleaning',
        ]);
        $response->assertSessionHasErrors(['phone']);
    }

    public function test_homepage_form_with_area_code_123(): void
    {
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'Test User',
            'phone' => '123-456-7890',
            'address' => 'test@example.com',
            'service' => 'house-cleaning',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['phone']);
        $response->assertSessionHasErrors(); // Should have validation error

        // Check specific error message
        $errors = session('errors');
        $this->assertNotNull($errors, 'No errors found in session');
        if ($errors) {
            $phoneErrors = $errors->get('phone');
            $this->assertNotEmpty($phoneErrors, 'No phone errors found');
            $this->assertStringContainsString('Area code 123 is not a valid area code', $phoneErrors[0]);
        }
    }

    public function test_database_name_splitting(): void
    {
        // Test 1: Simple two-part name
        $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'John Doe',
            'phone' => '555-111-1111',
            'address' => 'john@example.com',
            'service' => 'house-cleaning',
        ]);

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        // Test 2: Three-part name
        $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'Mary Jane Smith',
            'phone' => '555-222-2222',
            'address' => 'mary@example.com',
            'service' => 'house-cleaning',
        ]);

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'Mary',
            'last_name' => 'Jane Smith',
        ]);

        // Test 3: Name with title
        $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'Dr. Robert Johnson',
            'phone' => '555-333-3333',
            'address' => 'robert@example.com',
            'service' => 'house-cleaning',
        ]);

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'Robert',
            'last_name' => 'Johnson',
        ]);
    }
}
