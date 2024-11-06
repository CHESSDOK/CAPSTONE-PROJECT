<?php
// Include the database connection
include 'php/conn_db.php';

// Capture the search term from the search input (use real_escape_string to prevent SQL injection)
$searchTerm = isset($_GET['search']) ? '%' . $conn->real_escape_string($_GET['search']) . '%' : '%';

// Base SQL query for fetching jobs
$sql = "SELECT jp.*, em.company_name, em.photo, ad.username AS admin_username
        FROM job_postings jp
        LEFT JOIN employer_profile em ON jp.employer_id = em.user_id
        LEFT JOIN admin_profile ad ON jp.admin_id = ad.id
        WHERE (jp.job_title LIKE ? OR em.company_name LIKE ? OR ad.username LIKE ?)";

// Prepare the SQL query
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);

// Execute the query and get the result set
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $conn->error);
}

// Display the jobs
while ($job = $result->fetch_assoc()) {
    echo '<div class="card mb-2 p-2 shadow-sm">';

    // Center-align job title and company/admin name
    echo '<div class="d-flex justify-content-between align-items-center">';

    // Job Title
    echo '<div>';
    echo '<h5 class="mb-0" style="color: #007bff;">' . htmlspecialchars($job["job_title"]) . '</h5>';
    
    // Company or Admin
    if (!empty($job["company_name"])) {
        echo '<p class="mb-0" style="font-size: 0.9rem; color: #6c757d;">' . htmlspecialchars($job["company_name"]) . '</p>';
    } else {
        echo '<p class="mb-0" style="font-size: 0.9rem;">Posted by Admin: ' . htmlspecialchars($job["admin_username"]) . '</p>';
    }
    echo '</div>';

    // Apply Button
    echo '<div>';
    echo '<a href="html/combine_login.html" class="btn btn-sm btn-primary">Apply</a>';
    echo '</div>';

    echo '</div>'; // Close align-center div
    echo '</div>'; // Close card
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
