<?php
// Start session and load dependencies
session_start();
require_once __DIR__ . '/../core/CMM007_dbconfig.php';
require_once __DIR__ . '/../core/helpers.php';
// Debug: Show the generated token
$token = generateCsrfToken();
echo "<!-- DEBUG: CSRF Token: " . $_SESSION['csrf_token'] . " -->";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CMM007 Login</title>
        <link rel="stylesheet" href="../assets/css/bootstrap.css">
    </head>
<body>
     
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <div class="text-center mb-3">
                    <a href="/CMM007-coursework/index.php" class="text-decoration-none">
                    Yetunde's Library
                    </a>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Forgot Password</h2>
                    </div>
                    <div class="card-body">
                        <form id="forgotPasswordForm">
                        <?php echo csrfField(); ?> 
                            <div class=mb-3>
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-info w-100">Send Reset Link</button>
                        </form>

                        <div class="mt-3">Remember your password?<a href="login_display.php">Log in</a></div>

                        <div id="responseMessage"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/forgot_password.js"></script>   
</body>
</html>