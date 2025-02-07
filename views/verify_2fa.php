<?php 
session_start();
include_once '../templates/header.php'; 

// Store user details from registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Generate and send OTP (You'll need an email function for this)
    $_SESSION['otp'] = rand(100000, 999999); // Example OTP
    mail($_SESSION['email'], "Your OTP Code", "Your OTP is: " . $_SESSION['otp']);

    echo "<p class='text-success'>OTP sent to your email.</p>";
}
?>

<div class="container mt-5">
    <h2>Verify 2FA</h2>
    <form action="../verify_otp.php" method="POST">
        <div class="form-group">
            <label>Enter OTP</label>
            <input type="text" name="otp" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
    <form action="../resend_otp.php" method="POST" class="mt-3">
        <button type="submit" class="btn btn-secondary">Resend OTP</button>
    </form>
</div>

<?php include_once '../templates/footer.php'; ?>
