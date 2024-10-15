<?php
session_start();

include 'conn_db.php';

$user_id = $_SESSION['id']; // Assume you store the user_id in session after login

// Check if at least 3 employer documents are verified
$sql = "SELECT COUNT(*) AS count FROM employer_documents WHERE user_id = '$user_id' AND is_verified = 'verified'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Proceed if at least 3 documents are verified
if ($row['count'] >= 3) {
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $vacant = $_POST['vacant'];
    $date_posted = date('Y-m-d');
    $requirment = $_POST['req'];
    $location = $_POST['loc'];
    $remarks = $_POST['rem'];
    $jobtype = $_POST['jobtype'];
    $salary =  $_POST['salary'];
    $selectedOptions = $_POST['selectedOptions'] ?? ''; 
    $optionsArray = explode(',', $selectedOptions); // Convert it to an array
    $optionsString = implode(',', $optionsArray);
    $education_background = $_POST['education_background'];
    
    // Prepared statement for inserting the job posting
    $stmt = $conn->prepare("INSERT INTO job_postings (employer_id, job_title,job_type, salary, education, job_description, selected_options, requirment, work_location, remarks, date_posted, vacant) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssssss", $user_id, $job_title, $jobtype, $salary, $education_background, $job_description, $optionsString, $requirment, $location, $remarks, $date_posted, $vacant);

    if ($stmt->execute()) {
        // Get the ID of the newly inserted job
        $job_id = $stmt->insert_id;
        // Store the job_id in the session
        $_SESSION['job_id'] = $job_id;

        header("Location: ../../html/employer/job_creat.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "You need to have at least 3 verified documents before you can post a job. Please wait for verification.";
}

// Close the connection
$conn->close();
?>
