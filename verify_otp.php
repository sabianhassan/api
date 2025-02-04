<?php
require_once 'classes/OTP.php';
session_start();  // Ensure session is started

// Debugging: Print the session data
echo "<pre>Session Data: ";
print_r($_SESSION);
echo "</pre>";

// Ensure OTP is set in the session before processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expires_at'])) {
        die("Error: OTP not found in session. Please request a new OTP.");
    }

    // Retrieve OTP and expiration time from session
    $storedOTP = $_SESSION['otp'];
    $otpExpirationTime = $_SESSION['otp_expires_at']; // Corrected session key

    // Retrieve OTP entered by user
    $enteredOTP = trim($_POST['otp']); // Remove whitespace

    // Debugging: Print values to check if they match
    echo "Stored OTP: $storedOTP <br>";
    echo "Entered OTP: $enteredOTP <br>";
    echo "Current Time: " . time() . "<br>";
    echo "OTP Expiration Time: $otpExpirationTime <br>";

    // Check if the OTP matches and has not expired
    if ((string)$enteredOTP === (string)$storedOTP) {
        if (time() < $otpExpirationTime) {
            echo "OTP successfully verified. Proceeding with action.";

            // Invalidate OTP from the session after successful verification
            unset($_SESSION['otp'], $_SESSION['otp_expires_at']);

            // Redirect to the dashboard
            header("Location: views/dashboard.php");
            exit;
        } else {
            echo "Error: OTP has expired. Please request a new one.";
        }
    } else {
        echo "Error: Invalid OTP!";
    }
} else {
    echo "Error: Unauthorized access!";
}
?>