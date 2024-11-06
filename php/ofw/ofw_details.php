<?php
include '../../php/conn_db.php'; // Include your database connection

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

$userId = checkSession(); // Get the current user ID from session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $prefix = $_POST['Prefix'];
    $houseNo = $_POST['houseadd'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $contactNo = $_POST['contactNo'];
    $sex = $_POST['sex'];
    $civilStatus = $_POST['civilStatus'];
    $email = $_POST['email'];
    $sssNo = $_POST['sssNo'];
    $pagibigNo = $_POST['pagibigNo'];
    $philhealthNo = $_POST['philhealthNo'];
    $passportNo = $_POST['passportNo'];
    $immigrationStatus = $_POST['immigrationStatus'];
    $spouseName = $_POST['spouseName'];
    $spouseContact = $_POST['spouseContact'];
    $fathersName = $_POST['fathersName'];
    $fathersAddress = $_POST['fathersAddress'];
    $mothersName = $_POST['mothersName'];
    $mothersAddress = $_POST['mothersAddress'];
    $emergencyContactName = $_POST['emergencyContactName'];
    $emergencyContact = $_POST['emergencyContactNum'];
    $nextOfKinRelationship = $_POST['nextOfKinRelationship'];
    $nextOfKinContact = $_POST['nextOfKinContact'];
    $educationLevel = $_POST['education_level'];
    $occupation = $_POST['occupation'];
    $employername = $_POST['employer_name'];
    $income = $_POST['income'];
    $employmentType = $_POST['employment_type'];
    $destination = $_POST['country'];
    $employmentform = $_POST['employment_form'];
    $contactnumber = $_POST['contact_number'];
    $employeraddress = $_POST['employer_address'];
    $agencyname = $_POST['local_agency_name'];
    $agencyaddress = $_POST['local_agency_address'];
    $departure = $_POST['departure_date'];
    $arrival = $_POST['arrival_date'];

    $profile_image = $_POST['existing_image'] ?? ''; // Retain the existing image
    $resume = $_POST['existing_resume'] ?? '';       // Retain the existing resume
    $upload_dir = 'profile/';
    if (!empty($_FILES['profile_image']['name'])) {
        $profile_image = basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $profile_image);
    }

    // Prepare an SQL query to update the applicant_profile table
    $sql = "UPDATE ofw_profile SET 
    profile_image = ?, 
    last_name = ?, 
    first_name = ?, 
    middle_name = ?, 
    prefix = ?, 
    dob = ?, 
    sex = ?, 
    age = ?, 
    civil_status = ?, 
    house_address = ?, 
    contact_no = ?, 
    email = ?, 
    sss_no = ?, 
    pagibig_no = ?, 
    philhealth_no = ?, 
    passport_no = ?, 
    immigration_status = ?, 
    education_level = ?, 
    spouse_name = ?, 
    spouse_contact = ?, 
    fathers_name = ?, 
    fathers_address = ?, 
    mothers_name = ?, 
    mothers_address = ?, 
    emergency_contact_name = ?, 
    emergency_contact_num = ?, 
    next_of_kin_relationship = ?, 
    next_of_kin_contact = ?, 
    occupation = ?, 
    income = ?, 
    employment_type = ?, 
    country = ?, 
    employment_form = ?, 
    contact_number = ?,
    employer_name = ?,
    employer_address = ?,
    local_agency_name = ?,
    local_agency_address = ?,
    departure_date = ?,
    arrival_date = ?
    WHERE id = ?";                 // (35) Missing variable for id (userId)

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the query
        $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssi",
        $profile_image,          // Profile Image
        $lastName,              // last_name
        $firstName,             // first_name
        $middleName,            // middle_name
        $prefix,                // prefix
        $dob,                   // dob
        $sex,                   // sex
        $age,                   // age
        $civilStatus,           // civil_status
        $houseNo,          // house_address
        $contactNo,             // contact_no
        $email,                 // email
        $sssNo,                 // sss_no
        $pagibigNo,             // pagibig_no
        $philhealthNo,          // philhealth_no
        $passportNo,            // passport_no
        $immigrationStatus,     // immigration_status
        $educationLevel,        // education_level
        $spouseName,            // spouse_name
        $spouseContact,         // spouse_contact
        $fathersName,           // fathers_name
        $fathersAddress,        // fathers_address
        $mothersName,           // mothers_name
        $mothersAddress,        // mothers_address
        $emergencyContactName,  // emergency_contact_name
        $emergencyContact,      // emergency_contact_num
        $nextOfKinRelationship, // next_of_kin_relationship
        $nextOfKinContact,      // next_of_kin_contact
        $occupation,            // occupation
        $income,                // income
        $employmentType,        // employment_type
        $destination,           // country
        $employmentform,        // employment_form
        $contactnumber,         // contact_number
        $employername,
        $employeraddress,
        $agencyname,
        $agencyaddress,
        $departure,
        $arrival,           
        $userId                 // (35) id - assuming this is $userId
        );


        // Execute the query
        if ($stmt->execute()) {
            echo "Record updated successfully!";
            header("Location: ../../html/ofw/ofw_form.php"); // Redirect to a success page
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
