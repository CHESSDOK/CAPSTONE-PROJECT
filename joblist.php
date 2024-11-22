<?php
include 'php/conn_db.php';

$jobsPerPage = 2;
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($currentPage < 1) $currentPage = 1;
$offset = ($currentPage - 1) * $jobsPerPage;

$searchTerm = isset($_GET['search']) ? '%' . $conn->real_escape_string($_GET['search']) . '%' : '%';

$sql = "SELECT jp.*, em.company_name, em.photo, ad.username AS admin_username
        FROM job_postings jp
        LEFT JOIN employer_profile em ON jp.employer_id = em.user_id
        LEFT JOIN admin_profile ad ON jp.admin_id = ad.id
        WHERE (jp.job_title LIKE ? OR em.company_name LIKE ? OR ad.username LIKE ?)
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssii", $searchTerm, $searchTerm, $searchTerm, $jobsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

while ($job = $result->fetch_assoc()) {
    echo '<div class="card mb-2 p-2 shadow-sm">';
    echo '<h5>' . htmlspecialchars($job['job_title']) . '</h5>';
    echo '<p>' . htmlspecialchars($job['company_name']) . '</p>';
    echo '<a href="html/combine_login.html" class="btn btn-primary">Apply</a>';
    echo '</div>';
}

$totalSql = "SELECT COUNT(*) AS total FROM job_postings jp
             LEFT JOIN employer_profile em ON jp.employer_id = em.user_id
             LEFT JOIN admin_profile ad ON jp.admin_id = ad.id
             WHERE (jp.job_title LIKE ? OR em.company_name LIKE ? OR ad.username LIKE ?)";
$totalStmt = $conn->prepare($totalSql);
$totalStmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalJobs = $totalResult->fetch_assoc()['total'];

$totalPages = ceil($totalJobs / $jobsPerPage);
if ($totalPages > 1) {
    echo '<nav><ul class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<li class="page-item"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul></nav>';
}
$conn->close();
?>
