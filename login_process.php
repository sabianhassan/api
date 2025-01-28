<?php
// Include necessary classes and functions
require_once 'classes/User.php';
require_once 'classes/OTP.php';

date_default_timezone_set('Africa/Nairobi'); // Set time zone

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "An error occurred."];

    try {
        // Database connection
        $db = connectDatabase();
        $user = new User($db);

        // Retrieve and sanitize input
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            throw new Exception("Email and password are required.");
        }

        // Authenticate user
        $userData = $user->login($email);
        if ($userData && password_verify($password, $userData['password'])) {
            // Start session and store email
            session_start();
            $_SESSION['email'] = $email;

            // Generate OTP and store it in the session
            $otpHandler = new OTP(600); // 10-minute expiration time
            $generatedOTP = $otpHandler->generateOtp();

            // Save OTP and expiration time in the session
            $_SESSION['otp'] = $generatedOTP;
            $_SESSION['otp_expires_at'] = time() + 600; // 10 minutes from now

            // Log the OTP for testing purposes (REMOVE in production!)
            error_log("Generated OTP for {$email}: {$generatedOTP}");

            // Success response
            $response = [
                "status" => "success",
                "message" => "Login successful. OTP generated and stored.",
                "redirect" => "verify_2fa.php",
            ];
        } else {
            throw new Exception("Invalid email or password.");
        }
    } catch (Exception $e) {
        $response["message"] = $e->getMessage();
    }

    echo json_encode($response);
    exit;
}
?>
