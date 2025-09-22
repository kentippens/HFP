<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submission_saves_to_database(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'phone' => '555-123-4567',
            'address' => 'john@example.com',
            'service' => 'request-callback',
            'message' => 'This is a test message for contact form submission.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '555-123-4567',
            'message' => 'This is a test message for contact form submission.',
        ]);
    }

    public function test_name_splitting_with_multiple_names(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Mary Jane Smith',
            'phone' => '555-567-8901',
            'address' => 'mary@example.com',
            'service' => 'house-cleaning',
            'message' => 'Test message with multiple names.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'Mary',
            'last_name' => 'Jane Smith',
            'email' => 'mary@example.com',
        ]);
    }

    public function test_name_splitting_with_title(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Mr. Robert Johnson',
            'phone' => '555-999-9999',
            'address' => 'robert@example.com',
            'service' => 'carpet-cleaning',
            'message' => 'Test message with title prefix.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'Robert',
            'last_name' => 'Johnson',
            'email' => 'robert@example.com',
        ]);
    }

    public function test_single_name_only(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Madonna',
            'phone' => '555-000-0000',
            'address' => 'madonna@example.com',
            'service' => 'commercial-cleaning',
            'message' => 'Test message with single name only.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'Madonna',
            'last_name' => '',
            'email' => 'madonna@example.com',
        ]);
    }

    public function test_homepage_form_submission(): void
    {
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'name' => 'John Smith',
            'phone' => '555-111-2222',
            'address' => 'john.smith@example.com',
            'service' => 'house-cleaning',
            'message' => 'Please call me to schedule an appointment.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Thank you for your request! We will contact you shortly to schedule your callback.');

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john.smith@example.com',
            'source' => 'homepage_form',
        ]);
    }

    public function test_newsletter_subscription(): void
    {
        $response = $this->post('/contact', [
            'type' => 'newsletter',
            'email' => 'subscriber@example.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Thank you for subscribing to our newsletter!');

        $this->assertDatabaseHas('contact_submissions', [
            'email' => 'subscriber@example.com',
            'source' => 'newsletter',
            'first_name' => 'Newsletter',
            'last_name' => 'Subscriber',
            'message' => 'Newsletter subscription request',
        ]);
    }

    public function test_service_page_form_submission(): void
    {
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'source' => 'service_carpet-cleaning',
            'name' => 'Jane Doe',
            'phone' => '555-333-4444',
            'address' => 'jane.doe@example.com',
            'service' => 'carpet-cleaning',
            'message' => 'I need carpet cleaning for my office.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane.doe@example.com',
            'source' => 'service_carpet-cleaning',
        ]);
    }

    public function test_about_page_form_submission(): void
    {
        $response = $this->post('/contact', [
            'type' => 'appointment',
            'source' => 'about_page',
            'name' => 'Bob Wilson',
            'phone' => '555-555-5555',
            'address' => 'bob.wilson@example.com',
            'service' => 'commercial-cleaning',
            'message' => 'Need a quote for office cleaning.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'Bob',
            'last_name' => 'Wilson',
            'email' => 'bob.wilson@example.com',
            'source' => 'about_page',
        ]);
    }
}
