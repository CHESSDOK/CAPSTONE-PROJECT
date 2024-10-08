<?php
include 'conn_db.php';

// Get user_id from URL
$user_id = intval($_GET['employer_id']);

// Fetch documents for the selected employer
$sql = "SELECT * FROM employer_documents WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
echo "
    <h2> Employer Documents </h2>
    <table class='table table-borderless table-hover'>
        <thead>
            <th>Document Name</th>
            <th>Document File</th>
            <th>Verification</th>
            <th>Status</th>
        </thead>

     ";
     if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $docverify =  $row['is_verified'];
            $active = ($docverify == 1) ? 'disabled-link' : '';

            echo "<tr>
                    <td>" . htmlspecialchars($row["document_name"]) . "</td>
                    <td><a class='docu' href='" . htmlspecialchars($row["document_path"]) . "' target='_blank'>View Document</a></td>
                    <td><a class='docu' href='verify_documents.php?id=" . $row['id'] . " & user_id=". $user_id." '>Verify</a></td>
                    <td><a class='docu ".$active."' href='reject_documents.php?id=" . $row['id'] . " & user_id=". $user_id."'>Reject</a></td>
                    <td style='color: " . (htmlspecialchars($row['is_verified']) ? 'green' : 'red') . ";'>" . (htmlspecialchars($row['is_verified']) ? 'Yes' : 'No') . "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No documents found</td></tr>";
    }
    $conn->close();
?>
