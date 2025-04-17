<?php
header('Content-Type: application/json');

// Start session and load dependencies
require_once __DIR__ . '/../../core/helpers.php';
require_once __DIR__ . '/../../core/CMM007_dbconfig.php';
generateCsrfToken();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

try {
    $userId = $_SESSION['user_id'];
    // Get current loans count
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Loans WHERE user_id = ? AND return_date IS NULL 
    AND borrow_date <= CURDATE() AND (due_date >=CURDATE() OR return_date IS NULL)");
    $stmt->execute([$_SESSION['user_id']]);
    $borrowedCount = (int)$stmt->fetchColumn();

    // Get overdue books count
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Loans WHERE user_id = ? 
        AND return_date IS NULL AND due_date < CURDATE()");
    $stmt->execute([$_SESSION['user_id']]);
    $overdueCount = (int)$stmt->fetchColumn();

    echo json_encode( [
        'status' => 'success',
        'borrowedCount' => $borrowedCount,
        'overdueCount' => $overdueCount
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error',
        'debug' => $e->getMessage()
    ]);
}
catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>