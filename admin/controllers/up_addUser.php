<?php
require_once __DIR__ . '/../../core/middleware.php';
require_once __DIR__ . '/../../core/config.php';

validateCsrf(); // Validate CSRF token

// Load PHPMailer
require __DIR__ . '/../../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../PHPMailer/src/SMTP.php';
require __DIR__ . '/../../PHPMailer/src/Exception.php';

// Use PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: /CMM007-coursework/auth/login_display.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['status' => 'error', 'message' => ''];

    try {
        // Validate input
        $required = ['email', 'username', 'role', 'password'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields.");
            }
        }

        // Generate a unique verification token
        $verification_token = bin2hex(random_bytes(32));
        $verify_token_expiry = date("Y-m-d H:i:s", time() + 3600); // Expires after an hour

        // Hash password
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Insert user with named parameters
        $stmt = $pdo->prepare("INSERT INTO Users 
                              (email, username, password, role,verification_token, verify_token_expiry,status) 
                              VALUES (:email, :username, :password, :role,:verification_token, :verify_token_expiry,'pending')");

        if (
            !$stmt->execute([
                "email" => $_POST['email'],
                "username" => $_POST['username'],
                "password" => $hashed_password,
                "role" => $_POST['role'],
                "verification_token" => $verification_token,
                "verify_token_expiry" => $verify_token_expiry
            ])
        ) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Database error: " . $errorInfo[2]);
        }

        // Send verification email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = SMTP_PORT;

            // Recipients
            $mail->setFrom('yetunde.lms@gmail.com', "Yetunde's Library Management System");
            $mail->addAddress($_POST['email']);

            // Content
            $verificationLink = "http://" . $_SERVER['HTTP_HOST'] . "/CMM007-COURSEWORK/auth/verify_email.html?token=" . urlencode($verification_token);
            // $verificationLink = "http://" . $_SERVER['HTTP_HOST'] . "/CMM007-COURSEWORK/auth/verify_email.html?token=" . urlencode($verificationToken);
                error_log("[DEBUG] Verification Link: " . $verificationLink);
                $mail->isHTML(true);
            $mail->Subject = "Verify Your Account";
            $mail->Body = "An admin created an account for you. Please verify your email address:<br><br>
              <a href=\"$verificationLink\">Verify Email</a><br><br>
              Or copy this link: <code>$verificationLink</code><br><br>
              This link will expire in 1 hour.";

            $mail->send();
            $emailMessage = "Verification email sent to user.";
        } catch (Exception $e) {
            $emailMessage = " User created but verification email failed to send: " . $e->getMessage();
        }

        // Log system action
        $logStmt = $pdo->prepare("INSERT INTO system_logs 
         (user_id, user_role, action_type, target_type, target_id) 
         VALUES (:user_id, 'Admin','create', 'user', :target_id)");
        $logStmt->execute([
            "user_id" => $_SESSION['user_id'],
            "target_id" => $pdo->lastInsertId()
        ]);

        $response = ['status' => 'success', 'message' => 'User added successfully.'];
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $response['message'] = ($e->getCode() == 23000)
            ? 'Email or username already exists.'
            : 'Database error: ' . $e->getMessage();
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>