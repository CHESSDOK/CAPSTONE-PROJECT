<?php
include '../../php/conn_db.php';
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
        header("Location: ../login.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}
$userId = checkSession();
$user_id = $_GET['user_id'];
$module_id = $_GET['modules_id'];
$module_name = $_GET['module_name'];

// Fetch the current user's details
$sql = "SELECT * FROM applicant_profile WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$res = $stmt->get_result();

if (!$res) {
    die("Invalid query: " . $conn->error); 
}

$row = $res->fetch_assoc();
if (!$row) {
    die("User not found.");
}

// Fetch module content
$sql_module = "SELECT * FROM module_content WHERE modules_id = ?";
$stmt = $conn->prepare($sql_module);
$stmt->bind_param("i", $module_id);
$stmt->execute();
$result_module = $stmt->get_result();

if (!$result_module) {
    die("Invalid query: " . $conn->error);
}

$sql_quiz = "SELECT * FROM quiz_name WHERE module_id = ?";
$stmt_quiz = $conn->prepare($sql_quiz);
$stmt_quiz->bind_param("i", $module_id);
$stmt_quiz->execute();
$result_quiz = $stmt_quiz->get_result();

if ($row_quiz = $result_quiz->fetch_assoc()) {
    // Store quiz ID and name
    $quiz_id = $row_quiz['id'];
    $quiz_title = $row_quiz['title'];
} else {
    $quiz_id = null;
}

$module_id = $_GET['course_id'];
$sql = "SELECT * FROM modules WHERE course_id = $module_id ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Module Content</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="../../css/nav_float.css">
    <link rel="stylesheet" href="../../css/content.css">
</head>
<body>
    <!-- Navigation -->
    <nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
        <h1 class="h1">Content</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
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

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table border="0" class="menu">
                <tr><td><a style="text-align:left;" href="../../index(applicant).php" class="nav-link">Home</a></td></tr>
                <tr><td><a style="text-align:left;" href="applicant.php" class="nav-link">Applicant</a></td></tr>
                <tr><td><a style="text-align:left;" href="#" class="active nav-link">Training</a></td></tr>
                <tr><td><a style="text-align:left;" href="ofw_form.php" class="nav-link">OFW</a></td></tr>
                <tr><td><a style="text-align:left;" href="../../html/about.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a style="text-align:left;" href="../../html/contact.php" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>
    
<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="../../index(applicant).php" >Home</a></li>
        <li class="breadcrumb-item"><a href="training_list.php" >Training</a></li>
        <li class="breadcrumb-item"><a href="modules_list.php?user_id=<?php echo htmlspecialchars($user_id); ?>&course_id=<?php echo htmlspecialchars($module_id); ?>" >Module</a></li>
        <li class="breadcrumb-item active" aria-current="page">Material</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

    <!-- Page Content -->    
        <?php
        if ($result_module->num_rows > 0) {
            while ($row = $result_module->fetch_assoc()) {
                echo '<div class="container">';
                    echo '<p class="label">' . htmlspecialchars($module_name) . '</p>' . '<div class="divider"></div>';
                    echo '<p class="info">' . htmlspecialchars($row["description"]) . '</p>';
                        echo '<a class="video" href="' . htmlspecialchars($row['video']) . '" target="_blank">
                              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/YouTube_icon_%282013-2017%29.png/1200px-YouTube_icon_%282013-2017%29.png" 
                              alt="YouTube Logo" style="width: 45px; height: 30px; vertical-align: middle;">
                              View Video</a>';
                        echo '<a href="' . htmlspecialchars($row['file_path']) . '" target="_blank">
                              <img class="icon" src="../../img/file_icon.png" alt="Logo" style="width: 32.5px; height: 35px; vertical-align: middle;">
                              Open File</a>';
                        echo '<a href="take_exam.php?module_id=' . htmlspecialchars($row["modules_id"]) . '&q_id=' . htmlspecialchars($quiz_id) . '&q_title=' . htmlspecialchars($quiz_title) . '" target="_blank">
                              <img class="icon" src="../../img/quiz.png" alt="Logo" style="width: 32.5px; height: 35px; vertical-align: middle;">
                              Take Quiz</a>';
                echo '</div>';
            }
        } else {
            echo "<tr><td colspan='4'>No module content found</td></tr>";
        }
        $conn->close();
        ?> 

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="../../javascript/script.js"></script>
</body>
</html>

