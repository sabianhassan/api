<?php
require_once 'config/config.php';
require_once 'classes/User.php';
require_once 'classes/OTP.php';
require_once 'vendor/autoload.php'; // Ensure Resend library is autoloaded

use Resend\Resend as ResendClient; // Alias Resend class to avoid conflict

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = connectDatabase();
    $user = new User($db);
    $otp = new OTP($db);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $userData = $user->login($email);

    if ($userData && password_verify($password, $userData['password'])) {
        $generatedOTP = random_int(100000, 999999);
        $otp->email = $email;
        $otp->otp = $generatedOTP;
        $otp->created_at = date('Y-m-d H:i:s');
        $otp->saveOTP();

        // Correctly initialize Resend client with an alias
        $resend = ResendClient::client('re_SBf6bmS3_CSh7UnVQVvP5vB9iyVnzDH53');
        
        // Send OTP email using Resend
        $resend->emails->send([
            'from' => 'no-reply@yourdomain.com',
            'to' => [$email],
            'subject' => 'Your OTP Code',
            'text' => "Your OTP code is: $generatedOTP"
        ]);

        session_start();
        $_SESSION['email'] = $email;
        header("Location: views/verify_2fa.php");
    } else {
        echo "Invalid credentials!";
    }
}
?>
