<?php
session_start();

require_once __DIR__ . '/../../core/CMM007_dbconfig.php';
require_once __DIR__ . '/../../core/helpers.php';
generateCsrfToken();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'User') {
    header("Location: /CMM007-coursework/auth/login_display.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yetunde's LMS User Dahboard</title>
    <link rel="stylesheet" href="/CMM007-coursework/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/CMM007-coursework/assets/css/style.css">
</head>

<body>
    <?php
    include __DIR__ . '/../../components/shared_header.php';
    echo csrfField();
    ?>
    <div class="container">
        <h2> Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <?php include __DIR__ . '/user_books_tab.php'; ?>
    </div>
    <?php include __DIR__ . '/../modals/book_details_modal.php'; ?>

    <?php include __DIR__ . '/../../components/toast.php'; ?>

    <?php include __DIR__ . '/../../components/confirmation_modal.php'; ?>

    <script type="importmap">
{
    "imports": {
        "jquery": "https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"
    }
}
</script>
    <script src="/CMM007-coursework/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/CMM007-coursework/user/js/statusHelper.js"></script>
    <script src="/CMM007-coursework/user/js/confirmationModal.js"></script>
    <script src="/CMM007-coursework/user/js/toastNotification.js"></script>
    <script src="/CMM007-coursework/user/js/bookService.js"></script>
    <script src="/CMM007-coursework/user/js/bookRenderer.js"></script>
    <script src="/CMM007-coursework/user/js/loanRenderer.js"></script>
    <script src="/CMM007-coursework/user/js/app.js"></script>
</body>

</html>