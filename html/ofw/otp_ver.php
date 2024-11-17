<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/nav.css">
  <link rel="stylesheet" href="../css/register.css">
</head>
<body>
<nav>
        <div class="logo">
            <img src="../img/logo_peso.png" alt="Logo">
            <a href="#"> PESO-lb.ph</a>
        </div>
    </nav>

<!-- OTP Verification Modal -->
<div class="modal fade show" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true" style="display:block;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="otpModalLabel">OTP Verification</h5>
      </div>
      <div class="modal-body">
        <form action="otp_verification.php" method="post">
            <div class="mb-3">
                <label for="otpInput" class="form-label">Enter OTP:</label>
                <input type="text" class="form-control" id="otpInput" name="otp" required>
            </div>
            <input type="hidden" id="emailOtp" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" id="resendOtpBtn">Resend OTP</button>
      </div>
    </div>
  </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('resendOtpBtn').addEventListener('click', function() {
    const email = document.getElementById('emailOtp').value;

    fetch('../../php/ofw/resend_otp.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            email: email,
        }),
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    })
    .catch(error => {
        alert('Error resending OTP. Please try again.');
        console.error('Error:', error);
    });
});
</script>
</body>
</html>
