<?php
require_once 'classes/OTP.php';

// Ensure the user is logged in (i.e., the email is present in the session)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email'])) {
    // Database connection
    $db = connectDatabase();  // Assuming connectDatabase() connects to your DB
    $otp = new OTP($db);  // Create the OTP class instance if DB interaction is needed

    $email = $_SESSION['email'];
    $enteredOTP = $_POST['otp'];

    // Log email and entered OTP for debugging
    echo "Debug - Email: $email, Entered OTP: $enteredOTP<br>";

    // Retrieve the OTP and expiration time from the database
    $stmt = $db->prepare("SELECT otp_code, expiry_time FROM otp_verifications WHERE user_email = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Retrieve OTP and expiration time from the database record
        $storedOTP = $row['otp_code'];
        $otpExpirationTime = strtotime($row['expiry_time']);  // Convert expiry_time to timestamp

        // Log the OTP for debugging (REMOVE in production!)
        echo "Debug - Stored OTP: $storedOTP, Expiry Time: $otpExpirationTime<br>";

        // Check if the entered OTP matches and has not expired
        if ($enteredOTP == $storedOTP) {
            if (time() < $otpExpirationTime) {
                // OTP is correct and has not expired
                echo "OTP successfully verified. Proceeding with action.";

                // Invalidate OTP in the database (remove it after successful verification)
                $otp->invalidateOtp($email);  // Call invalidateOtp method to remove OTP from the database

                // Redirect to the dashboard or any other page
                header("Location: views/dashboard.php");
                exit;  // Always call exit after a redirect
            } else {
                echo "OTP has expired. Please request a new one.";
            }
        } else {
            echo "Invalid OTP!";
        }
    } else {
        echo "No OTP found in the database for this email!";
    }
} else {
    echo "Unauthorized access!";
}
?>
