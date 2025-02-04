<?php include_once '../templates/header.php'; ?>


<div class="container mt-5">
    <h2>Verify 2FA</h2>
    <form action="../verify_otp.php" method="POST">
        <div class="form-group">
            <label>Enter OTP</label>
            <input type="text" name="otp" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
    <form action="../resend_otp.php" method="POST" class="mt-3">
        <button type="submit" class="btn btn-secondary">Resend OTP</button>
    </form>
</div>

<?php include_once '../templates/footer.php'; ?>
