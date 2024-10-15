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
    while ($row = $result->fetch_assoc()) {
        $docverify = $row['is_verified'];
        
        echo "<tr>
                <td>" . htmlspecialchars($row["document_name"]) . "</td>
                <td><a class='btn btn-primary read-link' href='view_docs.php?file_path=" . htmlspecialchars($row["document_path"]) . "' target='_blank'>View Document</a></td>
                <td>";

        // Case 1: is_verified is NULL (Pending)
        if (is_null($docverify)) {
            echo "<a class='btn btn-success' href='verify_documents.php?id=" . $row['id'] . "&user_id=" . $user_id . "'>Verify</a>";
            echo "</td><td>
                    <form action='reject_documents.php' method='post'>
                        <input type='hidden' name='doc_id' value='" . htmlspecialchars($row['id']) . "'>
                        <input type='hidden' name='user_id' value='" . htmlspecialchars($user_id) . "'>
                        <input type='text' name='comment' placeholder='Enter comment'>
                        <input class='btn btn-danger' type='submit' name='Reject' value='Reject'>
                    </form>
                  </td>
                  <td style='font-size:1.2em;color: orange;'>Pending</td>";

        // Case 2: is_verified is 'verified'
        } elseif ($docverify == 'verified') {
            echo "<span style='color: green;'>Verified</span></td><td></td>
                  <td style='font-size:1.2em;color: green;'>Verified</td>";

        // Case 3: is_verified is 'updated'
        } elseif ($docverify == 'updated') {
            echo "<a class='btn btn-success' href='verify_documents.php?id=" . $row['id'] . "&user_id=" . $user_id . "'>Verify</a>";
            echo "</td><td>
                    <form action='reject_documents.php' method='post'>
                        <input type='hidden' name='doc_id' value='" . htmlspecialchars($row['id']) . "'>
                        <input type='hidden' name='user_id' value='" . htmlspecialchars($user_id) . "'>
                        <input type='text' name='comment' placeholder='Enter comment'>
                        <input class='btn btn-danger' type='submit' name='Reject' value='Reject'>
                    </form>
                  </td>
                  <td style='font-size:1.2em;color: blue;'>Updated</td>";

        // Case 4: is_verified is 'rejected' or any other value
        } else {
            echo "<span class='disabled-link btn btn-secondary'>Verify</span></td><td></td>
                  <td style='font-size:1.2em;color: red;'>Rejected</td>";
        }

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No documents found</td></tr>";
}
echo "</table>";

$conn->close();
?>
