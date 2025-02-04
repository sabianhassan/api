<?php
class OTP {
    private $expirationTime;

    public function __construct($expirationTime = 600) {
        $this->expirationTime = $expirationTime;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function generateOtp() {
        $otp = random_int(100000, 999999);
        $_SESSION['otp_expires_at'] = time() + $this->expirationTime;
        return $otp;
    }

    public function isOtpValid($inputOtp) {
        if (isset($_SESSION['otp']) && isset($_SESSION['otp_expires_at'])) {
            if ($_SESSION['otp_expires_at'] > time() && $_SESSION['otp'] == $inputOtp) {
                return true;
            }
        }
        return false;
    }
}
?>