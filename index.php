<!DOCTYPE html>
<html lang="en">
<head>
    <title>Landing Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- External CSS and Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/modal-form.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/notif.css">

    <!-- Internal Styles for Widgets -->
    <style>
        /* Styles for widgets */
        #employerWidget, #newsWidget {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        #employerWidget {
            top: 12%;
            height: 35%;
        }
        
        #newsWidget {
            top: 50%;
            height: 50%;
        }

        .btn-close-widget {
            float: right;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .news-item {
            margin-bottom: 15px;
        }

        .news-item img {
            width: 100%;
            border-radius: 8px;
        }

        .news-title {
            font-weight: bold;
            margin-top: 10px;
            font-size: 1.2em;
        }

        .news-description {
            font-size: 0.9em;
            color: #555;
        }
    </style>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">
            <img src="img/logo_peso.png" alt="Logo">
            <a href="#"> PESO-Los Baños.ph</a>
        </div>
        
        <div class="profile-login"></div>
        
        <!-- Burger Icon -->
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
                    <tr><td><a href="#" class="active nav-link">Home</a></td></tr>
                    <tr><td><a href="html/about.php" class="nav-link">About Us</a></td></tr>
                    <tr><td><a href="html/contact.php" class="nav-link">Contact Us</a></td></tr>
                </table>
            </div>
        </div>
    </nav>

   <!-- Body Content -->
<div class="table-container">
    <!-- Row containing all widgets and main content -->
    <div class="row">
        
        
        
        <!-- Main Content Fields (Col 6) -->
        <div class="col-md-8">
            <div class="background-container">
                
                <!-- PESO and Location Information -->
                <div class="row">
                    <div class="col-12 container_whole">
                        <label class="lbl_1">PESO</label>
                        <label class="lbl_2">Los Baños</label>
                    </div>
                </div>
                
                <!-- Public Employment Service Office Label -->
                <div class="row">
                    <div class="col-12 container_whole">
                        <label class="lbl_3">Public Employment Service Office</label>
                    </div>
                </div>
                
                <!-- "I AM" Section with Links -->
                <div class="row">
                    <div class="col-12 container_whole">
                        <!-- Breadcrumb Structure using Bootstrap -->
                          <nav aria-label="breadcrumb">
                              <ol class="breadcrumb">
                                  <li><label class="lbl_4">LOGIN/REGISTER AS A &nbsp</label></li>
                                  <li class="breadcrumb-item"><a href="html/applicant_login.html"> Applicant</a></li>
                                  <li class="breadcrumb-item"><a href="html/employer_login.html">Employer</a></li>
                                  <li class="breadcrumb-item"><a href="html/ofw_login.html#">OFW</a></li>
                              </ol>
                          </nav>

                    </div>
                </div>
                
                <!-- Description Text Area -->
                <div class="row">
                    <div class="col-12 container_whole">
                        <textarea readonly>
                            Available in one roof the various employment promotion, manpower programs, 
                            and services of the DOLE and other government agencies to enable all types 
                            of clientele to know more about them and seek specific assistance they require.
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>


  <!-- JavaScript: Widget and Popover Initialization -->
<script>
$(document).ready(function () {
    // Load employer widget content on page load
    $.ajax({
        url: 'joblist.php',
        method: 'GET',
        success: function (response) {
            $('#employersModuleContent').html(response);
            $('#employerWidget').fadeIn();
        }
    });

    // Load latest news content dynamically
    $.ajax({
        url: 'news.php',
        method: 'GET',
        success: function (response) {
            $('#newsModuleContent').html(response);
            $('#newsWidget').fadeIn();
        }
    });

    // Close widgets without adjusting table container width
    $('.btn-close-widget').click(function () {
        var widget = $(this).closest('div');  // Find the closest widget container
        widget.fadeOut();  // Simply fade out the widget
    });
});
</script>





    <!-- External JavaScript File -->
    <script src="javascript/script.js"></script>
</body>
</html>
