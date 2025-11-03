<?php
// Get current page
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<aside class="sidebar">
    <div class="sidebar-header">
        <a href="<?php echo SITE_URL; ?>/admin/" class="sidebar-logo">
            <i class="fas fa-calculator"></i>
            <div class="sidebar-logo-text">
                <span class="logo-title">Calculator</span>
                <span class="logo-subtitle">Admin Panel</span>
            </div>
        </a>
    </div>
    
    <nav class="sidebar-menu">
        <ul>
            <li class="menu-item <?php echo $current_page === 'index' ? 'active' : ''; ?>">
                <a href="<?php echo SITE_URL; ?>/admin/index.php">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="menu-item <?php echo $current_page === 'calculators' ? 'active' : ''; ?>">
                <a href="<?php echo SITE_URL; ?>/admin/calculators.php">
                    <i class="fas fa-calculator"></i>
                    <span>Calculators</span>
                </a>
            </li>
            
            <li class="menu-item <?php echo $current_page === 'categories' ? 'active' : ''; ?>">
                <a href="<?php echo SITE_URL; ?>/admin/categories.php">
                    <i class="fas fa-folder"></i>
                    <span>Categories</span>
                </a>
            </li>
            
            <li class="menu-item <?php echo $current_page === 'users' ? 'active' : ''; ?>">
                <a href="<?php echo SITE_URL; ?>/admin/users.php">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            
            <li class="menu-item <?php echo $current_page === 'analytics' ? 'active' : ''; ?>">
                <a href="<?php echo SITE_URL; ?>/admin/analytics.php">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </a>
            </li>
            
            <li class="menu-item <?php echo $current_page === 'contact-messages' ? 'active' : ''; ?>">
                <a href="<?php echo SITE_URL; ?>/admin/contact-messages.php">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Messages</span>
                </a>
            </li>

            <!-- <li class="menu-item <?php echo $current_page === 'settings' ? 'active' : ''; ?>">
                <a href="<?php echo SITE_URL; ?>/admin/settings.php">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li> -->

            <li class="menu-item <?php echo $current_page === 'site-settings' ? 'active' : ''; ?>">
                <a href="<?php echo SITE_URL; ?>/admin/site-settings.php">
                    <i class="fas fa-cog"></i>
                    <span>Site Settings</span>
                </a>
            </li>

            
        </ul>
        
        <div class="sidebar-footer">
            <a href="<?php echo SITE_URL; ?>/admin/logout.php" class="menu-item logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </nav>
</aside>