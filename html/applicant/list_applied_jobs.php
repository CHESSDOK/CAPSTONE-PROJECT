<?php
include '../../php/conn_db.php';
$userId = $_SESSION['id']; // Get the applicant's ID from the session

// SQL query to fetch applied jobs with additional employer and admin details
$sql = "
SELECT a.id AS application_id, 
       jp.job_title, 
       jp.job_type, 
       jp.salary, 
       a.application_date, 
       a.status, 
       em.company_name, 
       em.photo, 
       em.company_address, 
       em.company_mail, 
       em.tel_num, 
       ad.username AS admin_username
FROM applications a
JOIN job_postings jp ON a.job_posting_id = jp.j_id
LEFT JOIN employer_profile em ON jp.employer_id = em.user_id
LEFT JOIN admin_profile ad ON jp.admin_id = ad.id
WHERE a.applicant_id = ?
ORDER BY a.application_date DESC
";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the user ID to the placeholder in the SQL query
$stmt->bind_param("i", $userId);

// Execute the statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();
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


<?php if ($result->num_rows > 0): ?>
    <div class="row">
        <?php while ($job = $result->fetch_assoc()): ?>
            <div class="col-md-12">
                <div class="card mb-3 p-3 shadow-sm">
                    
                    <div class="row align-items-center">
                        
                        <!-- Job Logo / Placeholder -->
                        <div class="col-md-2 text-center">
                            <?php if (!empty($job["photo"])): ?>
                                <img src="../../php/employer/uploads/<?php echo htmlspecialchars($job["photo"]); ?>" alt="Logo" class="img-fluid rounded-circle mb-3" style="max-width: 100px; height: auto;">
                            <?php else: ?>
                                <img src="../../img/logo_peso.png" alt="Logo" class="img-fluid rounded-circle mb-3" style="max-width: 100px; height: auto;">
                            <?php endif; ?>
                        </div>
                        
                        <!-- Job Title and Company Details -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-briefcase" style="color: #007bff; margin-right: 8px;"></i>
                                <h4 class="fw-bold mb-0" style="color: #007bff;"><?php echo htmlspecialchars($job["job_title"]); ?></h4>
                            </div>

                            <!-- Job Details -->
                            <p class="mb-0" style="font-size: 1rem; color: #6c757d;">
                                <i class="fas fa-clipboard-list" style="color: #007bff;"></i> <?php echo htmlspecialchars($job["job_type"]); ?><br>
                                <i class="fas fa-dollar-sign" style="color: #007bff;"></i> <?php echo htmlspecialchars($job["salary"]); ?><br>
                                <i class="fas fa-calendar-alt" style="color: #007bff;"></i> <?php echo htmlspecialchars($job["application_date"]); ?><br>
                            </p>
                        </div>

                        <!-- job status  -->
                        <div class="col-md-4 text-end">
                            <div class="d-flex justify-content-end align-items-center">
                                <!-- Wrapped icon and status inside a div to control their layout -->
                                <div class="status-wrapper d-flex align-items-center">
                                    <i class="fas fa-info-circle text-primary fs-3 me-2"></i> <!-- Bootstrap class for large icon -->
                                    <span class="fw-bold fs-4"><?php echo htmlspecialchars($job["status"]); ?></span> <!-- Bootstrap class for larger text -->
                                </div>
                            </div>
                        </div>

                    </div> <!-- Close row -->

                </div> <!-- Close card -->
            </div> <!-- Close col-md-12 -->
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="alert alert-warning text-center" role="alert">
        No jobs applied yet.
    </div>
<?php endif; ?>

<?php $conn->close(); ?>


<!-- Bootstrap JS and dependencies (Popper and Bootstrap's JavaScript components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
