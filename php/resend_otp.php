<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'mailer/vendor/autoload.php';
require 'conn_db.php';

function sendOtpEmail($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jervinguevarra123@gmail.com';
        $mail->Password = 'wdul asom bddj yhfd'; // App-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('jervinguevarra123@gmail.com', 'PESO-lb.ph');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body = 'Your OTP for email verification is: <b>' . $otp . '</b>. It will expire in 10 minutes.';

        $mail->send();
        echo 'OTP email has been sent.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);

    // Check if email exists and is not yet verified
    $sql = "SELECT * FROM applicant_profile WHERE email = '$email' AND is_verified = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $otp = rand(100000, 999999); // Generate a new OTP
        $otp_expiry = date("Y-m-d H:i:s", strtotime("+10 minutes")); // Set OTP expiry

        // Update the new OTP in the database
        $update_sql = "UPDATE applicant_profile SET otp = '$otp', otp_expiry = '$otp_expiry' WHERE email = '$email'";
        if ($conn->query($update_sql) === TRUE) {
            // Send the new OTP to the user's email
            sendOtpEmail($email, $otp);
        } else {
            echo "Error updating OTP. Please try again later.";
        }
    } else {
        echo "Email not found or already verified.";
    }

    $conn->close();
}
?>
