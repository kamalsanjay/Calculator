<?php
/**
 * Admin Logout
 */

require_once '../config.php';
require_once '../middleware/AuthMiddleware.php';

// Logout user
AuthMiddleware::logout();

// Redirect to login
header('Location: login.php?logout=success');
exit;
?>