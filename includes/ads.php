<?php
/**
 * Advertisement Component
 * 
 * Handles ad placements with:
 * - 2 vertical sidebar ads (300x600)
 * - 2 horizontal banner ads (728x90)
 * - Responsive ad handling
 * - Ad rotation and tracking
 * 
 * @package CalculatorWebsite
 * @version 1.0.0
 */

// Ensure this file is not accessed directly
if (!defined('DB_HOST')) {
    die('Direct access not permitted');
}

/**
 * Display a vertical sidebar advertisement
 * 
 * @param int $position Ad position number (1 or 2)
 * @param string $class Additional CSS classes
 * @return void Outputs ad HTML
 */
function display_vertical_ad($position = 1, $class = '') {
    $ad_id = 'vertical-ad-' . $position;
    $ad_unit = 'vertical-sidebar-' . $position;
    
    ?>
    <div class="ad-container ad-horizontal <?php echo htmlspecialchars($class); ?>" id="<?php echo $ad_id; ?>">
        <div class="ad-label">Advertisement</div>
        <div class="ad-content ad-728x90">
            <?php
            // Check if user has ad blocker or premium subscription
            if (is_ad_free_user()) {
                display_ad_placeholder('horizontal');
            } else {
                // Google AdSense integration
                ?>
                <ins class="adsbygoogle"
                     style="display:inline-block;width:728px;height:90px"
                     data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
                     data-ad-slot="<?php echo get_ad_slot($ad_unit); ?>"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    
    // Track ad impression
    track_ad_impression($ad_unit);
}

/**
 * Display responsive advertisement (adapts to screen size)
 * 
 * @param string $position Position identifier
 * @param string $class Additional CSS classes
 * @return void Outputs ad HTML
 */
function display_responsive_ad($position = 'content', $class = '') {
    $ad_id = 'responsive-ad-' . $position;
    $ad_unit = 'responsive-' . $position;
    
    ?>
    <div class="ad-container ad-responsive <?php echo htmlspecialchars($class); ?>" id="<?php echo $ad_id; ?>">
        <div class="ad-label">Advertisement</div>
        <div class="ad-content">
            <?php
            if (is_ad_free_user()) {
                display_ad_placeholder('responsive');
            } else {
                ?>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
                     data-ad-slot="<?php echo get_ad_slot($ad_unit); ?>"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    
    track_ad_impression($ad_unit);
}

/**
 * Display ad placeholder for premium users or ad blocker detected
 * 
 * @param string $type Ad type (vertical, horizontal, responsive)
 * @return void Outputs placeholder HTML
 */
function display_ad_placeholder($type = 'vertical') {
    $dimensions = [
        'vertical' => ['width' => '300px', 'height' => '600px'],
        'horizontal' => ['width' => '728px', 'height' => '90px'],
        'responsive' => ['width' => '100%', 'height' => '250px']
    ];
    
    $dim = isset($dimensions[$type]) ? $dimensions[$type] : $dimensions['responsive'];
    
    ?>
    <div class="ad-placeholder" style="width: <?php echo $dim['width']; ?>; height: <?php echo $dim['height']; ?>;">
        <div class="placeholder-content">
            <i class="fas fa-ad"></i>
            <p>Thank you for supporting us!</p>
            <?php if (!isset($_SESSION['user_id']) || !is_premium_user()): ?>
            <a href="/premium.php" class="upgrade-link">Go Ad-Free</a>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Check if user is ad-free (premium subscriber or ad blocker)
 * 
 * @return bool True if user should not see ads
 */
function is_ad_free_user() {
    // Check if user is logged in and has premium subscription
    if (isset($_SESSION['user_id'])) {
        return is_premium_user();
    }
    
    // Check if ad blocker is detected (client-side check)
    return false;
}

/**
 * Check if user has premium subscription
 * 
 * @return bool True if user is premium
 */
function is_premium_user() {
    global $conn;
    
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    
    try {
        $stmt = $conn->prepare("
            SELECT premium_until 
            FROM users 
            WHERE id = ? AND premium_until > NOW()
        ");
        $stmt->execute([$_SESSION['user_id']]);
        
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Premium check error: " . $e->getMessage());
        return false;
    }
}

/**
 * Get ad slot ID for specific ad unit
 * 
 * @param string $ad_unit Ad unit identifier
 * @return string Ad slot ID
 */
function get_ad_slot($ad_unit) {
    // Map ad units to Google AdSense slot IDs
    $ad_slots = [
        'vertical-sidebar-1' => '1234567890',
        'vertical-sidebar-2' => '1234567891',
        'horizontal-banner-1' => '1234567892',
        'horizontal-banner-2' => '1234567893',
        'responsive-content' => '1234567894',
        'responsive-footer' => '1234567895'
    ];
    
    return isset($ad_slots[$ad_unit]) ? $ad_slots[$ad_unit] : '0000000000';
}

/**
 * Track ad impression in database
 * 
 * @param string $ad_unit Ad unit identifier
 * @return void
 */
function track_ad_impression($ad_unit) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("
            INSERT INTO ad_impressions (ad_unit, page_url, user_id, ip_address, user_agent, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $page_url = $_SERVER['REQUEST_URI'];
        
        $stmt->execute([$ad_unit, $page_url, $user_id, $ip_address, $user_agent]);
    } catch (PDOException $e) {
        error_log("Ad tracking error: " . $e->getMessage());
    }
}

/**
 * Initialize ad scripts (call in header)
 * 
 * @return void Outputs ad initialization scripts
 */
function init_ad_scripts() {
    if (is_ad_free_user()) {
        return;
    }
    
    ?>
    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXXXXXXXX"
            crossorigin="anonymous"></script>
    
    <!-- Ad Blocker Detection -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Detect ad blocker
        setTimeout(function() {
            const adElement = document.querySelector('.adsbygoogle');
            if (adElement && window.getComputedStyle(adElement).display === 'none') {
                // Ad blocker detected
                document.body.classList.add('ad-blocker-detected');
                
                // Show ad blocker message
                showAdBlockerMessage();
            }
        }, 2000);
    });
    
    function showAdBlockerMessage() {
        const message = document.createElement('div');
        message.className = 'ad-blocker-notice';
        message.innerHTML = `
            <div class="notice-content">
                <i class="fas fa-info-circle"></i>
                <p>We noticed you're using an ad blocker. Ads help us keep Calculator Hub free for everyone.</p>
                <div class="notice-actions">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()">Dismiss</button>
                    <a href="/premium.php" class="btn-premium">Go Premium</a>
                </div>
            </div>
        `;
        document.body.appendChild(message);
    }
    </script>
    <?php
}

/**
 * Display in-content ad (between content sections)
 * 
 * @param string $position Position identifier
 * @return void Outputs ad HTML
 */
function display_incontent_ad($position = 1) {
    ?>
    <div class="ad-incontent">
        <?php display_responsive_ad('incontent-' . $position, 'my-4'); ?>
    </div>
    <?php
}

/**
 * Get ad revenue statistics (for admin dashboard)
 * 
 * @param string $date_from Start date (Y-m-d format)
 * @param string $date_to End date (Y-m-d format)
 * @return array Ad statistics
 */
function get_ad_statistics($date_from = null, $date_to = null) {
    global $conn;
    
    if ($date_from === null) {
        $date_from = date('Y-m-d', strtotime('-30 days'));
    }
    if ($date_to === null) {
        $date_to = date('Y-m-d');
    }
    
    try {
        $stmt = $conn->prepare("
            SELECT 
                ad_unit,
                COUNT(*) as impressions,
                COUNT(DISTINCT ip_address) as unique_views,
                DATE(created_at) as date
            FROM ad_impressions
            WHERE DATE(created_at) BETWEEN ? AND ?
            GROUP BY ad_unit, DATE(created_at)
            ORDER BY date DESC, impressions DESC
        ");
        
        $stmt->execute([$date_from, $date_to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Ad statistics error: " . $e->getMessage());
        return [];
    }
}
?><div class="ad-container ad-vertical <?php echo htmlspecialchars($class); ?>" id="<?php echo $ad_id; ?>">
        <div class="ad-label">Advertisement</div>
        <div class="ad-content ad-300x600">
            <?php
            // Check if user has ad blocker or premium subscription
            if (is_ad_free_user()) {
                display_ad_placeholder('vertical');
            } else {
                // Google AdSense integration
                ?>
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:600px"
                     data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
                     data-ad-slot="<?php echo get_ad_slot($ad_unit); ?>"
                     data-ad-format="auto"
                     data-full-width-responsive="false"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    
    // Track ad impression
    track_ad_impression($ad_unit);
}

/**
 * Display a horizontal banner advertisement
 * 
 * @param int $position Ad position number (1 or 2)
 * @param string $class Additional CSS classes
 * @return void Outputs ad HTML
 */
function display_horizontal_ad($position = 1, $class = '') {
    $ad_id = 'horizontal-ad-' . $position;
    $ad_unit = 'horizontal-banner-' . $position;
    
    ?>  
