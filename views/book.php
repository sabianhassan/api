<?php
session_start();

// Always load the database and create the $pdo connection first
require_once '../classes/Database.php';
$pdo = connectDatabase();

// If user_id is not set, try to retrieve it using the email stored in the session.
if (!isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
    // Query the database for the userid using the email
    $stmt = $pdo->prepare("SELECT userid FROM users WHERE email = ?");
    $stmt->execute([$_SESSION['email']]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($userData) {
        $_SESSION['user_id'] = $userData['userid'];
    } else {
        header("Location: ../views/login.php");
        exit();
    }
}

// Final check: if user_id is still not set, redirect to login.
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id    = $_SESSION['user_id'];
    $room_id    = $_POST['room_id'] ?? null;
    $package    = $_POST['package'] ?? null;
    $meal       = $_POST['meal'] ?? null;
    $duration   = $_POST['duration'] ?? 1;
    $additional = $_POST['additional'] ?? null;
    $status     = 'Pending';
    
    if (!$room_id || !$package || !$meal) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../views/confirm_booking.php");
        exit();
    }
    
    try {
        // Insert booking record with status 'Pending'
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, room_id, package, meal, duration, additional, status) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $room_id, $package, $meal, $duration, $additional, $status]);

        $_SESSION['success'] = "Booking submitted successfully! Await admin approval.";

        // Fetch the last inserted booking for confirmation
        $booking_id = $pdo->lastInsertId();

        // Retrieve the booking details (using booking_id as primary key)
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE booking_id = ?");
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: ../views/confirm_booking.php");
        exit();
    }
} else {
    header("Location: ../views/confirm_booking.php");
    exit();
}

include_once '../templates/header.php';
?>

<div class="container mt-5">
    <div class="booking-confirmation">
        <h2 class="text-center">Booking Confirmation</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($booking) && $booking): ?>
            <div class="booking-details">
                <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['booking_id']); ?></p>
                <p><strong>Room Number:</strong> <?php echo htmlspecialchars($booking['room_id']); ?></p>
                <p><strong>Package:</strong> <?php echo htmlspecialchars($booking['package']); ?></p>
                <p><strong>Meal Plan:</strong> <?php echo htmlspecialchars($booking['meal']); ?></p>
                <p><strong>Additional Services:</strong> <?php echo htmlspecialchars($booking['additional']) ?: 'None'; ?></p>
                <p><strong>Duration:</strong> <?php echo htmlspecialchars($booking['duration']); ?> days</p>
                <p><strong>Status:</strong>
                    <!-- Notice we add IDs so we can update this element via JavaScript -->
                    <span id="bookingStatusBadge" class="badge bg-warning">
                        <span id="bookingStatus"><?php echo htmlspecialchars($booking['status']); ?></span>
                    </span>
                </p>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <a href="../views/dashboard.php" class="btn btn-primary">Return to Dashboard</a>
            <a href="../views/my_bookings.php" class="btn btn-secondary">View My Bookings</a>
        </div>
    </div>
</div>

<style>
    .booking-confirmation {
        max-width: 600px;
        margin: auto;
        background: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .booking-details p {
        font-size: 16px;
        margin: 5px 0;
    }
    .badge {
        padding: 5px 10px;
        border-radius: 5px;
    }
    .bg-warning {
        background-color: orange;
        color: white;
    }
</style>

<!-- AJAX polling script to update booking status every 5 seconds -->
<script>
function pollStatus() {
    // Use the booking_id from PHP in the URL
    fetch('get_booking_status.php?booking_id=<?= $booking["booking_id"]; ?>')
        .then(response => response.json())
        .then(data => {
            // Update the status text
            document.getElementById('bookingStatus').textContent = data.status;
            // Update badge color accordingly
            let badge = document.getElementById('bookingStatusBadge');
            if (data.status === 'Approved') {
                badge.className = 'badge bg-success';
            } else if (data.status === 'Rejected') {
                badge.className = 'badge bg-danger';
            } else {
                badge.className = 'badge bg-warning';
            }
        })
        .catch(error => console.error('Error polling status:', error));
}

// Poll every 5 seconds
setInterval(pollStatus, 5000);
</script>

<?php include_once '../templates/footer.php'; ?>
