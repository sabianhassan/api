<?php include_once '../templates/header.php'; ?>

<!-- Link to external CSS -->
<link rel="stylesheet" href="../assets/style.css">

<div class="container mt-5">
    <h2 class="text-center">Select a Room</h2>

    <div class="room-selection">
        <!-- Single Room -->
        <div class="room-card" onclick="toggleRoom(1, 'Single Room')" id="room-1">
            <img src="../assets/images/single_room.jpg" alt="Single Room">
            <p>Single Room - $50</p>
            <p class="description">Television, hot shower, and all basic necessities provided.</p>
            <img src="../assets/images/single2.jpg" alt="Single Room">
        </div>

        <!-- Double Room -->
        <div class="room-card" onclick="toggleRoom(2, 'Double Room')" id="room-2">
            <img src="../assets/images/double2.jpg" alt="Double Room">
            <p>Double Room - $80</p>
            <p class="description">Spacious room for two guests with premium comfort.</p>
            <img src="../assets/images/double_room.jpg" alt="Double Room">
        </div>

        <!-- Suite -->
        <div class="room-card" onclick="toggleRoom(3, 'Suite')" id="room-3">
            <img src="../assets/images/suite.jpg" alt="Suite">
            <p>Suite - $150</p>
            <p class="description">Luxurious suite with top-tier amenities and scenic views.</p>
        </div>
    </div>

    <div class="navigation">
        <a href="dashboard.php" class="back-btn">⬅ Back</a>
        <a href="packages.php" class="continue-btn disabled" id="continue-btn">Continue ➡</a>
    </div>
</div>

<script>
    // Load selected rooms from localStorage
    let selectedRooms = JSON.parse(localStorage.getItem("selected_rooms")) || [];
    let continueBtn = document.getElementById("continue-btn");

    function toggleRoom(id, name) {
        let index = selectedRooms.indexOf(name);
        if (index > -1) {
            selectedRooms.splice(index, 1); // Remove if already selected
            document.getElementById(`room-${id}`).classList.remove("selected");
        } else {
            selectedRooms.push(name); // Add if not selected
            document.getElementById(`room-${id}`).classList.add("selected");
        }
        localStorage.setItem("selected_rooms", JSON.stringify(selectedRooms));
        updateContinueButton();
    }

    // Update the continue button state
    function updateContinueButton() {
        if (selectedRooms.length > 0) {
            continueBtn.classList.remove("disabled");
            continueBtn.href = "packages.php";
        } else {
            continueBtn.classList.add("disabled");
            continueBtn.removeAttribute("href");
        }
    }

    // Apply selection styling on page load
    document.addEventListener("DOMContentLoaded", function () {
        selectedRooms.forEach(room => {
            let roomElement = document.querySelector(`[onclick*="${room}"]`);
            if (roomElement) roomElement.classList.add("selected");
        });
        updateContinueButton();
    });
</script>

<?php include_once '../templates/footer.php'; ?>
