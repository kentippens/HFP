<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;

class CleanBlogContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:clean-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean attachment metadata from existing blog post content';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Cleaning blog post content...');
        
        $posts = BlogPost::whereNotNull('content')->get();
        $cleaned = 0;
        
        foreach ($posts as $post) {
            $originalContent = $post->content;
            $cleanedContent = BlogPost::cleanTrixContent($originalContent);
            
            if ($originalContent !== $cleanedContent) {
                // Disable the saving event temporarily to avoid re-cleaning
                BlogPost::unguard();
                $post->timestamps = false;
                $post->update(['content' => $cleanedContent]);
                $post->timestamps = true;
                BlogPost::reguard();
                
                $cleaned++;
                $this->line("Cleaned: {$post->title}");
            }
        }
        
        $this->info("Cleaned {$cleaned} blog posts.");
        
        return Command::SUCCESS;
    }
}