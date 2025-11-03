<?php
/**
 * Sidebar Template
 * Right sidebar with widgets
 */

// Get popular calculators
try {
    $db = Database::getInstance();
    $popular_calculators = $db->fetchAll("
        SELECT c.id, c.name, c.slug, c.category, COUNT(cu.id) as usage_count
        FROM calculators c
        LEFT JOIN calculator_usage cu ON c.id = cu.calculator_id
        WHERE c.is_active = 1
        AND cu.created_at > DATE_SUB(NOW(), INTERVAL 30 DAY)
        GROUP BY c.id
        ORDER BY usage_count DESC
        LIMIT 10
    ");
} catch (Exception $e) {
    $popular_calculators = [];
}

// Get related calculators if category is set
$related_calculators = [];
if (isset($calculator_category)) {
    try {
        $related_calculators = $db->fetchAll("
            SELECT id, name, slug, category
            FROM calculators
            WHERE category = ?
            AND is_active = 1
            AND id != ?
            ORDER BY page_views DESC
            LIMIT 8
        ", [$calculator_category, $calculator_id ?? 0]);
    } catch (Exception $e) {
        $related_calculators = [];
    }
}
?>

<!-- Sidebar -->
<aside class="sidebar">
    <!-- Ad Space 1 -->
    <div class="sidebar-widget ad-widget">
        <div class="ad-container" data-ad-slot="sidebar-1">
            <!-- 300x600 Ad -->
            <div style="width: 300px; height: 600px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc;">
                <span style="color: #999;">Ad Space 300x600</span>
            </div>
        </div>
    </div>
    
    <?php if (!empty($related_calculators)): ?>
    <!-- Related Calculators -->
    <div class="sidebar-widget">
        <h3 class="widget-title">Related Calculators</h3>
        <ul class="related-list">
            <?php foreach ($related_calculators as $calc): ?>
            <li>
                <a href="/calculators/<?php echo htmlspecialchars($calc['category']); ?>/<?php echo htmlspecialchars($calc['slug']); ?>">
                    <i class="fas fa-calculator"></i>
                    <span><?php echo htmlspecialchars($calc['name']); ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($popular_calculators)): ?>
    <!-- Popular Calculators -->
    <div class="sidebar-widget">
        <h3 class="widget-title">Popular Calculators</h3>
        <ul class="popular-list">
            <?php foreach ($popular_calculators as $index => $calc): ?>
            <li class="popular-item">
                <span class="popular-rank"><?php echo $index + 1; ?></span>
                <a href="/calculators/<?php echo htmlspecialchars($calc['category']); ?>/<?php echo htmlspecialchars($calc['slug']); ?>">
                    <?php echo htmlspecialchars($calc['name']); ?>
                </a>
                <span class="popular-count"><?php echo number_format($calc['usage_count']); ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    
    <!-- Calculator Categories -->
    <div class="sidebar-widget">
        <h3 class="widget-title">Categories</h3>
        <ul class="category-list">
            <li><a href="/calculators/financial"><i class="fas fa-dollar-sign"></i> Financial</a></li>
            <li><a href="/calculators/health"><i class="fas fa-heartbeat"></i> Health & Fitness</a></li>
            <li><a href="/calculators/math"><i class="fas fa-calculator"></i> Math</a></li>
            <li><a href="/calculators/conversion"><i class="fas fa-exchange-alt"></i> Conversion</a></li>
            <li><a href="/calculators/date-time"><i class="fas fa-calendar"></i> Date & Time</a></li>
        </ul>
        <a href="/categories" class="view-all-link">View All Categories →</a>
    </div>
    
    <!-- Ad Space 2 -->
    <div class="sidebar-widget ad-widget">
        <div class="ad-container" data-ad-slot="sidebar-2">
            <!-- 300x250 Ad -->
            <div style="width: 300px; height: 250px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc;">
                <span style="color: #999;">Ad Space 300x250</span>
            </div>
        </div>
    </div>
    
    <!-- Quick Links -->
    <div class="sidebar-widget">
        <h3 class="widget-title">Quick Links</h3>
        <ul class="quick-links">
            <li><a href="/about"><i class="fas fa-info-circle"></i> About Us</a></li>
            <li><a href="/contact"><i class="fas fa-envelope"></i> Contact</a></li>
            <li><a href="/privacy-policy"><i class="fas fa-shield-alt"></i> Privacy Policy</a></li>
            <li><a href="/terms-of-service"><i class="fas fa-file-contract"></i> Terms of Service</a></li>
        </ul>
    </div>
</aside>

<style>
.sidebar {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-xl);
}

.sidebar-widget {
    background: white;
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    box-shadow: var(--shadow-sm);
}

.widget-title {
    margin: 0 0 var(--spacing-lg) 0;
    font-size: 1.25rem;
    color: var(--dark-color);
    padding-bottom: var(--spacing-md);
    border-bottom: 2px solid var(--light-color);
}

.related-list,
.popular-list,
.category-list,
.quick-links {
    list-style: none;
}

.related-list li,
.category-list li,
.quick-links li {
    margin-bottom: var(--spacing-md);
}

.related-list a,
.category-list a,
.quick-links a {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-sm);
    color: var(--dark-color);
    text-decoration: none;
    border-radius: var(--radius-sm);
    transition: all var(--transition-normal);
}

.related-list a:hover,
.category-list a:hover,
.quick-links a:hover {
    background: var(--light-color);
    color: var(--primary-color);
    transform: translateX(5px);
}

.popular-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-sm);
    margin-bottom: var(--spacing-sm);
    background: var(--light-color);
    border-radius: var(--radius-sm);
}

.popular-rank {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    font-size: 0.75rem;
    font-weight: 600;
}

.popular-item a {
    flex: 1;
    color: var(--dark-color);
    text-decoration: none;
}

.popular-item a:hover {
    color: var(--primary-color);
}

.popular-count {
    color: var(--secondary-color);
    font-size: 0.875rem;
}

.view-all-link {
    display: block;
    margin-top: var(--spacing-md);
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.view-all-link:hover {
    text-decoration: underline;
}

.ad-widget {
    padding: 0;
    overflow: hidden;
}

.ad-container {
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 1024px) {
    .sidebar {
        margin-top: var(--spacing-2xl);
    }
}
</style>