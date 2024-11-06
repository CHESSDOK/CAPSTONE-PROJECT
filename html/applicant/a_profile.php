<?php
include '../../php/conn_db.php';

function checkSession() {
   session_start(); // Start the session

   // Check if the session variable 'id' is set
   if (!isset($_SESSION['id'])) {
       // Redirect to login page if session not found
       header("Location: ../combine_login.html");
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
$preferred = isset($row['preferred_occupation']) ? explode(',', $row['preferred_occupation']) : '';
$loc1 = isset($row['overseas_loc']) ? explode(',',$row['overseas_loc']) : ''; 
$loc2 = isset($row['local_loc']) ? explode(',',$row['local_loc']) : ''; 
$otherSkills = isset($row['selected_options']) ? explode(',', $row['selected_options']) : [];
$uploadedImage = isset($row['photo']) ? $row['photo'] : '';  // Use the value from the database
$imagePath = '../../php/applicant/images/' . $uploadedImage;  // Assuming this is the directory where the images are stored
$uploadedResume = isset($row['resume']) ? $row['resume'] : '';  // Use the value from the database
$resumePath = '../../php/applicant/resume/' . $uploadedResume;  // Assuming this is the directory where the images are stored

if (!$row) {
   die("User not found in applicant_profile.");
}

// Fetch data from register table using new approach
$sql_new = "SELECT * FROM applicant_profile WHERE user_id = ?";
$stmt_new = $conn->prepare($sql_new);
$stmt_new->bind_param("i", $userId);
$stmt_new->execute();
$result_new = $stmt_new->get_result();

if ($result_new->num_rows > 0) {
    $row_new = $result_new->fetch_assoc(); // Fetch the data into a separate variable
} else {
    $row_new = array(); // If no data found, initialize as an empty array
}

//training
$sql_training = "SELECT * FROM training WHERE user_id = ?";
$stmt_training = $conn->prepare($sql_training);
$stmt_training->bind_param("i", $userId);
$stmt_training->execute();
$result_training = $stmt_training->get_result();
// Close the connection

//language
$sql_language = "SELECT * FROM language_proficiency WHERE user_id = ?";
$stmt_language = $conn->prepare($sql_language);
$stmt_language->bind_param("i", $userId);
$stmt_language->execute();
$result_language = $stmt_language->get_result();

// Create an array to hold language proficiency data
$languageData = [];
while ($row_language = $result_language->fetch_assoc()) {
    $languageData[$row_language['language_p']] = $row_language;
}

// Close the statement
$stmt_language->close();

// Fetch data from license table
$sql_license = "SELECT * FROM license WHERE user_id = ?";
$stmt_license = $conn->prepare($sql_license);
$stmt_license->bind_param("i", $userId);
$stmt_license->execute();
$result_license = $stmt_license->get_result();

// Close the statement after fetching
$stmt_license->close();

// Fetch data from work_exp table
$sql_work_exp = "SELECT * FROM work_exp WHERE user_id = ?";
$stmt_work_exp = $conn->prepare($sql_work_exp);
$stmt_work_exp->bind_param("i", $userId);
$stmt_work_exp->execute();
$result_work_exp = $stmt_work_exp->get_result();

// Close the statement after fetching
$stmt_work_exp->close();



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
                <tr><td><a href="About.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="Contact.php" class="nav-link">Contact Us</a></td></tr>
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


<form id="optionsForm" action="../../php/applicant/approf.php" method="post" enctype="multipart/form-data">
<!-- Profile Container -->
<div class="profile-container container mt-4">
<input type="hidden" name="id"  value="<?php echo $userId; ?>">

  <!-- Combined Personal Information Card -->
<div class="card mb-4">
  <div class="card-header">
    <h4>Personal Information</h4>
  </div>
  <div class="card-body">
 
    <!-- Profile Image -->
    <div class="row">
    <div class="col-md-6 mb-3">
      <label for="profile_image">Select Profile Image:</label>
      <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*" onchange="previewImage(event)">
      <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($uploadedImage); ?>">
    </div>

    <div class="col-md-6 mb-3 text-center">
    <img id="profile_image_preview" 
         src="<?php echo !empty($row['photo']) ? '../../php/applicant/images/' . $row['photo'] : '../../img/user-placeholder.png'; ?>" 
         alt="Profile Image" 
         class="rounded-circle img-thumbnail" 
         style="width: 150px; height: 150px; object-fit: cover;">
</div>
<div class="row">
  <div class="col-md-6 mb-3">
        <label for="resume">RESUME:</label>
        <input type="file" name="resume" id="resume" class="form-control">
        <input type="hidden" name="existing_resume" value="<?php echo htmlspecialchars($uploadedResume); ?>">
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

    <!-- Civil Status, Sex, and Height -->
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
            <select class="form-select" id="pwd" name="pwd">
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
            <div id="disability-input" class="additional-input" style="display: none;">
                <label for="disability-other" class="info">Please specify:</label>
                <input type="text" id="disability-other" name="pwd2" class="form-control" value="<?php echo isset($row['pwd2']) ? htmlspecialchars($row['pwd2']) : ''; ?>">
            </div>
        </div>
    </div>

      <div class="col-md-3 mb-3">
        <label for="four-ps-beneficiary" class="info">Are you a 4Ps beneficiary?</label>
        <select class="form-select" id="four-ps-beneficiary" name="four-ps-beneficiary">
          <option value="">Select</option>
          <option value="Yes" <?php echo (isset($row['four_ps']) && $row['four_ps'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
          <option value="No" <?php echo (isset($row['four_ps']) && $row['four_ps'] == 'No') ? 'selected' : ''; ?>>No</option>
        </select>
      </div>
      <div class="col-md-3 mb-3">
        <div id="household-id-input" class="additional-input">
          <label for="household-id" class="info">If yes, Household ID No.</label>
          <input type="text" name = "household_id" id="household-id" class="form-control" value="<?php echo isset($row['hhid']) ? htmlspecialchars($row['hhid']) : ''; ?>">
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Educational Background Card -->
<div class="card mb-4">
    <div class="card-header">
        <h4>Educational Background</h4>
    </div>
    <div class="card-body">
        <!-- Elementary Section -->
        <div class="row mb-3">
            <div class="col-md-2">
                <h5>Elementary</h5>
            </div>
            <div class="col-md-5">
                <label for="elemSchoolName" class="form-label">School Name</label>
                <input type="text" name="school_name1" class="form-control" id="elemSchoolName" value="<?php echo isset($row['school_name1']) ? htmlspecialchars($row['school_name1']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <label for="elemYearGrad" class="form-label">Year Graduated</label>
                <input type="date" name="year_grad1" class="form-control" id="elemYearGrad" value="<?php echo isset($row['year_grad1']) ? htmlspecialchars($row['year_grad1']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <label for="elemAwards" class="form-label">Awards Received</label>
                <input type="text" name="award1" class="form-control" id="elemAwards" value="<?php echo isset($row['award1']) ? htmlspecialchars($row['award1']) : ''; ?>">
            </div>
        </div>

        <!-- Secondary Section -->
        <div class="row mb-3">
            <div class="col-md-2">
                <h5>Secondary</h5>
            </div>
            <div class="col-md-5">
                <label for="secSchoolName" class="form-label">School Name</label>
                <input type="text" name="school_name2" class="form-control" id="secSchoolName" value="<?php echo isset($row['school_name2']) ? htmlspecialchars($row['school_name2']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <label for="secYearGrad" class="form-label">Year Graduated</label>
                <input type="date" name="year_grad2" class="form-control" id="secYearGrad" value="<?php echo isset($row['year_grad2']) ? htmlspecialchars($row['year_grad2']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <label for="secAwards" class="form-label">Awards Received</label>
                <input type="text" name="award2" class="form-control" id="secAwards" value="<?php echo isset($row['award2']) ? htmlspecialchars($row['award2']) : ''; ?>">
            </div>
        </div>

        <!-- Tertiary Section -->
        <div class="row mb-3">
            <div class="col-md-2">
                <h5>Tertiary</h5>
            </div>
            <div class="col-md-3">
                <label for="terSchoolName" class="form-label">School Name</label>
                <input type="text" name="school_name3" class="form-control" id="terSchoolName" value="<?php echo isset($row['school_name3']) ? htmlspecialchars($row['school_name3']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <label for="terCourse" class="form-label">Course</label>
                <input type="text" name="course3" class="form-control" id="terCourse" value="<?php echo isset($row['course3']) ? htmlspecialchars($row['course3']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <label for="terYearGrad" class="form-label">Year Graduated</label>
                <input type="date" name="year_grad3" class="form-control" id="terYearGrad" value="<?php echo isset($row['year_grad3']) ? htmlspecialchars($row['year_grad3']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <label for="terAwards" class="form-label">Awards Received</label>
                <input type="text" name="award3" class="form-control" id="terAwards" value="<?php echo isset($row['award3']) ? htmlspecialchars($row['award3']) : ''; ?>">
            </div>
        </div>

        <!-- Undergraduate Option -->
<div class="row mb-3">
    <div class="col-md-2">
        <!-- Empty space for alignment -->
    </div>
    <div class="col-md-10">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="terUndergradCheck">
            <label class="form-check-label" for="terUndergradCheck">
                If Undergraduate
            </label>
        </div>
    </div>
</div>

<!-- Fields on the same row -->
<div class="row mb-3" id="terUndergradFields" style="display: none;">
    <div class="col-md-2">
        <!-- Empty space for alignment -->
    </div>
    <div class="col-md-5">
        <label for="terLevel" class="form-label">Level</label>
        <input type="text" name="level3" class="form-control" id="terLevel" value="<?php echo isset($row['level3']) ? htmlspecialchars($row['level3']) : NULL; ?>">
    </div>
    <div class="col-md-5">
        <label for="terLastYear" class="form-label">Year Last Attended</label>
        <input type="date" name="year_level3" class="form-control" id="terLastYear" value="<?php echo isset($row['year_level3']) ? htmlspecialchars($row['year_level3']) : NULL; ?>">
    </div>
</div>

        <!-- Graduate Studies Section -->
        <div class="row mb-3">
            <div class="col-md-2">
                <h5>Graduate Studies</h5>
            </div>
            <div class="col-md-3">
                <label for="gradSchoolName" class="form-label">School Name</label>
                <input type="text" name="school_name4" class="form-control" id="gradSchoolName" value="<?php echo isset($row['school_name4']) ? htmlspecialchars($row['school_name4']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <label for="gradCourse" class="form-label">Course</label>
                <input type="text" name="course4" class="form-control" id="gradCourse" value="<?php echo isset($row['course4']) ? htmlspecialchars($row['course4']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <label for="gradYearGrad" class="form-label">Year Graduated</label>
                <input type="date" name="year_grad4" class="form-control" id="gradYearGrad" value="<?php echo isset($row['year_grad4']) ? htmlspecialchars($row['year_grad4']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <label for="gradAwards" class="form-label">Awards Received</label>
                <input type="text" name="award4" class="form-control" id="gradAwards" value="<?php echo isset($row['award4']) ? htmlspecialchars($row['award4']) : ''; ?>">
            </div>
        </div>

        <!-- Undergraduate Option for Graduate Studies -->
        <div class="row mb-3">
            <div class="col-md-2">
                <!-- Empty space for alignment -->
            </div>
            <div class="col-md-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gradUndergradCheck">
                    <label class="form-check-label" for="gradUndergradCheck">
                        If Undergraduate
                    </label>
                </div>
            </div>
        </div>
        <div class="row mb-3" id="gradUndergradFields" style="display: none;">
            <div class="col-md-5">
                <label for="gradLevel" class="form-label">Level</label>
                <input type="text" name="level4" class="form-control" id="gradLevel" value="<?php echo isset($row['level4']) ? htmlspecialchars($row['level4']) : NULL; ?>">
            </div>
            <div class="col-md-5">
                <label for="gradLastYear" class="form-label">Year Last Attended</label>
                <input type="date" name="year_level4" class="form-control" id="gradLastYear" value="<?php echo isset($row['year_level4']) ? htmlspecialchars($row['year_level4']) : NULL; ?>">
            </div>
        </div>
    </div>
</div>

  <!-- Combined Employment Information, Job Search Status, Job Preference, and Passport Information Card -->
<div class="card mb-4">
  <div class="card-header">
    <h4>Employment Information</h4>
  </div>
  <div class="card-body">

    <!-- Employment Information -->
    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="employment-status" class="info">Employment Status:</label>
        <select class="form-select" id="employment-status" name="employent_status">
          <option value="">Select</option>
          <option value="employed" <?php echo (isset($row['employment_status']) && $row['employment_status'] == 'employed') ? 'selected' : ''; ?>>Employed</option>
          <option value="unemployed" <?php echo (isset($row['employment_status']) && $row['employment_status'] == 'unemployed') ? 'selected' : ''; ?>>Unemployed</option>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <div id="sub-dropdown" class="sub-dropdown">
          <label for="employment-type" class="info">Employment Type:</label>
          <select class="form-select" name = "es_status" id="employment-type">
            <option value="">Select</option>
            <option value="wage" <?php echo (isset($row['es_status']) && $row['es_status'] == 'wage') ? 'selected' : ''; ?>>Wage Employed</option>
            <option value="self" <?php echo (isset($row['es_status']) && $row['es_status'] == 'self') ? 'selected' : ''; ?>>Self Employed</option>
            <option value="fresh_grad" <?php echo (isset($row['es_status']) && $row['es_status'] == 'fresh_grad') ? 'selected' : ''; ?>class="unemployed-option">New Entrant/Fresh Graduate</option>
            <option value="f_contract" <?php echo (isset($row['es_status']) && $row['es_status'] == 'f_contract') ? 'selected' : ''; ?>class="unemployed-option">Finished Contract</option>
            <option value="resigned" <?php echo (isset($row['es_status']) && $row['es_status'] == 'resigned') ? 'selected' : ''; ?>class="unemployed-option">Resigned</option>
            <option value="retired" <?php echo (isset($row['es_status']) && $row['es_status'] == 'retired') ? 'selected' : ''; ?>class="unemployed-option">Retired</option>
            <option value="local" <?php echo (isset($row['es_status']) && $row['es_status'] == 'local') ? 'selected' : ''; ?>class="unemployed-option">Terminated/Laidoff(local)</option>
            <option value="abroad" <?php echo (isset($row['es_status']) && $row['es_status'] == 'abroad') ? 'selected' : ''; ?>class="unemployed-option">Terminated/Laidoff(abroad)</option>
            <option value="others" <?php echo (isset($row['es_status']) && $row['es_status'] == 'others') ? 'selected' : ''; ?>class="unemployed-option">Others, specify</option>
          </select>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div id="additional-input" class="info">
          <label for="other-reason">Please specify country, others:</label>
          <input type="text" name="es_others" id="other-reason" class="form-control" value="<?php echo isset($row['es_others']) ? htmlspecialchars($row['es_others']) : ''; ?>">
        </div>
      </div>
    </div>

    <!-- Job Search Status -->
    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="actively-looking" class="info">Are you actively looking for work?</label>
        <select class="form-select" id="actively-looking" name="actively-looking">
          <option value="">Select</option>
          <option value="Yes" <?php echo (isset($row['actively_looking']) && $row['actively_looking'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
          <option value="No" <?php echo (isset($row['actively_looking']) && $row['actively_looking'] == 'No') ? 'selected' : ''; ?>>No</option>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <div id="actively-looking-input" class="additional-input">
          <label for="actively-looking-details" class="info">Please specify:</label>
          <input type="text" name = 'al_details' id="actively-looking-details" class="form-control" value="<?php echo isset($row['al_details']) ? htmlspecialchars($row['al_details']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="willing-to-work" class="info">Willing to work immediately?</label>
        <select class="form-select" id="willing-to-work" name="willing_to_work">
          <option value="">Select</option>
          <option value="Yes" <?php echo (isset($row['willing_to_work']) && $row['willing_to_work'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
          <option value="No" <?php echo (isset($row['willing_to_work']) && $row['willing_to_work'] == 'No') ? 'selected' : ''; ?>>No</option>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <div id="willing-to-work-input" class="additional-input">
          <label for="willing-to-work-details" class="info">Please specify:</label>
          <input type="text" name="ww_detail" id="willing-to-work-details" class="form-control" value="<?php echo isset($row['ww_details']) ? htmlspecialchars($row['ww_details']) : ''; ?>">
        </div>
      </div>
    </div>

    <!-- Job Preference -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <label for="occupation" class="info">Preferred Occupation</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <input type="text" id="occupation_1" name="job[]" class="form-control ocu_input" placeholder="1 - Occupation" value="<?php echo isset($preferred[0]) ? htmlspecialchars($preferred[0]) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
            <input type="text" id="occupation_2" name="job[]" class="form-control ocu_input" placeholder="2 - Occupation" value="<?php echo isset($preferred[1]) ? htmlspecialchars($preferred[1]) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
            <input type="text" id="occupation_3" name="job[]" class="form-control ocu_input" placeholder="3 - Occupation" value="<?php echo isset($preferred[2]) ? htmlspecialchars($preferred[2]) : ''; ?>">
        </div>
        <div class="col-md-3 mb-3">
            <input type="text" id="occupation_4" name="job[]" class="form-control ocu_input" placeholder="4 - Occupation" value="<?php echo isset($preferred[3]) ? htmlspecialchars($preferred[3]) : ''; ?>">
        </div>
    </div>

    <!-- Preferred Work Location and Salary -->
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="pwl" class="info">Preferred Work Location</label>
        <select class="form-select" id="pwl" name="pwl">
          <option value="">Select</option>
          <option value="local" <?php echo (isset($row['pwl']) && $row['pwl'] == 'local') ? 'selected' : ''; ?>>Local, specify cities/municipalities</option>
          <option value="overseas" <?php echo (isset($row['pwl']) && $row['pwl'] == 'overseas') ? 'selected' : ''; ?>>Overseas, specify countries</option>
        </select>
      </div>
      <div class="col-md-6 mb-3">
        <label for="salary" class="info">Expected Salary</label>
        <input type="text" id="salary" name="salary" class="form-control" value="<?php echo isset($row['expected_salary']) ? htmlspecialchars($row['expected_salary']) : ''; ?>">
      </div>
    </div>

    <!-- Local Work Location Details -->
    <div id="local-input" class="location-input">
      <div class="row">
        <div class="col-md-4 mb-3">
          <input type="text" name="local[]" class="form-control pwl_input" placeholder="1 - City/Municipality" value="<?php echo isset($loc2[0]) ? htmlspecialchars($loc2[0]) : ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
          <input type="text" name="local[]" class="form-control pwl_input" placeholder="2 - City/Municipality" value="<?php echo isset($loc2[1]) ? htmlspecialchars($loc2[1]) : ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
          <input type="text" name="local[]" class="form-control pwl_input" placeholder="3 - City/Municipality" value="<?php echo isset($loc2[2]) ? htmlspecialchars($loc2[2]) : ''; ?>">
        </div>
      </div>
    </div>

    <!-- Overseas Work Location Details -->
    <div id="overseas-input" class="location-input">
      <div class="row">
        <div class="col-md-4 mb-3">
          <input type="text" name="overseas[]" class="form-control overseas-option pwl_input" placeholder="1 - Country" value="<?php echo isset($loc1[0]) ? htmlspecialchars($loc1[0]) : ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
          <input type="text" name="overseas[]" class="form-control overseas-option pwl_input" placeholder="2 - Country" value="<?php echo isset($loc1[1]) ? htmlspecialchars($loc1[1]) : ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
          <input type="text" name="overseas[]" class="form-control overseas-option pwl_input" placeholder="3 - Country" value="<?php echo isset($loc1[2]) ? htmlspecialchars($loc1[2]) : ''; ?>">
        </div>
      </div>
    </div>

    <!-- Passport Information -->
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="passport" class="info">Passport No.</label>
        <input type="text" id="passport" name="passport_no" class="form-control" value="<?php echo isset($row['passport_no']) ? htmlspecialchars($row['passport_no']) : ''; ?>">
      </div>
      <div class="col-md-6 mb-3">
        <label for="passport_expiry" class="info">Expiry Date</label>
        <input type="date" id="passport_expiry" name="passport_expiry" class="form-control" value="<?php echo isset($row['passport_expiry']) ? htmlspecialchars($row['passport_expiry']) : ''; ?>">
      </div>
    </div>

  </div>
</div>


<!-- Technical/Vocational and Other Training Card -->
<div class="card mb-4">
  <div class="card-header">
    <h4>Technical/Vocational and Other Training</h4>
  </div>
  <div class="card-body">
    <div id="training-container">
        <?php if ($result_training->num_rows > 0): ?>
          <?php while ($row_training = $result_training->fetch_assoc()): ?>
            <div class="row mb-3">
              <div class="col-md-2">
                <input type="text" class="form-control" name="training[]" value="<?php echo htmlspecialchars($row_training['training']); ?>" placeholder="Training/Vocational">
              </div>
              <div class="col-md-4 text-center">
                <div class="d-flex justify-content-center">
                  <input type="date" class="form-control" name="start_date[]" value="<?php echo htmlspecialchars($row_training['start_date']); ?>" style="width: 120px;">
                  <span class="mx-2 align-self-center">to</span>
                  <input type="date" class="form-control" name="end_date[]" value="<?php echo htmlspecialchars($row_training['end_date']); ?>" style="width: 120px;">
                </div>
              </div>
              <div class="col-md-2 text-center">
                <input type="text" class="form-control" name="institution[]" value="<?php echo htmlspecialchars($row_training['institution']); ?>" placeholder="Institution">
              </div>
              <div class="col-md-2 text-center">
                <?php if (!empty($row_training['certificate_path'])):?>
                  <a href="../../php/applicant/<?php echo htmlspecialchars($row_training['certificate_path']); ?>" class="form-control" target="_blank">View Certificate</a>
                <?php endif; ?>
                <input type="file" class="form-control" name="certificate[]">
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <!-- No training records found, show an empty row for new input -->
          <div class="row mb-3">
            <div class="col-md-2">
              <input type="text" class="form-control" name="training[]" placeholder="Training/Vocational">
            </div>
            <div class="col-md-4 text-center">
              <div class="d-flex justify-content-center">
                <input type="date" class="form-control" name="start_date[]" style="width: 120px;">
                <span class="mx-2 align-self-center">to</span>
                <input type="date" class="form-control" name="end_date[]" style="width: 120px;">
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
        <?php endif; ?>
      </div>

      <div class="row">
        <div class="col-md-12 text-right">
          <button type="button" class="btn btn-primary" onclick="addTrainingGroup()">Add Another Training Set</button>
        </div>
      </div>
    </div>
</div>
<!-- Language/Dialect Proficiency Card -->
<div class="card mb-4">
  <div class="card-header">
    <h4>Language/Dialect Proficiency</h4>
  </div>
  <div class="card-body">
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
        <label class="info">Action</label>
      </div>
    </div>

    <!-- Default English Row -->
    <div class="row mb-3">
      <div class="col-md-2">
        <input type="text" class="form-control" name="language[]" value="English" readonly>
      </div>
      <div class="col-md-2 text-center">
        <input type="checkbox" name="read[]" value="1" <?php echo isset($languageData['English']) && $languageData['English']['read_l'] == 1 ? 'checked' : ''; ?>>
      </div>
      <div class="col-md-2 text-center">
        <input type="checkbox" name="write[]" value="1" <?php echo isset($languageData['English']) && $languageData['English']['write_l'] == 1 ? 'checked' : ''; ?>>
      </div>
      <div class="col-md-2 text-center">
        <input type="checkbox" name="speak[]" value="1" <?php echo isset($languageData['English']) && $languageData['English']['speak_l'] == 1 ? 'checked' : ''; ?>>
      </div>
      <div class="col-md-2 text-center">
        <input type="checkbox" name="understand[]" value="1" <?php echo isset($languageData['English']) && $languageData['English']['understand_l'] == 1 ? 'checked' : ''; ?>>
      </div>
    </div>

    <!-- Default Filipino Row -->
    <div class="row mb-3">
      <div class="col-md-2">
        <input type="text" class="form-control" name="language[]" value="Filipino" readonly>
      </div>
      <div class="col-md-2 text-center">
        <input type="checkbox" name="read[]" value="1" <?php echo isset($languageData['Filipino']) && $languageData['Filipino']['read_l'] == 1 ? 'checked' : ''; ?>>
      </div>
      <div class="col-md-2 text-center">
        <input type="checkbox" name="write[]" value="1" <?php echo isset($languageData['Filipino']) && $languageData['Filipino']['write_l'] == 1 ? 'checked' : ''; ?>>
      </div>
      <div class="col-md-2 text-center">
        <input type="checkbox" name="speak[]" value="1" <?php echo isset($languageData['Filipino']) && $languageData['Filipino']['speak_l'] == 1 ? 'checked' : ''; ?>>
      </div>
      <div class="col-md-2 text-center">
        <input type="checkbox" name="understand[]" value="1" <?php echo isset($languageData['Filipino']) && $languageData['Filipino']['understand_l'] == 1 ? 'checked' : ''; ?>>
      </div>
    </div>

    <!-- Dynamic Language Rows from Database -->
    <div id="language-container">
      <?php foreach ($languageData as $language => $data): ?>
        <?php if ($language != 'English' && $language != 'Filipino'): ?>
          <div class="row mb-3">
            <div class="col-md-2">
              <input type="text" class="form-control" name="language[]" value="<?php echo htmlspecialchars($language); ?>">
            </div>
            <div class="col-md-2 text-center">
              <input type="checkbox" name="read[]" value="1" <?php echo $data['read_l'] == 1 ? 'checked' : ''; ?>>
            </div>
            <div class="col-md-2 text-center">
              <input type="checkbox" name="write[]" value="1" <?php echo $data['write_l'] == 1 ? 'checked' : ''; ?>>
            </div>
            <div class="col-md-2 text-center">
              <input type="checkbox" name="speak[]" value="1" <?php echo $data['speak_l'] == 1 ? 'checked' : ''; ?>>
            </div>
            <div class="col-md-2 text-center">
              <input type="checkbox" name="understand[]" value="1" <?php echo $data['understand_l'] == 1 ? 'checked' : ''; ?>>
            </div>
            <div class="col-md-1 text-center">
              <button type="button" class="btn btn-danger" onclick="removeLanguageGroup(this)">Remove</button>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <!-- Add Another Language Set Button -->
    <div class="row">
      <div class="col-md-12 text-right">
        <button type="button" class="btn btn-primary" onclick="addLanguageGroup()">Add Another Language Set</button>
      </div>
    </div>
  </div>
</div>

<!-- Eligibility/Professional License Card -->
<div class="card mb-4">
  <div class="card-header">
    <h4>Eligibility/Professional License</h4>
  </div>
  <div class="card-body">
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

    <!-- Loop through the result set and display existing data as read-only -->
    <?php if ($result_license->num_rows > 0): ?>
      <?php while ($row_license = $result_license->fetch_assoc()): ?>
        <div class="row mb-3">
          <div class="col-md-3">
            <!-- Display existing eligibility -->
            <p><?php echo htmlspecialchars($row_license['eligibility']); ?></p>
            <input type="hidden" name="existing_eligibility[]" value="<?php echo htmlspecialchars($row_license['eligibility']); ?>">
          </div>
          <div class="col-md-2">
            <!-- Display existing rating -->
            <p><?php echo htmlspecialchars($row_license['rating']); ?></p>
            <input type="hidden" name="existing_rating[]" value="<?php echo htmlspecialchars($row_license['rating']); ?>">
          </div>
          <div class="col-md-3">
            <!-- Display existing date of examination -->
            <p><?php echo htmlspecialchars($row_license['doe']); ?></p>
            <input type="hidden" name="existing_doe[]" value="<?php echo htmlspecialchars($row_license['doe']); ?>">
          </div>
          <div class="col-md-3">
            <!-- Display existing PRC path (with link to the file) -->
            <?php if (!empty($row_license['prc_path'])): ?>
              <a href="../../php/applicant/<?php echo htmlspecialchars($row_license['prc_path']); ?>" class="form-control" target="_blank">View License</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>

    <!-- Empty row for new inputs -->
    <div id="input-container">
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
          <button type="button" class="btn btn-danger" onclick="removeInputGroup(this)">Remove</button>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 text-right">
        <button type="button" class="btn btn-primary" onclick="addInputGroup()">Add Another Set</button>
      </div>
    </div>
  </div>
</div>


<!-- Work Experience Card -->
<div class="card mb-4">
  <div class="card-header">
    <h4>Work Experience (Limit to 10-year period)</h4>
  </div>
  <div class="card-body">
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

    <!-- Loop through existing work experience data from the database -->
    <?php if ($result_work_exp->num_rows > 0): ?>
      <?php while ($row_work_exp = $result_work_exp->fetch_assoc()): ?>
        <div class="row mb-3">
          <div class="col-md-2">
            <p><?php echo htmlspecialchars($row_work_exp['company_name']); ?></p>
            <input type="hidden" name="existing_company[]" value="<?php echo htmlspecialchars($row_work_exp['company_name']); ?>">
          </div>
          <div class="col-md-3">
            <p><?php echo htmlspecialchars($row_work_exp['address']); ?></p>
            <input type="hidden" name="existing_address[]" value="<?php echo htmlspecialchars($row_work_exp['address']); ?>">
          </div>
          <div class="col-md-2">
            <p><?php echo htmlspecialchars($row_work_exp['position']); ?></p>
            <input type="hidden" name="existing_position[]" value="<?php echo htmlspecialchars($row_work_exp['position']); ?>">
          </div>
          <div class="col-md-3 text-center">
            <p><?php echo htmlspecialchars($row_work_exp['started_date']); ?> to <?php echo htmlspecialchars($row_work_exp['termination_date']); ?></p>
            <input type="hidden" name="existing_start_date[]" value="<?php echo htmlspecialchars($row_work_exp['started_date']); ?>">
            <input type="hidden" name="existing_end_date[]" value="<?php echo htmlspecialchars($row_work_exp['termination_date']); ?>">
          </div>
          <div class="col-md-2">
            <p><?php echo htmlspecialchars($row_work_exp['status']); ?></p>
            <input type="hidden" name="existing_status[]" value="<?php echo htmlspecialchars($row_work_exp['status']); ?>">
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>

    <!-- Empty row for new inputs -->
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
        <div class="col-md-1 text-center">
          <button type="button" class="btn btn-danger" onclick="removeWorkExperienceGroup(this)">Remove</button>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 text-right">
        <button type="button" class="btn btn-primary" onclick="addWorkExperienceGroup()">Add Another Work Experience Set</button>
      </div>
    </div>
  </div>
</div>


<!-- Other Skills Acquired Without Formal Training Card -->
<div class="card mb-4">
  <div class="card-header">
    <h4>Other Skills Acquired Without Formal Training</h4>
  </div>
  <div class="card-body">
    <label for="dynamicSelect">Choose one or more options:</label>
    <select id="dynamicSelect" name="other_skills[]" multiple class="form-select">
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

    <div id="newOptionContainer" class="mt-3">
      <input type="text" id="newOption" placeholder="Enter new option" class="form-control mb-2">
      <button id="addButton" type="button" class="btn btn-primary">Add Option</button>
    </div>

    <input type="hidden" name="selectedOptions" id="selectedOptionsHidden">
    <div id="selectedOptionsContainer" class="mt-3">
      <h5>Selected Options:</h5>
      <ul id="selectedOptionsList">
        <?php if (!empty($otherSkills)): ?>
          <?php foreach ($otherSkills as $skill): ?>
            <li><?php echo htmlspecialchars(trim($skill)); ?></li>
          <?php endforeach; ?>
        <?php else: ?>
          <li>No skills found.</li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>

<!-- Submit Button -->
<div class="row">
  <div class="col-md-12 text-right">
    <input class="btn btn-primary" type="submit" value="Submit">
  </div>
</div>
<div class="row mt-4">
    <div class="col-md-12 text-right">
        <a href="generate_resume.php" class="btn btn-primary" target="_blank">Generate Resume</a>
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

<!-- JavaScript to toggle fields -->
<script>
    // Toggle undergraduate fields for tertiary section
    document.getElementById('terUndergradCheck').addEventListener('change', function () {
        var undergradFields = document.getElementById('terUndergradFields');
        undergradFields.style.display = this.checked ? 'block' : 'none';
    });

    // Toggle undergraduate fields for graduate section
    document.getElementById('gradUndergradCheck').addEventListener('change', function () {
        var gradUndergradFields = document.getElementById('gradUndergradFields');
        gradUndergradFields.style.display = this.checked ? 'block' : 'none';
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../../javascript/a_profile.js"></script> 
    
<script src="../../javascript/script.js"></script> 
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
</form>
</body>
</html>