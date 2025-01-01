<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
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
</div>

<?php include_once '../templates/footer.php'; ?>
