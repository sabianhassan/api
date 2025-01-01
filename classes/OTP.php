<?php 
require_once __DIR__ . '/../vendor/autoload.php'; // Correct path to autoload.php

class OTP {
    private $conn;
    private $table = "otp";

    public $id;
    public $user_id;
    public $otp;
    public $created_at;
    public $expires_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    private function generateOTP() {
        return random_int(100000, 999999); // 6-digit OTP
    }

    public function saveOTP() {
        $query = "INSERT INTO {$this->table} (user_id, otp, created_at, expires_at) 
                  VALUES (:user_id, :otp, :created_at, :expires_at)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":otp", $this->otp);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":expires_at", $this->expires_at);
        return $stmt->execute();
    }

    public function sendOTP($email, $user_id) {
        $this->otp = $this->generateOTP();
        $this->created_at = date("Y-m-d H:i:s");
        $this->expires_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));
        $this->user_id = $user_id;

        // Save OTP to the database
        if (!$this->saveOTP()) {
            throw new Exception("Failed to save OTP.");
        }

        try {
            // Send OTP via email using Resend service
            $resend = \Resend::client('re_SBf6bmS3_CSh7UnVQVvP5vB9iyVnzDH53'); // Replace with actual Resend API key
            $result = $resend->emails->send([
                "from" => "no-reply@yourdomain.com",
                "to" => [$email],
                "subject" => "Your OTP Code",
                "html" => "<p>Your OTP code is <strong>{$this->otp}</strong>. It is valid for 10 minutes.</p>"
            ]);
        } catch (Exception $e) {
            // Catch any email sending errors
            throw new Exception("Failed to send OTP email: " . $e->getMessage());
        }

        return $this->otp;  // Return OTP for confirmation or logging purposes
    }

    public function verifyOTP($user_id, $otp) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE user_id = :user_id AND otp = :otp AND expires_at > NOW()";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":otp", $otp);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>
