<!DOCTYPE html>
<html lang="en">
<?php
include '../../php/conn_db.php';

function checkSession() {
  session_start(); // Start the session

  // Check if the session variable 'id' is set
  if (!isset($_SESSION['id'])) {
      // Redirect to login page if session not found
      header("Location: html/login_ofw.html");
      exit();
  } else {
      // If session exists, store the session data in a variable
      return $_SESSION['id'];
  }
}
$userId = checkSession();

$sql = "SELECT * FROM ofw_profile WHERE id = ?";
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us Page</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link rel="stylesheet" href="../../css/nav_float.css">
</head>
<style>
    .offcanvas .nav-link {
        color: #333 !important; /* Change link color to #333 */
    }

    .offcanvas {
        transition: transform 0.3s ease-in-out !important; /* Adjust the speed of the open/close animation */
    }

    .h-container{
    width: 90%;
    margin: 5vh auto;
    }
</style>
<body>
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
        <a class='openEmployersBtn' href='#'><img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle"></a>
        </div>
        <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
        <?php if (!empty($row['profile_image'])): ?>
            <img id="preview" src="../../php/ofw/profile/<?php echo $row['profile_image']; ?>" alt="Profile Image" class="circular--square">
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


    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
        <table class="menu">
                <tr><td><a href="ofw_home.php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="ofw_form.php" class="nav-link">Survey</a></td></tr>
                <tr><td><a href="About.php" class="active nav-link">About Us</a></td></tr>
                <tr><td><a href="Contact.php" class="nav-link">Contact Us</a></td></tr>
          </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="ofw_home.php" >Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

<div class="h-container">   
    <div class="container-fluid bg-light py-3 ">
        <div class="text-center">
            <h1 class="display-4">City Government of Los Baños Public Employment Service Office (PESO)</h1>
        </div>
    </div>
</div>

<!-- Sub-Header Section -->
<div class="container my-5">
    <div class="card" style="max-width: 800px; margin: auto; border: none;">
        <div class="card-body d-flex align-items-center p-4 rounded shadow-lg justify-content-between" 
             style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
            <div class="content-section" style="flex: 1; margin-right: 20px;">
                <div class="text-center">
                    <h2 class="h3 mb-4" style="color: #007bff;">Mandate</h2>
                </div>
                <div>
                    <p class="lead mb-3 text-justify">A Public Employment Service Office (PESO) is a non-fee charging multi-service provider established or accredited pursuant to Republic Act 8759 otherwise known as the PESO Act of 1999, as amended by Republic Act 10691.</p>
                    <p class="text-justify">PESO is a conduit of the Department of Labor and Employment in the implementation of employment facilitation programs in the locality.</p>
                </div>
            </div>

            <div class="sub-header-logo-container">
                <img src="../../img/logo_peso.png" alt="PESO Logo" class="img-fluid" style="max-width: 250px;">
            </div>
        </div>
    </div>
</div>

<!-- Body Section with Mission, Vision, Values -->
<div class="container p-3 my-4">
    <div class="row text-center">
        <!-- Mission Card -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <img src="../../img/mission.png" alt="Mission Logo" class="img-fluid my-2" style="margin: 30px;">
                    <hr class="my-3" style="border-top: 3px solid #ddd; width: 80%; margin: auto;">
                    <h2 class="h5">Mission</h2>
                    <p>To promote gainful employment by ensuring prompt, timely, and efficient delivery of full-cycle employment facilitation services.</p>
                </div>
            </div>
        </div>

        <!-- Vision Card -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <img src="../../img/vision.png" alt="Vision Logo" class="img-fluid my-2" style="margin: 30px;">
                    <hr class="my-3" style="border-top: 3px solid #ddd; width: 80%; margin: auto;">
                    <h2 class="h5">Vision</h2>
                    <p>A decent job for at least one member of Tacurongnon household.</p>
                </div>
            </div>
        </div>

        <!-- Values Card -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <img src="../../img/values.png" alt="Values Logo" class="img-fluid my-2" style="margin: 30px;">
                    <hr class="my-3" style="border-top: 3px solid #ddd; width: 80%; margin: auto;">
                    <h2 class="h5">Values</h2>
                    <p>Passion<br>Empathy<br>Social Responsibility<br>Open-Mindedness</p>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Organizational Outcome Section -->
