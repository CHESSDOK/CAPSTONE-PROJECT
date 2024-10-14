<?php
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

$admin = checkSession();
include '../../php/conn_db.php';
$q_id = $_GET['q_id'];
$module_id = $_GET['module_id'];
$course_id = $_GET['course_id'];
$total = $_GET['total'];


$sql = "SELECT * FROM question WHERE quiz_id = $q_id";
$result = $conn->query($sql);

$pic_sql = "SELECT * FROM admin_profile WHERE id = ?";
$pic_stmt = $conn->prepare($pic_sql);
$pic_stmt->bind_param("i", $admin);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../../css/modal-form.css">
    <link rel="stylesheet" href="../../css/admin_course.css">
    <link rel="stylesheet" href="../../css/nav_float.css">
    <title>Enter Questions</title>
</head>
<body>

<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
      <h1 class="ofw-h1">Update Quiz</h1>
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
                <tr><td><a href="employer_list.php" class="nav-link">Employer List</a></td></tr>
                <tr><td><a href="#" class="active nav-link">Course List</a></td></tr>
                <tr><td><a href="ofw_case.php" class="nav-link">OFW Cases</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admin_home.php" >Home</a></li>
    <li class="breadcrumb-item"><a href="course_list.php" >Courses</a></li>
    <li class="breadcrumb-item"><a href="module_list.php?course_id=<?php echo $course_id; ?>">Module List</a></li>
    <li class="breadcrumb-item"><a href="quiz_list.php?course_id=<?php echo $course_id; ?>&modules_id=<?php echo $module_id; ?>">Quiz List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Quiz Question</li>
  </ol>
</nav>

<div class="container form-box">
    <div class="side-by-side-container">
        <div class="scrollable-container form-section">
            <form class="form" action="save_question.php" method="post">
                <h2 class="title mb-4">Enter Questions</h2>
                <input type="hidden" name="eid" value="<?php echo $q_id; ?>">
                <input type="hidden" name="mid" value="<?php echo $module_id; ?>">
                <?php for($i = 1; $i <= $total; $i++) { ?>
                <div class="form-container mb-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <textarea class="form-control" name="questions[]" placeholder="Question <?php echo $i; ?>" required rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select name="correct_answer[]" class="form-select" required>
                                <option value="">Select correct answer</option>
                                <option value="a">Option A</option>
                                <option value="b">Option B</option>
                                <option value="c">Option C</option>
                                <option value="d">Option D</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="text" class="form-control" name="option_a[]" placeholder="Option A" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="text" class="form-control" name="option_b[]" placeholder="Option B" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="text" class="form-control" name="option_c[]" placeholder="Option C" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="text" class="form-control" name="option_d[]" placeholder="Option D" required>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </form>
            <button type="submit" name="save" class="btn btn-primary">SAVE QUESTIONS</button>
        </div>

        <div class="scrollable-container table-section">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Question</th>
                        <th>Correct Answer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["question"] . "</td>
                                    <td>" . $row["correct_answer"] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No questions found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>





</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="../../javascript/a_profile.js"></script> 
    <script src="../../javascript/script.js"></script> 
</body>
</html>


