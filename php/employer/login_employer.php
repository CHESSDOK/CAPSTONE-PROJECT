<?php
include '../conn_db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM empyers WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $row['id'];
            header("Location: ../../html/employer/employer_home.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "<script>alert('No account found with this username/email.');
                window.location.href = '../../html/combine_login.html';</script>";
    }
}

$conn->close();
?>
