$(document).ready(function () {
    // Get the token from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');
    if (!token) {
        $('#responseMessage').html('<p style="color: red;">Invalid reset link.</p>');
        $('#resetPasswordForm').hide(); 
    } else {
        $('#token').val(token); // Set the token in the hidden input
    }
});

// Attach form submission handler
$("#resetPasswordForm").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    // Get reset password form data
    const resetFormData = {
        token: $("#token").val(),
        new_password: $("#new_password").val().trim(),
        repeat_password: $("#repeat_password").val().trim(),
        csrf_token: $('input[name="csrf_token"]').val().trim()
    };

    //validate password length
    if (resetFormData.new_password.length < 8) {
        $('#responseMessage').html('<p style="color: red"> Password must be at least 8 characters</p>');
        return;
    }

    // validate password match
    if (resetFormData.new_password !== resetFormData.repeat_password) {
        $('#responseMessage').html('<p style="color: red;">Passwords do not match</p>');
        return;
    }

    //send AJAX request
    $.post(
        '../auth/reset_password_handler.php',
        resetFormData,
        function (response) {
            try {
                const result = typeof response === "string" ? JSON.parse(response) : response;
                if (result.success) {
                    $('#responseMessage').html('<p style="color: green;">' + result.message + '</p>');
                    // Redirect to login page after a short delay
                    setTimeout(()=>{
                        window.location.href = result.redirect;
                    }, 2000); // 2 seconds delay
                    
                } else {
                    $('#responseMessage').html('<p style="color: red;">' + result.message + '</p>');
                }
            }
            catch (e) {
                $('#responseMessage').html('<p style="color: red;">Invalid response from server</p>');
            }

        }
    ).fail(
        function (xhr, status, error) {
            $('#responseMessage').html('<p style="color: red;">An error occurred:' + error + '</p>');
        }
    );
});