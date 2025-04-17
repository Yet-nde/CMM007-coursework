<?php
require_once 'CMM007_dbconfig.php';

function validateCsrf() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once 'security.php';
        $token = $_POST['csrf_token'] ?? '';
        if (!validateCsrfToken($token)) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'CSRF validation failed']);
            exit();
        }
    }
}
?>


