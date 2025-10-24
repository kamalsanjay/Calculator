<?php
/**
 * Header Component
 * 
 * Displays the main site header with:
 * - Sticky navigation bar
 * - Logo and site branding
 * - Search bar with autocomplete
 * - Theme toggle
 * - Mobile hamburger menu
 * - Dynamic breadcrumbs
 * 
 * @package CalculatorWebsite
 * @version 1.0.0
 */

// Ensure this file is not accessed directly
if (!defined('DB_HOST')) {
    die('Direct access not permitted');
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <?php 
    // Include dynamic meta tags
    if (function_exists('generate_meta_tags')) {
        generate_meta_tags();
    }
    ?>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png">
    
    <!-- Preconnect to external domains for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <!-- Theme Styles -->
    <style>
        :root[data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --border-color: #dee2e6;
            --primary-color: #007bff;
            --primary-hover: #0056b3;
        }
        
        :root[data-theme="dark"] {
            --bg-primary: #1a1a1a;
            --bg-secondary: #2d2d2d;
            --text-primary: #f8f9fa;
            --text-secondary: #adb5bd;
            --border-color: #495057;
            --primary-color: #0d6efd;
            --primary-hover: #0a58ca;
        }
    </style>
</head>
<body>
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
    <!-- Header Section -->
    <header class="site-header" role="banner">
        <!-- Top Bar (Optional - for announcements) -->
        <div class="top-bar">
            <div class="container">
                <div class="top-bar-content">
                    <span class="announcement">
                        <i class="fas fa-info-circle"></i> 
                        Welcome to Calculator Hub - Your One-Stop Solution for All Calculations!
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation Bar -->
        <nav class="navbar sticky-nav" role="navigation" aria-label="Main Navigation">
            <div class="container">
                <div class="navbar-wrapper">
                    <!-- Logo and Site Name -->
                    <div class="navbar-brand">
                        <a href="/" class="logo-link" aria-label="Calculator Hub Home">
                            <img src="/assets/images/logo.svg" alt="Calculator Hub Logo" class="logo-image">
                            <span class="site-name">Calculator<span class="highlight">Hub</span></span>
                        </a>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="navbar-search">
                        <form action="/search.php" method="GET" class="search-form" role="search">
                            <div class="search-input-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input 
                                    type="search" 
                                    name="q" 
                                    id="searchInput"
                                    class="search-input" 
                                    placeholder="Search calculators..." 
                                    autocomplete="off"
                                    aria-label="Search calculators"
                                    required
                                >
                                <button type="submit" class="search-submit" aria-label="Submit search">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                            <!-- Autocomplete Results -->
                            <div id="searchResults" class="search-results" style="display: none;"></div>
                        </form>
                    </div>
                    
                    <!-- Navigation Actions -->
                    <div class="navbar-actions">
                        <!-- Theme Toggle -->
                        <button 
                            id="themeToggle" 
                            class="theme-toggle" 
                            aria-label="Toggle dark mode"
                            title="Toggle theme"
                        >
                            <i class="fas fa-moon dark-icon"></i>
                            <i class="fas fa-sun light-icon"></i>
                        </button>
                        
                        <!-- User Menu (if logged in) -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user-menu">
                            <button class="user-button" aria-label="User menu" aria-haspopup="true">
                                <i class="fas fa-user-circle"></i>
                            </button>
                            <div class="user-dropdown">
                                <a href="/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                                <a href="/saved-calculations.php"><i class="fas fa-bookmark"></i> Saved</a>
                                <a href="/profile.php"><i class="fas fa-user-cog"></i> Profile</a>
                                <hr>
                                <a href="/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </div>
                        <?php else: ?>
                        <a href="/login.php" class="login-btn">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <?php endif; ?>
                        
                        <!-- Mobile Menu Toggle -->
                        <button 
                            id="mobileMenuToggle" 
                            class="mobile-menu-toggle" 
                            aria-label="Toggle mobile menu"
                            aria-expanded="false"
                            aria-controls="mobileMenu"
                        >
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </button>
                    </div>
                </div>
                
                <!-- Main Navigation Menu -->
                <?php include 'navigation.php'; ?>
            </div>
        </nav>
    </header>
    
    <!-- Breadcrumbs -->
    <?php if (function_exists('generate_breadcrumb') && !isset($hide_breadcrumb)): ?>
    <div class="breadcrumb-wrapper">
        <div class="container">
            <?php echo generate_breadcrumb(); ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Main Content Wrapper -->
    <main id="main-content" class="main-content" role="main">
    
    <script>
    // Theme Toggle Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        
        // Load saved theme preference
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        
        themeToggle.addEventListener('click', function() {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
        
        // Search Autocomplete
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                searchResults.style.display = 'none';
                return;
            }
            
            searchTimeout = setTimeout(() => {
                fetch(`/api/search-autocomplete.php?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.results && data.results.length > 0) {
                            displaySearchResults(data.results);
                        } else {
                            searchResults.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                    });
            }, 300);
        });
        
        function displaySearchResults(results) {
            let html = '<ul class="autocomplete-list">';
            results.forEach(result => {
                html += `
                    <li class="autocomplete-item">
                        <a href="${result.url}">
                            <i class="${result.icon}"></i>
                            <span class="result-name">${result.name}</span>
                            <span class="result-category">${result.category}</span>
                        </a>
                    </li>
                `;
            });
            html += '</ul>';
            searchResults.innerHTML = html;
            searchResults.style.display = 'block';
        }
        
        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
        
        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                this.classList.toggle('active');
                mobileMenu.classList.toggle('active');
                document.body.classList.toggle('menu-open');
            });
        }
    });
    </script>