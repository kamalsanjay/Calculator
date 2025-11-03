<?php
require_once 'config.php';

$page_title = "About Us - Calculator";
$page_description = "Learn about Calculator, your trusted source for free online calculators. Our mission is to make calculations simple and accessible for everyone.";

require_once 'includes/header.php';
?>

<div class="about-page">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="about-hero-content">
                <h1>About Calculator</h1>
                <p class="lead">Making calculations simple and accessible for everyone</p>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <h2>Our Mission</h2>
                    <p>At Calculator, we believe that everyone should have access to professional-grade calculation tools without barriers. Our mission is to provide accurate, easy-to-use calculators that help people make informed decisions in their daily lives.</p>
                    <p>Whether you're planning your finances, tracking your health, solving math problems, or converting units, we're here to help you get the answers you need quickly and accurately.</p>
                </div>
                <div class="about-image">
                    <div class="about-stats-card">
                        <div class="stat-item">
                            <div class="stat-number">300+</div>
                            <div class="stat-label">Calculators</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">14</div>
                            <div class="stat-label">Categories</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">100%</div>
                            <div class="stat-label">Free</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Available</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header">
                <h2>Our Values</h2>
                <p>The principles that guide everything we do</p>
            </div>

            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Accuracy</h3>
                    <p>Every calculator uses professionally verified formulas to ensure you get precise results every time.</p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-universal-access"></i>
                    </div>
                    <h3>Accessibility</h3>
                    <p>Our tools are designed to be simple and intuitive, making complex calculations accessible to everyone.</p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Privacy</h3>
                    <p>We don't store your data or require registration. Your calculations are private and secure.</p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Free Forever</h3>
                    <p>All our calculators are completely free with no hidden charges or premium features.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="about-section bg-light">
        <div class="container">
            <div class="about-grid reverse">
                <div class="feature-list">
                    <h2>Why Choose Us?</h2>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="feature-content">
                            <h4>Mobile Responsive</h4>
                            <p>Access calculators seamlessly on any device - desktop, tablet, or smartphone.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="feature-content">
                            <h4>Lightning Fast</h4>
                            <p>Get instant results with our optimized calculation engines.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="feature-content">
                            <h4>Global Standards</h4>
                            <p>Support for multiple units and international calculation standards.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-life-ring"></i>
                        </div>
                        <div class="feature-content">
                            <h4>Always Updated</h4>
                            <p>Regular updates ensure formulas and calculations stay current.</p>
                        </div>
                    </div>
                </div>
                <div class="about-content">
                    <div class="highlight-box">
                        <h3>Trusted by Millions</h3>
                        <p>Join millions of users worldwide who rely on Calculator for their daily calculation needs.</p>
                        <a href="<?php echo SITE_URL; ?>" class="btn btn-primary btn-lg">
                            Explore Calculators
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Get Started?</h2>
                <p>Explore our collection of 300+ free calculators and make your life easier today.</p>
                <div class="cta-buttons">
                    <a href="<?php echo SITE_URL; ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-calculator"></i> Browse Calculators
                    </a>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-secondary btn-lg">
                        <i class="fas fa-envelope"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* About Page Styles */
.about-page {
    padding-bottom: 0;
}

.about-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 5rem 0;
    text-align: center;
}

.about-hero-content h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: white;
}

.lead {
    font-size: 1.5rem;
    opacity: 0.95;
}

.about-section {
    padding: 5rem 0;
}

.about-section.bg-light {
    background: #f8f9fa;
}

.about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

.about-grid.reverse {
    direction: rtl;
}

.about-grid.reverse > * {
    direction: ltr;
}

.about-content h2 {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
    color: #1a1a1a;
}

.about-content p {
    font-size: 1.125rem;
    line-height: 1.8;
    color: #495057;
    margin-bottom: 1.5rem;
}

.about-stats-card {
    background: white;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6c757d;
    font-weight: 600;
}

/* Values Section */
.values-section {
    padding: 5rem 0;
    background: #f8f9fa;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.section-header h2 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.section-header p {
    font-size: 1.125rem;
    color: #6c757d;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.value-card {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
}

.value-card:hover {
    transform: translateY(-10px);
}

.value-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
}

.value-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.value-card p {
    color: #6c757d;
    line-height: 1.8;
}

/* Feature List */
.feature-list h2 {
    font-size: 2.5rem;
    margin-bottom: 2rem;
    color: #1a1a1a;
}

.feature-item {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.feature-content h4 {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
    color: #1a1a1a;
}

.feature-content p {
    color: #6c757d;
    margin: 0;
}

.highlight-box {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem;
    border-radius: 20px;
    text-align: center;
}

.highlight-box h3 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: white;
}

.highlight-box p {
    font-size: 1.125rem;
    margin-bottom: 2rem;
    opacity: 0.95;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 5rem 0;
    text-align: center;
}

.cta-content h2 {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: white;
}

.cta-content p {
    font-size: 1.25rem;
    margin-bottom: 2.5rem;
    opacity: 0.95;
}

.cta-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-secondary {
    background: white;
    color: #667eea;
}

.btn-secondary:hover {
    background: #f8f9fa;
    color: #667eea;
}

/* Responsive */
@media (max-width: 768px) {
    .about-hero-content h1 {
        font-size: 2.5rem;
    }
    
    .about-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .about-stats-card {
        grid-template-columns: 1fr;
    }
    
    .values-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-content h2 {
        font-size: 2rem;
    }
    
    .cta-buttons {
        flex-direction: column;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>