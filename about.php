<?php
require_once 'config.php';

$page_title = "About Us - Calculator";
$page_description = "Learn about Calculator, your trusted source for free online calculators. Our mission is to make calculations simple and accessible for everyone.";

require_once 'includes/header.php';
?>

<div class="about-page">
    <!-- Theme Toggle -->
    <div class="theme-toggle-container">
        <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">
            <i class="fas fa-moon"></i>
            <span class="theme-text">Dark Mode</span>
        </button>
    </div>

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
/* CSS Variables for Theme */
:root {
    /* Light Theme (Default) */
    --bg-primary: #ffffff;
    --bg-secondary: #f8f9fa;
    --bg-hero: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    --bg-card: #ffffff;
    --bg-form: #ffffff;
    --bg-info-icon: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-social-card: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-social-btn: rgba(255, 255, 255, 0.2);
    --bg-alert-success: #d4edda;
    --bg-alert-danger: #f8d7da;
    --bg-cta: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-highlight: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    
    --text-primary: #2d3748;
    --text-secondary: #4a5568;
    --text-muted: #718096;
    --text-hero: #2d3748;
    --text-social: #ffffff;
    --text-cta: #ffffff;
    --text-highlight: #ffffff;
    
    --border-color: #e2e8f0;
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    
    --btn-primary-bg: #667eea;
    --btn-primary-text: #ffffff;
    --btn-secondary-bg: #718096;
    --btn-secondary-text: #ffffff;
    --btn-cta-secondary-bg: #ffffff;
    --btn-cta-secondary-text: #667eea;
}

[data-theme="dark"] {
    /* Dark Theme */
    --bg-primary: #1a202c;
    --bg-secondary: #2d3748;
    --bg-hero: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
    --bg-card: #2d3748;
    --bg-form: #2d3748;
    --bg-info-icon: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-social-card: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-social-btn: rgba(255, 255, 255, 0.1);
    --bg-alert-success: #0f5132;
    --bg-alert-danger: #842029;
    --bg-cta: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-highlight: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    
    --text-primary: #e2e8f0;
    --text-secondary: #cbd5e0;
    --text-muted: #a0aec0;
    --text-hero: #e2e8f0;
    --text-social: #ffffff;
    --text-cta: #ffffff;
    --text-highlight: #ffffff;
    
    --border-color: #4a5568;
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    
    --btn-primary-bg: #667eea;
    --btn-primary-text: #ffffff;
    --btn-secondary-bg: #718096;
    --btn-secondary-text: #ffffff;
    --btn-cta-secondary-bg: #ffffff;
    --btn-cta-secondary-text: #667eea;
}

/* Base Styles */
body {
    background-color: var(--bg-primary);
    color: var(--text-primary);
    transition: background-color 0.3s ease, color 0.3s ease;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
}

/* Theme Toggle */
.theme-toggle-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
}

