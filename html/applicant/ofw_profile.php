<?php
// Include database connection
include '../../php/conn_db.php';

function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['id'])) {
        header("Location: ../login.html");
        exit();
    } else {
        return $_SESSION['id'];
    }
}

$userId = checkSession();

// Fetch data from applicant_profile table
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

// Fetch data from register table
$sql_new = "SELECT * FROM register WHERE id = ?";
$stmt_new = $conn->prepare($sql_new);
$stmt_new->bind_param("i", $userId);
$stmt_new->execute();
$result_new = $stmt_new->get_result();

$row_new = ($result_new->num_rows > 0) ? $result_new->fetch_assoc() : array(); // Fetch the data or initialize empty array

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="../../css/ofw_profile.css">
    <link rel="stylesheet" href="../../css/nav_float.css">
</head>

<body data-bs-spy="scroll" data-bs-target="#scrollspy-menu" data-bs-offset="175">

<!-- Navigation -->
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#">PESO-lb.ph</a>
    </div>

    <header>
        <h1 class="h1">Update Information</h1>
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
                <tr><td><a href="#" class="active nav-link">OFW</a></td></tr>
                <tr><td><a href="../../html/about.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="../../html/contact.php" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="../../index(applicant).php" >Home</a></li>
        <li class="breadcrumb-item"><a href="ofw_form.php" >OFW Form</a></li>
        <li class="breadcrumb-item active" aria-current="page">OFW Profile</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

