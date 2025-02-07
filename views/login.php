<?php include_once '../templates/header.php'; ?>

<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #001f3f;">
    <div class="card p-4 shadow-lg text-white" style="width: 400px; border-radius: 10px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
        <h2 class="text-center text-light">Login</h2>
        <form id="loginForm">
            <div class="form-group mb-3">
                <label class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control bg-transparent text-white border-light" required>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control bg-transparent text-white border-light" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        
        <!-- Link to registration page -->
        <div class="mt-3 text-center">
            <p>Don't have an account? <a href="register.php" class="text-light text-decoration-none">Register here</a></p>
        </div>
    </div>
</div>

<?php include_once '../templates/footer.php'; ?>

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
