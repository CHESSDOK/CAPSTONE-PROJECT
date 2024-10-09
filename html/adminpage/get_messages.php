<?php
include 'conn_db.php';

// Get customer ID from the GET request
$customer_id = $_GET['customer_id'];

// Fetch messages for the specified customer
$sql = "SELECT * FROM chat_messages WHERE user_id='$customer_id' ORDER BY timestamp ASC";
$result = $conn->query($sql);

$messages = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

echo json_encode($messages);

$conn->close();
?>
