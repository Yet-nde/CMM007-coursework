<?php
session_start();

require_once __DIR__ . '/../../core/CMM007_dbconfig.php';
header('Content-Type: application/json');

// Input validation
$allowedSorts = ['title_asc', 'title_desc', 'author_asc', 'author_desc', 'popular'];
$allowedAvailability = ['all', 'available', 'unavailable'];

$filters = [
    'genre' => isset($_GET['genre']) ? trim($_GET['genre']) : '',
    'availability' => isset($_GET['availability']) && in_array($_GET['availability'], $allowedAvailability) 
                    ? $_GET['availability'] : 'all',
    'sort' => isset($_GET['sort']) && in_array($_GET['sort'], $allowedSorts) 
             ? $_GET['sort'] : 'title_asc',
    'search' => isset($_GET['search']) ? trim($_GET['search']) : ''
];

// Sanitize inputs
$filters['genre'] = filter_var($filters['genre'], FILTER_SANITIZE_STRING);
$filters['search'] = filter_var($filters['search'], FILTER_SANITIZE_STRING);

try {
    $sql = "SELECT b.book_id, b.title, b.author, b.genre, b.isbn,
        b.available_quantity, b.image_path,
        (SELECT COUNT(*) FROM Loans l WHERE l.book_id = b.book_id) as popularity
    FROM Books b 
    WHERE b.deleted_at IS NULL";
    
    $params = [];
    
       // Validate genre against database
       if (!empty($filters['genre'])) {
        $genreCheck = $pdo->prepare("SELECT 1 FROM Books WHERE LOWER(genre) = LOWER(?) LIMIT 1");
        $genreCheck->execute([$filters['genre']]);
        if (!$genreCheck->fetch()) {
            $filters['genre'] = ''; // Ignore invalid genre
        } else {
            $sql .= " AND LOWER(b.genre) = LOWER(?)"; 
            $params[] = $filters['genre'];
        }
    }
    
    if ($filters['availability'] === 'available') {
        $sql .= " AND b.available_quantity > 0";
    } elseif ($filters['availability'] === 'unavailable') {
        $sql .= " AND b.available_quantity <= 0";
    }
    
    if (!empty($filters['search'])) {
        $searchTerm = "%" . str_replace(' ', '%', $filters['search']) . "%";
        $sql .= " AND (LOWER(b.title) LIKE LOWER(?) OR LOWER(b.author) LIKE LOWER(?) OR LOWER(b.isbn) LIKE LOWER(?))";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
    }
    
    // Apply sorting
    switch ($filters['sort']) {
        case 'title_desc': 
            $sql .= " ORDER BY b.title DESC"; 
            break;
        case 'author_asc': 
            $sql .= " ORDER BY b.author ASC, b.title ASC"; 
            break;
        case 'author_desc': 
            $sql .= " ORDER BY b.author DESC, b.title DESC"; 
            break;
        case 'popular': 
            $sql .= " ORDER BY popularity DESC, b.title ASC"; 
            break;
        default: 
            $sql .= " ORDER BY b.title ASC"; 
            break;
    }
    

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $books,
        
    ]);
        
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error'
    ]);
}

?>

