<?php
include 'conn_db.php';

    $id = $_GET['case_id'];

    // Update the data in the quiz_name table
    $sql = "UPDATE `cases` 
            SET status = 'resolved'
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the add_question page with parameters
        header("Location: ofw_case.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
