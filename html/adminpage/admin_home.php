<?php
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'level' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
        header("Location: login_admin.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}

$admin_id = checkSession();
$admin_level = $_SESSION['level'];

include 'conn_db.php';

$pic_sql = "SELECT * FROM admin_profile WHERE id = ?";
$pic_stmt = $conn->prepare($pic_sql);
$pic_stmt->bind_param("i", $admin_id);
$pic_stmt->execute();
$pic_result = $pic_stmt->get_result();

if (!$pic_result) {
    die("Invalid query: " . $conn->error); 
}

$pic_row = $pic_result->fetch_assoc();
if (!$pic_row) {
    die("User not found.");
}

// Query to get total users and accepted users
$sql = "SELECT 
            (SELECT COUNT(*) FROM applicant_profile) AS total_users,
            (SELECT COUNT(DISTINCT applicant_id) FROM applications WHERE status = 'accepted') AS accepted_users,
            (SELECT COUNT(DISTINCT applicant_id) FROM applications WHERE status = 'rejected') AS rejected_users,
            (SELECT COUNT(DISTINCT applicant_id) FROM applications WHERE status = 'interview') AS interview_users,
            (SELECT COUNT(DISTINCT applicant_id) FROM applications WHERE status = 'pending') AS pending_users";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

$total_users = $row['total_users'];
$accepted_users = $row['accepted_users'];
$pending_users = $row['pending_users'];
$reject_users = $row['rejected_users'];
$interview_users = $row['interview_users'];

$total_applicant = $accepted_users + $pending_users + $reject_users + $interview_users;

// Calculate percentages with zero division check
if ($total_applicant > 0) {
    $accepted_percentage = ($accepted_users / $total_applicant) * 100;
    $pending_percentage = ($pending_users / $total_applicant) * 100;
    $reject_percentage = ($reject_users / $total_applicant) * 100;
    $interview_percentage = ($interview_users / $total_applicant) * 100;
} else {
    $accepted_percentage = $pending_percentage = $reject_percentage = $interview_percentage = 0;
}

$other_percentage = $total_users - $total_applicant;

// SQL query to count unique cases by title and user_id
$sql = "SELECT title, COUNT(DISTINCT user_id) AS case_count
        FROM cases
        GROUP BY title
        ORDER BY case_count DESC";

$result = $conn->query($sql);

// Prepare data for Chart.js
$titles = [];
$counts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $titles[] = $row['title'];
        $counts[] = $row['case_count'];
    }
} else {
    $titles = []; // Ensure titles is empty if no results
    $counts = []; // Ensure counts is empty if no results
}

// Query to get total applications
$total_sql = "SELECT COUNT(DISTINCT applicant_id) AS total_applications FROM applications";
$result = $conn->query($total_sql);
$total_applications = $result->fetch_assoc()['total_applications'];

// Query to get hired applications
$hired_sql = "SELECT COUNT(DISTINCT applicant_id) AS hired_applications FROM applications WHERE status = 'accepted'";
$result = $conn->query($hired_sql);
$hired_applications = $result->fetch_assoc()['hired_applications'];

// Calculate the total hiring rate
if ($total_applications > 0) {
    $hiring_rate = ($hired_applications / $total_applications) * 100;
} else {
    $hiring_rate = 0; // Avoid division by zero
}

// Query to get active job postings
$active_jobs_sql = "SELECT COUNT(*) AS active_job_postings FROM job_postings WHERE is_active = 1";
$result = $conn->query($active_jobs_sql);
$active_job_postings = $result->fetch_assoc()['active_job_postings'];

$sql = "SELECT ap.user_id, ap.first_name, ap.last_name, ap.middle_name, 
        MAX(a.job_posting_id) AS job_id, MAX(a.status) AS status, MAX(a.job) AS job
        FROM applicant_profile ap
        JOIN applications a ON ap.user_id = a.applicant_id
        WHERE a.status = 'accepted'
        GROUP BY ap.user_id, ap.first_name, ap.last_name, ap.middle_name, a.status";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/admin_home.css">
    <link rel="stylesheet" href="../../css/modal-form.css">
</head>
<body>
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>
    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon-admin" data-bs-toggle="popover" data-bs-placement="bottom">
            <?php if (!empty($pic_row['profile_picture'])): ?>
                <img id="preview" src="<?php echo $pic_row['profile_picture']; ?>" alt="Profile Image" class="circular--square">
            <?php else: ?>
                <img src="../../img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
            <?php endif; ?>
        </div>
    </div>

    <!-- Burger icon -->
    <div class="burger" id="burgerToggle">
        <span></span>
        <span></span>
        <span></span>
    </div>
</nav>

