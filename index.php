<?php
/**
 * Homepage - Calculator Hub
 * 
 * Main landing page featuring:
 * - Hero section with search
 * - 14 category grid
 * - Popular calculators
 * - Features section
 * - Recent calculations
 * 
 * @package CalculatorWebsite
 * @version 1.0.0
 */

// Start session
session_start();

// Include configuration
require_once 'config/config.php';
require_once 'config/database.php';

// Include core functions
require_once 'includes/functions.php';
require_once 'includes/meta.php';
require_once 'includes/ads.php';

// Set page metadata
$page_meta = [
    'title' => 'Free Online Calculators - 300+ Tools for Every Need',
    'description' => 'Access 300+ free online calculators across 14 categories including math, finance, health, conversion tools, and more. Fast, accurate, and easy-to-use calculation tools.',
    'keywords' => 'online calculator, free calculator, math calculator, financial calculator, conversion tool, calculator hub',
    'type' => 'website'
];

// Hide breadcrumb on homepage
$hide_breadcrumb = true;

// Include header
include 'includes/header.php';
?>

<style>
/* ============================================
   HOMEPAGE STYLES
   ============================================ */

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 20px;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.1;
}

.hero-content {
    max-width: 900px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 20px;
    line-height: 1.2;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 40px;
    opacity: 0.95;
    line-height: 1.6;
}

.hero-search {
    max-width: 700px;
    margin: 0 auto 30px;
}

.hero-search-form {
    position: relative;
}

.hero-search-input {
    width: 100%;
    padding: 20px 60px 20px 25px;
    border: none;
    border-radius: 50px;
    font-size: 1.1rem;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.hero-search-button {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: #007bff;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.hero-search-button:hover {
    background: #0056b3;
    transform: translateY(-50%) scale(1.05);
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.hero-stat {
    text-align: center;
}

.hero-stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    display: block;
}

.hero-stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

/* Category Grid Section */
.categories-section {
    padding: 80px 20px;
    background: var(--bg-secondary);
}

.section-header {
    text-align: center;
    margin-bottom: 50px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 15px;
}

.section-subtitle {
    font-size: 1.1rem;
    color: var(--text-secondary);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    max-width: 1400px;
    margin: 0 auto;
}

.category-card {
    background: var(--bg-primary);
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    transition: all 0.3s ease;
    border: 2px solid var(--border-color);
    cursor: pointer;
    text-decoration: none;
    color: var(--text-primary);
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-color: var(--primary-color);
}

.category-icon {
    font-size: 3rem;
    margin-bottom: 15px;
    display: block;
}

.category-name {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.category-count {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.category-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-top: 10px;
}

/* Popular Calculators Section */
.popular-section {
    padding: 80px 20px;
    background: var(--bg-primary);
}

.calculators-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    max-width: 1400px;
    margin: 0 auto;
}

.calculator-card {
    background: var(--bg-primary);
    padding: 25px;
    border-radius: 12px;
    border: 2px solid var(--border-color);
    transition: all 0.3s ease;
    text-decoration: none;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 20px;
}

.calculator-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: var(--primary-color);
}

.calculator-icon-box {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    flex-shrink: 0;
}

.calculator-details h3 {
    font-size: 1.1rem;
    margin-bottom: 5px;
    font-weight: 600;
}

