<?php
include 'conn_db.php';

// Get the news ID from the POST request
$id = $_POST['id'];

// Delete the news item
$sql = "DELETE FROM news WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: manage_news.php");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
