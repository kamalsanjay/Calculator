<?php
/**
 * Logout Handler
 * Destroys user session and logs out
 */

require_once '../config.php';

// Delete remember me token if exists
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    
    try {
        $stmt = $db->prepare("DELETE FROM remember_tokens WHERE token = ?");
        $stmt->execute([hash('sha256', $token)]);
    } catch (PDOException $e) {
        error_log("Logout error: " . $e->getMessage());
    }
    
    setcookie('remember_token', '', time() - 3600, '/', '', true, true);
}

// Destroy session
session_destroy();

// Redirect to homepage
header('Location: /?logout=success');
exit;