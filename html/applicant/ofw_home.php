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
  <link rel="stylesheet" href="../../css/ofw_home.css">
  <link rel="stylesheet" href="../../css/nav_float.css">
</head>

<body data-bs-spy="scroll" data-bs-target="#scrollspy-menu" data-bs-offset="175">

<!-- Navigation -->
<nav class="ofw-nav">
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#">PESO-lb.ph</a>
    </div>
    <label class="burger" for="burger">
        <input type="checkbox" id="burger">
        <span></span>
        <span></span>
        <span></span>
    </label>
    <ul class="menu">
        <li><a href="../../index(applicant).php">Home</a></li>
        <li><a href="applicant.php">Applicant</a></li>
        <li><a href="training_list.php">Training</a></li>
        <li><a href="#" class="active">OFW</a></li>
        <li><a href="../../html/about.php">About Us</a></li>
        <li><a href="../../html/contact.php">Contact Us</a></li>
    </ul>
    <div class="auth">
        <button class="ofw-btn" id="emprof"><?php echo htmlspecialchars($row_new['username']); ?></button>
    </div>
</nav>

<header>
    <h1 class="ofw-h1">File a Case</h1>
</header>

<div class="outer-container">
    <div class="container-fluid">
        <!-- Scrollspy Menu -->
        <nav id="scrollspy-menu" class="scrollspy flex-column">
            <a class="nav-link" href="#section1">Personal Information</a>
            <a class="nav-link" href="#section2">Family Information</a>
            <a class="nav-link" href="#section3">Employment Details</a>
        </nav>

        <!-- Form Content -->
        <div class="form-content">
            <form action="../../php/applicant/of.php" method="POST">

        
        <!-- Personal Information -->
