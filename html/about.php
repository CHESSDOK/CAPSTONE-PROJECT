<?php
include '../php/conn_db.php';
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
        header("Location: login.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}
$userId = checkSession();

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
    <title>About Us Page</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/about.css">
    <link rel="stylesheet" href="../css/nav_float.css">
</head>
<body>
<!-- Navigation -->
<nav>
    <div class="logo">
        <img src="../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
        <h1 class="h1">About Us</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
    <?php if (!empty($row['photo'])): ?>
        <img id="preview" src="../php/applicant/images/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
    <?php else: ?>
        <img src="../img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
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
              <tr><td><a href="../index(applicant).php" class="nav-link">Home</a></td></tr>
              <tr><td><a href="applicant/applicant.php" class="nav-link">Applicant</a></td></tr>
              <tr><td><a href="applicant/training_list.php" class="nav-link">Training</a></td></tr>
              <tr><td><a href="applicant/ofw_home.php" class="nav-link">OFW</a></td></tr>
              <tr><td><a href="#" class="nav-link">About Us</a></td></tr>
              <tr><td><a href="contact.php" class="active nav-link">Contact Us</a></td></tr>
          </table>
        </div>
    </div>
</nav>

    <div class="header-container">
        <h1 class="header-title">City Government of Los Baños Public Employment Service Office (PESO)</h1>
    </div>
    <div class="sub-header">
        <div class="sub-header-text">
            <div class="section">
                <h2>Mandate</h2>
                <p>A Public Employment Service Office (PESO) is a non-fee charging multi-service provider established or accredited pursuant to Republic Act 8759 otherwise known as the PESO Act of 1999, as amended by Republic Act 10691.</p>
                <p>PESO is a conduit of the Department of Labor and Employment in the implementation of employment facilitation programs in the locality.</p>
            </div>
        </div>
        <div class="sub-header-logo-container">
            <img src="../img/logo_peso.png" alt="PESO Logo" class="sub-header-logo">
        </div>
    </div>
    <!-- Body -->
    <div class="wrapper">
        <div class="principle-container">
            <div class="section">
                <img src="../img/mission.png" alt="Mission Logo">
                <hr>
                <h2>Mission</h2>
                <p class="section-box">To promote gainful employment by ensuring prompt, timely, and efficient delivery of full-cycle employment facilitation services.</p>
            </div>
            <div class="divider"></div>
            <div class="section">
                <img src="../img/vision.png" alt="Vision Logo">
                <hr>
                <h2>Vision</h2>
                <p class="section-box">A decent job for at least one member of Tacurongnon household.</p>
            </div>
            <div class="divider"></div>
            <div class="section">
                <img src="../img/values.png" alt="Values Logo">
                <hr>
                <h2>Values</h2>
                <p class="section-box1">Passion<br>Empathy<br>Social Responsibility<br>Open - Mindedness</p>
            </div>
        </div>
    </div>
    <hr>
    <div class="header-2">
        <h1 class="header-t2">Organizational Outcome</h1>
        <p>Gainful employment for Tacurong City’s labor force.</p>
    </div>
    <hr> 
    <div class="header-3">
        <h1 class="header-t3">Objectives</h1>
        <p class="h3p">Citing provisions of RA 10691, the LGU Tacurong PESO shall ensure prompt, timely, and efficient delivery of full-cycle employment facilitation services. Towards this end, it shall:</p>
        <p>1. Provide a venue where clients could avail simultaneously various employment services, such as LMI, referrals, training, and entrepreneurial, reintegration, and other services;</p>
        <p>2. Serve as referral and Information center for the DOLE and other government agencies by making available data and information on their respective programs;</p>
        <p>3. Provide clients with adequate information for the DOLE and other government agencies by making available data and information on their respective programs;</p>
        <p>4. Provide clients with adequate information on employment and the labor market situation; and</p>
        <p>5. Establish linkages with other PESOs for job exchange and other employment–related services. The PESO shall also provide information on other DOLE programs.</p>
    </div>
    <hr>
    <!-- about image --> 
    <h1 class="h3">Officers</h1>
    <div id="image-container-module">
        <div class="image-item">
            <img src="../img/logo_peso.png" alt="Person 1">
            <div class="info">
                <h3>Person 1</h3>
                <p>Job Title 1</p>
            </div>
        </div>
        <div class="image-item">
            <img src="../img/logo_peso.png" alt="Person 2">
            <div class="info">
                <h3>Person 2</h3>
                <p>Job Title 2</p>
            </div>
        </div>
        <div class="image-item">
            <img src="../img/logo_peso.png" alt="Person 3">
            <div class="info">
                <h3>Person 3</h3>
                <p>Job Title 3</p>
            </div>
        </div>
        <div class="image-item">
            <img src="../img/logo_peso.png" alt="Person 4">
            <div class="info">
                <h3>Person 4</h3>
                <p>Job Title 4</p>
            </div>
        </div>
        <div class="image-item">
            <img src="../img/logo_peso.png" alt="Person 5">
            <div class="info">
                <h3>Person 5</h3>
                <p>Job Title 5</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->
</body>
</html>
