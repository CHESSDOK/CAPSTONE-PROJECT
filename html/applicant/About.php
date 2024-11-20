<!DOCTYPE html>
<html lang="en">
<?php
include '../../php/conn_db.php';

function checkSession() {
  session_start(); // Start the session

  // Check if the session variable 'id' is set
  if (!isset($_SESSION['id'])) {
      // Redirect to login page if session not found
      header("Location: html/login.html");
      exit();
  } else {
      // If session exists, store the session data in a variable
      return $_SESSION['id'];
  }
}
$userId = checkSession();

$sql = "SELECT * FROM applicant_profile WHERE user_id = ?";
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
    .h-container{
    width: 90%;
    margin: 5vh auto;
}
</style>
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
            <img id="#" src="../img/notif.png" alt="Notification Icon" class="rounded-circle">
        </div>

        <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
            <img id="preview" src="../img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
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
                <tr><td><a href="../index.php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="about.php" class="active nav-link">About Us</a></td></tr>
                <tr><td><a href="contact.php" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>

    <nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
        <div>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="../index.html" >Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a>About Us</a></li>
          </ol>
        </div>
        <a href="javascript:history.back()" class="return me-2">
          <i class="fas fa-reply"></i> Back
        </a>
    </nav>
    
    <!-- Header Section -->

<div class="h-container">   
    <div class="container-fluid bg-light py-3 ">
        <div class="text-center">
            <h1 class="display-10">City Government of Los Baños Public Employment Service Office (PESO)</h1>
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
                    <p class="text-justify">Section 9, 1987 Constitution – The State shall…. promote full employment, a rising standard of living, and an improved quality of life for all.</p>
                    <p class="text-justify">Article 3, Philippine Labor Code– The State shall afford protection to labor, promote full employment, ensure equal work opportunities.</p>
                    <p class="text-justify">Article 12, Philippine Labor Code– The State should facilitate a free choice of available employment by persons seeking work in conformity with the national interest.</p>
                </div>
            </div>

            <div class="sub-header-logo-container">
                <img src="../img/logo_peso.png" alt="PESO Logo" class="img-fluid" style="max-width: 250px;">
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
                    <img src="../img/mission.png" alt="Mission Logo" class="img-fluid my-2" style="margin: 30px;">
                    <hr class="my-3" style="border-top: 3px solid #ddd; width: 80%; margin: auto;">
                    <h2 class="h5">Mission</h2>
                    <p>To carry out full employment and equality of employment opportunities for all, and for this purpose, strengthen and expand the existing employment facilitation service machinery.</p>
                </div>
            </div>
        </div>

        <!-- Vision Card -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <img src="../img/vision.png" alt="Vision Logo" class="img-fluid my-2" style="margin: 30px;">
                    <hr class="my-3" style="border-top: 3px solid #ddd; width: 80%; margin: auto;">
                    <h2 class="h5">Vision</h2>
                    <p>HANAPBUHAY PARA SA LAHAT TUNGO SA MAUNLAD, MASAGANA AT MASAYANG LOS BAÑOS</p>
                </div>
            </div>
        </div>

        <!-- Values Card -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <img src="../img/values.png" alt="Values Logo" class="img-fluid my-2" style="margin: 30px;">
                    <hr class="my-3" style="border-top: 3px solid #ddd; width: 80%; margin: auto;">
                    <h2 class="h5">Values</h2>
                    <p>Integrity / Honesty / Teamwork<br>Innovation / Cooperation / Diversity / Trust<br>Passion / Respect  /  Accountability</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ABOUT PESO Section -->
<div class="container my-5 p-4 bg-light border rounded shadow-lg">
    <div class="text-center">
        <h1 class="display-10 mb-4" style="color: #007bff;">About PESO  </h1>
        <p class="text-justify">The Public Employment Service Office (PESO) is a multi-service facility designed to offer employment information and assistance to clients of the Department of Labor and Employment (DOLE) and the constituents of Local Government Units (LGUs). PESO consolidates various employment promotion programs and services from DOLE and other government agencies, making it easier for all types of clientele to access information and seek the specific assistance they need.</p>
    </div>
</div>

<!-- Objectives Section -->
<div class="container my-5 p-4 border rounded shadow-sm">
    <h1 class="display-10 text-center mb-4" style="color: #007bff;">Objectives of PESO</h1>
    <h5 class="display-7 mb-2" style="color: #007bff;">General Objectives</h5>
    <p class="lead text-justify">Ensure the prompt, timely and efficient delivery of employment service and provision of information on the other DOLE programs.</p>
    
    <h5 class="display-7 mb-2" style="color: #007bff;">Specific Objectives</h5>
    <ul class="list-unstyled mt-4">
        <li class="mb-3">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Provide a venue where people could explore simultaneously various employment options and actually seek assistance they prefer;
        </li>
        <li class="mb-3">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Serve as referral and information center for the various services and programs of DOLE and other government agencies present in the area;
        </li>
        <li class="mb-3">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Provide clients with adequate information on employment and labor market situation in the area; and
        </li>
        <li class="mb-3">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Network with other PESOs within the region on employment for job exchange purposes.
        </li>
    </ul>
</div>

<!-- Organizational Outcome Section -->
<div class="container my-5 p-4 border rounded shadow-lg">
        <h1 class="display-10 mb-4 text-center" style="color: #007bff;">Organizational Outcome</h1>
        <p class="lead">1. Full employment opportunities for all</p>
        <p class="lead">2. Capable and empowered citizenry  through skills training</p>
        <p class="lead">3. Efficient OFW and Migration Development Center</p>
        <p class="lead">4. Enterprise  Community through incubation and livelihood development</p>
