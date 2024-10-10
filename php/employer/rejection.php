<?php
    function checkSession() {
        session_start(); // Start the session

        // Check if the session variable 'id' is set
        if (!isset($_SESSION['id'])) {
            // Redirect to login page if session not found
            header("Location: html/login_employer.html");
            exit();
        } else {
            // If session exists, store the session data in a variable
            return $_SESSION['id'];
        }
    }

    $userId = checkSession();
include '../conn_db.php';
$user_id = $_GET['id'];
$job_id = $_GET['job_id'];

    // Update the data in the quiz_name table
    $sql = "UPDATE applications SET status = 'rejected' WHERE applicant_id = '$user_id' AND job_posting_id = $job_id";

        if (mysqli_query($conn, $sql)) {
            // Redirect to the add_question page with parameters
            header("Location: ../../html/employer/applicant_list.php?job_id=$job_id");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    mysqli_close($conn);
?>
