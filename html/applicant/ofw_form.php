<?php
include '../../php/conn_db.php';
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
    <title>OFW Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../../css/nav_float.css">
    <link rel="stylesheet" href="../../css/ofw_form.css">
</head>
<body>
<!-- Navigation -->
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
        <h1 class="h1">File a Case</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
    <?php if (!empty($row['photo'])): ?>
        <img id="preview" src="../../php/applicant/images/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
    <?php else: ?>
        <img src="../../img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
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
                <tr><td><a href="../../index(applicant).php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="applicant.php" class="nav-link">Applicant</a></td></tr>
                <tr><td><a href="training_list.php" class="nav-link">Training</a></td></tr>
                <tr><td><a href="#" class="active nav-link">OFW</a></td></tr>
                <tr><td><a href="../../html/about.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="../../html/contact.php" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav> 

<nav class="bcrumb-container" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../../index(applicant).php" >Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">OFW Form</li>
  </ol>
</nav>



<!-- Offcanvas Component -->

<div class="form-container">
<table class="table table-borderless">
    <tr>
        <th class="text-center">Question</th>
        <th class="text-center">Never</th>
        <th class="text-center">Often</th>
        <th class="text-center">Sometimes</th>
        <th class="text-center">Always</th>
    </tr>

    <form action='../../php/applicant/survey_reponse.php' method='POST'>
<?php
    $sql = "SELECT * FROM survey_form";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Fetch the user's previous response for the current survey question
            $survey_id = $row['id'];
            $response_sql = "SELECT reponse FROM survey_reponse WHERE user_id = $userId AND survey_id = $survey_id";
            $response_result = $conn->query($response_sql);
            $previous_response = '';

            if ($response_result->num_rows > 0) {
                $response_row = $response_result->fetch_assoc();
                $previous_response = $response_row['reponse'];  // Get the previous response if it exists
            }

            echo "<tr'>
                    <td>". $row["question"] . "</td>
                      <input type='hidden' name='survey_ids[]' value='".$row['id']."'>
                      <input type='hidden' name='user_id' value='".$userId."'>
                    <td>
                      <div class='form-check d-flex justify-content-center'>
                        <input class='form-check-input' type='radio' name='response".$row['id']."' value='Never' " . ($previous_response == 'Never' ? 'checked' : '') . ">
                      </div>
                    </td>
                    <td >
                      <div class='form-check d-flex justify-content-center'>
                        <input class='form-check-input' type='radio' name='response".$row['id']."' value='Often' " . ($previous_response == 'Often' ? 'checked' : '') . ">
                      </div>
                    </td>
                    <td>
                      <div class='form-check d-flex justify-content-center'>
                        <input class='form-check-input' type='radio' name='response".$row['id']."' value='Sometimes' " . ($previous_response == 'Sometimes' ? 'checked' : '') . ">
                      </div></td>
                    <td>
                      <div class='form-check d-flex justify-content-center'>
                        <input class='form-check-input' type='radio' name='response".$row['id']."' value='Always' " . ($previous_response == 'Always' ? 'checked' : '') . ">
                      </div>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No questions found</td></tr>";
    }
?> 

<tr>      
    <td>
        <input class="btn btn-primary" type="submit" value="Submit">
    </td>
</tr>
    </form>
</table>
</div>

<!-- admin chat -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="chatOffcanvas" aria-labelledby="chatOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 id="chatOffcanvasLabel">Chat with Admin</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
           <?php
           $sql = "SELECT * FROM messages WHERE user_id = '$userId'";
           $result = $conn->query($sql);
           if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<h2>Message from " . $_SESSION['username'] . "</h2>";
                echo "<p>" . $row["message"] . "</p>";
        
                $reply_sql = "SELECT * FROM replies WHERE message_id = '" . $row["id"] . "'";
                $reply_result = $conn->query($reply_sql);
        
             if ($reply_result->num_rows > 0) {
               while($reply_row = $reply_result->fetch_assoc()) {
                     $admin_sql = "SELECT * FROM admin_profile WHERE id = '" . $reply_row["admin_id"] . "'";
                     $admin_result = $conn->query($admin_sql);
                     $admin_row = $admin_result->fetch_assoc();
                     echo "<h2>Reply from " . $admin_row["username"] . "</h2>";
                     echo "<p>" . $reply_row["reply"] . "</p>";
               }
             } else {
                    echo "<p>No replies found.</p>";
             }
             }
             } else {
                    echo "<p>No messages found.</p>";
             }
?>
<form action="../../php/applicant/send_message.php" method="post">
  <input type="hidden" name="user_id" value="<?php echo $userId ?>">
  <label for="message">Message:</label>
  <textarea id="message" name="message"></textarea><br><br>
  <input type="submit" value="Send Message">
</form>
</div>

<div class="chat-conainer">
  <a class="chat-admin" data-bs-toggle="offcanvas" data-bs-target="#chatOffcanvas">
    <i class="bi bi-chat-dots"></i> Chat with Admin
  </a>
</div>
  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../../javascript/script.js"></script> 
</body>
</html>
