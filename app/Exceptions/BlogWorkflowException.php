<?php

namespace App\Exceptions;

use Exception;

class BlogWorkflowException extends Exception
{
    protected $currentStatus;
    protected $targetStatus;
    protected $postId;

    public function __construct($message, $currentStatus = null, $targetStatus = null, $postId = null)
    {
        parent::__construct($message);
        $this->currentStatus = $currentStatus;
        $this->targetStatus = $targetStatus;
        $this->postId = $postId;
    }

    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    public function getTargetStatus()
    {
        return $this->targetStatus;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public static function invalidTransition($current, $target, $postId = null)
    {
        return new static(
            "Invalid workflow transition from '{$current}' to '{$target}'",
            $current,
            $target,
            $postId
        );
    }

    public static function missingReviewer()
    {
        return new static("A reviewer must be specified when approving or rejecting a post");
    }

    public static function missingReviewNotes()
    {
        return new static("Review notes are required when rejecting a post");
    }

    public static function invalidStatus($status)
    {
        return new static("Invalid status value: '{$status}'");
    }

    public static function transitionFailed($reason)
    {
        return new static("Workflow transition failed: {$reason}");
    }
}