<?php
ob_start(); 
header("Content-Type: application/json"); // Set response to JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../core/middleware.php';

validateCsrf(); // Validate CSRF token

// Load PHPMailer
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';
require __DIR__ . '/../PHPMailer/src/Exception.php';

// Use PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

if (!isset($_POST["email"])) {
    echo json_encode(["success" => false, "message" => "Email is required"]);
    exit;
}

// Get and sanitize email
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format"]);
    exit;
}

// Check if the email exists in the database
try {
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = :email");
    $stmt->execute(["email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(["success" => false, "message" => "Email not found"]);
        exit;
    }

    // Generate a unique reset token
    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", time() + 3600); // Expires after an hour

    // Save the token in the database
    $stmt = $pdo->prepare("UPDATE Users SET reset_token = :token, reset_token_expiry = :expiry WHERE email = :email");
    $stmt->execute([
        "token" => $token,
        "expiry" => $expiry,
        "email" => $email
    ]);

    // Create instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;  // Set the SMTP server to gmail
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //TLS encryption
        $mail->Port = SMTP_PORT; // TCP port to connect to

        // Recipients
        $mail->setFrom('yetunde.lms@gmail.com', " Yetunde's Library Management System");
        $mail->addAddress($email);

        // Content
        $resetLink = "http://".$_SERVER['HTTP_HOST']."/CMM007-COURSEWORK/auth/reset_password_display.php?token=".urlencode($token);
        $mail->isHTML(true);
        $mail->Subject = "Password Reset Request";
        $mail->Body = "Click the link below to reset your password. This link will expire in an hour:\n\n" . $resetLink;

        $mail->send();
        echo json_encode(["success" => true, "message" => "A password reset link has been sent to your email. Check the spam folder."]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Failed to send email: " . $e->getMessage()]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}

// $pdo = null; // Close connection
ob_end_clean();  // Discard accidental output
echo json_encode($response);  // Only outputexit;
?>