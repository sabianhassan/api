<?php
require_once '../classes/Database.php'; // Ensure correct path

// Extract form values safely
$user_id = $_POST['user_id'] ?? null;
$room_id = $_POST['room_id'] ?? null;
$package = $_POST['package'] ?? null;
$meal = $_POST['meal'] ?? null;
$additional = $_POST['additional'] ?? null; // Can be empty
$check_in = $_POST['check_in'] ?? null;
$check_out = $_POST['check_out'] ?? null;
$duration = $_POST['duration'] ?? null;

// Validate required fields
if (empty($user_id) || empty($room_id) || empty($check_in) || empty($check_out)) {
    die("<div class='error-message'>Error: Missing required fields.</div>");
}

try {
    $conn = connectDatabase(); // Use function to get database connection

    // Insert booking into the database
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_id, package, meal, additional, check_in, check_out, duration, status) 
                            VALUES (:user_id, :room_id, :package, :meal, :additional, :check_in, :check_out, :duration, 'Pending')");
    
    $stmt->execute([
        ':user_id' => $user_id,
        ':room_id' => $room_id,
        ':package' => $package,
        ':meal' => $meal,
        ':additional' => $additional,
        ':check_in' => $check_in,
        ':check_out' => $check_out,
        ':duration' => $duration
    ]);

    // Display a well-designed success message
    echo "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                background-color: #f4f4f4;
                padding: 50px;
            }
            .success-box {
                background: #4CAF50;
                color: white;
                padding: 20px;
                border-radius: 10px;
                display: inline-block;
                box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
            }
            .success-box h2 {
                margin: 0;
            }
            .success-box p {
                font-size: 18px;
            }
            .button {
                margin-top: 20px;
                display: inline-block;
                background: white;
                color: #4CAF50;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                transition: 0.3s;
            }
            .button:hover {
                background: #45a049;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class='success-box'>
            <h2>Booking Successful! 🎉</h2>
            <p>Your reservation has been recorded.</p>
            <a href='dashboard.php' class='button'>Go Back to Dashboard</a>
        </div>
    </body>
    </html>";
    
} catch (PDOException $e) {
    echo "<div class='error-message'>Error: " . $e->getMessage() . "</div>";
}
?>
