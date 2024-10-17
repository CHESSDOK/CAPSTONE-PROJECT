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

  $sql = "SELECT * FROM applicant_profile WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $res = $stmt->get_result();
  
  if (!$res) {
      die("Invalid query: " . $conn->error); 
  }
  
  $row = $res->fetch_assoc();
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../../css/modal-form.css">
    <link rel="stylesheet" href="../../css/nav_float.css">
    <link rel="stylesheet" href="../../css/ofw_form.css">
    <style>
        #messageList {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
        }
        .message {
            margin: 5px 0;
        }
        .user-message {
            color: blue;
            text-align: left;
        }
        .admin-reply {
            color: green;
            text-align: left;
        }
    </style>
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
                    <tr><td><a href="about.php" class="nav-link">About Us</a></td></tr>
                    <tr><td><a href="contact.php" class="nav-link">Contact Us</a></td></tr>
                </table>
            </div>
        </div>
  </nav> 

  <nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="../../index(applicant).php" >Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">OFW Form</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

<div class="table-containers">
    <div class="button-container">
        <button class="btn btn-primary" id='openCaseBtn' data-ofw-id="<?php echo $userId; ?>" >File Case</button>
        <button class="btn btn-primary openStatusBtn" id='openStatusBtn' data-ofw-id="<?php echo $userId; ?>" >File status</button>
        <a class="btn btn-primary" href="ofw_profile.php">OFW Profile</a>
    </div>
    
        <div class="form-container">
          <table class="table table-hover">
              <thead>
                  <th class="text-center">Question</th>
                  <th class="text-center">Never</th>
                  <th class="text-center">Often</th>
                  <th class="text-center">Sometimes</th>
                  <th class="text-center">Always</th>
              </thead>

        <form action='../../php/applicant/survey_reponse.php' method='POST' onsubmit='submitSurvey()'>
            <?php
              $sql = "SELECT * FROM survey_form ORDER BY category";
              $result = $conn->query($sql);

              // Initialize variable to track the current category
              $current_category = '';

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Fetch the user's previous response for the current survey question
                    $survey_id = $row['id'];
                    $response_sql = "SELECT reponse FROM survey_reponse WHERE user_id = $userId AND survey_id = $survey_id";
                    $response_result = $conn->query($response_sql);
                    $previous_response = '';
                
                    // Get the previous response if it exists
                    if ($response_result->num_rows > 0) {
                        $response_row = $response_result->fetch_assoc();
                        $previous_response = $response_row['reponse'];
                    }
                
                    // Check if we are in a new category
                    if ($current_category != $row['category']) {
                        // If it's a new category, print it as a heading row
                        echo "<thead><th colspan='5'>" . $row['category'] . "</th></thead>";
                        // Update current category tracker
                        $current_category = $row['category'];
                    }
                
                    // Print the survey question with radio button options
                    echo "<tr>
                            <td style='width: 300px; text-align: justify;'>" . $row["question"] . "</td>
                            <input type='hidden' name='survey_ids[]' value='" . $row['id'] . "'>
                            <input type='hidden' name='user_id' value='" . $userId . "'>
                            <td>
                              <div class='form-check d-flex justify-content-center'>
                                <input class='form-check-input' type='radio' name='response" . $row['id'] . "' value='Never' " . ($previous_response == 'Never' ? 'checked' : '') . ">
                              </div>
                            </td>
                            <td>
                              <div class='form-check d-flex justify-content-center'>
                                <input class='form-check-input' type='radio' name='response" . $row['id'] . "' value='Often' " . ($previous_response == 'Often' ? 'checked' : '') . ">
                              </div>
                            </td>
                            <td>
                              <div class='form-check d-flex justify-content-center'>
                                <input class='form-check-input' type='radio' name='response" . $row['id'] . "' value='Sometimes' " . ($previous_response == 'Sometimes' ? 'checked' : '') . ">
                              </div>
                            </td>
                            <td>
                              <div class='form-check d-flex justify-content-center'>
                                <input class='form-check-input' type='radio' name='response" . $row['id'] . "' value='Always' " . ($previous_response == 'Always' ? 'checked' : '') . ">
                              </div>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No questions found</td></tr>";
            }
            ?>
            </table>
                  <input class="btn btn-primary" type="submit" value="Submit">
              </form>
          
          
        </div>
        <div class="chat-conainer">
      <a class="chat-admin" data-bs-toggle="offcanvas" data-bs-target="#chatOffcanvas">
        <i class="bi bi-chat-dots"></i> Admin Chat 
      </a>
  </div>
    </div>

