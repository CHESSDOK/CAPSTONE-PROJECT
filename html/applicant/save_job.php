<?php
include '../../php/conn_db.php';
$userId = $_SESSION['id'];
// SQL query to fetch applied jobs
$sql = "
SELECT s.*, jp.* 
FROM save_job s
JOIN job_postings jp ON s.job_id = jp.j_id
WHERE s.applicant_id = $userId
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

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Job Title</th>
                        <th>Job Type</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['job_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['salary']); ?></td>
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
