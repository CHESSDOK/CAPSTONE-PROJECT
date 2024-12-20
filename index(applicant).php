<!DOCTYPE html>
<html lang="en">
<?php
include 'php/conn_db.php';

function checkSession() {
  session_start(); // Start the session

  // Check if the session variable 'id' is set
  if (!isset($_SESSION['id'])) {
      // Redirect to login page if session not found
      header("Location: html/login.html");
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

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="css/modal-form.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/notif.css">
  <style>
    .widget-container {
    position: fixed; /* Keeps the widget in the same position as you scroll */
    right: 0; /* Positions the container on the right side */
    top: 80px; /* Adjust the vertical positioning */
    width: 25vw; /* Set the desired width */
    padding: 20px; /* Padding inside the widget */
    background-color: #f8f9fa; /* Background color */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Adds a shadow for better visibility */
    z-index: 1000; /* Ensures the widget is on top */
    border-radius: 10px;
    border: 1px solid #ddd;
    }

  </style>
</head>
<body>
<nav>
    <div class="logo">
        <img src="img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
        <a class='openEmployersBtn' href='#'><img id="#" src="img/notif.png" alt="Profile Picture" class="rounded-circle"></a>
        </div>
        <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
        <?php if (!empty($row['photo'])): ?>
            <img id="preview" src="php/applicant/images/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
        <?php else: ?>
            <img src="img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
        <?php endif; ?>
        </div>
    </div>

    <!-- Burger icon -->
    <div class="burger" id="burgerToggle">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table class="menu">
                <tr><td><a href="#" class="active nav-link">Home</a></td></tr>
                <tr><td><a href="html/applicant/applicant.php" class="nav-link">Applicant</a></td></tr>
                <tr><td><a href="html/applicant/training_list.php" class="nav-link">Training</a></td></tr>
                <tr><td><a href="html/applicant/About.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="html/applicant/Contact.php" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>
    <table>
    <tr>
      <td class="container_whole" colspan="2">
        <label class="lbl_1">PESO</label>
        <label class="lbl_2">Los Baños</label>
      </td>
    </tr>
    <tr>
      <td class="container_whole" colspan="2">
        <label class="lbl_3">Public Employment Service Office</label>
      </td>
    </tr>
    <tr>
      <td class="container_whole" colspan="2">
        <label class="lbl_4">JOB PORTAL</label>
      </td>
    </tr>
    <tr>
      <td class="container_whole" colspan="2">
        <label class="lbl_5">YOUR</label>
        <label class="lbl_6">NEW CAREER</label>
        <label class="lbl_7">STARTS HERE!</label>
      </td>
    </tr>
    <tr>
      <td class="container_whole">
      <button class="btn btn-primary lbl_8" onclick="window.location.href='html/applicant/applicant.php';">Find Job</button>

      </td>
    </tr>
    <tr>
      <td class="container_whole" colspan="2">
        <textarea readonly>
            Available in one roof the various employment promotion, manpower programs, 
            and services of the DOLE and other government agencies to enable all types 
            of clientele to know more about them and seek specific assistance they require.
        </textarea>
      </td>
    </tr>
    </table>

    <div id="widgetContainer" class="widget-container">
      <h4>Recommended Job</h4>
      <div id="recommendationResults">
  </div>
  
<div id="employerModal" class="modal modal-container">
    <div class="modal-content">
        <span class="btn-close closBtn">&times;</span>
        <div id="employersModuleContent">
            <!-- Module content will be dynamically loaded here -->
        </div>
    </div>
</div>

    <script>  
        const employerModal = document.getElementById('employerModal');
        const closeModuleBtn = document.querySelector('.closBtn');
        // Open profile modal and load data via AJAX
        $(document).on('click', '.openEmployersBtn', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'html/applicant/sched_list.php',
                method: 'GET',
                success: function(response) {
                    $('#employersModuleContent').html(response);
                    employerModal.style.display = 'flex';
                }
            });
        });

        // Close profile modal when 'x' is clicked
        closeModuleBtn.addEventListener('click', function() {
            employerModal.style.display = 'none';
        });

        // Close profile modal when clicking outside the modal content
        window.addEventListener('click', function(event) {
            if (event.target === employerModal) {
                employerModal.style.display = 'none';
            }
        });
    </script>
    
<!-- <script>
    // Automatically load job recommendations on page load
    $(document).ready(function() {
        $.ajax({
            url: 'php/job_recommendation.php', // PHP script that runs the Python script
            method: 'GET',
            success: function(response) {
                try {
                    const recommendations = JSON.parse(response);

                    // If the Python script returns an error, show the message
                    if (recommendations.error) {
                        document.getElementById('recommendationResults').innerHTML = `<p>${recommendations.error}</p>`;
                        return;
                    }

                    // Display job recommendations
                    let resultsHTML = '<h3>Job Recommendations:</h3>';
                    recommendations.forEach(function(job) {
                        resultsHTML += `
                            <p><strong>Job Title:</strong> ${job.job_title}</p>
                            <p><strong>Salary:</strong> ${job.salary}</p>
                            <p><strong>Preferred Occupation:</strong> ${job.preferred_occupation}</p>
                            <hr>
                        `;
                    });
                    document.getElementById('recommendationResults').innerHTML = resultsHTML;
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    alert("Error processing recommendations. Please check the console for details.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error loading recommendations:", error);
                alert("Error loading recommendations. Please check the console for details.");
            }
        });
    });
</script> -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->
<script>
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
</script>
</body>
</html>
