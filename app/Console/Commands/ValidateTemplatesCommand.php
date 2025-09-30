<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ValidateTemplatesCommand extends Command
{
    protected $signature = 'templates:validate
                            {--fix : Attempt to fix common issues}
                            {--detailed : Show detailed output}';

    protected $description = 'Validate all Blade templates for security and syntax issues';

    private $errors = [];
    private $warnings = [];
    private $info = [];
    private $stats = [
        'total_files' => 0,
        'files_with_issues' => 0,
        'unescaped_output' => 0,
        'missing_csrf' => 0,
        'inline_scripts' => 0,
        'broken_includes' => 0,
    ];

    public function handle()
    {
        $this->info('🔍 Starting template validation...');

        $viewsPath = resource_path('views');
        $templates = File::allFiles($viewsPath);

        $this->stats['total_files'] = count($templates);
        $progressBar = $this->output->createProgressBar(count($templates));

        foreach ($templates as $template) {
            if ($template->getExtension() === 'php') {
                $this->validateTemplate($template);
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->line('');
        $this->displayResults();

        return $this->stats['files_with_issues'] > 0 ? 1 : 0;
    }

    private function validateTemplate($file)
    {
        $content = File::get($file->getPathname());
        $relativePath = str_replace(resource_path('views') . '/', '', $file->getPathname());

        // Check for unescaped output (potential XSS)
        $this->checkUnescapedOutput($content, $relativePath);

        // Check for missing CSRF tokens in forms
        $this->checkCsrfProtection($content, $relativePath);

        // Check for inline scripts (security risk)
        $this->checkInlineScripts($content, $relativePath);

        // Check for broken includes/extends
        $this->checkTemplateInheritance($content, $relativePath);

        // Check for common anti-patterns
        $this->checkAntiPatterns($content, $relativePath);

        // Check for accessibility issues
        $this->checkAccessibility($content, $relativePath);

        // Check for performance issues
        $this->checkPerformance($content, $relativePath);
    }

    private function checkUnescapedOutput($content, $file)
    {
        // Check for {!! !!} usage
        if (preg_match_all('/\{!!\s*(.+?)\s*!!\}/', $content, $matches)) {
            foreach ($matches[1] as $match) {
                // Allow certain safe outputs
                $safePatterns = [
                    'json_ld', 'schema', 'csrf_field', 'method_field',
                    'app\(', 'config\(', 'asset\(', 'route\(',
                    'Vite::', 'Html::', 'Form::', '__\(', 'trans\(',
                    'old\(', 'session\(', 'svg\(', 'icon\(',
                    'HtmlHelper::safe', '\\App\\Helpers\\HtmlHelper::safe',
                    'conversion_tracking_code', 'tracking_script', 'header_script',
                    'footer_script', 'body_script', 'google_analytics', 'gtag',
                    'recaptcha', 'analytics_code', '$svg', '$iconMap', '$flaticonMap'
                ];

                $isSafe = false;
                foreach ($safePatterns as $pattern) {
                    if (Str::contains($match, $pattern)) {
                        $isSafe = true;
                        break;
                    }
                }

                // Also check if it's already HTML-escaped content from the database
                if (Str::contains($match, ['->toHtml()', 'purify(', 'clean(', 'sanitize('])) {
                    $isSafe = true;
                }

                if (!$isSafe) {
                    // Determine severity based on content
                    $severity = 'warning';
                    if (Str::contains($match, ['$service->description', '$page->content', '$silo->content'])) {
                        // These are database fields that might contain HTML
                        $this->info[] = "ℹ️  {$file}: Unescaped HTML content '{!! {$match} !!}' - ensure it's sanitized before storage";
                    } else {
                        $this->warnings[] = "⚠️  {$file}: Unescaped output '{!! {$match} !!}' - potential XSS risk";
                        $this->stats['unescaped_output']++;
                        $this->stats['files_with_issues']++;
                    }
                }
            }
        }
    }

    private function checkCsrfProtection($content, $file)
    {
        // Check forms for CSRF token
        if (preg_match('/<form[^>]*method=["\']?post["\']?[^>]*>/i', $content)) {
            if (!preg_match('/@csrf|csrf_field\(\)|csrf_token\(\)/', $content)) {
                $this->errors[] = "❌ {$file}: Form with POST method missing CSRF token";
                $this->stats['missing_csrf']++;
                $this->stats['files_with_issues']++;
            }
        }
    }

    private function checkInlineScripts($content, $file)
    {
        // Check for inline JavaScript (should be in external files)
        if (preg_match('/<script[^>]*>(?!.*src=)[^<]+<\/script>/i', $content, $matches)) {
            // Allow specific safe patterns
            if (!preg_match('/gtag\(|dataLayer|Google|Analytics|RecaptchaV3/i', $matches[0])) {
                $this->warnings[] = "⚠️  {$file}: Inline script detected - consider moving to external file";
                $this->stats['inline_scripts']++;
            }
        }

        // Check for onclick, onload, etc. handlers
        if (preg_match('/on(click|load|change|submit|error|focus|blur)=["\']/', $content)) {
            $this->warnings[] = "⚠️  {$file}: Inline event handlers detected - use addEventListener instead";
        }
    }

    private function checkTemplateInheritance($content, $file)
    {
        // Check @extends
        if (preg_match('/@extends\([\'"](.+?)[\'"]\)/', $content, $matches)) {
            $layoutFile = str_replace('.', '/', $matches[1]) . '.blade.php';
            if (!File::exists(resource_path('views/' . $layoutFile))) {
                $this->errors[] = "❌ {$file}: Missing parent template '{$matches[1]}'";
                $this->stats['broken_includes']++;
                $this->stats['files_with_issues']++;
            }
        }

        // Check @include
        if (preg_match_all('/@include(?:If|When|Unless|First)?\([\'"](.+?)[\'"]\s*(?:,|\))/', $content, $matches)) {
            foreach ($matches[1] as $include) {
                $includeFile = str_replace('.', '/', $include) . '.blade.php';
                if (!File::exists(resource_path('views/' . $includeFile))) {
                    $this->warnings[] = "⚠️  {$file}: Missing include file '{$include}'";
                    $this->stats['broken_includes']++;
                }
            }
        }

        // Check for @section without proper closing
        // Inline sections: @section('name', 'value') don't need closing
        // Block sections: @section('name') ... @endsection/@stop/@show need closing

        // Find all block-form sections (not inline)
        $blockSections = 0;
        $inlineSections = 0;

        // Match all @section directives
        if (preg_match_all('/@section\s*\([\'"]([^\'"]+)[\'"](?:\s*,\s*[^\)]+)?\)/', $content, $sectionMatches, PREG_OFFSET_CAPTURE)) {
            foreach ($sectionMatches[0] as $match) {
                $sectionText = $match[0];
                // Check if it's an inline section (has a second parameter)
                if (preg_match('/@section\s*\([\'"][^\'"]+[\'"]\s*,/', $sectionText)) {
                    $inlineSections++;
                } else {
                    $blockSections++;
                }
            }
        }

        // Count closings (@endsection, @stop, @show)
        $endSections = preg_match_all('/@(endsection|stop|show)/', $content, $endMatches);

        if ($blockSections !== $endSections) {
            $this->errors[] = "❌ {$file}: Mismatched block @section count ({$blockSections}) vs closing directives ({$endSections})";
            $this->stats['files_with_issues']++;
        }
    }

    private function checkAntiPatterns($content, $file)
    {
        // Check for PHP tags (should use Blade syntax)
        if (preg_match('/<\?php(?!.*blade)/', $content)) {
            $this->warnings[] = "⚠️  {$file}: Raw PHP tags detected - use Blade syntax instead";
        }

        // Check for hardcoded URLs
        if (preg_match('/href=["\']\/(?!\/|#)/', $content)) {
            $this->info[] = "ℹ️  {$file}: Hardcoded URL detected - consider using route() or url() helpers";
        }

        // Check for hardcoded text (should use translations)
        if (!Str::contains($file, 'test/') && preg_match('/>([A-Z][a-z]+\s){3,}/', $content)) {
            // Skip if it's likely documentation or comments
            if (!Str::contains($content, '{{--')) {
                $this->info[] = "ℹ️  {$file}: Hardcoded text detected - consider using translations";
            }
        }

        // Check for commented out code
        if (substr_count($content, '{{--') > 3) {
            $this->info[] = "ℹ️  {$file}: Multiple commented sections - consider cleaning up";
        }
    }

    private function checkAccessibility($content, $file)
    {
        // Check for missing alt attributes on images
        if (preg_match('/<img(?![^>]*alt=)[^>]*>/i', $content)) {
            $this->warnings[] = "⚠️  {$file}: Image missing alt attribute - accessibility issue";
        }

        // Check for form inputs without labels (simplified check)
        if (preg_match('/<input[^>]*type=["\'](?!hidden|submit|button)[^"\']*["\'][^>]*>/i', $content)) {
            // Check if there are labels in the file
            if (!preg_match('/<label/', $content)) {
                $this->info[] = "ℹ️  {$file}: Form inputs detected but no labels found - accessibility issue";
            }
        }

        // Check for proper heading hierarchy
        if (preg_match('/<h[1-6]/', $content)) {
            preg_match_all('/<h([1-6])/', $content, $headings);
            $lastLevel = 0;
            foreach ($headings[1] as $level) {
                if ($level > $lastLevel + 1 && $lastLevel !== 0) {
                    $this->info[] = "ℹ️  {$file}: Heading hierarchy skip detected (h{$lastLevel} to h{$level})";
                    break;
                }
                $lastLevel = $level;
            }
        }
    }

    private function checkPerformance($content, $file)
    {
        // Check for N+1 query patterns - look for relationship access in loops
        if (preg_match_all('/@foreach[^@]*@endforeach/s', $content, $loops)) {
            foreach ($loops[0] as $loop) {
                // Check for relationship access patterns that likely trigger queries
                // Look for: $item->relationship->property or $item->relationship()->method()
                // But exclude common safe methods and properties
                if (preg_match('/\$\w+->(?!get|first|last|count|isEmpty|isNotEmpty|take|skip|slug|name|id|title|description|url|route|path|link|image|icon|class|style|created_at|updated_at|deleted_at|email|phone|address)(\w+)(?:\(|->)/', $loop)) {
                    // Check if it looks like a relationship (typically another model or collection)
                    if (preg_match('/\$\w+->(author|user|category|categories|posts|comments|tags|children|parent|items|products|services|roles|permissions)(?:\(|->|\s|$)/', $loop)) {
                        $this->warnings[] = "⚠️  {$file}: Potential N+1 query in loop - consider eager loading";
                        break; // Only report once per file
                    }
                }
            }
        }

        // Check for large asset files
        if (preg_match('/\.(jpg|jpeg|png|gif)["\']/i', $content, $matches)) {
            $this->info[] = "ℹ️  {$file}: Image reference found - ensure optimized/lazy loading";
        }
    }

    private function displayResults()
    {
        $this->line('');
        $this->info('=' . str_repeat('=', 60));
        $this->info('TEMPLATE VALIDATION RESULTS');
        $this->info('=' . str_repeat('=', 60));

        // Display stats
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Templates', $this->stats['total_files']],
                ['Files with Issues', $this->stats['files_with_issues']],
                ['Unescaped Output', $this->stats['unescaped_output']],
                ['Missing CSRF', $this->stats['missing_csrf']],
                ['Inline Scripts', $this->stats['inline_scripts']],
                ['Broken Includes', $this->stats['broken_includes']],
            ]
        );

        // Display errors
        if (count($this->errors) > 0) {
            $this->line('');
            $this->error('ERRORS (' . count($this->errors) . ')');
            foreach ($this->errors as $error) {
                $this->line($error);
            }
        }

        // Display warnings
        if (count($this->warnings) > 0) {
            $this->line('');
            $this->warn('WARNINGS (' . count($this->warnings) . ')');
            foreach ($this->warnings as $warning) {
                $this->line($warning);
            }
        }

        // Display info (detailed mode)
        if ($this->option('detailed') && count($this->info) > 0) {
            $this->line('');
            $this->info('INFORMATION (' . count($this->info) . ')');
            foreach ($this->info as $info) {
                $this->line($info);
            }
        }

        // Summary
        $this->line('');
        if ($this->stats['files_with_issues'] === 0) {
            $this->info('✅ All templates passed validation!');
        } else {
            $severity = $this->stats['missing_csrf'] > 0 ? 'error' : 'warn';
            $this->$severity('⚠️  ' . $this->stats['files_with_issues'] . ' template(s) have issues that need attention');
        }
    }
}