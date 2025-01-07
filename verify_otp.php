<?php
require_once 'config/config.php';
require_once 'classes/OTP.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email'])) {
    $db = connectDatabase();
    $otp = new OTP($db);

    $email = $_SESSION['email'];
    $enteredOTP = $_POST['otp'];

    // Log email and entered OTP for debugging
    echo "Debug - Email: $email, Entered OTP: $enteredOTP<br>";

    if ($otp->verifyOTP($email, $enteredOTP)) {
        // OTP verified successfully
        // Optionally, clean up OTP records for the user
        if ($otp->deleteOTP($email)) {
            echo "OTP successfully verified. Record deleted.";
        } else {
            echo "Failed to delete OTP record.";
        }

        // Redirect to the dashboard or any other page
        header("Location: views/dashboard.php");
        exit; // Always call exit after a redirect
    } else {
        echo "Invalid OTP!";
    }
} else {
    echo "Unauthorized access!";
}
?>