</div>

<!-- Organizational Outcome Section -->
<div class="container bg-white my-5 p-4 border rounded shadow-lg">
    <h1 class="display-10 mb-4 text-center text-primary">PESO Programs</h1>

    <ul class="list-group list-group-flush lead">
        <li class="list-group-item border-0 ps-0">1. <strong>Provision of Labor Market Information</strong></li>
        
        <li class="list-group-item border-0 ps-0">2. <strong>Employment Facilitation</strong>
            <ul class="list-group list-group-flush ms-4">
                <li class="list-group-item border-0">a. Referral and Placement</li>
                <li class="list-group-item border-0">b. Local Recruitment Assistance</li>
                <li class="list-group-item border-0">c. JOB FAIR</li>
            </ul>
        </li>
        
        <li class="list-group-item border-0 ps-0">3. <strong>Employment Guidance and Counseling</strong>
            <ul class="list-group list-group-flush ms-4">
                <li class="list-group-item border-0">a. Employment Coaching</li>
                <li class="list-group-item border-0">b. Career Information Guidance</li>
            </ul>
        </li>
        
        <li class="list-group-item border-0 ps-0">4. <strong>Manpower Skills Training Program</strong> (Kasanayan at Hanapbuhay Program)</li>
        
        <li class="list-group-item border-0 ps-0">5. <strong>Microbiz Incubation and Livelihood Development Program</strong></li>
        
        <li class="list-group-item border-0 ps-0">6. <strong>Special Programs:</strong>
            <ul class="list-group list-group-flush ms-4">
                <li class="list-group-item border-0">a. Special Program For Employment of Students</li>
                <li class="list-group-item border-0">b. KABATAAN Program
                    <ul class="list-group list-group-flush ms-4">
                        <li class="list-group-item border-0">i. Youth Entrepreneurship Development</li>
                    </ul>
                </li>
                <li class="list-group-item border-0">c. Workers Hiring for Infrastructure Program (WHIP)</li>
                <li class="list-group-item border-0">d. Tulong Alalay Para sa Taong May Kapansanan (TULAY)</li>
                <li class="list-group-item border-0">e. Tulong Hanapbuhay Para sa Mga Displaced Workers (TUPAD)</li>
            </ul>
        </li>
    </ul>
</div>


<!-- Officers Section -->
<div class="container my-4 p-4">
    <h1 class="display-10 text-center mb-5" style="color: #007bff;">MUNICIPAL PUBLIC EMPLOYMENT SERVICE OFFICE</h1>
    
    <div id="officersCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner text-center">
            <!-- Person 1 -->
            <div class="carousel-item active">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 1" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>HON. ANTHONY F. GENUINO</h3>
                        <p>Local Chief Executive</p>
                    </div>
                </div>
            </div>

            <!-- Person 2 -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 2" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>GLICERIA A. TRINIDAD</h3>
                        <p>Senior Labor and Employment Officer</p>
                    </div>
                </div>
            </div>

            <!-- Person 3 -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 3" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>THELMA VILLAMOR</h3>
                        <p>Trainer, Massage (R.C.)</p>
                    </div>
                </div>
            </div>

            <!-- Person 4 -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 4" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>GERALD AGOJO</h3>
                        <p>Trainer SMAW (R.C.)</p>
                    </div>
                </div>
            </div>

            <!-- Person 5 -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>VICTORIA LESCANO</h3>
                        <p>Trainer, Garments (R.C.)</p>
                    </div>
                </div>
            </div>

            <!-- Person 6  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>JOHN ERLL ESCOBEL</h3>
                        <p>Trainer CSS (R.C.)</p>
                    </div>
                </div>
            </div>

            <!-- Person 7 -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>Person 5</h3>
                        <p>Job Title 5</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>EDDIE SULAT</h3>
                        <p>TADLAC</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>GINALYN HORNILLA</h3>
                        <p>TIMUGAN</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>ROLLIEDAN NATIVIDAD</h3>
                        <p>MALINTA</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>WENIEFREDA DE LEON</h3>
                        <p>MAYONDON</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>MILAGROS DEANGKINAY</h3>
                        <p>BAYOG</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>PROLEN ARDIETTA BELEN</h3>
                        <p>BATONG MALAKE</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>MAYLYN RUBIO</h3>
                        <p> TUNTUNGIN-PUTHO</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>LORELIE LIWANAG</h3>
                        <p>ANOS</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>LEONILA LOBRIN</h3>
                        <p>SAN ANTONIO</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>SUSAN DE LOS REYES</h3>
                        <p>BAGONG SILANG</p>
                    </div>
                </div>
            </div>
            
            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>EDNA ABULENCIA</h3>
                        <p>BAMBANG</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>MARCOPOLO BADILLO</h3>
                        <p>BAYBAYIN</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>FE ALCACHUPAS</h3>
                        <p>MAAHAS</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>JEVARIE DE VILLA</h3>
                        <p>Administrative Aid </p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>LINA LAVA</h3>
                        <p>Administrative Aid</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>MARCELO GIBAS</h3>
                        <p>Maintenance</p>
                    </div>
                </div>
            </div>

            <!-- Person  -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <img src="../img/user-placeholder.png" alt="Person 5" class="img-fluid rounded-circle mb-2" style="width: 250px; height: 250px;">
                        <h3>LESLY ISAAC</h3>
                        <p>Administrative Aid</p>
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
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                <a class="link" >Profile</a><br>
                <a class="link" href="login.html">Login</a>
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
