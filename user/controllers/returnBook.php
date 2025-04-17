<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../core/middleware.php';
validateCsrf(); // Validate CSRF token


if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['loan_id'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

try {
    $userId = $_SESSION['user_id'];
    $loanId = (int) $_POST['loan_id'];
    $transactionStarted = false;

    // Begin transaction
    $pdo->beginTransaction();
    $transactionStarted = true;

    // Validate loan belongs to user
    $stmt = $pdo->prepare("SELECT book_id,return_date FROM Loans WHERE loan_id = ? AND user_id = ? FOR UPDATE");
    $stmt->execute([$loanId, $userId]);
    $loan = $stmt->fetch();

    if (!$loan) {
        
        throw new Exception("Loan not found or does not belong to you");
    }

    // Check if it has been returned
    if ($loan['return_date'] !== null) {
        
        echo json_encode([
            'status' => 'error',
            'message' => 'Book was already returned on ' . $loan['return_date']
        ]);
        exit;
    }
    // Update loan with return date
    $stmt = $pdo->prepare("UPDATE Loans SET return_date = NOW() WHERE loan_id = ?");
    $stmt->execute([$loanId]);

    // Update book availability
    $stmt = $pdo->prepare("UPDATE Books SET available_quantity = available_quantity + 1 WHERE book_id = ?");
    $stmt->execute([$loan['book_id']]);

    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'message' => 'Book returned successfully'
    ]);


} catch (Exception $e) {
    if ($transactionStarted) {
        $pdo->rollBack();
    }
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>