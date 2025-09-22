<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;

class FixBlogLineBreaks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:fix-line-breaks {--dry-run : Show what would be changed without saving}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix blog posts where line breaks were removed by content cleaning';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('Searching for blog posts with potential line break issues...');
        
        // Get all blog posts
        $posts = BlogPost::all();
        
        $fixed = 0;
        
        foreach ($posts as $post) {
            $originalContent = $post->content;
            
            // Check if content has been overly cleaned (no empty paragraphs for spacing)
            if (!preg_match('/<p[^>]*>[\s&nbsp;]+<\/p>/i', $originalContent)) {
                // Check if there are multiple paragraphs without proper spacing
                if (preg_match_all('/<\/p>\s*<p/i', $originalContent, $matches) > 2) {
                    $this->line("Found post that might have spacing issues: {$post->title}");
                    
                    if (!$dryRun) {
                        // Add spacing between paragraphs if they're too close
                        $newContent = preg_replace('/<\/p>\s*<p/i', '</p>' . PHP_EOL . PHP_EOL . '<p', $originalContent);
                        
                        // Temporarily disable the cleaning in boot method
                        BlogPost::unguard();
                        $post->update(['content' => $newContent]);
                        BlogPost::reguard();
                        
                        $fixed++;
                        $this->info("  ✓ Fixed spacing in: {$post->title}");
                    } else {
                        $this->warn("  Would fix spacing in: {$post->title}");
                    }
                }
            }
        }
        
        if ($dryRun) {
            $this->info("Dry run complete. Would have fixed {$fixed} posts.");
            $this->info("Run without --dry-run to apply changes.");
        } else {
            $this->info("Fixed {$fixed} blog posts.");
        }
        
        return Command::SUCCESS;
    }
}