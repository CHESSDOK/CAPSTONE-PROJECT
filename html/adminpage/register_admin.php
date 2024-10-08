<?php
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['level'])) {
        // Redirect to login page if session not found
        header("Location: login_admin.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['level'];
    }
}
include 'conn_db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../php/mailer/vendor/autoload.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    // Insert admin details into database
    $sql = "INSERT INTO admin_profile (username, password, email) VALUES ('$username', '$password', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'> 
                    alert('Account Created, password is send to email');
                    window.location.href='admin_home.php'; 
                  </script>";

        // Send email with PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     // Set SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'jervinguevarra123@gmail.com';               // SMTP username
            $mail->Password   = 'wdul asom bddj yhfd';                  // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
            $mail->Port       = 587;                                    // TCP port to connect to

            // Recipients
            $mail->setFrom('jervinguevarra123@gmail.com', 'PESO-lb.ph');
            $mail->addAddress($email);                                  // Add recipient

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'Welcome to Admin Portal';
            $mail->Body    = "Hello $username,<br>Your registration was successful. Your password is: " . $_POST['password'] . "<br>Please keep this information secure.";
            $mail->AltBody = "Hello $username, Your registration was successful. Your password is: " . $_POST['password'] . ". Please keep this information secure.";

            $mail->send();
            echo 'Password has been emailed.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
