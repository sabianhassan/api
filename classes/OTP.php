<?php
class OTP {
    private $otp;
    private $timestamp;
    private $expirationTime;

    public function __construct($expirationTime = 600) {
        // Set expiration time to 10 minutes by default (600 seconds)
        $this->expirationTime = $expirationTime;
        $this->otp = null;
        $this->timestamp = null;
    }

    // Generate a 6-digit OTP
    public function generateOtp() {
        $this->otp = random_int(100000, 999999); // Random 6-digit number
        $this->timestamp = time(); // Store the current timestamp when OTP is generated
        return $this->otp;
    }

    // Check if the OTP is still valid
    public function isOtpValid() {
        // If OTP has not been generated yet, it's invalid
        if ($this->otp === null || $this->timestamp === null) {
            return false;
        }

        // Check if the OTP has expired (older than 10 minutes)
        if ((time() - $this->timestamp) > $this->expirationTime) {
            return false;
        }

        return true;
    }
}
?>