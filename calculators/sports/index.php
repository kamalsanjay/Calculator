<?php
/**
 * Sports Calculators - Category Page
 * Overview of all sports calculators
 */

require_once '../../config.php';
require_once '../../includes/functions.php';

$page_title = "Sports Calculators - Free Online Sports Tools";
$page_description = "Free sports calculators for athletes. Calculate swim pace, marathon time, bike cadence, golf handicap, and more. Professional tools for training and performance.";
$page_keywords = "sports calculator, pace calculator, marathon calculator, golf handicap, training zones";
$calculator_category = "sports";

// Get all sports calculators
try {
    $db = Database::getInstance();
    $calculators = $db->fetchAll("
        SELECT id, name, slug, description, page_views
        FROM calculators
        WHERE category = 'sports'
        AND is_active = 1
        ORDER BY display_order ASC, name ASC
    ");
} catch (Exception $e) {
    $calculators = [];
}

require_once '../../includes/header.php';
?>

<div class="category-page">
    <div class="container">
        <!-- Category Header -->
        <div class="category-header">
            <div class="category-icon">
                <i class="fas fa-football-ball"></i>
            </div>
            <h1>Sports Calculators</h1>
            <p>Professional sports and training calculators for athletes of all levels. Calculate pace, predict race times, determine training zones, and track your athletic performance.</p>
        </div>

        <!-- Calculator Grid -->
        <div class="calculator-grid">
            <?php foreach ($calculators as $calc): ?>
            <a href="/calculators/sports/<?php echo htmlspecialchars($calc['slug']); ?>" class="calculator-card">
                <div class="calculator-card-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3><?php echo htmlspecialchars($calc['name']); ?></h3>
                <p><?php echo htmlspecialchars($calc['description']); ?></p>
                <div class="calculator-card-footer">
                    <span class="views">
                        <i class="fas fa-eye"></i>
                        <?php echo number_format($calc['page_views']); ?> views
                    </span>
                    <span class="arrow">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Category Info -->
        <div class="category-info">
            <div class="info-card">
                <h2>Why Use Sports Calculators?</h2>
                <ul>
                    <li><strong>Training Optimization:</strong> Calculate ideal training zones and paces</li>
                    <li><strong>Performance Tracking:</strong> Monitor progress and set realistic goals</li>
                    <li><strong>Race Planning:</strong> Predict finish times and plan strategies</li>
                    <li><strong>Technique Analysis:</strong> Improve form and efficiency</li>
                    <li><strong>Goal Setting:</strong> Set achievable targets based on current performance</li>
                </ul>
            </div>

            <div class="info-card">
                <h2>Popular Sports Calculations</h2>
                <ul>
                    <li>Swimming pace per 100m/yards</li>
                    <li>Marathon and race time predictions</li>
                    <li>Cycling cadence and power zones</li>
                    <li>Golf handicap calculations</li>
                    <li>Heart rate training zones</li>
                    <li>Vertical jump measurements</li>
                    <li>Baseball batting statistics</li>
                </ul>
            </div>
        </div>

        <!-- Related Categories -->
        <div class="related-categories">
            <h2>Related Categories</h2>
            <div class="category-links">
                <a href="/calculators/health" class="category-link">
                    <i class="fas fa-heartbeat"></i>
                    <span>Health & Fitness</span>
                </a>
                <a href="/calculators/conversion" class="category-link">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Conversion Tools</span>
                </a>
                <a href="/calculators/date-time" class="category-link">
                    <i class="fas fa-calendar"></i>
                    <span>Date & Time</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.category-page {
    padding: var(--spacing-3xl) 0;
}

.category-header {
    text-align: center;
    margin-bottom: var(--spacing-3xl);
    padding: var(--spacing-3xl);
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border-radius: var(--radius-xl);
}

.category-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--spacing-lg);
    font-size: 2.5rem;
}

.category-header h1 {
    color: white;
    margin-bottom: var(--spacing-md);
}

.calculator-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: var(--spacing-xl);
    margin-bottom: var(--spacing-3xl);
}

.calculator-card {
    background: white;
    padding: var(--spacing-xl);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    text-decoration: none;
    color: var(--dark-color);
    transition: all var(--transition-normal);
    display: flex;
    flex-direction: column;
}

.calculator-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.calculator-card-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-bottom: var(--spacing-lg);
}

.calculator-card h3 {
    margin-bottom: var(--spacing-md);
    color: var(--dark-color);
}

.calculator-card p {
    color: var(--secondary-color);
    flex: 1;
    margin-bottom: var(--spacing-md);
}

.calculator-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: var(--spacing-md);
    border-top: 1px solid var(--light-color);
    font-size: 0.875rem;
    color: var(--secondary-color);
}

.category-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: var(--spacing-xl);
    margin-bottom: var(--spacing-3xl);
}

.info-card {
    background: white;
    padding: var(--spacing-2xl);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.info-card h2 {
    color: var(--primary-color);
    margin-bottom: var(--spacing-lg);
}

.info-card ul {
    list-style: none;
    padding: 0;
}

.info-card li {
    padding: var(--spacing-sm) 0;
    padding-left: var(--spacing-xl);
    position: relative;
}

.info-card li:before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #28a745;
    font-weight: bold;
}

.related-categories {
    background: white;
    padding: var(--spacing-2xl);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.related-categories h2 {
    margin-bottom: var(--spacing-lg);
}

.category-links {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--spacing-md);
}

.category-link {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    padding: var(--spacing-md);
    background: var(--light-color);
    border-radius: var(--radius-md);
    text-decoration: none;
    color: var(--dark-color);
    transition: all var(--transition-normal);
}

.category-link:hover {
    background: #28a745;
    color: white;
    transform: translateX(5px);
}

.category-link i {
    font-size: 1.5rem;
}

@media (max-width: 768px) {
    .calculator-grid {
        grid-template-columns: 1fr;
    }
    
    .category-info {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once '../../includes/footer.php'; ?>