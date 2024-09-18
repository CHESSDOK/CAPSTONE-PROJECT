<?php
include '../../php/conn_db.php';
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
        header("Location: html/login_employer.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}

// $user_id = checkSession();
// Get user_id from URL
// Fetch documents for the selected employer
$user_id = $_GET['user_id'];

$sql = "SELECT * FROM applicant_profile WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Employer Documents</title>
</head>
<body>
    <h1>Documents for Employer ID: <?php echo htmlspecialchars($user_id); ?></h1>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Contact number</th>
            <th>address</th>
            <th>specialization</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $fullname = $row['last_name'] . ", " . $row['first_name'] . " " . $row['middle_name'];
                echo "<tr>
                        <td>" . $fullname . "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                        <td>" . htmlspecialchars($row["age"]) . "</td>
                        <td>" . htmlspecialchars($row["sex"]) . "</td>
                        <td>" . htmlspecialchars($row["contact_no"]) . "</td>
                        <td>" . htmlspecialchars($row["house_no"]) . "</td>
                        <td>" . htmlspecialchars($row["specialization"]) . "</td>
                        <td><a href='../../php/employer/application_process.php?id=" . $row['user_id'] . "'>accepted</a></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No documents found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
