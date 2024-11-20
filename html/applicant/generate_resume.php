<?php
include '../../php/conn_db.php';

function checkSession() {
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ../login.html");
        exit();
    }
    return $_SESSION['id'];
}

$userId = checkSession();

$sql = "SELECT * FROM applicant_profile WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $conn->error);
}

$row = $result->fetch_assoc();
if (!$row) {
    die("User not found in applicant_profile.");
}

$preferred = isset($row['preferred_occupation']) ? explode(',', $row['preferred_occupation']) : [];
$otherSkills = isset($row['selected_options']) ? explode(',', $row['selected_options']) : [];
$uploadedImage = isset($row['photo']) ? $row['photo'] : '';
$imagePath = '../../php/applicant/images/' . $uploadedImage;

$sql_work_exp = "SELECT * FROM work_exp WHERE user_id = ?";
$stmt_work_exp = $conn->prepare($sql_work_exp);
$stmt_work_exp->bind_param("i", $userId);
$stmt_work_exp->execute();
$result_work_exp = $stmt_work_exp->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 30px;
        }
        .profile-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
        }
        .resume-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .resume-header {
            display: flex;
            justify-content: space-between; /* Align items to opposite ends */
            align-items: center;
            margin-bottom: 20px;
        }
        .resume-header img {
            margin-left: 20px; /* Optional spacing for the image */
        }
        .resume-header h1 {
            margin: 0;
            font-size: 1.8rem;
            color: #333;
        }
        .section-title {
            color: #0d6efd;
            margin-bottom: 10px;
        }
        .resume-section {
            margin-bottom: 20px;
        }
        .resume-section p {
            margin: 5px 0;
        }
        .contact-details p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="resume-container">
        <!-- Resume Header -->
        <div class="resume-header">
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Profile Photo" class="profile-image">
        </div>

        <!-- Personal Information Section -->
        <div class="resume-section">
            <h2 class="section-title">Personal Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></p>
            <p><strong>Sex:</strong> <?php echo htmlspecialchars($row['sex']); ?></p>
            <p><strong>Civil Status:</strong> <?php echo htmlspecialchars($row['civil_status']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($row['house_address']); ?></p>
        </div>

        <!-- Education Section -->
        <div class="resume-section">
            <h2 class="section-title">Education</h2>
            <p><strong>Highest level:</strong> <?php echo htmlspecialchars($row['education_level']); ?></p>
        </div>

        <!-- Preferred Positions Section -->
        <div class="resume-section">
            <h2 class="section-title">Preferred Positions</h2>
            <p><strong>Position Title:</strong> <?php echo htmlspecialchars($row['preferred_position']); ?></p>
        </div>

        <!-- Work Experience Section -->
        <div class="resume-section">
            <h2 class="section-title">Work Experience</h2>
            <ul>
                <?php if ($result_work_exp->num_rows > 0): ?>
                    <?php while ($row_work_exp = $result_work_exp->fetch_assoc()): ?>
                        <li><strong><?php echo htmlspecialchars($row_work_exp['position']); ?></strong> at 
                            <?php echo htmlspecialchars($row_work_exp['company_name']); ?> 
                            (<?php echo htmlspecialchars($row_work_exp['start_date']); ?> to <?php echo htmlspecialchars($row_work_exp['termination_date']); ?>)
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li>No work experience found.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Skills Section -->
        <div class="resume-section">
            <h2 class="section-title">Skills</h2>
            <ul>
                <?php if (!empty($otherSkills)): ?>
                    <?php foreach ($otherSkills as $skill): ?>
                        <li><?php echo htmlspecialchars(trim($skill)); ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No skills found.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Contact Details Section -->
        <div class="resume-section contact-details">
            <h2 class="section-title">Contact Details</h2>
            <p><strong>Cellphone:</strong> <?php echo htmlspecialchars($row['contact_no']); ?></p>
            <p><strong>Email Address:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
        </div>
    </div>
</div>

<script>
    window.print(); // Automatically trigger the print dialog
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
