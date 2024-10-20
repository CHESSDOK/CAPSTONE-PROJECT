<?php
include '../../php/conn_db.php';
$userId = $_SESSION['id'];

// Prepare SQL query to fetch saved jobs along with additional job details
$sql = "
SELECT jp.*, em.company_name, em.photo, em.company_address, em.company_mail, em.tel_num, ad.username AS admin_username, a.status
FROM save_job s
JOIN job_postings jp ON s.job_id = jp.j_id
LEFT JOIN employer_profile em ON jp.employer_id = em.user_id
LEFT JOIN admin_profile ad ON jp.admin_id = ad.id
LEFT JOIN applications a ON a.job_posting_id = jp.j_id AND a.applicant_id = ?
WHERE s.applicant_id = ? AND jp.is_active = 1 AND a.status IS NULL
";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameters for `applicant_id`
$stmt->bind_param("ii", $userId, $userId);

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

                            <?php if (!empty($job["company_name"])): ?>
                                <p class="mb-0" style="font-size: 1rem; color: #6c757d;">
                                    <i class="fas fa-building" style="color: #007bff;"></i> <?php echo htmlspecialchars($job["company_name"]); ?><br>
                                    <i class="fas fa-map-marker-alt" style="color: #007bff;"></i> <?php echo htmlspecialchars($job["company_address"]); ?><br>
                                    <i class="fas fa-envelope" style="color: #007bff;"></i> <?php echo htmlspecialchars($job["company_mail"]); ?><br>
                                    <i class="fas fa-phone" style="color: #007bff;"></i> <?php echo htmlspecialchars($job["tel_num"]); ?>
                                </p>
                            <?php else: ?>
                                <p>Posted by Admin: <strong><?php echo htmlspecialchars($job["admin_username"]); ?></strong></p>
                            <?php endif; ?>
                        </div>

                        <!-- Vacancy status and apply button -->
                        <div class="col-md-4 text-end">
                            <div class="d-flex justify-content-between align-items-center">
                                
                                <!-- Vacancy Status -->
                                <p class="mb-1">
                                    <span class="badge <?php echo ($job["vacant"] > 1 ? 'bg-success' : 'bg-danger'); ?> d-block fs-5 p-2 mb-3">
                                        <?php echo ($job['vacant'] > 1 ? 'Vacant' : 'Not Vacant'); ?>
                                    </span>
                                    <span class="ms-2 fs-5 d-block mb-4"><?php echo htmlspecialchars($job['vacant']); ?> openings</span>
                                </p>
                                
                                <!-- Apply Button -->
                                <a href="../../html/applicant/apply.php?job=<?php echo urlencode($job["job_title"]); ?>" class="btn btn-primary">
                                    Apply <i class="fa fa-chevron-right"></i>
                                </a>
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
