<?php

// This script updates all remaining contact forms with reCAPTCHA

$formsToUpdate = [
    [
        'file' => 'resources/views/services/show.blade.php',
        'formId' => 'service-contact-form',
        'searchForm' => '<form action="{{ route(\'contact.store\') }}" method="POST">',
        'replaceForm' => '<form action="{{ route(\'contact.store\') }}" method="POST" id="service-contact-form">',
        'searchButton' => '<button type="submit" class="bixol-primary-btn">Get A Quote<span>@icon("fa-paper-plane")</span></button>',
        'replaceButton' => '@include(\'components.recaptcha-button\', [
                                    \'formId\' => \'service-contact-form\',
                                    \'buttonText\' => \'Get A Quote\',
                                    \'buttonClass\' => \'bixol-primary-btn\',
                                    \'buttonIcon\' => \'fa-paper-plane\'
                                ])'
    ],
    [
        'file' => 'resources/views/components/hero-slider.blade.php',
        'formId' => 'hero-slider-form',
        'searchForm' => '<form action="{{ route(\'contact.store\') }}" method="POST">',
        'replaceForm' => '<form action="{{ route(\'contact.store\') }}" method="POST" id="hero-slider-form">',
        'searchButton' => '<button type="submit" class="bixol-primary-btn">Get A Quote<span>@icon("fa-paper-plane")</span></button>',
        'replaceButton' => '@include(\'components.recaptcha-button\', [
                        \'formId\' => \'hero-slider-form\',
                        \'buttonText\' => \'Get A Quote\',
                        \'buttonClass\' => \'bixol-primary-btn\',
                        \'buttonIcon\' => \'fa-paper-plane\'
                    ])'
    ],
    [
        'file' => 'resources/views/about.blade.php',
        'formId' => 'about-contact-form',
        'searchForm' => '<form action="{{ route(\'contact.store\') }}" method="POST">',
        'replaceForm' => '<form action="{{ route(\'contact.store\') }}" method="POST" id="about-contact-form">',
        'searchButton' => '<button type="submit" class="bixol-primary-btn">Send Message<span>@icon("fa-paper-plane")</span></button>',
        'replaceButton' => '@include(\'components.recaptcha-button\', [
                                \'formId\' => \'about-contact-form\',
                                \'buttonText\' => \'Send Message\',
                                \'buttonClass\' => \'bixol-primary-btn\',
                                \'buttonIcon\' => \'fa-paper-plane\'
                            ])'
    ],
    [
        'file' => 'resources/views/contact/index.blade.php',
        'formId' => 'main-contact-form',
        'searchForm' => '<form action="{{ route(\'contact.store\') }}" method="POST">',
        'replaceForm' => '<form action="{{ route(\'contact.store\') }}" method="POST" id="main-contact-form">',
        'searchButton' => '<button type="submit" class="bixol-primary-btn">Send Message<span>@icon("fa-paper-plane")</span></button>',
        'replaceButton' => '@include(\'components.recaptcha-button\', [
                                \'formId\' => \'main-contact-form\',
                                \'buttonText\' => \'Send Message\',
                                \'buttonClass\' => \'bixol-primary-btn\',
                                \'buttonIcon\' => \'fa-paper-plane\'
                            ])'
    ],
    [
        'file' => 'resources/views/services/partials/contact-form.blade.php',
        'formId' => 'partial-contact-form',
        'searchForm' => '<form action="{{ route(\'contact.store\') }}" method="POST">',
        'replaceForm' => '<form action="{{ route(\'contact.store\') }}" method="POST" id="partial-contact-form">',
        'searchButton' => '<button type="submit" class="bixol-primary-btn">Get A Quote<span>@icon("fa-paper-plane")</span></button>',
        'replaceButton' => '@include(\'components.recaptcha-button\', [
                                \'formId\' => \'partial-contact-form\',
                                \'buttonText\' => \'Get A Quote\',
                                \'buttonClass\' => \'bixol-primary-btn\',
                                \'buttonIcon\' => \'fa-paper-plane\'
                            ])'
    ],
];

foreach ($formsToUpdate as $form) {
    echo "Processing: {$form['file']}\n";

    $filePath = __DIR__ . '/' . $form['file'];

    if (!file_exists($filePath)) {
        echo "  - File not found, skipping.\n";
        continue;
    }

    $content = file_get_contents($filePath);

    // Add form ID
    if (strpos($content, $form['searchForm']) !== false) {
        $content = str_replace($form['searchForm'], $form['replaceForm'], $content);
        echo "  - Added form ID: {$form['formId']}\n";
    } else {
        echo "  - Form tag not found or already has ID\n";
    }

    // Replace submit button with reCAPTCHA button
    if (strpos($content, $form['searchButton']) !== false) {
        $content = str_replace($form['searchButton'], $form['replaceButton'], $content);
        echo "  - Replaced submit button with reCAPTCHA button\n";
    } else {
        echo "  - Submit button not found or already replaced\n";
    }

    file_put_contents($filePath, $content);
    echo "  - File updated successfully\n\n";
}

echo "All forms have been updated with reCAPTCHA!\n";
echo "\nREMINDER: Don't forget to add your actual reCAPTCHA keys to the .env file:\n";
echo "RECAPTCHA_SITE_KEY=your_site_key_here\n";
echo "RECAPTCHA_SECRET_KEY=your_secret_key_here\n";