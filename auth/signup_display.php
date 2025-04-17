<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1); 

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
    <title>CMM007 Signup</title>
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
                        <h3 class="text-center">Sign Up</h3>
                    </div>
                    <div class="card-body">
                        <form id="signupForm" method="POST" action="signup_handler.php">
                            <?php echo csrfField(); ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="repeat_password" class="form-label">Repeat Password</label>
                                <input type="password" class="form-control" id="repeat_password" name="repeat_password"
                                    required>
                                <small id="password-message" class="text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="User">User</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="6Lc2DgMrAAAAAMgy5q3YTes07WmOngLg9cQ8DC7i"
                                    name="g-recaptcha-response"></div>
                            </div>
                            <button type="submit" class="btn btn-info w-100">Signup</button>
                        </form>
                        <div class="mt-3">Already a user? <a href="login_display.php">Login</a></div>
                        <div id="responseMessage"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="../assets/js/validate_signup.js"></script>
</body>

</html>