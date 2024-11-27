<?php
include 'conn_db.php';
session_start();

// Check if the user is a super admin
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'super_admin') {
    die("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']); // Sanitize input
    $sql = "DELETE FROM applicant_profile WHERE user_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            echo "Applicant deleted successfully.";
        } else {
            echo "Error deleting applicant: " . $conn->error;
        }
        $stmt->close();
    }
}

$conn->close();
header("Location: applicants_list.php"); // Redirect back to the list
exit();
?>
