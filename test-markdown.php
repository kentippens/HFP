<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

$post = \App\Models\BlogPost::where('slug', 'saltwater-vs-chlorine-pools-which-is-right-for-you')->first();
if (!$post) {
    echo "Post not found\n";
    exit;
}

$html = $post->content_html;

if (strpos($html, '<table') !== false) {
    echo "✅ Tables converted successfully!\n\n";

    // Find first table
    $tablePos = strpos($html, '<table');
    echo "First table HTML:\n";
    echo substr($html, $tablePos, 500) . "\n";
} else {
    echo "❌ Still has markdown tables\n\n";

    // Find markdown table
    if (preg_match('/\|.*\|.*\|/m', $html, $matches, PREG_OFFSET_CAPTURE)) {
        $pos = $matches[0][1];
        echo "Markdown table found at position $pos:\n";
        echo substr($html, $pos, 300) . "\n";
    }
}