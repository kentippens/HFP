<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ContactSubmission;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test homepage form submission
     */
    public function test_homepage_form_submission()
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'John Doe',
            'phone' => '214-555-1234',
            'address' => 'john@example.com',
            'service' => 'cleaning-house',
            'message' => 'This is a test message from homepage',
            'type' => 'appointment'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '214-555-1234',
            'service' => 'cleaning-house',
            'source' => 'homepage_form'
        ]);
    }

    /**
     * Test contact page form submission
     */
    public function test_contact_page_form_submission()
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Jane Smith',
            'phone' => '972-555-6789',
            'address' => 'jane@example.com',
            'service' => 'cleaning-commercial',
            'message' => 'Need commercial cleaning quote'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'source' => 'contact_page'
        ]);
    }

    /**
     * Test service form submission
     */
    public function test_service_form_submission()
    {
        $response = $this->post(route('contact.store'), [
            'fname' => 'Bob Johnson',
            'pnumber' => '469-555-2468',
            'message' => 'Interested in pool cleaning service'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'phone' => '469-555-2468',
            'source' => 'service_form'
        ]);
    }

    /**
     * Test newsletter form submission
     */
    public function test_newsletter_form_submission()
    {
        $response = $this->post(route('contact.store'), [
            'email' => 'newsletter@example.com',
            'type' => 'newsletter'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'email' => 'newsletter@example.com',
            'source' => 'newsletter',
            'first_name' => 'Newsletter',
            'last_name' => 'Subscriber'
        ]);
    }

    /**
     * Test investor relations form submission
     */
    public function test_investor_relations_form_submission()
    {
        $response = $this->post(route('contact.investor.store'), [
            'name' => 'Investor Name',
            'email' => 'investor@example.com',
            'phone' => '817-555-9876',
            'company' => 'Test Company LLC',
            'investment_interest' => 'franchise',
            'investment_amount' => '100k_250k',
            'message' => 'Interested in franchise opportunities'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'email' => 'investor@example.com',
            'source' => 'investor_relations_page'
        ]);
    }

    /**
     * Test validation for required fields
     */
    public function test_validation_for_required_fields()
    {
        $response = $this->post(route('contact.store'), [
            'type' => 'appointment'
            // Missing required fields
        ]);

        $response->assertSessionHasErrors(['name', 'phone', 'service']);
    }

    /**
     * Test blocked phone numbers
     */
    public function test_blocked_phone_numbers()
    {
        $blockedNumbers = ['123-456-7890', '000-111-2222', '555-123-4567', '111-222-3333'];

        foreach ($blockedNumbers as $phone) {
            $response = $this->post(route('contact.store'), [
                'name' => 'Test User',
                'phone' => $phone,
                'service' => 'cleaning-house',
                'type' => 'appointment'
            ]);

            $response->assertSessionHasErrors('phone');
        }
    }

    /**
     * Test email validation
     */
    public function test_email_validation()
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Test User',
            'phone' => '214-555-1234',
            'address' => 'invalid-email',
            'service' => 'cleaning-house',
            'type' => 'appointment'
        ]);

        $response->assertSessionHasErrors('address');
    }

    /**
     * Test message minimum length
     */
    public function test_message_minimum_length()
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Test User',
            'phone' => '214-555-1234',
            'service' => 'cleaning-house',
            'message' => 'Short',
            'type' => 'appointment'
        ]);

        $response->assertSessionHasErrors('message');
    }

    /**
     * Test name validation (letters only)
     */
    public function test_name_validation()
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Test123',
            'phone' => '214-555-1234',
            'service' => 'cleaning-house',
            'type' => 'appointment'
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test concurrent submissions
     */
    public function test_concurrent_submissions()
    {
        $submissions = [];
        
        for ($i = 1; $i <= 3; $i++) {
            $response = $this->post(route('contact.store'), [
                'name' => "User {$i}",
                'phone' => "214-555-000{$i}",
                'service' => 'cleaning-house',
                'type' => 'appointment'
            ]);
            
            $response->assertRedirect();
            $response->assertSessionHas('success');
        }

        $this->assertEquals(3, ContactSubmission::count());
    }

    /**
     * Test XSS prevention
     */
    public function test_xss_prevention()
    {
        $response = $this->post(route('contact.store'), [
            'name' => '<script>alert("XSS")</script>Test User',
            'phone' => '214-555-1234',
            'service' => 'cleaning-house',
            'message' => '<img src=x onerror=alert("XSS")>',
            'type' => 'appointment'
        ]);

        // Should either fail validation or strip tags
        if ($response->status() === 302 && $response->getSession()->has('success')) {
            $submission = ContactSubmission::latest()->first();
            $this->assertStringNotContainsString('<script>', $submission->first_name);
            $this->assertStringNotContainsString('<img', $submission->message);
        } else {
            $response->assertSessionHasErrors();
        }
    }

    /**
     * Test SQL injection prevention
     */
    public function test_sql_injection_prevention()
    {
        $response = $this->post(route('contact.store'), [
            'name' => "Test'; DROP TABLE contact_submissions; --",
            'phone' => '214-555-1234',
            'service' => 'cleaning-house',
            'type' => 'appointment'
        ]);

        // Table should still exist
        $this->assertTrue(\Schema::hasTable('contact_submissions'));
    }

    /**
     * Test metadata collection
     */
    public function test_metadata_collection()
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Test Browser 1.0'
        ])->post(route('contact.store'), [
            'name' => 'Test User',
            'phone' => '214-555-1234',
            'service' => 'cleaning-house',
            'type' => 'appointment'
        ]);

        $response->assertRedirect();

        $submission = ContactSubmission::latest()->first();
        $this->assertNotNull($submission->ip_address);
        $this->assertNotNull($submission->user_agent);
        $this->assertNotNull($submission->submitted_at);
    }
}