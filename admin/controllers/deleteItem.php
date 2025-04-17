<?php
session_start();
require_once __DIR__ . '/../../core/middleware.php';
validateCsrf(); // Validate CSRF token
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login_display.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['status' => 'error', 'message' => ''];

    try {
        $id = $_POST['id'];
        $type = $_POST['type'];

        if ($type === 'book') {
            // Soft delete book with named parameter
            $stmt = $pdo->prepare("UPDATE Books SET status='deleted',deleted_at = NOW() WHERE book_id = :id");
            $stmt->execute(["id" => $id]);

            // Log system action
            $logStmt = $pdo->prepare("INSERT INTO system_logs 
        (user_id, user_role, action_type, target_type, target_id) 
        VALUES (:user_id, 'Admin','delete', 'book', :target_id)");
            $logStmt->execute([
                "user_id" => $_SESSION['user_id'],
                "target_id" => $id
            ]);
        } else {
            // Soft delete user with named parameter
            $stmt = $pdo->prepare("UPDATE Users SET status='deleted', deleted_at = NOW() WHERE user_id = :id");
            $stmt->execute(["id" => $id]);


            // Log system action
            $logStmt = $pdo->prepare("INSERT INTO system_logs 
        (user_id, user_role, action_type, target_type, target_id) 
        VALUES (:user_id, 'Admin','delete', 'user', :target_id)");
            $logStmt->execute([
                "user_id" => $_SESSION['user_id'],
                "target_id" => $id
            ]);
        }

        $response = ['status' => 'success', 'message' => ucfirst($type) . ' deleted successfully.'];
    } catch (PDOException $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>