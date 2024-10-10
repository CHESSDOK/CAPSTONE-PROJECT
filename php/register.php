<?php
include 'conn_db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'mailer/vendor/autoload.php';

function sendOtpEmail($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'jervinguevarra123@gmail.com'; // SMTP username
        $mail->Password = 'wdul asom bddj yhfd'; // SMTP password (Use app-specific password for Gmail)
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

if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['user']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Generate a 6-digit OTP
    $otp = mt_rand(100000, 999999);

    // Set the OTP expiration time (current time + 10 minutes)
    date_default_timezone_set('Asia/Manila');
    $otp_expiry = date("Y-m-d H:i:s", strtotime('+5 minutes'));

    // Insert the new user into the register table
    $sql = "INSERT INTO register (email, username, password, otp, otp_expiry, is_verified) 
            VALUES ('$email', '$username', '$hashedPassword', '$otp', '$otp_expiry', 0)";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;

        // Insert into `applicant_profile`
        $sql = "INSERT INTO applicant_profile (user_id, email) VALUES ('$last_id','$email')";
        if ($conn->query($sql) === TRUE) {
            // Send OTP email
            sendOtpEmail($email, $otp);

            // Redirect to OTP verification page with email
            header("Location: ../html/otp_ver.php?email=" . urlencode($email));
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    }
?>