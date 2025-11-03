<?php
/**
 * Breadcrumb Navigation
 * Generate breadcrumb trails
 */

/**
 * Generate Breadcrumb HTML
 */
function generate_breadcrumb($category = null, $page_title = null) {
    $breadcrumbs = [
        ['name' => 'Home', 'url' => '/']
    ];
    
    if ($category) {
        $breadcrumbs[] = [
            'name' => ucwords(str_replace('-', ' ', $category)),
            'url' => "/calculators/{$category}"
        ];
    }
    
    if ($page_title) {
        $breadcrumbs[] = [
            'name' => $page_title,
            'url' => null
        ];
    }
    
    ob_start();
    ?>
    <nav class="breadcrumb" aria-label="Breadcrumb">
        <?php foreach ($breadcrumbs as $index => $item): ?>
            <?php if ($item['url']): ?>
                <a href="<?php echo htmlspecialchars($item['url']); ?>" class="breadcrumb-item">
                    <?php echo htmlspecialchars($item['name']); ?>
                </a>
            <?php else: ?>
                <span class="breadcrumb-item active" aria-current="page">
                    <?php echo htmlspecialchars($item['name']); ?>
                </span>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
    
    <?php
    // Generate schema markup
    $schema = generate_breadcrumb_schema($breadcrumbs);
    ?>
    <script type="application/ld+json">
    <?php echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
    </script>
    <?php
    
    return ob_get_clean();
}
?>