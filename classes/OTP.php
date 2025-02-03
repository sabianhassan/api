<?php
class OTP {
    private $expirationTime;

    // Constructor to set default expiration time
    public function __construct($expirationTime = 600) {
        $this->expirationTime = $expirationTime;
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Start the session if it's not already started
        }
    }

    // Generate OTP and store it in the session
    public function generateOtp() {
        $otp = random_int(100000, 999999); // Generate random 6-digit OTP
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expires_at'] = time() + $this->expirationTime; // Set expiry time

        return $otp; // Return the generated OTP
    }

    // Check if the OTP is valid
    public function isOtpValid($inputOtp) {
        if (isset($_SESSION['otp']) && isset($_SESSION['otp_expires_at'])) {
            if ($_SESSION['otp_expires_at'] > time() && $_SESSION['otp'] == $inputOtp) {
                $this->invalidateOtp(); // Invalidate OTP after successful validation
                return true; // OTP is valid
            }
        }
        return false; // OTP is invalid or expired
    }

    // Invalidate the OTP (remove it from the session)
   /// public function invalidateOtp() {
       // unset($_SESSION['otp']);
       // unset($_SESSION['otp_expires_at']);
    //}
}
?>
