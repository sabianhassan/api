<?php include_once '../templates/header.php'; ?>

<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #001f3f;">
    <div class="card p-4 shadow-lg text-white" style="width: 400px; border-radius: 10px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
        <h2 class="text-center text-light">User Registration</h2>
        <form action="../submit_register.php" method="POST">
            <div class="form-group mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control bg-transparent text-white border-light" required>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control bg-transparent text-white border-light" required>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control bg-transparent text-white border-light" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        
        <!-- Link to Login Page -->
        <div class="mt-3 text-center">
            <p>Already have an account? <a href="login.php" class="text-light text-decoration-none">Login here</a></p>
        </div>
    </div>
</div>

<?php include_once '../templates/footer.php'; ?>
