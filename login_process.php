<?php
require_once 'config/config.php';
require_once 'classes/User.php';
require_once 'classes/OTP.php';
require __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('Africa/Nairobi'); // Set time zone

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "An error occurred."];

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
            $otp->created_at = date('Y-m-d H:i:s'); // Current timestamp
            $otp->expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            // Save OTP to the database
            if (!$otp->saveOTP()) {
                throw new Exception("Failed to save OTP.");
            }

            // Initialize Resend client
            // $resend = new \Resend\Resend('re_SBf6bmS3_CSh7UnVQVvP5vB9iyVnzDH53');
            // $resend->emails->send([
            //     'from' => 'no-reply@fuelmybuild.com',
            //     'to' => $email,
            //     'subject' => 'Your OTP Code',
            //     'html' => "<p>Your OTP code is: <strong>{$generatedOTP}</strong>. It is valid for 10 minutes.</p>",
            // ]);

            // Start session and set email
            session_start();
            $_SESSION['email'] = $email;

            // Success response
            $response = [
                "status" => "success",
                "message" => "Login successful. OTP sent to your email.",
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
