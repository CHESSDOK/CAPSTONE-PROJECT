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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../../css/a_profile.css">
  <link rel="stylesheet" href="../../css/nav_float.css">
  <style>
        #newOptionContainer {
            display: none; /* Initially hide the input field */
            margin-top: 10px;
        }
        #selectedOptionsContainer {
            margin-top: 20px;
        }
        #selectedOptionsList li {
            cursor: pointer;
        }
        .row {
            margin-bottom: 10px;
        }
  </style>
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
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
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
            <input type="text" id="disability-other" name="pwd2" class="form-control" value="<?php echo isset($row['pwd2']) ? htmlspecialchars($row['pwd2']) : ''; ?>">
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

        <!-- Technical/Vocational and Other Training -->
    <h4>Technical/Vocational and Other Training</h4>

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
    <div class="col-md-1 text-center">
        <label>Action</label>
    </div>
</div>

<!-- Input Container for Technical Training -->
<div id="training-container">
    <div class="row mb-3">
        <div class="col-md-2">
            <input type="text" class="form-control" name="training[]" placeholder="Training/Vocational">
        </div>
        <div class="col-md-4 text-center">
            <div class="d-flex justify-content-center">
                <input type="date" class="form-control" name="start_date[]" placeholder="Start Date" style="width: 120px;">
                <span class="mx-2 align-self-center">to</span>
                <input type="date" class="form-control" name="end_date[]" placeholder="End Date" style="width: 120px;">
            </div>
        </div>
        <div class="col-md-2 text-center">
            <input type="text" class="form-control" name="institution[]" placeholder="Institution">
        </div>
        <div class="col-md-2 text-center">
            <input type="file" class="form-control" name="certificate[]">
        </div>
        <div class="col-md-1 text-center">
            <button type="button" class="btn btn-danger" onclick="removeTrainingGroup(this)">Remove</button>
        </div>
    </div>
</div>

<!-- Button to Add Another Training Set -->
<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-primary" onclick="addTrainingGroup()">Add Another Training Set</button>
    </div>
</div>

