<?php
/**
 * Navigation Component
 * 
 * Main navigation menu with:
 * - Category dropdown menus (14 categories)
 * - Active page highlighting
 * - Responsive mobile menu
 * - Accessibility features
 * 
 * @package CalculatorWebsite
 * @version 1.0.0
 */

// Ensure this file is not accessed directly
if (!defined('DB_HOST')) {
    die('Direct access not permitted');
}

// Get current page for active state
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$current_category = isset($_GET['category']) ? $_GET['category'] : '';

/**
 * Check if navigation item is active
 * 
 * @param string $page Page identifier
 * @return string Active class if current page matches
 */
function is_nav_active($page) {
    global $current_page, $current_category;
    if ($current_page === $page || $current_category === $page) {
        return 'active';
    }
    return '';
}

// Define navigation categories with their calculators
$nav_categories = [
    [
        'id' => 'math',
        'name' => 'Math',
        'icon' => 'fa-calculator',
        'url' => '/category/math',
        'description' => 'Mathematical calculators and tools',
        'items' => [
            ['name' => 'Basic Calculator', 'url' => '/calculator/basic', 'icon' => 'fa-plus-minus'],
            ['name' => 'Scientific Calculator', 'url' => '/calculator/scientific', 'icon' => 'fa-square-root-alt'],
            ['name' => 'Percentage Calculator', 'url' => '/calculator/percentage', 'icon' => 'fa-percent'],
            ['name' => 'Fraction Calculator', 'url' => '/calculator/fraction', 'icon' => 'fa-divide'],
            ['name' => 'Algebra Calculator', 'url' => '/calculator/algebra', 'icon' => 'fa-x'],
        ]
    ],
    [
        'id' => 'finance',
        'name' => 'Finance',
        'icon' => 'fa-dollar-sign',
        'url' => '/category/finance',
        'description' => 'Financial planning and investment tools',
        'items' => [
            ['name' => 'Loan Calculator', 'url' => '/calculator/loan', 'icon' => 'fa-money-bill-wave'],
            ['name' => 'Mortgage Calculator', 'url' => '/calculator/mortgage', 'icon' => 'fa-home'],
            ['name' => 'Investment Calculator', 'url' => '/calculator/investment', 'icon' => 'fa-chart-line'],
            ['name' => 'Salary Calculator', 'url' => '/calculator/salary', 'icon' => 'fa-wallet'],
            ['name' => 'Tax Calculator', 'url' => '/calculator/tax', 'icon' => 'fa-file-invoice-dollar'],
        ]
    ],
    [
        'id' => 'health',
        'name' => 'Health',
        'icon' => 'fa-heartbeat',
        'url' => '/category/health',
        'description' => 'Health and fitness calculators',
        'items' => [
            ['name' => 'BMI Calculator', 'url' => '/calculator/bmi', 'icon' => 'fa-weight'],
            ['name' => 'Calorie Calculator', 'url' => '/calculator/calorie', 'icon' => 'fa-fire'],
            ['name' => 'Pregnancy Calculator', 'url' => '/calculator/pregnancy', 'icon' => 'fa-baby'],
            ['name' => 'Body Fat Calculator', 'url' => '/calculator/body-fat', 'icon' => 'fa-user'],
            ['name' => 'BMR Calculator', 'url' => '/calculator/bmr', 'icon' => 'fa-running'],
        ]
    ],
    [
        'id' => 'conversion',
        'name' => 'Conversion',
        'icon' => 'fa-exchange-alt',
        'url' => '/category/conversion',
        'description' => 'Unit conversion tools',
        'items' => [
            ['name' => 'Length Converter', 'url' => '/calculator/length', 'icon' => 'fa-ruler'],
            ['name' => 'Weight Converter', 'url' => '/calculator/weight', 'icon' => 'fa-balance-scale'],
            ['name' => 'Temperature Converter', 'url' => '/calculator/temperature', 'icon' => 'fa-thermometer-half'],
            ['name' => 'Currency Converter', 'url' => '/calculator/currency', 'icon' => 'fa-coins'],
            ['name' => 'Speed Converter', 'url' => '/calculator/speed', 'icon' => 'fa-tachometer-alt'],
        ]
    ],
    [
        'id' => 'date',
        'name' => 'Date & Time',
        'icon' => 'fa-calendar-alt',
        'url' => '/category/date',
        'description' => 'Date and time calculators',
        'items' => [
            ['name' => 'Age Calculator', 'url' => '/calculator/age', 'icon' => 'fa-birthday-cake'],
            ['name' => 'Date Difference', 'url' => '/calculator/date-difference', 'icon' => 'fa-calendar-minus'],
            ['name' => 'Time Calculator', 'url' => '/calculator/time', 'icon' => 'fa-clock'],
            ['name' => 'Work Hours Calculator', 'url' => '/calculator/work-hours', 'icon' => 'fa-business-time'],
            ['name' => 'Countdown Timer', 'url' => '/calculator/countdown', 'icon' => 'fa-hourglass-half'],
        ]
    ],
    [
        'id' => 'statistics',
        'name' => 'Statistics',
        'icon' => 'fa-chart-bar',
        'url' => '/category/statistics',
        'description' => 'Statistical analysis tools',
        'items' => [
            ['name' => 'Mean Calculator', 'url' => '/calculator/mean', 'icon' => 'fa-chart-line'],
            ['name' => 'Standard Deviation', 'url' => '/calculator/standard-deviation', 'icon' => 'fa-chart-area'],
            ['name' => 'Probability Calculator', 'url' => '/calculator/probability', 'icon' => 'fa-dice'],
            ['name' => 'Percentage Change', 'url' => '/calculator/percentage-change', 'icon' => 'fa-percent'],
            ['name' => 'Ratio Calculator', 'url' => '/calculator/ratio', 'icon' => 'fa-balance-scale-left'],
        ]
    ],
    [
        'id' => 'science',
        'name' => 'Science',
        'icon' => 'fa-flask',
        'url' => '/category/science',
        'description' => 'Scientific calculators',
        'items' => [
            ['name' => 'Physics Calculator', 'url' => '/calculator/physics', 'icon' => 'fa-atom'],
            ['name' => 'Chemistry Calculator', 'url' => '/calculator/chemistry', 'icon' => 'fa-flask'],
            ['name' => 'Biology Calculator', 'url' => '/calculator/biology', 'icon' => 'fa-dna'],
            ['name' => 'Astronomy Calculator', 'url' => '/calculator/astronomy', 'icon' => 'fa-moon'],
            ['name' => 'Energy Calculator', 'url' => '/calculator/energy', 'icon' => 'fa-bolt'],
        ]
    ],
    [
        'id' => 'engineering',
        'name' => 'Engineering',
        'icon' => 'fa-cogs',
        'url' => '/category/engineering',
        'description' => 'Engineering and technical tools',
        'items' => [
            ['name' => 'Electrical Calculator', 'url' => '/calculator/electrical', 'icon' => 'fa-plug'],
            ['name' => 'Mechanical Calculator', 'url' => '/calculator/mechanical', 'icon' => 'fa-cog'],
            ['name' => 'Civil Engineering', 'url' => '/calculator/civil', 'icon' => 'fa-bridge'],
            ['name' => 'Material Calculator', 'url' => '/calculator/material', 'icon' => 'fa-cube'],
            ['name' => 'Load Calculator', 'url' => '/calculator/load', 'icon' => 'fa-weight-hanging'],
        ]
    ],
    [
        'id' => 'cooking',
        'name' => 'Cooking',
        'icon' => 'fa-utensils',
        'url' => '/category/cooking',
        'description' => 'Cooking and recipe tools',
        'items' => [
            ['name' => 'Recipe Converter', 'url' => '/calculator/recipe', 'icon' => 'fa-book-open'],
            ['name' => 'Cooking Time Calculator', 'url' => '/calculator/cooking-time', 'icon' => 'fa-clock'],
            ['name' => 'Ingredient Substitution', 'url' => '/calculator/substitution', 'icon' => 'fa-exchange-alt'],
            ['name' => 'Serving Size Calculator', 'url' => '/calculator/serving-size', 'icon' => 'fa-users'],
            ['name' => 'Nutrition Calculator', 'url' => '/calculator/nutrition', 'icon' => 'fa-apple-alt'],
        ]
    ],
    [
        'id' => 'construction',
        'name' => 'Construction',
        'icon' => 'fa-hard-hat',
        'url' => '/category/construction',
        'description' => 'Construction and building tools',
        'items' => [
            ['name' => 'Concrete Calculator', 'url' => '/calculator/concrete', 'icon' => 'fa-cube'],
            ['name' => 'Roofing Calculator', 'url' => '/calculator/roofing', 'icon' => 'fa-home'],
            ['name' => 'Paint Calculator', 'url' => '/calculator/paint', 'icon' => 'fa-paint-roller'],
            ['name' => 'Flooring Calculator', 'url' => '/calculator/flooring', 'icon' => 'fa-th'],
            ['name' => 'Material Estimator', 'url' => '/calculator/material-estimator', 'icon' => 'fa-ruler-combined'],
        ]
    ],
    [
        'id' => 'automotive',
        'name' => 'Automotive',
        'icon' => 'fa-car',
        'url' => '/category/automotive',
        'description' => 'Automotive calculators',
        'items' => [
            ['name' => 'Fuel Cost Calculator', 'url' => '/calculator/fuel-cost', 'icon' => 'fa-gas-pump'],
            ['name' => 'Car Loan Calculator', 'url' => '/calculator/car-loan', 'icon' => 'fa-car-side'],
            ['name' => 'MPG Calculator', 'url' => '/calculator/mpg', 'icon' => 'fa-tachometer-alt'],
            ['name' => 'Tire Size Calculator', 'url' => '/calculator/tire-size', 'icon' => 'fa-circle'],
            ['name' => 'Lease Calculator', 'url' => '/calculator/lease', 'icon' => 'fa-file-contract'],
        ]
    ],
    [
        'id' => 'education',
        'name' => 'Education',
        'icon' => 'fa-graduation-cap',
        'url' => '/category/education',
        'description' => 'Educational tools and calculators',
        'items' => [
            ['name' => 'GPA Calculator', 'url' => '/calculator/gpa', 'icon' => 'fa-chart-line'],
            ['name' => 'Grade Calculator', 'url' => '/calculator/grade', 'icon' => 'fa-star'],
            ['name' => 'Study Time Calculator', 'url' => '/calculator/study-time', 'icon' => 'fa-book'],
            ['name' => 'Student Loan Calculator', 'url' => '/calculator/student-loan', 'icon' => 'fa-university'],
            ['name' => 'Test Score Calculator', 'url' => '/calculator/test-score', 'icon' => 'fa-clipboard-check'],
        ]
    ],
    [
        'id' => 'business',
        'name' => 'Business',
        'icon' => 'fa-briefcase',
        'url' => '/category/business',
        'description' => 'Business and productivity tools',
        'items' => [
            ['name' => 'ROI Calculator', 'url' => '/calculator/roi', 'icon' => 'fa-chart-pie'],
            ['name' => 'Break-even Calculator', 'url' => '/calculator/break-even', 'icon' => 'fa-balance-scale'],
            ['name' => 'Profit Margin Calculator', 'url' => '/calculator/profit-margin', 'icon' => 'fa-percentage'],
            ['name' => 'Discount Calculator', 'url' => '/calculator/discount', 'icon' => 'fa-tags'],
            ['name' => 'Sales Tax Calculator', 'url' => '/calculator/sales-tax', 'icon' => 'fa-receipt'],
        ]
    ],
    [
        'id' => 'other',
        'name' => 'Other',
        'icon' => 'fa-ellipsis-h',
        'url' => '/category/other',
        'description' => 'Miscellaneous calculators',
        'items' => [
            ['name' => 'Random Number Generator', 'url' => '/calculator/random', 'icon' => 'fa-random'],
            ['name' => 'Password Generator', 'url' => '/calculator/password', 'icon' => 'fa-key'],
            ['name' => 'QR Code Generator', 'url' => '/calculator/qr-code', 'icon' => 'fa-qrcode'],
            ['name' => 'Color Converter', 'url' => '/calculator/color', 'icon' => 'fa-palette'],
            ['name' => 'Text Counter', 'url' => '/calculator/text-counter', 'icon' => 'fa-font'],
        ]
    ]
];
?>

