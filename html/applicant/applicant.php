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
<style>
    #jobListContainer {
    display: none; /* Initially hide the job list */
}

</style>
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
                <tr><td><a href="about.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="contact.php" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>
 
<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="../../index(applicant).php" >Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Job List</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>
    
<div class="table-containers">
<div class="table-container">
<form method="GET" action="" class="my-4">

<div class="d-flex justify-content-between align-items-center">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="toggleButton" href="#" role="tab">Job List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="toggleButton4" href="#" role="tab">Recommended Job</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="toggleButton2" href="#" role="tab">Saved Job</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="toggleButton3" href="#" role="tab">Applied Job</a>
        </li>
    </ul>

    <!-- Right side: Search input and button -->
    <div class="d-flex position-relative">
        <!-- Search Input -->
        <input type="text" id="search-input" name="search" class="form-control ps-5" placeholder="Search for a job..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

        <!-- Search Icon -->
        <span class="position-absolute search-icon" style="left: 10px; top: 50%; transform: translateY(-50%);">
            <i class="fa fa-search"></i> <!-- FontAwesome search icon -->
        </span>

        <!-- Search Button -->
        <button type="submit" class="btn btn-primary ms-2">Search</button>

        <!-- Clear Button -->
        <button type="button" class="btn btn-secondary ms-2" id="clear-button" onclick="clearSearch()">Clear</button>
    </div>
</div>

</form>



<div class="row align-items-start"  style="margin-top:-1.6rem;">
    <div id="jobListContainer" class="job-list">
        <?php 
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            include '../../php/applicant/job_list.php'; 
        ?>
    </div>

    <div id="recomendedJobListContainer" class="job-list">
        <?php 
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            include 'recomended_list.php'; 
        ?>
    </div>

    <div id="savedJobListContainer" class="job-list">
        <?php 
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            include 'save_job.php'; 
        ?>
    </div>

    <div id="appliedJobListContainer" class="job-list">
        <?php 
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            include 'list_applied_jobs.php'; 
        ?>
    </div>
</div>




</div>

<script>
    // JavaScript function to clear the search input and reset the page
    function clearSearch() {
        // Redirect to the same page without any search query (clear the search)
        window.location.href = window.location.pathname;
    }
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

<script>
    // Hide all job lists initially
    document.querySelectorAll('.job-list').forEach(function (list) {
        list.style.display = 'none';
    });

    // Show the job list by default
    document.getElementById('jobListContainer').style.display = 'block';

    // Button event listeners for showing the respective job list
    document.getElementById('toggleButton').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default anchor click behavior
        toggleJobList('jobListContainer', this);
    });

    document.getElementById('toggleButton2').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default anchor click behavior
        toggleJobList('savedJobListContainer', this);
    });

    document.getElementById('toggleButton3').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default anchor click behavior
        toggleJobList('appliedJobListContainer', this);
    });

    document.getElementById('toggleButton4').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default anchor click behavior
        toggleJobList('recomendedJobListContainer', this);
    });

    // Function to toggle job lists
    function toggleJobList(containerId, button) {
        // Hide all job lists
        document.querySelectorAll('.job-list').forEach(function (list) {
            list.style.display = 'none'; 
        });
        // Show selected job list
        document.getElementById(containerId).style.display = 'block'; 

        // Update tab styles
        document.querySelectorAll('.nav-link').forEach(function (navLink) {
            navLink.classList.remove('active'); // Remove active class from all links
        });
        button.classList.add('active'); // Add active class to the clicked link
    }
</script>



</body>
</html>