<div id="section1" class="input-group">
  <h4>Personal Information</h4>
  <table>
    <tr>
      <td>
        <label for="firstName" class="info">First Name</label>
        <input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo isset($row['first_name']) ? htmlspecialchars($row['first_name']) : ''; ?>" placeholder=" " required>
      </td>
      <td>
        <label for="middleName" class="info">Middle Name</label>
        <input type="text" id="middleName" name="middleName" class="form-control" value="<?php echo isset($row['middle_name']) ? htmlspecialchars($row['middle_name']) : ''; ?>">
      </td>
      <td>
        <label for="lastName" class="info">Last Name</label>
        <input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo isset($row['last_name']) ? htmlspecialchars($row['last_name']) : ''; ?>" required>
      </td>
      <td>
        <label for="Prefix" class="info">Prefix</label>
        <select class="form-select" id="Prefix" name="Prefix">
          <option value="">Optional</option>
          <?php
            $prefixes = ['Sr.', 'Jr.', 'II', 'III', 'IV', 'V', 'VI', 'VII'];
            foreach ($prefixes as $prefix) {
                echo "<option value='$prefix'" . (isset($row['prefix']) && $row['prefix'] == $prefix ? ' selected' : '') . ">$prefix</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="house">
        <label for="houseadd" class="info">House Address</label>
        <input type="text" id="houseadd" name="houseadd" class="form-control h1ouse-info"
        placeholder="House no. / Street / Subdivision / Barangay / City or Municipality / Province"
        value="<?php echo isset($row['house_address']) ? htmlspecialchars($row['house_address']) : ''; ?>" required>
      </td>
    </tr>
    <tr>
      <td>
        <label for="sex" class="info">Sex</label>
        <select class="form-select" id="sex" name="sex" required>
          <option value="Male" <?php echo (isset($row['sex']) && $row['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
          <option value="Female" <?php echo (isset($row['sex']) && $row['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select>
      </td>
      <td>
        <label for="civilStatus" class="info">Civil Status</label>
        <select class="form-select" id="civilStatus" name="civilStatus" required>
          <option value="Single" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Single') ? 'selected' : ''; ?>>Single</option>
          <option value="Married" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
          <option value="Widowed" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
          <option value="Separated" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Separated') ? 'selected' : ''; ?>>Separated</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        <label for="age" class="info">Age</label>
        <input type="number" id="age" name="age" class="form-control" value="<?php echo isset($row['age']) ? htmlspecialchars($row['age']) : ''; ?>" required>
      </td>
      <td>
        <label for="dob" class="info">Date of Birth</label>
        <input type="date" id="dob" name="dob" class="form-control" value="<?php echo isset($row['dob']) ? htmlspecialchars($row['dob']) : ''; ?>" required>
      </td>
      <td>
        <label for="contactNo" class="info">Contact No.</label>
        <input type="tel" id="contactNo" name="contactNo" class="form-control" value="<?php echo isset($row['contact_no']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
      </td>
    </tr>
    <tr>
      <td>
        <label for="sssNo" class="info">SSS No.</label>
        <input type="text" id="sssNo" name="sssNo" class="form-control" value="<?php echo isset($row['sss_no']) ? htmlspecialchars($row['sss_no']) : ''; ?>">
      </td>
      <td>
        <label for="pagibigNo" class="info">Pag-IBIG No.</label>
        <input type="text" id="pagibigNo" name="pagibigNo" class="form-control" value="<?php echo isset($row['pagibig_no']) ? htmlspecialchars($row['pagibig_no']) : ''; ?>">
      </td>
      <td>
        <label for="philhealthNo" class="info">PhilHealth No.</label>
        <input type="text" id="philhealthNo" name="philhealthNo" class="form-control" value="<?php echo isset($row['philhealth_no']) ? htmlspecialchars($row['philhealth_no']) : ''; ?>">
      </td>
    </tr>
    <tr>
      <td>
        <label for="passportNo" class="info">Passport Number</label>
        <input type="text" id="passportNo" name="passportNo" class="form-control" value="<?php echo isset($row['passport_no']) ? htmlspecialchars($row['passport_no']) : ''; ?>">
      </td>
      <td>
        <label for="email" class="info">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>" required>
      </td>
    </tr>
    <tr>
      <td>
        <label for="immigrationStatus" class="info">Immigration Status</label>
        <select class="form-select" id="immigrationStatus" name="immigrationStatus" required>
          <option value="Documented" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Documented') ? 'selected' : ''; ?>>Documented</option>
          <option value="Undocumented" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Undocumented') ? 'selected' : ''; ?>>Undocumented</option>
          <option value="Returning" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Returning') ? 'selected' : ''; ?>>Returning (finish contract)</option>
          <option value="Repatriated" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Repatriated') ? 'selected' : ''; ?>>Repatriated</option>
        </select>
      </td>
      <td>
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
      </td>
    </tr>
  </table>
</div>


        <!-- Family Information -->
<div id="section2" class="input-group">
  <h4>Family Information</h4>
  <table>
    <tr>
      <td>
        <label for="spouseName" class="info">Spouse's Name</label>
        <input type="text" id="spouseName" name="spouseName" class="form-control" value="<?php echo isset($row['spouse_name']) ? htmlspecialchars($row['spouse_name']) : ''; ?>">
      </td>
      <td>
        <label for="spouseContact" class="info">Spouse's Contact No.</label>
        <input type="text" id="spouseContact" name="spouseContact" class="form-control" value="<?php echo isset($row['spouse_contact']) ? htmlspecialchars($row['spouse_contact']) : ''; ?>">
      </td>
    </tr>
    <tr>
      <td>
        <label for="fathersName" class="info">Father's Name</label>
        <input type="text" id="fathersName" name="fathersName" class="form-control" value="<?php echo isset($row['fathers_name']) ? htmlspecialchars($row['fathers_name']) : ''; ?>">
      </td>
      <td>
        <label for="fathersAddress" class="info">Father's Address</label>
        <input type="text" id="fathersAddress" name="fathersAddress" class="form-control" value="<?php echo isset($row['fathers_address']) ? htmlspecialchars($row['fathers_address']) : ''; ?>">
      </td>
    </tr>
    <tr>
      <td>
        <label for="mothersName" class="info">Mother's Name</label>
        <input type="text" id="mothersName" name="mothersName" class="form-control" value="<?php echo isset($row['mothers_name']) ? htmlspecialchars($row['mothers_name']) : ''; ?>">
      </td>
      <td>
        <label for="mothersAddress" class="info">Mother's Address</label>
        <input type="text" id="mothersAddress" name="mothersAddress" class="form-control" value="<?php echo isset($row['mothers_address']) ? htmlspecialchars($row['mothers_address']) : ''; ?>">
      </td>
    </tr>
    <tr>
      <td>
        <label for="emergencyContactName" class="info">In Case of Emergency, Contact Person</label>
        <input type="text" id="emergencyContactName" name="emergencyContactName" class="form-control" value="<?php echo isset($row['emergency_contact_name']) ? htmlspecialchars($row['emergency_contact_name']) : ''; ?>">
      </td>
      <td>
        <label for="emergencyContactNum" class="info">Contact No.</label>
        <input type="text" id="emergencyContactNum" name="emergencyContactNum" class="form-control" value="<?php echo isset($row['emergency_contact_num']) ? htmlspecialchars($row['emergency_contact_num']) : ''; ?>">
      </td>
    </tr>
    <tr>
      <td>
        <label for="nextOfKinRelationship" class="info">Relationship to Next of Kin</label>
        <input type="text" id="nextOfKinRelationship" name="nextOfKinRelationship" class="form-control" placeholder="Relationship" value="<?php echo isset($row['next_of_kin_relationship']) ? htmlspecialchars($row['next_of_kin_relationship']) : ''; ?>">
      </td>
    </tr>
    <tr>
      <td>
        <label for="nextOfKinContact" class="info">Next of Kin's Contact Number</label>
        <input type="text" id="nextOfKinContact" name="nextOfKinContact" class="form-control" placeholder="Contact Number" value="<?php echo isset($row['next_of_kin_contact']) ? htmlspecialchars($row['next_of_kin_contact']) : ''; ?>">
      </td>
    </tr>
  </table>
</div>
        <!-- Employment Details -->
<div id="section3" class="input-group">
  <h4>Employment Details</h4>
  <table>
    <tr>
      <td>
        <label for="occupation" class="info">Occupation Abroad</label>
        <select id="occupation" name="occupation" class="form-select" required>
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
      </td>
      <td>
        <label for="income" class="info">Average Income Per Month</label>
        <input type="number" id="income" name="income" class="form-control" placeholder="Enter average income" value="<?php echo isset($row['income']) ? htmlspecialchars($row['income']) : ''; ?>" required>
      </td>
    </tr>
    <tr>
      <td>
        <label for="employmentType" class="info">Land-Based or Sea-Based</label>
        <select id="employmentType" name="employment_type" class="form-select" required>
          <option value="">-- Select Employment Type --</option>
          <option value="Land-Based" <?php echo (isset($row['employment_type']) && $row['employment_type'] == 'Land-Based') ? 'selected' : ''; ?>>Land-Based</option>
          <option value="Sea-Based" <?php echo (isset($row['employment_type']) && $row['employment_type'] == 'Sea-Based') ? 'selected' : ''; ?>>Sea-Based</option>
        </select>
      </td>
      <td>
        <label for="country" class="info">Country of Destination</label>
        <input type="text" id="country" name="country" class="form-control" placeholder="Enter country" value="<?php echo isset($row['country']) ? htmlspecialchars($row['country']) : ''; ?>" required>
      </td>
    </tr>
    <tr>
      <td>
        <label for="employmentForm" class="info">Forms of Employment</label>
        <select id="employmentForm" name="employment_form" class="form-select" required>
          <option value="">-- Select Form of Employment --</option>
          <option value="Recruitment Agency" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Recruitment Agency') ? 'selected' : ''; ?>>Recruitment Agency</option>
          <option value="Government Hire" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Government Hire') ? 'selected' : ''; ?>>Government Hire</option>
          <option value="Name Hire" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Name Hire') ? 'selected' : ''; ?>>Name Hire</option>
          <option value="Referral" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Referral') ? 'selected' : ''; ?>>Referral</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        <label for="employerName" class="info">Name of Employer/Company</label>
        <input type="text" id="employerName" name="employer_name" class="form-control" placeholder="Enter employer/company name" value="<?php echo isset($row['employer_name']) ? htmlspecialchars($row['employer_name']) : ''; ?>" required>
      </td>
      <td>
        <label for="contactNumber" class="info">Contact Number</label>
        <input type="text" id="contactNumber" name="contact_number" class="form-control" placeholder="Enter contact number" value="<?php echo isset($row['contact_number']) ? htmlspecialchars($row['contact_number']) : ''; ?>" required>
      </td>
    </tr>
    <tr>
      <td>
        <label for="employerAddress" class="info">Address of Employer/Company</label>
        <input type="text" id="employerAddress" name="employer_address" class="form-control" placeholder="Enter employer/company address" value="<?php echo isset($row['employer_address']) ? htmlspecialchars($row['employer_address']) : ''; ?>" required>
      </td>
    </tr>
    <tr>
      <td>
        <label for="localAgencyName" class="info">Name of Local Agency</label>
        <input type="text" id="localAgencyName" name="local_agency_name" class="form-control" placeholder="Enter local agency name" value="<?php echo isset($row['local_agency_name']) ? htmlspecialchars($row['local_agency_name']) : ''; ?>" required>
      </td>
    </tr>
    <tr>
      <td>
        <label for="localAgencyAddress" class="info">Address of Local Agency</label>
        <input type="text" id="localAgencyAddress" name="local_agency_address" class="form-control" placeholder="Enter local agency address" value="<?php echo isset($row['local_agency_address']) ? htmlspecialchars($row['local_agency_address']) : ''; ?>" required>
      </td>
    </tr>
    <tr>
      <td>
        <label for="departureDate" class="info">Date of Departure from the Philippines</label>
        <input type="date" id="departureDate" name="departure_date" class="form-control" value="<?php echo isset($row['departure_date']) ? htmlspecialchars($row['departure_date']) : ''; ?>" required>
      </td>
      <td>
        <label for="arrivalDate" class="info">Date of Arrival (If Applicable)</label>
        <input type="date" id="arrivalDate" name="arrival_date" class="form-control" value="<?php echo isset($row['arrival_date']) ? htmlspecialchars($row['arrival_date']) : ''; ?>">
      </td>
    </tr>
  </table>
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
</div>


<script src="../../javascript/script.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
