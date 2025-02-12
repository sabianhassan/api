<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Select Additional Services</h2>

    <div class="room-selection">
        <div class="room-card" onclick="toggleAdditional('Pool Access')" id="additional-pool">
            <img src="../assets/images/pool bar1.jpeg" alt="Pool Access">
            <p>Pool Access - $50</p>
        </div>
        <div class="room-card" onclick="toggleAdditional('Bar Access')" id="additional-bar">
            <img src="../assets/images/poolbar2.jpeg" alt="Bar Access">
            <p>Bar Access - $70</p>
            <img src="../assets/images/poolbar3.jpeg" alt="Bar Access">
        </div>
    </div>

    <div class="navigation">
        <a href="meals.php" class="back-btn">⬅ Back</a>
        <a href="confirm_booking.php" class="continue-btn">Continue ➡</a>
    </div>
</div>

<script>
    let selectedAdditional = JSON.parse(localStorage.getItem("selected_additional")) || [];

    function toggleAdditional(name) {
        let formattedId = `additional-${name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z-]/g, '')}`;
        let additionalElement = document.getElementById(formattedId);

        if (!additionalElement) return; // Prevent errors if element is not found

        let index = selectedAdditional.indexOf(name);
        if (index > -1) {
            selectedAdditional.splice(index, 1);
            additionalElement.classList.remove("selected");
        } else {
            selectedAdditional.push(name);
            additionalElement.classList.add("selected");
        }
        localStorage.setItem("selected_additional", JSON.stringify(selectedAdditional));
    }

    document.addEventListener("DOMContentLoaded", function () {
        selectedAdditional.forEach(name => {
            let formattedId = `additional-${name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z-]/g, '')}`;
            let additionalElement = document.getElementById(formattedId);
            if (additionalElement) additionalElement.classList.add("selected");
        });
    });
</script>

<?php include_once '../templates/footer.php'; ?>
