<?php
require 'db.php';
$email = $_GET['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Update the user's password and clear the reset code
    $stmt = $pdo->prepare("UPDATE users SET password = :password, code = NULL, code_expiry = NULL WHERE email = :email");
    $stmt->execute(['password' => $password, 'email' => $email]);

    $success = "Password successfully reset!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <form method="POST">
        <label>New Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Reset</button>
    </form>
    <?php if (!empty($success)) echo "<p>$success</p>"; ?>
</body>
</html>
