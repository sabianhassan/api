<?php
require_once 'config/config.php';
require_once 'classes/OTP.php';

session_start();
if (isset($_SESSION['email'])) {
    $db = connectDatabase();
    $otp = new OTP($db);

    $email = $_SESSION['email'];
    $newOTP = random_int(100000, 999999);
    $otp->email = $email;
    $otp->otp = $newOTP;
    $otp->created_at = date('Y-m-d H:i:s');
    $otp->saveOTP();

    // Implement Resend API for sending OTP (Resend or any other SMS/Email API)
    // Use $newOTP for the OTP value

    echo "OTP resent!";
} else {
    echo "Unauthorized access!";
}
?>
