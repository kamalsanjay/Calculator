<?php
/**
 * Dynamic Meta Tags Generator
 * SEO optimization functions
 */

/**
 * Generate Meta Tags for Calculator Pages
 */
function generate_calculator_meta($calculator_name, $category, $description) {
    return [
        'title' => "{$calculator_name} - Free Online Calculator",
        'description' => $description,
        'keywords' => "{$calculator_name}, {$category} calculator, online calculator, free calculator",
        'og_type' => 'website',
        'twitter_card' => 'summary_large_image'
    ];
}

/**
 * Generate Schema.org Markup for Calculator
 */
function generate_calculator_schema($calculator_name, $description, $url) {
    return [
        "@context" => "https://schema.org",
        "@type" => "SoftwareApplication",
        "name" => $calculator_name,
        "applicationCategory" => "UtilityApplication",
        "operatingSystem" => "Web Browser",
        "description" => $description,
        "url" => $url,
        "offers" => [
            "@type" => "Offer",
            "price" => "0",
            "priceCurrency" => "USD"
        ],
        "aggregateRating" => [
            "@type" => "AggregateRating",
            "ratingValue" => "4.8",
            "ratingCount" => "1250"
        ]
    ];
}

/**
 * Generate Breadcrumb Schema
 */
function generate_breadcrumb_schema($items) {
    $itemListElement = [];
    
    foreach ($items as $index => $item) {
        $itemListElement[] = [
            "@type" => "ListItem",
            "position" => $index + 1,
            "name" => $item['name'],
            "item" => $item['url']
        ];
    }
    
    return [
        "@context" => "https://schema.org",
        "@type" => "BreadcrumbList",
        "itemListElement" => $itemListElement
    ];
}

/**
 * Generate FAQ Schema
 */
function generate_faq_schema($faqs) {
    $mainEntity = [];
    
    foreach ($faqs as $faq) {
        $mainEntity[] = [
            "@type" => "Question",
            "name" => $faq['question'],
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => $faq['answer']
            ]
        ];
    }
    
    return [
        "@context" => "https://schema.org",
        "@type" => "FAQPage",
        "mainEntity" => $mainEntity
    ];
}

/**
 * Generate How-To Schema
 */
function generate_howto_schema($name, $description, $steps) {
    $stepElements = [];
    
    foreach ($steps as $index => $step) {
        $stepElements[] = [
            "@type" => "HowToStep",
            "position" => $index + 1,
            "name" => $step['name'],
            "text" => $step['text']
        ];
    }
    
    return [
        "@context" => "https://schema.org",
        "@type" => "HowTo",
        "name" => $name,
        "description" => $description,
        "step" => $stepElements
    ];
}
?>