<div class="container my-5 p-4 bg-light border rounded shadow-lg">
    <div class="text-center">
        <h1 class="display-5 mb-4" style="color: #007bff;">Organizational Outcome</h1>
        <p class="lead">Gainful employment for Tacurong City’s labor force.</p>
    </div>
</div>


<!-- Objectives Section -->
<div class="container my-5 p-4 bg-white border rounded shadow-sm">
    <h1 class="display-6 text-center mb-4" style="color: #007bff;">Objectives</h1>
    <p class="lead text-center">Citing provisions of RA 10691, the LGU Tacurong PESO shall ensure prompt, timely, and efficient delivery of full-cycle employment facilitation services. Towards this end, it shall:</p>
    
    <ul class="list-unstyled mt-4">
        <li class="mb-3">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Provide a venue where clients could avail of various employment services, such as LMI, referrals, training, and entrepreneurial, reintegration, and other services.
        </li>
        <li class="mb-3">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Serve as referral and Information center for the DOLE and other government agencies by making available data and information on their respective programs.
        </li>
        <li class="mb-3">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Provide clients with adequate information on employment and the labor market situation.
        </li>
        <li class="mb-3">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Establish linkages with other PESOs for job exchange and other employment–related services.
        </li>
        <li class="mb-3">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Provide information on other DOLE programs.
        </li>
    </ul>
</div>



<!-- Officers Section -->
<div class="container my-4 p-4">
    <h1 class="display-6 text-center mb-5" style="color: #007bff;">Officers</h1>
    
    <div id="officersCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner text-center">
            <!-- Person 1 -->
            <div class="carousel-item active">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../../img/user-placeholder.png" alt="Person 1" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>Person 1</h3>
                        <p>Job Title 1</p>
                    </div>
                </div>
            </div>

            <!-- Person 2 -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../../img/user-placeholder.png" alt="Person 2" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>Person 2</h3>
                        <p>Job Title 2</p>
                    </div>
                </div>
            </div>

            <!-- Person 3 -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../../img/user-placeholder.png" alt="Person 3" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>Person 3</h3>
                        <p>Job Title 3</p>
                    </div>
                </div>
            </div>

            <!-- Person 4 -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../../img/user-placeholder.png" alt="Person 4" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>Person 4</h3>
                        <p>Job Title 4</p>
                    </div>
                </div>
            </div>

            <!-- Person 5 -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>Person 5</h3>
                        <p>Job Title 5</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#officersCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#officersCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
    // Get elements
const burgerToggle = document.getElementById('burgerToggle');
const offcanvasMenu = new bootstrap.Offcanvas(document.getElementById('offcanvasMenu'));

// Toggle burger class and offcanvas menu
burgerToggle.addEventListener('click', function() {
    // Toggle burger active class for animation
    burgerToggle.classList.toggle('active');

    // Open or close the offcanvas menu
    if (offcanvasMenu._isShown) {
        offcanvasMenu.hide();
    } else {
        offcanvasMenu.show();
    }
});

$(document).ready(function(){
    // Initialize popover with multiple links in the content
    $('.profile-icon').popover({
        trigger: 'click', 
        html: true, // Allow HTML content
        animation: true, // Enable animation
        content: function() {
            return `
                <a class="link" href="a_profile.php"  id="emprof">Profile</a><br>
                <a class="link" href="logout.php">Logout</a>
            `;
        }
    });
// Close popover when clicking outside
$(document).on('click', function (e) {
    const target = $(e.target);
    if (!target.closest('.profile-icon').length) {
        $('.profile-icon').popover('hide');
    }
});
});
</script>

</body>
</html>
