<?php
require_once __DIR__ . '/../../core/CMM007_dbconfig.php';

if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit(json_encode(['status' => 'error', 'message' => 'Unauthorized']));
}

$type = $_GET['type'] === 'book' ? 'Books' : 'Users';
$idField = $_GET['type'] . '_id';
$id = $_GET['id'];

// Debug output
error_log("Fetching item - Type: $type, ID: $id");

try {
    $stmt = $pdo->prepare("SELECT * FROM $type WHERE $idField = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        error_log("Item not found - Type: $type, ID: $id");
        header('HTTP/1.1 404 Not Found');
        exit(json_encode([
            'status' => 'error',
            'message' => "$type not found",
            'debug' => ["type" => $type, "id" => $id]
        ]));
    }

    header('Content-Type: application/json');
    echo json_encode($item);
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
}
?>