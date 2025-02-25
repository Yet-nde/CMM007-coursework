<?php
session_start();
error_reporting(E_ALL);
require_once "CMM007_dbconfig.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];
    $quantity = intval($_POST['quantity']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = 'uploads/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $file_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . uniqid() . "-" . $file_name;

        $allowed_types = ['jpg', 'png', 'jpeg'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_types)) {
            echo 'Only JPG,JPEG, and PNG files are allowed.';
            exit();
        }

        if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
            echo 'File size must be less than 5MB.';
            exit();
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            try {
                $query = "INSERT INTO Books (title,author,isbn,genre,quantity,available_quantity,image_path)
                VALUES (:title, :author, :isbn, :genre, :quantity, :quantity, :image_path)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':author', $author);
                $stmt->bindParam(':isbn', $isbn);
                $stmt->bindParam(':genre', $genre);
                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->bindValue(':available_quantity', $quantity, PDO::PARAM_INT);
                $stmt->bindParam(':image_path', $target_file);
                $stmt->execute();

                echo "SQL: " . $query;

                echo 'Book added!';
                header('Location:adminpage.php');
                exit();
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
                error_log("Database error: " . $e->getMessage());
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No file uploaded or error.";
    }
}
?>