<?php
include '../../php/conn_db.php';
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
    checkSession();    header("Location: ../../html/employer/employer_login.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}
$employerid = checkSession();
$new_sql = "SELECT * FROM employer_profile WHERE user_id = ?";
$new_stmt = $conn->prepare($new_sql);
$new_stmt->bind_param("i", $employerid);
$new_stmt->execute();
$new_result = $new_stmt->get_result();

if (!$new_result) {
    die("Invalid query: " . $conn->error);
}

$new_row = $new_result->fetch_assoc();
if (!$new_row) {
    die("User not found.");
}

$sql = "SELECT * FROM job_postings WHERE employer_id = $employerid ";
$result = $conn->query($sql);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../../css/modal-form.css"> 
  <link rel="stylesheet" href="../../css/nav_float.css">
  <link rel="stylesheet" href="../../css/employer.css">
  <style>
        #newOptionContainer {
            display: none; /* Initially hide the input field */
            margin-top: 10px;
        }
        #selectedOptionsContainer {
            margin-top: 20px;
        }
        #selectedOptionsList li {
            cursor: pointer;
        }
  </style>
</head>
<body>

<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
        <h1 class="h1">Job Posted</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon-employer" data-bs-toggle="popover" data-bs-placement="bottom">
        <?php if (!empty($new_row['photo'])): ?>
        <img id="preview" src="../../php/employer/uploads/<?php echo $new_row['photo']; ?>" alt="Profile Image" class="circular--square">
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
                <tr><td><a href="../../html/employer/employer_home.php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="../../html/employer/job_creat.php" class="nav-link">Post Job</a></td></tr>
                <tr><td><a href="#" class="active nav-link">Job List</a></td></tr>
                <tr><td><a href="../../html/about.php" class="nav-link">About Us</a></td></tr>
                <tr><td><a href="../../html/contact.php" class="nav-link">Contact Us</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="../../html/employer/employer_home.php" >Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Job List</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

<div class="table-containers">
<div class="container mt-4">

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <!-- Card for each job -->
            <div class="row justify-content-center mb-3">
                <div class="col-md-8"> <!-- Adjusted the column width to make the card smaller -->
                    <div class="card p-3 shadow-sm">
                        <form action='../../php/employer/update_jobs.php' method='post'>
                            <input type='hidden' name='job_id' value='<?php echo $row['j_id']; ?>'>

                            <div class="row align-items-center">
                                <!-- Job Title (Disabled) -->
                                <div class="col-md-3">
                                    <label for='jtitle_<?php echo $row['j_id']; ?>'><strong>Title</strong></label>
                                    <input type='text' id='jtitle_<?php echo $row['j_id']; ?>' class='form-control mb-2' name='jtitle' value='<?php echo htmlspecialchars($row['job_title']); ?>' disabled>
                                </div>

                                <!-- Vacant Positions -->
                                <div class="col-md-2">
                                    <label for='vacant_<?php echo $row['j_id']; ?>'><strong>Vacant</strong></label>
                                    <input type='number' id='vacant_<?php echo $row['j_id']; ?>' class='form-control mb-2' name='vacant' value='<?php echo $row['vacant']; ?>' disabled>
                                </div>

                                <!-- Job Status -->
                                <div class="col-md-2">
                                    <label for='act_<?php echo $row['j_id']; ?>'><strong>Status</strong></label>
                                    <input type='number' id='act_<?php echo $row['j_id']; ?>' class='form-control mb-2' name='act' value='<?php echo $row['is_active']; ?>' disabled>
                                </div>

                                <!-- Actions -->
                                <div class="col-md-5">
                                    <label><strong>Actions</strong></label>
                                    <div class="d-flex gap-3">
                                        <a href='#' class='btn btn-success openUpdateBtn' id='openUpdateBtn' data-job-id='<?php echo $row["j_id"]; ?>'>Update</a>
                                        <a href='applicant_list.php?job_id=<?php echo $row['j_id']; ?>' class='btn btn-primary'>Applicants</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<div class='alert alert-warning'>No employers found</div>";
    }

    $conn->close();
    ?>
</div>
</div>


