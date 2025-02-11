<?php include_once '../templates/header.php'; ?>

<div class="hero">
    <h1>Welcome to Jambo Hotel</h1>
    <p>Manage your bookings with ease</p>
</div>

<div class="nav-links">
    <a href="room.php">Rooms</a> <!-- Adjusted path -->
    <a href="packages.php">Packages</a>
    <a href="meals.php">Meal Plans</a>
    <a href="additional.php">Extras</a>
</div>

<div class="container mt-5">
    <h2 class="text-center">Jambo Hotel Management Dashboard</h2>

    <div class="summary-section">
        <a href="../confirm_booking.php" class="confirm-btn">Proceed to Booking</a> <!-- Adjusted path -->
    </div>
</div>

<script>
    // Load selections from local storage
    document.getElementById("room_summary").innerText = "Room: " + (localStorage.getItem("selected_room") || "Not selected");
    document.getElementById("package_summary").innerText = "Package: " + (localStorage.getItem("selected_package") || "Not selected");
    document.getElementById("meal_summary").innerText = "Meal Plan: " + (localStorage.getItem("selected_meal") || "Not selected");
    document.getElementById("additional_summary").innerText = "Extras: " + (localStorage.getItem("selected_additional") || "None");
</script>

<?php include_once '../templates/footer.php'; ?>
