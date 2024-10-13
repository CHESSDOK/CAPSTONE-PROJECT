<?php
include '../../php/conn_db.php';
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
    checkSession();    header("Location: ../../html/employer/employer_login.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}
$employerid = checkSession();
$new_sql = "SELECT * FROM employer_profile WHERE user_id = ?";
$new_stmt = $conn->prepare($new_sql);
$new_stmt->bind_param("i", $employerid);
$new_stmt->execute();
$new_result = $new_stmt->get_result();

if (!$new_result) {
    die("Invalid query: " . $conn->error);
}

$new_row = $new_result->fetch_assoc();
if (!$new_row) {
    die("User not found.");
}

$sql = "SELECT * FROM job_postings WHERE employer_id = $employerid ";
$result = $conn->query($sql);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../../css/nav_float.css">
  <link rel="stylesheet" href="../../css/employer.css">
</head>
<body>

<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
        <h1 class="h1">Job Posted</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon-employer" data-bs-toggle="popover" data-bs-placement="bottom">
        <?php if (!empty($new_row['photo'])): ?>
        <img id="preview" src="../../php/employer/uploads/<?php echo $new_row['photo']; ?>" alt="Profile Image" class="circular--square">
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
                <tr><td><a href="../../html/employer/employer_home.php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="../../html/employer/job_creat.php" class="nav-link">Post Job</a></td></tr>
                <tr><td><a href="#" class="active nav-link">Job List</a></td></tr>
                <tr><td><a href="../../html/about.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="../../html/contact.php" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="../../html/employer/employer_home.php" >Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Job List</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

<div class="container">
    <div class="table-containers">
        <div class="table-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <div class='card p-3 mb-3 shadow-sm'>
                    <form action='../../php/employer/update_jobs.php' method='post'>
                            <div class='row align-items-center gx-2'>

                                <input type='hidden' name='job_id' value='" . htmlspecialchars($row['j_id']) . "'>

                                <!-- Title (Reduced to 2 columns) -->
                                <div class='col-md-2'>
                                    <label for='jtitle' class='form-label'>Title</label>
                                    <input type='text' class='form-control form-control-sm' id='jtitle' name='jtitle' value='" . htmlspecialchars($row['job_title']) . "' placeholder='Job Title'>
                                </div>

                                <!-- Job Description (Reduced to 2 columns) -->
                                <div class='col-md-3'>
                                    <label for='desc' class='form-label'>Job Description</label>
                                    <input type='text' class='form-control form-control-sm' id='desc' name='desc' value='" . htmlspecialchars($row['job_description']) . "' placeholder='Job Description'>
                                </div>

                                <!-- Specialization (Reduced to 2 columns) -->
                                <div class='col-md-2'>
                                    <label for='spe' class='form-label'>Specialization</label>
                                    <input type='text' class='form-control form-control-sm' id='spe' name='spe' value='" . htmlspecialchars($row['specialization'] ? $row['specialization'] : '') . "' placeholder='Specialization'>
                                </div>

                                <!-- Job Type (Reduced to 2 columns) -->
                                <div class='col-md-2'>
                                    <label for='jobtype' class='form-label'>Job Type</label>
                                    <select class='form-select form-select-sm' id='jobtype' name='jobtype' required>
                                        <option value='Part time'" . ($row['job_type'] == 'Part time' ? ' selected' : '') . ">Part time</option>
                                        <option value='Prelance'" . ($row['job_type'] == 'Prelance' ? ' selected' : '') . ">Prelance</option>
                                        <option value='Fulltime'" . ($row['job_type'] == 'Fulltime' ? ' selected' : '') . ">Fulltime</option>
                                    </select>
                                </div>

                                <!-- Vacant (Reduced to 1 column) -->
                                <div class='col-md-1'>
                                    <label for='vacant' class='form-label'>Vacant</label>
                                    <input type='number' class='form-control form-control-sm' id='vacant' name='vacant' value='" . htmlspecialchars($row['vacant']) . "' placeholder='Vacant'>
                                </div>

                                <!-- Status (Reduced to 1 column) -->
                                <div class='col-md-1'>
                                    <label for='act' class='form-label'>Status</label>
                                    <input type='number' class='form-control form-control-sm' id='act' name='act' value='" . htmlspecialchars($row['is_active']) . "' placeholder='Active'>
                                </div>

                                <!-- Actions (Reduced to 1 column) -->
                                <div class='col-md-1 d-flex align-items-end'>
                                    <div class='d-grid gap-2 d-md-flex'>
                                        <button type='submit' class='btn btn-primary btn-sm'>Update</button>
                                        <a href='applicant_list.php?job_id=" . htmlspecialchars($row['j_id']) . "' class='btn btn-secondary btn-sm'>Applicant List</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>";
                }
            } else {
                echo "<div class='alert alert-warning'>No employers found</div>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</div>

   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
   <script src="../../javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->
</body>
</html>