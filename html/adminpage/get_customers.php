<?php
include 'conn_db.php';

// Fetch customers who have sent messages
$sql = "SELECT c.user_id, c.first_name, COUNT(m.id) AS message_count 
        FROM applicant_profile c 
        JOIN chat_messages m ON c.user_id = m.user_id 
        GROUP BY c.user_id, c.first_name
";


$result = $conn->query($sql);

$customers = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

echo json_encode($customers);

$conn->close();
?>
