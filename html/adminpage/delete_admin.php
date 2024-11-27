<?php
include 'conn_db.php';
session_start();

if ($_SESSION['level'] !== 'super_admin') {
    die("Unauthorized access!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM admin_profile WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: admin_management.php");
    exit;
}
?>
