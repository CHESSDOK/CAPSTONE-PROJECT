<?php
include 'conn_db.php'; // Include your MySQLi connection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['applicant_id'];
    $job_id = $_POST['jobid'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $type = $_POST['interview'];
    $interviewType = $_POST['interview']; // Get the interview type (virtual or physical)

    // Determine which field to use based on interviewType
    if ($interviewType === 'online') {
        $meeting = $_POST['link'];  // Use the virtual link
    } else {
        $meeting = $_POST['address'];  // Use the physical address
    }

    // Step 1: Update the status in applications table
    $sqlUpdateStatus = "UPDATE applications SET status = 'interview' WHERE applicant_id = ? AND job_posting_id = ?";
    $stmtStatus = $conn->prepare($sqlUpdateStatus);
    $stmtStatus->bind_param("ii", $user_id, $job_id);
    
    if ($stmtStatus->execute()) {
        // Step 2: Insert into interview table
        $sqlInsertInterview = "INSERT INTO interview (user_id, job_id, sched_date, sched_time, interview, meeting) 
                               VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInterview = $conn->prepare($sqlInsertInterview);
        $stmtInterview->bind_param("iissss", $user_id, $job_id, $date, $time, $type, $meeting);

        if ($stmtInterview->execute()) {
            // Step 3: Update the vacant count in job_postings table
            $sqlVacant = "UPDATE job_postings SET vacant = vacant - 1 WHERE j_id = ?";
            $stmtVacant = $conn->prepare($sqlVacant);
            $stmtVacant->bind_param("i", $job_id);
            $stmtVacant->execute();
            $stmtVacant->close();

            header("Location: applicant_list.php?job_id=$job_id");    
        } else {
            echo "Error inserting interview: " . $stmtInterview->error;
        }
        
        $stmtInterview->close();
    } else {
        echo "Error updating status: " . $stmtStatus->error;
    }

    $stmtStatus->close();
    $conn->close();
}

?>