.theme-toggle {
    background: var(--bg-card);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 30px;
    padding: 10px 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.theme-toggle:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.theme-text {
    font-weight: 500;
}

/* About Page Styles */
.about-page {
    padding-bottom: 0;
}

.about-hero {
    background: var(--bg-hero);
    color: var(--text-hero);
    padding: 5rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,100 1000,0 0,100"></polygon></svg>');
    background-size: cover;
}

.about-hero-content {
    position: relative;
    z-index: 1;
}

.about-hero-content h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: var(--text-hero);
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.lead {
    font-size: 1.5rem;
    color: var(--text-hero);
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

.about-section {
    padding: 5rem 0;
    background-color: var(--bg-primary);
}

.about-section.bg-light {
    background: var(--bg-secondary);
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
    color: var(--text-primary);
    font-weight: 700;
}

.about-content p {
    font-size: 1.125rem;
    line-height: 1.8;
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
}

.about-stats-card {
    background: var(--bg-card);
    padding: 3rem;
    border-radius: 20px;
    box-shadow: var(--shadow);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    border: 1px solid var(--border-color);
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
    color: var(--text-muted);
    font-weight: 600;
}

/* Values Section */
.values-section {
    padding: 5rem 0;
    background: var(--bg-secondary);
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.section-header h2 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.section-header p {
    font-size: 1.125rem;
    color: var(--text-secondary);
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.value-card {
    background: var(--bg-card);
    padding: 2.5rem;
    border-radius: 16px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: transform 0.3s ease;
    border: 1px solid var(--border-color);
}

.value-card:hover {
    transform: translateY(-10px);
}

.value-icon {
    width: 80px;
    height: 80px;
    background: var(--bg-info-icon);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.value-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
    font-weight: 600;
}

.value-card p {
    color: var(--text-secondary);
    line-height: 1.8;
}

/* Feature List */
.feature-list h2 {
    font-size: 2.5rem;
    margin-bottom: 2rem;
    color: var(--text-primary);
    font-weight: 700;
}

.feature-item {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--bg-card);
    border-radius: 12px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateX(5px);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: var(--bg-info-icon);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.feature-content h4 {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    font-weight: 600;
}

.feature-content p {
    color: var(--text-secondary);
    margin: 0;
}

.highlight-box {
    background: var(--bg-highlight);
    color: var(--text-highlight);
    padding: 3rem;
    border-radius: 20px;
    text-align: center;
    box-shadow: var(--shadow);
}

.highlight-box h3 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--text-highlight);
    font-weight: 700;
}

.highlight-box p {
    font-size: 1.125rem;
    margin-bottom: 2rem;
    opacity: 0.95;
}

/* CTA Section */
.cta-section {
    background: var(--bg-cta);
    color: var(--text-cta);
    padding: 5rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,100 1000,0 0,100"></polygon></svg>');
    background-size: cover;
}

.cta-content {
    position: relative;
    z-index: 1;
}

.cta-content h2 {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: var(--text-cta);
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

/* Buttons */
.btn {
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
    text-decoration: none;
}

.btn-lg {
    padding: 15px 30px;
    font-size: 1.1rem;
}

.btn-primary {
    background: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
}

.btn-secondary {
    background: var(--btn-secondary-bg);
    color: var(--btn-secondary-text);
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.cta-section .btn-secondary {
    background: var(--btn-cta-secondary-bg);
    color: var(--btn-cta-secondary-text);
}

.cta-section .btn-secondary:hover {
    background: #f8f9fa;
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
        padding: 2rem;
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
    
    .theme-toggle-container {
        position: relative;
        top: 0;
        right: 0;
        display: flex;
        justify-content: flex-end;
        padding: 10px 15px;
    }
    
    .feature-item {
        flex-direction: column;
        text-align: center;
    }
    
    .feature-icon {
        margin: 0 auto;
    }
}

@media (max-width: 480px) {
    .about-hero {
        padding: 3rem 0;
    }
    
    .about-section {
        padding: 3rem 0;
    }
    
    .values-section {
        padding: 3rem 0;
    }
    
    .about-hero-content h1 {
        font-size: 2rem;
    }
    
    .value-card {
        padding: 1.5rem;
    }
    
    .highlight-box {
        padding: 2rem;
    }
}
</style>

<script>
// Theme Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle.querySelector('i');
    const themeText = themeToggle.querySelector('.theme-text');
    
    // Check for saved theme preference or default to light
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // Apply the saved theme
    document.documentElement.setAttribute('data-theme', currentTheme);
    updateThemeToggle(currentTheme);
    
    // Toggle theme on button click
    themeToggle.addEventListener('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        updateThemeToggle(newTheme);
    });
    
    function updateThemeToggle(theme) {
        if (theme === 'dark') {
            themeIcon.className = 'fas fa-sun';
            themeText.textContent = 'Light Mode';
        } else {
            themeIcon.className = 'fas fa-moon';
            themeText.textContent = 'Dark Mode';
        }
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>