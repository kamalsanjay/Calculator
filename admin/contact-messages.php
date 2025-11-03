<?php
/**
 * View Contact Messages - FIXED
 */

define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

AdminMiddleware::check();
$admin = AdminMiddleware::adminUser();

$db = Database::getInstance();
$success = '';
$error = '';

// Mark as read - FIXED
if (isset($_GET['action']) && $_GET['action'] === 'read' && isset($_GET['id'])) {
    try {
        $id = intval($_GET['id']);
        $stmt = $db->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Message marked as read';
        header('Location: contact-messages.php?success=' . urlencode($success));
        exit;
    } catch (Exception $e) {
        $error = 'Failed to mark as read: ' . $e->getMessage();
    }
}

// Delete message - FIXED
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    try {
        $id = intval($_GET['id']);
        $stmt = $db->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Message deleted successfully';
        header('Location: contact-messages.php?success=' . urlencode($success));
        exit;
    } catch (Exception $e) {
        $error = 'Failed to delete message: ' . $e->getMessage();
    }
}

// Get success message from URL
if (isset($_GET['success'])) {
    $success = $_GET['success'];
}

// Get all messages
try {
    $messages = $db->fetchAll("
        SELECT * FROM contact_messages 
        ORDER BY is_read ASC, created_at DESC
    ");
} catch (Exception $e) {
    $messages = [];
    $error = 'Failed to load messages: ' . $e->getMessage();
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
                <div class="user-info">
                    <span class="badge badge-primary">
                        <?php echo count(array_filter($messages, function($m) { return !$m['is_read']; })); ?> Unread
                    </span>
                </div>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="content-card">
                <div class="content-card-header">
                    <h3>All Messages (<?php echo count($messages); ?>)</h3>
                </div>
                <div class="content-card-body">
                    <?php if (empty($messages)): ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h3>No Messages Yet</h3>
                            <p>Contact form submissions will appear here</p>
                        </div>
                    <?php else: ?>
                        <div class="messages-list">
                            <?php foreach ($messages as $msg): ?>
                                <div class="message-item <?php echo !$msg['is_read'] ? 'unread' : ''; ?>" id="msg-<?php echo $msg['id']; ?>">
                                    <div class="message-header">
                                        <div class="message-from">
                                            <i class="fas fa-user-circle"></i>
                                            <div>
                                                <strong><?php echo htmlspecialchars($msg['name']); ?></strong>
                                                <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" class="message-email">
                                                    <?php echo htmlspecialchars($msg['email']); ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="message-meta">
                                            <?php if (!$msg['is_read']): ?>
                                                <span class="badge badge-primary">New</span>
                                            <?php endif; ?>
                                            <span class="message-date">
                                                <i class="fas fa-clock"></i>
                                                <?php echo date('M j, Y g:i A', strtotime($msg['created_at'])); ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="message-subject">
                                        <strong>Subject:</strong> <?php echo htmlspecialchars($msg['subject']); ?>
                                    </div>
                                    
                                    <div class="message-content">
                                        <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                                    </div>
                                    
                                    <div class="message-actions">
                                        <?php if (!$msg['is_read']): ?>
                                            <a href="?action=read&id=<?php echo $msg['id']; ?>" 
                                               class="btn-action btn-primary" 
                                               title="Mark as Read">
                                                <i class="fas fa-check"></i> Mark as Read
                                            </a>
                                        <?php endif; ?>
                                        
                                        <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" 
                                           class="btn-action btn-secondary" 
                                           title="Reply">
                                            <i class="fas fa-reply"></i> Reply
                                        </a>
                                        
                                        <a href="?action=delete&id=<?php echo $msg['id']; ?>" 
                                           class="btn-action btn-danger" 
                                           title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this message?');">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </div>
                                    
                                    <div class="message-footer">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt"></i> IP: <?php echo htmlspecialchars($msg['ip_address'] ?? 'N/A'); ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

    <style>
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-view {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .btn-view:hover {
        background: #2e7d32;
        color: white;
    }

    .btn-edit {
        background: #e3f2fd;
        color: #1976d2;
    }

    .btn-edit:hover {
        background: #1976d2;
        color: white;
    }

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .btn-delete:hover {
        background: #c62828;
        color: white;
    }

    .message-detail td {
        padding: 2rem !important;
        background: #f8f9fa;
    }

    .message-content {
        max-width: 800px;
    }

    .message-content p {
        margin-top: 1rem;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        line-height: 1.6;
    }

    .message-meta {
        margin-top: 1rem;
        color: #6c757d;
    }
    </style>

    <script>
    function viewMessage(id) {
        const row = document.getElementById('message-' + id);
        if (row.style.display === 'none') {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    }
    </script>
</body>
</html>