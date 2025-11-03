<?php
/**
 * Advertisement Placements
 * Easy integration for AdSense, Adsterra, or any ad network
 */

// Ad Configuration
$ads_enabled = true; // Set to false to disable all ads

/**
 * Display Ad based on position
 * 
 * @param string $position Ad position (header, sidebar-top, sidebar-bottom, content-top, content-middle, content-bottom, footer)
 */
function display_ad($position) {
    global $ads_enabled;
    
    if (!$ads_enabled) {
        return;
    }
    
    $ad_class = "ad-container ad-{$position}";
    
    echo "<div class=\"{$ad_class}\">";
    
    switch ($position) {
        case 'header':
            // Header Banner - 728x90 (Leaderboard)
            echo get_header_ad();
            break;
            
        case 'sidebar-top':
            // Sidebar Top - 300x250 (Medium Rectangle)
            echo get_sidebar_top_ad();
            break;
            
        case 'sidebar-middle':
            // Sidebar Middle - 300x600 (Half Page)
            echo get_sidebar_middle_ad();
            break;
            
        case 'sidebar-bottom':
            // Sidebar Bottom - 300x250 (Medium Rectangle)
            echo get_sidebar_bottom_ad();
            break;
            
        case 'content-top':
            // Above Content - 728x90 (Leaderboard)
            echo get_content_top_ad();
            break;
            
        case 'content-middle':
            // Middle of Content - 336x280 (Large Rectangle)
            echo get_content_middle_ad();
            break;
            
        case 'content-bottom':
            // Below Content - 728x90 (Leaderboard)
            echo get_content_bottom_ad();
            break;
            
        case 'footer':
            // Footer Banner - 970x90 (Large Leaderboard)
            echo get_footer_ad();
            break;
            
        case 'mobile-sticky':
            // Mobile Sticky Bottom - 320x50 (Mobile Banner)
            echo get_mobile_sticky_ad();
            break;
    }
    
    echo "</div>";
}

// ==================== HEADER AD (728x90) ====================
function get_header_ad() {
    return '
    <!-- Header Ad - 728x90 Leaderboard -->
    <div class="ad-placeholder" style="width: 728px; height: 90px; margin: 0 auto;">
        <!-- PASTE YOUR AD CODE HERE -->
        <!-- Example: Google AdSense -->
        <!--
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
             data-ad-slot="XXXXXXXXXX"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        -->
        
        <!-- Example: Adsterra Banner -->
        <!--
        <script type="text/javascript">
            atOptions = {
                "key" : "YOUR_KEY_HERE",
                "format" : "iframe",
                "height" : 90,
                "width" : 728,
                "params" : {}
            };
        </script>
        <script type="text/javascript" src="//www.topcreativeformat.com/YOUR_ID/invoke.js"></script>
        -->
        
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; height: 100%;">
            728x90 Ad Space
        </div>
    </div>
    ';
}

// ==================== SIDEBAR TOP AD (300x250) ====================
function get_sidebar_top_ad() {
    return '
    <!-- Sidebar Top Ad - 300x250 Medium Rectangle -->
    <div class="ad-placeholder" style="width: 300px; height: 250px;">
        <!-- PASTE YOUR AD CODE HERE -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; height: 100%;">
            300x250 Ad Space
        </div>
    </div>
    ';
}

// ==================== SIDEBAR MIDDLE AD (300x600) ====================
function get_sidebar_middle_ad() {
    return '
    <!-- Sidebar Middle Ad - 300x600 Half Page -->
    <div class="ad-placeholder" style="width: 300px; height: 600px;">
        <!-- PASTE YOUR AD CODE HERE -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; height: 100%;">
            300x600 Ad Space
        </div>
    </div>
    ';
}

// ==================== SIDEBAR BOTTOM AD (300x250) ====================
function get_sidebar_bottom_ad() {
    return '
    <!-- Sidebar Bottom Ad - 300x250 Medium Rectangle -->
    <div class="ad-placeholder" style="width: 300px; height: 250px;">
        <!-- PASTE YOUR AD CODE HERE -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; height: 100%;">
            300x250 Ad Space
        </div>
    </div>
    ';
}

// ==================== CONTENT TOP AD (728x90) ====================
function get_content_top_ad() {
    return '
    <!-- Content Top Ad - 728x90 Leaderboard -->
    <div class="ad-placeholder" style="width: 728px; height: 90px; margin: 20px auto;">
        <!-- PASTE YOUR AD CODE HERE -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; height: 100%;">
            728x90 Ad Space
        </div>
    </div>
    ';
}

// ==================== CONTENT MIDDLE AD (336x280) ====================
function get_content_middle_ad() {
    return '
    <!-- Content Middle Ad - 336x280 Large Rectangle -->
    <div class="ad-placeholder" style="width: 336px; height: 280px; margin: 20px auto;">
        <!-- PASTE YOUR AD CODE HERE -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; height: 100%;">
            336x280 Ad Space
        </div>
    </div>
    ';
}

// ==================== CONTENT BOTTOM AD (728x90) ====================
function get_content_bottom_ad() {
    return '
    <!-- Content Bottom Ad - 728x90 Leaderboard -->
    <div class="ad-placeholder" style="width: 728px; height: 90px; margin: 20px auto;">
        <!-- PASTE YOUR AD CODE HERE -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; height: 100%;">
            728x90 Ad Space
        </div>
    </div>
    ';
}

// ==================== FOOTER AD (970x90) ====================
function get_footer_ad() {
    return '
    <!-- Footer Ad - 970x90 Large Leaderboard -->
    <div class="ad-placeholder" style="width: 970px; height: 90px; margin: 0 auto;">
        <!-- PASTE YOUR AD CODE HERE -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; height: 100%;">
            970x90 Ad Space
        </div>
    </div>
    ';
}

// ==================== MOBILE STICKY AD (320x50) ====================
function get_mobile_sticky_ad() {
    return '
    <!-- Mobile Sticky Bottom Ad - 320x50 Mobile Banner -->
    <div class="ad-placeholder mobile-sticky-ad" style="width: 320px; height: 50px;">
        <!-- PASTE YOUR AD CODE HERE -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; height: 100%;">
            320x50 Mobile Ad
        </div>
    </div>
    ';
}
?>

<style>
/* Ad Container Styles */
.ad-container {
    margin: 1.5rem 0;
    text-align: center;
    overflow: hidden;
}

.ad-placeholder {
    margin: 0 auto;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Responsive Ads */
@media (max-width: 768px) {
    .ad-header,
    .ad-content-top,
    .ad-content-bottom,
    .ad-footer {
        display: none;
    }
}

/* Mobile Sticky Ad */
.mobile-sticky-ad {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    z-index: 999;
    display: none;
}

@media (max-width: 768px) {
    .mobile-sticky-ad {
        display: block;
    }
}

/* Sidebar Ads */
.ad-sidebar-top,
.ad-sidebar-middle,
.ad-sidebar-bottom {
    margin: 2rem 0;
}

@media (max-width: 1024px) {
    .ad-sidebar-middle {
        display: none;
    }
}
</style>