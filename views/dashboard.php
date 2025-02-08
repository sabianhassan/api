<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Jambo Hotel Management Dashboard</h2>

    <div class="dashboard-container">
        <form action="book.php" method="POST">
            <label>Select Room:</label>
            <select name="room_id" required>
                <option value="1">Single Room - $50</option>
                <option value="2">Double Room - $80</option>
                <option value="3">Suite - $150</option>
            </select>

            <label>Check-in Date:</label>
            <input type="date" name="check_in" required>

            <label>Check-out Date:</label>
            <input type="date" name="check_out" required>

            <button type="submit">Book Now</button>
        </form>
    </div>

</div>

<?php include_once '../templates/footer.php'; ?>