<!-- update job -->
<div id="jobupdateModal" class="modal modal-container-upload">
        <div class="modal-content">
            <span class="closBtn closeBtn btn-close thirdclosBtn">&times;</span>
            <h2>Update Job Post</h2>
            <div id="updatejobdetail">
                <!-- Profile details will be dynamically loaded here -->
            </div>
        </div>
    </div>
    <script>
// Update job
        const jobupdateModal = document.getElementById('jobupdateModal');
        const thirdcloseModuleBtn = document.querySelector('.thirdclosBtn');

        // Open profile modal and load data via AJAX
        $(document).on('click', '#openUpdateBtn', function(e) {
            e.preventDefault();
            const jobId = $(this).data('job-id');
            
            $.ajax({
                url: 'job_details.php',
                method: 'GET',
                data: { job_id: jobId },
                success: function(response) {
                    $('#updatejobdetail').html(response);
                    jobupdateModal.style.display = 'flex';
                    
                    // Call the function to initialize the select input
                    initializeDynamicSelect();
                }
            });
        });

        // Function to initialize dynamic select input and its event listeners
        function initializeDynamicSelect() {
            const selectElement = document.getElementById('dynamicSelect');
            const newOptionInput = document.getElementById('newOption');
            const addButton = document.getElementById('addButton');
            const newOptionContainer = document.getElementById('newOptionContainer');
            const selectedOptionsList = document.getElementById('selectedOptionsList');
            const form = document.getElementById('optionsForm');
            const selectedOptionsHidden = document.getElementById('selectedOptionsHidden');

            let selectedOptions = new Set(); // Use a Set to store unique selected options

            function updateSelectedOptions() {
                selectedOptionsList.innerHTML = ''; // Clear the current list
                selectedOptions.forEach(optionValue => {
                    const listItem = document.createElement('li');
                    listItem.textContent = optionValue;
                    listItem.addEventListener('click', function() {
                        removeOption(optionValue); // Allow removing option on click
                    });
                    selectedOptionsList.appendChild(listItem);
                });
                updateHiddenField();
            }

            function removeOption(optionValue) {
                selectedOptions.delete(optionValue); // Remove from set
                updateSelectedOptions(); // Update display
            }

            function toggleOption(optionValue) {
                if (selectedOptions.has(optionValue)) {
                    removeOption(optionValue); // If already selected, remove it
                } else {
                    selectedOptions.add(optionValue); // If not selected, add it
                }
                updateSelectedOptions(); // Update display
            }

            selectElement.addEventListener('change', function() {
                const selectedValue = selectElement.value;
                if (selectedValue === 'add') {
                    newOptionContainer.style.display = 'block';
                    newOptionInput.focus(); // Focus on the input field
                } else {
                    newOptionContainer.style.display = 'none';
                    toggleOption(selectedValue); // Toggle the selection state of the option
                    selectElement.value = ''; // Reset the select value
                }
            });

            addButton.addEventListener('click', function() {
                const newOptionValue = newOptionInput.value.trim();
                if (newOptionValue) {
                    const newOption = document.createElement('option');
                    newOption.value = newOptionValue;
                    newOption.textContent = newOptionValue;
                    selectElement.appendChild(newOption);
                    toggleOption(newOptionValue);
                    selectElement.value = ''; // Reset the select value
                    newOptionInput.value = '';
                    newOptionContainer.style.display = 'none';
                    updateSelectedOptions();
                } else {
                    alert('Please enter a valid option.');
                }
            });

            function updateHiddenField() {
                selectedOptionsHidden.value = Array.from(selectedOptions).join(','); // Convert Set to comma-separated string
            }

            form.addEventListener('submit', function(event) {
                updateHiddenField(); // Update the hidden field before submission
            });
        }

        // Close profile modal when 'x' is clicked
        thirdcloseModuleBtn.addEventListener('click', function() {
            jobupdateModal.style.display = 'none';
        });

        // Close profile modal when clicking outside the modal content
        window.addEventListener('click', function(event) {
            if (event.target === jobupdateModal) {
                jobupdateModal.style.display = 'none';
            }
        });
    </script>

   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
   <script src="../../javascript/script.js"></script> <!-- You can link your JavaScript file here if needed -->
</body>
</html>