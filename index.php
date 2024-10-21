<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<style>
        .news-embed {
            width: 100%;   /* Adjusts the iframe to 100% width of its parent container */
            max-width: 1200px; /* Max width in case you want a cap */
            height: 500px;  /* Control height here */
            border: 1px solid #ccc;
        }
    </style>
<body>

    <!-- Navigation -->

    <nav>
        <div class="logo">
            <img src="img/logo_peso.png" alt="Logo">
            <a href="#"> PESO-lb.ph</a>
        </div>
    
        <div class="profile-icons">
            <div class="notif-icon" data-bs-toggle="popover" data-bs-content="Notification" data-bs-placement="bottom">
                <img id="#" src="img/notif.png" alt="Profile Picture" class="rounded-circle">
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
    <!-- Body -->
    <iframe class="news-embed news-link" src="https://www.gmanetwork.com/news/" frameborder="0"></iframe>

   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
