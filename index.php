<?php
require_once 'config.php';
require_once 'router.php';

$request_uri = $_SERVER['REQUEST_URI'];
if (strpos($request_uri, 'index.php') === false && $request_uri !== '/' && $request_uri !== '/Calculator' && $request_uri !== '/Calculator/') {
    Router::dispatch();
    exit;
}

$page_title = "Calculator - Free Online Calculators for Every Need";
$page_description = "Access 300+ free online calculators for financial, health, math, conversion, and more. Fast, accurate, and easy to use.";

try {
    $db = Database::getInstance();
    $categories = $db->fetchAll("
        SELECT * FROM categories 
        WHERE is_active = 1 
        ORDER BY display_order ASC
    ");
} catch (Exception $e) {
    $categories = [];
}

require_once 'includes/header.php';
?>

<!-- Hero Section with Animated Background -->
<section class="hero-section">
    <div class="hero-background">
        <div class="hero-shape shape-1"></div>
        <div class="hero-shape shape-2"></div>
        <div class="hero-shape shape-3"></div>
        <div class="hero-particles"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge" data-aos="fade-down">
                <i class="fas fa-star"></i>
                <span>300+ Free Calculators</span>
            </div>
            
            <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                Professional Calculator Tools
            </h1>
            
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                Access 300+ free online calculators for finance, health, math, conversions, and more.<br>
                Fast, accurate, and easy to use.
            </p>
            
            <div class="hero-stats" data-aos="fade-up" data-aos-delay="300">
                <div class="hero-stat">
                    <div class="stat-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="stat-number" data-count="300">0</div>
                    <div class="stat-label">Calculators</div>
                </div>
                <div class="hero-stat">
                    <div class="stat-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="stat-number" data-count="14">0</div>
                    <div class="stat-label">Categories</div>
                </div>
                <div class="hero-stat">
                    <div class="stat-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Free</div>
                </div>
            </div>
            
            <div class="hero-cta" data-aos="fade-up" data-aos-delay="400">
                <a href="#categories" class="btn-hero btn-primary">
                    <i class="fas fa-rocket"></i>
                    Explore Calculators
                </a>
                <a href="<?php echo SITE_URL; ?>/about.php" class="btn-hero btn-secondary">
                    <i class="fas fa-info-circle"></i>
                    Learn More
                </a>
            </div>
        </div>
    </div>
    
    <div class="hero-scroll">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section" id="categories">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Browse Tools</span>
            <h2>Calculator Categories</h2>
            <p>Choose from our comprehensive collection of professional calculator tools</p>
        </div>
        
        <div class="categories-grid">
            <!-- Financial -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="0">
                <a href="<?php echo SITE_URL; ?>/calculators/financial/">
                    <div class="category-icon-wrapper">
                        <div class="category-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="category-glow"></div>
                    </div>
                    <h3>Financial</h3>
                    <p>Mortgage, loans, investments, tax calculators and more</p>
                    <div class="category-footer">
                        <span class="category-count">
                            <i class="fas fa-calculator"></i> 58 tools
                        </span>
                        <span class="category-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Health & Fitness -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="100">
                <a href="<?php echo SITE_URL; ?>/calculators/health/">
                    <div class="category-icon-wrapper">
                        <div class="category-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div class="category-glow"></div>
                    </div>
                    <h3>Health & Fitness</h3>
                    <p>BMI, calorie, fitness, and wellness calculators</p>
                    <div class="category-footer">
                        <span class="category-count">
                            <i class="fas fa-calculator"></i> 40 tools
                        </span>
                        <span class="category-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Math -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="200">
                <a href="<?php echo SITE_URL; ?>/calculators/math/">
                    <div class="category-icon-wrapper">
                        <div class="category-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-square-root-alt"></i>
                        </div>
                        <div class="category-glow"></div>
                    </div>
                    <h3>Math</h3>
                    <p>Scientific, algebra, geometry, statistics calculators</p>
                    <div class="category-footer">
                        <span class="category-count">
                            <i class="fas fa-calculator"></i> 42 tools
                        </span>
                        <span class="category-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Conversion -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="300">
                <a href="<?php echo SITE_URL; ?>/calculators/conversion/">
                    <div class="category-icon-wrapper">
                        <div class="category-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="category-glow"></div>
                    </div>
                    <h3>Conversion</h3>
                    <p>Unit converters for length, weight, temperature</p>
                    <div class="category-footer">
                        <span class="category-count">
                            <i class="fas fa-calculator"></i> 40 tools
                        </span>
                        <span class="category-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Date & Time -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="400">
                <a href="<?php echo SITE_URL; ?>/calculators/date-time/">
                    <div class="category-icon-wrapper">
                        <div class="category-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="category-glow"></div>
                    </div>
                    <h3>Date & Time</h3>
                    <p>Age, date difference, time calculators</p>
                    <div class="category-footer">
                        <span class="category-count">
                            <i class="fas fa-calculator"></i> 16 tools
                        </span>
                        <span class="category-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Sports -->
            <div class="category-card" data-aos="fade-up" data-aos-delay="500">
                <a href="<?php echo SITE_URL; ?>/calculators/sports/">
                    <div class="category-icon-wrapper">
                        <div class="category-icon" style="background: linear-gradient(135deg, #fccb90 0%, #d57eeb 100%);">
                            <i class="fas fa-running"></i>
                        </div>
                        <div class="category-glow"></div>
                    </div>
                    <h3>Sports</h3>
                    <p>Pace, time, performance calculators</p>
                    <div class="category-footer">
                        <span class="category-count">
                            <i class="fas fa-calculator"></i> 8 tools
                        </span>
                        <span class="category-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="view-all-wrapper" data-aos="fade-up" data-aos-delay="600">
            <a href="<?php echo SITE_URL; ?>/calculators/" class="btn-view-all">
                View All Categories
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Why Choose Us</span>
            <h2>Professional Tools You Can Trust</h2>
            <p>Everything you need for accurate calculations</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="0">
                <div class="feature-icon">
                    <i class="fas fa-shield-check"></i>
                </div>
                <h3>100% Accurate</h3>
                <p>Every calculator uses professionally verified formulas to ensure precise results every time.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Mobile Friendly</h3>
                <p>Fully responsive design works perfectly on smartphones, tablets, and desktop computers.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3>Privacy First</h3>
                <p>No registration required. Your data stays private and is never stored or shared with anyone.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Lightning Fast</h3>
                <p>Instant calculations with optimized algorithms for the fastest results possible.</p>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Section with Animations */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.hero-shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    opacity: 0.3;
    animation: float 20s infinite ease-in-out;
}

