<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\BlogPost;
use App\Models\User;

class BlogWorkflowTest
{
    private $errors = [];
    private $warnings = [];
    private $successes = [];

    public function run()
    {
        echo "\n=== BLOG WORKFLOW TEST SUITE ===\n\n";

        // Test 1: Status Constants
        $this->testStatusConstants();

        // Test 2: Create test post
        $post = $this->createTestPost();

        if ($post) {
            // Test 3: Workflow transitions
            $this->testWorkflowTransitions($post);

            // Test 4: Invalid transitions
            $this->testInvalidTransitions($post);

            // Test 5: Scope tests
            $this->testScopes();

            // Test 6: Edge cases
            $this->testEdgeCases($post);

            // Cleanup
            $post->delete();
        }

        // Display results
        $this->displayResults();
    }

    private function testStatusConstants()
    {
        echo "Testing Status Constants...\n";

        try {
            // Check if constants exist
            $constants = [
                'STATUS_DRAFT' => BlogPost::STATUS_DRAFT,
                'STATUS_REVIEW' => BlogPost::STATUS_REVIEW,
                'STATUS_PUBLISHED' => BlogPost::STATUS_PUBLISHED,
                'STATUS_ARCHIVED' => BlogPost::STATUS_ARCHIVED,
            ];

            foreach ($constants as $name => $value) {
                if (empty($value)) {
                    $this->errors[] = "Constant $name is not defined or empty";
                } else {
                    $this->successes[] = "✓ Constant $name = '$value'";
                }
            }

            // Check STATUSES array
            if (!is_array(BlogPost::STATUSES)) {
                $this->errors[] = "STATUSES is not an array";
            } else {
                $this->successes[] = "✓ STATUSES array defined with " . count(BlogPost::STATUSES) . " items";
            }

            // Check STATUS_TRANSITIONS
            if (!is_array(BlogPost::STATUS_TRANSITIONS)) {
                $this->errors[] = "STATUS_TRANSITIONS is not an array";
            } else {
                $this->successes[] = "✓ STATUS_TRANSITIONS defined";
            }

        } catch (\Exception $e) {
            $this->errors[] = "Error testing constants: " . $e->getMessage();
        }
    }

    private function createTestPost()
    {
        echo "\nCreating test post...\n";

        try {
            $post = BlogPost::create([
                'name' => 'Test Workflow Post ' . time(),
                'slug' => 'test-workflow-' . time(),
                'content' => 'Test content for workflow validation',
                'excerpt' => 'Test excerpt',
                'status' => BlogPost::STATUS_DRAFT,
                'author_id' => 1,
                'category_id' => 1,
                'version' => 1,
            ]);

            if ($post) {
                $this->successes[] = "✓ Test post created with ID: " . $post->id;
                return $post;
            } else {
                $this->errors[] = "Failed to create test post";
                return null;
            }
        } catch (\Exception $e) {
            $this->errors[] = "Error creating test post: " . $e->getMessage();
            return null;
        }
    }

