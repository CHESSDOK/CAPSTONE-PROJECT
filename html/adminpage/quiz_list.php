<?php
include_once "../../php/conn_db.php";
$m_id = $_GET['modules_id'];
$sql = "SELECT * FROM quiz_name WHERE module_id = $m_id ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>quiz List</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">

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
      <h1 class="ofw-h1">Quiz Contents</h1>
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
                <tr><td><a href="#" class="active nav-link">Course List</a></td></tr>
                <tr><td><a href="ofw_case.php" class="nav-link">OFW Cases</a></td></tr>
                <tr><td><a href="create_survey.php" class="nav-link">OFW Survey</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admin_home.php" >Home</a></li>
    <li class="breadcrumb-item"><a href="course_list.php" >Courses</a></li>
    <li class="breadcrumb-item"><a href="module_list.php?module_id=<?= $row['id']; ?>">Module List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Quiz List</li>
  </ol>
</nav>

<div class="table-container">
    <table class="table table-borderless table-hover">
        <thead>
        <tr>
            <th></th><th></th>
            <th scope="col">Title</th>
            <th scope="col">Tag</th>
            <th scope="col">Total</th>
            <th colspan="2" scope="col">Actions</th>
        </tr>
        </thead>
         <tbody>
         <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <form action='quiz_update.php' method='post'>
                            <td><input type='hidden' name='id' value='" . $row['id'] . "'>
                            <td><input type='hidden' name='module_id' value='" . $row['module_id'] . "'>
                            <td><input class='form-control' type='text' name='name' value='" . $row['title'] . "'></td>
                            <td><input class='form-control' type='text' name='tag' value='" . $row['tag'] . "'></td>
                            <td><input class='form-control' type='text' name='total' value='" . $row['total'] . "'></td>
                            <td><input class='btn btn-primary' type='submit' value='Update'></td>
                            </form>
                            <td><a class='btn btn-primary' href='view_question.php?module_id=" . $m_id . "&q_id=" . $row['id'] . "'>View Quiz</a></td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No employers found</td></tr>";
            }
            $conn->close();
        ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../../javascript/a_profile.js"></script> 
    
    <script src="../../javascript/popup-modal.js"></script>
    <script src="../../javascript/script.js"></script> 
</body>
</html>
