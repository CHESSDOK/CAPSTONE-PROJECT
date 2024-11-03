<!DOCTYPE html>
<html lang="en">
<head>
  <title>Landing Page</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="css/modal-form.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/notif.css">
  <style>
    /* Style for the employer widget on the left */
    #employerWidget {
      position: fixed;
      top: 12%;
      left: 0;
      width: 34%;
      height: 35%;
      background: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      overflow-y: auto;
      display: none;
      padding: 20px;
    }

    /* Style for the news widget below the employer widget */
    #newsWidget {
      position: fixed;
      top: 50%;
      left: 0;
      width: 34%;
      height: 50%;
      background: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      overflow-y: auto;
      display: none;
      padding: 20px;
    }

    .btn-close-widget3 {
      float: right;
      font-size: 1.2rem;
      cursor: pointer;
    }
    .btn-close-widget2 {
      float: right;
      font-size: 1.2rem;
      cursor: pointer;
    }
    .btn-close-widget1 {
      float: right;
      font-size: 1.2rem;
      cursor: pointer;
    }

    /* Sample layout for news item */
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

    #chartwidget {
      position: fixed;
      top: 12%;
      right: 0;
      width: 64%;
      height: 555px;
      background: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      overflow-y: auto;
      display: none;
      padding: 20px;
    }
  </style>
</head>
<body>

    <!-- Navigation -->

    <nav>
        <div class="logo">
            <img src="img/logo_peso.png" alt="Logo">
            <a href="#"> PESO-lb.ph</a>
        </div>
    
        <div class="profile-icons">
            <div class="notif-icon" data-bs-toggle="popover" data-bs-content="Notification" data-bs-placement="bottom">
              <a class='openEmployersBtn' href='#'><img id="#" src="img/notif.png" alt="Profile Picture" class="rounded-circle"></a>
            </div>
            
            <div class="profile-icon"  data-bs-toggle="popover_index" data-bs-content="Login/Register" data-bs-placement="bottom">
                <img src="img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
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
                    <tr><td><a href="#" class="active nav-link">Home</a></td></tr>
                    <tr><td><a href="html/about.php" class="nav-link">About Us</a></td></tr>
                    <tr><td><a href="html/contact.php" class="nav-link">Contact Us</a></td></tr>
                </table>
            </div>
        </div>
    </nav>
    
     
    <!-- Left Side Widget for Employers -->
    <div id="employerWidget">
      <span class="btn-close-widget3"></span>
      <div id="employersModuleContent">
          <!-- Module content will be dynamically loaded here -->
      </div>
    </div>
    <!-- News Widget -->
    <div id="newsWidget">
      <span class="btn-close-widget2"></span>
      <div id="newsModuleContent">
          <!-- Sample News Layout -->
      </div>
    </div>

    <!-- chart Widget -->
    <div id="chartwidget">
      <span class="btn-close-widget1"></span>
      <div id="chartModuleContent">
        <?php include 'chart.php'; ?>
      </div>
    </div>
    <!-- Body -->
           <table >
           <tr>
             <td class="container_whole" colspan="2">
               <label class="lbl_1">PESO</label>
               <label class="lbl_2">Los Baños</label>
             </td>
           </tr>
           <tr>
             <td class="container_whole" colspan="2">
               <label class="lbl_3">Public Employment Service Office</label>
             </td>
           </tr>
           <tr>
             <td class="container_whole" colspan="2">
               <label class="lbl_4">JOB PORTAL</label>
             </td>
           </tr>
           <tr>
             <td class="container_whole" colspan="2">
               <label class="lbl_5">YOUR</label>
               <label class="lbl_6">NEW CAREER</label>
               <label class="lbl_7">STARTS HERE!</label>
             </td>
           </tr>
           <tr>
             <td class="container_whole">
               <button class="btn btn-primary lbl_8">Find Job</button>
             </td>
           </tr>
           <tr>
             <td class="container_whole" colspan="2">
               <textarea readonly>
                   Available in one roof the various employment promotion, manpower programs, 
                   and services of the DOLE and other government agencies to enable all types 
                   of clientele to know more about them and seek specific assistance they require.
               </textarea>
             </td>
           </tr>
           </table>
<script>
    $(document).ready(function () {
        // Load the widget content on page load
        $.ajax({
            url: 'joblist.php',
            method: 'GET',
            success: function (response) {
                $('#employersModuleContent').html(response);
                $('#employerWidget').fadeIn(); // Display the widget on load
            }
        });

        // Load the latest news content dynamically
        $.ajax({
            url: 'news.php', // Path to the PHP file
            method: 'GET',
            success: function (response) {
                $('#newsModuleContent').html(response);
                $('#newsWidget').fadeIn(); // Display the news widget on load
            }
        });

        // Display the chart widget and initialize the chart
        $('#chartwidget').fadeIn();
        initializeChart(); // Initialize the chart after page loads

        // Close widgets when the close button is clicked
        $('.btn-close-widget1').click(function () {
            $('#chartwidget').fadeOut();
        });
        $('.btn-close-widget2').click(function () {
            $('#newsWidget').fadeOut();
        });
        $('.btn-close-widget3').click(function () {
            $('#employerWidget').fadeOut();
        });
    });
</script>


   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <script>

    
$(document).ready(function(){
    // Initialize popover with multiple links in the content
    $('.profile-icon').popover({
        trigger: 'click', 
        html: true, // Allow HTML content
        animation: true, // Enable animation
        content: function() {
            return `
                <a class="link" >Profile</a><br>
                <a class="link" href="html/combine_login.html" id="link3">Login</a>
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

   <script src="javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->
</body>
</html>
