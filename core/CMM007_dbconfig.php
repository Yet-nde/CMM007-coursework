<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include security functions
require_once 'security.php';

$host = 'localhost';
$dbname = '007';
$username = 'root';
$password = '';

try {
      // Create a PDO instance with charset specification
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("DB Connection Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database connection error']);
    exit();
}
?>