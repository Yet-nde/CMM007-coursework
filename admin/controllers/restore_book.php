<?php
require_once __DIR__ . '/../../core/middleware.php';
validateCsrf(); // Validate CSRF token

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    http_response_code(403);
    die(json_encode([
        'status' => 'error',
        'message' => 'Admin access required'
    ]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $bookId = $_POST['book_id'];

        // Check if book exists
        $checkStmt = $pdo->prepare("SELECT book_id FROM books WHERE book_id = :id");
        $checkStmt->execute(["id" => $bookId]);

        if ($checkStmt->rowCount() === 0) {
            die(json_encode([
                'status' => 'error',
                'message' => 'Book not found'
            ]));
        }

        // Update book status
        $updateStmt = $pdo->prepare("UPDATE books SET status='active', deleted_at = NULL WHERE book_id = :id");
        $updateStmt->execute(["id" => $bookId]);

        // Verify update
        if ($updateStmt->rowCount() === 0) {
            die(json_encode([
                'status' => 'error',
                'message' => 'No changes made'
            ]));
        }

        // Log the restoration
        $logStmt = $pdo->prepare("INSERT INTO system_logs 
    (user_id, user_role, action_type, target_type, target_id) 
    VALUES (:user_id, 'Admin', 'restore', 'book', :target_id)");
        $logStmt->execute([
            "user_id" => $_SESSION['user_id'],
            "target_id" => $bookId
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Book restored successfully.']);

    } catch (PDOException $e) {
        error_log("Restore error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
}
?>