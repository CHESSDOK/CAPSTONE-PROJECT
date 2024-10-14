<?php
include 'conn_db.php';

// Fetch the list of applicants taking the course along with module progress
$sql = "SELECT ap.id, ap.first_name, ap.middle_name, ap.last_name, ap.email, 
               m.module_name, c.course_name, mt.status
        FROM modules_taken mt
        JOIN applicant_profile ap ON ap.user_id = mt.user_id
        JOIN modules m ON m.id = mt.module_id
        JOIN courses c ON c.id = m.course_id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Create an associative array to group data by applicant
$applicants = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $middle_initial = !empty($row['middle_name']) ? strtoupper($row['middle_name'][0]) . '. ' : '';
        $fullname = htmlspecialchars($row['first_name'] . ' ' . $middle_initial . $row['last_name']);
        $course_name = htmlspecialchars($row["course_name"]);
        $module_name = htmlspecialchars($row["module_name"]);

        // Correctly display the module name to handle special characters
        $module_name = str_replace('&amp;', '&', $module_name);
        
        // Determine the status of the module for display with document icon
        if ($row['status'] === 'passed') {
            $status_display = "<i class='fas fa-file-alt text-success'></i> Passed"; // Green document icon
        } elseif ($row['status'] === 'fail') {
            $status_display = "<i class='fas fa-file-alt text-danger'></i> Failed"; // Gray document icon
        } else {
            $status_display = "<i class='fas fa-file-alt text-warning'></i> Not Attempted"; // Yellow document icon
        }

        // Grouping data by applicant and course
        $applicants[$fullname]['course'] = $course_name;
        $applicants[$fullname]['modules'][] = ["name" => $module_name, "status" => $status_display];
    }
} 

// Start echoing HTML as PHP output
echo '
<!-- Include Bootstrap CSS and Font Awesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Learners and Modules Progress</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Full Name</th>
                            <th scope="col">Course Taken</th>
                            <th scope="col">Module Progress</th>
                        </tr>
                    </thead>
                    <tbody>';
                        
                        if (!empty($applicants)) {
                            foreach ($applicants as $fullname => $data) {
                                echo "<tr>
                                    <td>$fullname</td>
                                    <td>" . $data['course'] . "</td>
                                    <td>";
                                        foreach ($data['modules'] as $module) {
                                            echo "<ul><li>" . htmlspecialchars($module['name']) . " (" . $module['status'] . ")</li></ul>";
                                        }
                                echo "</td>
                                </tr>";
                            }
                        } else {
                            echo '
                            <tr>
                                <td colspan="3" class="text-center">No modules found</td>
                            </tr>';
                        }
echo '                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and Font Awesome JS (optional for mobile and icon support) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>';
?>
