<?php
include 'conn_db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../php/mailer/vendor/autoload.php';

function sendAcceptanceEmail($email, $applicantName) {
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
        $mail->Subject = 'Application Accepted';
        $mail->Body = "Dear $applicantName,<br><br>
        Congratulations! Your application has been accepted.<br>
        Please contact us for further details.<br><br>
        Regards,<br>PESO-lb.ph Team";

        $mail->send();
        echo 'Acceptance email has been sent.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$job_posting_id = $_GET['job_id'];
$user_id = $_GET['id'];

// Update the application status for the given applicant ID
$sql = "UPDATE applications SET status = 'accepted' WHERE applicant_id = '$user_id' AND job_posting_id = '$job_posting_id'";

if ($conn->query($sql) === TRUE) {
    // Fetch applicant's email and name
    $applicantQuery = "SELECT email, first_name FROM applicant_profile WHERE user_id = '$user_id'";
    $applicantResult = $conn->query($applicantQuery);

    if ($applicantResult->num_rows > 0) {
        $applicant = $applicantResult->fetch_assoc();
        $applicantEmail = $applicant['email'];
        $applicantName = $applicant['first_name'];

        // Send acceptance email
        sendAcceptanceEmail($applicantEmail, $applicantName);
    } else {
        echo "Applicant details not found.";
    }

    // Subtract 1 from the vacant column in the job_posting table
    $update_vacant_sql = "UPDATE job_postings SET vacant = GREATEST(vacant - 1, 0) WHERE j_id = '$job_posting_id'";
    if ($conn->query($update_vacant_sql) === TRUE) {

        // Check if the vacant count is now zero
        $check_vacant_sql = "SELECT vacant FROM job_postings WHERE j_id = '$job_posting_id'";
        $vacant_result = $conn->query($check_vacant_sql);

        if ($vacant_result->num_rows > 0) {
            $vacant_row = $vacant_result->fetch_assoc();
            $vacant_count = $vacant_row['vacant'];

            // If vacant is 0, deactivate the job posting by setting is_active to 0
            if ($vacant_count == 0) {
                $deactivate_job_sql = "UPDATE job_postings SET is_active = 0 WHERE j_id = '$job_posting_id'";
                if ($conn->query($deactivate_job_sql) === TRUE) {
                    echo "Job posting deactivated due to zero vacancies.";
                } else {
                    echo "Error deactivating job posting: " . $conn->error;
                }
            }
        }

        echo "Application accepted and vacant position updated.";
    } else {
        echo "Error updating vacant position: " . $conn->error;
    }

    // Redirect to the applicant list using the original job_posting_id
    header("Location: ../../html/employer/applicant_list.php?job_id=".$job_posting_id);
    exit(); // Ensure to stop further script execution
} else {
    // Display an error message if the query fails
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
