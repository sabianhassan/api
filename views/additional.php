<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Select Additional Services</h2>

    <div class="room-selection">
        <!-- Additional Service: Pool Access -->
        <div class="room-card" onclick="toggleAdditional('Pool Access')" id="additional-pool-access">
            <img src="../assets/images/pool bar1.jpeg" alt="Pool Access">
            <p>Pool Access - $50</p>
        </div>
        <!-- Additional Service: Bar Access -->
        <div class="room-card" onclick="toggleAdditional('Bar Access')" id="additional-bar-access">
            <img src="../assets/images/poolbar2.jpeg" alt="Bar Access">
            <p>Bar Access - $70</p>
            <img src="../assets/images/poolbar3.jpeg" alt="Bar Access">
        </div>
    </div>

    <div class="navigation">
        <a href="meals.php" class="back-btn">⬅ Back</a>
        <button id="save-btn" class="btn btn-secondary">Save Selection</button>
        <a href="duration.php" class="continue-btn" id="continue-btn">Continue ➡</a>
    </div>
</div>

<script>
    let selectedAdditional = JSON.parse(localStorage.getItem("selected_additional")) || [];
    let saveBtn = document.getElementById("save-btn");

    function toggleAdditional(name) {
        // Format the name into the element ID, e.g., "Pool Access" becomes "additional-pool-access"
        let formattedId = `additional-${name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z-]/g, '')}`;
        let additionalElement = document.getElementById(formattedId);
        if (!additionalElement) return;

        let index = selectedAdditional.indexOf(name);
        if (index > -1) {
            // Remove the selection if already selected
            selectedAdditional.splice(index, 1);
            additionalElement.classList.remove("selected");
        } else {
            // Add the selection if not already selected
            selectedAdditional.push(name);
            additionalElement.classList.add("selected");
        }
        localStorage.setItem("selected_additional", JSON.stringify(selectedAdditional));
    }

    // On page load, restore saved selections by applying the "selected" class to the corresponding elements
    document.addEventListener("DOMContentLoaded", function () {
        selectedAdditional.forEach(name => {
            let formattedId = `additional-${name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z-]/g, '')}`;
            let additionalElement = document.getElementById(formattedId);
            if (additionalElement) {
                additionalElement.classList.add("selected");
            }
        });
    });

    // Save Selection Button functionality
    saveBtn.addEventListener("click", function() {
        alert("Your additional service selection has been saved: " + JSON.stringify(selectedAdditional));
        console.log("Saved additional selection:", selectedAdditional);
    });
</script>

<?php include_once '../templates/footer.php'; ?>
