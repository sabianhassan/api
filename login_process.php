// Include the necessary class and function files
require_once 'classes/User.php';
require_once 'classes/OTP.php';
require_once 'classes/Database.php'; // Include the Database connection file

// Include the PHPMailer email function
include('PHPMailer/mailer_demo.php'); // Ensure this includes the sendOtpEmail function

date_default_timezone_set('Africa/Nairobi'); // Set time zone

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize response and output the JSON response at the end
    header('Content-Type: application/json');
    $response = ["status" => "error", "message" => "An error occurred."];

    try {
        // Database connection
        $db = connectDatabase(); // Now it's defined because Database.php is included
        $user = new User($db);

        // Retrieve and sanitize input
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            throw new Exception("Email and password are required.");
        }

        // Authenticate user
        $userData = $user->login($email);
        if ($userData && password_verify($password, $userData['password'])) {
            // Start session and store email and name
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $userData['name']; // Store the user's name

            // Generate OTP and store it in the session
            $otpHandler = new OTP(600); // 10-minute expiration time
            $generatedOTP = $otpHandler->generateOtp();

            // Save OTP and expiration time in the session
            $_SESSION['otp'] = $generatedOTP;
            $_SESSION['otp_expires_at'] = time() + 600; // 10 minutes from now

            // Log the OTP for testing purposes (REMOVE in production!)
            error_log("Generated OTP for {$email}: {$generatedOTP}");

            // Call the sendOtpEmail function to send the OTP email
            $emailSent = sendOtpEmail($_SESSION['email'], $generatedOTP, $_SESSION['name']);
            if ($emailSent) {
                // Success response - send redirect info and message
                $response = [
                    "status" => "success",
                    "message" => "Successfully sent the email. Redirecting to OTP verification page.",
                    "redirect" => "verify_2fa.php",
                ];
            } else {
                // Handle email sending failure
                throw new Exception("Failed to send OTP email.");
            }
        } else {
            throw new Exception("Invalid email or password.");
        }
    } catch (Exception $e) {
        $response["message"] = $e->getMessage();
    }

    // Send the JSON response to the front-end
    echo json_encode($response);
    exit;
}
