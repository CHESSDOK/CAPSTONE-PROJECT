<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conctact Us Page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
  <link rel="stylesheet" href="../css/contact.css">
  <link rel="stylesheet" href="../css/nav_float.css">   
</head>
<style>
body::before{
    background-image:none;
    background-color:#EBEEF1;
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
                <tr><td><a href="about.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="contact.php" class="active nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
        <div>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="../index.html" >Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a>Contact US</a></li>
          </ol>
        </div>
        <a href="javascript:history.back()" class="return me-2">
          <i class="fas fa-reply"></i> Back
        </a>
    </nav>


    <!-- Body -->
<!-- Address Section -->
<section class="address-section">
  <div class="address-container">
    <h2><img src="../img/address.png" alt="address Logo"> Address</h2>
    <p>56HC+JRX, Los Baños, Laguna</p>
  </div>
  <iframe class="map" 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3868.2675574829345!2d121.21954777509826!3d14.179101086258884!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd60dea78fb355%3A0x6375301b90332e37!2sPESO%20OFFICE!5e0!3m2!1sen!2sph!4v1715908808800!5m2!1sen!2sph" 
    width="600" 
    height="450" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy">
  </iframe>
</section> 
 <!-- Phone Number Section -->
 <section class="phone-section">
  <div class="phone-container">
    <h2><img src="../img/contact.png" alt="Phone Logo"> Phone Number</h2>
    <p>(049) 536 5976</p>
  </div>
</section>
<!-- Email Section -->
<section class="email-section">
    <div class="email-container">
      <h2><img src="../img/email.png" alt="Email Logo"> Email Address</h2>
      <p> pesolosbanos@yahoo.com.ph</p>
      <h2>Message Us!</h2>
    </div>
    <div class="contact-form">
      <form action="../php/contact_form.php" method="post">
          <label for="name">Your name</label>
          <input type="text" id="name" name="name" required>
          
          <label for="email">Your email</label>
          <input type="email" id="email" name="email" required>
          
          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" required>
          
          <label for="message">Your message (optional)</label>
          <textarea id="message" name="message" rows="4"></textarea>
          
          <button class="btn btn-primary" type="submit">Submit</button>
      </form>
  </div>
  </section>
    
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- You can link your JavaScript file here if needed -->

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