.calculator-meta {
    display: flex;
    gap: 15px;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.calculator-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Features Section */
.features-section {
    padding: 80px 20px;
    background: var(--bg-secondary);
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.feature-card {
    background: var(--bg-primary);
    padding: 35px;
    border-radius: 12px;
    text-align: center;
    border: 2px solid var(--border-color);
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.feature-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: white;
}

.feature-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 12px;
    color: var(--text-primary);
}

.feature-description {
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Recent Calculations Section */
.recent-section {
    padding: 80px 20px;
    background: var(--bg-primary);
}

.recent-list {
    max-width: 800px;
    margin: 0 auto;
}

.recent-calculation {
    background: var(--bg-primary);
    border: 2px solid var(--border-color);
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.recent-calculation:hover {
    border-color: var(--primary-color);
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.recent-calc-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.recent-calc-icon {
    width: 50px;
    height: 50px;
    background: var(--bg-secondary);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.recent-calc-details h4 {
    font-size: 1rem;
    margin-bottom: 5px;
}

.recent-calc-time {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--text-secondary);
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.3;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 60px 20px;
    text-align: center;
    color: white;
    margin: 40px 0;
}

.cta-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 30px;
}

.btn {
    padding: 15px 35px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-primary {
    background: white;
    color: #667eea;
}

.btn-primary:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 20px rgba(255,255,255,0.3);
}

.btn-outline {
    background: transparent;
    border: 2px solid white;
    color: white;
}

.btn-outline:hover {
    background: white;
    color: #667eea;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .hero-stats {
        gap: 20px;
    }
    
    .hero-stat-number {
        font-size: 1.8rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .calculators-grid {
        grid-template-columns: 1fr;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
}

/* Animation Classes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content fade-in-up">
        <h1 class="hero-title">Calculator Hub - 300+ Free Online Calculators</h1>
        <p class="hero-subtitle">
            Fast, accurate, and easy-to-use calculators for math, finance, health, conversions, and more. 
            All tools are 100% free with no registration required.
        </p>
        
        <div class="hero-search">
            <form action="/search.php" method="GET" class="hero-search-form">
                <input 
                    type="search" 
                    name="q" 
                    class="hero-search-input" 
                    placeholder="Search for any calculator... (e.g., BMI, Loan, Temperature)" 
                    required
                    aria-label="Search calculators"
                >
                <button type="submit" class="hero-search-button">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
        
        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-number">300+</span>
                <span class="hero-stat-label">Calculators</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-number">14</span>
                <span class="hero-stat-label">Categories</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-number">1M+</span>
                <span class="hero-stat-label">Monthly Users</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-number">100%</span>
                <span class="hero-stat-label">Free</span>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Browse by Category</h2>
            <p class="section-subtitle">Explore our comprehensive collection of calculators organized into 14 categories</p>
        </div>
        
        <div class="categories-grid">
            <?php
            $categories = [
                [
                    'name' => 'Math Calculators',
                    'icon' => '🔢',
                    'count' => '25+',
                    'slug' => 'math',
                    'description' => 'Basic, scientific, and advanced math tools'
                ],
                [
                    'name' => 'Financial Calculators',
                    'icon' => '💰',
                    'count' => '30+',
                    'slug' => 'finance',
                    'description' => 'Loans, investments, taxes, and budgeting'
                ],
                [
                    'name' => 'Health & Fitness',
                    'icon' => '🏥',
                    'count' => '20+',
                    'slug' => 'health',
                    'description' => 'BMI, calories, pregnancy, and wellness'
                ],
                [
                    'name' => 'Conversion Tools',
                    'icon' => '🔄',
                    'count' => '40+',
                    'slug' => 'conversion',
                    'description' => 'Units, currency, temperature, and more'
                ],
                [
                    'name' => 'Date & Time',
                    'icon' => '📅',
                    'count' => '15+',
                    'slug' => 'date',
                    'description' => 'Age, duration, and date calculations'
                ],
                [
                    'name' => 'Construction',
                    'icon' => '🏗️',
                    'count' => '18+',
                    'slug' => 'construction',
                    'description' => 'Building materials and measurements'
                ],
                [
                    'name' => 'Statistics',
                    'icon' => '📊',
                    'count' => '22+',
                    'slug' => 'statistics',
                    'description' => 'Statistical analysis and probability'
                ],
                [
                    'name' => 'Automotive',
                    'icon' => '🚗',
                    'count' => '12+',
                    'slug' => 'automotive',
                    'description' => 'Fuel, MPG, and vehicle calculations'
                ],
                [
                    'name' => 'Education',
                    'icon' => '🎓',
                    'count' => '16+',
                    'slug' => 'education',
                    'description' => 'GPA, grades, and academic tools'
                ],
                [
                    'name' => 'Science',
                    'icon' => '🔬',
                    'count' => '24+',
                    'slug' => 'science',
                    'description' => 'Physics, chemistry, and biology'
                ],
                [
                    'name' => 'Cooking',
                    'icon' => '🍳',
                    'count' => '14+',
                    'slug' => 'cooking',
                    'description' => 'Recipe conversion and nutrition'
                ],
                [
                    'name' => 'Engineering',
                    'icon' => '⚡',
                    'count' => '20+',
                    'slug' => 'engineering',
                    'description' => 'Electrical, mechanical, and civil'
                ],
                [
                    'name' => 'Business',
                    'icon' => '💼',
                    'count' => '18+',
                    'slug' => 'business',
                    'description' => 'ROI, profit margins, and analytics'
                ],
                [
                    'name' => 'Other Tools',
                    'icon' => '🛠️',
                    'count' => '26+',
                    'slug' => 'other',
                    'description' => 'Miscellaneous helpful tools'
                ]
            ];
            
            foreach ($categories as $category):
            ?>
            <a href="/category/<?php echo $category['slug']; ?>" class="category-card">
                <span class="category-icon"><?php echo $category['icon']; ?></span>
                <h3 class="category-name"><?php echo htmlspecialchars($category['name']); ?></h3>
                <div class="category-count"><?php echo $category['count']; ?> calculators</div>
                <p class="category-description"><?php echo htmlspecialchars($category['description']); ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Horizontal Ad #1 -->
<div class="container">
    <?php display_horizontal_ad(1, 'my-5'); ?>
</div>

<!-- Popular Calculators Section -->
<section class="popular-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Most Popular Calculators</h2>
            <p class="section-subtitle">Quick access to our most frequently used tools</p>
        </div>
        
        <div class="calculators-grid">
            <?php
            // Get popular calculators from database
            $popular_calculators = get_popular_calculators(10);
            
            // Fallback data if database is empty
            if (empty($popular_calculators)) {
                $popular_calculators = [
                    ['name' => 'BMI Calculator', 'slug' => 'bmi', 'icon' => 'fa-weight', 'category' => 'Health', 'uses' => 125000],
                    ['name' => 'Loan Calculator', 'slug' => 'loan', 'icon' => 'fa-money-bill-wave', 'category' => 'Finance', 'uses' => 98000],
                    ['name' => 'Percentage Calculator', 'slug' => 'percentage', 'icon' => 'fa-percent', 'category' => 'Math', 'uses' => 87000],
                    ['name' => 'Age Calculator', 'slug' => 'age', 'icon' => 'fa-birthday-cake', 'category' => 'Date & Time', 'uses' => 76000],
                    ['name' => 'Currency Converter', 'slug' => 'currency', 'icon' => 'fa-coins', 'category' => 'Conversion', 'uses' => 71000],
                    ['name' => 'Calorie Calculator', 'slug' => 'calorie', 'icon' => 'fa-fire', 'category' => 'Health', 'uses' => 68000],
                    ['name' => 'Mortgage Calculator', 'slug' => 'mortgage', 'icon' => 'fa-home', 'category' => 'Finance', 'uses' => 59000],
                    ['name' => 'GPA Calculator', 'slug' => 'gpa', 'icon' => 'fa-graduation-cap', 'category' => 'Education', 'uses' => 52000],
                    ['name' => 'Temperature Converter', 'slug' => 'temperature', 'icon' => 'fa-thermometer-half', 'category' => 'Conversion', 'uses' => 48000],
                    ['name' => 'Tax Calculator', 'slug' => 'tax', 'icon' => 'fa-file-invoice-dollar', 'category' => 'Finance', 'uses' => 45000]
                ];
            }
            
            foreach ($popular_calculators as $calc):
            ?>
            <a href="/calculator/<?php echo htmlspecialchars($calc['slug']); ?>" class="calculator-card">
                <div class="calculator-icon-box">
                    <i class="fas <?php echo htmlspecialchars($calc['icon']); ?>"></i>
                </div>
                <div class="calculator-details">
                    <h3><?php echo htmlspecialchars($calc['name']); ?></h3>
                    <div class="calculator-meta">
                        <span>
                            <i class="fas fa-folder"></i>
                            <?php echo htmlspecialchars($calc['category']); ?>
                        </span>
                        <span>
                            <i class="fas fa-users"></i>
                            <?php echo format_number_short($calc['uses']); ?> uses
                        </span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Why Choose Calculator Hub?</h2>
            <p class="section-subtitle">Trusted by millions for accurate and reliable calculations</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="feature-title">Lightning Fast</h3>
                <p class="feature-description">
                    Get instant results with our optimized calculators. No waiting, no delays.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="feature-title">100% Accurate</h3>
                <p class="feature-description">
                    Verified formulas and algorithms ensure precision in every calculation.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3 class="feature-title">Private & Secure</h3>
                <p class="feature-description">
                    Your data stays on your device. We don't store any calculation data.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="feature-title">Mobile Friendly</h3>
                <p class="feature-description">
                    Responsive design works perfectly on all devices - phone, tablet, or desktop.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <h3 class="feature-title">Always Free</h3>
                <p class="feature-description">
                    No subscriptions, no hidden fees. All calculators are completely free to use.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Regular Updates</h3>
                <p class="feature-description">
                    New calculators added weekly based on user requests and trending needs.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Recent Calculations Section (Only for logged-in or session users) -->
<?php
$recent_calcs = isset($_SESSION['recent_calculations']) ? $_SESSION['recent_calculations'] : [];
if (!empty($recent_calcs) || isset($_SESSION['user_id'])):
?>
<section class="recent-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Your Recent Calculations</h2>
            <p class="section-subtitle">Quick access to your calculation history</p>
        </div>
        
        <div class="recent-list">
            <?php
            if (!empty($recent_calcs)):
                foreach (array_slice($recent_calcs, 0, 5) as $calc):
            ?>
            <div class="recent-calculation">
                <div class="recent-calc-info">
                    <div class="recent-calc-icon">
                        <i class="fas <?php echo htmlspecialchars($calc['icon']); ?>"></i>
                    </div>
                    <div class="recent-calc-details">
                        <h4><?php echo htmlspecialchars($calc['name']); ?></h4>
                        <span class="recent-calc-time">
                            <i class="fas fa-clock"></i> <?php echo time_elapsed($calc['timestamp']); ?>
                        </span>
                    </div>
                </div>
                <a href="/calculator/<?php echo htmlspecialchars($calc['slug']); ?>" class="btn btn-primary" style="font-size: 0.9rem; padding: 8px 20px;">
                    Use Again
                </a>
            </div>
            <?php 
                endforeach;
            else:
            ?>
            <div class="empty-state">
                <i class="fas fa-calculator"></i>
                <h3>No Recent Calculations</h3>
                <p>Start using our calculators to see your history here</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Horizontal Ad #2 -->
<div class="container">
    <?php display_horizontal_ad(2, 'my-5'); ?>
</div>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 class="cta-title">Ready to Get Started?</h2>
        <p style="font-size: 1.1rem; opacity: 0.95;">Join millions of users who trust Calculator Hub for their daily calculations</p>
        
        <div class="cta-buttons">
            <a href="/categories.php" class="btn btn-primary">
                <i class="fas fa-th"></i> Browse All Categories
            </a>
            <a href="/about.php" class="btn btn-outline">
                <i class="fas fa-info-circle"></i> Learn More
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="features-section" style="padding: 60px 20px;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What Our Users Say</h2>
            <p class="section-subtitle">Trusted by professionals and students worldwide</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div style="color: #ffc107; font-size: 1.5rem; margin-bottom: 15px;">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p style="font-style: italic; margin-bottom: 15px; color: var(--text-secondary);">
                    "The most comprehensive collection of calculators I've found online. Use it daily for work!"
                </p>
                <strong>Sarah Johnson</strong>
                <div style="color: var(--text-secondary); font-size: 0.9rem;">Financial Analyst</div>
            </div>
            
            <div class="feature-card">
                <div style="color: #ffc107; font-size: 1.5rem; margin-bottom: 15px;">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p style="font-style: italic; margin-bottom: 15px; color: var(--text-secondary);">
                    "Incredibly accurate and easy to use. Saves me hours of manual calculations every week."
                </p>
                <strong>Michael Chen</strong>
                <div style="color: var(--text-secondary); font-size: 0.9rem;">Civil Engineer</div>
            </div>
            
            <div class="feature-card">
                <div style="color: #ffc107; font-size: 1.5rem; margin-bottom: 15px;">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p style="font-style: italic; margin-bottom: 15px; color: var(--text-secondary);">
                    "Perfect for students! All the calculators I need for my coursework in one place."
                </p>
                <strong>Emily Rodriguez</strong>
                <div style="color: var(--text-secondary); font-size: 0.9rem;">University Student</div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Indicators -->
<section style="padding: 40px 20px; background: var(--bg-secondary);">
    <div class="container">
        <div style="display: flex; justify-content: center; align-items: center; gap: 50px; flex-wrap: wrap; opacity: 0.6;">
            <div style="text-align: center;">
                <i class="fas fa-shield-alt" style="font-size: 2rem; color: var(--primary-color);"></i>
                <div style="margin-top: 10px; font-weight: 600;">SSL Secured</div>
            </div>
            <div style="text-align: center;">
                <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--primary-color);"></i>
                <div style="margin-top: 10px; font-weight: 600;">Verified Formulas</div>
            </div>
            <div style="text-align: center;">
                <i class="fas fa-users" style="font-size: 2rem; color: var(--primary-color);"></i>
                <div style="margin-top: 10px; font-weight: 600;">1M+ Active Users</div>
            </div>
            <div style="text-align: center;">
                <i class="fas fa-clock" style="font-size: 2rem; color: var(--primary-color);"></i>
                <div style="margin-top: 10px; font-weight: 600;">24/7 Available</div>
            </div>
        </div>
    </div>
</section>

<script>
// Homepage Interactive Features
document.addEventListener('DOMContentLoaded', function() {
    
    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all category cards, calculator cards, and feature cards
    document.querySelectorAll('.category-card, .calculator-card, .feature-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    // Hero search input focus effect
    const heroSearchInput = document.querySelector('.hero-search-input');
    if (heroSearchInput) {
        heroSearchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 0.3s ease';
        });
        
        heroSearchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }
    
    // Category card hover effect - show more info
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            const description = this.querySelector('.category-description');
            if (description) {
                description.style.maxHeight = '100px';
                description.style.opacity = '1';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const description = this.querySelector('.category-description');
            if (description) {
                description.style.maxHeight = '0';
                description.style.opacity = '0';
            }
        });
    });
    
    // Add pulse animation to popular calculators
    const calculatorCards = document.querySelectorAll('.calculator-card');
    calculatorCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.animation = 'fadeInUp 0.5s ease-out forwards';
            card.style.animationDelay = (index * 0.1) + 's';
        }, 100);
    });
    
    // Stats counter animation
    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 16);
    }
    
    // Animate hero stats when visible
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumber = entry.target.querySelector('.hero-stat-number');
                const targetText = statNumber.textContent;
                
                // Only animate numeric values
                if (targetText.includes('+')) {
                    const target = parseInt(targetText.replace('+', ''));
                    statNumber.textContent = '0+';
                    
                    let current = 0;
                    const increment = target / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            statNumber.textContent = targetText;
                            clearInterval(timer);
                        } else {
                            statNumber.textContent = Math.floor(current) + '+';
                        }
                    }, 30);
                }
                
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    document.querySelectorAll('.hero-stat').forEach(stat => {
        statsObserver.observe(stat);
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Track popular calculator clicks
    document.querySelectorAll('.calculator-card').forEach(card => {
        card.addEventListener('click', function(e) {
            const calculatorName = this.querySelector('h3').textContent;
            
            // Send analytics event (if analytics is configured)
            if (typeof gtag !== 'undefined') {
                gtag('event', 'calculator_click', {
                    'calculator_name': calculatorName,
                    'location': 'homepage_popular'
                });
            }
        });
    });
    
    // Track category clicks
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function(e) {
            const categoryName = this.querySelector('.category-name').textContent;
            
            // Send analytics event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'category_click', {
                    'category_name': categoryName,
                    'location': 'homepage_grid'
                });
            }
        });
    });
    
    // Show/hide recent calculations section based on data
    const recentSection = document.querySelector('.recent-section');
    if (recentSection) {
        const recentCalcs = recentSection.querySelectorAll('.recent-calculation');
        if (recentCalcs.length === 0) {
            recentSection.style.display = 'none';
        }
    }
    
    // Add loading state to search form
    const heroSearchForm = document.querySelector('.hero-search-form');
    if (heroSearchForm) {
        heroSearchForm.addEventListener('submit', function() {
            const button = this.querySelector('.hero-search-button');
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            button.disabled = true;
        });
    }
    
    // Initialize tooltips (if using a tooltip library)
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.setAttribute('title', element.getAttribute('data-tooltip'));
    });
    
    // Add ripple effect to buttons
    document.querySelectorAll('.btn, .category-card, .calculator-card').forEach(element => {
        element.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Log page view
    if (typeof fetch !== 'undefined') {
        fetch('/api/track-pageview.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                page: 'homepage',
                timestamp: new Date().toISOString()
            })
        }).catch(err => console.log('Tracking error:', err));
    }
});

// Add ripple effect styles
const style = document.createElement('style');
style.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .category-description {
        max-height: 0;
        opacity: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, opacity 0.3s ease;
    }
`;
document.head.appendChild(style);
</script>

<?php
// Include footer
include 'includes/footer.php';
?>