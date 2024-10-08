<?php
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['level'])) {
        // Redirect to login page if session not found
        header("Location: login_admin.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['level'];
    }
}

$admin_level = checkSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/register.css">
  <link rel="stylesheet" href="../../css/nav.css">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/modal-form.css">
</head>
<body>
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon" data-bs-toggle="popover" data-bs-placement="bottom">
    <?php if (!empty($row['photo'])): ?>
        <img id="preview" src="php/applicant/images/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
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
                <tr><td><a href="admin_home.php" class="active nav-link">Home</a></td></tr>
                <tr><td><a href="create_job.php" class="nav-link">Post Job</a></td></tr>
                <tr><td><a href="employer_list.php" class="nav-link">Employer List</a></td></tr>
                <tr><td><a href="course_list.php" class="nav-link">Course List</a></td></tr>
                <tr><td><a href="ofw_case.php" class="nav-link">OFW Cases</a></td></tr>
                <tr><td><a href="user_master_list.php" class="nav-link">User List</a></td></tr>
            </table>
        </div>
    </div>
</nav>
<?php 
if ($admin_level === "super_admin"){
    echo "<button class='btn btn-primary' id='openCourseBtn'>Create accoount</button>";
}else { echo "";}
?>

    <div id="courseModal" class="modal modal-container">
        <div class="modal-content">
            <span class="btn-close closBtn closeBtn"></span>
                    <table>
                <tr>
                    <td>
                        <p class="title">Admin Account</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="logol">
                            <img src="../../img/logo_peso.png" alt="Logo">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="subtitle">Signup now and get access to our job portal.</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <form class="form" action="register_admin.php" method="POST" id="registrationForm">
                            <div class="input-group">
                                <input required type="email" class="input" name="email" id="emailInput" placeholder="Email">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="input-group">
                            <input required type="text" class="input" name="username" placeholder="Username">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="input-group">
                            <input required type="password" class="input" name="password" minlength="8" maxlength="16" id="passwordInput" placeholder="Password">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="input-group">
                        <select class="form-select" id="admin_role" name="admin_role" required>
                            <option value="super_admin">Super Admin</option>
                            <option value="admin">Admin</option>
                        </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="btn btn-primary sign" type="submit">Submit</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="signup">Already have an account? <a href="login_admin.html">Signin</a></p>
                        </form>
                    </td>
                </tr>
            <tr>
                <td>
                </p>
                </td>
            </tr>
            </table>
        </div>
    </div>

    <script src="../javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            const password = document.getElementById('passwordInput').value;
            const email = document.getElementById('emailInput').value;

            // Define the patterns for required conditions
            const hasUpperCase = /[A-Z]/.test(password); // Must have at least one uppercase letter
            const hasLowerCase = /[a-z]/.test(password); // Must have at least one lowercase letter
            const hasDigit = /\d/.test(password);        // Must have at least one digit
            const hasSpecialChar = /[\W_]/.test(password); // Special character is optional
            
            // Email regex for validation
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                event.preventDefault(); // Prevent form submission
                alert('Please enter a valid email address.');
                return;
            }

            // Ensure all required conditions are met (uppercase, lowercase, digit)
            if (!hasUpperCase || !hasLowerCase || !hasDigit) {
                event.preventDefault(); // Prevent form submission
                alert('Password must contain at least one uppercase letter, one lowercase letter, and one digit.');
            }
        });

        const modal = document.getElementById('courseModal');
        const openBtn = document.getElementById('openCourseBtn');
        const closeBtn = document.querySelector('.closeBtn');

        // Open modal and set applicant_id in hidden field
        openBtn.addEventListener('click', function() {

        // Open the modal
        modal.style.display = 'flex';
        });

        // Close modal when 'x' is clicked
        closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        });

        // Close modal when clicked outside of the modal content
        window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->
</body>
</html>
