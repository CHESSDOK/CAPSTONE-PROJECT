<?php
session_start();
// Check if job is set
if (isset($_GET['job'])) {
    $jobTitle = urldecode($_GET['job']);
} else {
    header("Location: index.html");
    exit();
}

include '../../php/conn_db.php';


// Fetch the user data (assuming you have a way to identify the user, e.g., session)
$user_id = $_SESSION['id']; // This should be set dynamically based on logged-in user
$sql = "SELECT * FROM applicant_profile WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch the job posting data // This should be set based on the job the user is applying for
$sql = "SELECT * FROM job_postings WHERE job_title = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $jobTitle);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();
$stmt->close();

if (!$user || !$job) {
    die("Invalid user or job data.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Apply for <?php echo htmlspecialchars($jobTitle); ?></h1>
        <form action="../../php/applicant/submit_application.php" method="post">
            <input type="hidden" name="job" value="<?php echo htmlspecialchars($jobTitle); ?>">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
            <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job['j_id']); ?>">
            <h4><?php echo htmlspecialchars($job['job_description']); ?> </h4><br>
            <h4><?php echo htmlspecialchars($job['requirment']); ?> </h4> <br>
            <h4><?php echo htmlspecialchars($job['work_location']); ?> </h4> <br>
            <h4><?php echo htmlspecialchars($job['remarks']); ?> </h4> <br>
            <h4><?php echo htmlspecialchars($job['date_posted']); ?> </h4> <br>
            <input type="submit" value="Submit Application">
        </form>
    </div>
</body>
</html>