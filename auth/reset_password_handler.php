<?php
header("Content-Type: application/json"); // set response to json
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../core/middleware.php';

validateCsrf(); // Validate CSRF token


//Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

// Validate required fields
if (!isset($_POST["token"]) || !isset($_POST["new_password"]) || !isset($_POST["repeat_password"])) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

// Database connection
require_once __DIR__ . '/../core/CMM007_dbconfig.php';


// Get form data
$token = filter_var($_POST["token"], FILTER_SANITIZE_STRING);
$new_password = $_POST["new_password"];
$repeat_password = $_POST["repeat_password"];

// Validate password length
if (strlen($new_password) < 8) {
    echo json_encode(["success" => false, "message" => "Password must be at least 8 characters"]);
    exit;
}

// Validate password match
if ($new_password !== $repeat_password) {
    echo json_encode(["success" => false, "message" => "Passwords do not match"]);
    exit;
}

// Hash password
$hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

// Fetch user
try {
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE reset_token= :token AND  reset_token_expiry > NOW()");
    $stmt->execute(["token" => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Update password and clear reset token
        $stmt = $pdo->prepare("UPDATE Users SET password=:password,reset_token= NULL,reset_token_expiry=NULL WHERE email= :email");
        $stmt->execute([
            "password" => $hashed_password,
            "email" => $user["email"]
        ]);
        echo json_encode(["success" => true, "message" => "Password successfully reset", "redirect" => "../login_display.php" ]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid or expired token"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}
$pdo = null; // Close connection
?>