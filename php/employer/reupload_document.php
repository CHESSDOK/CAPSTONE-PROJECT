<?php
include 'conn_db.php'; // Include the database connection

// Get the document ID and the new status from the form submission
$doc_id = intval($_POST['doc_id']);
$status = $_POST['status'];

// Handle the file upload
if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
    $file_name = $_FILES['document']['name'];
    $file_tmp = $_FILES['document']['tmp_name'];
    $upload_dir = 'uploads/'; // Specify the upload directory

    // Concatenate the upload directory with the file name for storing in the database
    $file_path = $upload_dir . $file_name;

    // Move the uploaded file to the server directory
    if (move_uploaded_file($file_tmp, $file_path)) {
        // Update the document status and path in the database
        $sql = "UPDATE employer_documents SET document_path = ?, is_verified = ?, comment = 'Document reuploaded' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $file_path, $status, $doc_id); // Using the full path ($file_path)

        if ($stmt->execute()) {
            echo "Document reuploaded and status updated successfully.";
            header("Location: ../../html/employer/employer_profile.php"); // Redirect back to the original page or modal
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "File upload failed.";
    }
} else {
    echo "No file uploaded or an error occurred.";
}

$conn->close();
?>
