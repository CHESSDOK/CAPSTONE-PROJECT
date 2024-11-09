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

    <!-- Internal Styles for Widgets -->
    <style>
        /* Styles for widgets */
        #employerWidget, #newsWidget, .background-container {
    background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white */
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
   <div class="table-containers">
    <div class="row">

        <!-- Main Content Fields (Col 6) -->
        <div class="col-md-8 background-container">
            <!-- PESO and Location Information -->
            <label class="lbl_1">PESO</label>
            <label class="lbl_2">Los Baños</label><br>

            <!-- Public Employment Service Office Label -->
            <label class="lbl_3">Public Employment Service Office</label>

            <!-- "I AM" Section with Links (Breadcrumb) -->
            <ol class="breadcrumb">
                <li><label class="lbl_4">LOGIN/REGISTER AS A &nbsp;</label></li>
                <li class="breadcrumb-item lbl_5"><a href="html/applicant_login.html">APPLICANT</a></li>
                <li class="breadcrumb-item lbl_5"><a href="html/employer_login.html">EMPLOYER</a></li>
                <li class="breadcrumb-item lbl_5"><a href="html/ofw_login.html#">OFW</a></li>
            </ol>

            <!-- Description Text Area -->
            <textarea readonly>
Available in one roof the various employment promotion, manpower programs, 
and services of the DOLE and other government agencies to enable all types 
of clientele to know more about them and seek specific assistance they require.
            </textarea>
        </div>

        <!-- News Widget (Col 3) -->
        <div id="newsWidget" class="col-md-3">
            <div id="newsModuleContent">
                <!-- Sample News Layout -->
            </div>

            <div id="employersModuleContent">
                <!-- Module content will be dynamically loaded here -->
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

    // Disable the close button by commenting out the close functionality
    // $('.btn-close-widget').click(function () {
    //     var widget = $(this).closest('div');  // Find the closest widget container
    //     widget.fadeOut();  // Remove this line to prevent closing
    // });
});

</script>





    <!-- External JavaScript File -->
    <script src="javascript/script.js"></script>
</body>
</html>
