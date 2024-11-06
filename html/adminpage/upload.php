<?php
// Database connection
include 'conn_db.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    $description = $_POST['desc'];
    $videoLink = $_POST['link'];
    $modules_id = $_POST['mod_id'];
    $course_id = $_POST['course_id'];

    // Directory to upload files
    $uploadDir = "uploads/";

    // Create the directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Process each file
    foreach ($_FILES['files']['name'] as $key => $filename) {
        $targetFilePath = $uploadDir . basename($filename);

        // Upload file to server
        if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $targetFilePath)) {
            // Check if record already exists
            $checkSql = "SELECT * FROM module_content WHERE modules_id = '$modules_id'";
            $result = $conn->query($checkSql);

            if ($result->num_rows > 0) {
                // Update existing record
                $updateSql = "UPDATE module_content 
                              SET description = '$description', 
                                  file_path = '$targetFilePath', 
                                  video = '$videoLink' 
                              WHERE modules_id = '$modules_id'";

                if ($conn->query($updateSql) === TRUE) {
                    echo "<script type='text/javascript'> alert('File has been updated and saved to the database'); window.location.href='module_list.php?course_id=" . $course_id . "'; </script>";
                } else {
                    echo "Database error: " . $conn->error . "<br>";
                }
            } else {
                // Insert new record
                $insertSql = "INSERT INTO module_content (modules_id, description, file_path, video) 
                              VALUES ('$modules_id', '$description', '$targetFilePath', '$videoLink')";

                if ($conn->query($insertSql) === TRUE) {
                    echo "<script type='text/javascript'> alert('File has been uploaded and saved to the database'); window.location.href='module_list.php?course_id=" . $course_id . "'; </script>";
                } else {
                    echo "Database error: " . $conn->error . "<br>";
                }
            }
        } else {
            echo "Error uploading file: " . htmlspecialchars(basename($filename)) . "<br>";
        }
    }
}

$conn->close();
?>
