<?php
include '../conn_db.php';

// Get data from the POST request
$customer_id = $_POST['customer_id'];
$message = $_POST['message'];

// Insert message into the database
$sql = "INSERT INTO chat_messages (user_id, message, sender) VALUES ('$customer_id', '$message', 'user')";
if ($conn->query($sql) === TRUE) {
    echo "Message sent";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
