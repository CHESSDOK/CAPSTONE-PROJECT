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
    $jobid = $_GET['job_id'];

    // SQL JOIN to fetch applicant details and their applications
    $sql = "SELECT ap.*, a.*, i.meeting AS interview_link
    FROM applicant_profile ap 
    JOIN applications a ON ap.user_id = a.applicant_id
    LEFT JOIN interview i ON i.user_id = ap.user_id AND i.Job_id = a.job_posting_id
    WHERE a.job_posting_id = ? AND a.status != 'rejected'";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $jobid);
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
    <title>list of applicants</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        </div>

        <!-- Burger icon -->
        <div class="burger" id="burgerToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </td>
    </tr>
    </table>

        <!-- Offcanvas Menu -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                    <table class="menu">
                    <tr><td><a href="admin_home.php" class="nav-link">Home</a></td></tr>
                    <tr><td><a href="employer_list.php" class="active nav-link">Employer List</a></td></tr>
                    <tr><td><a href="course_list.php" class="nav-link">Course List</a></td></tr>
                    <tr><td><a href="ofw_case.php" class="nav-link">OFW Cases</a></td></tr>
                </table>
            </div>
        </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="admin_home.php" >Home</a></li>
        <li class="breadcrumb-item"><a href="employer_list.php" >Employer List</a></li>
        <li class="breadcrumb-item"><a href="create_job.php" >Post Job</a></li>
        <li class="breadcrumb-item active" aria-current="page">Applicants</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

<div class="table-containers">
    <div class="row align-items-start">
        <?php
            function display_table($applicants, $status_label) {
                echo "<h3>$status_label</h3>";
                echo "<table class='table table-borderless'>
                        <thead class='thead-light'>
                            <th>Full Name</th>
                            <th>Job</th>
                            <th>Interview Link</th> <!-- Add new header for interview link -->
                            <th>Status</th>
                            <th class='action-btn'>Actions</th>
                        </thead>";
                
                if (!empty($applicants)) {
                    foreach ($applicants as $row) {
                        $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . '. ' . $row['last_name']);
                        $status = $row['status'];
                        $job = htmlspecialchars($row['job']);
                        $interview_link = htmlspecialchars($row['interview_link'] ? $row['interview_link'] : '' ); // Fetch interview link
                        
                        echo "
                        <tr>
                            <td style='width: 450px;'>".htmlspecialchars($full_name)."</td>
                            <td style='width: 100px;'>$job</td>
                            <td style='width: 150px;'>
                                <a href='' target='_blank'>$interview_link</a> <!-- Display the interview link -->
                            </td>
                            <td style='width: 50px;'>".ucfirst($status)."</td>
                            <td class='btn-job'>";
                        
                        // Show the Accept and Reject buttons only if the status is neither 'accepted' nor 'interview'
                        if ($status != 'accepted' && $status != 'interview') {
                            echo "
                            <a class='btn btn-success mx-2' href='application_process.php?id=".htmlspecialchars($row['user_id'])."'>Accept</a>
                            <a class='btn btn-danger mx-2' href='application_rejection.php?id=".htmlspecialchars($row['user_id'])."&job_id=".htmlspecialchars($row['job_posting_id'])."'>Reject</a>
                            <button class='openFormBtn btn btn-primary mx-2' id='openFormBtn' data-applicant-id=".htmlspecialchars($row["applicant_id"])."
                            data-job-id=".htmlspecialchars($row["job_posting_id"]).">Interview</button>";
                        } elseif ($status === 'interview') {
                            echo "<a class='btn btn-success mx-2' href='application_process.php?id=".htmlspecialchars($row['user_id'])."'>Accept</a>
                                  <a class='btn btn-danger mx-2' href='application_rejection.php?id=".htmlspecialchars($row['user_id'])."&job_id=".htmlspecialchars($row['job_posting_id'])."'>Reject</a>";
                        }
            
                        echo "<button id='profileFormBtn' class='openProfileBtn btn btn-primary mx-2' data-applicant-id='".htmlspecialchars($row["applicant_id"])."'>View Profile</button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No applicants found</td></tr>";
                }
            
                echo "</table>";
            }
            
            
            // Display each category vertically with centered alignment
            echo "<div class='category-section'>";
            display_table($pending, 'Applied applicant');
            echo "</div>";

            echo "<div class='category-section'>";
            display_table($review, 'For interview');
            echo "</div>";

            echo "<div class='category-section'>";
            display_table($rejected, 'Accepted Applicant');
            echo "</div>";
            
            $conn->close();
        ?>
        </div>
    </div>


    <div id="formModal" class="modal modal-container">
    <div class="modal-content p-4">
        <span class="btn-close closBtn closeBtn">&times;</span>
        <h2 class="mb-4">Interview</h2>
        
        <form action="interview.php" method="post">
            <table class="table table-borderless">
                <input type="hidden" id="applicantId" name="applicant_id">
                <input type="hidden" id="jobid" name="jobid">
                
                <tr>
                    <td>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date:</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                    </td>
                    <td>
                        <div class="mb-3">
                            <label for="time" class="form-label">Time:</label>
                            <input type="time" id="time" name="time" class="form-control" required>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <div class="mb-3">
                            <label for="interview" class="form-label">Interview Type:</label>
                            <select name="interview" id="interview" class="form-select" onchange="toggleInterviewFields()">
                                <option value="">Select Interview Type</option>
                                <option value="online">Online</option>
                                <option value="FacetoFace">Face to Face</option>
                            </select>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <div id="linkField" class="mb-3">
                            <label for="link" class="form-label">Link:</label>
                            <input type="text" id="link" name="link" class="form-control" placeholder="Enter Your Virtual Link">
                        </div>

                        <div id="addressField" class="mb-3">
                            <label for="address" class="form-label">Physical Address:</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Enter Your Office Address">
                        </div>
                    </td>
                </tr>
            </table>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>


