<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SanitizesHtml;
use App\Traits\LogsActivity;

class ContactSubmission extends Model
{
    use HasFactory, SanitizesHtml, LogsActivity;

    /**
     * Fields that should be sanitized as HTML
     */
    protected $htmlFields = ['message'];

    /**
     * Fields that should be stripped of HTML
     */
    protected $stripFields = ['first_name', 'last_name', 'email', 'phone', 'subject', 'service'];

    /**
     * Purifier config to use for this model
     */
    protected $purifierConfig = 'strict'; // Use strict config for user input

    /**
     * Activity log configuration.
     */
    protected $activityLogOptions = [
        'identifier' => 'email',
        'log_name' => 'contact',
        'events' => ['created', 'updated'],
        'except' => ['updated_at', 'created_at', 'user_agent', 'ip_address'],
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'message',
        'service',
        'source',
        'source_uri',
        'ip_address',
        'user_agent',
        'submitted_at',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeBySource($query, $source)
    {
        return $query->where('source', $source);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
