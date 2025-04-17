<?php
session_start();
require_once __DIR__ . '/../../core/CMM007_dbconfig.php';
require_once __DIR__ . '/../../core/helpers.php';
generateCsrfToken();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: /CMM007-coursework/auth/login_display.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CM007 Admin Page</title>
    <link rel="stylesheet" href="/CMM007-coursework/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/CMM007-coursework/assets/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../../components/shared_header.php'; ?>
    <div class="container">
        <h2>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <ul class="nav nav-tabs" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="books-tab" data-bs-toggle="tab" data-bs-target="#books"
                    type="button" role="tab">Books</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button"
                    role="tab">Users</button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">
            <div class="tab-pane fade show active" id="books" role="tabpanel">
                <?php require_once __DIR__ . '/admin_books_tab.php'; ?>
            </div>
            <div class="tab-pane fade" id="users" role="tabpanel">
                <?php require_once __DIR__ . '/admin_users_tab.php'; ?>
            </div>
        </div>

        <?php
        require_once __DIR__ . '/../modals/add_book_modal.php';
        require_once __DIR__ . '/../modals/edit_book_modal.php';
        require_once __DIR__ . '/../modals/add_user_modal.php';
        require_once __DIR__ . '/../modals/edit_user_modal.php';
        require_once __DIR__ . '/../../components/confirmation_modal.php';
        require_once __DIR__ . '/../../components/toast.php'
        // include '../includes/footer.php';
        ?>



        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="/CMM007-coursework/assets/js/bootstrap.bundle.min.js"></script>
        <script type="module" src="/CMM007-coursework/admin/js/main.js"></script>
</body>

</html>