<!-- Offcanvas Menu -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <table class="menu">
            <tr><td><a href="admin_home.php" class="active nav-link">Home</a></td></tr>
            <tr><td><a href="employer_list.php" class="nav-link">Employer List</a></td></tr>
            <tr><td><a href="course_list.php" class="nav-link">Course List</a></td></tr>
            <tr><td><a href="ofw_case.php" class="nav-link">OFW Cases</a></td></tr>
            <tr><td><a href="list_applicant.php" class="nav-link" target="_blank">Manage Applicants</a></td></tr>
            <tr><td><a href="admin_list.php" class="nav-link" target="_blank">Manage Admins</a></td></tr>
            <tr><td><a href="manage_news.php" class="nav-link" target="_blank">Manage News Page</a></td></tr>
        </table>
    </div>
</div>
        <div class="admin-container">
            <div class="num-container">
                <!--hiring rate-->
                <div class="job-container">
                    <h5>Total Job Hiring Rate</h5>
                    <p>Total Applications: <?php echo $total_applications; ?><p>
                    <p>Hired Applications: <?php echo $hired_applications; ?><p>
                    <p>Hiring Rate: <?php echo round($hiring_rate, 2); ?>%<p>
                </div>
                <div class="combine-num-container">
                    <!--job count-->
                    <div class="job-container">
                        <h5>Active Job Postings</h5>
                        <p>Total Active Jobs Posted: <?php echo $active_job_postings; ?></p>
                    </div>

                    <!--User count-->
                    <div class="job-container">
                        <h5>Inactive User</h5>
                        <p>Total Inactive Applicants: <?php echo $other_percentage; ?></p>
                    </div>
        </div>

        <div class="applicant-container">
            <table>
                <thead>
                    <th>Lastname</th>
                    <th>Specialization</th>
                    <th>Job Applied</th>
                    <th>Status</th>
                </thead>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $specialization = $row["specialization"] ?? 'None';
                        echo "<tr>
                                <td>" . htmlspecialchars($row["last_name"]) . "</td>
                                <td>" . htmlspecialchars($specialization) . "</td>
                                <td>" . htmlspecialchars($row["job"]) . "</td>
                                <td>" . htmlspecialchars($row["status"]) . "</td>
                            </tr>";
                    }
                } else {
                    echo "
                    <tr><td colspan='7'>No user found</td></tr>";
                }
                $conn->close();
                ?>
            </table>
        </div>
    </div>       

    <div class="chart-container">
    <!-- Pie Chart -->
        <div class="pie-container">
            <h3>Applicants Chart</h3>
            <canvas id="userPieChart" width="200" height="200"></canvas>
        </div>

    <!-- Bar Chart -->
        <div class="bar-container">
            <h3>OFW Chart</h3>
            <canvas id="casesBarChart" width="500" height="200"></canvas>
        </div>
    <!-- Bar Chart -->
        <div class="news-container">
        <h3>Add News</h3>
        <form id="newsForm" action="save_news.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="newsTitle" class="form-label">News Title</label>
                <input type="text" class="form-control" id="newsTitle" name="title" required>
            </div>
            <div class="mb-3">
                <label for="newsImage" class="form-label">News Image</label>
                <input type="file" class="form-control" id="newsImage" name="image" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="newsDescription" class="form-label">News Description</label>
                <textarea class="form-control" id="newsDescription" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
</div>
</div>

<!-- Applicant Pie Chart -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('userPieChart').getContext('2d');
    var userPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Hired Applicant', 'Rejected Applicant', 'Pending Applicant', 'For Interview'],
            datasets: [{
                label: 'Percentage',
                data: [<?php echo $accepted_percentage; ?>, <?php echo $reject_percentage; ?>, <?php echo $pending_percentage; ?>, <?php echo $interview_percentage; ?>],
                backgroundColor: ['#4CAF50', '#FF6347', '#FFCE54', '#5D9CEC'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false, // Disable responsive behavior for fixed size
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var percentage = tooltipItem.raw.toFixed(1) + '%'; // Round to 1 decimal place
                            return tooltipItem.label + ': ' + percentage;
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 20, // Size of color boxes
                        padding: 10,  // Space between the boxes
                    }
                }
            },
            layout: {
                padding: {
                    bottom: 20 // Add space between the chart and the legend
                }
            }
        }
    });
});
</script>

<!-- OFW Bar Chart -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Data from PHP
    const titles = <?php echo json_encode($titles); ?>;
    const counts = <?php echo json_encode($counts); ?>;

    const ctx = document.getElementById('casesBarChart').getContext('2d');
    const casesBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: titles.length ? titles : ['No Data'], // Ensure titles is not empty
            datasets: [{
                label: 'Number of Unique Cases',
                data: counts.length ? counts : [0], // Ensure counts is not empty
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: ''
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Case Title'
                    }
                }
            }
        }
    });
});
</script>

<script>
    var totalApplications = <?php echo $total_applications; ?>;
    var hiredApplications = <?php echo $hired_applications; ?>;
    var hiringRate = (hiredApplications / totalApplications) * 100;

    console.log("Total Hiring Rate: " + hiringRate.toFixed(2) + "%");
</script>

<script>
    var activeJobPostings = <?php echo $active_job_postings; ?>;
    console.log("Total Active Job Postings: " + activeJobPostings);
</script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="../../javascript/script.js"></script>
<script src="../../javascript/admin_modal.js"></script>
</body>
</html>