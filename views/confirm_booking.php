<?php
session_start();
include_once '../templates/header.php';

// --- Combine check-in and check-out values if the form was submitted ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the separate date and time values from the duration form
    $checkin_date = $_POST['checkin_date'] ?? '';
    $checkin_time = $_POST['checkin_time'] ?? '';
    $checkout_date = $_POST['checkout_date'] ?? '';
    $checkout_time = $_POST['checkout_time'] ?? '';
    
    // Combine them into a proper datetime string ("YYYY-MM-DD HH:MM:SS")
    // If any part is missing, we use default test values for now.
    $check_in = trim($checkin_date . ' ' . $checkin_time);
    if (empty($check_in) || $check_in === 'Not selected') {
        // Default test value
        $check_in = "2025-01-01 12:00:00";
    } else {
        // Ensure seconds are appended
        if (strpos($check_in, ':') === false || strlen($check_in) < 17) {
            $check_in .= ':00';
        }
    }
    
    $check_out = trim($checkout_date . ' ' . $checkout_time);
    if (empty($check_out) || $check_out === 'Not selected') {
        // Default test value
        $check_out = "2025-01-02 12:00:00";
    } else {
        if (strpos($check_out, ':') === false || strlen($check_out) < 17) {
            $check_out .= ':00';
        }
    }
    
    // Store in session so we can use them later
    $_SESSION['check_in'] = $check_in;
    $_SESSION['check_out'] = $check_out;
}
?>

<div class="container mt-5">
    <h2 class="text-center">Confirm Your Booking</h2>

    <div class="confirmation-box">
        <p><strong>Room Type:</strong> <span id="selected-room">Not selected</span></p>
        <p><strong>Package:</strong> <span id="selected-package">Not selected</span></p>
        <p><strong>Meal Plan:</strong> <span id="selected-meal">Not selected</span></p>
        <p><strong>Additional Services:</strong> <span id="selected-additional">Not selected</span></p>
        <p><strong>Check-In Date and Time:</strong> 
           <span id="selected-checkin">
               <?php echo isset($_SESSION['check_in']) ? $_SESSION['check_in'] : 'Not selected'; ?>
           </span>
        </p>
        <p><strong>Check-Out Date and Time:</strong> 
           <span id="selected-checkout">
               <?php echo isset($_SESSION['check_out']) ? $_SESSION['check_out'] : 'Not selected'; ?>
           </span>
        </p>
        <p><strong>Duration:</strong> <span id="duration">Not selected</span></p>
    </div>

    <form id="booking-form" action="book.php" method="POST">
        <!-- Hidden inputs for final submission -->
        <input type="hidden" name="user_id" id="user-id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; ?>">

        <!-- Changed field name from 'room' to 'room_id' -->
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
        // Retrieve selections from localStorage
        let selectedRoom       = JSON.parse(localStorage.getItem("selected_room")) || null;
        let selectedPackages   = JSON.parse(localStorage.getItem("selected_packages")) || [];
        let selectedMeals      = JSON.parse(localStorage.getItem("selected_meals")) || [];
        let selectedAdditional = JSON.parse(localStorage.getItem("selected_additional")) || [];

        // For check-in and check-out, we rely on PHP session values.
        let checkinDate  = "<?php echo isset($_SESSION['check_in']) ? $_SESSION['check_in'] : 'Not selected'; ?>";
        let checkoutDate = "<?php echo isset($_SESSION['check_out']) ? $_SESSION['check_out'] : 'Not selected'; ?>";

        // Debug output in the console
        console.log("Selected room from localStorage:", selectedRoom);

        // Display selected room details & set the hidden 'room_id'
        if (selectedRoom) {
            // Display a descriptive room (for the user)
            document.getElementById("selected-room").innerText =
                `${selectedRoom.roomType} - Room ${selectedRoom.roomNumber}`;
            // Set the hidden room_id to a numeric value.
            document.getElementById("room-id-input").value = selectedRoom.roomNumber;
        } else {
            document.getElementById("selected-room").innerText = "Not selected";
            // Fallback default for testing
            document.getElementById("room-id-input").value = "101";
            console.warn("No room selected in localStorage. Using default room_id = 101 for testing.");
        }

        // Display and set package, meal, and additional services
        document.getElementById("selected-package").innerText =
            selectedPackages.length ? selectedPackages.join(", ") : "Not selected";
        document.getElementById("package-input").value = selectedPackages.join(", ");

        document.getElementById("selected-meal").innerText =
            selectedMeals.length ? selectedMeals.join(", ") : "Not selected";
        document.getElementById("meal-input").value = selectedMeals.join(", ");

        document.getElementById("selected-additional").innerText =
            selectedAdditional.length ? selectedAdditional.join(", ") : "Not selected";
        document.getElementById("additional-input").value = selectedAdditional.join(", ");

        // Set hidden inputs for check_in and check_out from PHP session values
        document.getElementById("checkin-input").value = checkinDate;
        document.getElementById("checkout-input").value = checkoutDate;

        // Calculate duration (difference between check-in and check-out dates)
        if (checkinDate !== "Not selected" && checkoutDate !== "Not selected") {
            let checkin  = new Date(checkinDate);
            let checkout = new Date(checkoutDate);
            let duration = (checkout - checkin) / (1000 * 3600 * 24); // in days
            document.getElementById("duration").innerText = `${duration} days`;
            document.getElementById("duration-input").value = duration;
        }
    }

    document.addEventListener("DOMContentLoaded", loadSelections);
</script>

<?php include_once '../templates/footer.php'; ?>
