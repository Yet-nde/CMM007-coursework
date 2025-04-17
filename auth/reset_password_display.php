<?php
// Start session and load dependencies
require_once __DIR__ . '/../core/CMM007_dbconfig.php';
require_once __DIR__ . '/../core/helpers.php'; 
generateCsrfToken();
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
                        <h2 class="text-center">Reset Password</h2>
                    </div>
                    <div class="card-body">                   
                        
                        <form id="resetPasswordForm">
                        <?php echo csrfField(); ?> 
                            <input type="hidden" name="token" id="token">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password:</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="repeat_password" class="form-label">Repeat Password:</label>
                                <input type="password" class="form-control" id="repeat_password" name="repeat_password" required>
                            </div>
                            <button type="submit" class="btn btn-info w-100">Reset Password</button>
                        </form>

                        <div id="responseMessage"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>     
    <script src="../assets/js/reset_password.js"></script>   
</body>
</html>