<!-- admin chat -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="chatOffcanvas" aria-labelledby="chatOffcanvasLabel">
  <div class="offcanvas-header bg-primary text-white">
    <h5 class="offcanvas-title" id="chatOffcanvasLabel">Chat with Admin</h5>
    <button type="button" class="btn-close closBtn closeBtn" data-bs-dismiss="offcanvas" aria-label="Close">&times;</button>
  </div>

  <div class="offcanvas-body d-flex flex-column flex-grow-1">
    <h1 class="h4 mb-3">Your Messages</h1>
    <div id="messageList" class="flex-grow-1 overflow-auto mb-3" style="border: 1px solid #ccc; padding: 10px; border-radius: 5px; min-height: 0;">
    </div>
    
    <div class="input-group ">
      <input type="text" class="form-control" id="userMessage" placeholder="Type your message here..." aria-label="User's message">
      <button class="btn btn-primary" type="button" onclick="sendMessage()">Send Message</button>
    </div>
  </div>

  <script>
    const customerId = <?php echo json_encode($userId); ?>; // Replace with the actual customer ID from the session or authentication system

    // Function to format the timestamp dynamically
    function formatTimestamp(timestamp) {
        const messageDate = new Date(timestamp);
        const now = new Date();

        const timeDifference = now - messageDate; // Difference in milliseconds
        const oneDay = 24 * 60 * 60 * 1000; // 24 hours in milliseconds

        if (timeDifference < oneDay) {
            // If the message was sent within the last 24 hours, show time
            return messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        } else {
            // If the message was sent more than 24 hours ago, show date
            return messageDate.toLocaleDateString();
        }
    }

    function fetchMessages() {
        fetch(`../../php/applicant/get_messages.php?customer_id=${customerId}`)
            .then(response => response.json())
            .then(data => {
                const messageList = document.getElementById('messageList');
                messageList.innerHTML = ''; // Clear existing messages
                data.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'message p-2 mb-2 rounded';

                    // Check if the message is from the user or admin
                    if (msg.sender === 'user') {
                        // User's message
                        messageDiv.className += ' bg-none text-end';
                        messageDiv.innerHTML = `<strong>You:</strong> ${msg.message} <em class="text-muted">${formatTimestamp(msg.timestamp)}</em>`;
                    } else {
                        // Admin's reply
                        messageDiv.className += ' bg-primary text-white';
                        messageDiv.innerHTML = `<strong>Admin:</strong> ${msg.message} <em class="text-muted">${formatTimestamp(msg.timestamp)}</em>`;
                    }

                    messageList.appendChild(messageDiv);
                });
            });
    }

    function sendMessage() {
        const userMessage = document.getElementById('userMessage').value;

        if (userMessage) {
            fetch('../../php/applicant/send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `customer_id=${customerId}&message=${encodeURIComponent(userMessage)}`
            })
            .then(response => response.text())
            .then(() => {
                document.getElementById('userMessage').value = ''; // Clear input
                fetchMessages(); // Refresh messages
            });
        }
    }

    // Event listener to detect Enter key press and submit the message
    document.getElementById('userMessage').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent the default behavior (like line breaks in text areas)
            sendMessage(); // Trigger the message send function
        }
    });

    fetchMessages(); // Fetch messages on page load
  </script>
</div>

  <!-- case -->
<div id="caseModal" class="modal modal-container" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-4">
            <div class="modal-header">
                <span class="btn-close seccloseBtn"></span>
            </div>
            <h3>OFW File Case</h3>
            <div class="modal-body">
                <form action="../../php/applicant/submit_case.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="userid" id="ofwId">

                    <div class="form-group">
                        <label for="title">Case Title:</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Case Description:</label>
                        <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="file">Upload Supporting File:</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div><br>
                    
                        <div class="col text-left">
                            <button type="submit" class="btn btn-primary">Submit Case</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="statusModal" class="modal modal-container">
    <div class="modal-content">
    <div class="modal-header">
        <span class="btn-close thirdcloseBtn"></span>
    </div>
        <div id="statussModuleContent">
            <!-- Module content will be dynamically loaded here -->
        </div>
    </div>
</div>
  <script>
//file
      const modal = document.getElementById('caseModal');
      const openBtn = document.getElementById('openCaseBtn');
      const seccloseBtn = document.querySelector('.seccloseBtn');
      const ofwidField = document.getElementById('ofwId');
      

      // Open modal and set applicant_id in hidden field
      openBtn.addEventListener('click', function() {
        const ofwId = this.getAttribute('data-ofw-id');

        // Set the applicant ID in the hidden field
        ofwidField.value = ofwId;
        // Open the modal
        modal.style.display = 'flex';
      });

      // Close modal when 'x' is clicked
      seccloseBtn.addEventListener('click', function() {
        modal.style.display = 'none';
      });

      // Close modal when clicked outside of the modal content
      window.addEventListener('click', function(event) {
        if (event.target === modal) {
          modal.style.display = 'none';
        }
      });
const statusModal = document.getElementById('statusModal');
const closeModuleBtn = document.querySelector('.thirdcloseBtn');
// Open profile modal and load data via AJAX
        $(document).on('click', '.openStatusBtn', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'file_status.php',
                method: 'GET',
                success: function(response) {
                    $('#statussModuleContent').html(response);
                    statusModal.style.display = 'flex';
                }
            });
        });

        // Close profile modal when 'x' is clicked
        closeModuleBtn.addEventListener('click', function() {
            statusModal.style.display = 'none';
        });

        // Close profile modal when clicking outside the modal content
        window.addEventListener('click', function(event) {
            if (event.target === statusModal) {
                statusModal.style.display = 'none';
            }
        });
  </script>
  

<script>
  function submitSurvey() {
    alert('You have submitted a survey! Thank you!!');
  }
</script>
 
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
