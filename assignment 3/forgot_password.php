<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a unique code and expiry time
        $code = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime('+10 minutes'));

        // Update user table with the code and expiry
        $stmt = $pdo->prepare("UPDATE users SET code = :code, code_expiry = :expiry WHERE email = :email");
        $stmt->execute(['code' => $code, 'expiry' => $expiry, 'email' => $email]);

        // Send the reset code to the user's email (using mail function)
        $subject = "Password Reset Code";
        $message = "Your password reset code is: $code";
        $headers = "From: noreply@example.com";
        mail($email, $subject, $message, $headers);

        // Redirect to verify_code page
        header("Location: verify_code.php?email=$email");
        exit;
    } else {
        $error = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Submit</button>
    </form>
    <?php if (!empty($error)) echo "<p>$error</p>"; ?>
</body>
</html>
