<?php
session_start();
header("Content-Type: application/json"); // set response to json

require_once __DIR__ . '/../core/middleware.php';
require_once __DIR__ . '/../core/config.php';

validateCsrf(); // Validate CSRF token

// Load PHPMailer
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';
require __DIR__ . '/../PHPMailer/src/Exception.php';

// Use PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



// Validate request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate required fields
    if (!isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["repeat_password"]) || !isset($_POST["role"]) || !isset($_POST["g-recaptcha-response"])) {
        echo json_encode(["success" => false, "message" => "All fields are required"]);
        exit();
    }

    // Get and sanitize form data
    $username = htmlspecialchars($_POST["username"]); // Prevent XSS
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); // Sanitize email
    $password = $_POST["password"];
    $repeat_password = $_POST["repeat_password"];
    $role = htmlspecialchars($_POST["role"]); // Prevent XSS
    $recaptcha = $_POST['g-recaptcha-response'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email format"]);
        exit();
    }

    // Validate email domain
    function validateEmailDomain($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, "MX");
    }

    if (!validateEmailDomain($email)) {
        echo json_encode(["success" => false, "message" => "Invalid email domain"]);
        exit();
    }

    // Validate password length
    if (strlen($password) < 8) {
        echo json_encode(["success" => false, "message" => "Password must be at least 8 characters"]);
        exit();
    }

    // Validate password complexity
    $passwordRegex = "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?\":{}|<>]).+$/";
    if (!preg_match($passwordRegex, $password)) {
        echo json_encode(["success" => false, "message" => "Password must include a capital letter, a number, and a special character."]);
        exit();
    }

    // Validate password match
    if ($password !== $repeat_password) {
        echo json_encode(["success" => false, "message" => "Passwords do not match"]);
        exit();
    }

    // Verify reCAPTCHA
    $recaptchaSecret = '6Lc2DgMrAAAAABtj5KA_gwVSZhcx-Pu7gEeQqTN-';
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";
    $recaptchaData = file_get_contents($recaptchaUrl . "?secret=" . $recaptchaSecret . "&response=" . $recaptcha);
    $recaptchaData = json_decode($recaptchaData, true);
    if (!$recaptchaData || !isset($recaptchaData['success'])) {
        echo json_encode(["success" => false, "message" => "reCAPTCHA verification failed: " . $recaptchaResponse]);
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if username and email already exist in the database
    try {
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE username= :username OR email= :email");
        $stmt->execute(["username" => $username, "email" => $email]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => false, "message" => "Username or email already exists"]);
            exit();
        }

        // Generate a unique verification token
        $verification_token = bin2hex(random_bytes(32));
        $verify_token_expiry = date("Y-m-d H:i:s", time() + 3600); // Expires after an hour

        // Insert new user with verification details
        $stmt = $pdo->prepare("INSERT INTO Users (username, email, password, role, verification_token, verify_token_expiry,status) 
                                VALUES (:username, :email, :password, :role, :verification_token, :verify_token_expiry,'pending')");

        $stmt->execute([
            "username" => $username,
            "email" => $email,
            "password" => $hashed_password,
            "role" => $role,
            "verification_token" => $verification_token,
            "verify_token_expiry" => $verify_token_expiry
        ]);

        // Send verification email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;  // Set the SMTP server to Gmail
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS encryption
            $mail->Port = SMTP_PORT; // TCP port to connect to

            // Recipients
            $mail->setFrom('yetunde.lms@gmail.com', "Yetunde's Library Management System");
            $mail->addAddress($email);

            // Content

            $verificationLink = "http://" . $_SERVER['HTTP_HOST'] . "/CMM007-COURSEWORK/auth/verify_email.html?token=" . urlencode($verification_token);
            $mail->isHTML(true);
            $mail->Subject = "Verify your email address";
            $mail->Body = "Click the link below to verify your email address. This link will expire in an hour:<br><br><a href='$verificationLink'>$verificationLink</a>";

            // Send the email
            $mail->send();
            echo json_encode(["success" => true, "message" => "Please check your email to verify your account"]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Failed to send email: " . $mail->ErrorInfo]);
        }

    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Signup failed: " . $e->getMessage()]);
    }
}
?>