    private function testWorkflowTransitions($post)
    {
        echo "\nTesting workflow transitions...\n";

        try {
            // Test: Draft -> Review
            if ($post->canTransitionTo(BlogPost::STATUS_REVIEW)) {
                if ($post->submitForReview()) {
                    $this->successes[] = "✓ Draft → Review transition successful";

                    // Check timestamps
                    if ($post->submitted_for_review_at) {
                        $this->successes[] = "✓ submitted_for_review_at timestamp set";
                    } else {
                        $this->warnings[] = "submitted_for_review_at not set";
                    }
                } else {
                    $this->errors[] = "Failed to transition from Draft to Review";
                }
            } else {
                $this->errors[] = "Cannot transition from Draft to Review";
            }

            // Test: Review -> Published
            if ($post->status === BlogPost::STATUS_REVIEW) {
                if ($post->canTransitionTo(BlogPost::STATUS_PUBLISHED)) {
                    if ($post->approve(1, 'Approved for testing')) {
                        $this->successes[] = "✓ Review → Published transition successful";

                        // Check fields
                        if ($post->reviewed_at) {
                            $this->successes[] = "✓ reviewed_at timestamp set";
                        }
                        if ($post->reviewer_id == 1) {
                            $this->successes[] = "✓ reviewer_id set correctly";
                        }
                        if ($post->published_at) {
                            $this->successes[] = "✓ published_at timestamp set";
                        }
                    } else {
                        $this->errors[] = "Failed to approve post";
                    }
                } else {
                    $this->errors[] = "Cannot transition from Review to Published";
                }
            }

            // Test: Published -> Archived
            if ($post->status === BlogPost::STATUS_PUBLISHED) {
                if ($post->canTransitionTo(BlogPost::STATUS_ARCHIVED)) {
                    if ($post->archive()) {
                        $this->successes[] = "✓ Published → Archived transition successful";

                        if ($post->archived_at) {
                            $this->successes[] = "✓ archived_at timestamp set";
                        }
                        if (!$post->is_published) {
                            $this->successes[] = "✓ is_published set to false";
                        }
                    } else {
                        $this->errors[] = "Failed to archive post";
                    }
                } else {
                    $this->errors[] = "Cannot transition from Published to Archived";
                }
            }

            // Test: Archived -> Draft
            if ($post->status === BlogPost::STATUS_ARCHIVED) {
                if ($post->canTransitionTo(BlogPost::STATUS_DRAFT)) {
                    $oldVersion = $post->version;
                    if ($post->transitionTo(BlogPost::STATUS_DRAFT)) {
                        $this->successes[] = "✓ Archived → Draft transition successful";

                        if ($post->version > $oldVersion) {
                            $this->successes[] = "✓ Version incremented from $oldVersion to {$post->version}";
                        }
                    } else {
                        $this->errors[] = "Failed to transition from Archived to Draft";
                    }
                } else {
                    $this->errors[] = "Cannot transition from Archived to Draft";
                }
            }

        } catch (\Exception $e) {
            $this->errors[] = "Error in workflow transitions: " . $e->getMessage();
        }
    }

    private function testInvalidTransitions($post)
    {
        echo "\nTesting invalid transitions...\n";

        // Reset to draft
        $post->update(['status' => BlogPost::STATUS_DRAFT]);

        try {
            // Test: Draft -> Published (invalid)
            if (!$post->canTransitionTo(BlogPost::STATUS_PUBLISHED)) {
                $this->successes[] = "✓ Correctly prevents Draft → Published direct transition";
            } else {
                $this->errors[] = "Allows invalid Draft → Published transition";
            }

            // Test: Draft -> Draft (invalid)
            if (!$post->canTransitionTo(BlogPost::STATUS_DRAFT)) {
                $this->successes[] = "✓ Correctly prevents Draft → Draft transition";
            } else {
                $this->errors[] = "Allows invalid Draft → Draft transition";
            }

            // Set to published
            $post->update(['status' => BlogPost::STATUS_PUBLISHED]);

            // Test: Published -> Review (invalid)
            if (!$post->canTransitionTo(BlogPost::STATUS_REVIEW)) {
                $this->successes[] = "✓ Correctly prevents Published → Review transition";
            } else {
                $this->errors[] = "Allows invalid Published → Review transition";
            }

            // Test invalid status
            if (!$post->canTransitionTo('invalid_status')) {
                $this->successes[] = "✓ Correctly rejects invalid status";
            } else {
                $this->errors[] = "Accepts invalid status value";
            }

        } catch (\Exception $e) {
            $this->errors[] = "Error testing invalid transitions: " . $e->getMessage();
        }
    }

