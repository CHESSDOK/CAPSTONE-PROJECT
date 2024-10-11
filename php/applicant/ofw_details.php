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
    $gencyname = $_POST['local_agency_name'];
    $agencyaddress = $_POST['local_agency_address'];
    $departure = $_POST['departure_date'];
    $arrival = $_POST['arrival_date'];


    // Prepare an SQL query to update the applicant_profile table
    $sql = "UPDATE applicant_profile SET 
        first_name = ?, middle_name = ?, last_name = ?, age = ?,prefix = ?, dob = ?, contact_no = ?, 
        sex = ?, civil_status = ?, email = ?, house_address= ?, sss_no = ?, pagibig_no = ?, philhealth_no = ?, 
        passport_no = ?, immigration_status = ?, spouse_name = ?, spouse_contact = ?, fathers_name = ?, fathers_address = ?, mothers_name = ?, 
        mothers_address = ?,emergency_contact_name = ?, emergency_contact_num = ?, next_of_kin_relationship = ?, next_of_kin_contact = ?, education_level = ?, occupation = ?, 
        income = ?, employment_type = ?, employment_form = ?, employer_name = ?, contact_number = ?, employer_address = ?, local_agency_name = ?,
        local_agency_address = ?, arrival_date = ?, dept_date = ?, country = ?
        WHERE user_id = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the query
        $stmt->bind_param("sssisssssssiiiissssssssisississsissssssi",
            $firstName, $middleName, $lastName, $age, $prefix, $dob, $contactNo,
            $sex, $civilStatus, $email, $houseNo, $sssNo, $pagibigNo, $philhealthNo, 
            $passportNo, $immigrationStatus, $spouseName, $spouseContact, $fathersName, $fathersAddress, $mothersName, 
            $mothersAddress,$emergencyContactName, $emergencyContact, $nextOfKinRelationship, $nextOfKinContact, $educationLevel, $occupation, 
            $income, $employmentType, $employmentform, $employername, $contactnumber, $employeraddress, $gencyname,
            $agencyaddress, $arrival, $departure, $destination,
            $userId
        );

        // Execute the query
        if ($stmt->execute()) {
            echo "Record updated successfully!";
            header("Location: ../../html/applicant/ofw_form.php"); // Redirect to a success page
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
