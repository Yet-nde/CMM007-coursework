<?php
header("Content-Type: application/json"); // Set response to JSON

session_start();
require_once __DIR__ . '/../core/middleware.php';
require_once __DIR__ . '/../core/config.php';
validateCsrf(); // Validate CSRF token


// Define maximum login attempts and time window to prevent DDOS and brute-force attacks
define("MAX_LOGIN_ATTEMPTS_PER_IP", 5); // 5 attempts per IP
define("LOGIN_ATTEMPT_WINDOW", 180); // 3 minutes time window

// Google reCAPTCHA Secret Key
$recaptchaSecret = "6Lc2DgMrAAAAABtj5KA_gwVSZhcx-Pu7gEeQqTN-";

// Get the user's IP address
$ip_address = $_SERVER["REMOTE_ADDR"];

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

if (!isset($_POST["login"]) || !isset($_POST["password"]) || !isset($_POST["recaptcha_response"])) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

// Get and sanitize form data
$login = $_POST["login"];
$password = $_POST["password"];
$recaptchaResponse = $_POST['recaptcha_response'];

// Validate reCAPTCHA response
$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
$response = file_get_contents($recaptchaUrl . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
$responseKeys = json_decode($response, true);
if (intval($responseKeys['success']) !== 1) {
    echo json_encode(["success" => false, "message" => "reCAPTCHA verification failed"]);
    exit;
}

// Check IP-based rate limiting
try {
    $interval = intval(LOGIN_ATTEMPT_WINDOW);
    $stmt = $pdo->prepare("SELECT COUNT(*) AS attempt_count FROM login_attempts WHERE ip_address = :ip_address AND attempt_time > (NOW() - INTERVAL $interval SECOND)");
    $stmt->execute(["ip_address" => $ip_address]);
    $attempt_count = $stmt->fetch(PDO::FETCH_ASSOC)["attempt_count"];

    // Block if attempts exceed max login attempts
    if ($attempt_count >= MAX_LOGIN_ATTEMPTS_PER_IP) {
        echo json_encode(["success" => false, "message" => "Too many login attempts from your IP. Please reset password."]);
        exit;
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    exit;
}

// Check if the provided login is email or username
if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
    // Login is an email
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->execute([$login]);
} else {
    // Login is a username
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->execute([$login]);
     
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Check if user is active
    if ($user['status'] !== 'active') {
        echo json_encode([
            'success' => false,
            'message' => 'Account inactive'
        ]);
        exit;
    }
    // Check if user is verified
    if (!$user["verified"]) {
        echo json_encode(["success" => false, "message" => "Your account is not verified."]);
        exit;
    }

    // Verify password
    if (password_verify($password, $user["password"])) {
        session_regenerate_id(true);
        // Set session variables
        $_SESSION = [
            'user_id' => $user['user_id'],
            'role' => $user['role'],
            'username' => $user['username']
        ];

        session_write_close();

        // Log successful login attempt
        $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE ip_address=:ip_address");
        $stmt->execute(["ip_address" => $ip_address]);
        echo json_encode(["success" => true, "message" => "Login successful", "role" => $user["role"]]);
    } else {
        // Log failed login attempt
        $stmt = $pdo->prepare("INSERT INTO login_attempts(ip_address,attempt_time) VALUES (:ip_address,NOW())");
        $stmt->execute(["ip_address" => $ip_address]);

        echo json_encode(["success" => false, "message" => "Invalid credentials"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid credentials"]);
}
$pdo = null; // Close connection
?>