<?php
// function csrfField() {
//     return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
// }
function csrfField() {
    require_once 'security.php';
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}
 ?>



