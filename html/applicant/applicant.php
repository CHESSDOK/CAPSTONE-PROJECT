<?php
include '../../php/conn_db.php';
session_start();
$userId = $_SESSION['id'];

$sql = "SELECT * FROM register WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $conn->error); 
}

$row = $result->fetch_assoc();
if (!$row) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <link rel="stylesheet" href="../../css/nav_float.css">
  <link rel="stylesheet" href="../../css/applicant.css">
  <link
      href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
      rel="stylesheet"
    />
</head>
<body>

    <!-- Navigation -->
    <nav>
        <div class="logo">
            <img src="img/logo_peso.png" alt="Logo">
            <a href="#"> PESO-lb.ph</a>
        </div>
        <label class="burger" for="burger">
            <input type="checkbox" id="burger">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <ul class="menu">
            <li><a href="#" class="active">Home</a></li>
            <li><a href="html/about.html">About Us</a></li>
            <li><a href="html/applicant/training_list.php">training</a></li>
            <li><a href="html/course.html">course</a></li>
            <li><a href="html/services.html">Services</a></li>
            <li><a href="html/applicant/applicant.php">Applicant</a></li>
        </ul>
        <div class="auth">
        <button id ="emprof">  <?php echo htmlspecialchars($row['username']); ?> </button>
        </div>
    </nav>
  
    <header>
        <h1 class="h1">Applicant Dashboard</h1>
    </header>
    <div class="container">
        <div class="label">
            <h2>Job Listings</h2>
        </div>

<!-- search bar-->

<form method="GET" action="">
    <input type="text" name="search" placeholder="Search for a job..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button type="submit">Search</button>
    <?php if (isset($_GET['search']) && $_GET['search'] != ''): ?>
        <a href="?" class="clear-button">Clear</a>
    <?php endif; ?>
</form>

<!--listing loop-->
        <div class="container text-center">
        <div class="job-list"> 
            <?php include '../../php/applicant/job_list.php'; ?>
        </div>
    </div>

   <script src="../../javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->
</body>
</html>