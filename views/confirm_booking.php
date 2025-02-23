<?php
session_start();
include_once '../templates/header.php';

// Handle form submission (for check-in/out values)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $checkin_date = $_POST['checkin_date'] ?? '';
    $checkin_time = $_POST['checkin_time'] ?? '';
    $checkout_date = $_POST['checkout_date'] ?? '';
    $checkout_time = $_POST['checkout_time'] ?? '';
    
    $check_in = trim($checkin_date . ' ' . $checkin_time);
    if (empty($check_in)) {
        $check_in = "2025-01-01 12:00:00"; // Default
    } elseif (strlen($check_in) < 17) {
        $check_in .= ':00';
    }
    
    $check_out = trim($checkout_date . ' ' . $checkout_time);
    if (empty($check_out)) {
        $check_out = "2025-01-02 12:00:00"; // Default
    } elseif (strlen($check_out) < 17) {
        $check_out .= ':00';
    }
    
    $_SESSION['check_in'] = $check_in;
    $_SESSION['check_out'] = $check_out;
}
?>

<div class="container mt-5">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <h2 class="text-center">Confirm Your Booking</h2>

    <div class="confirmation-box">
        <p><strong>Room Type:</strong> <span id="selected-room">Not selected</span></p>
        <p><strong>Package:</strong> <span id="selected-package">Not selected</span></p>
        <p><strong>Meal Plan:</strong> <span id="selected-meal">Not selected</span></p>
        <p><strong>Additional Services:</strong> <span id="selected-additional">Not selected</span></p>
        <p><strong>Check-In:</strong> <span id="selected-checkin"><?php echo $_SESSION['check_in'] ?? 'Not selected'; ?></span></p>
        <p><strong>Check-Out:</strong> <span id="selected-checkout"><?php echo $_SESSION['check_out'] ?? 'Not selected'; ?></span></p>
        <p><strong>Duration:</strong> <span id="duration">Not selected</span></p>
    </div>

    <form id="booking-form" action="book.php" method="POST">
        <input type="hidden" name="user_id" id="user-id" value="<?php echo $_SESSION['user_id'] ?? 1; ?>">
        <input type="hidden" name="room_id" id="room-id-input">
        <input type="hidden" name="package" id="package-input">
        <input type="hidden" name="meal" id="meal-input">
        <input type="hidden" name="additional" id="additional-input">
        <input type="hidden" name="check_in" id="checkin-input">
        <input type="hidden" name="check_out" id="checkout-input">
        <input type="hidden" name="duration" id="duration-input">

        <div class="navigation">
            <a href="additional.php" class="back-btn">⬅ Back</a>
            <button type="submit" class="confirm-btn">Confirm Booking</button>
            <a href="dashboard.php" class="dashboard-btn">🏠 Go to Dashboard</a>
        </div>
    </form>
</div>

<script>
    function loadSelections() {
        let selectedRoom = JSON.parse(localStorage.getItem("selected_room")) || null;
        let selectedPackages = JSON.parse(localStorage.getItem("selected_packages")) || [];
        let selectedMeals = JSON.parse(localStorage.getItem("selected_meals")) || [];
        let selectedAdditional = JSON.parse(localStorage.getItem("selected_additional")) || [];
        
        let checkinDate = "<?php echo $_SESSION['check_in'] ?? ''; ?>";
        let checkoutDate = "<?php echo $_SESSION['check_out'] ?? ''; ?>";

        console.log("Selected Room:", selectedRoom);
        console.log("Check-in:", checkinDate);
        console.log("Check-out:", checkoutDate);

        if (selectedRoom) {
            document.getElementById("selected-room").innerText = `${selectedRoom.roomType} - Room ${selectedRoom.roomNumber}`;
            document.getElementById("room-id-input").value = selectedRoom.roomNumber;
        } else {
            document.getElementById("selected-room").innerText = "Not selected";
        }

        document.getElementById("selected-package").innerText = selectedPackages.join(", ") || "Not selected";
        document.getElementById("package-input").value = selectedPackages.join(", ");
        
        document.getElementById("selected-meal").innerText = selectedMeals.join(", ") || "Not selected";
        document.getElementById("meal-input").value = selectedMeals.join(", ");

        document.getElementById("selected-additional").innerText = selectedAdditional.join(", ") || "Not selected";
        document.getElementById("additional-input").value = selectedAdditional.join(", ");

        document.getElementById("selected-checkin").innerText = checkinDate || "Not selected";
        document.getElementById("selected-checkout").innerText = checkoutDate || "Not selected";
        document.getElementById("checkin-input").value = checkinDate;
        document.getElementById("checkout-input").value = checkoutDate;

        // Calculate duration in days
        if (checkinDate && checkoutDate) {
            let checkin = new Date(checkinDate);
            let checkout = new Date(checkoutDate);
            let duration = Math.ceil((checkout - checkin) / (1000 * 3600 * 24)); // Convert milliseconds to days
            document.getElementById("duration").innerText = duration + " days";
            document.getElementById("duration-input").value = duration;
        }

        console.log("Form Values:", {
            room_id: document.getElementById("room-id-input").value,
            package: document.getElementById("package-input").value,
            meal: document.getElementById("meal-input").value,
            additional: document.getElementById("additional-input").value,
            check_in: document.getElementById("checkin-input").value,
            check_out: document.getElementById("checkout-input").value,
            duration: document.getElementById("duration-input").value
        });
    }

    document.addEventListener("DOMContentLoaded", loadSelections);
</script>

<?php include_once '../templates/footer.php'; ?>
