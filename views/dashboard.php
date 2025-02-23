<?php include_once '../templates/header.php'; ?>

<style>
    .hero {
        text-align: center;
        background: linear-gradient(to right, #4A90E2, #50BFA5);
        color: white;
        padding: 50px 20px;
        border-radius: 10px;
        margin: 20px auto;
    }
    .nav-links {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin: 20px 0;
    }
    .nav-links a {
        text-decoration: none;
        background: #4A90E2;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        transition: 0.3s;
    }
    .nav-links a:hover {
        background: #357ABD;
    }
    .container {
        max-width: 900px;
        margin: auto;
        padding: 20px;
        background: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .summary-section {
        text-align: center;
        margin-top: 20px;
    }
    .confirm-btn {
        display: inline-block;
        background: #50BFA5;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 18px;
        transition: 0.3s;
    }
    .confirm-btn:hover {
        background: #3A9D82;
    }
</style>

<div class="hero">
    <h1>Welcome to Jambo Hotel</h1>
    <p>Manage your bookings with ease</p>
</div>

<div class="nav-links">
    <a href="room.php">Rooms</a>
    <a href="packages.php">Packages</a>
    <a href="meals.php">Meal Plans</a>
    <a href="additional.php">Extras</a>
</div>

<div class="container mt-5">
    <h2 class="text-center">Jambo Hotel Management Dashboard</h2>
    <div class="summary-section">
        <a href="../confirm_booking.php" class="confirm-btn">Proceed to Booking</a>
    </div>
</div>

<script>
    document.getElementById("room_summary").innerText = "Room: " + (localStorage.getItem("selected_room") || "Not selected");
    document.getElementById("package_summary").innerText = "Package: " + (localStorage.getItem("selected_package") || "Not selected");
    document.getElementById("meal_summary").innerText = "Meal Plan: " + (localStorage.getItem("selected_meal") || "Not selected");
    document.getElementById("additional_summary").innerText = "Extras: " + (localStorage.getItem("selected_additional") || "None");
</script>

<?php include_once '../templates/footer.php'; ?>
