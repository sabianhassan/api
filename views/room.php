<?php include_once '../templates/header.php'; ?>

<!-- Link to the external CSS file -->
<link rel="stylesheet" href="../assets/style.css">

<div class="container mt-5">
    <h2 class="text-center">Select a Room</h2>

    <div class="room-selection">
        <div class="room-card" onclick="selectRoom(1, 'Single Room')">
            <img src="..\assets\images\single_room.jpg" alt="Single Room"> <p>Single Room - $50</p>
            <p>Television available,hot shower and all basic necessities provided</p>
            <img src="..\assets\images\single2.jpg" alt="Single Room">
            <p>Single Room - $50</p>

        </div>
        <div class="room-card" onclick="selectRoom(2, 'Double Room')">
            <img src="..\assets\images\double2.jpg" alt="Double Room">
            <p>Double Room - $80</p>
            <img src="..\assets\images\double_room.jpg" alt="Double Room">
            <p>Double Room - $80</p>
            <p>accommodates up to two guests. </p>
        </div>
        <div class="room-card" onclick="selectRoom(3, 'Suite')">
            <img src="..\assets\images\suite.jpg" alt="Suite">
            <p>Suite - $150</p>
        </div>
    </div>

    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
</div>

<script>
    function selectRoom(id, name) {
        localStorage.setItem("selected_room", name);
        window.location.href = "dashboard.php";
    }
</script>

<?php include_once '../templates/footer.php'; ?>
