<?php
include 'conn_db.php';
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'level' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
        header("Location: login_admin.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}
$adminId = checkSession(); 
$admin_level = $_SESSION['level'];

$sql = "SELECT * FROM admin_profile WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $adminId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
   die("Invalid query: " . $conn->error); 
}

$row = $result->fetch_assoc();
if (!$row) {
   die("No admind found");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/nav_float.css">
    <link rel="stylesheet" href="../../css/modal-form.css">
    <link rel="stylesheet" href="../../css/admin_profile.css">
</head>
<body>
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
        <h1 class="h1">Admin Profile</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
            <?php if (!empty($row['photo'])): ?>
                <img id="preview" src="php/applicant/images/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
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
</nav>

<!-- Offcanvas Menu -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <table class="menu">
            <tr><td><a href="admin_home.php" class="active nav-link">Home</a></td></tr>
            <tr><td><a href="employer_list.php" class="nav-link">Employer List</a></td></tr>
            <tr><td><a href="course_list.php" class="nav-link">Course List</a></td></tr>
            <tr><td><a href="ofw_case.php" class="nav-link">OFW Cases</a></td></tr>
        </table>
    </div>
</div>

<nav class="bcrumb-container" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admin_home.php" >Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
  </ol>
</nav>

<div class="container table-containers">





<div class="button-container">
<?php 
    if ($admin_level === "super_admin") {
        echo "<button style='width: 140px;'  class='btn btn-primary' id='openCourseBtn'>Create account</button>";
    } else {
        echo "";
    }
    ?>
    <form method="POST" action="profile_update.php"  enctype="multipart/form-data">
    <button type="submit" style="width: 140px;" class="btn btn-primary d-block">Save Changes</button></div>
        <table class="table table-borderless">
        <tr>
        <td colspan="2" class="text-center">
            <img id="preview" src="<?php echo isset($row['profile_picture']) ? htmlspecialchars($row['profile_picture']) : 'https://via.placeholder.com/150'; ?>" alt="Profile Image" class="profile-img rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: fill;">
            <input type="file" name="photoInput" value="<?php echo isset($row['profile_picture']) ? htmlspecialchars($row['profile_picture']) : ''; ?>" class="form-control mt-2" id="photoInput" accept="image/*">
        </td>

        </tr>
        <tr>   
            <td>
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($row['full_name']) ? htmlspecialchars($row['full_name']) : ''; ?>" required>
            </td>
            <td>
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>" required>
            </td>
        </tr>
        <tr>    
            <td colspan="2">     
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($row['phone']) ? htmlspecialchars($row['phone']) : ''; ?>" required>
            </td>
        </tr>        
        </table>
    </form>
</div>

<div id="courseModal" class="modal modal-container">
    <div class="modal-content modal-dialog">
        <span class="btn-close closBtn closeBtn">&times;</span>
        <table>
            <thead>
                <h3 class="text-center">Admin Account</h3>
            </thead>
            <tr>
                <td>
                    <p class="subtitle">Create Admin Account.</p>
                </td>
            </tr>
            <tr>
                <td>
                    <form class="form" action="register_admin.php" method="POST" id="registrationForm">
                        <div class="input-group mb-3">
                            <input required type="email" class="form-control input" name="email" id="emailInput" placeholder="Email">
                        </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="input-group mb-3">
                        <input required type="text" class="form-control input" name="username" placeholder="Username">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="input-group mb-3">
                        <input required type="password" class="form-control input" name="password" minlength="8" maxlength="16" id="passwordInput" placeholder="Password">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="input-group mb-3">
                        <select class="form-select" id="admin_role" name="admin_role" required>
                            <option>Select Admin Type</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <button class="btn btn-primary sign" type="submit">Submit</button>
                </td>
            </tr>
        </table>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="../../javascript/script.js"></script>
<script src="../../javascript/admin_modal.js"></script>
</body>
</html>