.shape-1 {
    width: 600px;
    height: 600px;
    background: #ff6b9d;
    top: -200px;
    right: -200px;
    animation-delay: 0s;
}

.shape-2 {
    width: 400px;
    height: 400px;
    background: #4facfe;
    bottom: -100px;
    left: -100px;
    animation-delay: 5s;
}

.shape-3 {
    width: 500px;
    height: 500px;
    background: #43e97b;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: 10s;
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(50px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-50px, 50px) scale(0.9);
    }
}

.hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
    color: white;
    padding: 2rem;
    max-width: 900px;
    margin: 0 auto;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
    }
}

.hero-badge i {
    color: #ffd700;
    animation: rotate 3s infinite linear;
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.hero-title {
    font-size: 4rem;
    font-weight: 900;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    color: rgba(222, 211, 211, 1);
    /* text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); */
    text-shadow: 0 4px 20px rgba(235, 228, 228, 0.2);
}

.hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 3rem;
    opacity: 0.95;
    line-height: 1.8;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.hero-stat {
    text-align: center;
}

.stat-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.stat-icon i {
    font-size: 2rem;
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1.125rem;
    opacity: 0.9;
}

.hero-cta {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-hero {
    padding: 1.25rem 2.5rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.125rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background: white;
    color: #667eea;
}

.btn-primary:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-4px);
}

.hero-scroll {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    animation: bounce 2s infinite;
}

.hero-scroll i {
    font-size: 2rem;
    color: white;
}

@keyframes bounce {
    0%, 100% {
        transform: translateX(-50%) translateY(0);
    }
    50% {
        transform: translateX(-50%) translateY(-20px);
    }
}

/* Categories Section */
.categories-section {
    padding: 6rem 0;
    background: #f8f9fa;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.section-badge {
    display: inline-block;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.875rem;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.section-header h2 {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.section-header p {
    font-size: 1.25rem;
    color: #6c757d;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
}

.category-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 2px solid transparent;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
}

.category-card a {
    display: block;
    padding: 2.5rem;
    text-decoration: none;
    color: inherit;
}

.category-icon-wrapper {
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0 auto 2rem;
}

.category-icon {
    width: 100%;
    height: 100%;
    border-radius: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.1) rotate(5deg);
}

.category-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 120%;
    height: 120%;
    background: inherit;
    border-radius: 25px;
    filter: blur(20px);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.category-card:hover .category-glow {
    opacity: 0.5;
}

.category-card h3 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.category-card p {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.category-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid #f1f3f5;
}

.category-count {
    font-size: 0.875rem;
    font-weight: 600;
    color: #667eea;
}

.category-arrow {
    width: 40px;
    height: 40px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    transition: all 0.3s ease;
}

.category-card:hover .category-arrow {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateX(5px);
}

/* Features Section */
.features-section {
    padding: 6rem 0;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.feature-card {
    background: white;
    padding: 3rem 2rem;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 2.5rem;
    color: white;
}

.feature-card h3 {
    font-size: 1.75rem;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.feature-card p {
    color: #6c757d;
    line-height: 1.8;
}

.view-all-wrapper {
    text-align: center;
    margin-top: 4rem;
}

.btn-view-all {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.25rem 2.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.125rem;
    transition: all 0.3s ease;
}

.btn-view-all:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-stats {
        gap: 2rem;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .section-header h2 {
        font-size: 2rem;
    }
    
    .categories-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- AOS Animation Library -->
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
// Initialize AOS
AOS.init({
    duration: 800,
    once: true,
    offset: 100
});

// Counter animation
document.querySelectorAll('.stat-number[data-count]').forEach(counter => {
    const target = parseInt(counter.dataset.count);
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    
    const updateCounter = () => {
        current += step;
        if (current < target) {
            counter.textContent = Math.floor(current);
            requestAnimationFrame(updateCounter);
        } else {
            counter.textContent = target + '+';
        }
    };
    
    // Start animation when in view
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            updateCounter();
            observer.disconnect();
        }
    });
    
    observer.observe(counter);
});
</script>

<?php require_once 'includes/footer.php'; ?>