<?php
include '../../php/conn_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize input data
    $id = $_POST['id'];
    $lastName = htmlspecialchars($_POST['lastName'] ?? '');
    $firstName = htmlspecialchars($_POST['firstName'] ?? '');
    $middleName = htmlspecialchars($_POST['middleName'] ?? '');
    $suffix = htmlspecialchars($_POST['Prefix'] ?? '');
    $dob = $_POST['dob'] ?? '';
    $pob = htmlspecialchars($_POST['pob'] ?? '');
    $religion = htmlspecialchars($_POST['religion'] ?? '');
    $houseadd = htmlspecialchars($_POST['houseadd'] ?? '');
    $civilStatus = htmlspecialchars($_POST['civilStatus'] ?? '');
    $sex = htmlspecialchars($_POST['sex'] ?? '');
    $height = htmlspecialchars($_POST['height'] ?? '');
    $tin = htmlspecialchars($_POST['tin'] ?? '');
    $sssNo = htmlspecialchars($_POST['sssNo'] ?? '');
    $pagibigNo = htmlspecialchars($_POST['pagibigNo'] ?? '');
    $philhealthNo = htmlspecialchars($_POST['philhealthNo'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $contactNo = htmlspecialchars($_POST['contactNo'] ?? '');
    $landline = htmlspecialchars($_POST['landline'] ?? '');
    $pwd = htmlspecialchars($_POST['pwd'] ?? '');
    $pwd2 = htmlspecialchars($_POST['pwd2'] ?? '');
    $fourPs = htmlspecialchars($_POST['four-ps-beneficiary'] ?? '');
    $employment_status = htmlspecialchars($_POST['employent_status'] ?? '');
    $actively_looking = htmlspecialchars($_POST['actively-looking'] ?? '');
    $willing_to_work = htmlspecialchars($_POST['willing-to-work'] ?? '');
    $passport = htmlspecialchars($_POST['passport_no'] ?? '');
    $passport_expiry = $_POST['passport_expiry'] ?? '';
    $salary = htmlspecialchars($_POST['salary'] ?? '');

    // Handling selectedOptions input (assuming it's a comma-separated string)
    $selectedOptions = $_POST['selectedOptions'] ?? ''; 
    $optionsArray = explode(',', $selectedOptions); // Convert it to an array
    $optionsString = implode(',', $optionsArray); // Convert it back to a string for saving into the database

    // Debugging output
    echo 'Selected Options: ' . $optionsString . '<br>';

    // Ensure the uploads directory exists
    $upload_dir = 'images/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory if not exists
    }

    // Handle the file uploads
    $profile_image = '';
    $resume = '';

    if (!empty($_FILES['profile_image']['name'])) {
        $profile_image = basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $profile_image);
    }

    if (!empty($_FILES['resume']['name'])) {
        $resume = basename($_FILES['resume']['name']);
        move_uploaded_file($_FILES['resume']['tmp_name'], $upload_dir . $resume);
    }

    // Update the database with the new information
    $sql = "UPDATE applicant_profile SET 
                last_name = ?, 
                first_name = ?, 
                middle_name = ?, 
                prefix = ?, 
                dob = ?, 
                pob = ?, 
                religion = ?, 
                house_address = ?, 
                civil_status = ?, 
                sex = ?, 
                height = ?, 
                tin = ?, 
                sss_no = ?, 
                pagibig_no = ?, 
                philhealth_no = ?, 
                email = ?, 
                contact_no = ?, 
                landline = ?, 
                pwd = ?, 
                pwd2 = ?, 
                four_ps = ?, 
                selected_options = ?, 
                employment_status = ?, 
                actively_looking = ?, 
                willing_to_work = ?, 
                passport_no = ?, 
                passport_expiry = ?, 
                expected_salary = ?,
                photo = IFNULL(?, photo),
                resume = IFNULL(?, resume)
            WHERE user_id = ?";

    // Note that we have 28 parameters in total
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssssssssssssssssssi",
        $lastName, $firstName, $middleName, $suffix, $dob, $pob, $religion, $houseadd, $civilStatus, $sex, $height, 
        $tin, $sssNo, $pagibigNo, $philhealthNo, $email, $contactNo, $landline, $pwd, $pwd2, $fourPs, $optionsString, 
        $employment_status, $actively_looking, $willing_to_work, $passport, $passport_expiry, 
        $salary, $profile_image, $resume, $id
    );

    if ($stmt->execute()) {
        echo "Record updated successfully!";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
