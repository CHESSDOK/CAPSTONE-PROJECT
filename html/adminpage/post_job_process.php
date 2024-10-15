<?php
session_start();

include 'conn_db.php';

$admin_id = $_SESSION['id']; // Assume you store the user_id in session after login

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Escape the inputs to prevent SQL injection
    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $job_description = mysqli_real_escape_string($conn, $_POST['job_description']);
    $vacant = mysqli_real_escape_string($conn, $_POST['vacant']);
    $requirment = mysqli_real_escape_string($conn, $_POST['req']);
    $location = mysqli_real_escape_string($conn, $_POST['loc']);
    $remarks = mysqli_real_escape_string($conn, $_POST['rem']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $date_posted = date('Y-m-d'); // No need to escape as this is generated
    $jobtype =  $_POST['jobtype'];
    $selectedOptions = $_POST['selectedOptions'] ?? ''; 
    $optionsArray = explode(',', $selectedOptions); // Convert it to an array
    $optionsString = implode(',', $optionsArray);

    // Construct the SQL query
    $sql = "INSERT INTO job_postings (admin_id, job_title, salary, job_type, job_description, selected_options, requirment, work_location, remarks, date_posted, vacant) 
            VALUES ('$admin_id', '$job_title', '$salary', '$jobtype', '$job_description', '$optionsString', '$requirment', '$location', '$remarks', '$date_posted', '$vacant')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the create_job page with a success message
        echo "<script>
                alert('Job successfully created!');
                window.location.href = 'create_job.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
