<?php
require '../conn_db.php';  // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $userId = $_POST['userid'];  // Assume the user is logged in

    // Handle file upload
    $file = null;
    if (!empty($_FILES['file']['name'])) {
        $targetDir = "../uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $file = $targetFilePath;
        }
    }

    // Insert case into the database
    $stmt = $conn->prepare("INSERT INTO cases (user_id, title, description, file) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $userId, $title, $description, $file);
    if ($stmt->execute()) {
        echo "Case filed successfully!";
        header("Location: ../../html/applicant/ofw_form.php");
    } else {
        echo "Error filing case: " . $stmt->error;
    }
}
?>
