<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Select Duration of Stay</h2>

    <!-- Duration Form -->
    <form action="confirm_booking.php" method="POST" onsubmit="saveDuration()">
        <div class="mb-3">
            <label for="checkin" class="form-label">Check-In Date and Time</label>
            <div class="d-flex">
                <input type="date" class="form-control" id="checkin-date" name="checkin_date" required>
                <input type="time" class="form-control" id="checkin-time" name="checkin_time" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="checkout" class="form-label">Check-Out Date and Time</label>
            <div class="d-flex">
                <input type="date" class="form-control" id="checkout-date" name="checkout_date" required>
                <input type="time" class="form-control" id="checkout-time" name="checkout_time" required>
            </div>
        </div>

        <!-- Display selected additional services -->
        <h4>Selected Additional Services</h4>
        <ul id="additional-services-list">
            <!-- This will be dynamically filled with selected services -->
        </ul>

        <!-- Continue Button -->
        <div class="navigation">
            <a href="additional.php" class="back-btn">⬅ Back</a>
            <button type="submit" class="btn btn-primary">Continue ➡</button>
        </div>
    </form>
</div>

<script>
    // Fetch the selected additional services from localStorage
    let selectedAdditional = JSON.parse(localStorage.getItem("selected_additional")) || [];

    // Display the selected services in the list
    const servicesList = document.getElementById('additional-services-list');
    selectedAdditional.forEach(service => {
        let listItem = document.createElement('li');
        listItem.textContent = service;
        servicesList.appendChild(listItem);
    });

    // Save the check-in and check-out dates to localStorage before submitting the form
    function saveDuration() {
        const checkinDate = document.getElementById('checkin-date').value;
        const checkinTime = document.getElementById('checkin-time').value;
        const checkoutDate = document.getElementById('checkout-date').value;
        const checkoutTime = document.getElementById('checkout-time').value;

        // Combine date and time for check-in and check-out
        const checkinDatetime = `${checkinDate} ${checkinTime}`;
        const checkoutDatetime = `${checkoutDate} ${checkoutTime}`;

        // Store the check-in and check-out dates in localStorage
        localStorage.setItem("checkin_date", checkinDatetime);
        localStorage.setItem("checkout_date", checkoutDatetime);
    }
</script>

<?php include_once '../templates/footer.php'; ?>
