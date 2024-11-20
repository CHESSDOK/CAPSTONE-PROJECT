<?php
include '../conn_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $input_otp = $conn->real_escape_string($_POST['otp']);

    // Fetch the user's OTP and expiry from the database
    $sql = "SELECT otp, otp_expiry FROM empyers WHERE email = '$email' AND is_verified = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_otp = $row['otp'];
        $otp_expiry = $row['otp_expiry'];

        // Check if OTP matches and if it hasn't expired
        if ($input_otp == $stored_otp && strtotime($otp_expiry) > time()) {
            // OTP is valid and not expired, update the user to verified
            $update_sql = "UPDATE empyers SET is_verified = 1 WHERE email = '$email'";
            if ($conn->query($update_sql) === TRUE) {
                echo "<script type='text/javascript'>
                        alert('Your email has been successfully verified!');
                        window.location.href='../../html/employer_login.html';
                      </script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "<script type='text/javascript'>
                    alert('Invalid OTP or OTP has expired. Please try again.');
                    window.location.href='../../html/employer/otp_ver.php?email=$email';
                  </script>";
        }
    } else {
        echo "<script type='text/javascript'>
                alert('Email not found or already verified.');
                window.location.href='../../html/employer_login.html';
              </script>";
    }

    $conn->close();
}
?>
