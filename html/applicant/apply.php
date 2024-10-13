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
        <h1>Apply for <?php echo htmlspecialchars($jobTitle); ?></h1>
        <form action="../../php/applicant/submit_application.php" method="post">
            <input type="hidden" name="job" value="<?php echo htmlspecialchars($jobTitle); ?>">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
            <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job['j_id']); ?>">
            <h4><?php echo htmlspecialchars($job['job_description']); ?> </h4><br>
            <h4><?php echo htmlspecialchars($job['requirment']); ?> </h4> <br>
            <h4><?php echo htmlspecialchars($job['work_location']); ?> </h4> <br>
            <h4><?php echo htmlspecialchars($job['remarks']); ?> </h4> <br>
            <h4><?php echo htmlspecialchars($job['job_type']); ?> </h4> <br>
            <h4><?php echo htmlspecialchars($job['date_posted']); ?> </h4> <br>
            <input type="submit" value="Submit Application">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
   <script src="../../javascript/script.js"></script> 
</body>
</html>