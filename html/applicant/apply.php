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
$sql = "SELECT jp.*, em.*
        FROM job_postings jp
        LEFT JOIN employer_profile em ON jp.employer_id = em.user_id
        WHERE job_title = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $jobTitle);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();
$stmt->close();

if (!$user || !$job) {
    die("Invalid user or job data.");
}

if (!$user || !$job) {
    die("Invalid user or job data.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="../../css/nav_float.css">
  <link rel="stylesheet" href="../../css/applicant.css">
 
</head>
<body>

    <!-- Navigation -->
    <nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
        <h1 class="h1">Applicant Dashboard</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
    <?php if (!empty($row['photo'])): ?>
        <img id="preview" src="../../php/applicant/images/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
    <?php else: ?>
        <img src="../../img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
    <?php endif; ?>
    </div>



    </div>

    <!-- Burger icon -->
    <div class="burger" id="burgerToggle">
        <span></span>
        <span></span>
        <span></span>
    </div>
</td>
</tr>
</table>

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table class="menu">
                <tr><td><a href="../../index(applicant).php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="#" class="active nav-link">Applicant</a></td></tr>
                <tr><td><a href="training_list.php" class="nav-link">Training</a></td></tr>
                <tr><td><a href="ofw_form.php" class="nav-link">OFW</a></td></tr>
                <tr><td><a href="../../html/about.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="../../html/contact.php" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>
<body>

    <nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
        <div>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="../../index(applicant).php" >Home</a></li>
            <li class="breadcrumb-item"><a href="applicant.php" >Job List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Job Form</li>
          </ol>
        </div>
        <a href="javascript:history.back()" class="return me-2">
          <i class="fas fa-reply"></i> Back
        </a>
    </nav>

<div class="table-containers">
<div class="table-container">
    <form action="../../php/applicant/submit_application.php" method="post">
        <div class="card mb-3 p-3 shadow-sm">
            <div class="row align-items-center">

                <!-- Job Logo / Placeholder (left side) -->
                <div class="col-md-2 text-center">
                    <?php if (!empty($job["photo"])) { ?>
                        <img src="../../php/employer/uploads/<?php echo htmlspecialchars($job["photo"]); ?>" alt="Logo" class="img-fluid rounded-circle mb-3" style="max-width: 100px; height: auto;">
                    <?php } else { ?>
                        <img src="../../img/user-placeholder.png" alt="Logo" class="img-fluid rounded-circle mb-3" style="max-width: 100px; height: auto;">
                    <?php } ?>
                </div>

                <!-- Job Title and Description (center part) -->
                <div class="col-md-4">
                    <label class="fw-bold"><?php echo htmlspecialchars($jobTitle); ?></label>
                    <p><?php echo htmlspecialchars($jobTitle); ?></p><!--Company name-->
                    <p><?php echo htmlspecialchars($job['work_location']); ?></p>
                </div>

                <div class="col-md-2">
                    <p><?php echo htmlspecialchars($job['requirment']); ?></p><!--requirment dropdown-->
                </div>

                <div class="col-md-2">
                    <p><?php echo htmlspecialchars($job['job_type']); ?></p><!--job type-->
                </div>

                <!-- Apply button (right side) -->
                <div class="col-md-2 text-end">
                    <input type="hidden" name="job" value="<?php echo htmlspecialchars($jobTitle); ?>">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                    <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job['j_id']); ?>">
                    <h4><?php echo htmlspecialchars($job['date_posted']); ?></h4>
                    <input type="submit" value="Submit Application" class="btn btn-primary">
                </div>

            </div>
        </div>
    <div class="table-container">
        <div class="card mb-3 p-3 shadow-sm">
            <div class="col align-items-center">
                <div>
                <h3>Job Description</h3>
                <div class="line divider"> </div>
                <label><?php echo htmlspecialchars($jobTitle); ?></label><br>
                <label><?php echo htmlspecialchars($job['job_description']); ?></label><br>
                
                <h3>Qualifications / Requirements</h3>
                <div class="line divider"> </div>
                <p><?php echo htmlspecialchars($job['requirment']); ?></p>

                <h3>Work Location</h3>
                <div class="line divider"> </div>
                <p><?php echo htmlspecialchars($job['work_location']); ?></p>

                <h3>Remarks</h3>
                <div class="line divider"> </div>
                <label><?php echo htmlspecialchars($job['remarks']); ?></label>
                <input type="submit" value="Submit Application" class="btn btn-primary">
                </div>
            </div>
        </div>
    </div>
        
    </form>
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
   <script src="../../javascript/script.js"></script> 
</body>
</html>