<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Calculator - Free Online Calculators'; ?></title>
    <meta name="description" content="<?php echo $page_description ?? 'Professional online calculators'; ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/footer.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <div class="header-container">
                <!-- Logo -->
                <a href="<?php echo SITE_URL; ?>" class="site-logo">
                    <i class="fas fa-calculator"></i>
                    <span>Calculator</span>
                </a>
                
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Open Menu">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Navigation -->
                <nav class="main-nav" id="mainNav">
                    <!-- Mobile Close Button -->
                    <button class="mobile-close" id="mobileClose" aria-label="Close Menu">
                        <i class="fas fa-times"></i>
                    </button>
                    
                    <!-- Search Bar (Mobile First) -->
                    <div class="header-search">
                        <input type="text" 
                               id="searchInput" 
                               class="search-input" 
                               placeholder="Search calculators...">
                        <button class="search-button" id="searchButton">
                            <i class="fas fa-search"></i>
                        </button>
                        <div class="search-results" id="searchResults"></div>
                    </div>
                    
                    <!-- Menu Items -->
                    <ul class="nav-menu">
                        <li>
                            <a href="<?php echo SITE_URL; ?>" class="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
                                <i class="fas fa-home"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li class="has-dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle">
                                <i class="fas fa-th"></i>
                                <span>Categories</span>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="nav-dropdown">
                                <li><a href="<?php echo SITE_URL; ?>/calculators/financial/"><i class="fas fa-dollar-sign"></i> Financial</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/health/"><i class="fas fa-heartbeat"></i> Health & Fitness</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/math/"><i class="fas fa-square-root-alt"></i> Math</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/conversion/"><i class="fas fa-exchange-alt"></i> Conversion</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/date-time/"><i class="fas fa-calendar-alt"></i> Date & Time</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/construction/"><i class="fas fa-hammer"></i> Construction</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/electronics/"><i class="fas fa-bolt"></i> Electronics</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/automotive/"><i class="fas fa-car"></i> Automotive</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/education/"><i class="fas fa-graduation-cap"></i> Education</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/utility/"><i class="fas fa-tools"></i> Utility</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/weather/"><i class="fas fa-cloud-sun"></i> Weather</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/cooking/"><i class="fas fa-utensils"></i> Cooking</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/gaming/"><i class="fas fa-gamepad"></i> Gaming</a></li>
                                <li><a href="<?php echo SITE_URL; ?>/calculators/sports/"><i class="fas fa-running"></i> Sports</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo SITE_URL; ?>/about.php">
                                <i class="fas fa-info-circle"></i>
                                <span>About</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SITE_URL; ?>/contact.php">
                                <i class="fas fa-envelope"></i>
                                <span>Contact</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Mobile Overlay -->
                <div class="mobile-overlay" id="mobileOverlay"></div>
            </div>
        </div>
    </header>