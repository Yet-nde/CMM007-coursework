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
    <link rel="stylesheet" href="/CMM007-coursework/assets/css/bootstrap.css">
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
                        <h3 class="text-center">Log in</h3>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <?php echo csrfField(); ?>
                            <div class="mb-3">
                                <label for="login" class="form-label">Email or Username</label>
                                <input type="text" class="form-control" id="login" name="login" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="6Lc2DgMrAAAAAMgy5q3YTes07WmOngLg9cQ8DC7i"></div>
                            </div>
                            <button type="submit" class="btn btn-info w-100">Login</button>
                        </form>
                        <div class="mt-3"> Do not have an account? <a href="signup_display.php"> Sign up</a></div>
                        <div class="mt-3">Forgot password? <a href="forgot_password_display.php">Click here</a> </div>
                        <div class="mt-3" id="responseMessage"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/CMM007-coursework/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="/CMM007-coursework/assets/js/validate_login.js"></script>
</body>

</html>