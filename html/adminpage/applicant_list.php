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
    $sql = "SELECT ap.*, a.* 
    FROM applicant_profile ap
    JOIN applications a ON ap.user_id = a.applicant_id
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
    $sql = "SELECT * FROM empyers WHERE id = ?";
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>list of applicants</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/modal-form.css">
    <link rel="stylesheet" href="../../css/nav_float.css">
    <link rel="stylesheet" href="../../css/admin_employer.css">
    <style>
            .category-container {
                display: flex;
                flex-direction: column; /* Align categories and tables vertically */
                gap: 20px; /* Space between categories */
            }
            .category-section {
                display: flex;
                flex-direction: column;
                align-items: center; /* Center align headers and tables */
                width: 100%;
            }
            .category-section h3 {
                margin-bottom: 10px; /* Space between header and table */
            }
            table {
                width: 80%; /* Adjust table width */
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black; /* Add borders to the table */
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
            .disabled-link {
            pointer-events: none; /* Prevents clicking */
            color: gray; /* Makes it look disabled */
            text-decoration: none;
            }
    </style>
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
            
            <div class="profile-icon-employer" data-bs-toggle="popover" data-bs-placement="bottom">
            <?php if (!empty($row['photo'])): ?>
                <img id="preview" src="php/employer/images/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
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
                    <tr><td><a href="user_master_list.php" class="nav-link">User List</a></td></tr>
                </table>
            </div>
        </div>
</nav>

<nav class="bcrumb-container" aria-label="breadcrumb">
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="admin_home.php" >Home</a></li>
  <li class="breadcrumb-item"><a href="employer_list.php" >Employer List</a></li>
  <li class="breadcrumb-item"><a href="create_job.php" >Post Job</a></li>
  <li class="breadcrumb-item active" aria-current="page">Applicants</li>
  </ol>
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
                            <th>Status</th>
                            <th class='action-btn'>Actions</th>
                        </thead>";
                
                if (!empty($applicants)) {
                    foreach ($applicants as $row) {
                        $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                        $status = $row['status'];

                        // Conditionally disable the interview button for "interview" or "accepted" status
                        $interview_button_disabled = ($status == 'interview' || $status == 'accepted') ? 'disabled' : '';
                        $accept_link_disabled = ($status == 'accepted') ? 'disabled-link' : '';
                        
                        echo "
                        <tr>
                            <td class='full-name'>" . htmlspecialchars($full_name) . "</td>
                            <td>" . htmlspecialchars($row['job']) . "</td>
                            <td>" . ucfirst($row['status']) . "</td>

                            <td class='btn-job'>
                                <a href='application_process.php?id=" . htmlspecialchars($row['user_id']) . "' 
                                class='btn btn-success mx-2" . $accept_link_disabled . "'>Accept</a>
                            
                                <a href='application_rejection.php?id=" . htmlspecialchars($row['user_id']) . "'
                                class='btn btn-danger mx-2" . $accept_link_disabled . "'>Rejected</a>
                            
                                <button class='btn btn-primary mx-2' id='openFormBtn' data-applicant-id=" . htmlspecialchars($row['applicant_id']) . "
                                data-job-id=" . htmlspecialchars($row['job_posting_id']) . " $interview_button_disabled>Interview</button>
                           
                                <button id='profileFormBtn' class='btn btn-primary openProfileBtn mx-2' data-applicant-id='" . htmlspecialchars($row['applicant_id']) . "'>View Profile</button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No applicants found</td></tr>";
                }
            
                echo "</table>";
            }
            
            // Display each category vertically with centered alignment
            // Display each category vertically with centered alignment
            echo "<div class='category-section'>";
            display_table($pending, 'Applied Applicant');
            echo "</div>";

            echo "<div class='category-section'>";
            display_table($review, 'For Interview');
            echo "</div>";

            echo "<div class='category-section'>";
            display_table($rejected, 'Accepted Applicant');
            echo "</div>";

            $conn->close();
        ?>
    </div>
</div>



    <div id="formModal" class="modal modal-container">
        <div class="modal-content">
            <span class="btn-close closBtn closeBtn">&times;</span>
            <h2>Interview</h2>
            <form action="interview.php" method="post">
                <input type="hidden" id="applicantId" name="applicant_id">
                <input type="hidden" id="jobid" name="jobid">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required><br><br>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required><br><br>
                <label for="interview">Interview Type:</label>
                <select name="interview" id="interview">
                    <option value="online">Online</option>
                    <option value="FacetoFace">Face to Face</option>
                </select>
                <label for="link">Link:</label>
                <input type="text" id="link" name="link"><br><br>
                <label for="address">Physical Address:</label>
                <input type="text" id="address" name="address"><br><br>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

<!-- Modal for Viewing Applicant Profile -->
<div id="profileModal" class="modal">
    <div class="modal-content">
        <span class="seccloseBtn">&times;</span>
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

    <script src="../../javascript/script.js"></script>  
</body>
</html>
