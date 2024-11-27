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
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #007bff;
        }
        .applicant-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .applicant-container:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .applicant-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .applicant-header h3 {
            margin: 0;
            font-size: 1.5em;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table td {
            vertical-align: top;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        table td label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        button {
            display: block;
            margin: 20px auto;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            text-align: center;
            font-size: 1.2em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All Applicants Details</h1>
        <button onclick="window.print()">Print All</button>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="applicant-container">
                    <div class="applicant-header">
                        <h3><?= htmlspecialchars($row['first_name'] . ' ' . substr($row['middle_name'], 0, 1) . '. ' . $row['last_name']); ?></h3>
                    </div>
                    <table>
                        <tr>
                            <?php
                            $columns = 3; // Number of columns in the table
                            $data = [];
                            foreach ($row as $key => $value) {
                                if (!in_array($key, ['user_id', 'username', 'email', 'password', 'is_verified', 'otp', 'otp_expiry', 'reset_token', 'reset_token_expiry'])) {
                                    $data[] = ['label' => ucfirst(str_replace('_', ' ', $key)), 'value' => $value ?: 'N/A'];
                                }
                            }
                            for ($i = 0; $i < count($data); $i++) {
                                if ($i % $columns === 0 && $i !== 0) {
                                    echo '</tr><tr>'; // Start a new row after 3 columns
                                }
                                echo '<td><label>' . htmlspecialchars($data[$i]['label']) . '</label><span>' . htmlspecialchars($data[$i]['value']) . '</span></td>';
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No applicants found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
