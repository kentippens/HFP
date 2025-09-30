<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\User;
use App\Exceptions\BlogWorkflowException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $testPost;
    protected $testUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test user
        $this->testUser = User::factory()->create();

        // Create test post
        $this->testPost = BlogPost::create([
            'name' => 'Test Workflow Post',
            'slug' => 'test-workflow-post',
            'content' => 'This is test content for workflow testing',
            'excerpt' => 'Test excerpt',
            'status' => BlogPost::STATUS_DRAFT,
            'author_id' => $this->testUser->id,
            'category_id' => 1,
            'meta_robots' => 'index, follow',
        ]);
    }

    /**
     * Test valid workflow transitions
     */
    public function test_draft_to_review_transition()
    {
        $this->assertEquals(BlogPost::STATUS_DRAFT, $this->testPost->status);

        $result = $this->testPost->submitForReview();

        $this->assertTrue($result);
        $this->assertEquals(BlogPost::STATUS_REVIEW, $this->testPost->fresh()->status);
        $this->assertNotNull($this->testPost->fresh()->submitted_for_review_at);
    }

    public function test_review_to_published_transition()
    {
        $this->testPost->submitForReview();
        $this->testPost->refresh();

        $result = $this->testPost->approve($this->testUser->id, 'Looks good!');

        $this->assertTrue($result);
        $this->assertEquals(BlogPost::STATUS_PUBLISHED, $this->testPost->fresh()->status);
        $this->assertEquals($this->testUser->id, $this->testPost->fresh()->reviewer_id);
        $this->assertNotNull($this->testPost->fresh()->reviewed_at);
        $this->assertNotNull($this->testPost->fresh()->published_at);
        $this->assertTrue($this->testPost->fresh()->is_published);
    }

    public function test_review_to_draft_rejection()
    {
        $this->testPost->submitForReview();
        $this->testPost->refresh();

        $result = $this->testPost->reject($this->testUser->id, 'Needs more work');

        $this->assertTrue($result);
        $this->assertEquals(BlogPost::STATUS_DRAFT, $this->testPost->fresh()->status);
        $this->assertEquals('Needs more work', $this->testPost->fresh()->review_notes);
        $this->assertEquals(2, $this->testPost->fresh()->version); // Version should increment
    }

    public function test_published_to_archived_transition()
    {
        $this->testPost->submitForReview();
        $this->testPost->refresh();
        $this->testPost->approve($this->testUser->id);
        $this->testPost->refresh();

        $result = $this->testPost->archive();

        $this->assertTrue($result);
        $this->assertEquals(BlogPost::STATUS_ARCHIVED, $this->testPost->fresh()->status);
        $this->assertNotNull($this->testPost->fresh()->archived_at);
        $this->assertFalse($this->testPost->fresh()->is_published);
    }

    public function test_archived_to_draft_transition()
    {
        $this->testPost->update(['status' => BlogPost::STATUS_ARCHIVED]);
        $oldVersion = $this->testPost->version;

        $result = $this->testPost->transitionTo(BlogPost::STATUS_DRAFT);

        $this->assertTrue($result);
        $this->assertEquals(BlogPost::STATUS_DRAFT, $this->testPost->fresh()->status);
        $this->assertEquals($oldVersion + 1, $this->testPost->fresh()->version);
    }

    /**
     * Test invalid transitions
     */
    public function test_direct_draft_to_published_throws_exception()
    {
        $this->expectException(BlogWorkflowException::class);
        $this->expectExceptionMessage("Invalid workflow transition from 'draft' to 'published'");

        $this->testPost->transitionTo(BlogPost::STATUS_PUBLISHED);
    }

    public function test_published_to_review_throws_exception()
    {
        $this->testPost->update(['status' => BlogPost::STATUS_PUBLISHED]);

        $this->expectException(BlogWorkflowException::class);
        $this->expectExceptionMessage("Invalid workflow transition from 'published' to 'review'");

        $this->testPost->transitionTo(BlogPost::STATUS_REVIEW);
    }

    public function test_same_status_transition_throws_exception()
    {
        $this->expectException(BlogWorkflowException::class);
        $this->expectExceptionMessage("Invalid workflow transition from 'draft' to 'draft'");

        $this->testPost->transitionTo(BlogPost::STATUS_DRAFT);
    }

    /**
     * Test validation errors
     */
    public function test_approve_without_reviewer_throws_exception()
    {
        $this->testPost->submitForReview();
        $this->testPost->refresh();

        $this->expectException(BlogWorkflowException::class);
        $this->expectExceptionMessage("A reviewer must be specified");

        $this->testPost->approve(null);
    }

    public function test_reject_without_reviewer_throws_exception()
    {
        $this->testPost->submitForReview();
        $this->testPost->refresh();

        $this->expectException(BlogWorkflowException::class);
        $this->expectExceptionMessage("A reviewer must be specified");

        $this->testPost->reject(null, 'Notes');
    }

    public function test_reject_without_notes_throws_exception()
    {
        $this->testPost->submitForReview();
        $this->testPost->refresh();

        $this->expectException(BlogWorkflowException::class);
        $this->expectExceptionMessage("Review notes are required when rejecting a post");

        $this->testPost->reject($this->testUser->id, '');
    }

    /**
     * Test scopes
     */
    public function test_status_scopes()
    {
        // Create posts with different statuses
        BlogPost::factory()->create(['status' => BlogPost::STATUS_DRAFT]);
        BlogPost::factory()->create(['status' => BlogPost::STATUS_REVIEW]);
        BlogPost::factory()->create([
            'status' => BlogPost::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);
        BlogPost::factory()->create(['status' => BlogPost::STATUS_ARCHIVED]);

        $this->assertEquals(2, BlogPost::draft()->count()); // Including our test post
        $this->assertEquals(1, BlogPost::inReview()->count());
        $this->assertEquals(1, BlogPost::published()->count());
        $this->assertEquals(1, BlogPost::archived()->count());
        $this->assertEquals(3, BlogPost::notArchived()->count());
    }

    public function test_by_status_scope()
    {
        BlogPost::factory()->count(3)->create(['status' => BlogPost::STATUS_DRAFT]);

        $drafts = BlogPost::byStatus(BlogPost::STATUS_DRAFT)->count();

        $this->assertEquals(4, $drafts); // 3 new + 1 test post
    }

    /**
     * Test helper methods
     */
    public function test_can_transition_to_method()
    {
        // From draft
        $this->assertTrue($this->testPost->canTransitionTo(BlogPost::STATUS_REVIEW));
        $this->assertTrue($this->testPost->canTransitionTo(BlogPost::STATUS_ARCHIVED));
        $this->assertFalse($this->testPost->canTransitionTo(BlogPost::STATUS_PUBLISHED));
        $this->assertFalse($this->testPost->canTransitionTo(BlogPost::STATUS_DRAFT));

        // From review
        $this->testPost->update(['status' => BlogPost::STATUS_REVIEW]);
        $this->assertTrue($this->testPost->canTransitionTo(BlogPost::STATUS_DRAFT));
        $this->assertTrue($this->testPost->canTransitionTo(BlogPost::STATUS_PUBLISHED));
        $this->assertTrue($this->testPost->canTransitionTo(BlogPost::STATUS_ARCHIVED));
        $this->assertFalse($this->testPost->canTransitionTo(BlogPost::STATUS_REVIEW));
    }

    public function test_status_label_accessor()
    {
        $this->assertEquals('Draft', $this->testPost->status_label);

        $this->testPost->update(['status' => BlogPost::STATUS_REVIEW]);
        $this->assertEquals('Under Review', $this->testPost->status_label);

        $this->testPost->update(['status' => BlogPost::STATUS_PUBLISHED]);
        $this->assertEquals('Published', $this->testPost->status_label);

        $this->testPost->update(['status' => BlogPost::STATUS_ARCHIVED]);
        $this->assertEquals('Archived', $this->testPost->status_label);
    }

    public function test_status_color_accessor()
    {
        $this->assertEquals('gray', $this->testPost->status_color);

        $this->testPost->update(['status' => BlogPost::STATUS_REVIEW]);
        $this->assertEquals('warning', $this->testPost->status_color);

        $this->testPost->update(['status' => BlogPost::STATUS_PUBLISHED]);
        $this->assertEquals('success', $this->testPost->status_color);

        $this->testPost->update(['status' => BlogPost::STATUS_ARCHIVED]);
        $this->assertEquals('danger', $this->testPost->status_color);
    }

    /**
     * Test relationships
     */
    public function test_reviewer_relationship()
    {
        $this->testPost->submitForReview();
        $this->testPost->refresh();
        $this->testPost->approve($this->testUser->id);
        $this->testPost->refresh();

        $this->assertInstanceOf(User::class, $this->testPost->reviewer);
        $this->assertEquals($this->testUser->id, $this->testPost->reviewer->id);
    }
}