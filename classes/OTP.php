<?php
class OTP {
    private $expirationTime;
    private $db;  // Database connection

    // Constructor to set default expiration time and DB connection
    public function __construct($db, $expirationTime = 600) {
        $this->db = $db;
        $this->expirationTime = $expirationTime;
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Start the session if it's not already started
        }
    }

    // Generate OTP and store it in the database
    public function generateOtp($email) {
        $otp = random_int(100000, 999999); // Generate random 6-digit OTP
        $expiryTime = date('Y-m-d H:i:s', time() + $this->expirationTime); // Set expiry time

        // Store the OTP in the database
        $stmt = $this->db->prepare("INSERT INTO otp_verifications (user_email, otp_code, expiry_time) VALUES (?, ?, ?)");
        $stmt->execute([$email, $otp, $expiryTime]);

        // Return the generated OTP
        return $otp;
    }

    // Check if the OTP is valid (check both session and database)
    public function isOtpValid($inputOtp, $email) {
        // First, check the session for the OTP
        if (isset($_SESSION['otp']) && $_SESSION['otp_expires_at'] > time() && $_SESSION['otp'] === $inputOtp) {
            return true; // Valid OTP in session
        }

        // Then, check the database for the OTP
        $stmt = $this->db->prepare("SELECT otp_code, expiry_time FROM otp_verifications WHERE user_email = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Check if OTP is still valid
            $otpExpiryTime = strtotime($row['expiry_time']);
            if ($otpExpiryTime > time() && $row['otp_code'] === $inputOtp) {
                // OTP is valid, now invalidate it in the database
                $this->invalidateOtp($email);
                return true; // Valid OTP from the database
            }
        }

        return false; // Invalid OTP
    }

    // Invalidate the OTP (remove it from the session and database)
    public function invalidateOtp($email) {
        // Remove OTP from the session
        unset($_SESSION['otp']);
        unset($_SESSION['otp_expires_at']);

        // Remove OTP from the database
        $stmt = $this->db->prepare("DELETE FROM otp_verifications WHERE user_email = ? AND expiry_time < NOW()");
        $stmt->execute([$email]);
    }
}
?>
