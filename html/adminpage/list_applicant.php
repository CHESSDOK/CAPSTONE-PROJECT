<?php
include 'conn_db.php';

// Fetch all applicants
$sql = "SELECT user_id, first_name, middle_name, last_name FROM applicant_profile";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Applicants List</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $counter = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $counter++; ?></td>
                        <td><?= $row['first_name'] . ' ' . substr($row['middle_name'], 0, 1) . '. ' . $row['last_name']; ?></td>
                        <td>
                            <form action="print_applicant.php" method="get" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $row['user_id']; ?>">
                                <button type="submit">Print Details</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No applicants found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <button onclick="window.location.href='print_all.php'">Print All</button>
</body>
</html>

<?php $conn->close(); ?>
