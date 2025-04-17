<?php
require_once __DIR__ . '/../core/middleware.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Immediately clear session data
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;

// Destroy session FIRST to prevent race conditions
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}
session_destroy();

// Only then proceed with logging (if we had a user)
if ($user_id) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO system_logs 
            (user_id, user_role, action_type, status, ip_address, session_id)
            VALUES (?, ?, 'logout', 'success', ?, ?)
        ");
        $stmt->execute([
            $user_id,
            $role,
            $_SERVER['REMOTE_ADDR'],
            session_id() // Still available right after destroy
        ]);
    } catch (PDOException $e) {
        error_log("Logout logging failed: " . $e->getMessage());
    }
}

// Force no-cache headers
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// PROPER redirect
header("Location: /CMM007-coursework/auth/login_display.php");
exit();
?>