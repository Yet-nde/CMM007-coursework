
$("#signupForm").on("submit", async function (event) {
    event.preventDefault();

    // Get recaptcha response
    const recaptchaResponse = grecaptcha.getResponse();
    if (!recaptchaResponse) {
        $('#responseMessage').html('<p style="color: red;">Please complete the reCAPTCHA.</p>');
        grecaptcha.reset();
        return;
    }

    // Get sign up form data
    const signupFormData = {
        username: $('#username').val().trim(),
        email: $('#email').val().trim(),
        password: $('#password').val().trim(),
        repeat_password: $('#repeat_password').val().trim(),
        role: $('#role').val(), 
        'g-recaptcha-response': recaptchaResponse,
        csrf_token: $('input[name="csrf_token"]').val().trim()
    };

    // Validate all fields are filled
    if (!signupFormData.username || !signupFormData.email || !signupFormData.password || !signupFormData.repeat_password || !signupFormData.role) {
        $('#responseMessage').html('<p style="color: red;">All fields are required.</p>');
        return;
    }

    // Validate email format
    const emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailFormat.test(signupFormData.email)) {
        $('#responseMessage').html('<p style="color: red;">Invalid email format.</p>');
        return;
    }

    // Validate password length
    if (signupFormData.password.length < 8) {
        $('#responseMessage').html('<p style="color: red;">Password must be at least 8 characters long.</p>');
        return;
    }

    // Validate password complexity (uppercase letter, number, special character)
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).+$/;
    if (!passwordRegex.test(signupFormData.password)) {
        $('#responseMessage').html('<p style="color: red;">Password must include a capital letter, a number, and a special character.</p>');
        return;
    }

    // Validate password match
    if (signupFormData.password !== signupFormData.repeat_password) {
        $('#responseMessage').html('<p style="color: red;">Passwords do not match.</p>');
        return;
    }

    $.ajax({
        type: "POST",
        url: "../auth/signup_handler.php",
        data: signupFormData,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $('#responseMessage').html('<p style="color: green;">' + response.message + '</p>');
                $("#signupForm")[0].reset();
                grecaptcha.reset();
            } else {
                $('#responseMessage').html('<p style="color: red;">' + response.message + '</p>');
            }
        },
        error: function (xhr, status, error) {
            try {
                const response = JSON.parse(xhr.responseText);
                $('#responseMessage').html('<p style="color: red;">' + response.message + '</p>');
            } catch (e) {
                
                $('#responseMessage').html('<p style="color: red;">An error occurred: ' + error + '</p>');
            }
        }
    });
    
})