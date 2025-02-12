<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Confirm Your Booking</h2>

    <div class="confirmation-box">
        <p><strong>Room Type:</strong> <span id="selected-room">Not selected</span></p>
        <p><strong>Package:</strong> <span id="selected-package">Not selected</span></p>
        <p><strong>Meal Plan:</strong> <span id="selected-meal">Not selected</span></p>
        <p><strong>Additional Services:</strong> <span id="selected-additional">Not selected</span></p>
    </div>

    <div class="navigation">
        <a href="additional.php" class="back-btn">⬅ Back</a>
        <button class="confirm-btn" onclick="submitBooking()">Confirm Booking</button>
    </div>
</div>

<script>
    // Function to get selected data from localStorage
    function loadSelections() {
        let selectedRoom = localStorage.getItem("selected_room") 
