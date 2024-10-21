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
<div class="modal fade show" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true" style="display:block; margin:30vh auto;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="otpModalLabel">OTP Verification</h5>
      </div>
      <div class="modal-body">
        <form action="../php/otp_verification.php" method="post">
            <div class="mb-3">
                <label for="otpInput" class="form-label">Enter OTP:</label>
                <input type="text" class="form-control" id="otpInput" name="otp" required>
            </div>
            <input type="hidden" id="emailOtp" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
