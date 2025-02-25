<?php
session_start();
error_reporting(E_ALL);
require_once "CMM007_dbconfig.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $query = "INSERT INTO Users (username, email, password, role) VALUES (:username, :email, :password, :role)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        // Redirect to the admin dashboard or user list page
        header("Location: adminpage.php");
        exit();
    } else {
        echo "Error adding user.";
    }
}
?>

