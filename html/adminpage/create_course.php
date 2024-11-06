<?php
include 'conn_db.php';
$course = $_POST['course'];
$description = $_POST['description'];
$numm = $_POST['module_count'];

// SQL query to insert data into the database
$sql = "INSERT INTO courses (course_name, description, module_count) VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $course, $description, $numm); // Assuming module_count is an integer

if ($stmt->execute()) {
    $last_id = $stmt->insert_id;
    $_SESSION['id'] = $last_id;
    $_SESSION['modules'] = $numm;
    
    // Insert null modules after course creation
    for ($i = 1; $i <= $numm; $i++) {
        $module_name = null; // Set module_name to null
        saveModuleToDatabase($last_id, $module_name);
    }
 // Redirect after inserting modules
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$stmt->close();
$conn->close();

function saveModuleToDatabase($course_id, $module_name) {
    // Database connection (replace with your actual connection details)
    $conn = new mysqli('sql113.infinityfree.com', 'if0_37485657', '0c1Lrqmw4l9t4Rm', 'if0_37485657_peso');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO modules (course_id, module_name) VALUES (?, ?)");
    $stmt->bind_param("is", $course_id, $module_name); // 's' for string, but null should work as well


    header("Location: course_list.php");
    // Execute the statement
    if (!$stmt->execute()) {    
        echo "Error inserting module: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
