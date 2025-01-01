<?php
require_once 'config/config.php';
require_once 'classes/OTP.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email'])) {
    $db = connectDatabase();
    $otp = new OTP($db);

    $email = $_SESSION['email'];
    $enteredOTP = $_POST['otp'];

    if ($otp->verifyOTP($email, $enteredOTP)) {
        // OTP verified successfully
        // Optionally, clean up OTP records for the user
        $otp->deleteOTP($email);

        header("Location: views/dashboard.php");
    } else {
        echo "Invalid OTP!";
    }
} else {
    echo "Unauthorized access!";
}
?>
