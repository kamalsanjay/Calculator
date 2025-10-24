<?php
/**
 * Sidebar Component
 * 
 * Displays sidebar with:
 * - Related calculators widget
 * - Popular calculators list
 * - Recent calculations (for logged-in users)
 * - Ad placements
 * - Quick links
 * 
 * @package CalculatorWebsite
 * @version 1.0.0
 */

// Ensure this file is not accessed directly
if (!defined('DB_HOST')) {
    die('Direct access not permitted');
}

// Get current calculator info if on calculator page
$current_calculator = isset($calculator_slug) ? $calculator_slug : '';
$current_category = isset($category) ? $category : '';
?>

<aside class="sidebar" role="complementary" aria-label="Sidebar">
    
    <!-- Vertical Ad #1 -->
    <div class="sidebar-section ad-section">
        <?php display_vertical_ad(1, 'mb-4'); ?>
    </div>
    
    <!-- Related Calculators Widget -->
    <?php if (!empty($current_calculator) || !empty($current_category)): ?>
    <div class="sidebar-section related-calculators">
        <h3 class="sidebar-title">
            <i class="fas fa-link"></i> Related Calculators
        </h3>
        <div class="sidebar-content">
            <?php
            $related = get_related_calculators($current_calculator, $current_category, 5);
            if (!empty($related)):
            ?>
            <ul class="calculator-list">
                <?php foreach ($related as $calc): ?>
                <li class="calculator-item">
                    <a href="/calculator/<?php echo htmlspecialchars($calc['slug']); ?>" class="calculator-link">
                        <div class="calculator-icon">
                            <i class="fas <?php echo htmlspecialchars($calc['icon']); ?>"></i>
                        </div>
                        <div class="calculator-info">
                            <h4><?php echo htmlspecialchars($calc['name']); ?></h4>
                            <p class="calculator-category"><?php echo htmlspecialchars($calc['category']); ?></p>
                        </div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p class="no-results">No related calculators found.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Popular Calculators Widget -->
    <div class="sidebar-section popular-calculators">
        <h3 class="sidebar-title">
            <i class="fas fa-fire"></i> Popular Calculators
        </h3>
        <div class="sidebar-content">
            <?php
            $popular = get_popular_calculators(8);
            if (!empty($popular)):
            ?>
            <ul class="popular-list">
                <?php foreach ($popular as $index => $calc): ?>
                <li class="popular-item">
                    <a href="/calculator/<?php echo htmlspecialchars($calc['slug']); ?>" class="popular-link">
                        <span class="popular-rank"><?php echo $index + 1; ?></span>
                        <div class="popular-icon">
                            <i class="fas <?php echo htmlspecialchars($calc['icon']); ?>"></i>
                        </div>
                        <div class="popular-info">
                            <h4><?php echo htmlspecialchars($calc['name']); ?></h4>
                            <p class="popular-stats">
                                <i class="fas fa-users"></i> 
                                <?php echo format_number_short($calc['uses']); ?> uses
                            </p>
                        </div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p class="no-results">No popular calculators available.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Vertical Ad #2 -->
    <div class="sidebar-section ad-section">
        <?php display_vertical_ad(2, 'mb-4'); ?>
    </div>
    
    <!-- Recent Calculations Widget (Only for logged-in users) -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="sidebar-section recent-calculations">
        <h3 class="sidebar-title">
            <i class="fas fa-history"></i> Recent Calculations
        </h3>
        <div class="sidebar-content">
            <?php
            $recent = get_recent_calculations(5);
            if (!empty($recent)):
            ?>
            <ul class="recent-list">
                <?php foreach ($recent as $calc): ?>
                <li class="recent-item">
                    <a href="/saved-calculations.php?id=<?php echo $calc['id']; ?>" class="recent-link">
                        <div class="recent-icon">
                            <i class="fas <?php echo htmlspecialchars($calc['icon']); ?>"></i>
                        </div>
                        <div class="recent-info">
                            <h4><?php echo htmlspecialchars($calc['calculator_name']); ?></h4>
                            <p class="recent-time">
                                <i class="fas fa-clock"></i> 
                                <?php echo time_elapsed($calc['created_at']); ?>
                            </p>
                        </div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="recent-footer">
                <a href="/saved-calculations.php" class="view-all-link">
                    View All Saved <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php else: ?>
            <p class="no-results">No recent calculations.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Categories Quick Links Widget -->
    <div class="sidebar-section category-links">
        <h3 class="sidebar-title">
            <i class="fas fa-th-large"></i> Browse Categories
        </h3>
        <div class="sidebar-content">
            <ul class="category-list">
                <?php
                $categories = [
                    ['name' => 'Math', 'slug' => 'math', 'icon' => 'fa-calculator', 'count' => 15],
                    ['name' => 'Finance', 'slug' => 'finance', 'icon' => 'fa-dollar-sign', 'count' => 18],
                    ['name' => 'Health', 'slug' => 'health', 'icon' => 'fa-heartbeat', 'count' => 12],
                    ['name' => 'Conversion', 'slug' => 'conversion', 'icon' => 'fa-exchange-alt', 'count' => 20],
                    ['name' => 'Date & Time', 'slug' => 'date', 'icon' => 'fa-calendar-alt', 'count' => 10],
                    ['name' => 'Statistics', 'slug' => 'statistics', 'icon' => 'fa-chart-bar', 'count' => 14],
                ];
                
                foreach ($categories as $cat):
                ?>
                <li class="category-item">
                    <a href="/category/<?php echo $cat['slug']; ?>" class="category-link">
                        <i class="fas <?php echo $cat['icon']; ?>"></i>
                        <span class="category-name"><?php echo $cat['name']; ?></span>
                        <span class="category-count"><?php echo $cat['count']; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="category-footer">
                <a href="/categories.php" class="view-all-link">
                    View All Categories <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Newsletter Signup Widget -->
    <div class="sidebar-section newsletter-widget">
        <h3 class="sidebar-title">
            <i class="fas fa-envelope"></i> Stay Updated
        </h3>
        <div class="sidebar-content">
            <p class="newsletter-text">Get the latest calculators and updates delivered to your inbox.</p>
            <form action="/api/newsletter-signup.php" method="POST" class="sidebar-newsletter-form" id="sidebarNewsletterForm">
                <div class="form-group">
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control" 
                        placeholder="Your email address" 
                        required
                        aria-label="Email for newsletter"
                    >
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane"></i> Subscribe
                </button>
                <div class="newsletter-response" style="display: none;"></div>
            </form>
        </div>
    </div>
    
    <!-- Help & Support Widget -->
    <div class="sidebar-section help-widget">
        <h3 class="sidebar-title">
            <i class="fas fa-question-circle"></i> Need Help?
        </h3>
        <div class="sidebar-content">
            <ul class="help-links">
                <li>
                    <a href="/faq.php">
                        <i class="fas fa-book"></i> FAQ
                    </a>
                </li>
                <li>
                    <a href="/tutorials.php">
                        <i class="fas fa-graduation-cap"></i> Tutorials
                    </a>
                </li>
                <li>
                    <a href="/contact.php">
                        <i class="fas fa-envelope"></i> Contact Us
                    </a>
                </li>
                <li>
                    <a href="/feedback.php">
                        <i class="fas fa-comment-dots"></i> Send Feedback
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Premium Upgrade Banner (Only for non-premium users) -->
    <?php if (!isset($_SESSION['user_id']) || !is_premium_user()): ?>
    <div class="sidebar-section premium-banner">
        <div class="premium-content">
            <div class="premium-icon">
                <i class="fas fa-crown"></i>
            </div>
            <h3>Go Premium!</h3>
            <p>Unlock ad-free experience, save unlimited calculations, and get priority support.</p>
            <a href="/premium.php" class="btn btn-premium">
                <i class="fas fa-star"></i> Upgrade Now
            </a>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Social Share Widget (Only on calculator pages) -->
    <?php if (!empty($current_calculator)): ?>
    <div class="sidebar-section social-share">
        <h3 class="sidebar-title">
            <i class="fas fa-share-alt"></i> Share This Calculator
        </h3>
        <div class="sidebar-content">
            <div class="share-buttons">
                <a href="#" class="share-btn facebook" onclick="shareOnFacebook(); return false;" aria-label="Share on Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="share-btn twitter" onclick="shareOnTwitter(); return false;" aria-label="Share on Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="share-btn linkedin" onclick="shareOnLinkedIn(); return false;" aria-label="Share on LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="share-btn whatsapp" onclick="shareOnWhatsApp(); return false;" aria-label="Share on WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <button class="share-btn copy-link" onclick="copyLink(); return false;" aria-label="Copy link">
                    <i class="fas fa-link"></i>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
