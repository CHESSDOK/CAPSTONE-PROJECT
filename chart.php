<?php
// Include the database connection
include 'php/conn_db.php';


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

echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="css/visualization.css">
    </head>
    <body>

    <div class="container">

        <div class="top-left-large">
            <div class="job-container">
                <h3>Hiring Rate</h3>
                <p class="percentage-container">
                 <span class="percentage-text">' . round($hiring_rate, 2) . '%</span>
                </p>
            </div>
        </div>

        <div class="top-middle-small">

            <div class="small-box1">
                <div class="1">
                    <h5>Active Job Postings</h5>
                    <p>Total Active Jobs Posted: ' . $active_job_postings . '</p>
                </div>
            </div>

            <div class="small-box2">
                    <div class="2">
                        <h5>Inactive User</h5>
                        <p>Total Inactive Applicants: '. $other_percentage .'</p>
                    </div>
            </div>
        </div>
        <div class="top-right-large">
                <div class="chart-container">
                    <!-- Pie Chart -->
                        <div class="pie-container">
                            <h3>Applicants Chart</h3>
                            <canvas id="userPieChart" width="200" height="200"></canvas>
                        </div>
                </div>
        </div>
    </div>
    <div class="container-bot">
        <div class="bottom-left"></div>
        <div class="bottom-right"></div>
    </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var ctx = document.getElementById("userPieChart").getContext("2d");
                var userPieChart = new Chart(ctx, {
                    type: "pie",
                    data: {
                        labels: ["Hired Applicant", "Rejected Applicant", "Pending Applicant", "For Interview"],
                        datasets: [{
                            label: "Percentage",
                            data: [' . $accepted_percentage . ', ' . $reject_percentage . ', ' . $pending_percentage . ', ' . $interview_percentage . '],
                            backgroundColor: ["#4CAF50", "#FF6347", "#FFCE54", "#5D9CEC"],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: false,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        var percentage = tooltipItem.raw.toFixed(1) + "%";
                                        return tooltipItem.label + ": " + percentage;
                                    }
                                }
                            },
                            legend: {
                                display: true,
                                position: "bottom",
                                labels: {
                                    boxWidth: 20,
                                    padding: 10
                                }
                            }
                        },
                        layout: {
                            padding: {
                                bottom: 20
                            }
                        }
                    }
                });
            });
        </script>
</body>
</html>
';

?>
