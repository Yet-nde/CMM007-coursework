<?php
require_once __DIR__ . '/../../core/CMM007_dbconfig.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

try {
      // Validate user_id
      $userId = $_SESSION['user_id'];
      if (!is_numeric($userId) || $userId <= 0) {
          throw new Exception("Invalid user ID");
      }

    // Fetch all loans
    $stmt = $pdo->prepare("
        SELECT b.title, b.author, l.loan_id, l.borrow_date, l.due_date, l.return_date,
        CASE WHEN l.return_date IS NOT NULL THEN 'returned' WHEN l.due_date < CURDATE() THEN 'overdue'
        ELSE 'borrowed' END AS status
        FROM Loans l JOIN Books b ON l.book_id = b.book_id WHERE l.user_id = ? 
        ORDER BY CASE WHEN l.return_date IS NULL THEN 0 ELSE 1 END, l.due_date ASC");
    $stmt->execute([$userId]);
    $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $loans,
        'currentCount' => getCurrentBorrowCount($pdo,$userId)
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
function getCurrentBorrowCount(PDO $pdo, int $userId): int
{
    $stmt = $pdo->prepare("SELECT COALESCE(active_count,0) FROM user_active_loans WHERE user_id = ?");
    $stmt->execute([$userId]);
    return (int)$stmt->fetchColumn();
}
?>