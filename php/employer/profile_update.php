<?php
    include '../conn_db.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $conn->real_escape_string($_POST['email']);
        $userId = $_POST['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $bdate =  $_POST['bdate'];
        $contact =  $_POST['contact'];

        // Update the password in the database
        $sql = "UPDATE empyers SET Fname = '$fname', Lname = '$lname', Bdate = '$bdate', contact = '$contact' WHERE id = '$userId'";
        if ($conn->query($sql) === TRUE) {
            // Correcting the header function
            header("Location: ../../html/employer/employer_profile.php");
            exit(); // It's a good practice to call exit after header redirection
        } else {
            echo "Error updating record: " . $conn->error;
        }
    
        $conn->close();
    }
?>
