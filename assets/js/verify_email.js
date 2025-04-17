$(document).ready(function () {
    // Get the token from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');

    if (!token) {
        showVerificationError("Invalid verification link");
        return;
    }
    
    $.ajax({
        url: '../auth/verify_email.php',
        method: 'GET',
        data: { token: token },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#responseMessage').html(`
                    <div class="alert alert-success">
                        ${response.message} Redirecting to login...
                    </div>
                `);
                setTimeout(() => window.location.href = 'login_display.php', 3000);
            } else {
                showVerificationError(response.message);
            }
        },
        error: function(xhr) {
            const error = xhr.status + ": " + (xhr.responseJSON?.message || "Verification failed");
            showVerificationError(error);
        }
    });
});

function showVerificationError(message) {
    $('#responseMessage').html(`
        <div class="alert alert-danger">
            ${message} Please contact support.
        </div>
    `);
}