</aside>

<?php
/**
 * Get related calculators based on current calculator or category
 * 
 * @param string $calculator_slug Current calculator slug
 * @param string $category Current category
 * @param int $limit Number of calculators to retrieve
 * @return array Array of related calculators
 */
function get_related_calculators($calculator_slug, $category, $limit = 5) {
    global $conn;
    
    try {
        if (!empty($calculator_slug)) {
            // Get calculators from same category, excluding current
            $stmt = $conn->prepare("
                SELECT c.*, COALESCE(cs.total_uses, 0) as uses
                FROM calculators c
                LEFT JOIN calculator_stats cs ON c.slug = cs.calculator_slug
                WHERE c.category = (
                    SELECT category FROM calculators WHERE slug = ?
                )
                AND c.slug != ?
                AND c.status = 'active'
                ORDER BY uses DESC
                LIMIT ?
            ");
            $stmt->execute([$calculator_slug, $calculator_slug, $limit]);
        } elseif (!empty($category)) {
            // Get calculators from specified category
            $stmt = $conn->prepare("
                SELECT c.*, COALESCE(cs.total_uses, 0) as uses
                FROM calculators c
                LEFT JOIN calculator_stats cs ON c.slug = cs.calculator_slug
                WHERE c.category = ?
                AND c.status = 'active'
                ORDER BY uses DESC
                LIMIT ?
            ");
            $stmt->execute([$category, $limit]);
        } else {
            return [];
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Get related calculators error: " . $e->getMessage());
        return [];
    }
}
?>

<script>
// Sidebar Newsletter Form Submission
document.addEventListener('DOMContentLoaded', function() {
    const sidebarForm = document.getElementById('sidebarNewsletterForm');
    
    if (sidebarForm) {
        sidebarForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const responseDiv = this.querySelector('.newsletter-response');
            const submitBtn = this.querySelector('button[type="submit"]');
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';
            
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
                    sidebarForm.reset();
                }
            })
            .catch(error => {
                responseDiv.style.display = 'block';
                responseDiv.className = 'newsletter-response error';
                responseDiv.textContent = 'An error occurred. Please try again.';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Subscribe';
                
                setTimeout(() => {
                    responseDiv.style.display = 'none';
                }, 5000);
            });
        });
    }
});

