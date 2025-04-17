<?php

require_once __DIR__ . '/../../core/CMM007_dbconfig.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT DISTINCT genre FROM Books WHERE genre IS NOT NULL ORDER BY genre");
    $genres = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($genres);
} catch (PDOException $e) {
    echo json_encode([]);
}