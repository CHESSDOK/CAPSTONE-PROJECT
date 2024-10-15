<?php
// Start the session and check if the user is logged in
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

$userId = checkSession(); // Call the function and store the returned user ID

// Assuming $conn is your valid database connection
include '../../php/conn_db.php'; // Include your database connection script

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" >  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../../css/modal-form.css">
  <link rel="stylesheet" href="../../css/nav_float.css">
  <link rel="stylesheet" href="../../css/employer.css">
  </head>
<body>
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>
    <header>
        <h1 class="h1">Profile</h1>
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
                <tr><td><a href="../../html/employer/job_creat.php" class="nav-link">Post Job</a></td></tr>
                <tr><td><a href="../../html/employer/job_list.php" class="nav-link">Job List</a></td></tr>
                <tr><td><a href="../../html/about.html" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="../../html/contact.html" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
  <div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../../html/employer/employer_home.php" >Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
  </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

<div class="ep-container">
<form action="../../php/employer/employer_prof_process.php" method="post" enctype="multipart/form-data">
<table> 
<h1 class="h1">Company Info</h1>
 <tr>
   <td colspan="2">
    <label for="profile_image" class="form-label">Select Profile Image:</label>
    <input type="file"  class="form-control" name="profile_image" id="profile_image" accept="image/*" required>   
   </td>
 </tr>
 <tr>
   <td>
    <label for="company_name" class="form-label">Company Name:</label>
    <input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo htmlspecialchars($row['company_name'] ?? ''); ?>">
   </td>
   <td>
    <label for="president" class="form-label">Company President:</label>
    <input type="text" class="form-control" name="president" id="president" value="<?php echo htmlspecialchars($row['president'] ?? ''); ?>">
   </td>
 </tr>
 <tr>
   <td colspan="2">
    <label for="company_add" class="form-label">Company Address:</label>
    <input type="text" class="form-control" name="company_add" id="company_add" value="<?php echo htmlspecialchars($row['company_address'] ?? ''); ?>">
   </td>
 </tr>
 <tr>
   <td>
    <label for="HR" class="form-label">HR Manager:</label>
    <input type="text" class="form-control" name="HR" id="HR" value="<?php echo htmlspecialchars($row['HR'] ?? ''); ?>">
   </td>
   <td>
    <label for="HR_mail" class="form-label">HR Official Email:</label>
    <input type="text" class="form-control" name="HR_mail" id="HR_mail" value="<?php echo htmlspecialchars($row['HR_mail'] ?? ''); ?>">
   </td>
 </tr>
 <tr>
   
   <td>
    <label for="tel_num" class="form-label">Company Telephone Number:</label>
    <input type="tel" class="form-control" name="tel_num" id="tel_num" value="<?php echo htmlspecialchars($row['tel_num'] ?? ''); ?>">
   </td>
   <td>
    <label for="company_mail" class="form-label">Company Email:</label>
    <input type="text" class="form-control" name="company_mail" id="company_mail" value="<?php echo htmlspecialchars($row['company_mail'] ?? ''); ?>">
   </td>
 </tr>
 <tr>
   <td>
    <input class="btn btn-primary" type="submit" value="Update">
   </td>
 </tr>
</table>
</form>
</div>

<div class="ep-container">
<form action="../../php/employer/documents_process.php" method="post" enctype="multipart/form-data">
<table>
<h1 class="h1">Company Documents</h1>
 <tr>
   <td>
    <label for="document_name" class="form-label">Document type:</label>
        <select class="form-select" id="document_name" name="document_name" required>
          <option value="SEC Certificate">SEC Certificate</option>
          <option value="BIR Certificate of Registration (Form 2303)">BIR Certificate of Registration (Form 2303)</option>
          <option value="POEA license">POEA license</option>
          <option value="Private  Employment Agency (PEA) License">Private  Employment Agency (PEA) License</option>
          <option value="D.O. 174 Series of 2017 (Contractor/ Sub - Contractor) Certicate">D.O. 174 Series of 2017 (Contractor/ Sub - Contractor) Certicate</option>
        </select>
   </td>
   <td>
    <label for="document" class="form-label">Upload Document:</label>
    <input type="file" class="form-control" name="document" id="document" >
   </td>
 </tr>
 <tr>
  <td>
  
  </td>
   <td>
    <input class="btn btn-primary" type="submit" value="Upload">
   </td>
   <td>
   
   </td>
 </tr>
</table>
</form>
</div>

<button id='openFormBtn' class="btn btn-primary" >File list</button>
<button id='openProfileBtn' class="btn btn-primary openProfileBtn" >Employer profile</button>
<!-- modal form -->
<div id="formModal" class="modal">
                <div class="modal-content">
                <span class="closeBtn">&times;</span>
                <h2>file list</h2>
                <table>
                <tr>
                  <th scope="col">type</th>
                  <th scope="col">status</th>
                  <th scope="col">comment</th>
                </tr>
                <?php
                  $docu_sql = "SELECT * FROM employer_documents WHERE user_id = $userId";
                  $docu_result = $conn->query($docu_sql);
                  if ($docu_result->num_rows > 0) {
                      while ($row = $docu_result->fetch_assoc()) {
                          echo '        
                                  <tr>
                                  <td>' . $row['document_name'] . '</td>
                                  <td>';
                          if ($row['is_verified'] == 1) {
                              echo 'Verified';
                          } else {
                              echo 'Not Verified ';
                          }                          
                          echo '</td>
                                <td> '.$row['comment'].' </td>
                                </tr>
                                </table>
                                ';
                      }
                  } else {
                      echo "<tr><td colspan='4'>No employers found</td></tr>";
                  }
                  $conn->close();
                  ?>
                </form>
                </div>
            </div>


<!--Profile modal form -->

<div id="profileModal" class="modal">
    <div class="modal-content">
        <span class="seccloseBtn">&times;</span>
        <div id="applicantProfileContent"></div> <!-- AJAX will inject content here -->
    </div>
</div>

<script>

  // Get modal and button elements
const modal = document.getElementById('formModal');
const openBtn = document.getElementById('openFormBtn');
const closeBtn = document.querySelector('.closeBtn');

// Open modal and set applicant_id in hidden field
openBtn.addEventListener('click', function() {
  // Open the modal
  modal.style.display = 'flex';
});

// Close modal when 'x' is clicked
closeBtn.addEventListener('click', function() {
  modal.style.display = 'none';
});
// Close modal when clicked outside of the modal content
window.addEventListener('click', function(event) {
  if (event.target === modal) {
    modal.style.display = 'none';
  }
});
    const profileModal = document.getElementById('profileModal');
    const closepBtn = document.querySelector('.seccloseBtn');

    // Open profile modal and load data via AJAX
    $(document).on('click', '.openProfileBtn', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'profile.php',
            method: 'GET',
            success: function(response) {
                $('#applicantProfileContent').html(response);
                profileModal.style.display = 'flex';
            }
        });
    });
        // Close profile modal when 'x' is clicked
    closepBtn.addEventListener('click', function() {
        profileModal.style.display = 'none';
    });

    // Close profile modal when clicking outside the modal content
    window.addEventListener('click', function(event) {
        if (event.target === profileModal) {
            profileModal.style.display = 'none';
        }
    });
</script>

<script src="../../javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->

</body>
</html>