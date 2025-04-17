<?php
header('Content-Type: application/json'); 

require_once __DIR__ . '/../../core/middleware.php';
validateCsrf(); // Validate CSRF token


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['status' => 'error', 'message' => ''];

    try {
        // Validate input
        $required = ['title', 'author', 'isbn', 'genre', 'quantity'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields.");
            }
        }

        // Validate ISBN format and check for duplicates
        if (!preg_match('/^[0-9]{10,13}$/', $_POST['isbn'])) {
            throw new Exception("Invalid ISBN format");
        }
        
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Books WHERE isbn = ?");
        $stmt->execute([$_POST['isbn']]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("A book with this ISBN already exists.");
        }

        // Validate quantity
        if (!filter_var($_POST['quantity'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            throw new Exception("Quantity must be a positive integer.");
        }

        // Handle file upload
        if (empty($_FILES['image']['name'])) {
            throw new Exception("Please select an image.");
        }

        $targetDir = __DIR__ . '/../../uploads/';
        $webPath = '../../uploads/';

        // Create directory if it doesn't exist
        if (!file_exists($targetDir)) {
            if (!mkdir($targetDir, 0750, true)) { // More restrictive permissions
                throw new Exception("Could not create upload directory.");
            }
        }

        if (!is_writable($targetDir)) {
            throw new Exception("Upload directory is not writable.");
        }

        // Sanitize filename
        $originalName = preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES["image"]["name"]));
        $fileName = uniqid() . '_' . $originalName;
        $targetFile = $targetDir . $fileName;

        // Check if image file is a actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            throw new Exception("File is not an image.");
        }

        // Check file size (5MB max)
        if ($_FILES["image"]["size"] > 5000000) {
            throw new Exception("File is too large. Maximum size is 5MB.");
        }

        // Allow certain file formats
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            throw new Exception("Only JPG, JPEG & PNG files are allowed.");
        }

        // Move uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            throw new Exception("Error uploading file.");
        }
        
        if (!file_exists($targetFile)) {
            throw new Exception("File upload failed: no file saved.");
        }

        // Insert book
        $stmt = $pdo->prepare("INSERT INTO Books 
                              (title, author, isbn, genre, quantity, available_quantity, image_path) 
                              VALUES (:title, :author, :isbn, :genre, :quantity, :available_quantity, :image_path)");

        $stmt->execute([
            "title" => $_POST['title'],
            "author" => $_POST['author'],
            "isbn" => $_POST['isbn'],
            "genre" => $_POST['genre'],
            "quantity" => $_POST['quantity'],
            "available_quantity" => $_POST['quantity'],
            "image_path" => 'uploads/' . $fileName
        ]);

        // Log system action
        $logStmt = $pdo->prepare("INSERT INTO system_logs 
                                 (user_id, user_role, action_type, target_type, target_id) 
                                 VALUES (:user_id, 'Admin','create', 'book', :target_id)");
        $logStmt->execute([
            "user_id" => $_SESSION['user_id'],
            "target_id" => $pdo->lastInsertId()
        ]);

        $response = ['status' => 'success', 'message' => 'Book added successfully.'];
    } catch (PDOException $e) {
        // Clean up uploaded file if database operation fails
        if (isset($targetFile) && file_exists($targetFile)) {
            unlink($targetFile);
        }
        $response['message'] = 'Database error: ' . $e->getMessage();
    } catch (Exception $e) {
        // Clean up uploaded file if any other error occurs
        if (isset($targetFile) && file_exists($targetFile)) {
            unlink($targetFile);
        }
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
    exit();
}
?>