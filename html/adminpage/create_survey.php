<?php
    include 'conn_db.php';  // Database connection

    // Insert survey question
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $questions = $_POST['question'];
        $category = $_POST['category'];

        // Prepared statement for security
        $stmt = $conn->prepare("INSERT INTO survey_form (question, category) VALUES (?, ?)");
        $stmt->bind_param("ss", $questions, $category);

        if ($stmt->execute() === TRUE) {
            header("Location: create_survey.php");
            exit();  // Important to stop further script execution after redirect
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Fetch existing survey questions
    $sql_new = "SELECT * FROM survey_form ORDER BY category";
    $result = $conn->query($sql_new);

    // Initialize variable to track the current category
    $current_category = '';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
      <h1 class="ofw-h1">OFW Survey Creator</h1>
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
            <button type="button" class="btn-close offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table class="menu">
            <tr><td><a href="admin_home.php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="employer_list.php" class="nav-link">Employer List</a></td></tr>
                <tr><td><a href="course_list.php" class="nav-link">Course List</a></td></tr>
                <tr><td><a href="#" class="active nav-link">OFW Cases</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="admin_home.php" >Home</a></li>
        <li class="breadcrumb-item"><a href="ofw_case.php" >OFW Cases</a></li>
        <li class="breadcrumb-item active" aria-current="page">Survey Creator</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

<div class="table-containers grid gap-3">
    <form action="create_survey.php" method="POST">
        <table class="table table-borderless " style="background-color:transparent;">
        <thead>
            <th>Survey Question</th>
        </thead>
        <tbody class="grid gap-3 row-gap-0">
            <tr>
            <td>
                <input class="form-control" type="text" name="question" placeholder="Enter Survey Question" value="" required>
            </td>
            </tr>
            <tr>
            <td>
                <input class="form-control" type="text" name="category" placeholder="Survey Category"  value="" required>
            </td>
            </tr>
            <tr>
            <td>
                <input class="btn btn-primary" style="display:flex; position:flex-start;" type="submit" value="Submit">
            </td>
            </tr>
        </tbody>
        </table>
    </form>

  <table class="table table-borderless table-hover">
    <?php
    if ($result->num_rows > 0) {
        $current_category = ''; // To track the current category
        while ($row = $result->fetch_assoc()) {
            // Check if we are in a new category
            if ($current_category != $row['category']) {
                // If it's a new category, print it as a header
                echo "
                <thead>
                    <th class='text-start' colspan='2'><strong>Category: " . $row['category'] . "</strong></th>
                    <th colspan='2'> Actions</th>  
                </thead>
                ";
                // Update current category tracker
                $current_category = $row['category'];
            }

            // Print each question under its category
            echo "<tr>
                    <form action='update_survey.php' method='POST'>
                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                    <td><input class='form-control' type='text' name='question' value='" . $row["question"] . "'></td>
                    <td><input class='form-control' type='text' name='category' value='" . $row["category"] . "'></td>
                    <td><input class='btn btn-success mt-2' type='submit' value='Update'></td>
                    <td><a class='btn btn-danger mt-2' href='delete_survey.php?survey_id=".$row["id"]."'>DELETE</a></td>
                    </form>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No survey found</td></tr>";
    }
    ?>
  </table>
</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../../javascript/a_profile.js"></script>
    <script src="../../javascript/script.js"></script> 
</body>
</html>
