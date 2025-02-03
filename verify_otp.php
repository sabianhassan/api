<?php
require_once 'classes/OTP.php';
session_start();  // Ensure session is started

// Ensure the user is logged in and OTP is set in the session
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email'], $_SESSION['otp'], $_SESSION['otp_expiry'])) {
    $email = $_SESSION['email'];
    $enteredOTP = $_POST['otp'];
    $storedOTP = $_SESSION['otp'];
    $otpExpirationTime = $_SESSION['otp_expiry'];

    // Check if the entered OTP matches and has not expired
    if ($enteredOTP == $storedOTP) {
        if (time() < $otpExpirationTime) {
            // OTP is correct and has not expired
            echo "OTP successfully verified. Proceeding with action.";

            // Invalidate OTP from the session
            unset($_SESSION['otp'], $_SESSION['otp_expiry']);

            // Redirect to the dashboard
            header("Location: views/dashboard.php");
            exit;
        } else {
            echo "OTP has expired. Please request a new one.";
        }
    } else {
        echo "Invalid OTP!";
    }
} else {
    echo "Unauthorized access or OTP not found!";
}
?>
