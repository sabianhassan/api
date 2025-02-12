<?php
session_start();
require_once __DIR__ . '/../classes/Database.php';

$pdo = connectDatabase();
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $message = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            margin: auto;
            margin-top: 100px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="login-container">
    <h3 class="text-center">Admin Login</h3>
    <?php if ($message): ?>
        <div class="alert alert-danger text-center"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

</body>
</html>