<!-- Language/Dialect Proficiency -->
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
        <div class="col-md-1 text-center">
            <label>Action</label>
        </div>
    </div>

    <!-- Input Container for Language Proficiency -->
    <div id="language-container">
        <div class="row mb-3">
            <div class="col-md-2">
                <input type="text" class="form-control" name="language[]" placeholder="Language">
            </div>
            <div class="col-md-2 text-center">
                <input type="checkbox" name="read[]" value="1" aria-label="Read">
            </div>
            <div class="col-md-2 text-center">
                <input type="checkbox" name="write[]" value="1" aria-label="Write">
            </div>
            <div class="col-md-2 text-center">
                <input type="checkbox" name="speak[]" value="1" aria-label="Speak">
            </div>
            <div class="col-md-2 text-center">
                <input type="checkbox" name="understand[]" value="1" aria-label="Understand">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger" onclick="removeLanguageGroup(this)">Remove</button>
            </div>
        </div>
    </div>

    <!-- Button to Add Another Language Set --> 
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="button" class="btn btn-primary" onclick="addLanguageGroup()">Add Another Language Set</button>
        </div>
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
            <div class="col-md-3 text-center">
              <label>Professional License (PRC) (upload file)</label>
            </div>
            <div class="col-md-1 text-center">
              <label>Action</label>
            </div>
        </div>

        <!-- Input Container for Dynamic Rows -->
        <div id="input-container">
            <!-- Input Row 1 (Default) -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="eligibility[]" placeholder="Eligibility">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="rating[]" placeholder="Rating">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="exam_date[]">
                </div>
                <div class="col-md-3">
                    <input type="file" class="form-control" name="license[]">
                </div>
                <div class="col-md-1 text-center">
                    <!-- Empty action column for the first row -->
                </div>
            </div>
        </div>

        <!-- Button to Add Another Set -->
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-primary" onclick="addInputGroup()">Add Another Set</button>
            </div>
        </div>

      <!-- Work Experience (Limit to 10-year period) -->
      <h4>Work Experience (Limit to 10-year period)</h4>

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

        <!-- Input Container for Work Experience -->
        <div id="work-experience-container">
            <div class="row mb-3">
                <div class="col-md-2">
                    <input type="text" class="form-control" name="company[]" placeholder="Company Name">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="address[]" placeholder="Address">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="position[]" placeholder="Position">
                </div>
                <div class="col-md-3 text-center">
                    <div class="d-flex justify-content-center">
                        <input type="date" class="form-control" name="start_date[]">
                        <span class="mx-2 align-self-center">to</span>
                        <input type="date" class="form-control" name="end_date[]">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="status[]" placeholder="Status">
                </div>
            </div>
        </div>

        <!-- Button to Add Another Work Experience Set -->
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-primary" onclick="addWorkExperienceGroup()">Add Another Work Experience Set</button>
            </div>
        </div>

      <!-- Other Skills Acquired Without Formal Training -->
      <h4>Other Skills Acquired Without Formal Training</h4>
        <label for="dynamicSelect">Choose one or more options:</label>
        <select id="dynamicSelect"  name="other_skills[]" multiple>
          <option value="add">Add a new option...</option>
          <option value="Auto Mechanic">Auto Mechanic</option>
          <option value="Beautician">Beautician</option>
          <option value="Carpentry Work">Carpentry Work</option>
          <option value="Computer Literate">Computer Literate</option>
          <option value="Domestic Chores">Domestic Chores</option>
          <option value="Driver">Driver</option>
          <option value="Electrician">Electrician</option>
          <option value="Embroidery">Embroidery</option>
          <option value="Gardening">Gardening</option>
          <option value="Masonry">Masonry</option>
          <option value="Painter/Artist">Painter/Artist</option>
          <option value="Painting Jobs">Painting Jobs</option>
          <option value="Photography">Photography</option>
          <option value="Plumbing">Plumbing</option>
          <option value="Sewing">Sewing Dresses</option>
          <option value="Stenography">Stenography</option>
          <option value="Tailoring">Tailoring</option>
        </select>

        <div id="newOptionContainer">
          <input type="text" id="newOption" placeholder="Enter new option">
          <button id="addButton" type="button">Add Option</button> <!-- Ensure type="button" here -->
        </div>
        <input type="hidden" name="selectedOptions" id="selectedOptionsHidden">
        <div id="selectedOptionsContainer">
          <h3>Selected Options:</h3>
          <ul id="selectedOptionsList"></ul>
        </div>

        <input class="btn btn-primary" type="submit" value="submit">
  </form>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('dynamicSelect');
    const newOptionInput = document.getElementById('newOption');
    const addButton = document.getElementById('addButton');
    const newOptionContainer = document.getElementById('newOptionContainer');
    const selectedOptionsList = document.getElementById('selectedOptionsList');
    const form = document.getElementById('optionsForm');
    const selectedOptionsHidden = document.getElementById('selectedOptionsHidden'); // The hidden input field

    let selectedOptions = new Set(); // Use a Set to store unique selected options

    // Function to update the displayed selected options
    function updateSelectedOptions() {
        selectedOptionsList.innerHTML = ''; // Clear the current list
        
        // Loop through selected options and display them
        selectedOptions.forEach(optionValue => {
            const listItem = document.createElement('li');
            listItem.textContent = optionValue;
            listItem.addEventListener('click', function() {
                removeOption(optionValue); // Allow removing option on click
            });
            selectedOptionsList.appendChild(listItem);
        });

        // Update the hidden field with selected options
        updateHiddenField();
    }

    // Remove option from the selected options
    function removeOption(optionValue) {
        selectedOptions.delete(optionValue); // Remove from set
        updateSelectedOptions(); // Update display
    }

    // Toggle option in the selected options
    function toggleOption(optionValue) {
        if (selectedOptions.has(optionValue)) {
            removeOption(optionValue); // If already selected, remove it
        } else {
            selectedOptions.add(optionValue); // If not selected, add it
        }
        updateSelectedOptions(); // Update display
    }

    // Show the input field when "Add a new option..." is selected
    selectElement.addEventListener('change', function() {
        const selectedValue = selectElement.value;

        if (selectedValue === 'add') {
            newOptionContainer.style.display = 'block';
            newOptionInput.focus(); // Focus on the input field
        } else {
            newOptionContainer.style.display = 'none';
            toggleOption(selectedValue); // Toggle the selection state of the option
            selectElement.value = ''; // Reset the select value
        }
    });

    // Add new option to the select when the button is clicked
    addButton.addEventListener('click', function() {
        const newOptionValue = newOptionInput.value.trim();
        if (newOptionValue) {
            // Create a new option element
            const newOption = document.createElement('option');
            newOption.value = newOptionValue;
            newOption.textContent = newOptionValue;
            
            // Add the new option to the select element
            selectElement.appendChild(newOption);

            // Automatically add and select the newly added option
            toggleOption(newOptionValue);
            selectElement.value = ''; // Reset the select value

            // Clear the input field and hide it again
            newOptionInput.value = '';
            newOptionContainer.style.display = 'none';

            updateSelectedOptions(); // Update the displayed options
        } else {
            alert('Please enter a valid option.');
        }
    });

    // Function to update the hidden input field with selected options
    function updateHiddenField() {
        selectedOptionsHidden.value = Array.from(selectedOptions).join(','); // Convert Set to comma-separated string
    }

    // Update the hidden input field before form submission
    form.addEventListener('submit', function(event) {
        updateHiddenField(); // Make sure the hidden field is updated before submission
        console.log("Selected options: " + selectedOptionsHidden.value); // Debugging output
    });
});
  </script>
