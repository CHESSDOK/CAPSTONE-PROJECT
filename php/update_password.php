<?php
include 'conn_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $new_password = $_POST['new_password'];

    // Hash the new password
    $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);

    // Update the password in the database
    $sql = "UPDATE register SET password = '$hashedPassword', reset_token = NULL, reset_token_expiry = NULL WHERE email = '$email'";
    if ($conn->query($sql) === TRUE) {
        echo "Password has been reset successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>