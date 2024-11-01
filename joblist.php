<?php
// Include the database connection
include 'php/conn_db.php';

// Capture the search term from the search input (use real_escape_string to prevent SQL injection)
$searchTerm = isset($_GET['search']) ? '%' . $conn->real_escape_string($_GET['search']) . '%' : '%';

// Base SQL query for fetching jobs
$sql = "SELECT jp.*, em.company_name, em.photo, em.company_address, em.company_mail, em.tel_num, ad.username AS admin_username
        FROM job_postings jp
        LEFT JOIN employer_profile em ON jp.employer_id = em.user_id
        LEFT JOIN admin_profile ad ON jp.admin_id = ad.id
        WHERE (jp.job_title LIKE ? OR em.company_name LIKE ? OR em.company_address LIKE ? OR ad.username LIKE ?)";

// Prepare the SQL query
$stmt = $conn->prepare($sql);

// Bind the search parameters and the user ID (for checking status related to the current user)
$stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);

// Execute the query and get the result set
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $conn->error);
}

// Display the jobs
while ($job = $result->fetch_assoc()) {
    echo '<div class="card mb-3 p-3 shadow-sm">';

    // Row to align all fields horizontally
    echo '<div class="row align-items-center">';

    // Job Logo / Placeholder (left side)
    echo '<div class="col-md-2 text-center">';
    if (!empty($job["photo"])) {
        echo '<img src="php/employer/uploads/' . htmlspecialchars($job["photo"]) . '" alt="Logo" class="img-fluid rounded-circle mb-3" style="max-width: 100px; height: auto;">';
    } else {
        echo '<img src="img/logo_peso.png" alt="Logo" class="img-fluid rounded-circle mb-3" style="max-width: 100px; height: auto;">';
    }
    echo '</div>';

    // Job Title and Company Details (center part)
    echo '<div class="col-md-6">';
    echo '<div class="d-flex align-items-center">
        <i class="fas fa-briefcase" style="color: #007bff; margin-right: 8px;"></i>
        <h4 class="fw-bold mb-0" style="color: #007bff;">' . htmlspecialchars($job["job_title"]) . '</h4>
      </div>';

    // Company Details or Posted by Admin
    if (!empty($job["company_name"])) {
        // Job posted by employer
        echo '<p class="mb-0" style="font-size: 1rem; color: #6c757d;">
            <i class="fas fa-building" style="color: #007bff;"></i>
            ' . htmlspecialchars($job["company_name"]) . '<br>
        </p>';
    
    } else {
        // Job posted by admin
        echo '<p>Posted by Admin: <strong>' . htmlspecialchars($job["admin_username"]) . '</strong></p>';
    }
    echo '</div>';

    // Vacancy status and apply button (right side)
    echo '<div class="col-md-4 text-end">';

    // Vacancy Status and Apply Button
    echo '<div class="d-flex justify-content-between align-items-center">';

    // Vacancy Status
    // Apply Button aligned to the right
    echo '<a href="html/combine_login.html">
            Apply <i class="fa fa-chevron-right"></i>
        </a>
        ';

    echo '</div>';

    echo '</div>'; // Close col-md-4 (right side)

    echo '</div>'; // Close row

    echo '</div>'; // Close card
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
