<?php
include 'conn_db.php';
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'level' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
        header("Location: login_admin.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}

$admin = checkSession();
$sql = "SELECT * FROM job_postings WHERE admin_id = $admin";
$result = $conn->query($sql);

$pic_sql = "SELECT * FROM admin_profile WHERE id = ?";
$pic_stmt = $conn->prepare($pic_sql);
$pic_stmt->bind_param("i", $admin);
$pic_stmt->execute();
$pic_result = $pic_stmt->get_result();

if (!$pic_result) {
    die("Invalid query: " . $conn->error); 
}

$pic_row = $pic_result->fetch_assoc();
if (!$pic_row) {
    die("User not found.");
}
?>

<html lang="en">
<head>
    <title>Admin Post Job</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/modal-form.css"> 
    <link rel="stylesheet" href="../../css/nav_float.css">
    <link rel="stylesheet" href="../../css/admin_employer.css">
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
            <h1 class="h1">Admin Job Posting</h1>
        </header>

        <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon-admin" data-bs-toggle="popover" data-bs-placement="bottom">
            <?php if (!empty($pic_row['profile_picture'])): ?>
                <img id="preview" src="<?php echo $pic_row['profile_picture']; ?>" alt="Profile Image" class="circular--square">
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
                    <tr><td><a href="admin_home.php" class="nav-link">Home</a></td></tr>
                    <tr><td><a href="employer_list.php" class="active nav-link">Employer List</a></td></tr>
                    <tr><td><a href="course_list.php" class="nav-link">Course List</a></td></tr>
                    <tr><td><a href="ofw_case.php" class="nav-link">OFW Cases</a></td></tr>
                </table>
            </div>
        </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
        <div>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="admin_home.php" >Home</a></li>
            <li class="breadcrumb-item"><a href="employer_list.php" >Employer List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Post Job</li>
          </ol>
        </div>
        <a href="javascript:history.back()" class="return me-2">
          <i class="fas fa-reply"></i> Back
        </a>
      </nav>


      <div class="table-containers">
    <div class="d-flex align-items-start gap-2">
        <!-- Create Job Button -->
        <button class="btn btn-primary openCourseBtn" id="openCourseBtn">Create Job</button>
        
        <!-- Job Listings -->
        <div class="job-listings">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $spe = !empty($row['specialization']) ? $row['specialization'] : 'NONE';
                    ?>
                    <div class="row mb-3">
                        <div class="col-md-12"> <!-- Increased column width to make the card bigger -->
                            <div class="card custom-card p-4 shadow-sm"> <!-- Added custom-card class -->
                                <form action='update_jobs.php' method='post'>
                                    <input type='hidden' name='job_id' value='<?php echo $row['j_id']; ?>'>

                                    <div class="row align-items-center">
                                        <!-- Job Title (Disabled) -->
                                        <div class="col-md-4">
                                            <label for='jtitle_<?php echo $row['j_id']; ?>'><strong>Title</strong></label>
                                            <h5 class='card-title text-truncate' style='max-width: 300px;'><?php echo htmlspecialchars($row['job_title']); ?></h5>
                                        </div>

                                        <!-- Vacant Positions -->
                                        <div class="col-md-2">
                                            <label for='vacant_<?php echo $row['j_id']; ?>'><strong>Vacant</strong></label>
                                            <p class='card-text'><?php echo $row['vacant']; ?></p>
                                        </div>

                                        <!-- Job Status -->
                                        <div class="col-md-2">
                                            <label for='act_<?php echo $row['j_id']; ?>'><strong>Status</strong></label>
                                            <p class='card-text'><?php echo $row['is_active'] == 1 ? 'Active' : 'Inactive'; ?></p>
                                        </div>

                                        <!-- Actions -->
                                        <div class="col-md-4 text-center">
                                            <label class="text-center d-block"><strong>Actions</strong></label>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href='#' class='btn btn-success btn-sm' id='openUpdateBtn' data-job-id='<?php echo htmlspecialchars($row['j_id']); ?>'>Update</a>
                                                <a href='applicant_list.php?job_id=<?php echo $row['j_id']; ?>' class='btn btn-primary btn-sm'>Applicants</a>
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
                echo "<div class='text-center'>No Job found</div>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</div>




<!-- create job -->
    <div id="jobModal" class="modal modal-container-upload">
        <div class="modal-content">
            <span class="btn-close closBtn seccloseBtn">&times;</span>
            <h2>Upload Job Post</h2>
            <div id="uploadJobContent">
                <!-- Profile details will be dynamically loaded here -->
            </div>
        </div>
    </div>
<!-- update job -->
<div id="jobupdateModal" class="modal modal-container-upload">
        <div class="modal-content">
            <span class="btn-close closBtn thirdclosBtn">&times;</span>
            <h2>Update Job Post</h2>
            <div id="updatejobdetail">
                <!-- Profile details will be dynamically loaded here -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../../javascript/script.js"></script>
    <!-- You can link your JavaScript file here if needed -->
    <script>
            //create job
            const jobModal = document.getElementById('jobModal');
            const seccloseModuleBtn = document.querySelector('.seccloseBtn');
        
            // Open profile modal and load data via AJAX
            $(document).on('click', '#openCourseBtn', function(e) {
                e.preventDefault();

                
                $.ajax({
                    url: 'upload_job.php',
                    method: 'GET',
                    success: function(response) {
                        $('#uploadJobContent').html(response);
                        jobModal.style.display = 'flex';

                        // Call the function to initialize the select input
                        initializeDynamicSelect();
                    }
                });
            });

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
            seccloseModuleBtn.addEventListener('click', function() {
                jobModal.style.display = 'none';
            });
        
            // Close profile modal when clicking outside the modal content
            window.addEventListener('click', function(event) {
                if (event.target === jobModal) {
                    jobModal.style.display = 'none';
                }
            });
    </script>

    <script>
         //update job
            const jobupdateModal = document.getElementById('jobupdateModal');
            const thridcloseModuleBtn = document.querySelector('.thirdclosBtn');

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

                        initializeDynamic2Select();
                    }
                });
            });

            function initializeDynamic2Select() {
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
            thridcloseModuleBtn.addEventListener('click', function() {
                jobupdateModal.style.display = 'none';
            });

            // Close profile modal when clicking outside the modal content
            window.addEventListener('click', function(event) {
                if (event.target === jobupdateModal) {
                    jobupdateModal.style.display = 'none';
                }
            });

    </script>
</body>
</html>