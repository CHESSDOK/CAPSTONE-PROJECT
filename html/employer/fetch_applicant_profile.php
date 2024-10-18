<?php
include '../../php/conn_db.php';

$applicant_id = $_GET['applicant_id'];

$sql = "SELECT *, SUBSTRING(middle_name, 1, 1) AS middle_initial FROM applicant_profile WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $applicant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $full_name = $row['first_name'].  " " .$row['middle_initial']. ". " .$row['last_name'];

    echo "
<div class='container'>
    <div class='row'>
        <div class='col-md-6'>
            <label class='form-label'>Full Name:</label>
            <p class='form-text' style='font-size: 1.5rem;'>".htmlspecialchars($full_name)."</p>
        </div>
    </div>
    <div class='row'>
        <div class='col-md-6'>
            <label class='form-label'>Email:</label>
            <p class='form-text' style='font-size: 1.5rem;'>".htmlspecialchars($row['email'])."</p>
        </div>
    </div>
    
    <div class='row'>
        <div class='col-md-4'>
            <label class='form-label'>Contact Number:</label>
            <p class='form-text' style='font-size: 1.5rem;'>".htmlspecialchars($row['contact_no'])."</p>
        </div>
        <div class='col-md-4'>
            <label class='form-label'>Age:</label>
            <p class='form-text' style='font-size: 1.5rem;'>".htmlspecialchars($row['age'])."</p>
        </div>
    </div>
    
    <div class='row'>
        <div class='col-md-12'>
            <div class='d-flex justify-content-end'>
                <a href = 'view_resume.php?file_path=".htmlspecialchars($row['resume'])."' target='_blank' class='btn btn-primary btn-sm me-2'> View Resume</a>
            </div>  
        </div>
    </div>
</div>";

    

} else {
    echo "No profile found.";
}
?>
