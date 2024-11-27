<?php
include '../../php/conn_db.php';

function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
        header("Location: ../../index.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}

$adminId = checkSession();

// Ensure job_id is provided in the URL
if (!isset($_GET['job_id'])) {
    die("Job ID is required.");
}
$jobid = $_GET['job_id'];

// Pagination Variables
$items_per_page = 10; // Number of records per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // Current page
$offset = ($page - 1) * $items_per_page; // Calculate offset

// Fetch total records for pagination
$total_sql = "SELECT COUNT(*) AS total FROM applications WHERE job_posting_id = ? AND status != 'rejected'";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("i", $jobid);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// Calculate total pages
$total_pages = ceil($total_records / $items_per_page);

// SQL JOIN to fetch applicant details and their applications
$sql = "SELECT ap.*, a.*, i.meeting AS interview_link
    FROM applicant_profile ap 
    JOIN applications a ON ap.user_id = a.applicant_id
    LEFT JOIN interview i ON i.user_id = ap.user_id AND i.Job_id = a.job_posting_id
    WHERE a.job_posting_id = ? AND a.status != 'rejected'
    LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $jobid, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Arrays to hold categorized applicants
$pending = [];
$review = [];
$rejected = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Categorize based on status
        if ($row['status'] == 'pending') {
            $pending[] = $row;
        } elseif ($row['status'] == 'interview') {
            $review[] = $row;
        } elseif ($row['status'] == 'accepted') {
            $rejected[] = $row;
        }
    }
}

// Fetch employer profile
$sql = "SELECT * FROM admin_profile WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $adminId);
$stmt->execute();
$res = $stmt->get_result();

if (!$res) {
    die("Invalid query: " . $conn->error); 
}

$row = $res->fetch_assoc();
if (!$row) {
    die("User not found.");
}

$pic_sql = "SELECT * FROM admin_profile WHERE id = ?";
$pic_stmt = $conn->prepare($pic_sql);
$pic_stmt->bind_param("i", $adminId);
$pic_stmt->execute();
$pic_result = $pic_stmt->get_result();

if (!$pic_result) {
    die("Invalid query: " . $conn->error); 
}

$pic_row = $pic_result->fetch_assoc();
if (!$pic_row) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>List of Applicants</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/modal-form.css">
    <link rel="stylesheet" href="../../css/nav_float.css">
    <link rel="stylesheet" href="../../css/admin_employer.css">
</head>
<body>
<!-- Navigation -->
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
        <h1 class="h1">Applicant Updates</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon">
            <img id="#" src="../../img/notif.png" alt="Notification Icon" class="rounded-circle">
        </div>
        <div class="profile-icon-admin">
            <?php if (!empty($pic_row['profile_picture'])): ?>
                <img id="preview" src="<?php echo $pic_row['profile_picture']; ?>" alt="Profile Image" class="circular--square">
            <?php else: ?>
                <img src="../../img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="table-containers">
    <div class="row align-items-start">
        <?php
        function display_table($applicants, $status_label, $page, $total_pages, $jobid) {
            echo "<h3>$status_label</h3>";

            if (!empty($applicants)) {
                foreach ($applicants as $row) {
                    $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . '. ' . $row['last_name']);
                    $status = $row['status'];
                    $job = htmlspecialchars($row['job']);
                    $interview_link = htmlspecialchars($row['interview_link'] ?? ''); 

                    echo "
                    <div class='col-12'>
                        <div class='card mb-2'>
                            <div class='card-body'>
                                <div class='row align-items-center'>
                                    <div class='col-md-4'>
                                        <h5 class='card-title mb-1 text-truncate' style='max-width: 300px;'>$full_name</h5>
                                        <h6 class='card-subtitle mb-2 text-muted text-truncate' style='max-width: 300px;'>$job</h6>
                                    </div>
                                    <div class='col-md-2'>
                                        <a href='$interview_link' target='_blank' style='text-decoration:none; max-width: 100px;'>$interview_link</a>
                                    </div>
                                    <div class='col-md-2'>
                                        <p class='card-text mb-0'><strong>Status:</strong> ".ucfirst($status)."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
                }

                // Pagination Section
                echo '<nav aria-label="Page navigation">';
                echo '<ul class="pagination justify-content-center">';
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page='.($page - 1).'&job_id='.htmlspecialchars($jobid).'" aria-label="Previous">&laquo;</a></li>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i == $page) ? 'active' : '';
                    echo '<li class="page-item '.$active.'"><a class="page-link" href="?page='.$i.'&job_id='.htmlspecialchars($jobid).'">'.$i.'</a></li>';
                }
                if ($page < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="?page='.($page + 1).'&job_id='.htmlspecialchars($jobid).'" aria-label="Next">&raquo;</a></li>';
                }
                echo '</ul>';
                echo '</nav>';
            } else {
                echo "<p>No applicants found</p>";
            }
        }

        display_table($pending, 'Applied Applicants', $page, $total_pages, $jobid);
        display_table($review, 'For Interview', $page, $total_pages, $jobid);
        display_table($rejected, 'Accepted Applicants', $page, $total_pages, $jobid);
        ?>
    </div>
</div>
</body>
</html>
