<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Select a Package</h2>

    <div class="room-selection">
        <div class="room-card" onclick="togglePackage('Romantic Package')" id="package-romantic-package">
            <img src="../assets/images/romantic1.jpeg" alt="Romantic Package">
            <p>Romantic Package - $200</p>
        </div>
        <div class="room-card" onclick="togglePackage('Family Fun Package')" id="package-family-fun-package">
            <img src="../assets/images/family1.jpeg" alt="Family Fun Package">
            <p>Family Fun Package - $250</p>
            <img src="../assets/images/family2.jpeg" alt="Family Fun Package">
        </div>
        <div class="room-card" onclick="togglePackage('Business Package')" id="package-business-package">
            <img src="../assets/images/business1.jpeg" alt="Business Package">
            <p>Business Package - $180</p>
        </div>
    </div>

    <div class="navigation">
        <a href="room.php" class="back-btn">⬅ Back</a>
        <button id="save-btn" class="btn btn-secondary">Save Selection</button>
        <a href="meals.php" class="continue-btn disabled" id="continue-btn">Continue ➡</a>
    </div>
</div>

<script>
    // Load selected packages from localStorage
    let selectedPackages = JSON.parse(localStorage.getItem("selected_packages")) || [];
    let continueBtn = document.getElementById("continue-btn");
    let saveBtn = document.getElementById("save-btn");

    function togglePackage(name) {
        // Format the ID from the package name
        let formattedId = `package-${name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z-]/g, '')}`;
        let packageElement = document.getElementById(formattedId);
        
        if (!packageElement) return; // If element not found, exit

        let index = selectedPackages.indexOf(name);
        if (index > -1) {
            // Remove selection
            selectedPackages.splice(index, 1);
            packageElement.classList.remove("selected");
        } else {
            // Add selection
            selectedPackages.push(name);
            packageElement.classList.add("selected");
        }
        localStorage.setItem("selected_packages", JSON.stringify(selectedPackages));
        updateContinueButton();
    }

    // Update the continue button state
    function updateContinueButton() {
        if (selectedPackages.length > 0) {
            continueBtn.classList.remove("disabled");
            continueBtn.href = "meals.php";
        } else {
            continueBtn.classList.add("disabled");
            continueBtn.removeAttribute("href");
        }
    }

    // Restore selections on page load
    document.addEventListener("DOMContentLoaded", function () {
        selectedPackages.forEach(function(name) {
            let formattedId = `package-${name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z-]/g, '')}`;
            let packageElement = document.getElementById(formattedId);
            if (packageElement) {
                packageElement.classList.add("selected");
            }
        });
        updateContinueButton();
    });

    // Save Selection Button functionality
    saveBtn.addEventListener("click", function() {
        alert("Your selection has been saved: " + JSON.stringify(selectedPackages));
        console.log("Saved selection:", selectedPackages);
    });
</script>

<?php include_once '../templates/footer.php'; ?>
