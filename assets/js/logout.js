$(document).ready(function() {
    $('#logoutButton').click(function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to log out?')) {
            $.post('/CMM007-coursework/auth/logout.php')
                .always(function() {
                    window.location.href = '/CMM007-coursework/auth/login_display.php';
                });
        }
    });
});
