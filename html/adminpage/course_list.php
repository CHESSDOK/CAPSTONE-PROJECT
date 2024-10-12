<?php
include 'conn_db.php';
session_start();
$admin = $_SESSION['username'];
// Fetch all employers
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - course List</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link rel="stylesheet" href="../../css/modal-form.css">
    <link rel="stylesheet" href="../../css/admin_course.css">
    <link rel="stylesheet" href="../../css/nav_float.css">

</head>
<body>

<nav>
        <div class="logo">
            <img src="../../img/logo_peso.png" alt="Logo">
            <a href="#"> PESO-lb.ph</a>
        </div>

        <header>
        <h1 class="ofw-h1">Course List</h1>
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
                <tr><td><a href="employer_list.php" class="nav-link">Employer List</a></td></tr>
                <tr><td><a href="course_list.php" class="active nav-link">Course List</a></td></tr>
                <tr><td><a href="ofw_case.php" class="nav-link">OFW Cases</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
        <div>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="admin_home.php" >Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Courses</li>
          </ol>
        </div>
        <a href="javascript:history.back()" class="return me-2">
          <i class="fas fa-reply"></i> Back
        </a>
      </nav>

<div class="table-container d-flex align-items-start">
    <button class="btn btn-primary course-btn" id="openCourseBtn">Add Course</button>

    <table class="table table-borderless table-hover">
        <thead>
            <th>Course Description</th>
            <th>Module Label</th>
            <th colspan="2">Course Actions</th>
            <th colspan="2">Module Actions</th>
        </thead>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <form method='POST' action='update_course.php'>
                        <input type='hidden' name='course_id' value='".$row["id"]."'>
                        <td><input class='form-control' type='text' name='course_name' value='".$row["course_name"]."'></td>
                        <td><input class='form-control' type='text' name='course_desc' value='".$row["description"]."'></td>                        
                        <td><input class='btn btn-success' type='submit' value='Update'></td>
                        <td><a class='btn btn-danger' href='delete_course.php?course_id=".$row["id"]."'>DELETE</a></td>
                        <td><a class='btn btn-primary' href='module_list.php?course_id=" . $row["id"] . "'>Edit Items</a></td>
                        </form>
                    </tr>";
                    
            }
        } else {
            echo "<tr><td colspan='4'>No employers found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    </div>

    <div id="courseModal" class="modal modal-container">
        <div class="modal-content">
            <span class="btn-close closBtn closeBtn">&times;</span>
            <h2>Create a course</h2>
            <form action="create_course.php" method="post">
                <!-- Text Input for Course -->
                <label for="course">Course:</label>
                <input class="form-control" type="text" id="course" name="course" required>
                
                <!-- Text Input for Description -->
                <label for="description">Description:</label>
                <input class="form-control" type="text" id="description" name="description" required>

                <label for="module_count">Number of Modules:</label>
                <input class="form-control" type="number" id="module_count" name="module_count" min="1" required>
                
                <!-- Submit Button -->
                <input class="btn btn-primary" type="submit" value="Submit">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../javascript/admin_modal.js"></script>
    <script src="../../javascript/a_profile.js"></script> 
    <script src="../../javascript/script.js"></script> 

</body>
</html>
