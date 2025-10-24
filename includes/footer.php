<?php
/**
 * Footer Component
 * 
 * Displays the main site footer with:
 * - Copyright information
 * - Category links
 * - Social media links
 * - Newsletter signup form
 * - Footer navigation
 * 
 * @package CalculatorWebsite
 * @version 1.0.0
 */

// Ensure this file is not accessed directly
if (!defined('DB_HOST')) {
    die('Direct access not permitted');
}
?>
    </main>
    <!-- End Main Content -->
    
    <!-- Footer Section -->
    <footer class="site-footer" role="contentinfo">
        <div class="footer-main">
            <div class="container">
                <div class="footer-grid">
                    <!-- About Section -->
                    <div class="footer-column">
                        <div class="footer-brand">
                            <img src="/assets/images/logo.svg" alt="Calculator Hub" class="footer-logo">
                            <h3>Calculator<span class="highlight">Hub</span></h3>
                        </div>
                        <p class="footer-description">
                            Your comprehensive resource for free online calculators across 14+ categories. 
                            Fast, accurate, and easy-to-use tools for all your calculation needs.
                        </p>
                        <div class="social-links">
                            <a href="https://facebook.com/calculatorhub" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/calculatorhub" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://instagram.com/calculatorhub" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://linkedin.com/company/calculatorhub" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://youtube.com/calculatorhub" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Quick Links - Categories Part 1 -->
                    <div class="footer-column">
                        <h4 class="footer-title">Popular Categories</h4>
                        <ul class="footer-links">
                            <li><a href="/category/math"><i class="fas fa-calculator"></i> Math Calculators</a></li>
                            <li><a href="/category/finance"><i class="fas fa-dollar-sign"></i> Financial Tools</a></li>
                            <li><a href="/category/health"><i class="fas fa-heartbeat"></i> Health & Fitness</a></li>
                            <li><a href="/category/conversion"><i class="fas fa-exchange-alt"></i> Unit Converters</a></li>
                            <li><a href="/category/date"><i class="fas fa-calendar-alt"></i> Date & Time</a></li>
                            <li><a href="/category/statistics"><i class="fas fa-chart-bar"></i> Statistics</a></li>
                        </ul>
                    </div>
                    
                    <!-- Quick Links - Categories Part 2 -->
                    <div class="footer-column">
                        <h4 class="footer-title">More Tools</h4>
                        <ul class="footer-links">
                            <li><a href="/category/science"><i class="fas fa-flask"></i> Science Tools</a></li>
                            <li><a href="/category/engineering"><i class="fas fa-cogs"></i> Engineering</a></li>
                            <li><a href="/category/cooking"><i class="fas fa-utensils"></i> Cooking & Recipes</a></li>
                            <li><a href="/category/construction"><i class="fas fa-hard-hat"></i> Construction</a></li>
                            <li><a href="/category/automotive"><i class="fas fa-car"></i> Automotive</a></li>
                            <li><a href="/category/education"><i class="fas fa-graduation-cap"></i> Education</a></li>
                        </ul>
                    </div>
                    
                    <!-- Newsletter Signup -->
                    <div class="footer-column">
                        <h4 class="footer-title">Stay Updated</h4>
                        <p class="newsletter-description">
                            Subscribe to get updates on new calculators and features.
                        </p>
                        <form action="/api/newsletter-signup.php" method="POST" class="newsletter-form" id="newsletterForm">
                            <div class="newsletter-input-wrapper">
                                <input 
                                    type="email" 
                                    name="email" 
                                    class="newsletter-input" 
                                    placeholder="Enter your email" 
                                    required
                                    aria-label="Email address for newsletter"
                                >
                                <button type="submit" class="newsletter-button" aria-label="Subscribe">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                            <div class="newsletter-response" style="display: none;"></div>
                        </form>
                        <div class="footer-extra-links">
                            <h5 class="extra-links-title">Company</h5>
                            <ul class="extra-links">
                                <li><a href="/about.php">About Us</a></li>
                                <li><a href="/contact.php">Contact</a></li>
                                <li><a href="/blog.php">Blog</a></li>
                                <li><a href="/careers.php">Careers</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>
                            &copy; <?php echo date('Y'); ?> Calculator Hub. All rights reserved.
                            <span class="separator">|</span>
                            Made with <i class="fas fa-heart" style="color: #e74c3c;"></i> for accuracy
                        </p>
                    </div>
                    <div class="footer-bottom-links">
                        <a href="/privacy-policy.php">Privacy Policy</a>
                        <span class="separator">|</span>
                        <a href="/terms-of-service.php">Terms of Service</a>
                        <span class="separator">|</span>
                        <a href="/sitemap.php">Sitemap</a>
                        <span class="separator">|</span>
                        <a href="/disclaimer.php">Disclaimer</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    <!-- Cookie Consent Banner (GDPR Compliance) -->
    <?php if (!isset($_COOKIE['cookie_consent'])): ?>
    <div class="cookie-consent" id="cookieConsent">
        <div class="cookie-content">
            <div class="cookie-text">
                <i class="fas fa-cookie-bite"></i>
                <p>We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies. 
                <a href="/privacy-policy.php">Learn more</a></p>
            </div>
            <div class="cookie-actions">
                <button id="acceptCookies" class="btn-accept">Accept</button>
                <button id="declineCookies" class="btn-decline">Decline</button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Footer Scripts -->
    <script src="/assets/js/main.js"></script>
    
    <script>
    // Newsletter Form Submission
    document.addEventListener('DOMContentLoaded', function() {
        const newsletterForm = document.getElementById('newsletterForm');
        
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const responseDiv = this.querySelector('.newsletter-response');
                const submitBtn = this.querySelector('.newsletter-button');
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                
                fetch('/api/newsletter-signup.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    responseDiv.style.display = 'block';
                    responseDiv.className = 'newsletter-response ' + (data.success ? 'success' : 'error');
                    responseDiv.textContent = data.message;
                    
                    if (data.success) {
                        newsletterForm.reset();
                    }
                })
                .catch(error => {
                    responseDiv.style.display = 'block';
                    responseDiv.className = 'newsletter-response error';
                    responseDiv.textContent = 'An error occurred. Please try again.';
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                    
                    setTimeout(() => {
                        responseDiv.style.display = 'none';
                    }, 5000);
                });
            });
        }
        
        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Cookie Consent
        const cookieConsent = document.getElementById('cookieConsent');
        const acceptCookies = document.getElementById('acceptCookies');
        const declineCookies = document.getElementById('declineCookies');
        
        if (acceptCookies) {
            acceptCookies.addEventListener('click', function() {
                setCookie('cookie_consent', 'accepted', 365);
                cookieConsent.style.display = 'none';
            });
        }
        
        if (declineCookies) {
            declineCookies.addEventListener('click', function() {
                setCookie('cookie_consent', 'declined', 365);
                cookieConsent.style.display = 'none';
            });
        }
        
        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = "expires=" + date.toUTCString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        }
    });
    </script>
    
    <?php
    // Track page view if analytics function exists
    if (function_exists('track_page_view')) {
        track_page_view();
    }
    ?>
</body>
</html>  
