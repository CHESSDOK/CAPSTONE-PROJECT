<?php
include '../php/conn_db.php';

function checkSession() {
   session_start(); // Start the session

   // Check if the session variable 'id' is set
   if (!isset($_SESSION['id'])) {
       // Redirect to login page if session not found
       header("Location: ../login.html");
       exit();
   } else {
       // If session exists, store the session data in a variable
       return $_SESSION['id'];
   }
}
$userId = checkSession();

//Fetch data from applicant_profile table
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
   die("User not found in applicant_profile.");
}

// Fetch data from register table using new approach
$sql_new = "SELECT * FROM register WHERE id = ?";
$stmt_new = $conn->prepare($sql_new);
$stmt_new->bind_param("i", $userId);
$stmt_new->execute();
$result_new = $stmt_new->get_result();

if ($result_new->num_rows > 0) {
    $row_new = $result_new->fetch_assoc(); // Fetch the data into a separate variable
} else {
    $row_new = array(); // If no data found, initialize as an empty array
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conctact Us Page</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">

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
      <h1 class="h1">Contact Us</h1>
  </header>

  <div class="profile-icons">
    <div class="notif-icon" data-bs-toggle="popover" data-bs-placement="bottom">
        <img src="../img/notif.png" alt="Profile Picture" class="rounded-circle">
    </div>
        
    <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
      <?php if (!empty($row['photo'])): ?>
          <img id="preview" src="../php/applicant/images/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
      <?php else: ?>
          <img src="../img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
      <?php endif; ?>
    </div>
  </div>

  <div class="burger" id="burgerToggle">
      <span></span>
      <span></span>
      <span></span>
  </div>

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
              <tr><td><a href="about.php" class="nav-link">About Us</a></td></tr>
              <tr><td><a href="#" class="active nav-link">Contact Us</a></td></tr>
          </table>
      </div>
  </div>
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
          
          <button type="submit">Submit</button>
      </form>
  </div>
  </section>
    
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script src="../javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->
</body>
</html>
