<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../core/CMM007_dbconfig.php';


try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception("Invalid request method", 405);
    }

    // Validate token parameter
    if (!isset($_GET['token'])) {
        throw new Exception("Verification token required", 400);
    }

    // Sanitize and validate token format
    $token = trim($_GET['token']);
    if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
        throw new Exception("Invalid token format", 400);
    }

    // Database operation
    $stmt = $pdo->prepare("SELECT user_id FROM Users 
                          WHERE verification_token = :token 
                          AND verify_token_expiry > NOW()");
    $stmt->execute([':token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !isset($user['user_id'])) {
        throw new Exception("Invalid or expired verification token", 400);
    }

    // Update user verification status
    $pdo->beginTransaction();
    $updateStmt = $pdo->prepare("UPDATE Users SET 
                                status='active',
                                verified = 1, 
                                verification_token = NULL, 
                                verify_token_expiry = NULL 
                                WHERE user_id = :user_id");
    $updateStmt->execute([':user_id' => $user['user_id']]);
    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Email verified successfully. You can now login."
    ]);

} catch (Exception $e) {
    // Rollback transaction if needed
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    exit;
}
?>