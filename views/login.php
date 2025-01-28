<?php include_once '../templates/header.php'; ?>

<div class="container mt-5" style="min-height: 100vh; display: flex; flex-direction: column; justify-content: space-between;">
    <div>
        <h2>Login</h2>
        <form action="../login_process.php" method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
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
