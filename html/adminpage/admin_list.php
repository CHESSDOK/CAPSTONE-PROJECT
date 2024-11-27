<?php
include 'conn_db.php';

// Start the session to access user information
session_start();

// Fetch all admin accounts
$sql = "SELECT id, username, email, admin_level, full_name, phone FROM admin_profile";
$result = $conn->query($sql);

// Check if the user is a super admin
$is_super_admin = isset($_SESSION['level']) && $_SESSION['level'] === 'super_admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Account Management</title>
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
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Admin Account Management</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Admin Level</th>
                <th>Full Name</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $counter = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $counter++; ?></td>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['admin_level']; ?></td>
                        <td><?= $row['full_name']; ?></td>
                        <td><?= $row['phone']; ?></td>
                        <td>
                            <?php if ($is_super_admin): ?>
                                <!-- Update Button -->
                                <form action="update_admin.php" method="get" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit">Update</button>
                                </form>

                                <!-- Delete Button -->
                                <form action="delete_admin.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this admin account?');">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" style="background-color: red; color: white;">Delete</button>
                                </form>
                            <?php else: ?>
                                <span>N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No admin accounts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php $conn->close(); ?>
