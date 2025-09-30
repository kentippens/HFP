<?php

namespace App\Services;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;

class MarkdownService
{
    protected CommonMarkConverter $converter;

    public function __construct()
    {
        // Configure CommonMark with GitHub Flavored Markdown for table support
        $environment = new Environment();

        // Add extensions for better markdown support
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        // Configure the converter
        $config = [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 10,
            'table' => [
                'wrap' => [
                    'enabled' => true,
                    'tag' => 'div',
                    'attributes' => ['class' => 'table-responsive'],
                ],
            ],
        ];

        $this->converter = new CommonMarkConverter($config, $environment);
    }

    /**
     * Convert markdown to HTML
     */
    public function toHtml(string $content): string
    {
        if (empty($content)) {
            return '';
        }

        // Check if content has markdown tables that need conversion
        if ($this->hasMarkdownTables($content)) {
            // If content is mixed (HTML with markdown tables), convert the tables
            return $this->convertMarkdownTables($content);
        }

        // If it's pure HTML, return as-is
        if ($this->isPureHtml($content)) {
            return $content;
        }

        // Otherwise, convert all markdown to HTML
        return $this->converter->convert($content)->getContent();
    }

    /**
     * Check if content has markdown tables
     */
    protected function hasMarkdownTables(string $content): bool
    {
        // Look for markdown table syntax: | header | header |
        return preg_match('/^\|.*\|.*\|/m', $content) === 1;
    }

    /**
     * Convert only markdown tables in mixed HTML/Markdown content
     */
    protected function convertMarkdownTables(string $content): string
    {
        // Find and replace markdown tables with HTML tables
        $pattern = '/^(\|.+\|[\r\n]+)+/m';

        return preg_replace_callback($pattern, function($matches) {
            $table = $matches[0];

            // Convert the markdown table to HTML
            $html = $this->converter->convert($table)->getContent();

            // Wrap in responsive div
            return '<div class="table-responsive">' . $html . '</div>';
        }, $content);
    }

    /**
     * Check if content is pure HTML without markdown
     */
    protected function isPureHtml(string $content): bool
    {
        // If it has proper HTML table tags and no markdown tables
        if (preg_match('/<table[^>]*>.*<\/table>/is', $content)) {
            return !$this->hasMarkdownTables($content);
        }

        // Check for HTML structure without any markdown syntax
        $hasHtml = preg_match('/<(p|div|h[1-6]|ul|ol|li|br|strong|em|a)\b[^>]*>/i', $content) === 1;
        $hasMarkdown = preg_match('/^\|.*\|/m', $content) || preg_match('/^#+\s/m', $content) || preg_match('/^\*\s/m', $content);

        return $hasHtml && !$hasMarkdown;
    }

    /**
     * Convert markdown to HTML with sanitization
     */
    public function toSafeHtml(string $markdown, string $purifierConfig = 'default'): \Illuminate\Support\HtmlString
    {
        $html = $this->toHtml($markdown);
        return \App\Helpers\HtmlHelper::safe($html, $purifierConfig);
    }
}