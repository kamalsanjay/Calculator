<?php
/**
 * Navigation Menu
 * Main site navigation
 */

$categories = [
    'financial' => ['name' => 'Financial', 'icon' => 'dollar-sign'],
    'health' => ['name' => 'Health & Fitness', 'icon' => 'heartbeat'],
    'math' => ['name' => 'Math', 'icon' => 'calculator'],
    'conversion' => ['name' => 'Conversion', 'icon' => 'exchange-alt'],
    'date-time' => ['name' => 'Date & Time', 'icon' => 'calendar'],
    'construction' => ['name' => 'Construction', 'icon' => 'hammer'],
    'electronics' => ['name' => 'Electronics', 'icon' => 'bolt'],
    'automotive' => ['name' => 'Automotive', 'icon' => 'car'],
    'education' => ['name' => 'Education', 'icon' => 'graduation-cap'],
    'utility' => ['name' => 'Utility', 'icon' => 'tools'],
    'weather' => ['name' => 'Weather', 'icon' => 'cloud'],
    'cooking' => ['name' => 'Cooking', 'icon' => 'utensils'],
    'gaming' => ['name' => 'Gaming', 'icon' => 'gamepad'],
    'sports' => ['name' => 'Sports', 'icon' => 'football-ball']
];

$current_url = $_SERVER['REQUEST_URI'];
?>

<nav class="main-navigation">
    <ul class="nav-list">
        <li class="nav-item <?php echo ($current_url === '/') ? 'active' : ''; ?>">
            <a href="/" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
        </li>
        
        <?php foreach ($categories as $slug => $category): ?>
        <li class="nav-item <?php echo (strpos($current_url, "/calculators/{$slug}") !== false) ? 'active' : ''; ?>">
            <a href="/calculators/<?php echo $slug; ?>" class="nav-link">
                <i class="fas fa-<?php echo $category['icon']; ?>"></i>
                <span><?php echo $category['name']; ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>

<style>
.main-navigation {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    padding: var(--spacing-lg);
}

.nav-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: var(--spacing-sm);
}

.nav-item {
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    padding: var(--spacing-md);
    color: var(--dark-color);
    text-decoration: none;
    border-radius: var(--radius-md);
    transition: all var(--transition-normal);
}

.nav-link:hover {
    background: var(--light-color);
    color: var(--primary-color);
    transform: translateX(5px);
}

.nav-item.active .nav-link {
    background: var(--primary-color);
    color: white;
}

.nav-link i {
    width: 20px;
    text-align: center;
    font-size: 1.125rem;
}

@media (max-width: 768px) {
    .main-navigation {
        padding: var(--spacing-md);
    }
    
    .nav-link span {
        font-size: 0.875rem;
    }
}
</style>