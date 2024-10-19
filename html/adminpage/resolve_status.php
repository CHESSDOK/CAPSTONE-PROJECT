<?php
include 'conn_db.php';
$email = $_GET['email'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../php/mailer/vendor/autoload.php';

function sendResolveEmail($email) {
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
        $mail->Subject = 'Case resolve';
        $mail->Body = 'We have read your distress and send the file to OWA, please wait for the OWA to contact you';

        $mail->send();
        echo 'OTP email has been sent.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}


    $id = $_GET['case_id'];

    // Update the data in the quiz_name table
    $sql = "UPDATE `cases` 
            SET status = 'resolved'
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        sendResolveEmail($email);
        // Redirect to the add_question page with parameters
        header("Location: ofw_case.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
