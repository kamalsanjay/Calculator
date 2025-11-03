<?php
/**
 * All Calculator Categories Page - Fixed
 */

require_once __DIR__ . '/../config.php';

$page_title = "All Calculator Categories - Calculator";
$page_description = "Browse all 14 categories of calculators including Financial, Health, Math, Conversion, and more.";

// Get all categories with calculator counts
try {
    $db = Database::getInstance();
    $categories = $db->fetchAll("
        SELECT c.*, COUNT(calc.id) as calculator_count
        FROM categories c
        LEFT JOIN calculators calc ON c.slug = calc.category AND calc.is_active = 1
        WHERE c.is_active = 1
        GROUP BY c.id
        ORDER BY c.display_order ASC
    ");
} catch (Exception $e) {
    $categories = [];
    error_log('Categories error: ' . $e->getMessage());
}

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Futuristic Header Section -->
<section class="categories-hero-light">
    <div class="animated-bg-light">
        <div class="grid-overlay-light"></div>
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </div>
    
    <div class="container">
        <div class="hero-content-categories">
            <div class="breadcrumb-wrapper" data-aos="fade-down">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-modern">
                        <li><a href="<?php echo SITE_URL; ?>"><i class="fas fa-home"></i> Home</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li class="active">All Categories</li>
                    </ol>
                </nav>
            </div>
            
            <h1 class="page-title-modern" data-aos="fade-up" data-aos-delay="100">
                Explore All Categories
            </h1>
            
            <p class="page-subtitle-modern" data-aos="fade-up" data-aos-delay="200">
                Discover 300+ professional calculators across 14 specialized categories
            </p>
            
            <div class="stats-bar-modern" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-pill-modern">
                    <i class="fas fa-layer-group"></i>
                    <span><?php echo count($categories); ?> Categories</span>
                </div>
                <div class="stat-pill-modern">
                    <i class="fas fa-calculator"></i>
                    <span>
                        <?php 
                        $total = 0;
                        foreach ($categories as $cat) {
                            $total += isset($cat['calculator_count']) ? (int)$cat['calculator_count'] : 0;
                        }
                        echo $total;
                        ?>+ Tools
                    </span>
                </div>
                <div class="stat-pill-modern">
                    <i class="fas fa-infinity"></i>
                    <span>100% Free</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Grid Section -->
<section class="categories-showcase-light">
    <div class="container">
        <div class="categories-grid-responsive">
            <?php 
            $gradients = [
                ['#667eea', '#764ba2', '#e8eaf6'],
                ['#f093fb', '#f5576c', '#fce4ec'],
                ['#4facfe', '#00f2fe', '#e1f5fe'],
                ['#43e97b', '#38f9d7', '#e8f5e9'],
                ['#fa709a', '#fee140', '#fff3e0'],
                ['#667eea', '#764ba2', '#f3e5f5'],
                ['#ff9a56', '#ff6a88', '#fff0e6'],
                ['#ffecd2', '#fcb69f', '#fff8e1'],
                ['#ff6e7f', '#bfe9ff', '#ffe6ea'],
                ['#ebbba7', '#cfc7f8', '#f5f3ff'],
                ['#e0c3fc', '#8ec5fc', '#e8eaf6'],
                ['#f77062', '#fe5196', '#ffe5ec'],
                ['#fccb90', '#d57eeb', '#fff0f5'],
                ['#30cfd0', '#330867', '#e0f2f1']
            ];
            
            foreach ($categories as $index => $category): 
                $color1 = $gradients[$index % count($gradients)][0];
                $color2 = $gradients[$index % count($gradients)][1];
                $bgColor = $gradients[$index % count($gradients)][2];
                $icon = htmlspecialchars($category['icon'] ?? 'calculator');
                $calcCount = isset($category['calculator_count']) ? (int)$category['calculator_count'] : 0;
            ?>
                <div class="category-card-modern" 
                     data-aos="zoom-in" 
                     data-aos-delay="<?php echo ($index * 50); ?>"
                     style="--gradient-start: <?php echo $color1; ?>; --gradient-end: <?php echo $color2; ?>; --bg-light: <?php echo $bgColor; ?>;">
                    <a href="<?php echo SITE_URL; ?>/calculators/<?php echo htmlspecialchars($category['slug']); ?>/">
                        <div class="card-inner">
                            <div class="card-header-modern">
                                <div class="icon-box">
                                    <div class="icon-bg-gradient"></div>
                                    <i class="fas fa-<?php echo $icon; ?>"></i>
                                </div>
                                
                                <div class="count-badge">
                                    <span><?php echo $calcCount; ?></span>
                                    <small>tools</small>
                                </div>
                            </div>
                            
                            <div class="card-body-modern">
                                <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                                <p><?php echo htmlspecialchars($category['description'] ?? 'Professional calculation tools'); ?></p>
                            </div>
                            
                            <div class="card-footer-modern">
                                <span class="action-text">Explore Tools</span>
                                <div class="action-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-shine"></div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
/* Light Theme Hero Section */
.categories-hero-light {
    position: relative;
    padding: 5rem 0 4rem;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    overflow: hidden;
}

.animated-bg-light {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.grid-overlay-light {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        linear-gradient(rgba(102, 126, 234, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(102, 126, 234, 0.03) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: gridMove 20s linear infinite;
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.floating-shapes .shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(40px);
    opacity: 0.2;
}

.floating-shapes .shape-1 {
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    top: -100px;
    right: 10%;
    animation: float 15s ease-in-out infinite;
}

.floating-shapes .shape-2 {
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, #f093fb, #f5576c);
    bottom: -50px;
    left: 10%;
    animation: float 20s ease-in-out infinite;
    animation-delay: 2s;
}

.floating-shapes .shape-3 {
    width: 250px;
    height: 250px;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation: float 18s ease-in-out infinite;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0) translateX(0); }
    33% { transform: translateY(-30px) translateX(20px); }
    66% { transform: translateY(20px) translateX(-20px); }
}

.hero-content-categories {
    position: relative;
    z-index: 10;
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
}

.breadcrumb-wrapper {
    margin-bottom: 2rem;
}

.breadcrumb-modern {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    list-style: none;
    padding: 0.75rem 1.5rem;
    background: white;
    border-radius: 50px;
    display: inline-flex;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.breadcrumb-modern li {
    display: flex;
    align-items: center;
    font-size: 0.95rem;
    color: #495057;
}

.breadcrumb-modern a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.breadcrumb-modern a:hover {
    color: #764ba2;
}

.breadcrumb-modern .active {
    color: #6c757d;
}

.breadcrumb-modern i {
    font-size: 0.875rem;
}

.page-title-modern {
    font-size: 3.5rem;
    font-weight: 900;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-subtitle-modern {
    font-size: 1.25rem;
    margin-bottom: 2.5rem;
    color: #495057;
}

.stats-bar-modern {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.stat-pill-modern {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: white;
    border-radius: 50px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    font-weight: 600;
    color: #495057;
    transition: all 0.3s ease;
}

.stat-pill-modern:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.stat-pill-modern i {
    font-size: 1.5rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Categories Grid - Responsive */
.categories-showcase-light {
    padding: 6rem 0;
    background: #f8f9fa;
}

.categories-grid-responsive {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

/* Large screens: 4 columns */
@media (max-width: 1400px) {
    .categories-grid-responsive {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Medium screens: 3 columns */
@media (max-width: 1024px) {
    .categories-grid-responsive {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Small-medium screens: 2 columns */
@media (max-width: 768px) {
    .categories-grid-responsive {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    .page-title-modern {
        font-size: 2.5rem;
    }
}

/* Mobile: 1 column */
@media (max-width: 480px) {
    .categories-grid-responsive {
        grid-template-columns: 1fr;
    }
}

/* Modern Category Card */
.category-card-modern {
    position: relative;
    border-radius: 20px;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.category-card-modern a {
    display: block;
    position: relative;
    text-decoration: none;
    color: inherit;
    height: 100%;
}

.card-inner {
    position: relative;
    padding: 2rem;
    background: white;
    border-radius: 20px;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    overflow: hidden;
}

.category-card-modern:hover .card-inner {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.card-header-modern {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.icon-box {
    position: relative;
    width: 70px;
    height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.icon-bg-gradient {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    opacity: 0.15;
}

.icon-box i {
    position: relative;
    z-index: 2;
    font-size: 2rem;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    transition: transform 0.3s ease;
}

.category-card-modern:hover .icon-box i {
    transform: scale(1.1) rotate(5deg);
}

.count-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.5rem 1rem;
    background: var(--bg-light);
    border-radius: 12px;
    min-width: 60px;
}

.count-badge span {
    font-size: 1.25rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.count-badge small {
    font-size: 0.75rem;
    color: #6c757d;
    font-weight: 600;
}

.card-body-modern {
    flex: 1;
    margin-bottom: 1.5rem;
}

.card-body-modern h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    color: #1a1a1a;
}

.card-body-modern p {
    color: #6c757d;
    line-height: 1.6;
    font-size: 0.95rem;
}

.card-footer-modern {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 1.5rem;
    border-top: 2px solid #f1f3f5;
}

.action-text {
    font-weight: 600;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.action-arrow {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: transform 0.3s ease;
}

.category-card-modern:hover .action-arrow {
    transform: translateX(5px);
}

.card-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s ease;
}

.category-card-modern:hover .card-shine {
    left: 100%;
}

/* Mobile Responsive Adjustments */
@media (max-width: 768px) {
    .categories-hero-light {
        padding: 3rem 0 2rem;
    }
    
    .stats-bar-modern {
        flex-direction: column;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
    }
    
    .stat-pill-modern {
        width: 100%;
        justify-content: center;
    }
    
    .card-inner {
        padding: 1.5rem;
    }
    
    .icon-box {
        width: 60px;
        height: 60px;
    }
    
    .icon-box i {
        font-size: 1.75rem;
    }
}

@media (max-width: 480px) {
    .page-title-modern {
        font-size: 2rem;
    }
    
    .page-subtitle-modern {
        font-size: 1rem;
    }
}
</style>

<!-- AOS Animation -->
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    duration: 600,
    once: true,
    offset: 50,
    easing: 'ease-out-cubic'
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>