<div class="profile-container">
<div class="form-content">
<!-- Form Content -->
<form action="../../php/applicant/ofw_details.php" method="POST">
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

      <div class="row">
    <div class="col-md-3 mb-3">
        <label for="dob" class="info">Date of Birth</label>
        <input type="date" id="dob" name="dob" class="form-control" value="<?php echo isset($row['dob']) ? htmlspecialchars($row['dob']) : ''; ?>" required>
    </div>
    
    <div class="col-md-3 mb-3">
        <label for="sex" class="info">Sex</label>
        <select class="form-select" id="sex" name="sex" required>
            <option value="Male" <?php echo (isset($row['sex']) && $row['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo (isset($row['sex']) && $row['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label for="age" class="info">Age</label>
        <input type="number" id="age" name="age" class="form-control" value="<?php echo isset($row['age']) ? htmlspecialchars($row['age']) : ''; ?>" required>
    </div>

    <div class="col-md-3 mb-3">
        <label for="civilStatus" class="info">Civil Status</label>
        <select class="form-select" id="civilStatus" name="civilStatus" required>
            <option value="Single" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Single') ? 'selected' : ''; ?>>Single</option>
            <option value="Married" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
            <option value="Widowed" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
            <option value="Separated" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Separated') ? 'selected' : ''; ?>>Separated</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="houseadd" class="info">House Address</label>
        <input type="text" id="houseadd" name="houseadd" class="form-control h1ouse-info"
            placeholder="House no. / Street / Subdivision / Barangay / City or Municipality / Province"
            value="<?php echo isset($row['house_address']) ? htmlspecialchars($row['house_address']) : ''; ?>" required>
    </div>
    
    <div class="col-md-3 mb-3">
        <label for="contactNo" class="info">Contact No.</label>
        <input type="tel" id="contactNo" name="contactNo" class="form-control" value="<?php echo isset($row['contact_no']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
    </div>

    <div class="col-md-3 mb-3">
        <label for="email" class="info">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>" required>
    </div>
</div>

    
<div class="row">
    <div class="col-md-4 mb-3">
        <label for="sssNo" class="info">SSS No.</label>
        <input type="text" id="sssNo" name="sssNo" class="form-control" value="<?php echo isset($row['sss_no']) ? htmlspecialchars($row['sss_no']) : ''; ?>">
    </div>

    <div class="col-md-4 mb-3">
        <label for="pagibigNo" class="info">Pag-IBIG No.</label>
        <input type="text" id="pagibigNo" name="pagibigNo" class="form-control" value="<?php echo isset($row['pagibig_no']) ? htmlspecialchars($row['pagibig_no']) : ''; ?>">
    </div>

    <div class="col-md-4 mb-3">
        <label for="philhealthNo" class="info">PhilHealth No.</label>
        <input type="text" id="philhealthNo" name="philhealthNo" class="form-control" value="<?php echo isset($row['philhealth_no']) ? htmlspecialchars($row['philhealth_no']) : ''; ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="passportNo" class="info">Passport Number</label>
        <input type="text" id="passportNo" name="passportNo" class="form-control" value="<?php echo isset($row['passport_no']) ? htmlspecialchars($row['passport_no']) : ''; ?>">
    </div>

    <div class="col-md-4 mb-3">
        <label for="immigrationStatus" class="info">Immigration Status</label>
        <select class="form-select" id="immigrationStatus" name="immigrationStatus" required>
            <option value="Documented" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Documented') ? 'selected' : ''; ?>>Documented</option>
            <option value="Undocumented" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Undocumented') ? 'selected' : ''; ?>>Undocumented</option>
            <option value="Returning" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Returning') ? 'selected' : ''; ?>>Returning (finish contract)</option>
            <option value="Repatriated" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Repatriated') ? 'selected' : ''; ?>>Repatriated</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label for="educationLevel" class="info">Educational Attainment</label>
        <select id="educationLevel" name="education_level" class="form-select" required>
            <option value="">-- Select Educational Attainment --</option>
            <option value="Elementary Undergraduate" <?php echo (isset($row['education_level']) && $row['education_level'] == 'Elementary Undergraduate') ? 'selected' : ''; ?>>Elementary Undergraduate</option>
            <option value="Elementary Graduate" <?php echo (isset($row['education_level']) && $row['education_level'] == 'Elementary Graduate') ? 'selected' : ''; ?>>Elementary Graduate</option>
            <option value="High School Undergraduate" <?php echo (isset($row['education_level']) && $row['education_level'] == 'High School Undergraduate') ? 'selected' : ''; ?>>High School Undergraduate</option>
            <option value="High School Graduate" <?php echo (isset($row['education_level']) && $row['education_level'] == 'High School Graduate') ? 'selected' : ''; ?>>High School Graduate</option>
            <option value="College Undergraduate" <?php echo (isset($row['education_level']) && $row['education_level'] == 'College Undergraduate') ? 'selected' : ''; ?>>College Undergraduate</option>
            <option value="College Graduate" <?php echo (isset($row['education_level']) && $row['education_level'] == 'College Graduate') ? 'selected' : ''; ?>>College Graduate</option>
            <option value="Vocational" <?php echo (isset($row['education_level']) && $row['education_level'] == 'Vocational') ? 'selected' : ''; ?>>Vocational</option>
        </select>
    </div>
</div>


  <h4 class="mb-3">Family Information</h4>

  <div class="row">
    <div class="col-md-6 mb-3">
        <label for="spouseName" class="info">Spouse's Name</label>
        <input type="text" id="spouseName" name="spouseName" class="form-control" value="<?php echo isset($row['spouse_name']) ? htmlspecialchars($row['spouse_name']) : ''; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label for="spouseContact" class="info">Spouse's Contact No.</label>
        <input type="number" id="spouseContact" name="spouseContact" class="form-control" value="<?php echo isset($row['spouse_contact']) ? htmlspecialchars($row['spouse_contact']) : ''; ?>">
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 mb-3">
        <label for="fathersName" class="info">Father's Name</label>
        <input type="text" id="fathersName" name="fathersName" class="form-control" value="<?php echo isset($row['fathers_name']) ? htmlspecialchars($row['fathers_name']) : ''; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label for="fathersAddress" class="info">Father's Address</label>
        <input type="text" id="fathersAddress" name="fathersAddress" class="form-control" value="<?php echo isset($row['fathers_address']) ? htmlspecialchars($row['fathers_address']) : ''; ?>">
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 mb-3">
        <label for="mothersName" class="info">Mother's Name</label>
        <input type="text" id="mothersName" name="mothersName" class="form-control" value="<?php echo isset($row['mothers_name']) ? htmlspecialchars($row['mothers_name']) : ''; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label for="mothersAddress" class="info">Mother's Address</label>
        <input type="text" id="mothersAddress" name="mothersAddress" class="form-control" value="<?php echo isset($row['mothers_address']) ? htmlspecialchars($row['mothers_address']) : ''; ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="emergencyContactName" class="info">In Case of Emergency, Contact Person</label>
        <input type="text" id="emergencyContactName" name="emergencyContactName" class="form-control" value="<?php echo isset($row['emergency_contact_name']) ? htmlspecialchars($row['emergency_contact_name']) : ''; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label for="emergencyContactNum" class="info">Contact No.</label>
        <input type="number" id="emergencyContactNum" name="emergencyContactNum" class="form-control" value="<?php echo isset($row['emergency_contact_num']) ? htmlspecialchars($row['emergency_contact_num']) : ''; ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nextOfKinRelationship" class="info">Relationship to Next of Kin</label>
        <input type="text" id="nextOfKinRelationship" name="nextOfKinRelationship" class="form-control" value="<?php echo isset($row['next_of_kin_relationship']) ? htmlspecialchars($row['next_of_kin_relationship']) : ''; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label for="nextOfKinContact" class="info">Next of Kin's Contact Number</label>
        <input type="number" id="nextOfKinContact" name="nextOfKinContact" class="form-control" value="<?php echo isset($row['next_of_kin_contact']) ? htmlspecialchars($row['next_of_kin_contact']) : ''; ?>">
    </div>
</div>

  <h4 class="mb-3">Employment Details</h4>

  <div class="row">
    <div class="col-md-3 mb-3">
        <label for="occupation" class="info">Occupation Abroad</label>
        <select id="occupation" name="occupation" class="form-control" required>
            <option value="">-- Select Occupation --</option>
            <option value="Administrative Work" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Administrative Work') ? 'selected' : ''; ?>>Administrative Work</option>
            <option value="Medical Work" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Medical Work') ? 'selected' : ''; ?>>Medical Work</option>
            <option value="Factory/Manufacturing" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Factory/Manufacturing') ? 'selected' : ''; ?>>Factory/Manufacturing</option>
            <option value="Farmers (Agriculture)" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Farmers (Agriculture)') ? 'selected' : ''; ?>>Farmers (Agriculture)</option>
            <option value="Teaching" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Teaching') ? 'selected' : ''; ?>>Teaching</option>
            <option value="Information Technology" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Information Technology') ? 'selected' : ''; ?>>Information Technology</option>
            <option value="Engineering" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
            <option value="Restaurant Jobs (F&B)" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Restaurant Jobs (F&B)') ? 'selected' : ''; ?>>Restaurant Jobs (F&B)</option>
            <option value="Seaman (Sea-Based)" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Seaman (Sea-Based)') ? 'selected' : ''; ?>>Seaman (Sea-Based)</option>
            <option value="Household Service Worker (Domestic Helper)" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Household Service Worker (Domestic Helper)') ? 'selected' : ''; ?>>Household Service Worker (Domestic Helper)</option>
            <option value="Construction Work" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Construction Work') ? 'selected' : ''; ?>>Construction Work</option>
            <option value="Entertainment" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Entertainment') ? 'selected' : ''; ?>>Entertainment</option>
            <option value="Tourism Sector" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Tourism Sector') ? 'selected' : ''; ?>>Tourism Sector</option>
            <option value="Hospitality Sector" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Hospitality Sector') ? 'selected' : ''; ?>>Hospitality Sector</option>
            <option value="Others" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Others') ? 'selected' : ''; ?>>Others</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label for="income" class="info">Average Income Per Month</label>
        <input type="number" id="income" name="income" class="form-control" value="<?php echo isset($row['income']) ? htmlspecialchars($row['income']) : ''; ?>" required>
    </div>

    <div class="col-md-3 mb-3">
        <label for="employmentType" class="info">Land-Based or Sea-Based</label>
        <select id="employmentType" name="employment_type" class="form-control" required>
            <option value="">-- Select Employment Type --</option>
            <option value="Land-Based" <?php echo (isset($row['employment_type']) && $row['employment_type'] == 'Land-Based') ? 'selected' : ''; ?>>Land-Based</option>
            <option value="Sea-Based" <?php echo (isset($row['employment_type']) && $row['employment_type'] == 'Sea-Based') ? 'selected' : ''; ?>>Sea-Based</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label for="country" class="info">Country of Destination</label>
        <input type="text" id="country" name="country" class="form-control" value="<?php echo isset($row['country']) ? htmlspecialchars($row['country']) : ''; ?>" required>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="employmentForm" class="info">Forms of Employment</label>
        <select id="employmentForm" name="employment_form" class="form-control" required>
            <option value="">-- Select Form of Employment --</option>
            <option value="Recruitment Agency" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Recruitment Agency') ? 'selected' : ''; ?>>Recruitment Agency</option>
            <option value="Government Hire" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Government Hire') ? 'selected' : ''; ?>>Government Hire</option>
            <option value="Name Hire" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Name Hire') ? 'selected' : ''; ?>>Name Hire</option>
            <option value="Referral" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Referral') ? 'selected' : ''; ?>>Referral</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="contactNumber" class="info">Contact Number</label>
        <input type="text" id="contactNumber" name="contact_number" class="form-control" value="<?php echo isset($row['contact_number']) ? htmlspecialchars($row['contact_number']) : ''; ?>" required>
    </div>
</div>


<div class="row">
    <div class="col-md-6 mb-3">
        <label for="employerName" class="info">Name of Employer/Company</label>
        <input type="text" id="employerName" name="employer_name" class="form-control" value="<?php echo isset($row['employer_name']) ? htmlspecialchars($row['employer_name']) : ''; ?>" required>
    </div>

    <div class="col-md-6 mb-3">
      <label for="employerAddress" class="info">Address of Employer/Company</label>
      <input type="text" id="employerAddress" name="employer_address" class="form-control" value="<?php echo isset($row['employer_address']) ? htmlspecialchars($row['employer_address']) : ''; ?>" required>
   </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="localAgencyName" class="info">Name of Local Agency</label>
        <input type="text" id="localAgencyName" name="local_agency_name" class="form-control" value="<?php echo isset($row['local_agency_name']) ? htmlspecialchars($row['local_agency_name']) : ''; ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="localAgencyAddress" class="info">Address of Local Agency</label>
        <input type="text" id="localAgencyAddress" name="local_agency_address" class="form-control" value="<?php echo isset($row['local_agency_address']) ? htmlspecialchars($row['local_agency_address']) : ''; ?>" required>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="departureDate" class="info">Date of Departure from the Philippines</label>
        <input type="date" id="departureDate" name="departure_date" class="form-control" value="<?php echo isset($row['dept_date']) ? htmlspecialchars($row['dept_date']) : ''; ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="arrivalDate" class="info">Date of Arrival (If Applicable)</label>
        <input type="date" id="arrivalDate" name="arrival_date" class="form-control" value="<?php echo isset($row['arrival_date']) ? htmlspecialchars($row['arrival_date']) : ''; ?>">
    </div>
</div>

    <!-- Submit Button -->
    <button type="submit" style="margin-bottom:15px;" class="btn btn-primary">Update Profile</button>
</form>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="../../javascript/script.js"></script>
</body>
</html>
