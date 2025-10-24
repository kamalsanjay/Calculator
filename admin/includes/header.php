<?php
/**
 * Admin Header Template
 * Bootstrap-based admin panel header with sidebar navigation
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Admin Panel'; ?> - Calculator Website</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin Styles -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        #sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            color: white;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s;
        }

        #sidebar.toggled {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-brand {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand h4 {
            margin: 0;
            font-weight: 700;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            list-style: none;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
        }

        /* Content Area */
        #content-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            transition: all 0.3s;
        }

        #content-wrapper.expanded {
            margin-left: 0;
            width: 100%;
        }

        /* Topbar */
        .topbar {
            background: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--secondary-color);
            cursor: pointer;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Cards */
        .border-left-primary {
            border-left: 4px solid var(--primary-color) !important;
        }

        .border-left-success {
            border-left: 4px solid var(--success-color) !important;
        }

        .border-left-info {
            border-left: 4px solid var(--info-color) !important;
        }

        .border-left-warning {
            border-left: 4px solid var(--warning-color) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-brand">
                <h4><i class="fas fa-calculator me-2"></i>Admin Panel</h4>
            </div>

            <ul class="sidebar-nav">
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="analytics.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'analytics.php' ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Analytics</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="manage-calculators.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'manage-calculators.php' ? 'active' : ''; ?>">
                        <i class="fas fa-layer-group"></i>
                        <span>Calculators</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="manage-ads.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'manage-ads.php' ? 'active' : ''; ?>">
                        <i class="fas fa-ad"></i>
                        <span>Advertisements</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="settings.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : ''; ?>">
                        <i class="fas fa-cogs"></i>
                        <span>Settings</span>
                    </a>
                </li>

                <hr style="border-color: rgba(255, 255, 255, 0.1); margin: 1rem 0;">

                <li class="nav-item">
                    <a href="../index.php" class="nav-link" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Website</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Content Wrapper -->
        <div id="content-wrapper">
            <!-- Topbar -->
            <div class="topbar">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="user-info">
                    <span class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        <?php echo date('M j, Y g:i A'); ?>
                    </span>
                    
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle text-decoration-none" type="button" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                <?php echo strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1)); ?>
                            </div>
                            <span class="ms-2"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text">
                                    <strong><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></strong><br>
                                    <small class="text-muted"><?php echo ucfirst($_SESSION['admin_role'] ?? 'admin'); ?></small>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div id="content" style="padding: 2rem;">


