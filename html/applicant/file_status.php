<?php 
  include '../../php/conn_db.php';
  function checkSession() {
      session_start(); // Start the session

      // Check if the session variable 'id' is set
      if (!isset($_SESSION['id'])) {
          // Redirect to login page if session not found
          header("Location: ../login.html");
          exit();
      } else {
          // If session exists, store the session data in a variable
          return $_SESSION['id'];
      }
  }
  $userId = checkSession();

$sql = "SELECT * FROM cases WHERE user_id = $userId ";
$result = $conn->query($sql);

// Start outputting HTML
echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>User Case List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Your Cases</h2>

<table>
    <thead>
        <tr>
            <th>Case ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Filed Date</th>
        </tr>
    </thead>
    <tbody>";

// Check if there are any cases for the user
if ($result->num_rows > 0) {
    // Output data for each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No cases found</td></tr>";
}

echo "
    </tbody>
</table>

</body>
</html>";

// Close database connection
$conn->close();
?>