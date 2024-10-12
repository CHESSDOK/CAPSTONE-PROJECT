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

//Fetch data from applicant_profile table
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
   die("User not found in applicant_profile.");
}

// Fetch data from register table using new approach
$sql_new = "SELECT * FROM register WHERE id = ?";
$stmt_new = $conn->prepare($sql_new);
$stmt_new->bind_param("i", $userId);
$stmt_new->execute();
$result_new = $stmt_new->get_result();

if ($result_new->num_rows > 0) {
    $row_new = $result_new->fetch_assoc(); // Fetch the data into a separate variable
} else {
    $row_new = array(); // If no data found, initialize as an empty array
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Submission</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/a_profile.css">
  <link rel="stylesheet" href="../../css/nav_float.css">

</head>

<body data-bs-spy="scroll" data-bs-target="#scrollspy-menu" data-bs-offset="175">

<!-- Navigation -->
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
      <h1 class="ofw-h1">Profile</h1>
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

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table class="menu">
                <tr><td><a href="../../index(applicant).php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="applicant.php" class="nav-link">Applicant</a></td></tr>
                <tr><td><a href="training_list.php" class="nav-link">Training</a></td></tr>
                <tr><td><a href="ofw_form.php" class="nav-link">OFW</a></td></tr>
                <tr><td><a href="../../html/about.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="../../html/contact.php" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>


<!-- Form Content -->
<div class="profile-container">
<div class="form-content">
  <form action="../../php/applicant/approf.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value = "<?php echo $row['user_id'];?>">
    <!-- Personal Information Section -->
    <div class="container mt-4">
      <h4 class="mb-3">Personal Information</h4>
      
      <!-- Profile Image -->
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="profile_image">Select Profile Image:</label>
          <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*" required onchange="previewImage(event)">
        </div>
        <div class="col-md-6 mb-3 text-center">
          <img id="profile_image_preview" src="" alt="Profile Image" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
        </div>
      </div>

      <!-- Name Information -->
      <div class="row">
        <div class="col-md-3 mb-3">
          <label for="lastName" class="info">Surname</label>
          <input type="text" id="lastName" name="lastName" class="form-control" required value="<?php echo isset($row['last_name']) ? htmlspecialchars($row['last_name']) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label for="firstName" class="info">First Name</label>
          <input type="text" id="firstName" name="firstName" class="form-control" required value="<?php echo isset($row['first_name']) ? htmlspecialchars($row['first_name']) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label for="middleName" class="info">Middle Name</label>
          <input type="text" id="middleName" name="middleName" class="form-control" value="<?php echo isset($row['middle_name']) ? htmlspecialchars($row['middle_name']) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label for="Prefix" class="info">Suffix</label>
          <select class="form-select" id="Prefix" name="Prefix">
            <option value="">Optional</option>
            <?php
              $prefixes = ['none', 'Sr.', 'Jr.', 'II', 'III', 'IV', 'V', 'VI', 'VII'];
              foreach ($prefixes as $prefix) {
                echo "<option value='$prefix'" . (isset($row['prefix']) && $row['prefix'] == $prefix ? ' selected' : '') . ">$prefix</option>";
              }
            ?>
          </select>
        </div>
      </div>

      <!-- Birth Details and Religion -->
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="dob" class="info">Date of Birth</label>
          <input type="date" id="dob" name="dob" class="form-control" required value="<?php echo isset($row['dob']) ? htmlspecialchars($row['dob']) : ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label for="pob" class="info">Place of Birth</label>
          <input type="text" id="pob" name="pob" class="form-control" value="<?php echo isset($row['pob']) ? htmlspecialchars($row['pob']) : ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label for="religion" class="info">Religion</label>
          <input type="text" id="religion" name="religion" class="form-control" value="<?php echo isset($row['religion']) ? htmlspecialchars($row['religion']) : ''; ?>">
        </div>
      </div>

      <!-- Address Information -->
      <div class="row">
        <div class="col mb-3">
          <label for="houseadd" class="info">Present Address</label>
          <input type="text" id="houseadd" name="houseadd" class="form-control" required placeholder="House no. / Street / Barangay / City / Province" value="<?php echo isset($row['house_address']) ? htmlspecialchars($row['house_address']) : ''; ?>">
        </div>
      </div>

      <!-- Civil Status, Sex, Height -->
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="civilStatus" class="info">Civil Status</label>
          <select class="form-select" id="civilStatus" name="civilStatus" required>
            <option value="Single" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Single') ? 'selected' : ''; ?>>Single</option>
            <option value="Married" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
            <option value="Widowed" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
            <option value="Separated" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Separated') ? 'selected' : ''; ?>>Separated</option>
            <option value="Live-in" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Live-in') ? 'selected' : ''; ?>>Live-in</option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label for="sex" class="info">Sex</label>
          <select class="form-select" id="sex" name="sex" required>
            <option value="Male" <?php echo (isset($row['sex']) && $row['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo (isset($row['sex']) && $row['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label for="height" class="info">Height</label>
          <input type="text" id="height" name="height" class="form-control" value="<?php echo isset($row['height']) ? htmlspecialchars($row['height']) : ''; ?>">
        </div>
      </div>

      <!-- Identification Numbers -->
      <div class="row">
        <div class="col-md-3 mb-3">
          <label for="tin" class="info">TIN</label>
          <input type="text" id="tin" name="tin" class="form-control" value="<?php echo isset($row['tin']) ? htmlspecialchars($row['tin']) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label for="sssNo" class="info">GSIS/SSS No.</label>
          <input type="text" id="sssNo" name="sssNo" class="form-control" value="<?php echo isset($row['sss_no']) ? htmlspecialchars($row['sss_no']) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label for="pagibigNo" class="info">Pag-IBIG No.</label>
          <input type="text" id="pagibigNo" name="pagibigNo" class="form-control" value="<?php echo isset($row['pagibig_no']) ? htmlspecialchars($row['pagibig_no']) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label for="philhealthNo" class="info">PhilHealth No.</label>
          <input type="text" id="philhealthNo" name="philhealthNo" class="form-control" value="<?php echo isset($row['philhealth_no']) ? htmlspecialchars($row['philhealth_no']) : ''; ?>">
        </div>
      </div>

      <!-- Contact Information -->
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="email" class="info">Email</label>
          <input type="email" id="email" name="email" class="form-control" required value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label for="contactNo" class="info">Contact No.</label>
          <input type="tel" id="contactNo" name="contactNo" class="form-control" required value="<?php echo isset($row['contact_no']) ? htmlspecialchars($row['contact_no']) : ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label for="landline" class="info">Landline No.</label>
          <input type="tel" id="landline" name="landline" class="form-control" value="<?php echo isset($row['landline']) ? htmlspecialchars($row['landline']) : ''; ?>">
        </div>
      </div>

      <!-- Disability and 4Ps -->
      <div class="row">
        <div class="col-md-3 mb-3">
          <label for="pwd" class="info">Disability</label>
          <select class="form-select" id="pwd" name="pwd" required>
            <option value="">Select</option>
            <option value="None" <?php echo (isset($row['pwd']) && $row['pwd'] == 'None') ? 'selected' : ''; ?>>None</option>
            <option value="Visual" <?php echo (isset($row['pwd']) && $row['pwd'] == 'Visual') ? 'selected' : ''; ?>>Visual</option>
            <option value="Hearing" <?php echo (isset($row['pwd']) && $row['pwd'] == 'Hearing') ? 'selected' : ''; ?>>Hearing</option>
            <option value="Speech" <?php echo (isset($row['pwd']) && $row['pwd'] == 'Speech') ? 'selected' : ''; ?>>Speech</option>
            <option value="Physical" <?php echo (isset($row['pwd']) && $row['pwd'] == 'Physical') ? 'selected' : ''; ?>>Physical</option>
            <option value="Others" <?php echo (isset($row['pwd']) && $row['pwd'] == 'Others') ? 'selected' : ''; ?>>Others</option>
          </select>
        </div>
        <div class="col-md-3 mb-3">
          <div id="disability-input" class="additional-input">
            <label for="disability-other" class="info">Please specify:</label>
            <input type="text" id="disability-other" name="pwd2" class="form-control" value="<?php echo isset($row['disability_other']) ? htmlspecialchars($row['disability_other']) : ''; ?>">
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <label for="four-ps-beneficiary" class="info">Are you a 4Ps beneficiary?</label>
          <select class="form-select" id="four-ps-beneficiary" name="four-ps-beneficiary" required>
            <option value="">Select</option>
            <option value="Yes" <?php echo (isset($row['four-ps-beneficiary']) && $row['four-ps-beneficiary'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
            <option value="No" <?php echo (isset($row['four-ps-beneficiary']) && $row['four-ps-beneficiary'] == 'No') ? 'selected' : ''; ?>>No</option>
          </select>
        </div>
        <div class="col-md-3 mb-3">
          <div id="household-id-input" class="additional-input">
            <label for="household-id" class="info">If yes, Household ID No.</label>
            <input type="text" id="household-id" class="form-control" placeholder="Household ID">
          </div>
        </div>
      </div>

      <!-- Employment Information -->
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="employment-status" class="info">Employment Status:</label>
          <select class="form-select" id="employment-status" name="employent_status" required>
            <option value="">Select</option>
            <option value="employed" <?php echo (isset($row['employment_status']) && $row['employment_status'] == 'employed') ? 'selected' : ''; ?>>Employed</option>
            <option value="unemployed" <?php echo (isset($row['employment_status']) && $row['employment_status'] == 'unemployed') ? 'selected' : ''; ?>>Unemployed</option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <div id="sub-dropdown" class="sub-dropdown">
            <label for="employment-type" class="info">Employment Type:</label>
            <select class="form-select" id="employment-type" required>
              <option value="">Select</option>
              <option value="wage">Wage Employed</option>
              <option value="self">Self Employed</option>
              <option value="fresh_grad" class="unemployed-option">New Entrant/Fresh Graduate</option>
              <option value="f_contract" class="unemployed-option">Finished Contract</option>
              <option value="resigned" class="unemployed-option">Resigned</option>
              <option value="retired" class="unemployed-option">Retired</option>
              <option value="local" class="unemployed-option">Terminated/Laidoff(local)</option>
              <option value="abroad" class="unemployed-option">Terminated/Laidoff(abroad)</option>
              <option value="others" class="unemployed-option">Others, specify</option>
            </select>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div id="additional-input" class="info">
            <label for="other-reason">Please specify country, others:</label>
            <input type="text" id="other-reason" class="form-control" placeholder="Enter details here">
          </div>
        </div>
      </div>

      <!-- Job Search Status -->
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="actively-looking" class="info">Are you actively looking for work?</label>
          <select class="form-select" id="actively-looking" name="actively-looking" required>
            <option value="">Select</option>
            <option value="Yes" <?php echo (isset($row['actively-looking']) && $row['actively-looking'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
            <option value="No" <?php echo (isset($row['actively-looking']) && $row['actively-looking'] == 'No') ? 'selected' : ''; ?>>No</option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <div id="actively-looking-input" class="additional-input">
            <label for="actively-looking-details" class="info">Please specify:</label>
            <input type="text" id="actively-looking-details" class="form-control" placeholder="How long have you been looking for work?">
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="willing-to-work" class="info">Willing to work immediately?</label>
          <select class="form-select" id="willing-to-work" name="willing-to-work" required>
            <option value="">Select</option>
            <option value="Yes" <?php echo (isset($row['willing-to-work']) && $row['willing-to-work'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
            <option value="No" <?php echo (isset($row['willing-to-work']) && $row['willing-to-work'] == 'No') ? 'selected' : ''; ?>>No</option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <div id="willing-to-work-input" class="additional-input">
            <label for="willing-to-work-details" class="info">Please specify:</label>
            <input type="text" id="willing-to-work-details" class="form-control" placeholder="If no, when?">
          </div>
        </div>
      </div>

      <!-- Job Preference Section -->
      <h4>Job Preference</h4>

      <!-- Preferred Occupation -->
      <div class="row">
        <div class="col-md-3 mb-3">
          <label for="occupation" class="info">Preferred Occupation</label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 mb-3">
          <input type="text" id="occupation_1" name="#" class="form-control ocu_input" placeholder="1 - Occupation" value="<?php echo isset($row['#']) ? htmlspecialchars($row['#']) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" id="occupation_2" name="#" class="form-control ocu_input" placeholder="2 - Occupation" value="<?php echo isset($row['#']) ? htmlspecialchars($row['#']) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" id="occupation_3" name="#" class="form-control ocu_input" placeholder="3 - Occupation" value="<?php echo isset($row['#']) ? htmlspecialchars($row['#']) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" id="occupation_4" name="#" class="form-control ocu_input" placeholder="4 - Occupation" value="<?php echo isset($row['#']) ? htmlspecialchars($row['#']) : ''; ?>">
        </div>
      </div>

      <!-- Preferred Work Location and Salary -->
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="pwl" class="info">Preferred Work Location</label>
          <select class="form-select" id="pwl" name="pwl" required>
            <option value="">Select</option>
            <option value="local" <?php echo (isset($row['pwl']) && $row['pwl'] == 'local') ? 'selected' : ''; ?>>Local, specify cities/municipalities</option>
            <option value="overseas" <?php echo (isset($row['pwl']) && $row['pwl'] == 'overseas') ? 'selected' : ''; ?>>Overseas, specify countries</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label for="salary" class="info">Expected Salary</label>
          <input type="text" id="salary" name="salary" class="form-control" placeholder="Input Range" required>
        </div>
      </div>

      <!-- Local Work Location Details -->
      <div id="local-input" class="location-input">
        <div class="row">
          <div class="col-md-4 mb-3">
            <input type="text" name="local" class="form-control pwl_input" placeholder="1 - City/Municipality" value="<?php echo isset($row['local-city1']) ? htmlspecialchars($row['local-city1']) : ''; ?>">
          </div>
          <div class="col-md-4 mb-3">
            <input type="text" name="local" class="form-control pwl_input" placeholder="2 - City/Municipality" value="<?php echo isset($row['local-city2']) ? htmlspecialchars($row['local-city2']) : ''; ?>">
          </div>
          <div class="col-md-4 mb-3">
            <input type="text" name="local" class="form-control pwl_input" placeholder="3 - City/Municipality" value="<?php echo isset($row['local-city3']) ? htmlspecialchars($row['local-city3']) : ''; ?>">
          </div>
        </div>
      </div>

      <!-- Overseas Work Location Details -->
      <div id="overseas-input" class="location-input">
        <div class="row">
          <div class="col-md-4 mb-3">
            <input type="text" name="overseas-country1" class="form-control overseas-option pwl_input" placeholder="1 - Country" value="<?php echo isset($row['overseas-country1']) ? htmlspecialchars($row['overseas-country1']) : ''; ?>">
          </div>
          <div class="col-md-4 mb-3">
            <input type="text" name="overseas-country2" class="form-control overseas-option pwl_input" placeholder="2 - Country" value="<?php echo isset($row['overseas-country2']) ? htmlspecialchars($row['overseas-country2']) : ''; ?>">
          </div>
          <div class="col-md-4 mb-3">
            <input type="text" name="overseas-country3" class="form-control overseas-option pwl_input" placeholder="3 - Country" value="<?php echo isset($row['overseas-country3']) ? htmlspecialchars($row['overseas-country3']) : ''; ?>">
          </div>
        </div>
      </div>

      <!-- Passport Information -->
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="passport" class="info">Passport No.</label>
          <input type="text" id="passport" name="passport_no" class="form-control" placeholder="Input Passport Number" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="passport_expiry" class="info">Expiry Date</label>
          <input type="date" id="passport_expiry" name="passport_expiry" class="form-control" required>
        </div>
      </div>

      <!-- Language Proficiency -->
      <h4>Language/Dialect Proficiency</h4>
      <div class="container">
        <div class="row mb-3">
          <div class="col-md-2">
            <span class="info">Language</span>
            <label>(check if applicable)</label>
          </div>
          <div class="col-md-2 text-center">
            <span class="info">Read</span>
          </div>
          <div class="col-md-2 text-center">
            <span class="info">Write</span>
          </div>
          <div class="col-md-2 text-center">
            <span class="info">Speak</span>
          </div>
          <div class="col-md-2 text-center">
            <span class="info">Understand</span>
          </div>
        </div>

        <!-- English Row -->
        <div class="row mb-3">
          <div class="col-md-2">
            <label class="info">English</label>
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxReadEnglish" value="" aria-label="Read">
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxWriteEnglish" value="" aria-label="Write">
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxSpeakEnglish" value="" aria-label="Speak">
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxUnderstandEnglish" value="" aria-label="Understand">
          </div>
        </div>

        <!-- Filipino Row -->
        <div class="row mb-3">
          <div class="col-md-2">
            <label class="info">Filipino</label>
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxReadFilipino" value="" aria-label="Read">
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxWriteFilipino" value="" aria-label="Write">
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxSpeakFilipino" value="" aria-label="Speak">
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxUnderstandFilipino" value="" aria-label="Understand">
          </div>
        </div>

        <!-- Others Row -->
        <div class="row mb-3">
          <div class="col-md-2">
            <input type="text" id="language_others" class="form-control" placeholder="Others">
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxReadOthers" value="" aria-label="Read">
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxWriteOthers" value="" aria-label="Write">
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxSpeakOthers" value="" aria-label="Speak">
          </div>
          <div class="col-md-2 text-center">
            <input type="checkbox" id="checkboxUnderstandOthers" value="" aria-label="Understand">
          </div>
        </div>
      </div>

      <!-- Technical/Vocational and Other Training -->
      <h4>Technical/Vocational and Other Training</h4>

      <!-- Label Row -->
      <div class="row">
        <div class="col-md-2 text-center">
          <label>Training/Vocational Course</label>
        </div>
        <div class="col-md-4 text-center">
          <label>Duration</label>
        </div>
        <div class="col-md-2 text-center">
          <label>Training Institution</label>
        </div>
        <div class="col-md-2 text-center">
          <label>Certificates (upload file)</label>
        </div>
      </div>

      <!-- Input Row 1 -->
      <div class="row mb-3">
        <div class="col-md-2">
          <input type="text" class="form-control" placeholder="1 Training/Vocational">
        </div>
        <div class="col-md-4 text-center">
          <div class="d-flex justify-content-center">
            <input type="date" class="form-control" placeholder="Start Date" style="width: 120px;">
            <span class="mx-2 align-self-center">to</span>
            <input type="date" class="form-control" placeholder="End Date" style="width: 120px;">
          </div>
        </div>
        <div class="col-md-2 text-center">
          <input type="text" class="form-control" placeholder="Institution">
        </div>
        <div class="col-md-2 text-center">
          <input type="file" class="form-control" name="certificate">
        </div>
      </div>

      <!-- Input Row 2 -->
      <div class="row mb-3">
        <div class="col-md-2">
          <input type="text" class="form-control" placeholder="2 Training/Vocational">
        </div>
        <div class="col-md-4 text-center">
          <div class="d-flex justify-content-center">
            <input type="date" class="form-control" placeholder="Start Date" style="width: 120px;">
            <span class="mx-2 align-self-center">to</span>
            <input type="date" class="form-control" placeholder="End Date" style="width: 120px;">
          </div>
        </div>
        <div class="col-md-2 text-center">
          <input type="text" class="form-control" placeholder="Institution">
        </div>
        <div class="col-md-2 text-center">
          <input type="file" class="form-control" name="certificate">
        </div>
      </div>

      <!-- Input Row 3 -->
      <div class="row mb-3">
        <div class="col-md-2">
          <input type="text" class="form-control" placeholder="3 Training/Vocational">
        </div>
        <div class="col-md-4 text-center">
          <div class="d-flex justify-content-center">
            <input type="date" class="form-control" placeholder="Start Date" style="width: 120px;">
            <span class="mx-2 align-self-center">to</span>
            <input type="date" class="form-control" placeholder="End Date" style="width: 120px;">
          </div>
        </div>
        <div class="col-md-2 text-center">
          <input type="text" class="form-control" placeholder="Institution">
        </div>
        <div class="col-md-2 text-center">
          <input type="file" class="form-control" name="certificate">
        </div>
      </div>

      <!-- Eligibility/Professional License -->
      <h4>Eligibility/Professional License</h4>

      <!-- Label Row -->
      <div class="row">
        <div class="col-md-3 text-center">
          <label>Eligibility (Civil Service)</label>
        </div>
        <div class="col-md-2 text-center">
          <label>Rating</label>
        </div>
        <div class="col-md-3 text-center">
          <label>Date of Examination</label>
        </div>
        <div class="col-md-4 text-center">
          <label>Professional License (PRC) (upload file)</label>
        </div>
      </div>

      <!-- Input Row 1 -->
      <div class="row mb-3">
        <div class="col-md-3">
          <input type="text" class="form-control" name="eligibility" placeholder="Eligibility">
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="rating" placeholder="Rating">
        </div>
        <div class="col-md-3">
          <input type="date" class="form-control" name="exam_date">
        </div>
        <div class="col-md-4">
          <input type="file" class="form-control" name="license">
        </div>
      </div>

      <!-- Input Row 2 -->
      <div class="row mb-3">
        <div class="col-md-3">
          <input type="text" class="form-control" name="eligibility" placeholder="Eligibility">
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="rating" placeholder="Rating">
        </div>
        <div class="col-md-3">
          <input type="date" class="form-control" name="exam_date">
        </div>
        <div class="col-md-4">
          <input type="file" class="form-control" name="license">
        </div>
      </div>

      <!-- Work Experience (Limit to 10-year period) -->
      <h4>Work Experience (Limit to 10-year period)</h4>

      <!-- Label Row -->
      <div class="row">
        <div class="col-md-2 text-center">
          <label>Company Name</label>
        </div>
        <div class="col-md-3 text-center">
          <label>Address (City/Municipality)</label>
        </div>
        <div class="col-md-2 text-center">
          <label>Position</label>
        </div>
        <div class="col-md-3 text-center">
          <label>Inclusive Dates</label>
        </div>
        <div class="col-md-2 text-center">
          <label>Status</label>
        </div>
      </div>

      <!-- Input Row 1 -->
      <div class="row mb-3">
        <div class="col-md-2">
          <input type="text" class="form-control" name="company" placeholder="Company Name">
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" name="address" placeholder="Address">
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="position" placeholder="Position">
        </div>
        <div class="col-md-3 text-center">
          <div class="d-flex justify-content-center">
            <input type="date" class="form-control" name="start_date" placeholder="Start Date" style="width: 120px;">
            <span class="mx-2 align-self-center">to</span>
            <input type="date" class="form-control" name="end_date" placeholder="End Date" style="width: 120px;">
          </div>
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="status" placeholder="Status">
        </div>
      </div>

      <!-- Input Row 2 -->
      <div class="row mb-3">
        <div class="col-md-2">
          <input type="text" class="form-control" name="company" placeholder="Company Name">
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" name="address" placeholder="Address">
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="position" placeholder="Position">
        </div>
        <div class="col-md-3 text-center">
          <div class="d-flex justify-content-center">
            <input type="date" class="form-control" name="start_date" placeholder="Start Date" style="width: 120px;">
            <span class="mx-2 align-self-center">to</span>
            <input type="date" class="form-control" name="end_date" placeholder="End Date" style="width: 120px;">
          </div>
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="status" placeholder="Status">
        </div>
      </div>

      <!-- Input Row 3 -->
      <div class="row mb-3">
        <div class="col-md-2">
          <input type="text" class="form-control" name="company" placeholder="Company Name">
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" name="address" placeholder="Address">
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="position" placeholder="Position">
        </div>
        <div class="col-md-3 text-center">
          <div class="d-flex justify-content-center">
            <input type="date" class="form-control" name="start_date" placeholder="Start Date" style="width: 120px;">
            <span class="mx-2 align-self-center">to</span>
            <input type="date" class="form-control" name="end_date" placeholder="End Date" style="width: 120px;">
          </div>
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="status" placeholder="Status">
        </div>
      </div>

      <!-- Input Row 4 -->
      <div class="row mb-3">
        <div class="col-md-2">
          <input type="text" class="form-control" name="company" placeholder="Company Name">
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" name="address" placeholder="Address">
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="position" placeholder="Position">
        </div>
        <div class="col-md-3 text-center">
          <div class="d-flex justify-content-center">
            <input type="date" class="form-control" name="start_date" placeholder="Start Date" style="width: 120px;">
            <span class="mx-2 align-self-center">to</span>
            <input type="date" class="form-control" name="end_date" placeholder="End Date" style="width: 120px;">
          </div>
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="status" placeholder="Status">
        </div>
      </div>

      <!-- Input Row 5 -->
      <div class="row mb-3">
        <div class="col-md-2">
          <input type="text" class="form-control" name="company" placeholder="Company Name">
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" name="address" placeholder="Address">
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="position" placeholder="Position">
        </div>
        <div class="col-md-3 text-center">
          <div class="d-flex justify-content-center">
            <input type="date" class="form-control" name="start_date" placeholder="Start Date" style="width: 120px;">
            <span class="mx-2 align-self-center">to</span>
            <input type="date" class="form-control" name="end_date" placeholder="End Date" style="width: 120px;">
          </div>
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="status" placeholder="Status">
        </div>
      </div>

      <!-- Other Skills Acquired Without Formal Training -->
      <h4>Other Skills Acquired Without Formal Training</h4>

      <div class="row">
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Auto Mechanic"> Auto Mechanic</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Beautician"> Beautician</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Carpentry Work"> Carpentry Work</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Computer Literate"> Computer Literate</label>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Domestic Chores"> Domestic Chores</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Driver"> Driver</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Electrician"> Electrician</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Embroidery"> Embroidery</label>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Gardening"> Gardening</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Masonry"> Masonry</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Painter/Artist"> Painter/Artist</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Painting Jobs"> Painting Jobs</label>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Photography"> Photography</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Plumbing"> Plumbing</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Sewing Dresses"> Sewing Dresses</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Stenography"> Stenography</label>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Tailoring"> Tailoring</label>
        </div>
        <div class="col-md-3">
          <label><input type="checkbox" name="skills[]" value="Others"> Others</label>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-2">
          <label for="profile_image">resume:</label>
          <input type="file" class="form-control" name="resume" placeholder="Status">
        </div>
      </div>
      <!-- Submit Button -->
      <input class="btn btn-primary " type="submit" value="submit">
    </div>
  </form>
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../../javascript/a_profile.js"></script> 
    
<script src="../../javascript/script.js"></script> 
</body>
</html>