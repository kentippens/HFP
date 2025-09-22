<?php

namespace App\Services;

use App\Models\TrackingScript;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class TrackingScriptService
{
    /**
     * Get all active tracking scripts for a specific position
     */
    public function getScriptsForPosition(string $position): array
    {
        try {
            $cacheKey = "tracking_scripts_{$position}";
            
            return Cache::remember($cacheKey, 300, function () use ($position) {
                return TrackingScript::active()
                    ->byPosition($position)
                    ->ordered()
                    ->get()
                    ->map(function ($script) {
                        return $this->renderScript($script);
                    })
                    ->filter()
                    ->toArray();
            });
        } catch (\Exception $e) {
            Log::error('Error fetching tracking scripts for position: ' . $position, [
                'error' => $e->getMessage(),
                'position' => $position
            ]);
            return [];
        }
    }

    /**
     * Render a single tracking script with error handling
     */
    public function renderScript(TrackingScript $script): ?string
    {
        try {
            if (!$script->is_active) {
                return null;
            }

            // Validate script before rendering
            if (!$script->validateScriptCode()) {
                Log::warning('Invalid tracking script detected', [
                    'script_id' => $script->id,
                    'script_name' => $script->name,
                    'script_type' => $script->type
                ]);
                return null;
            }

            $formattedScript = $script->getSafeFormattedScript();
            
            if (empty($formattedScript)) {
                Log::warning('Empty tracking script after formatting', [
                    'script_id' => $script->id,
                    'script_name' => $script->name
                ]);
                return null;
            }

            // Add error handling wrapper for client-side errors
            return $this->wrapScriptWithErrorHandling($formattedScript, $script);
            
        } catch (\Exception $e) {
            Log::error('Error rendering tracking script', [
                'script_id' => $script->id,
                'script_name' => $script->name,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Wrap script with client-side error handling
     */
    private function wrapScriptWithErrorHandling(string $script, TrackingScript $trackingScript): string
    {
        // For non-script content (like noscript tags), return as-is
        if (!str_contains($script, '<script')) {
            return $script;
        }

        $scriptId = $trackingScript->id;
        $scriptName = htmlspecialchars($trackingScript->name);
        
        // Wrap script content with try-catch
        $wrappedScript = preg_replace_callback(
            '/<script([^>]*)>(.*?)<\/script>/s',
            function ($matches) use ($scriptId, $scriptName) {
                $attributes = $matches[1];
                $content = $matches[2];
                
                // Skip if script has src attribute (external scripts)
                if (str_contains($attributes, 'src=')) {
                    return $matches[0];
                }
                
                $errorHandler = "
                try {
                    {$content}
                } catch (e) {
                    console.error('Tracking script error in {$scriptName}:', e);
                    if (window.trackingScriptErrors) {
                        window.trackingScriptErrors.push({
                            scriptId: '{$scriptId}',
                            scriptName: '{$scriptName}',
                            error: e.message,
                            timestamp: new Date().toISOString()
                        });
                    }
                }";
                
                return "<script{$attributes}>{$errorHandler}</script>";
            },
            $script
        );

        return $wrappedScript;
    }

    /**
     * Get all tracking scripts grouped by position
     */
    public function getAllScriptsByPosition(): array
    {
        try {
            $positions = array_keys(TrackingScript::SCRIPT_POSITIONS);
            $scriptsByPosition = [];

            foreach ($positions as $position) {
                $scriptsByPosition[$position] = $this->getScriptsForPosition($position);
            }

            return $scriptsByPosition;
        } catch (\Exception $e) {
            Log::error('Error fetching all tracking scripts', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Clear tracking scripts cache
     */
    public function clearCache(): void
    {
        $positions = array_keys(TrackingScript::SCRIPT_POSITIONS);
        
        foreach ($positions as $position) {
            Cache::forget("tracking_scripts_{$position}");
        }
    }

    /**
     * Get script statistics
     */
    public function getScriptStats(): array
    {
        try {
            return [
                'total_scripts' => TrackingScript::count(),
                'active_scripts' => TrackingScript::active()->count(),
                'inactive_scripts' => TrackingScript::where('is_active', false)->count(),
                'scripts_by_type' => TrackingScript::selectRaw('type, COUNT(*) as count')
                    ->groupBy('type')
                    ->pluck('count', 'type')
                    ->toArray(),
                'scripts_by_position' => TrackingScript::selectRaw('position, COUNT(*) as count')
                    ->groupBy('position')
                    ->pluck('count', 'position')
                    ->toArray(),
            ];
        } catch (\Exception $e) {
            Log::error('Error fetching script statistics', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Validate all tracking scripts
     */
    public function validateAllScripts(): array
    {
        try {
            $scripts = TrackingScript::all();
            $results = [];

            foreach ($scripts as $script) {
                $validation = [
                    'script_id' => $script->id,
                    'script_name' => $script->name,
                    'script_type' => $script->type,
                    'is_valid' => true,
                    'errors' => []
                ];

                try {
                    $script->validateModel();
                } catch (\Exception $e) {
                    $validation['is_valid'] = false;
                    $validation['errors'][] = $e->getMessage();
                }

                if (!$script->validateScriptCode()) {
                    $validation['is_valid'] = false;
                    $validation['errors'][] = 'Script code validation failed for type: ' . $script->type;
                }

                $results[] = $validation;
            }

            return $results;
        } catch (\Exception $e) {
            Log::error('Error validating all scripts', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Get client-side error tracking script
     */
    public function getErrorTrackingScript(): string
    {
        return "
        <script>
            // Initialize tracking script error collection
            window.trackingScriptErrors = window.trackingScriptErrors || [];
            
            // Report errors to server (optional)
            window.reportTrackingErrors = function() {
                if (window.trackingScriptErrors.length > 0) {
                    fetch('/api/tracking-script-errors', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content')
                        },
                        body: JSON.stringify({
                            errors: window.trackingScriptErrors
                        })
                    }).catch(function(e) {
                        console.warn('Failed to report tracking script errors:', e);
                    });
                }
            };
            
            // Auto-report errors after page load
            window.addEventListener('load', function() {
                setTimeout(window.reportTrackingErrors, 1000);
            });
        </script>";
    }
}