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
<<<<<<<< HEAD:index.php
      top: 12%;
      left: 0;
      width: 30%;
      height: 35%;
      background: rgba(255, 255, 255, 0.9);
========
      top: 8%;
      left: 0;
      width: 34%;
      height: 400px;
      background: white;
>>>>>>>> 5b2aeccbb35cdd0885444b197adf91ca14a2d613:index.html
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
<<<<<<<< HEAD:index.php
      width: 30%;
      height: 50%;
      background: rgba(255, 255, 255, 0.9);
========
      width: 34%;
      height: 450px;
      background: white;
>>>>>>>> 5b2aeccbb35cdd0885444b197adf91ca14a2d613:index.html
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      overflow-y: auto;
      display: none;
      padding: 20px;
    }

<<<<<<<< HEAD:index.php
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
========
    .btn-close-widget {
>>>>>>>> 5b2aeccbb35cdd0885444b197adf91ca14a2d613:index.html
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

<<<<<<<< HEAD:index.php
========
    #chartwidget {
      position: fixed;
      top: 8%;
      right: 0;
      width: 64%;
      height: 900px;
      background: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      overflow-y: auto;
      display: none;
      padding: 20px;
    }
>>>>>>>> 5b2aeccbb35cdd0885444b197adf91ca14a2d613:index.html
  </style>
</head>
<body>

    <!-- Navigation -->

    <nav>
        <div class="logo">
            <img src="img/logo_peso.png" alt="Logo">
            <a href="#"> PESO-lb.ph</a>
        </div>
    
<<<<<<<< HEAD:index.php
       <div class="profile-login">
            <a href = "html/combine_login.html"><button class="btn btn-primary lbl_8">login / signup</button></a>
========
        <div class="profile-icons">
            <div class="notif-icon" data-bs-toggle="popover" data-bs-content="Notification" data-bs-placement="bottom">
              <a class='openEmployersBtn' href='#'><img id="#" src="img/notif.png" alt="Profile Picture" class="rounded-circle"></a>
            </div>
            
            <div class="profile-icon"  data-bs-toggle="popover_index" data-bs-content="Login/Register" data-bs-placement="bottom">
                <img src="img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
            </div>
>>>>>>>> 5b2aeccbb35cdd0885444b197adf91ca14a2d613:index.html
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
<<<<<<<< HEAD:index.php
      <span class="btn-close-widget3">&times;</span>
========
      <span class="btn-close-widget">&times;</span>
>>>>>>>> 5b2aeccbb35cdd0885444b197adf91ca14a2d613:index.html
      <div id="employersModuleContent">
          <!-- Module content will be dynamically loaded here -->
      </div>
    </div>
    <!-- News Widget -->
    <div id="newsWidget">
<<<<<<<< HEAD:index.php
      <span class="btn-close-widget2">&times;</span>
========
      <span class="btn-close-widget">&times;</span>
>>>>>>>> 5b2aeccbb35cdd0885444b197adf91ca14a2d613:index.html
      <div id="newsModuleContent">
          <!-- Sample News Layout -->
      </div>
    </div>
<<<<<<<< HEAD:index.php
========

    <!-- chart Widget -->
    <div id="chartwidget">
      <span class="btn-close-widget">&times;</span>
      <div id="chartModuleContent">
          <!-- Sample News Layout -->
      </div>
    </div>
>>>>>>>> 5b2aeccbb35cdd0885444b197adf91ca14a2d613:index.html
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
<<<<<<<< HEAD:index.php
           
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

        // Close widgets when the close button is clicked
        $('.btn-close-widget2').click(function () {
            $('#newsWidget').fadeOut();
        });
        $('.btn-close-widget3').click(function () {
            $('#employerWidget').fadeOut();
        });
    });
</script>
========
           <script src="javascript/piechart.js"></script>
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
          $.ajax({
            url: 'chart.php',
            method: 'GET',
            success: function (response) {
                $('#chartModuleContent').html(response);
                $('#chartwidget').fadeIn(); // Display the chart widget on load

                // Initialize the pie chart after loading the content
                initializeChart(); // Call the chart initialization function
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error); // Log AJAX errors
            }
        });
          // Close widgets when the close button is clicked
          $('.btn-close-widget').click(function () {
              $(this).closest('.widget').fadeOut();
          });
      });
      </script>
>>>>>>>> 5b2aeccbb35cdd0885444b197adf91ca14a2d613:index.html


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
