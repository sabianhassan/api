<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Confirm Your Booking</h2>

    <div class="confirmation-box">
        <p><strong>Room Type:</strong> <span id="selected-room">Not selected</span></p>
        <p><strong>Package:</strong> <span id="selected-package">Not selected</span></p>
        <p><strong>Meal Plan:</strong> <span id="selected-meal">Not selected</span></p>
        <p><strong>Additional Services:</strong> <span id="selected-additional">Not selected</span></p>
    </div>

    <form id="booking-form" action="book.php" method="POST">
        <input type="hidden" name="room" id="room-input">
        <input type="hidden" name="package" id="package-input">
        <input type="hidden" name="meal" id="meal-input">
        <input type="hidden" name="additional" id="additional-input">
        
        <div class="navigation">
            <a href="additional.php" class="back-btn">⬅ Back</a>
            <button type="submit" class="confirm-btn">Confirm Booking</button>
            <a href="dashboard.php" class="dashboard-btn">🏠 Go to Dashboard</a>
        </div>
    </form>
</div>

<script>
    function loadSelections() {
        let selectedRoom = localStorage.getItem("selected_room") || "Not selected";
        let selectedPackages = JSON.parse(localStorage.getItem("selected_packages")) || [];
        let selectedMeals = JSON.parse(localStorage.getItem("selected_meals")) || [];
        let selectedAdditional = JSON.parse(localStorage.getItem("selected_additional")) || [];

        // Display selected values
        document.getElementById("selected-room").innerText = selectedRoom;
        document.getElementById("selected-package").innerText = selectedPackages.length ? selectedPackages.join(", ") : "Not selected";
        document.getElementById("selected-meal").innerText = selectedMeals.length ? selectedMeals.join(", ") : "Not selected";
        document.getElementById("selected-additional").innerText = selectedAdditional.length ? selectedAdditional.join(", ") : "Not selected";

        // Populate hidden inputs for form submission
        document.getElementById("room-input").value = selectedRoom;
        document.getElementById("package-input").value = selectedPackages.join(", ");
        document.getElementById("meal-input").value = selectedMeals.join(", ");
        document.getElementById("additional-input").value = selectedAdditional.join(", ");
    }

    document.addEventListener("DOMContentLoaded", loadSelections);
</script>

<?php include_once '../templates/footer.php'; ?>