    private function testScopes()
    {
        echo "\nTesting scopes...\n";

        try {
            // Create posts with different statuses
            $draft = BlogPost::create([
                'name' => 'Draft Post Test',
                'slug' => 'draft-test-' . time(),
                'content' => 'Draft content',
                'status' => BlogPost::STATUS_DRAFT,
                'author_id' => 1,
                'category_id' => 1,
            ]);

            $review = BlogPost::create([
                'name' => 'Review Post Test',
                'slug' => 'review-test-' . time(),
                'content' => 'Review content',
                'status' => BlogPost::STATUS_REVIEW,
                'author_id' => 1,
                'category_id' => 1,
            ]);

            $published = BlogPost::create([
                'name' => 'Published Post Test',
                'slug' => 'published-test-' . time(),
                'content' => 'Published content',
                'status' => BlogPost::STATUS_PUBLISHED,
                'author_id' => 1,
                'category_id' => 1,
                'published_at' => now(),
            ]);

            // Test scopes
            $draftCount = BlogPost::draft()->count();
            if ($draftCount > 0) {
                $this->successes[] = "✓ draft() scope works - found $draftCount drafts";
            }

            $reviewCount = BlogPost::inReview()->count();
            if ($reviewCount > 0) {
                $this->successes[] = "✓ inReview() scope works - found $reviewCount in review";
            }

            $publishedCount = BlogPost::published()->count();
            if ($publishedCount > 0) {
                $this->successes[] = "✓ published() scope works - found $publishedCount published";
            }

            $notArchivedCount = BlogPost::notArchived()->count();
            if ($notArchivedCount > 0) {
                $this->successes[] = "✓ notArchived() scope works - found $notArchivedCount not archived";
            }

            // Test byStatus scope
            $byStatusCount = BlogPost::byStatus(BlogPost::STATUS_DRAFT)->count();
            if ($byStatusCount > 0) {
                $this->successes[] = "✓ byStatus() scope works";
            }

            // Cleanup
            $draft->delete();
            $review->delete();
            $published->delete();

        } catch (\Exception $e) {
            $this->errors[] = "Error testing scopes: " . $e->getMessage();
        }
    }

    private function testEdgeCases($post)
    {
        echo "\nTesting edge cases...\n";

        try {
            // Test null reviewer
            $post->update(['status' => BlogPost::STATUS_REVIEW]);
            $post->approve(null, 'Test without reviewer');

            if ($post->status === BlogPost::STATUS_PUBLISHED) {
                $this->warnings[] = "⚠ Allows approval without reviewer ID";
            }

            // Test rejection
            $post->update(['status' => BlogPost::STATUS_REVIEW]);
            if ($post->reject(1, 'Rejected for testing')) {
                $this->successes[] = "✓ Rejection works correctly";

                if ($post->review_notes === 'Rejected for testing') {
                    $this->successes[] = "✓ Review notes saved correctly";
                }
            }

            // Test status label
            $label = $post->status_label;
            if ($label && $label !== 'Unknown') {
                $this->successes[] = "✓ Status label accessor works: '$label'";
            }

            // Test status color
            $color = $post->status_color;
            if ($color && $color !== 'secondary') {
                $this->successes[] = "✓ Status color accessor works: '$color'";
            }

            // Test relationships
            if (method_exists($post, 'reviewer')) {
                $this->successes[] = "✓ Reviewer relationship defined";
            }

        } catch (\Exception $e) {
            $this->errors[] = "Error testing edge cases: " . $e->getMessage();
        }
    }

    private function displayResults()
    {
        echo "\n=== TEST RESULTS ===\n\n";

        if (count($this->successes) > 0) {
            echo "SUCCESSES (" . count($this->successes) . "):\n";
            foreach ($this->successes as $success) {
                echo "  $success\n";
            }
        }

        if (count($this->warnings) > 0) {
            echo "\nWARNINGS (" . count($this->warnings) . "):\n";
            foreach ($this->warnings as $warning) {
                echo "  ⚠ $warning\n";
            }
        }

        if (count($this->errors) > 0) {
            echo "\nERRORS (" . count($this->errors) . "):\n";
            foreach ($this->errors as $error) {
                echo "  ✗ $error\n";
            }
        }

        echo "\n=== SUMMARY ===\n";
        echo "Successes: " . count($this->successes) . "\n";
        echo "Warnings: " . count($this->warnings) . "\n";
        echo "Errors: " . count($this->errors) . "\n";

        $totalTests = count($this->successes) + count($this->warnings) + count($this->errors);
        $passRate = $totalTests > 0 ? round((count($this->successes) / $totalTests) * 100, 2) : 0;
        echo "Pass Rate: {$passRate}%\n\n";

        if (count($this->errors) === 0) {
            echo "✅ All critical tests passed!\n";
        } else {
            echo "❌ Some tests failed. Please review errors above.\n";
        }
    }
}

// Run the tests
$tester = new BlogWorkflowTest();
$tester->run();