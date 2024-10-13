<?php
include '../../php/conn_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $id = $_POST['job_id'];
    $j_title = $_POST['jtitle'];
    $desc = $_POST['desc'];
    $spe = $_POST['spe'];
    $vacant = $_POST['vacant'];
    $act = $_POST['act'];
    $job_type = $_POST['jobtype'];

    // Update the data in the quiz_name table
    $sql = "UPDATE `job_postings` 
            SET job_title = '$j_title', job_type = '$job_type', job_description = '$desc', specialization = '$spe', vacant = '$vacant', is_active = '$act', date_posted = NOW()
            WHERE j_id = '$id'";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the add_question page with parameters
        header("Location: ../../html/employer/job_list.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