<!-- Desktop Navigation Menu -->
<div class="main-navigation" role="menubar">
    <ul class="nav-menu">
        <li class="nav-item <?php echo is_nav_active('index'); ?>">
            <a href="/" class="nav-link">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        
        <?php foreach ($nav_categories as $category): ?>
        <li class="nav-item has-dropdown <?php echo is_nav_active($category['id']); ?>">
            <a href="<?php echo htmlspecialchars($category['url']); ?>" 
               class="nav-link"
               aria-haspopup="true"
               aria-expanded="false">
                <i class="fas <?php echo htmlspecialchars($category['icon']); ?>"></i>
                <?php echo htmlspecialchars($category['name']); ?>
                <i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            
            <!-- Dropdown Menu -->
            <div class="dropdown-menu" role="menu">
                <div class="dropdown-header">
                    <h4><?php echo htmlspecialchars($category['name']); ?> Calculators</h4>
                    <p><?php echo htmlspecialchars($category['description']); ?></p>
                </div>
                <div class="dropdown-content">
                    <ul class="dropdown-list">
                        <?php foreach ($category['items'] as $item): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($item['url']); ?>" class="dropdown-item">
                                <i class="fas <?php echo htmlspecialchars($item['icon']); ?>"></i>
                                <span><?php echo htmlspecialchars($item['name']); ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="dropdown-footer">
                        <a href="<?php echo htmlspecialchars($category['url']); ?>" class="view-all-link">
                            View All <?php echo htmlspecialchars($category['name']); ?> Tools 
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
        
        <li class="nav-item <?php echo is_nav_active('about'); ?>">
            <a href="/about.php" class="nav-link">
                <i class="fas fa-info-circle"></i> About
            </a>
        </li>
    </ul>
