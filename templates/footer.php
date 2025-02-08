<footer class="footer mt-auto py-3 bg-light text-center">
    <div class="container">
        <span class="text-muted">© 2025 Jambo_Reservations. All rights reserved.</span>
    </div>
</footer>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let checkinInput = document.getElementById("checkin");
    let checkoutInput = document.getElementById("checkout");

    // Set minimum check-in time to current date and time
    let now = new Date().toISOString().slice(0, 16);
    checkinInput.min = now;

    checkinInput.addEventListener("change", function() {
        let checkinTime = checkinInput.value;
        checkoutInput.min = checkinTime; // Ensure checkout is after check-in
    });
});
</script>
</body>
</html>

</body>
</html>
