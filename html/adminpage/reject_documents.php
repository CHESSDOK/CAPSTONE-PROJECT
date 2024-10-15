<?php
include 'conn_db.php';

$user_id = $_POST['user_id'];
$document_id = $_POST['doc_id']; // Corrected the variable name to match the form input
$comment = $_POST['comment'];

// Escape the input to prevent SQL injection
$comment = $conn->real_escape_string($comment);

// Update the SQL query to include quotes around the comment and to correctly identify the document ID
$sql = "UPDATE employer_documents SET comment = '$comment', is_verified = 'rejected' WHERE id = '$document_id'";

if ($conn->query($sql) === TRUE) {
    echo "Comment sent!";
    header("Location: employer_list.php"); // Redirect to the list after successful update
    exit(); // Always exit after a redirect to stop further script execution
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
