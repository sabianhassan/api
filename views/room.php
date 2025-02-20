<?php include_once '../templates/header.php'; ?>

<!-- Link to external CSS -->
<link rel="stylesheet" href="../assets/style.css">

<?php
require_once __DIR__ . '/../classes/Database.php';
$pdo = connectDatabase();

/* -------------------- Option B: Update Room Statuses on Page Load -------------------- */
// This function updates room statuses based on check-in and check-out times.
// Adjust the SQL queries to match your actual column names if needed.
function updateRoomStatuses($pdo) {
    $currentTime = date('Y-m-d H:i:s');

    // Update rooms to 'Available' if check_out time has passed.
    // Ensure that b.status = 'Approved' so only confirmed bookings affect status.
    $stmt = $pdo->prepare("
        UPDATE rooms r
        JOIN bookings b ON r.room_id = b.room_id
        SET r.status = 'Available'
        WHERE b.check_out <= ? 
          AND r.status IN ('Booked', 'Occupied')
          AND b.status = 'Approved'
    ");
    $stmt->execute([$currentTime]);

    // Update rooms to 'Occupied' if current time is between check_in and check_out.
    $stmt2 = $pdo->prepare("
        UPDATE rooms r
        JOIN bookings b ON r.room_id = b.room_id
        SET r.status = 'Occupied'
        WHERE b.check_in <= ? 
          AND ? < b.check_out
          AND r.status = 'Available'
          AND b.status = 'Approved'
    ");
    $stmt2->execute([$currentTime, $currentTime]);
}

// Call the function to update statuses whenever the page loads.
updateRoomStatuses($pdo);

/* -------------------- End Option B Integration -------------------- */

// Fetch available rooms for each type
$singleRooms = $pdo->query("SELECT * FROM rooms WHERE room_type = 'Single' AND status = 'Available'")->fetchAll(PDO::FETCH_ASSOC);
$doubleRooms = $pdo->query("SELECT * FROM rooms WHERE room_type = 'Double' AND status = 'Available'")->fetchAll(PDO::FETCH_ASSOC);
$suiteRooms  = $pdo->query("SELECT * FROM rooms WHERE room_type = 'Suite' AND status = 'Available'")->fetchAll(PDO::FETCH_ASSOC);

// Fetch total room counts for each type (regardless of status)
$totalSingle = $pdo->query("SELECT COUNT(*) as total FROM rooms WHERE room_type = 'Single'")->fetch(PDO::FETCH_ASSOC)['total'];
$totalDouble = $pdo->query("SELECT COUNT(*) as total FROM rooms WHERE room_type = 'Double'")->fetch(PDO::FETCH_ASSOC)['total'];
$totalSuite  = $pdo->query("SELECT COUNT(*) as total FROM rooms WHERE room_type = 'Suite'")->fetch(PDO::FETCH_ASSOC)['total'];
?>

<div class="container mt-5">
    <h2 class="text-center">Select a Room</h2>

    <div class="room-selection">
        <!-- Single Room Card -->
        <div class="room-card" id="room-single-card">
            <img src="../assets/images/single_room.jpg" alt="Single Room">
            <p>Single Room - $50</p>
            <p class="description">Television, hot shower, and all basic necessities provided.</p>
            <img src="../assets/images/single2.jpg" alt="Single Room">
            <!-- Display available vs. total rooms -->
            <div class="room-count">
                <?php echo "Available: " . count($singleRooms) . " out of " . $totalSingle; ?>
            </div>
            <!-- List available single room numbers -->
            <div class="available-rooms">
                <?php if(count($singleRooms) > 0): ?>
                    <?php foreach($singleRooms as $room): ?>
                        <span class="available-room" onclick="selectRoomNumber('Single', '<?php echo $room['room_id']; ?>', <?php echo $room['room_id']; ?>, this)">
                            <?php echo htmlspecialchars($room['room_id'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span>No available rooms</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Double Room Card -->
        <div class="room-card" id="room-double-card">
            <img src="../assets/images/double2.jpg" alt="Double Room">
            <p>Double Room - $80</p>
            <p class="description">Spacious room for two guests with premium comfort.</p>
            <img src="../assets/images/double_room.jpg" alt="Double Room">
            <!-- Display available vs. total rooms -->
            <div class="room-count">
                <?php echo "Available: " . count($doubleRooms) . " out of " . $totalDouble; ?>
            </div>
            <!-- List available double room numbers -->
            <div class="available-rooms">
                <?php if(count($doubleRooms) > 0): ?>
                    <?php foreach($doubleRooms as $room): ?>
                        <span class="available-room" onclick="selectRoomNumber('Double', '<?php echo $room['room_id']; ?>', <?php echo $room['room_id']; ?>, this)">
                            <?php echo htmlspecialchars($room['room_id'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span>No available rooms</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Suite Card -->
        <div class="room-card" id="room-suite-card">
            <img src="../assets/images/suite.jpg" alt="Suite">
            <p>Suite - $150</p>
            <p class="description">Luxurious suite with top-tier amenities and scenic views.</p>
            <!-- Display available vs. total rooms -->
            <div class="room-count">
                <?php echo "Available: " . count($suiteRooms) . " out of " . $totalSuite; ?>
            </div>
            <!-- List available suite room numbers -->
            <div class="available-rooms">
                <?php if(count($suiteRooms) > 0): ?>
                    <?php foreach($suiteRooms as $room): ?>
                        <span class="available-room" onclick="selectRoomNumber('Suite', '<?php echo $room['room_id']; ?>', <?php echo $room['room_id']; ?>, this)">
                            <?php echo htmlspecialchars($room['room_id'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span>No available rooms</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="navigation">
        <a href="dashboard.php" class="back-btn">⬅ Back</a>
        <button id="save-btn" class="btn btn-secondary">Save Selection</button>
        <a href="packages.php" class="continue-btn disabled" id="continue-btn">Continue ➡</a>
    </div>
</div>

<script>
    // This will store the final selected room as an object with roomType, roomNumber, and roomId.
    let selectedRoom = JSON.parse(localStorage.getItem("selected_room")) || null;
    let continueBtn = document.getElementById("continue-btn");
    let saveBtn = document.getElementById("save-btn");

    // Function to handle selection of a specific room number.
    function selectRoomNumber(roomType, roomNumber, roomId, elem) {
        // Save selection as an object
        selectedRoom = { roomType: roomType, roomNumber: roomNumber, roomId: roomId };
        localStorage.setItem("selected_room", JSON.stringify(selectedRoom));

        // Remove "selected" class from all available-room spans
        document.querySelectorAll(".available-room").forEach(el => el.classList.remove("selected"));

        // Add "selected" class to the clicked element
        elem.classList.add("selected");

        // Enable the Continue button since a room has been selected
        continueBtn.classList.remove("disabled");
        continueBtn.href = "packages.php";
    }

    // On page load, restore selection if exists
    document.addEventListener("DOMContentLoaded", function () {
        if(selectedRoom) {
            // Parse the stored selection
            selectedRoom = JSON.parse(localStorage.getItem("selected_room"));
            // Try to find the corresponding element and mark it as selected
            let formattedId = '';
            if(selectedRoom.roomType === "Single"){
                formattedId = "room-single-card";
            } else if(selectedRoom.roomType === "Double"){
                formattedId = "room-double-card";
            } else if(selectedRoom.roomType === "Suite"){
                formattedId = "room-suite-card";
            }
            // Look inside that card for a span that matches the roomNumber.
            document.querySelectorAll(`#${formattedId} .available-room`).forEach(el => {
                if(el.innerText.trim() === selectedRoom.roomNumber) {
                    el.classList.add("selected");
                }
            });
            // Enable the continue button if a selection exists
            continueBtn.classList.remove("disabled");
            continueBtn.href = "packages.php";
        }
    });

    // Save Selection Button functionality (optional)
    saveBtn.addEventListener("click", function() {
        if(selectedRoom) {
            alert("Your selection has been saved: " + JSON.stringify(selectedRoom));
            console.log("Saved selection:", selectedRoom);
        } else {
            alert("No room selected.");
        }
    });
</script>

<?php include_once '../templates/footer.php'; ?>
