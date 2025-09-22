<?php

echo "\n========================================\n";
echo "BREADCRUMB SCHEMA VALIDATION\n";
echo "========================================\n\n";

$urls = [
    'http://127.0.0.1:8000/pool-resurfacing',
    'http://127.0.0.1:8000/pool-resurfacing/fiberglass-pool-resurfacing',
    'http://127.0.0.1:8000/pool-repair',
    'http://127.0.0.1:8000/pool-repair/pool-crack-repair'
];

foreach ($urls as $url) {
    echo "Testing: $url\n";
    echo str_repeat('-', 50) . "\n";
    
    $html = @file_get_contents($url);
    if (!$html) {
        echo "❌ Could not fetch URL\n\n";
        continue;
    }
    
    // Extract all JSON-LD scripts
    preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches);
    
    if (empty($matches[1])) {
        echo "❌ No JSON-LD found\n\n";
        continue;
    }
    
    $schemaTypes = [];
    $breadcrumbFound = false;
    $validJson = true;
    
    foreach ($matches[1] as $jsonString) {
        $json = json_decode(trim($jsonString), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "⚠️  Invalid JSON: " . json_last_error_msg() . "\n";
            $validJson = false;
            continue;
        }
        
        if (isset($json['@type'])) {
            $schemaTypes[] = $json['@type'];
            
            if ($json['@type'] === 'BreadcrumbList') {
                $breadcrumbFound = true;
                
                // Validate breadcrumb structure
                if (!isset($json['itemListElement']) || !is_array($json['itemListElement'])) {
                    echo "⚠️  BreadcrumbList missing itemListElement\n";
                } else {
                    $itemCount = count($json['itemListElement']);
                    echo "✅ BreadcrumbList found with $itemCount items\n";
                    
                    // Validate each breadcrumb item
                    foreach ($json['itemListElement'] as $item) {
                        if (!isset($item['@type']) || $item['@type'] !== 'ListItem') {
                            echo "   ⚠️  Invalid ListItem type\n";
                        }
                        if (!isset($item['position']) || !is_numeric($item['position'])) {
                            echo "   ⚠️  Missing or invalid position\n";
                        }
                        if (!isset($item['name']) || empty($item['name'])) {
                            echo "   ⚠️  Missing name\n";
                        }
                        if (!isset($item['item']) || empty($item['item'])) {
                            echo "   ⚠️  Missing item URL\n";
                        }
                    }
                    
                    // Display breadcrumb path
                    $breadcrumbPath = array_map(function($item) {
                        return $item['name'] ?? '?';
                    }, $json['itemListElement']);
                    echo "   Path: " . implode(' > ', $breadcrumbPath) . "\n";
                }
            }
        }
    }
    
    if ($validJson) {
        echo "✅ All JSON-LD is valid\n";
    }
    
    if ($breadcrumbFound) {
        echo "✅ Breadcrumb schema present\n";
    } else {
        echo "❌ No breadcrumb schema found\n";
    }
    
    echo "Schema types found: " . implode(', ', array_unique($schemaTypes)) . "\n";
    echo "\n";
}

echo "========================================\n";
echo "GOOGLE STRUCTURED DATA REQUIREMENTS\n";
echo "========================================\n\n";

echo "✅ BreadcrumbList Requirements:\n";
echo "   - Must have @context: 'https://schema.org'\n";
echo "   - Must have @type: 'BreadcrumbList'\n";
echo "   - Must have itemListElement array\n";
echo "   - Each item must have:\n";
echo "     • @type: 'ListItem'\n";
echo "     • position: numeric value\n";
echo "     • name: text\n";
echo "     • item: URL (except last item)\n\n";

echo "✅ Benefits of Breadcrumb Schema:\n";
echo "   - Rich snippets in search results\n";
echo "   - Better navigation for users\n";
echo "   - Improved site structure understanding\n";
echo "   - Enhanced mobile search experience\n\n";

echo "Test your schema at:\n";
echo "https://search.google.com/test/rich-results\n\n";