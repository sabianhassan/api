<?php include_once '../templates/header.php'; ?>

<?php
require_once __DIR__ . '/../classes/Database.php';
$pdo = connectDatabase();

// Fetch all packages from the database
$stmt = $pdo->prepare("SELECT * FROM packages ORDER BY package_id ASC");
$stmt->execute();
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2 class="text-center">Select a Package</h2>

    <div class="room-selection">
        <?php if(count($packages) > 0): ?>
            <?php foreach($packages as $package): 
                // Create a formatted ID similar to your original code
                $formattedId = 'package-' . strtolower(str_replace(' ', '-', $package['name']));
            ?>
                <div class="room-card" onclick="togglePackage('<?php echo htmlspecialchars($package['name'], ENT_QUOTES); ?>')" id="<?php echo $formattedId; ?>">
                    <?php
                        // Display images based on package name
                        if ($package['name'] === "Romantic Package") {
                            echo "<img src='../assets/images/romantic1.jpeg' alt='Romantic Package'>";
                        } elseif ($package['name'] === "Family Fun Package") {
                            echo "<img src='../assets/images/family1.jpeg' alt='Family Fun Package'>";
                            echo "<img src='../assets/images/family2.jpeg' alt='Family Fun Package'>";
                        } elseif ($package['name'] === "Business Package") {
                            echo "<img src='../assets/images/business1.jpeg' alt='Business Package'>";
                        } else {
                            // Fallback image if package name doesn't match any of the above
                            echo "<img src='../assets/images/package_default.jpg' alt='" . htmlspecialchars($package['name'], ENT_QUOTES) . "'>";
                        }
                    ?>
                    <p><?php echo htmlspecialchars($package['name']); ?> - $<?php echo number_format($package['price'], 2); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No packages available at the moment.</p>
        <?php endif; ?>
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
