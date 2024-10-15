<?php
// Include the database connection
include '../../php/conn_db.php';

// Start the session and ensure session ID is available
if (!isset($_SESSION['id'])) {
    header("Location: ../login.html");
    exit();
}

$userId = $_SESSION['id']; // Get the logged-in user's ID

// Fetch user's specialization
$sqlUser = "SELECT selected_options FROM applicant_profile WHERE user_id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $userId);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();

// Capture the search term from the search input (use real_escape_string to prevent SQL injection)
$searchTerm = isset($_GET['search']) ? '%' . $conn->real_escape_string($_GET['search']) . '%' : '%';

// Base SQL query for fetching jobs
$sql = "SELECT jp.*, a.status, em.company_name, em.photo, em.company_address, em.company_mail, em.tel_num, ad.username AS admin_username
        FROM job_postings jp
        LEFT JOIN employer_profile em ON jp.employer_id = em.user_id
        LEFT JOIN admin_profile ad ON jp.admin_id = ad.id
        LEFT JOIN applications a ON a.job_posting_id = jp.j_id AND a.applicant_id = ?
        WHERE jp.is_active = 1 AND a.status IS NULL
        AND (jp.job_title LIKE ? OR em.company_name LIKE ? OR em.company_address LIKE ? OR ad.username LIKE ?)";

// Modify SQL if the user has a specialization
if (!empty($user['selected_options'])) {
    // Split selected_options into individual items and check if any match using FIND_IN_SET
    $specializations = explode(',', $user['selected_options']);
    $conditions = array_map(function($item) {
        return "FIND_IN_SET(?, jp.selected_options)";
    }, $specializations);

    $sql .= " AND (" . implode(' OR ', $conditions) . ")";
}

// Prepare the SQL query
$stmt = $conn->prepare($sql);

// Bind parameters based on specialization availability
if (!empty($user['selected_options'])) {
    // Create a dynamic type string with 's' for each specialization and other parameters
    $bindTypes = "issss" . str_repeat("s", count($specializations)); // 'i' for userId and 's' for search terms
    $params = array_merge([$userId, $searchTerm, $searchTerm, $searchTerm, $searchTerm], $specializations);
    
    // Use call_user_func_array to bind parameters dynamically
    $stmt->bind_param($bindTypes, ...$params);
} else {
    $stmt->bind_param("issss", $userId, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
}

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
        echo '<img src="../../php/employer/uploads/' . htmlspecialchars($job["photo"]) . '" alt="Logo" class="img-fluid rounded-circle mb-3" style="max-width: 100px; height: auto;">';
    } else {
        echo '<img src="../../img/user-placeholder.png" alt="Logo" class="img-fluid rounded-circle mb-3" style="max-width: 100px; height: auto;">';
    }
    echo '</div>';

    // Job Title and Company Details (center part)
    echo '<div class="col-md-6">';
    echo '<h5 class="fw-bold">' . htmlspecialchars($job["job_title"]) . '</h5>';

    // Company Details or Posted by Admin
    if (!empty($job["company_name"])) {
        // Job posted by employer
        echo '<p>
            <strong>' . htmlspecialchars($job["company_name"]) . '</strong><br>
            ' . htmlspecialchars($job["company_address"]) . '<br>
            <a href="mailto:' . htmlspecialchars($job["company_mail"]) . '">' . htmlspecialchars($job["company_mail"]) . '</a><br>
            ' . htmlspecialchars($job["tel_num"]) . '
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
    echo '<p class="mb-1">
            <span class="badge ' . ($job["vacant"] > 1 ? "bg-success" : "bg-danger") . ' d-block fs-5 p-s4 mb-3">
                ' . ($job['vacant'] > 1 ? 'Vacant' : 'Not Vacant') . ' 
            </span>
            <span class="ms-2 fs-5 d-block mb-4"> ' . htmlspecialchars($job['vacant']) . ' openings </span>
        </p>';

    // Apply Button aligned to the right
    echo '<a href="../../html/applicant/apply.php?job=' . urlencode($job["job_title"]) . '" class="docu">
            Apply <i class="fa fa-chevron-right"></i>
        </a>';

    echo '</div>';

    echo '</div>'; // Close col-md-4 (right side)

    echo '</div>'; // Close row

    echo '</div>'; // Close card
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
