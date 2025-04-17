<?php
if (!isset($_SESSION)) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$is_admin = false;
if ($isLoggedIn) {
    $is_admin = ($_SESSION['role'] ?? '') === 'Admin';
}
?>
<header class="mb-5 sticky-top">
    <nav class="navbar bg-light shadow-sm">
        <div class="container">
            <a href="/CMM007-coursework/index.php" class="navbar-brand fw-bold text-info fs-3">Yetunde's Library Management System</a>
            <!-- Right-side Menu -->
            <div class="d-flex">
                <?php if ($isLoggedIn): ?>
                    <!--- Logged-in Content --->
                <?php if (!$is_admin): ?>
                <span id="borrowedLimitBadge" class="badge bg-info me-3">
                    Books: <span id="currentBorrowCount">0</span>/5
                </span>
                <a href="/CMM007-coursework/user/views/userDashboard.php" class="btn btn-info me-2">Dashboard</a>
                <?php else: ?>
                <a href="/CMM007-coursework/admin/views/adminDashboard.php" class="btn btn-info me-2">Dashboard</a>
                <?php endif; ?>
                <button type="button" class="btn btn-outline-info" id="logoutButton">Log Out</button>
                <?php else: ?>
                <!--- Logged-out Content --->
                <a href="/CMM007-coursework/auth/login_display.php" class="btn btn-outline-info me-2">Log In</a>
                <a href="/CMM007-coursework/auth/signup_display.php" class="btn btn-info">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/CMM007-coursework/assets/js/logout.js"></script>
<?php if ($isLoggedIn): ?>
<script>
    // Pass minimal required data to JS
    window.sharedHeaderData = {
        isAdmin: <?= $is_admin ? 'true' : 'false' ?>
    };
</script>
<?php endif; ?>