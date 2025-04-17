<?php
session_start();
header("Content-Type: application/json"); // set response to json

require_once __DIR__ . '/../../core/middleware.php';
validateCsrf(); // Validate CSRF token

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['book_id'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

try {
    // Validate inputs
    $userId = $_SESSION['user_id'];
    $bookId = (int)$_POST['book_id'];

    if (!is_numeric($userId) || $userId <= 0) {
        throw new Exception("Invalid user ID");
    }

    if (!is_numeric($bookId) || $bookId <= 0) {
        throw new Exception("Invalid book ID");
    }

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT available_quantity FROM Books WHERE book_id = ? FOR UPDATE");
    $stmt->execute([$bookId]);
    $book = $stmt->fetch();

    if (!$book) {
        throw new Exception("Book not found");
    }

    if ($book['available_quantity'] <= 0) {
        throw new Exception("Book not available for borrowing");
    }

    // Update loans table
    $stmt = $pdo->prepare("
        INSERT INTO Loans (user_id, book_id, borrow_date,due_date)
        VALUES (?, ?, NOW(),DATE_ADD(NOW(),INTERVAL 14 DAY))
    ");
    $stmt->execute([$userId, $bookId]);

    // Update book availability
    $stmt = $pdo->prepare("UPDATE Books SET available_quantity = available_quantity - 1 WHERE book_id = ?");
    $stmt->execute([$_POST['book_id']]);

    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'message' => 'Book borrowed successfully',
        'currentCount' => getCurrentBorrowCount($pdo, $userId)
    ]);

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Database error: " . $e->getMessage());

    echo json_encode([
            'status' => 'error',
            'message' => 'Database error' . $e->getMessage(),
            'currentCount' => getCurrentBorrowCount($pdo, $_SESSION['user_id'])
        ]);
    
} catch (Exception $e) {
    $pdo->rollBack();
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