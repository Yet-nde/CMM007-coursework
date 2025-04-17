<?php
require_once __DIR__ . '/../../core/middleware.php';
validateCsrf(); // Validate CSRF token


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: up_login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['status' => 'error', 'message' => ''];

    try {
        // Validate required fields
        $required = ['email', 'username', 'role'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields.");
            }
        }

        // Check if password is being updated
        $passwordUpdate = '';
        if (!empty($_POST['password'])) {
            $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $passwordUpdate = ', password = :password';
        }

        // Update user
        $stmt = $pdo->prepare("UPDATE Users SET 
            email = :email,
            username = :username,
            role = :role,
            status= :status
            $passwordUpdate
            WHERE user_id = :user_id");

        $params = [
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            'role' => $_POST['role'],
            'status' => $_POST['status'] ?? 'active',
            'user_id' => $_POST['user_id']
        ];

        if (!empty($_POST['password'])) {
            $params['password'] = $hashed_password;
        }

        $stmt->execute($params);

        // Log system action
        $logStmt = $pdo->prepare("INSERT INTO system_logs 
         (user_id, user_role, action_type, target_type, target_id) 
         VALUES (:user_id, 'Admin','update', 'user', :target_id)");
        $logStmt->execute([
            "user_id" => $_SESSION['user_id'],
            "target_id" => $_POST['user_id']
        ]);

        $response = ['status' => 'success', 'message' => 'User updated successfully'];
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $response['message'] = 'Email or username already exists.';
        } else {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>