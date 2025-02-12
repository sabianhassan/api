<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Select a Package</h2>

    <div class="room-selection">
        <div class="room-card" onclick="togglePackage('Romantic Package')" id="package-romantic-package">
            <img src="../assets/images/romantic1.jpeg" alt="Romantic Package">
            <p>Romantic Package - $200</p>
        </div>
        <div class="room-card" onclick="togglePackage('Family Fun Package')" id="package-family-fun-package">
            <img src="..\assets\images\family1.jpeg" alt="Family Fun Package">
            <p>Family Fun Package - $250</p>
            <img src="..\assets\images\family2.jpeg" alt="Family Fun Package">
            <p>Family Fun Package - $250</p>
        </div>
        <div class="room-card" onclick="togglePackage('Business Package')" id="package-business-package">
            <img src="../assets/images/business1.jpeg" alt="Business Package">
            <p>Business Package - $180</p>
        </div>
    </div>

    <div class="navigation">
        <a href="room.php" class="back-btn">⬅ Back</a>
        <a href="meals.php" class="continue-btn">Continue ➡</a>
    </div>
</div>

<script>
    let selectedPackages = JSON.parse(localStorage.getItem("selected_packages")) || [];

    function togglePackage(name) {
        let formattedId = `package-${name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z-]/g, '')}`;
        let packageElement = document.getElementById(formattedId);
        
        if (!packageElement) return; // Prevent errors if element is not found

        let index = selectedPackages.indexOf(name);
        if (index > -1) {
            selectedPackages.splice(index, 1);
            packageElement.classList.remove("selected");
        } else {
            selectedPackages.push(name);
            packageElement.classList.add("selected");
        }
        localStorage.setItem("selected_packages", JSON.stringify(selectedPackages));
    }

    document.addEventListener("DOMContentLoaded", function () {
        selectedPackages.forEach(name => {
            let formattedId = `package-${name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z-]/g, '')}`;
            let packageElement = document.getElementById(formattedId);
            if (packageElement) packageElement.classList.add("selected");
        });
    });
</script>

<?php include_once '../templates/footer.php'; ?>
