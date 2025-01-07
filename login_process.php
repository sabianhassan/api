<?php
require_once 'config/config.php';
require_once 'classes/User.php';
require_once 'classes/OTP.php';
require __DIR__ . '/vendor/autoload.php';

// Set the correct time zone
date_default_timezone_set('Africa/Nairobi'); // Adjust to your local time zone

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Database connection
        $db = connectDatabase();
        $user = new User($db);
        $otp = new OTP($db);

        // Retrieve and sanitize input
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            throw new Exception("Email and password are required.");
        }

        // Authenticate user
        $userData = $user->login($email);
        if ($userData && password_verify($password, $userData['password'])) {
            // Generate OTP
            $generatedOTP = random_int(100000, 999999);
            $otp->email = $email;
            $otp->otp = $generatedOTP;
            $otp->created_at = date('Y-m-d H:i:s');  // Current timestamp
    $otp->expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            // Save OTP to the database
            if (!$otp->saveOTP()) {
                throw new Exception("Failed to save OTP.");
            }

            // Initialize Resend client with your API key
            $resend = Resend::client('re_SBf6bmS3_CSh7UnVQVvP5vB9iyVnzDH53');
            // Send OTP email
            $response = $resend->emails->send([
                'from' => 'no-reply@fuelmybuild.com', // Use a verified sender email
                'to' => $email,
                'subject' => 'Your OTP Code',
                'text' => "Your OTP code is: $generatedOTP. It is valid for 10 minutes."
            ]);

           



            if (!$response) {
                throw new Exception("Failed to send the OTP email.");
            }

            // Start session and redirect to 2FA verification page
            session_start();
            $_SESSION['email'] = $email;
            header("Location: views/verify_2fa.php");
            exit;
        } else {
            throw new Exception("Invalid email or password.");
        }
    } catch (Exception $e) {
        // Handle exceptions and display user-friendly messages
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}
?>
