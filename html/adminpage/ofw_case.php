<?php
session_start();
include 'conn_db.php';  // Include database connection

// Check if admin is logged in
$admin = $_SESSION['username'];

// Fetch all cases
$sql = "SELECT c.*, ap.*, c.id
        FROM cases c
        JOIN applicant_profile ap ON c.user_id = ap.user_id
       ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cases</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/modal-form.css">
    <link rel="stylesheet" href="../../css/admin_ofw.css">
    <link rel="stylesheet" href="../../css/nav_float.css">
</head>
<body>

<!-- Navigation -->
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
      <h1 class="ofw-h1">OFW Filed Cases</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon-admin" data-bs-toggle="popover" data-bs-placement="bottom">
    <?php if (!empty($row['photo'])): ?>
        <img id="preview" src="../../php/applicant/images/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
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

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table class="menu">
                <tr><td><a href="admin_home.php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="employer_list.php" class="nav-link">Employer List</a></td></tr>
                <tr><td><a href="course_list.php" class="nav-link">Course List</a></td></tr>
                <tr><td><a href="ofw_case.php" class="active nav-link">OFW Cases</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admin_home.php" >Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">OFW Cases</li>
  </ol>
</nav>

<div class="table-containers">
    <div class="button-container">
        <a class="btn btn-primary" href="user_chat.php">View Inquiries</a>
        <a class="btn btn-primary" href="create_survey.php">Create Survey</a>
    </div>

    <div class="table-wrapper">
        <div class="table-container-ofw-case">
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Agency</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Status update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
                                echo "<tr>
                                        <td>".$full_name."</td>
                                        <td>".$row['contact_number']."</td>
                                        <td>".$row['local_agency_name']."</td>
                                        <td>".$row['title']."</td>
                                        <td>".$row['status']."</td>";

                                // Check if status is not "resolved" or "in_progress"
                                if($row['status'] !== 'resolved') {
                                    if($row['status'] !== 'in_progress') {
                                        echo "<td> <a class='btn btn-success' href='update_status.php?case_id=".$row['id']."'>Update</a> </td>";
                                    }
                                    echo "<td> <a class='btn btn-success' href='resolve_status.php?case_id=".$row['id']."'>Resolved</a> </td>";
                                } else {
                                    // If the case is resolved, show no buttons
                                    echo "<td colspan='2'>Case Resolved</td>";
                                }
                                
                                echo "</tr>";
                            } 
                        } else {
                            echo "<tr><td colspan='6'>No case file found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- New table with user response data -->
        <div class="user-table-container">
          <div class="table-container-ofw-case">
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql_new1 = "SELECT survey_reponse.user_id, 
                                    MAX(applicant_profile.first_name) AS first_name, 
                                    MAX(applicant_profile.middle_name) AS middle_name, 
                                    MAX(applicant_profile.last_name) AS last_name
                                FROM survey_reponse
                                INNER JOIN applicant_profile ON survey_reponse.user_id = applicant_profile.user_id
                                GROUP BY survey_reponse.user_id";
                    $result_new = $conn->query($sql_new1);

                    if ($result_new->num_rows > 0) {
                        while ($row = $result_new->fetch_assoc()) {
                            $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
                            echo "<tr>
                                    <td>" . $row['user_id'] . "</td>
                                    <td>" . $full_name . "</td>
                                    <td> <a class='btn btn-primary openSurveyBtn' href='#' data-user-id=".htmlspecialchars($row['user_id'])."> check </a> </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No users found</td></tr>";
                    }

                    $conn->close();
                ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
</div>

<!-- employer list -->
<div id="surveyModal" class="modal modal-container">
            <div class="modal-content">
                <span class="btn-close closBtn closeBtn">&times;</span>
                <div id="surveyModuleContent">
                    <!-- Module content will be dynamically loaded here -->
                </div>
            </div>
        </div>

    <script>  const surveyModal = document.getElementById('surveyModal');
        const closeModuleBtn = document.querySelector('.closeBtn');
        // Open profile modal and load data via AJAX
        $(document).on('click', '.openSurveyBtn', function(e) {
            e.preventDefault();
            const userId = $(this).data('user-id');

            $.ajax({
                url: 'user_response.php',
                method: 'GET',
                data: { user_id: userId },
                success: function(response) {
                    $('#surveyModuleContent').html(response);
                    surveyModal.style.display = 'flex';
                }
            });
        });

        // Close profile modal when 'x' is clicked
        closeModuleBtn.addEventListener('click', function() {
            surveyModal.style.display = 'none';
        });

        // Close profile modal when clicking outside the modal content
        window.addEventListener('click', function(event) {
            if (event.target === surveyModal) {
                surveyModal.style.display = 'none';
            }
        });
    </script>
    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../../javascript/a_profile.js"></script> 
    
    <script src="../../javascript/script.js"></script> 
</body>
</html>