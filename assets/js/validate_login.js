$("#loginForm").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    // Get reCAPTCHA response
    const recaptchaResponse = grecaptcha.getResponse();
    if (!recaptchaResponse) {
        $('#responseMessage').html('<p style="color: red;">Please complete the CAPTCHA.</p>');
        return;
    }

    // Get login form data
    const loginFormData = {
        login: $('#login').val().trim(), // Either email or username
        password: $('#password').val().trim(),
        recaptcha_response: recaptchaResponse,
        csrf_token: $('input[name="csrf_token"]').val().trim()
    };

    // Validate all fields are filled
    if (!loginFormData.login || !loginFormData.password) {
        $('#responseMessage').html('<p style="color: red;">All fields are required</p>');
        return;
    }

    // Send AJAX request
    $.post(
        'login_handler.php',
        loginFormData,
        function (response) {
            try {
                const result = typeof response === "string" ? JSON.parse(response) : response;
                if (result.success) {
                    // Redirect based on role
                    if (result.role === "Admin") {
                        console.log("Role received:", result.role);
                        window.location.href = "../admin/views/adminDashboard.php";
                    } else {
                        window.location.href = "../user/views/userDashboard.php";
                    }
                } else {
                    $('#responseMessage').html('<p style="color: red;">' + result.message + '</p>');
                }
            }
            catch (e) {
                $('#responseMessage').html('<p style="color: red;">Invalid response from server</p>');
            }
        }
    ).fail(function (xhr, status, error) {
        const errorMessage = xhr.responseText ? xhr.responseText : "Unknown error occurred";
        $('#responseMessage').html('<p style="color: red;">An error occurred: ' + errorMessage + '</p>');
    });
});
