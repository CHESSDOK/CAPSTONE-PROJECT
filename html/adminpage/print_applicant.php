<?php
include 'conn_db.php';

// Get user_id from query parameter
$user_id = $_GET['user_id'];

// Fetch applicant details
$sql = "SELECT * FROM applicant_profile WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $applicant = $result->fetch_assoc();
} else {
    echo "Applicant not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Details</title>
</head>
<body>
    <h1>Applicant Details</h1>
    <ul>
        <?php foreach ($applicant as $key => $value): ?>
            <li><strong><?= ucfirst(str_replace('_', ' ', $key)); ?>:</strong> <?= $value; ?></li>
        <?php endforeach; ?>
    </ul>
    <button onclick="window.print()">Print</button>
</body>
</html>

<?php $conn->close(); ?>
