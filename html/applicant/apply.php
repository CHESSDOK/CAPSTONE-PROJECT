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

$sql = "SELECT * FROM applicant_profile WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $conn->error); 
}

$row = $result->fetch_assoc();
if (!$row) {
    die("User not found.");
}

// Check if job is set
if (isset($_GET['job'])) {
    $jobTitle = urldecode($_GET['job']);
} else {
    header("Location: index.html");
    exit();
}

include '../../php/conn_db.php';


$jobid = $_GET['jobid'];

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
$sql = "SELECT jp.*, em.*, jp.company_name AS admincompany
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
        <h1 class="h1">Company Details</h1>
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
                <tr><td><a href="about.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="contact.php" class="nav-link">Contact Us</a></td></tr>
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
        <?php if (!empty($job["photo"])): ?>
            <img src="../../php/employer/uploads/<?php echo htmlspecialchars($job["photo"]); ?>" alt="Logo" class="img-fluid rounded-circle mb-3" style="max-width: 100px; height: auto;">
        <?php else: ?>
            <img src="../../img/user-placeholder.png" alt="Logo" class="img-fluid rounded-circle mb-3" style="max-width: 100px; height: auto;">
        <?php endif; ?>
    </div>

    <!-- Job Title, Company Name, and Work Location (center part) -->
    <div class="col-md-4">
        <div class="d-flex flex-column">
            <!-- Job Title with Icon -->
            <label class="fw-bold mb-0" style="font-size: 1.30rem; color: #007bff;">
                <i class="fas fa-briefcase" style="color: #007bff;"></i>
                <?php echo htmlspecialchars($jobTitle); ?>
            </label>

            <!-- Company Name with Icon -->
            <p class="mb-0" style="font-size: 1rem; color: #007bff;">
                <i class="fas fa-building" style="color: #007bff;"></i>
                <?php echo isset($job['company_name']) ? htmlspecialchars($job['company_name']) : $job['admincompany']; ?>
            </p>

            <!-- Work Location with Icon -->
            <p class="mb-0" style="font-size: 1rem; color: #6c757d;">
                <i class="fas fa-map-marker-alt" style="color: #007bff;"></i>
                <?php echo htmlspecialchars($job['work_location']); ?>
            </p>
        </div>
    </div>

    <!-- Requirements and Job Type (Row layout, aligned with Work Location) -->
    <div class="col-md-4">
        <div class="d-flex flex-row mt-5">
            <!-- Requirement -->
            <div class="me-5">
                <p class="mb-0" style="font-size: 1rem; color: #6c757d;">
                    <i class="fas fa-graduation-cap" style="color: #007bff;"></i>
                    <?php echo htmlspecialchars($job['education']); ?>
                </p>
            </div>

            <!-- Job Type -->
            <div>
                <p class="mb-0" style="font-size: 1rem; color: #6c757d;">
                    <i class="fas fa-laptop-code" style="color: #007bff;"></i>
                    <?php echo htmlspecialchars($job['job_type']); ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <!-- Date posted -->
        <div class="mb-0">
            <p class="date-posted" style="color: #007bff;">₱
                <?php echo htmlspecialchars($job['salary']); ?>
            </p>
        </div>

        <div class="row align-items-center">
            <!-- Apply button -->
            <div class="col-auto">
                <input type="submit" value="Apply Now" class="btn btn-primary">
            </div>
            
            <!-- Save Job link -->
            <div class="col-auto">
                <a href="../../php/applicant/save.php?job=<?php echo htmlspecialchars($jobid);?>&userid=<?php echo htmlspecialchars($userId);?>" class="btn btn-link">Save Job</a>
            </div>
        </div>

        <input type="hidden" name="job" value="<?php echo htmlspecialchars($jobTitle); ?>">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
        <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job['j_id']); ?>">
    </div>
</div>

</div>
            <div class="table-container">
    <div class="card mb-3 p-3 shadow-sm">
        <div class="col align-items-center">
            
            <!-- Job Description Section -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                <h4 style="color: #007bff; letter-spacing: 2px;">Job Description</h4>
                    <p class="date-posted" style="font-size: 12px; color: #888;">
                        Posted on <?php echo date('d F Y', strtotime($job['date_posted'])); ?>
                    </p>
                </div>

                <div class="border-bottom my-2" style="border: 2px solid rgba(136, 136, 136, 0.4);"></div>

                <div class="row mt-2 mb-5" style="color: #666;">
                    <!-- Job Title -->
                    <div class="col-md-12 mt-2 mb-3">
                        <label class="fw-bold"><?php echo htmlspecialchars($jobTitle); ?></label>
                    </div>

                    <!-- Job Description -->
                    <div class="col-md-12">
                        <label><?php echo htmlspecialchars($job['job_description']); ?></label>
                    </div>
                </div>
            </div>

            <!-- Qualifications / Requirements Section -->
            <div class="mb-3">
                <h4 style="color: #007bff; letter-spacing: 2px;">Qualifications / Requirements</h4>
                <div class="border-bottom my-2" style="border: 2px solid rgba(136, 136, 136, 0.4);"></div>
                <textarea class="txt-area" readonly><?php echo htmlspecialchars($job['requirment']); ?></textarea>

            </div>

            <!-- Work Location Section -->
            <div class="mb-3">
                <h4 style="color: #007bff; letter-spacing: 2px;">Work Location</h4>
                <div class="border-bottom my-2" style="border: 2px solid rgba(136, 136, 136, 0.4);"></div>
                <p><?php echo htmlspecialchars($job['work_location']); ?></p>
            </div>

            <!-- Remarks Section -->
            <div class="mb-3">
                <h4 style="color: #007bff; letter-spacing: 2px;">Remarks</h4>
                <div class="border-bottom my-2" style="border: 2px solid rgba(136, 136, 136, 0.4);"></div>
                <label><?php echo htmlspecialchars($job['remarks']); ?></label>
            </div>

            <!-- Submit Button -->
            <div class="mt-4">
                <input type="submit" value="Submit Application" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>

        
    </form>
</div>
</div>

<script>
  const textarea = document.querySelector('.txt-area');
  textarea.style.height = 'auto'; // Reset the height
  textarea.style.height = textarea.scrollHeight + 'px'; // Set the height to fit the content
</script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
    // Get elements
const burgerToggle = document.getElementById('burgerToggle');
const offcanvasMenu = new bootstrap.Offcanvas(document.getElementById('offcanvasMenu'));

// Toggle burger class and offcanvas menu
burgerToggle.addEventListener('click', function() {
    // Toggle burger active class for animation
    burgerToggle.classList.toggle('active');

    // Open or close the offcanvas menu
    if (offcanvasMenu._isShown) {
        offcanvasMenu.hide();
    } else {
        offcanvasMenu.show();
    }
});

$(document).ready(function(){
    // Initialize popover with multiple links in the content
    $('.profile-icon').popover({
        trigger: 'click', 
        html: true, // Allow HTML content
        animation: true, // Enable animation
        content: function() {
            return `
                <a class="link" href="a_profile.php"  id="emprof">Profile</a><br>
                <a class="link" href="logout.php">Logout</a>
            `;
        }
    });
// Close popover when clicking outside
$(document).on('click', function (e) {
    const target = $(e.target);
    if (!target.closest('.profile-icon').length) {
        $('.profile-icon').popover('hide');
    }
});
});
</script>
</body>
</html>