<script>
    function toggleInterviewFields() {
        var interviewType = document.getElementById('interview').value;
        var linkField = document.getElementById('linkField');
        var addressField = document.getElementById('addressField');

        if (interviewType === 'online') {
            linkField.style.display = 'block';
            addressField.style.display = 'none';
        } else if (interviewType === 'FacetoFace') {
            linkField.style.display = 'none';
            addressField.style.display = 'block';
        } else {
            linkField.style.display = 'none';
            addressField.style.display = 'none';
        }
    }

    // Initialize the fields when the page loads
    window.onload = function() {
        toggleInterviewFields();
    };
</script>

<!-- Modal for Viewing Applicant Profile -->
<div id="profileModal" class="modal modal-container">
    <div class="modal-content p-4">
        <span class="btn-close closBtn seccloseBtn">&times;</span>
        <h2>Applicant Profile</h2>
        <div id="applicantProfileContent">
            <!-- Profile details will be dynamically loaded here -->
        </div>
    </div>
</div>
<script src="../../javascript/applicant_admin.js"></script>
    <script>
    // Get modal and button elements for viewing profile
    const profileModal = document.getElementById('profileModal');
    const closepBtn = document.querySelector('.seccloseBtn');

    // Open profile modal and load data via AJAX
    $(document).on('click', '.openProfileBtn', function(e) {
        e.preventDefault();
        const applicantId = $(this).data('applicant-id');
        
        $.ajax({
            url: 'fetch_applicant_profile.php',
            method: 'GET',
            data: { applicant_id: applicantId },
            success: function(response) {
                $('#applicantProfileContent').html(response);
                profileModal.style.display = 'flex';
            }
        });
    });

    // Close profile modal when 'x' is clicked
    closepBtn.addEventListener('click', function() {
        profileModal.style.display = 'none';
    });

    // Close profile modal when clicking outside the modal content
    window.addEventListener('click', function(event) {
        if (event.target === profileModal) {
            profileModal.style.display = 'none';
        }
    });

    const today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0
    const yyyy = today.getFullYear();
    const currentDate = `${yyyy}-${mm}-${dd}`;
    // Set the min attribute to today's date
    document.getElementById('date').setAttribute('min', currentDate);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../../javascript/script.js"></script> 
</body>
</html>
