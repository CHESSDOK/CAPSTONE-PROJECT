<?php
include 'conn_db.php';
$job_posting_id = $_GET['job_id'];
$user_id = $_GET['id'];

// Update the application status for the given applicant ID
$sql = "UPDATE applications SET status = 'accepted' WHERE applicant_id = '$user_id' AND job_posting_id = '$job_posting_id'";

if ($conn->query($sql) === TRUE) {
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
