<?php
include '../conn_db.php';

$userId = $_GET['userid']; // Get the logged-in user's ID
$joib = $_GET['job'];

$sql = "INSERT INTO `save_job` (`applicant_id`, `job_id`) VALUES ('$userId','$joib')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../../html/applicant/applicant.php");
    } else {
        echo "Error inserting" . $conn->error . "<br>";
    }
?>