<?php
include 'conn_db.php';

// Get data from the POST request
$customer_id = $_POST['customer_id'];
$message = $_POST['message'];

// Insert admin reply into the database
$sql = "INSERT INTO chat_messages (user_id, message, sender) VALUES ('$customer_id', '$message', 'admin')";
if ($conn->query($sql) === TRUE) {
    echo "Reply sent";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
