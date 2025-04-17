<?php
require_once __DIR__ . '/../../core/middleware.php';
validateCsrf(); // Validate CSRF token


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: up_login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['status' => 'error', 'message' => ''];

    try {
        // Validate required fields
        $required = ['title', 'author', 'isbn', 'genre', 'quantity'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields.");
            }
        }

        // Get current book data
        $stmt = $pdo->prepare("SELECT * FROM Books WHERE book_id = ?");
        $stmt->execute([(int) $_POST['book_id']]);
        $currentBook = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$currentBook) {
            throw new Exception("Book not found in database");
        }

        // Handle image upload if provided
        $imagePath = $currentBook['image_path'];
        if (!empty($_FILES['image']['name'])) {
            $targetDir = __DIR__ . '/../../uploads/';
            $fileName = uniqid() . '_' . basename($_FILES["image"]["name"]);
            $targetFile = $targetDir . $fileName;
            $webPath = '/uploads/' . $fileName;

            // Validate image (same as add book)
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                throw new Exception("File is not an image.");
            }
            if ($_FILES["image"]["size"] > 5000000) {
                throw new Exception("File is too large. Maximum size is 5MB.");
            }
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed.");
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imagePath = $webPath;
                // Delete old image if it exists
                if (!empty($currentBook['image_path'])) {
                    $oldImagePath = __DIR__ . '/../../' . $currentBook['image_path'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            } else {
                throw new Exception("Error uploading file.");
            }
        }

        // Update book
        $stmt = $pdo->prepare("UPDATE Books SET 
            title = :title,
            author = :author,
            isbn = :isbn,
            genre = :genre,
            quantity = :quantity,
            available_quantity = available_quantity + (:quantity - :old_quantity),
            image_path = :image_path
            WHERE book_id = :book_id");

        $stmt->execute([
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'isbn' => $_POST['isbn'],
            'genre' => $_POST['genre'],
            'quantity' => $_POST['quantity'],
            'old_quantity' => $currentBook ? $currentBook['quantity'] : 0,
            'image_path' => $imagePath,
            'book_id' => $_POST['book_id']
        ]);

        // Log system action
        $logStmt = $pdo->prepare("INSERT INTO system_logs 
                                 (user_id, user_role, action_type, target_type, target_id) 
                                 VALUES (:user_id, 'Admin','update', 'book', :target_id)");
        $logStmt->execute([
            "user_id" => $_SESSION['user_id'],
            "target_id" => $_POST['book_id']
        ]);

        $response = ['status' => 'success', 'message' => 'Book updated successfully'];
    } catch (PDOException $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>