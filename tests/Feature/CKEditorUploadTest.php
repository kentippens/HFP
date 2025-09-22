<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CKEditorUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create storage disk for testing
        Storage::fake('public');
        
        // Create a test user
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_upload_valid_image()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg', 800, 600)->size(1000); // 1MB

        $response = $this->post('/admin/ckeditor/upload', [
            'upload' => $file
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'uploaded' => true,
        ]);
        $response->assertJsonStructure([
            'url',
            'uploaded',
            'fileName'
        ]);

        // Verify file was stored
        $this->assertTrue(Storage::disk('public')->exists('blog-content/' . $file->hashName()));
    }

    /** @test */
    public function unauthenticated_user_cannot_upload()
    {
        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->post('/admin/ckeditor/upload', [
            'upload' => $file
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function upload_rejects_non_image_files()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf');

        $response = $this->post('/admin/ckeditor/upload', [
            'upload' => $file
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'uploaded' => false,
        ]);
        $response->assertJsonStructure([
            'error' => ['message']
        ]);
    }

    /** @test */
    public function upload_rejects_oversized_files()
    {
        $this->actingAs($this->user);

        // Create a file larger than 5MB
        $file = UploadedFile::fake()->image('large.jpg')->size(6000); // 6MB

        $response = $this->post('/admin/ckeditor/upload', [
            'upload' => $file
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'uploaded' => false,
        ]);
    }

    /** @test */
    public function upload_rejects_invalid_image_dimensions()
    {
        $this->actingAs($this->user);

        // Create an image that's too small (dimensions validation)
        $file = UploadedFile::fake()->image('tiny.jpg', 5, 5); // 5x5 pixels

        $response = $this->post('/admin/ckeditor/upload', [
            'upload' => $file
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'uploaded' => false,
        ]);
    }

    /** @test */
    public function upload_requires_file_parameter()
    {
        $this->actingAs($this->user);

        $response = $this->post('/admin/ckeditor/upload', []);

        $response->assertStatus(422);
        $response->assertJson([
            'uploaded' => false,
        ]);
    }

    /** @test */
    public function upload_rejects_non_multipart_requests()
    {
        $this->actingAs($this->user);

        // Send a JSON request instead of multipart/form-data
        $response = $this->json('POST', '/admin/ckeditor/upload', [
            'upload' => 'not-a-file'
        ]);

        $response->assertStatus(403); // Security middleware should reject this
    }

    /** @test */
    public function upload_generates_secure_filename()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test image with spaces!@#$.jpg');

        $response = $this->post('/admin/ckeditor/upload', [
            'upload' => $file
        ]);

        $response->assertStatus(200);
        
        // Check that the filename was sanitized and includes timestamp + random string
        $url = $response->json('url');
        $filename = basename($url);
        
        // Should contain timestamp and random string
        $this->assertMatchesRegularExpression('/^\d+_[a-zA-Z0-9]+_.*\.jpg$/', $filename);
    }

    /** @test */
    public function rate_limiting_prevents_abuse()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg');

        // Make 11 requests quickly (limit is 10 per minute)
        for ($i = 0; $i < 11; $i++) {
            $response = $this->postJson('/admin/ckeditor/upload', [
                'upload' => $file
            ]);
            
            if ($i < 10) {
                // First 10 should succeed (or fail for other reasons)
                $this->assertNotEquals(429, $response->status());
            } else {
                // 11th should be rate limited
                $response->assertStatus(429);
                $response->assertJson([
                    'uploaded' => false,
                ]);
            }
        }
    }

    /** @test */
    public function upload_creates_directory_if_not_exists()
    {
        $this->actingAs($this->user);

        // Remove the directory to test auto-creation
        Storage::disk('public')->deleteDirectory('blog-content');
        $this->assertFalse(Storage::disk('public')->exists('blog-content'));

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->post('/admin/ckeditor/upload', [
            'upload' => $file
        ]);

        $response->assertStatus(200);
        
        // Directory should be created
        $this->assertTrue(Storage::disk('public')->exists('blog-content'));
    }

    /** @test */
    public function upload_verifies_file_after_storage()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->post('/admin/ckeditor/upload', [
            'upload' => $file
        ]);

        $response->assertStatus(200);
        
        // Verify the response includes all expected fields
        $response->assertJsonStructure([
            'url',
            'uploaded',
            'fileName'
        ]);

        // Verify the file actually exists and is accessible
        $url = $response->json('url');
        $path = str_replace('/storage/', '', parse_url($url, PHP_URL_PATH));
        $this->assertTrue(Storage::disk('public')->exists($path));
    }
}