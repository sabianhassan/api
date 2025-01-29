<?php
//require_once 'config/config.php'; // Assuming this includes necessary DB connection
require_once 'classes/OTP.php';



// Ensure the user is logged in (i.e., the email is present in the session)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email'])) {
    $db = connectDatabase();  // Assuming connectDatabase() connects to your DB if needed (this can be commented out if not needed)
    $otp = new OTP($db);  // Create the OTP class instance if DB interaction is needed, or remove the line if unused

    $email = $_SESSION['email'];
    $enteredOTP = $_POST['otp'];

    // Log email and entered OTP for debugging
    echo "Debug - Email: $email, Entered OTP: $enteredOTP<br>";

    // Retrieve OTP and expiration timestamp from the session
    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expires_at'])) {
        $storedOTP = $_SESSION['otp'];  // The OTP stored in session
        $otpExpirationTime = $_SESSION['otp_expires_at'];  // The expiration timestamp from session
        
        // Check if the entered OTP matches the stored one and has not expired
        if ($enteredOTP == $storedOTP) {
            if (time() < $otpExpirationTime) {
                // OTP is correct and has not expired
                echo "OTP successfully verified. Proceeding with action.";

                // Optionally, clear OTP after verification if required
                unset($_SESSION['otp']);
                unset($_SESSION['otp_expires_at']);

                // Redirect to the dashboard or any other page
                header("Location: views/dashboard.php");
                exit; // Always call exit after a redirect
            } else {
                echo "OTP has expired. Please request a new one.";
            }
        } else {
            echo "Invalid OTP!";
        }
    } else {
        echo "No OTP found in session!";
    }
} else {
    echo "Unauthorized access!";
}
?>