</div>

<!-- Mobile Navigation Menu -->
<div class="mobile-navigation" id="mobileMenu">
    <div class="mobile-nav-header">
        <h3>Menu</h3>
        <button class="mobile-nav-close" aria-label="Close menu">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <nav class="mobile-nav-content">
        <ul class="mobile-nav-list">
            <li class="mobile-nav-item <?php echo is_nav_active('index'); ?>">
                <a href="/" class="mobile-nav-link">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            
            <?php foreach ($nav_categories as $category): ?>
            <li class="mobile-nav-item has-submenu <?php echo is_nav_active($category['id']); ?>">
                <div class="mobile-nav-toggle">
                    <a href="<?php echo htmlspecialchars($category['url']); ?>" class="mobile-nav-link">
                        <i class="fas <?php echo htmlspecialchars($category['icon']); ?>"></i>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </a>
                    <button class="submenu-toggle" aria-label="Toggle submenu">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                
                <ul class="mobile-submenu">
                    <?php foreach ($category['items'] as $item): ?>
                    <li>
                        <a href="<?php echo htmlspecialchars($item['url']); ?>" class="mobile-submenu-link">
                            <i class="fas <?php echo htmlspecialchars($item['icon']); ?>"></i>
                            <?php echo htmlspecialchars($item['name']); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    <li class="view-all-mobile">
                        <a href="<?php echo htmlspecialchars($category['url']); ?>" class="mobile-submenu-link featured">
                            <i class="fas fa-arrow-right"></i>
                            View All <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endforeach; ?>
            
            <li class="mobile-nav-item <?php echo is_nav_active('about'); ?>">
                <a href="/about.php" class="mobile-nav-link">
                    <i class="fas fa-info-circle"></i> About
                </a>
            </li>
        </ul>
    </nav>
</div>

<script>
// Navigation Dropdown Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Desktop dropdown hover
    const navItems = document.querySelectorAll('.nav-item.has-dropdown');
    
    navItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        const dropdown = item.querySelector('.dropdown-menu');
        
        item.addEventListener('mouseenter', function() {
            link.setAttribute('aria-expanded', 'true');
            dropdown.classList.add('show');
        });
        
        item.addEventListener('mouseleave', function() {
            link.setAttribute('aria-expanded', 'false');
            dropdown.classList.remove('show');
        });
    });
    
    // Mobile submenu toggle
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.closest('.mobile-nav-item');
            const submenu = parent.querySelector('.mobile-submenu');
            const icon = this.querySelector('i');
            
            parent.classList.toggle('active');
            
            if (parent.classList.contains('active')) {
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            } else {
                submenu.style.maxHeight = '0';
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
    
    // Mobile menu close button
    const mobileNavClose = document.querySelector('.mobile-nav-close');
    if (mobileNavClose) {
        mobileNavClose.addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            
            mobileMenu.classList.remove('active');
            mobileMenuToggle.classList.remove('active');
            mobileMenuToggle.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('menu-open');
        });
    }
});
</script>  