<script>
    function addInputGroup() {
        // Get the input container for Eligibility
        const container = document.getElementById('input-container');

        // Create a new row for eligibility input group
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-3');

        // Add the new input fields for eligibility
        newRow.innerHTML = `
            <div class="col-md-3">
                <input type="text" class="form-control" name="eligibility[]" placeholder="Eligibility">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="rating[]" placeholder="Rating">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" name="exam_date[]">
            </div>
            <div class="col-md-3">
                <input type="file" class="form-control" name="license[]">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger" onclick="removeInputGroup(this)">Remove</button>
            </div>
        `;

        // Append the new row to the container
        container.appendChild(newRow);
    }

    function addWorkExperienceGroup() {
        // Get the input container for Work Experience
        const container = document.getElementById('work-experience-container');

        // Create a new row for work experience input group
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-3');

        // Add the new input fields for work experience
        newRow.innerHTML = `
            <div class="col-md-2">
                <input type="text" class="form-control" name="company[]" placeholder="Company Name">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="address[]" placeholder="Address">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="position[]" placeholder="Position">
            </div>
            <div class="col-md-3 text-center">
                <div class="d-flex justify-content-center">
                    <input type="date" class="form-control" name="start_date[]">
                    <span class="mx-2 align-self-center">to</span>
                    <input type="date" class="form-control" name="end_date[]">
                </div>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="status[]" placeholder="Status">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger" onclick="removeWorkExperienceGroup(this)">Remove</button>
            </div>
        `;

        // Append the new row to the container
        container.appendChild(newRow);
    }

    function removeInputGroup(button) {
        // Remove the row that contains the clicked button
        button.parentElement.parentElement.remove();
    }

    function removeWorkExperienceGroup(button) {
        // Remove the row that contains the clicked button
        button.parentElement.parentElement.remove();
    }
    function addTrainingGroup() {
        // Get the input container for Technical/Vocational Training
        const container = document.getElementById('training-container');

        // Create a new row for training input group
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-3');

        // Add the new input fields for training
        newRow.innerHTML = `
            <div class="col-md-2">
                <input type="text" class="form-control" name="training[]" placeholder="Training/Vocational">
            </div>
            <div class="col-md-4 text-center">
                <div class="d-flex justify-content-center">
                    <input type="date" class="form-control" name="start_date[]" placeholder="Start Date" style="width: 120px;">
                    <span class="mx-2 align-self-center">to</span>
                    <input type="date" class="form-control" name="end_date[]" placeholder="End Date" style="width: 120px;">
                </div>
            </div>
            <div class="col-md-2 text-center">
                <input type="text" class="form-control" name="institution[]" placeholder="Institution">
            </div>
            <div class="col-md-2 text-center">
                <input type="file" class="form-control" name="certificate[]">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger" onclick="removeTrainingGroup(this)">Remove</button>
            </div>
        `;

        // Append the new row to the container
        container.appendChild(newRow);
    }

    function removeTrainingGroup(button) {
        // Remove the row that contains the clicked button
        button.parentElement.parentElement.remove();
    }

    function addLanguageGroup() {
        // Get the input container for Language Proficiency
        const container = document.getElementById('language-container');

        // Create a new row for language proficiency input group
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-3');

        // Add the new input fields for language proficiency
        newRow.innerHTML = `
            <div class="col-md-2">
                <input type="text" class="form-control" name="language[]" placeholder="Language">
            </div>
            <div class="col-md-2 text-center">
                <input type="checkbox" name="read[]" value="1" aria-label="Read">
            </div>
            <div class="col-md-2 text-center">
                <input type="checkbox" name="write[]" value="1" aria-label="Write">
            </div>
            <div class="col-md-2 text-center">
                <input type="checkbox" name="speak[]" value="1" aria-label="Speak">
            </div>
            <div class="col-md-2 text-center">
                <input type="checkbox" name="understand[]" value="1" aria-label="Understand">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger" onclick="removeLanguageGroup(this)">Remove</button>
            </div>
        `;

        // Append the new row to the container
        container.appendChild(newRow);
    }

    function removeLanguageGroup(button) {
        // Remove the row that contains the clicked button
        button.parentElement.parentElement.remove();
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../../javascript/a_profile.js"></script> 
    
<script src="../../javascript/script.js"></script> 
</body>
</html>