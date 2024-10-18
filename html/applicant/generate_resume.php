<?php
include '../../php/conn_db.php'; // Database connection
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
 $preferred = isset($row['preferred_occupation']) ? explode(',', $row['preferred_occupation']) : '';
 $loc1 = isset($row['overseas_loc']) ? explode(',',$row['overseas_loc']) : ''; 
 $loc2 = isset($row['local_loc']) ? explode(',',$row['local_loc']) : ''; 
 $otherSkills = isset($row['selected_options']) ? explode(',', $row['selected_options']) : [];
 $uploadedImage = isset($row['photo']) ? $row['photo'] : '';  // Use the value from the database
 $imagePath = '../../php/applicant/images/' . $uploadedImage;  // Assuming this is the directory where the images are stored
 $uploadedResume = isset($row['resume']) ? $row['resume'] : '';  // Use the value from the database
 $resumePath = '../../php/applicant/resume/' . $uploadedResume;  // Assuming this is the directory where the images are stored
 $fullname =  $row['last_name']  . ', ' . $row['first_name']  . ' ' . $row['middle_name'];



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
<html>
<head>
    <title>Resume</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .resume-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .resume-section {
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
    </style>
</head>
<body>

<div class="resume">
    <div class="resume-header">
        <h1><?php echo htmlspecialchars($fullname); ?></h1>
        <p><?php echo htmlspecialchars($row['email']) . " | " . htmlspecialchars($row['contact_no']) . " | " . htmlspecialchars($row['house_address']); ?></p>
    </div>

    <div class="resume-section">
        <h2>Personal Information</h2>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($row['dob']); ?></p>
        <p><strong>Civil Status:</strong> <?php echo htmlspecialchars($row['civil_status']); ?></p>
    </div>

    <div class="resume-section">
        <h2>Work Experience</h2>
        <ul>
            <?php if ($result_work_exp->num_rows > 0): ?>
                <?php while ($row_work_exp = $result_work_exp->fetch_assoc()): ?>
                    <li><strong><?php echo htmlspecialchars($row_work_exp['position']); ?></strong> at <?php echo htmlspecialchars($row_work_exp['company_name']); ?> (<?php echo htmlspecialchars($row_work_exp['company_name']); ?> to <?php echo htmlspecialchars($row_work_exp['termination_date']); ?>)</li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No work experience found.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="resume-section">
        <h2>Education</h2>
    </div>

    <div class="resume-section">
        <h2>Skills</h2>
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

<script>
    window.print(); // Automatically trigger the print dialog
</script>

</body>
</html>
