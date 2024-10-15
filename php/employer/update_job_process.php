<?php
include 'conn_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    // Retrieve form values
    $job_id = $_POST['job_id'];
    $j_title = $_POST['job_title'];
    $desc = $_POST['job_description'];
    $job_type = $_POST['jobtype'];
    $spe = $_POST['spe'];
    $req =  $_POST['req'];
    $loc =  $_POST['loc'];
    $rem =   $_POST['rem'];
    $salary =   $_POST['salary'];
    $vacant = $_POST['vacant'];
    $education_background =  $_POST['education_background'];
    $selectedOptions = $_POST['selectedOptions'] ?? ''; 
    $optionsArray = explode(',', $selectedOptions); // Convert it to an array
    $optionsString = implode(',', $optionsArray);


    // Update the job_postings table
    $sql = "UPDATE job_postings 
            SET job_title = ?, 
                vacant = ?, 
                selected_options = ?,
                salary = ?, 
                job_description = ?,
                education = ?, 
                job_type = ?, 
                requirment = ?, 
                work_location = ?, 
                remarks = ? 
            WHERE j_id = ?";

    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        echo "Error in preparing the statement: " . $conn->error;
        exit();
    }

    // Bind the parameters
    $stmt->bind_param("sissssssssi", 
        $j_title, $vacant, $optionsString, $salary,
        $desc, $education_background, $job_type, $req, 
        $loc, $rem, $job_id
    );

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect after successful update
        header("Location: ../../html/employer/job_list.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
