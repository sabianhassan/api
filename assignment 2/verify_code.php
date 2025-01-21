<?php
require 'db.php';
$email = $_GET['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];

    // Check if the code is valid
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND code = :code");
    $stmt->execute(['email' => $email, 'code' => $code]);
    $user = $stmt->fetch();

    if ($user) {
        $expiry = strtotime($user['code_expiry']);
        if (time() > $expiry) {
            $error = "Code has expired!";
        } else {
            // Redirect to reset_password
            header("Location: reset_password.php?email=$email");
            exit;
        }
    } else {
        $error = "Invalid code!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Code</title>
</head>
<body>
    <h1>Verify Code</h1>
    <form method="POST">
        <label>Enter Code:</label>
        <input type="text" name="code" required>
        <button type="submit">Verify</button>
    </form>
    <?php if (!empty($error)) echo "<p>$error</p>"; ?>
</body>
</html>
