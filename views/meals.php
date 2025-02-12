<?php include_once '../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Select a Meal Package</h2>

    <div class="room-selection">
        <div class="room-card" onclick="toggleMeal('Breakfast Only')" id="meal-breakfast">
            <img src="..\assets\images\breakfast1.jpeg" alt="Breakfast Only">
            <p>Breakfast Only - $30</p>
            <img src="..\assets\images\breakfast2.jpeg" alt="Breakfast Only">
            <p>Breakfast Only - $30</p>
        </div>
        <div class="room-card" onclick="toggleMeal('Three Course Meal')" id="meal-three">
            <img src="..\assets\images\meal.jpeg" alt="Three Course Meal">
            <p>Three Course Meal - $75</p>
        </div>
        <div class="room-card" onclick="toggleMeal('Drinks Only')" id="meal-drinks">
            <img src="..\assets\images\drinks1.jpeg" alt="Drinks Only">
            <p>Drinks Only - $25</p>
            <img src="..\assets\images\drinks2.jpeg" alt="Drinks Only">
            <p>Drinks Only - $25</p>
            <img src="..\assets\images\drinks3.jpg" alt="Drinks Only">
            <p>Drinks Only - $25</p>
        </div>
    </div>

    <div class="navigation">
        <a href="packages.php" class="back-btn">⬅ Back</a>
        <a href="additional.php" class="continue-btn">Continue ➡</a>
    </div>
</div>

<script>
    let selectedMeals = JSON.parse(localStorage.getItem("selected_meals")) || [];

    function toggleMeal(name) {
        let index = selectedMeals.indexOf(name);
        if (index > -1) {
            selectedMeals.splice(index, 1);
            document.getElementById(`meal-${name.toLowerCase().replace(/\s/g, '-')}`).classList.remove("selected");
        } else {
            selectedMeals.push(name);
            document.getElementById(`meal-${name.toLowerCase().replace(/\s/g, '-')}`).classList.add("selected");
        }
        localStorage.setItem("selected_meals", JSON.stringify(selectedMeals));
    }

    document.addEventListener("DOMContentLoaded", function () {
        selectedMeals.forEach(meal => {
            let mealElement = document.querySelector(`[onclick*="${meal}"]`);
            if (mealElement) mealElement.classList.add("selected");
        });
    });
</script>

<?php include_once '../templates/footer.php'; ?>
