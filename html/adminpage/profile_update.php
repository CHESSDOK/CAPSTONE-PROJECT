<?php
// Include database connection
include 'conn_db.php';  // Assuming you have a separate db connection file
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'level' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
        header("Location: login_admin.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}

$adminId = checkSession();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $fullName = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Check if a new profile picture was uploaded
    if (isset($_FILES['photoInput']) && $_FILES['photoInput']['error'] == 0) {
        // File upload handling
        $targetDir = "uploads/";
        $fileName = basename($_FILES['photoInput']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allow only specific file formats
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileType, $allowedTypes)) {
            // Upload the file
            if (move_uploaded_file($_FILES['photoInput']['tmp_name'], $targetFilePath)) {
                // File upload success, store file path in the database
                $profilePicture = $targetFilePath;
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type.";
        }
    }


    // Build the SQL query with or without the profile picture
    if (isset($profilePicture)) {
        $sql = "UPDATE admin_profile SET full_name = ?, email = ?, phone = ?, profile_picture = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $fullName, $email, $phone, $profilePicture, $adminId);
    } else {
        // If no new picture was uploaded, update everything except the profile picture
        $sql = "UPDATE admin_profile SET full_name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $fullName, $email, $phone, $adminId);
    }

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>
                alert('Job successfully updated!');
                window.location.href = 'admin_profile.php';
              </script>";
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
