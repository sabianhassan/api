<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Select a Meal Package</h2>

    <div class="room-selection">
        <!-- Changed id from "meal-breakfast" to "meal-breakfast-only" -->
        <div class="room-card" onclick="toggleMeal('Breakfast Only')" id="meal-breakfast-only">
            <img src="../assets/images/breakfast1.jpeg" alt="Breakfast Only">
            <p>Breakfast Only - $30</p>
            <img src="../assets/images/breakfast2.jpeg" alt="Breakfast Only">
        </div>
        <!-- Changed id from "meal-three" to "meal-three-course-meal" -->
        <div class="room-card" onclick="toggleMeal('Three Course Meal')" id="meal-three-course-meal">
            <img src="../assets/images/meal.jpeg" alt="Three Course Meal">
            <p>Three Course Meal - $75</p>
        </div>
        <!-- Changed id from "meal-drinks" to "meal-drinks-only" -->
        <div class="room-card" onclick="toggleMeal('Drinks Only')" id="meal-drinks-only">
            <img src="../assets/images/drinks1.jpeg" alt="Drinks Only">
            <p>Drinks Only - $25</p>
            <img src="../assets/images/drinks2.jpeg" alt="Drinks Only">
            <img src="../assets/images/drinks3.jpg" alt="Drinks Only">
        </div>
    </div>

    <div class="navigation">
        <a href="packages.php" class="back-btn">⬅ Back</a>
        <button id="save-btn" class="btn btn-secondary">Save Selection</button>
        <a href="additional.php" class="continue-btn" id="continue-btn">Continue ➡</a>
    </div>
</div>

<script>
    // Load selected meals from localStorage
    let selectedMeals = JSON.parse(localStorage.getItem("selected_meals")) || [];
    let continueBtn = document.getElementById("continue-btn");
    let saveBtn = document.getElementById("save-btn");

    function toggleMeal(name) {
        // Format the meal name into the element ID, e.g., "Breakfast Only" becomes "meal-breakfast-only"
        let formattedId = `meal-${name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z-]/g, '')}`;
        let mealElement = document.getElementById(formattedId);
        if (!mealElement) return; // Exit if element not found

        let index = selectedMeals.indexOf(name);
        if (index > -1) {
            // Remove selection if already selected
            selectedMeals.splice(index, 1);
            mealElement.classList.remove("selected");
        } else {
            // Add selection if not selected
            selectedMeals.push(name);
            mealElement.classList.add("selected");
        }
        localStorage.setItem("selected_meals", JSON.stringify(selectedMeals));
    }

    // On page load, restore selections using explicit IDs
    document.addEventListener("DOMContentLoaded", function () {
        selectedMeals.forEach(name => {
            let formattedId = `meal-${name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z-]/g, '')}`;
            let mealElement = document.getElementById(formattedId);
            if (mealElement) {
                mealElement.classList.add("selected");
            }
        });
    });

    // Save Selection Button functionality
    saveBtn.addEventListener("click", function() {
        alert("Your meal selection has been saved: " + JSON.stringify(selectedMeals));
        console.log("Saved meal selection:", selectedMeals);
    });
</script>

<?php include_once '../templates/footer.php'; ?>
