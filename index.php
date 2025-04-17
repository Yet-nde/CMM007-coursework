<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yetunde's LMS</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
</head>

<body>
    <?php include __DIR__ . '/components/shared_header.php'; ?>
    <div class="d-flex flex-column justify-content-center align-items-center text-center vh-100 bg-light text-info p-4">
  <h1 class="display-4 fw-bold">Welcome to Yetunde's Library</h1>
  <p class="mt-3">Explore a world of books — borrow, return, and manage your library journey with ease.</p>
 
  <a href="/CMM007-coursework/auth/login_display.php" class="btn btn-info">Start Browsing</a>
</div>


</body>

</html>