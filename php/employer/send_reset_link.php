<?php
include '../conn_db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../mailer/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);

    // Check if the email exists in the database
    $sql = "SELECT id FROM empyers WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a unique reset token
        $token = bin2hex(random_bytes(50)); // Generate a random token
        date_default_timezone_set('Asia/Manila'); // Adjust to your correct timezone
        $expiry_time = date("Y-m-d H:i:s", strtotime('+5 minutes')); // Token valid for 1 hour

        // Store the token and expiry time in the database
        $sql = "UPDATE empyers SET reset_token = '$token', reset_token_expiry = '$expiry_time' WHERE email = '$email'";
        $conn->query($sql);

        // Send email with reset link
        $reset_link = "localhost/wakey/html/employer/reset_password.php?token=" . urlencode($token);

        sendResetEmail($email, $reset_link);

        echo "<script>alert('A reset link has been sent to your email address.'); window.location.href='../../html/employer_login.html';</script>";
    } else {
        echo "<script>alert('No account found with that email address.'); window.location.href='../../html/employer_login.html';</script>";
    }

    $conn->close();
}

function sendResetEmail($email, $reset_link) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'jervinguevarra123@gmail.com'; // SMTP username
        $mail->Password = 'wdul asom bddj yhfd'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('jervinguevarra123@gmail.com', 'PESO-lb.ph');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = 'Click the following link to reset your password: <a href="' . $reset_link . '">Reset Password</a>';

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
