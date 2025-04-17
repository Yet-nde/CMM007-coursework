<?php
header('Content-Type: application/json');

// Start session and load dependencies
require_once __DIR__ . '/../../core/CMM007_dbconfig.php';
require_once __DIR__ . '/../../core/helpers.php';
generateCsrfToken();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit(json_encode(['status' => 'error', 'message' => 'Unauthorized']));
}

if ($_SESSION['role'] !== 'Admin') {
    header('HTTP/1.1 403 Forbidden');
    exit(json_encode(['status' => 'error', 'message' => 'Forbidden']));
}

try {
    $data = [];
    
    // Get all books
    $stmt = $pdo->prepare("SELECT * FROM Books");
    $stmt->execute();
    $data['books'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get all users
    $stmt = $pdo->prepare("SELECT user_id, email, username, role, status FROM Users");
    $stmt->execute();
    $data['users'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['status' => 'success', 'data' => $data]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>