<?php include_once '../templates/header.php'; ?>

<div class="container mt-5" style="min-height: 100vh; display: flex; flex-direction: column; justify-content: space-between;">
    <div>
        <h2>Login</h2>
        <form id="loginForm">
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <!-- Link to registration page -->
        <div class="mt-3">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>

    <?php include_once '../templates/footer.php'; ?>
</div>

<script type="text/javascript">
    // Form submission with AJAX
    document.getElementById("loginForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent form from being submitted in the default way
        
        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;

        var formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);

        // Send AJAX request
        fetch('../login_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Display the alert and redirect if needed
            if (data.status === 'success') {
                alert(data.message);
                window.location.href = data.redirect; // Redirect to OTP verification page
            } else {
                alert(data.message); // If an error occurs, show error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending the login request.');
        });
    });
</script>

