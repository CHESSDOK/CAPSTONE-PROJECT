<?php
include '../../php/conn_db.php';
function checkSession() {
  session_start(); // Start the session

  // Check if the session variable 'id' is set
  if (!isset($_SESSION['id'])) {
      // Redirect to login page if session not found
      header("Location: html/login_employer.html");
      exit();
  } else {
      // If session exists, store the session data in a variable
      return $_SESSION['id'];
  }
}

$userId = checkSession(); 
$sql = "SELECT * FROM employer_profile WHERE user_id = ?";
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

$ap_sql = "SELECT * FROM applicant_profile WHERE specialization IS NOT NULL";
$ap_result = $conn->query($ap_sql);
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
  <link rel="stylesheet" href="../../css/employer.css">
</head>
<style>
body::before{
    background-image:none;
    background-color:#EBEEF1;
    }
</style>
<body>
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
        <h1 class="h1">Create Form</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
        <?php if (!empty($row['photo'])): ?>
        <img id="preview" src="../../php/employer/uploads/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
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
                <tr><td><a href="../../html/employer/employer_home.php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="#" class="active nav-link">Post Job</a></td></tr>
                <tr><td><a href="../../html/employer/job_list.php" class="nav-link">Job List</a></td></tr>
                <tr><td><a href="../../html/about.html" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="../../html/contact.html" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="../../html/employer/employer_home.php" >Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Post Job</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

<div class="jc-container">
<form action="../../php/employer/post_job_process.php" method="post">
  <table>
    <tr>
      <td>
        <div class="mb-3">
          <label for="job_title" class="form-label">Job Title:</label>
          <input type="text" class="form-control" name="job_title" id="job_title" required>
        </div>
      </td>
      <td>
        <div class="mb-3">
          <label for="vacant" class="form-label">Job Vacant:</label>
          <input type="number" class="form-control" name="vacant" id="vacant" required>
        </div>
      </td>
      <td>
        <div class="mb-3">
          <label for="spe" class="form-label">Expert Requirement</label>
          <select id="spe" name="spe" class="form-select">
            <?php
              if ($ap_result->num_rows > 0) {
                while($ap_row = $ap_result->fetch_assoc()) {
                  echo "<option value='".$ap_row['specialization']."'>".$ap_row['specialization']."</option>";
                }
              }
              $conn->close();   
            ?>
          </select>
        </div>
      </td>
    </tr>
    <tr>
    <td colspan="3">
        <div class="mb-3">
          <label for="job_description" class="form-label">Job Description:</label>
          <textarea name="job_description" id="job_description" class="form-control" required></textarea>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <div class="mb-3">
          <label for="job_type" class="form-label">Job type:</label>
          <select class="form-select" id="jobtype" name="jobtype" required>
            <option value="Part time">Part time</option>
            <option value="Prelance">Prelance</option>
            <option value="Fulltime">Fulltime</option>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <div class="mb-3">
          <label for="req" class="form-label">Qualification/Requirements</label>
          <textarea name="req" id="req" class="form-control"></textarea>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <div class="mb-3">
          <label for="loc" class="form-label">Work Location</label>
          <input type="text" class="form-control" name="loc" id="loc">
        </div>
      </td>
      <td>
        <div class="mb-3">
          <label for="rem" class="form-label">Remarks</label>
          <input type="text" class="form-control" name="rem" id="rem">
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <button type="submit" class="btn btn-primary">Post Job</button>
      </td>
    </tr>
  </table>
</form>
</div>
    <!-- Body -->

   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <script src="../../javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->
</body>
</html>
