<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AddFilamentAuthorization extends Command
{
    protected $signature = 'filament:add-authorization';
    protected $description = 'Add authorization methods to Filament resources';

    protected $resources = [
        'UserResource' => 'User',
        'ContactSubmissionResource' => 'ContactSubmission',
        'CorePageResource' => 'CorePage',
        'LandingPageResource' => 'LandingPage',
        'BlogCategoryResource' => 'BlogCategory',
        'SiloResource' => 'Silo',
        'TrackingScriptResource' => 'TrackingScript',
        'ActivityLogResource' => 'ActivityLog',
    ];

    public function handle()
    {
        foreach ($this->resources as $resourceClass => $modelClass) {
            $this->addAuthorizationToResource($resourceClass, $modelClass);
        }

        $this->info('Authorization methods have been added to all Filament resources!');
        return 0;
    }

    protected function addAuthorizationToResource($resourceClass, $modelClass)
    {
        $filePath = app_path("Filament/Resources/{$resourceClass}.php");

        if (!File::exists($filePath)) {
            $this->warn("Resource file not found: {$filePath}");
            return;
        }

        $content = File::get($filePath);

        // Check if authorization methods already exist
        if (Str::contains($content, 'public static function canViewAny()')) {
            $this->info("{$resourceClass} already has authorization methods.");
            return;
        }

        // Add use statement for the model if not present
        $useStatement = "use App\\Models\\{$modelClass};";
        if (!Str::contains($content, $useStatement)) {
            // Add after namespace declaration
            $content = preg_replace(
                '/namespace App\\\\Filament\\\\Resources;/',
                "namespace App\\Filament\\Resources;\n\n{$useStatement}",
                $content
            );
        }

        // Authorization methods to add
        $authorizationMethods = $this->getAuthorizationMethods($modelClass);

        // Find the last closing brace of the class
        $lastBracePosition = strrpos($content, '}');

        if ($lastBracePosition !== false) {
            // Insert authorization methods before the last closing brace
            $content = substr($content, 0, $lastBracePosition) .
                       "\n" . $authorizationMethods .
                       substr($content, $lastBracePosition);
        }

        // Save the updated content
        File::put($filePath, $content);
        $this->info("Added authorization methods to {$resourceClass}");
    }

    protected function getAuthorizationMethods($modelClass)
    {
        // For ActivityLog, we don't need full CRUD, just view
        if ($modelClass === 'ActivityLog') {
            return <<<PHP

    /**
     * Determine if the user can view any records.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('logs.view') ?? false;
    }

    /**
     * Determine if the user can view the record.
     */
    public static function canView(\$record): bool
    {
        return auth()->user()?->hasPermission('logs.view') ?? false;
    }

    /**
     * ActivityLogs are read-only
     */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\$record): bool
    {
        return false;
    }

    public static function canDelete(\$record): bool
    {
        return false;
    }
PHP;
        }

        return <<<PHP

    /**
     * Determine if the user can view any records.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('viewAny', {$modelClass}::class) ?? false;
    }

    /**
     * Determine if the user can create records.
     */
    public static function canCreate(): bool
    {
        return auth()->user()?->can('create', {$modelClass}::class) ?? false;
    }

    /**
     * Determine if the user can edit the record.
     */
    public static function canEdit(\$record): bool
    {
        return auth()->user()?->can('update', \$record) ?? false;
    }

    /**
     * Determine if the user can delete the record.
     */
    public static function canDelete(\$record): bool
    {
        return auth()->user()?->can('delete', \$record) ?? false;
    }

    /**
     * Determine if the user can view the record.
     */
    public static function canView(\$record): bool
    {
        return auth()->user()?->can('view', \$record) ?? false;
    }
PHP;
    }
}