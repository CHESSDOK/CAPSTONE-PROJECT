
<?php
include '../../php/conn_db.php';
$userId = $_SESSION['id']; // Assuming you have the logged-in user's ID available

// Fetch user's specialization
$sqlUser = "SELECT specialization FROM applicant_profile WHERE user_id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $userId);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();

// Prepare the search query (if there's a search input)
$searchQuery = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

// Base SQL for fetching jobs

$sql = "SELECT jp.*, a.status, em.company_name, em.photo, em.company_address, em.company_mail, em.tel_num, ad.username AS admin_username
        FROM job_postings jp
        LEFT JOIN employer_profile em ON jp.employer_id = em.user_id
        LEFT JOIN admin_profile ad ON jp.admin_id = ad.id
        LEFT JOIN applications a ON a.job_posting_id = jp.j_id AND  a.applicant_id = $userId
        WHERE jp.is_active = 1 AND a.status IS NULL AND jp.job_title LIKE ?";

//$sql = "SELECT * FROM job_postings WHERE is_active = 1 AND job_title LIKE ?";

// Modify SQL if the user has a specialization
if ($user['specialization']) {
    $sql .= " AND specialization = ?";
}


// Prepare the SQL query
$stmt = $conn->prepare($sql);

// Bind parameters based on specialization availability
if ($user['specialization']) {
    $stmt->bind_param("ss", $searchQuery, $user['specialization']);
} else {
    $stmt->bind_param("s", $searchQuery);
}

// Execute the query and get results
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $conn->error);
}

// Display the jobs
while ($job = $result->fetch_assoc()) {
    echo '
    <table class="table table-striped table-hover">
    <tr>
    <td>';

    if (!empty($job["photo"])) {
        echo '<img src="../../php/employer/uploads/' . $job["photo"] . '" alt="Logo" class="img-fluid" style="max-width: 50px; height: auto;">';
    }else{
        echo '<img src="../../img/user-placeholder.png" alt="Logo" class="img-fluid" style="max-width: 50px; height: auto;">';
    }
    echo '</td>
    <td>
        <strong>' . htmlspecialchars($job["job_title"]) . '</strong><br>';
    
    // Check if the job was posted by an employer or admin
    if (!empty($job["company_name"])) {
        // Job posted by employer
        echo htmlspecialchars($job["company_name"]) . '<br>' . htmlspecialchars($job["company_address"]) . '<br>
        <a href="mailto:' . htmlspecialchars($job["company_mail"]) . '">' . htmlspecialchars($job["company_mail"]) . '</a><br>
        ' . htmlspecialchars($job["tel_num"]) . '<br>';
    } else {
        // Job posted by admin
        echo 'Posted by Admin: ' . htmlspecialchars($job["admin_username"]) . '<br>';
    }

    echo '</td>
    <td>
        <span class="badge ' . ($job["vacant"] > 1 ? "bg-success" : "bg-danger") . '">
            ' . ($job['vacant'] > 1 ? 'Vacant' : 'Not Vacant') . '
        </span>
    </td>
    <td>
        <a href="../../html/applicant/apply.php?job=' . urlencode($job["job_title"]) . '" class="btn btn-primary">
            Apply <i class="fa fa-arrow-right"></i>
        </a>
    </td>
  </tr>
  </table>';
}



// Close the connection
$conn->close();
?>

