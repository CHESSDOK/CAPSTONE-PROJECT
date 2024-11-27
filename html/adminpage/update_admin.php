<?php
include 'conn_db.php';
session_start();

if ($_SESSION['level'] !== 'super_admin') {
    die("Unauthorized access!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE admin_profile SET email = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $email, $password, $id);
    $stmt->execute();

    header("Location: admin_management.php");
    exit;
} else {
    $id = $_GET['id'];
    $sql = "SELECT email FROM admin_profile WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
}
?>

<form method="post">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <label>Email:</label>
    <input type="email" name="email" value="<?= $admin['email']; ?>" required>
    <label>New Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Update</button>
</form>
