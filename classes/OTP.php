<?php
class OTP {
    private $expirationTime;

    // Constructor to set default expiration time (10 minutes = 600 seconds)
    public function __construct($expirationTime = 600) {
        $this->expirationTime = $expirationTime;
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Start the session if it's not already started
        }
    }

    // Generate OTP and save it to the session
    public function generateOtp() {
        $otp = random_int(100000, 999999); // Generate random 6-digit OTP
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expires_at'] = time() + $this->expirationTime; // Save expiration time in the session
        return $otp;
    }

    // Check if the OTP is valid
    public function isOtpValid($inputOtp) {
        if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expires_at'])) {
            return false; // OTP not generated or missing data
        }

        // Check if the OTP has expired
        if (time() > $_SESSION['otp_expires_at']) {
            $this->invalidateOtp(); // Invalidate expired OTP
            return false;
        }

        // Check if the input matches the stored OTP
        return $_SESSION['otp'] === $inputOtp;
    }

    // Invalidate the OTP
    public function invalidateOtp() {
        unset($_SESSION['otp']);
        unset($_SESSION['otp_expires_at']);
    }
}
?>
