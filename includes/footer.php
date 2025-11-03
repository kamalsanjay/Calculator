</main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-container">
            <!-- Footer Top -->
            <div class="footer-content">
                <!-- About Column -->
                <div class="footer-column footer-about">
                    <div class="footer-brand">
                        <i class="fas fa-calculator"></i>
                        <span>Calculator</span>
                    </div>
                    <p>Your trusted source for free online calculators. Access 300+ professional calculation tools for finance, health, math, and more.</p>
                    
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo SITE_URL; ?>">Home</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/about.php">About Us</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contact.php">Contact</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/blog.php">Blog</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/faq.php">FAQ</a></li>
                    </ul>
                </div>

                <!-- Popular Categories -->
                <div class="footer-column">
                    <h3>Popular Categories</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo SITE_URL; ?>/calculators/financial/">Financial Calculators</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/calculators/health/">Health Calculators</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/calculators/math/">Math Calculators</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/calculators/conversion/">Conversion Tools</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/calculators/sports/">Sports Calculators</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="footer-column">
                    <h3>Stay Updated</h3>
                    <p>Subscribe to our newsletter for updates and new calculators.</p>
                    <form class="newsletter-form" id="newsletterForm">
                        <input type="email" 
                               class="newsletter-input" 
                               placeholder="Your email address" 
                               required>
                        <button type="submit" class="newsletter-button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                    <p class="newsletter-note">We respect your privacy. Unsubscribe anytime.</p>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="footer-copyright">
                    <p>&copy; <?php echo date('Y'); ?> <strong>Calculator</strong>. All rights reserved.</p>
                    <p class="footer-tagline">Making calculations simple and accessible for everyone</p>
                </div>
                <ul class="footer-legal">
                    <li><a href="<?php echo SITE_URL; ?>/privacy.php">Privacy Policy</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/terms.php">Terms of Service</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/disclaimer.php">Disclaimer</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/sitemap.php">Sitemap</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>
</html>