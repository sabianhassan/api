<?php
include ('classes/Database.php');
require_once 'classes/User.php';
require_once 'classes/OTP.php';
include('PHPMailer/mailer_demo.php');

date_default_timezone_set('Africa/Nairobi');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "An error occurred."];

    try {
        $db = connectDatabase();
        $user = new User($db);

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            throw new Exception("Email and password are required.");
        }

        $userData = $user->login($email, $password);

        if ($userData) {
            session_start();
            $_SESSION['email'] = $userData['email'];
            $_SESSION['name'] = $userData['name'];

            $otpHandler = new OTP(600);
            $generatedOTP = $otpHandler->generateOtp();
            $_SESSION['otp'] = $generatedOTP;

            $emailSent = sendOtpEmail($userData['email'], $generatedOTP, $userData['name']);

            if ($emailSent) {
                $response = [
                    "status" => "success",
                    "message" => "Successfully sent the email. Redirecting to OTP verification page.",
                    "redirect" => "verify_2fa.php",
                ];
            } else {
                throw new Exception("Failed to send OTP email.");
            }
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