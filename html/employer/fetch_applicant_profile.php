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
        <table class='table table-borderless'>
                        <thead class='thead-light'>
                            <th>Full Name</th>
                            <th>email</th>
                            <th>contact number</th>
                            <th>age</th>
                            <th class='action-btn'>Actions</th>
                        </thead>
                        <tr>
                                    <td style='width: 450px;'>".htmlspecialchars($full_name)."</td>
                                    <td style='width: 100px;'>" . htmlspecialchars($row['email']) . "</td>
                                    <td style='width: 50px;'>" . htmlspecialchars($row['contact_no']) . "</td>
                                    <td style='width: 50px;'>" . htmlspecialchars($row['age']) . "</td>
                        </tr>";
} else {
    echo "No profile found.";
}
?>
