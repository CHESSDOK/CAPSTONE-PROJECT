<?php
include 'conn_db.php';

// Fetch all applicants
$sql = "SELECT * FROM applicant_profile";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Applicants Details</title>
</head>
<body>
    <h1>All Applicants Details</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <h3><?= $row['first_name'] . ' ' . substr($row['middle_name'], 0, 1) . '. ' . $row['last_name']; ?></h3>
            <ul>
                <?php foreach ($row as $key => $value): ?>
                    <li><strong><?= ucfirst(str_replace('_', ' ', $key)); ?>:</strong> <?= $value; ?></li>
                <?php endforeach; ?>
            </ul>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No applicants found.</p>
    <?php endif; ?>

    <button onclick="window.print()">Print All</button>
</body>
</html>

<?php $conn->close(); ?>
