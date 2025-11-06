<?php
/**
 * Contact Messages Management
 */

define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

AdminMiddleware::check();
$admin = AdminMiddleware::adminUser();

$db = Database::getInstance();
$success = '';
$error = '';

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    try {
        switch ($_GET['action']) {
            case 'mark_read':
                $db->execute("UPDATE contact_messages SET is_read = 1, read_at = NOW() WHERE id = ?", [$id]);
                $success = 'Message marked as read!';
                break;
                
            case 'mark_unread':
                $db->execute("UPDATE contact_messages SET is_read = 0, read_at = NULL WHERE id = ?", [$id]);
                $success = 'Message marked as unread!';
                break;
                
            case 'delete':
                $db->execute("DELETE FROM contact_messages WHERE id = ?", [$id]);
                $success = 'Message deleted successfully!';
                break;
        }
    } catch (Exception $e) {
        $error = 'Failed to perform action: ' . $e->getMessage();
    }
}

// Get filters
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';

// Build query
$query = "SELECT * FROM contact_messages WHERE 1=1";
$params = [];

if ($filter === 'unread') {
    $query .= " AND is_read = 0";
} elseif ($filter === 'read') {
    $query .= " AND is_read = 1";
}

if ($search) {
    $query .= " AND (name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?)";
    $searchTerm = "%{$search}%";
    $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
}

$query .= " ORDER BY created_at DESC";

// Get messages
try {
    $messages = $db->fetchAll($query, $params);
    $totalCount = $db->fetchColumn("SELECT COUNT(*) FROM contact_messages");
    $unreadCount = $db->fetchColumn("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0");
    $readCount = $db->fetchColumn("SELECT COUNT(*) FROM contact_messages WHERE is_read = 1");
} catch (Exception $e) {
    $messages = [];
    $totalCount = $unreadCount = $readCount = 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="top-bar">
                <div class="welcome-text">
                    <h1><i class="fas fa-envelope"></i> Contact Messages</h1>
                    <p>View and manage contact form submissions</p>
                </div>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($totalCount); ?></h3>
                        <p>Total Messages</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ffc107 0%, #ff6b6b 100%);">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($unreadCount); ?></h3>
                        <p>Unread</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($readCount); ?></h3>
                        <p>Read</p>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters-card">
                <div class="filter-tabs">
                    <a href="?filter=all" class="filter-tab <?php echo $filter === 'all' ? 'active' : ''; ?>">
                        All (<?php echo $totalCount; ?>)
                    </a>
                    <a href="?filter=unread" class="filter-tab <?php echo $filter === 'unread' ? 'active' : ''; ?>">
                        Unread (<?php echo $unreadCount; ?>)
                    </a>
                    <a href="?filter=read" class="filter-tab <?php echo $filter === 'read' ? 'active' : ''; ?>">
                        Read (<?php echo $readCount; ?>)
                    </a>
                </div>

                <form method="GET" class="search-form">
                    <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
                    <input type="text" name="search" class="form-control" placeholder="Search messages..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>

            <!-- Messages -->
            <?php if (empty($messages)): ?>
                <div class="content-card">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>No messages found</h3>
                        <p>There are no contact messages matching your criteria.</p>
                    </div>
                </div>
            <?php else: ?>
                <div class="messages-grid">
                    <?php foreach ($messages as $message): ?>
                        <div class="message-card <?php echo !$message['is_read'] ? 'unread' : ''; ?>">
                            <div class="message-header">
                                <div class="message-info">
                                    <h3><?php echo htmlspecialchars($message['name']); ?></h3>
                                    <p class="message-email">
                                        <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($message['email']); ?>
                                    </p>
                                    <div class="message-meta">
                                        <span><i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($message['created_at'])); ?></span>
                                        <span><i class="fas fa-clock"></i> <?php echo date('h:i A', strtotime($message['created_at'])); ?></span>
                                        <?php if ($message['read_at']): ?>
                                            <span><i class="fas fa-check-double"></i> Read on <?php echo date('M d, Y', strtotime($message['read_at'])); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="message-status">
                                    <?php if ($message['is_read']): ?>
                                        <span class="badge badge-success">Read</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Unread</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="message-subject">
                                <i class="fas fa-tag"></i> <?php echo htmlspecialchars($message['subject']); ?>
                            </div>

                            <div class="message-body">
                                <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                            </div>

                            <div class="message-actions">
                                <?php if (!$message['is_read']): ?>
                                    <a href="?action=mark_read&id=<?php echo $message['id']; ?>&filter=<?php echo $filter; ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Mark as Read
                                    </a>
                                <?php else: ?>
                                    <a href="?action=mark_unread&id=<?php echo $message['id']; ?>&filter=<?php echo $filter; ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-envelope"></i> Mark as Unread
                                    </a>
                                <?php endif; ?>
                                
                                <a href="?action=delete&id=<?php echo $message['id']; ?>&filter=<?php echo $filter; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this message?');">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .stat-details h3 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-details p {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .filters-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-tabs {
        display: flex;
        gap: 0.5rem;
    }

    .filter-tab {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        color: #6c757d;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .filter-tab:hover {
        background: #f8f9fa;
    }

    .filter-tab.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .search-form {
        display: flex;
        gap: 0.5rem;
    }

    .search-form input {
        min-width: 300px;
    }

    .messages-grid {
        display: grid;
        gap: 1.5rem;
    }

    .message-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .message-card.unread {
        border-left-color: #ffc107;
        background: #fffef8;
    }

    .message-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .message-info h3 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .message-email {
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .message-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.875rem;
        color: #6c757d;
        flex-wrap: wrap;
    }

    .message-subject {
        font-size: 1rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 1rem;
    }

    .message-body {
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .message-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    @media (max-width: 768px) {
        .filters-card {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-tabs {
            flex-direction: column;
        }

        .search-form input {
            min-width: auto;
            width: 100%;
        }
    }
    </style>
</body>
</html>