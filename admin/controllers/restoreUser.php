<?php
session_start();
require_once __DIR__ . '/../../core/middleware.php';
validateCsrf();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("HTTP/1.1 403 Forbidden");
    exit(json_encode(['status' => 'error', 'message' => 'Forbidden']));
}

try {
    $userId = $_POST['user_id'];
    
    $stmt = $pdo->prepare("
        UPDATE Users 
        SET status = 'active', 
            deleted_at = NULL 
        WHERE user_id = ?
    ");
    $stmt->execute([$userId]);
    
    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}