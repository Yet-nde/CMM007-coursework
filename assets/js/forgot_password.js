$("#forgotPasswordForm").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    console.log("Form Data:",{
        email: $('#email').val(),
        csrf_token: $('input[name="csrf_token"]').val() || "MISSING_CSRF_IN_FORM"
    });
    // Get form data
    const email = $('#email').val().trim();
  

    // Validate email format
    const emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailFormat.test(email)) {
        $('#responseMessage').html('<p style="color: red;">Invalid email format</p>');
        return;
    }

    // Send AJAX request
    $.post(
        '/CMM007-coursework/auth/forgot_password_handler.php',
        {
            email: email,
            csrf_token: $('input[name="csrf_token"]').val().trim()
        },
        function (response) {
            try {
                const result = typeof response === "string" ? JSON.parse(response) : response;
                if (result.success) {
                    $('#responseMessage').html('<p style="color: green;">A password reset link has been sent to your email. Check the spam folder.</p>');
                } else {
                    $('#responseMessage').html('<p style="color: red;">' + result.message + '</p>');
                }
            } catch (e) {
                console.error("JSON parse error:", e, "Response:", response);
                $('#responseMessage').html('<p style="color: red;">Invalid response from server</p>');
            }
        }
    ).fail(
        function (xhr, status, error) {
            console.error("Error response:", xhr.responseText);
            $('#responseMessage').html('<p style="color: red;">An error occurred: ' + error + '</p>');
        }
    );
});