<?php
include '../../php/conn_db.php';
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
        header("Location: ../login.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}
$userId = checkSession();
// Get the applicant ID (In practice, you'd fetch this from a session or request)
 // Replace with the actual applicant ID

// SQL query to fetch applied jobs
$sql = "
SELECT a.id AS application_id, 
       jp.job_title, 
       jp.job_type, 
       jp.salary, 
       a.application_date, 
       a.status 
FROM applications a
JOIN job_postings jp ON a.job_posting_id = jp.j_id
WHERE a.applicant_id = $userId
ORDER BY a.application_date DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Applied Jobs</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">List of Applied Jobs</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Job Title</th>
                        <th>Job Type</th>
                        <th>Salary</th>
                        <th>Application Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['job_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['salary']); ?></td>
                        <td><?php echo htmlspecialchars($row['application_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            No jobs applied yet.
        </div>
    <?php endif; ?>

    <?php $conn->close(); ?>
</div>

<!-- Bootstrap JS and dependencies (Popper and Bootstrap's JavaScript components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