// Social Share Functions
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, 'facebook-share', 'width=600,height=400');
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent(document.title);
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, 'twitter-share', 'width=600,height=400');
}

function shareOnLinkedIn() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, 'linkedin-share', 'width=600,height=400');
}

function shareOnWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent(document.title);
    window.open(`https://wa.me/?text=${text}%20${url}`, 'whatsapp-share');
}

function copyLink() {
    const url = window.location.href;
    
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(() => {
            showCopyNotification('Link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy:', err);
            fallbackCopyLink(url);
        });
    } else {
        fallbackCopyLink(url);
    }
}

function fallbackCopyLink(url) {
    const textArea = document.createElement('textarea');
    textArea.value = url;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    document.body.appendChild(textArea);
    textArea.select();
    
    try {
        document.execCommand('copy');
        showCopyNotification('Link copied to clipboard!');
    } catch (err) {
        console.error('Fallback copy failed:', err);
        showCopyNotification('Failed to copy link', 'error');
    }
    
    document.body.removeChild(textArea);
}

function showCopyNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `copy-notification ${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : 'times'}-circle"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>

<style>
/* Copy Notification Styles */
.copy-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #28a745;
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 10000;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.copy-notification.show {
    opacity: 1;
    transform: translateY(0);
}

.copy-notification.error {
    background: #dc3545;
}

.copy-notification i {
    font-size: 18px;
}
</style>  
