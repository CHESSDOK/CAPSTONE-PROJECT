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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
            color: #333;
        }
        .form-container {
            width: 80%;
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
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
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Applicant Details</h1>
        <table>
            <tr>
                <?php
                $columns = 3; // Number of columns in the table
                $data = [];
                foreach ($applicant as $key => $value) {
                    if (!in_array($key, ['user_id', 'username', 'email', 'password', 'is_verified', 'otp', 'otp_expiry', 'reset_token', 'reset_token_expiry', 'photo'])) {
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
        <button onclick="window.print()">Print</button>
    </div>
</body>
</html>

<?php $conn->close(); ?>
